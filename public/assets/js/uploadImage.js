
// find repeated values in two arrays
Array.prototype.intersect = function(a){
    return this.filter(function(i){ return a.indexOf(i) > -1;});
};

let progress = document.getElementById('imageDownloadProgress'),
    output = document.getElementById('imageDownloadOutput'),
    submit_btn = document.getElementById('downloadImageBtn'),
    reset_btn = document.getElementById('resetImageBtn'),
    delete_img_sign = document.getElementById('deleteImagePreview'),
    imageField =  document.getElementById('file');

class Helper {
    static getCurrentLang(j){

        let url = window.location.href;
        let urlArray = url.split('/');
        let intersection = urlArray.intersect(j.languagesArray);

        let lang = intersection.shift();
        lang = (lang)? lang : j.defaultLanguage;

        return lang;
    }

    static ucFirst(str) {
        // только пустая строка в логическом контексте даст false
        if (!str) return str;

        return str[0].toUpperCase() + str.slice(1);
    }

}


// this background is for imageupload

function progressHandler(event){

    let percent=Math.round((event.loaded/event.total)*100);

    progress.value = percent;
   // progress.innerText= percent+"%";
}

function completeHandler(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    output.innerHTML= response.message;

    progress.value = 0;
    output.classList.remove('hidden');
    submit_btn.classList.add('hidden');
    progress.classList.add('hidden');
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

        if(delete_img_sign) delete_img_sign.className = 'hidden';

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
        let _token = document.getElementById('prozessImageToken').value;
        let imageCustomType = document.getElementById('imageCustomType').value;

        formdata.append("file", file);
        formdata.append("_token", _token);
        formdata.append("ajax", true);
        formdata.append("imageCustomType", imageCustomType );



        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j => {

                let uploadUrl =  "/"+Helper.getCurrentLang(j)+"/images/upload"+Helper.ucFirst(imageCustomType);

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

        let _token = document.getElementById('prozessImageToken').value;
        let imageCustomType = document.getElementById('imageCustomType').value;
        let noPhoto = imageCustomType == 'avatar'? 'noavatar' : 'nophoto';

        document.getElementById('downloadImagePreview').setAttribute('src', '/img/'+noPhoto+'.jpg');
        document.getElementById('file').classList.remove('hidden');
        let formData = new FormData;
         formData.append('_token', _token);
         formData.append('ajax', true);
         formData.append("imageCustomType", imageCustomType );

        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j =>  "/"+Helper.getCurrentLang(j)+"/images/delete"+Helper.ucFirst(imageCustomType) )
            .then(deleteUrl =>
                                fetch( deleteUrl,
                                    {
                                        method : "POST",
                                        credentials: "same-origin",
                                        body:formData
                                    })
                )

            .then(responce => responce.json())
            .then(j => { output.innerHTML = j.message;
            if(output.classList.contains('hidden')) {
                output.classList.remove('hidden')
            }
            imageField.value = '';

            });



        submit_btn.classList.add('hidden');
        reset_btn.classList.add('hidden');

    };
}
//end of image reset


if(delete_img_sign){
    document.getElementById('deleteImagePreview').addEventListener('click', function(){
//console.log(111);

        let _token = document.getElementById('prozessImageToken').value;
        let imageCustomType = document.getElementById('imageCustomType').value;
        let noPhoto = imageCustomType == 'avatar'? 'noavatar' : 'nophoto';
        document.getElementById('downloadImagePreview').setAttribute('src', '/img/'+noPhoto+'.jpg');

        let formData = new FormData;
        formData.append('deleteAvatarInSession', true);
        formData.append('_token', _token);
        formData.append('ajax', true);

        this.className = 'hidden';


        let deleteUrl = "/images/delete"+Helper.ucFirst(imageCustomType);

        fetch( deleteUrl,
            {
                method : "POST",
                credentials: "same-origin",
                body:formData
            })


    })
}
