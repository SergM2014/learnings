Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};


let languagesBox = document.getElementsByClassName('main-header__language-select')[0];


class Helper {

    static getCurrentLang(languagesSettings) {

        let url = window.location.href;
        let urlArray = url.split('/');
        let intersection = urlArray.intersect(languagesSettings.languagesArray);

        let lang = intersection.shift();
        return  (lang) ? lang : languagesSettings.defaultLanguage;
    }


    /**
     * getLanguagesSettings
     *
     * @returns {Promise.<TResult>}
     */
    static getLanguagesSettings() {

        return  fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json());


    }

    /**
     * returns ajax request according to current language on site
     *
     * @param givenUrl
     * @param formData
     * @returns {Promise.<TResult>}
     */
    static postAjax(givenUrl, formData){

         let queryResult =   Helper.getLanguagesSettings()
                .then(languagesSettings => {

                    let url = "/" + Helper.getCurrentLang(languagesSettings) + givenUrl;

                    return   fetch(
                        url, {
                            method: 'POST',
                            credentials: 'same-origin',
                            body: formData
                        })
                });

        return queryResult;

    }
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

    //add Comment
    if(e.target.id == "addCommentSubmitBtn"){

        let formData = new FormData(document.getElementById('addCommentForm'));

        Helper.postAjax("/comment/store", formData)

            .then(response =>response.text())
            .then(html => {
                document.querySelector('#CommentFormContainer').innerHTML = html;
            })
    }

    //shoose  comment  to answer
    if(e.target.closest('.lesson-comments__response-link-btn')){

        let commentId = e.target.dataset.commentId;

        let formData = new FormData(document.getElementById('addCommentForm'));
        formData.append('commentId', commentId );

        Helper.postAjax('/comment/getOneForResponse', formData)
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#addCommentHeader').innerHTML = html;
                document.querySelector('#commentParentId').value  = commentId;
            })

    }

//close the choseen comment that should be closed
    if(e.target.id =='lessonCommentCloseSign'){
        fetch(
            '/comment/resetHeader', {
                method: 'POST',
                credentials: 'same-origin',
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#addCommentHeader').innerHTML = html;
                document.querySelector('#commentParentId').value  = 0;
            })
    }


    if(e.target.id == "addTestimonialSubmitBtn"){

        let formData = new FormData(document.getElementById('addTestimonialForm'));

        Helper.postAjax('/index/storeTestimonial', formData)
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#TestimonialFormContainer').innerHTML = html;
            })

    }





});//ends of events hanged on the body














