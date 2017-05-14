let languageCached;
let popupMenuSaved;
Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};


class LanguageHelper {

    static getCurrentLang(languagesSettings) {

        let url = window.location.href;
        let urlArray = url.split('/');
        let intersection = urlArray.intersect(languagesSettings.languagesArray);

        let lang = intersection.shift();
        return (lang) ? lang : languagesSettings.defaultLanguage;
    }


    /**
     * getLanguagesSettings
     *
     * @returns {Promise.<TResult>}
     */
    static getLanguagesSettings() {

        if(languageCached) return languageCached;

        return fetch('/index/getLanguageComponents', {
            'method': 'POST',
            'credentials': 'same-origin'
        })
            .then(response => { languageCached =  response.json(); return languageCached; });


    }
}

/**
 * wraper for ajax request based on fetch
 *
 * @param givenUrl
 * @param formData
 * @param cache
 * @returns {Promise.<TResult>}
 */
function postAjax(givenUrl, formData){

   /* if(!formData)
        let formData = new FormData;


    formData.append('ajax', true );*/


    let queryResult =   LanguageHelper.getLanguagesSettings()
        .then(languagesSettings => {

            let url = "/" + LanguageHelper.getCurrentLang(languagesSettings) + givenUrl;

            return   fetch(
                url, {
                    method: 'POST',
                    credentials: 'same-origin',
                    body: formData

                })
        });

    return queryResult;

}

function hideAlert(){
    document.getElementById('alertZone').classList.add('hidden');
    document.getElementById('alertZoneText').innerText = '';
}

function showAlert(message){
    document.getElementById('alertZone').classList.remove('hidden');
    document.getElementById('alertZoneText').innerText = message;
}



class PopUpMenu{
    constructor(e){
        this.x = e.pageX;
        this.y = e.pageY;

        this.screenWidth = document.body.clientWidth;
        this.screenHeight = document.body.clientHeight;
        this.target = e.target;
    }


    drawMenu(x = 100, y = 60){

        if(popupMenuSaved && document.getElementById('popupMenu')){
            this.popUp = document.getElementById('popupMenu');
            this.popUp.classList.remove('hidden')
        } else {

            this.popUp = document.createElement('div');
            this.popUp.className = "popup-menu";
            this.popUp.id = "popupMenu";

            document.body.insertBefore(this.popUp, document.body.firstChild);
        }



        if(this.x+x >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-x);
        if(this.y+y >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-y);

        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popupMenu')){document.getElementById('popupMenu').remove();}
    }


    fillUpMenuContent(id, popUpContr, processContr){
       this.drawMenu();


        let formData = new FormData;
        formData.append('id', id);
        formData.append('processContr', processContr);

        postAjax(popUpContr,formData)
            .then(response => { popupMenuSaved = true; return response.text(); })
            .then(html =>document.getElementById('popupMenu').innerHTML= html);
    }

    static hideMenu()
    {
        if(document.getElementById('popupMenu')){
            document.getElementById('popupMenu').classList.add('hidden');


        }
    }


}

class Modal {
    static createBackground() {
        let background = document.createElement('div');
        background.className = "modal-background";
        background.id = "modalBackground";
        document.body.insertBefore(background, document.body.firstChild);
    }

    static createModalWindow(controller, formData){
        this.createBackground();
        postAjax(controller,formData)
             .then(response => response.text())
            .then(html =>document.getElementById('modalBackground').insertAdjacentHTML('afterBegin', html));
    }


}


//close alert window
document.getElementById('closeAlert').addEventListener('click', function(){
  hideAlert();
});


