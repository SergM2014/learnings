Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};

let progress=document.getElementById('imageDownloadProgress'),
    output= document.getElementById('imageDownloadOutput'),
    submit_btn= document.getElementById('downloadImageBtn'),
    reset_btn= document.getElementById('resetImageBtn');




// this background is for imageupload

function progressHandler(event){

    let percent=Math.round((event.loaded/event.total)*100);
    progress.style.width= percent+"%";
    progress.innerHTML= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    output.innerHTML= response.message;

    progress.style.width= "0%";
    progress.innerHTML= "0%";


    output.classList.remove('invisible');
    submit_btn.classList.add('invisible');
    progress.classList.add('invisible');
    reset_btn.removeAttribute('disabled');
}


function errorHandler(event){

    output.innerHTML= 'Upload failed';
}


function abortHandler(event){

    output.innerHTML= 'Upload aborted';
}


//to make previe image using file API


if(document.getElementById('file')) {
    document.getElementById('file').onchange = function () {

        let input = this;

        if (input.files && input.files[0]) {
            if (input.files[0].type.match('image.*')) {
                let reader = new FileReader();

                reader.onload = function (e) {
                    document.getElementById('downloadImagePreview').setAttribute('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);

                document.getElementById('file').classList.add('hidden');

                output.classList.add('hidden');

                reset_btn.classList.remove('hidden');

                submit_btn.classList.remove('hidden');

            }// else console.log('is not image mime type');
        }// else console.log('not isset files data or files API not supordet');

    };//end of function
}



if(submit_btn){
    submit_btn.onclick = function(e){

        e.preventDefault();
        progress.classList.remove('hidden');


        let file = document.getElementById("file").files[0];

        let formdata = new FormData();
       // let _token = document.getElementById('prozessAvatar').value;
       // let action = document.getElementById('action').value;

        formdata.append("file", file);
      //  formdata.append("_token", _token);
       // formdata.append("action", action );



        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j => {
                let url = window.location.href;
                let urlArray = url.split('/');
                let intersection = urlArray.intersect(j.languagesArray);

                let lang = intersection.shift();
                lang = (lang)? lang : j.defaultLanguage;

                let uploadUrl =  "/"+lang+"/images/uploadAvatar";

                let send_image=new XMLHttpRequest();
                send_image.upload.addEventListener("progress", progressHandler, false);
                send_image.addEventListener("load", completeHandler, false);
                send_image.addEventListener("error", errorHandler, false);
                send_image.addEventListener("abort", abortHandler, false);
                send_image.open("POST", uploadUrl);
                send_image.send(formdata);

                reset_btn.setAttribute('disabled', 'disabled');

            })




    };// end of submit button
}



if(reset_btn) {
    reset_btn.onclick = function (e) {
        e.preventDefault();

       // let _token = document.getElementById('prozessAvatar').value;

        document.getElementById('image_preview').setAttribute('src', '/public/img/noavatar.jpg');
        document.getElementById('file').classList.remove('hidden');

        let founded_lang =  new LangForAjax().getLanguage();
        let url =  founded_lang+"/image/delete";

        let formData = new FormData;
        formData.append('_token', _token);

        fetch( url,
            {
                method : "POST",
                credentials: "same-origin",
                body:formData

            })
            .then(responce => responce.json())
            .then(j => output.innerHTML = j.message)



        submit_btn.classList.add('invisible');
       reset_btn.classList.add('invisible');

    };
}
//end of image upload