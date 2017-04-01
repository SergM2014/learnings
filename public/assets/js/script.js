Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};


let languagesBox = document.getElementsByClassName('main-header__language-select')[0];


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

       if(!formData){
           let formData = new FormData;
           formData.append('ajax', true );
       }

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







//toggle languages in the header
languagesBox.addEventListener('click', function(){
    document.getElementsByClassName('main-header__language-select-dropdown')[0].classList.toggle('hidden')
});



document.body.addEventListener('click', function(e){

//catch the refresh captcha event
    if(e.target.id == "captchaImg") {
        fetch(
            '/index/refreshCaptcha', {
                method: 'POST',
                credentials: 'same-origin'
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#captchaImgContainer').innerHTML = html;
            })
    }

//click add comment button
    if(e.target.id == "addCommentSubmitBtn"){

        let formData = new FormData(document.getElementById('addCommentForm'));

        postAjax("/comment/store", formData)

            .then(response =>response.text())
            .then(html => {
                document.querySelector('#commentFormContainer').innerHTML = html;
            })
    }

//shoose  comment  to answer
    if(e.target.closest('.lesson-comments__response-link-btn')){

        let commentId = e.target.dataset.commentId;
        let lessonId = document.getElementById('lessonId').value;

        let formData = new FormData(document.getElementById('addCommentForm'));
        formData.append('commentId', commentId );
        formData.append('lessonId', lessonId);


        postAjax('/comment/showForm')
            .then(response =>response.text())
            .then(html => {
                document.getElementById('commentFormContainer').innerHTML = html;
                document.querySelector('#commentParentId').value = commentId;
                document.getElementById('lessonId').value = lessonId;


                postAjax('/comment/getOneForResponse', formData)
                    .then(response => response.text())
                    .then(html => {
                        document.querySelector('#addCommentHead').innerHTML = html;
                    })
            })



    }



//click add testimonial btn
    if(e.target.id == "addTestimonialSubmitBtn"){

        let formData = new FormData(document.getElementById('addTestimonialForm'));

        postAjax('/index/storeTestimonial', formData)
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#TestimonialFormContainer').innerHTML = html;
            })

    }

//click outside result search container to hide it
    if(!e.target.closest("#searchResultsContainer")){
        if(document.getElementById('searchResultsContainer')) document.getElementById('searchResultsContainer').className = "search-results-container--hidden";
    }


//clicking the results in results search container
    if(e.target.className == "search-results__founded"){

        let lessonId = e.target.dataset.lessonId;
        let formData = new FormData;
        formData.append('lessonId', lessonId);
        postAjax('/lesson/preview', formData)
            .then(response =>response.text())
            .then( html =>{
                document.getElementById('searchResultsContainer').className = "search-results-container--hidden";

                let modalBackgound = document.createElement('div');
                modalBackgound.id = "modalBackground";
                modalBackgound.className = "modal-background";

                document.body.insertBefore(modalBackgound, document.body.firstChild);

                let modalBody = document.createElement('div');
                modalBody.id = 'modalBody';
                modalBody.className = "modal-body";
                modalBackgound.appendChild(modalBody);
                modalBody.innerHTML = html;
            });

    }



//this is the clos sign section

    //close the choseen comment that should be closed
    if(e.target.id == 'lessonCommentCloseSign'){
        fetch(
            '/comment/resetHeader', {
                method: 'POST',
                credentials: 'same-origin',
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#addCommentHead').innerHTML = html;
                document.querySelector('#commentParentId').value  = 0;
            })
    }



    if(e.target.id == "previewLessonCloseSign" || e.target.id == "previewLessonCloseBtn"){
        document.getElementById('modalBackground').remove();
    }

    if(!e.target.closest('#mainHeaderTouchBtn')){
       let menu = document.getElementById('mainHeaderMenu');
       if(menu){if(menu.classList.contains('show-menu')) menu.classList.remove('show-menu')}
    }



});//ends of events hanged on the body


document.getElementById('search').addEventListener('keyup', function(e) {

    let existingSearchResultsCont = document.getElementById('searchResultsContainer');

    if (existingSearchResultsCont) {
        existingSearchResultsCont.innerHTML='';
    }

    let searchField = this.value;
    searchField = searchField.trim();

    if (searchField == '' || /*typeof existingSearchResultsCont !== "undefined"*/ !existingSearchResultsCont) {
        existingSearchResultsCont.remove();
        return;
    }


    let searchResultsCont;

     if (!existingSearchResultsCont ) {

             searchResultsCont = document.createElement('div');
            searchResultsCont.id = "searchResultsContainer";
            document.getElementById('mainHeaderSearchContainer').appendChild(searchResultsCont);
            searchResultsCont.className = "search-results-container--hidden";
    }

    let formData = new FormData;
    formData.append('searchField', searchField);
    postAjax('/index/search', formData)
        .then(response =>response.text())
        .then(html => {


            if(existingSearchResultsCont){
                existingSearchResultsCont.insertAdjacentHTML('afterBegin', html);
                return;
            }
                searchResultsCont.insertAdjacentHTML('afterBegin', html);
                searchResultsCont.className = "search-results-container";


        });


});

document.getElementById('mainHeaderTouchBtn').addEventListener('click', function(){

    document.getElementById('mainHeaderMenu').classList.add('show-menu');
});