document.body.addEventListener('click', function (e) {



    if(e.target.closest('.lesson-row')){
        let lessonId = e.target.closest('.table__row').dataset.lessonId;

        new PopUpMenu(e).fillUpMenuContent(lessonId, '/admin/popUp/lesson', 'admin/lesson');

    }

    if(e.target.closest('.testimonial-row')) {
        let testimonialId = e.target.closest('.table__row').dataset.testimonialId;

              new PopUpMenu(e).fillUpMenuContent(testimonialId, '/admin/popUp/testimonial', 'admin/testimonial');

          }

    if(e.target.closest('.comment-row')) {
        let commentId = e.target.closest('.table__row').dataset.commentId;

        new PopUpMenu(e).fillUpMenuContent(commentId, '/admin/popUp/comment', 'admin/comment');

    }






    if(e.target.classList.contains('admin-section')) {

        let serieId = e.target.closest('li').dataset.serieId;
        let categoryId = e.target.closest('[data-category-serie-id]').dataset.categorySerieId;

        if(serieId){
            new PopUpMenu(e).fillUpMenuContent(serieId, '/admin/popUp/serie', 'admin/cluster');
        } else {
            new PopUpMenu(e).fillUpMenuContent(categoryId, '/admin/popUp/category', 'admin/cluster');
        }
    }


    if(e.target.closest('[data-category-id]')){

        let elem = e.target;
        let categoryId = elem.closest('[data-category-id]').dataset.categoryId;
        let serieId = elem.closest('[data-serie-id')? elem.closest('[data-serie-id]').dataset.serieId: null;


        elem.closest('.tree-branch').classList.add('tree-branch--selected');


       let selected = document.getElementById('serieList').querySelectorAll('.tree-branch--selected');

           for(let i = 0; i < selected.length; i++){
              selected[i].classList.remove('tree-branch--selected')
           }



        document.getElementById('categoryField').value = categoryId;

        document.getElementById('serieField').value = serieId;


    }



    if(e.target.id === "popUpAdminDeleteLesson"){

          Modal.createModalWindow('/admin/popUp/drawDeleteLessonModal')
    }

    if(e.target.id === "popUpAdminDeleteSerie"){

        Modal.createModalWindow('/admin/popUp/drawDeleteSerieModal')
    }

    if(e.target.id === "popUpAdminDeleteCategory"){

        Modal.createModalWindow('/admin/popUp/drawDeleteCategoryModal')
    }

    if(e.target.id === "popUpAdminPublishTestimonial"){

        let formData = new FormData(document.getElementById('publishTestimonial'));

        postAjax('/admin/testimonial/publish', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {

                    document.getElementById('popupMenu').remove();
                  let selector = document.querySelector(`[data-testimonial-id="${j.testimonialId}"]`).querySelector('.publish-status');
                  selector.classList.remove('red');
                  selector.classList.add('green');
                  selector.innerText= j.response;

                    showAlert(j.message)
                }


            })
    }

    if(e.target.id === "popUpAdminUnpublishTestimonial"){

        let formData = new FormData(document.getElementById('unpublishTestimonial'));

        postAjax('/admin/testimonial/unpublish', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {

                    document.getElementById('popupMenu').remove();
                    let selector = document.querySelector(`[data-testimonial-id="${j.testimonialId}"]`).querySelector('.publish-status');
                    selector.classList.remove('green');
                    selector.classList.add('red');
                    selector.innerText= j.response;

                    showAlert(j.message)
                }


            })
    }


    if(e.target.id === "popUpAdminPublishComment"){

        let formData = new FormData(document.getElementById('publishComment'));

        postAjax('/admin/comment/publish', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {
                    document.getElementById('popupMenu').remove();
                    let selector = document.querySelector(`[data-comment-id="${j.commentId}"]`).querySelector('.publish-status');
                    selector.classList.remove('red');
                    selector.classList.add('green');
                    selector.innerText= j.response;

                    showAlert(j.message)
                }
            })
    }


    if(e.target.id === "popUpAdminUnpublishComment"){

        let formData = new FormData(document.getElementById('unpublishComment'));

        postAjax('/admin/comment/unpublish', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {

                    document.getElementById('popupMenu').remove();
                    let selector = document.querySelector(`[data-comment-id="${j.commentId}"]`).querySelector('.publish-status');
                    selector.classList.remove('green');
                    selector.classList.add('red');
                    selector.innerText= j.response;

                    showAlert(j.message)
                }


            })
    }



    //close deleteLesson modal window
    if(e.target.id === "closeWindowBtn" || e.target.id === "closeWindowSign"){
        document.getElementById('modalBackground').remove();
        document.getElementById('popupMenu').remove();
    }


    if(e.target.id === "confirmDeleteLessonBtn"){


        let formData = new FormData(document.getElementById('deleteLesson'));

        postAjax('/admin/lesson/delete', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {
                    document.getElementById('modalBackground').remove();
                    document.getElementById('popupMenu').remove();
                    document.querySelector(`[data-lesson-id="${j.lessonId}"]`).remove();

                   showAlert(j.message)
                }
            })
    }

    if(e.target.id === "confirmDeleteSerieBtn"){


        let formData = new FormData(document.getElementById('deleteSerie'));

        postAjax('/admin/cluster/deleteSerie', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {
                    document.getElementById('modalBackground').remove();
                    document.getElementById('popupMenu').remove();
                    document.querySelector(`[data-serie-id="${j.serieId}"]`).remove();

                    showAlert(j.message)
                }

                if(j.fail){
                    //here we print if something went wrong
                    document.getElementById('modalWindowText').classList.remove('hidden');
                    document.getElementById('modalWindowText').innerText = j.message;
                }
            })
    }


    if(e.target.id === "confirmDeleteCategoryBtn"){


        let formData = new FormData(document.getElementById('deleteCategory'));

        postAjax('/admin/cluster/deleteCategory', formData)
            .then(response => response.json() )
            .then(j => {
                if(j.success) {
                    document.getElementById('modalBackground').remove();
                    document.getElementById('popupMenu').remove();
                    document.querySelector(`[data-category-serie-id="${j.categoryId}"]`).remove();

                    showAlert(j.message)
                }

                if(j.fail){
                    //here we print if something went wrong
                    document.getElementById('modalWindowText').classList.remove('hidden');
                    document.getElementById('modalWindowText').innerText = j.message;
                }
            })
    }




});


document.getElementsByClassName('container')[0].addEventListener('click', function (e) {
    if( document.getElementById('popupMenu')){

      PopUpMenu.hideMenu();
     }
     if(!document.getElementById('alertZone').classList.contains('hidden')){
         document.getElementById('alertZone').classList.add('hidden');
     }
});


let categoryId = document.getElementById('categoryField')? document.getElementById('categoryField').value: null;
let serieId = document.getElementById('serieField')? document.getElementById('serieField').value: null;


if(serieId) {
    document.getElementById('serieList').querySelector(`[data-serie-id="${serieId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
} else if(categoryId) {
    document.getElementById('serieList').querySelector(`[data-category-id="${categoryId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
}






