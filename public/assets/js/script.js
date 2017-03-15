let languagesBox = document.getElementsByClassName('main-header__language-select')[0];





function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function validatePhone(phone){
   let regexp = /\d{3}-\d{3}-\d{2}-\d{2}/;
    //if (regexp.test(phone))  return true;
    return (regexp.test(phone));

   // return false;
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


    if(e.target.id == "addCommentSubmitBtn"){
//alert('I\'am submiting content now');
        let formData = new FormData(document.getElementById('addCommentForm'));
//console.log(formData)
        fetch(
            '/comment/add', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#CommentFormContainer').innerHTML = html;
            })

    }

    if(e.target.closest('.lesson-comments__response-link')){
       let commentId = e.target.dataset.commentId;
//console.log(commentId)
        let formData = new FormData(document.getElementById('addCommentForm'));
        formData.append('commentId', commentId );

        fetch(
            '/comment/getOneForResponse', {
                method: 'POST',
                credentials: 'same-origin',
                body: formData
            })
            .then(response =>response.text())
            .then(html => {
                document.querySelector('#addCommentHeader').innerHTML = html;
                document.querySelector('#commentParentId').value  = commentId;
            })

    }


    if(e.target.id =='lessonCommentCloseSign'){
//alert('closing')


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








});//ends of events hanged on the body














