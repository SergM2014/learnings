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
        this.popUp.id = "popup-menu";

        document.body.insertBefore(this.popUp, document.body.firstChild);

        if(this.x+x >this.screenWidth+pageXOffset) this.x= (this.screenWidth+pageXOffset-x);
        if(this.y+y >this.screenHeight+pageYOffset) this.y= (this.screenHeight+pageYOffset-y);

        this.popUp.style.left = this.x+"px";
        this.popUp.style.top = this.y+"px";
    }

    static deleteMenu()
    {
        if(document.getElementById('popup-menu')){document.getElementById('popup-menu').remove();}
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
            .then(html =>document.getElementById('popup-menu').innerHTML= html);
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




document.body.addEventListener('click', function (e) {

    if(e.target.closest('.table__row')){
        let lessonId = e.target.closest('.table__row').dataset.lessonId;

        new PopUpMenu(e).fillUpMenuContent(lessonId, '/admin/popUp/lesson', 'admin/lesson');

    }



    if(e.target.closest('[data-category-id]')){

        let elem = e.target;
        let categoryId = elem.closest('[data-category-id]').dataset.categoryId;
        let serieId = elem.closest('[data-serie-id')? elem.closest('[data-serie-id]').dataset.serieId: null;


       let selected = document.getElementById('serieList').querySelectorAll('.tree-branch--selected');

           for(let i = 0; i < selected.length; i++){
              selected[i].classList.remove('tree-branch--selected')
           }

         elem.closest('.tree-branch').classList.add('tree-branch--selected');

        document.getElementById('categoryField').value = categoryId;

        document.getElementById('serieField').value = serieId;


    }



if(e.target.id == "popUpAdminDeleteLesson"){
console.log(111)

      Modal.createModalWindow('/admin/popUp/drawDeleteLessonModal')
}




});


let categoryId = document.getElementById('categoryField')? document.getElementById('categoryField').value: null;
let serieId = document.getElementById('serieField')? document.getElementById('serieField').value: null;


if(serieId) {
    document.getElementById('serieList').querySelector(`[data-serie-id="${serieId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
} else if(categoryId) {
    document.getElementById('serieList').querySelector(`[data-category-id="${categoryId}"`).querySelector('.tree-branch').classList.add('tree-branch--selected')
}




