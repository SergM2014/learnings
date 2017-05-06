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

        return fetch('/index/getLanguageComponents', {
            'method': 'POST',
            'credentials': 'same-origin'
        })
            .then(response => response.json());


    }
}

/**
 * returns ajax request according to current language on site
 *
 * @param givenUrl
 * @param formData
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
        PopUpMenu.deleteMenu();

        this.popUp = document.createElement('div');
        this.popUp.className = "popup-menu";
        this.popUp.id = "popupMenu";

        document.body.insertBefore(this.popUp, document.body.firstChild);

        if(this.x+x >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-x);
        if(this.y+y >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-y);

        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popupMenu')){document.getElementById('popupMenu').remove();}
    }


    /**
     * create popup Menu with givven parameters
     *
     * id-> key data that should be transmitted
     * popUpContr ->Controller that is responsibele for out put of menu
     * processContr->controller that is put in outputed menu
     *
     * @param id
     * @param popUpContr
     * @param processContr
     */

    fillUpMenuContent(id, popUpContr, processContr){
       this.drawMenu();

        let formData = new FormData;
        formData.append('id', id);
        formData.append('processContr', processContr);

        postAjax(popUpContr,formData)
            .then(response => response.text())
            .then(html =>document.getElementById('popupMenu').innerHTML= html);
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

    if(e.target.closest('.table__row')){
        let lessonId = e.target.closest('.table__row').dataset.lessonId;

        new PopUpMenu(e).fillUpMenuContent(lessonId, '/admin/popUp/lesson', 'admin/lesson');

    }

    if(e.target.classList.contains('admin-section')) {

        let serieId = e.target.closest('li').dataset.serieId;
        let categoryId = e.target.closest('[data-category-serie-id]').dataset.categorySerieId;
//console.log(serieId, categoryId)

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


    //close deleteLesson modal window
    if(e.target.id === "closeWindowBtn" || e.target.id === "closeWindowSign"){
        document.getElementById('modalBackground').remove();
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




});


let categoryId = document.getElementById('categoryField')? document.getElementById('categoryField').value: null;
let serieId = document.getElementById('serieField')? document.getElementById('serieField').value: null;


if(serieId) {
    document.getElementById('serieList').querySelector(`[data-serie-id="${serieId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
} else if(categoryId) {
    document.getElementById('serieList').querySelector(`[data-category-id="${categoryId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
}

document.getElementsByClassName('content')[0].addEventListener('click', function(e){

});




