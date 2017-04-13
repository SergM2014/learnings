
let progressFile = document.getElementById('fileDownloadProgress'),
    outputFile = document.getElementById('fileDownloadOutput'),
    submitFileBtn = document.getElementById('downloadFileBtn'),
    resetFileBtn = document.getElementById('resetFileBtn'),
    fileField =  document.getElementById('downloadFile');



// this background is for imageupload

function progressHandlerFile(event){

    let percent = Math.round((event.loaded/event.total)*100);

    progressFile.value = percent;
   // progress.innerText= percent+"%";
}

function completeHandlerFile(event){//тут ивент переобразуется в XMLHttpRequestProgressEvent {}

    let response = JSON.parse(event.target.responseText);
    outputFile.innerHTML= response.message;

    progressFile.value = 0;
    outputFile.classList.remove('hidden');
    submitFileBtn.classList.add('hidden');
    progressFile.classList.add('hidden');
    resetFileBtn.removeAttribute('disabled');


    if(response.error){
        resetFileBtn.classList.add('hidden');
        fileField.classList.remove('hidden');
        fileField.value = '';
    }
}


function errorHandlerFile(event){

    outputFile.innerHTML= 'Upload failed';
}


function abortHandlerFile(event){

    outputFile.innerHTML= 'Upload aborted';
}


//to make previe image using file API


if(document.getElementById('downloadFile')) {
    document.getElementById('downloadFile').onchange = function () {

        let arr = this.value.split('\\');

        let title = arr[arr.length-1];


        this.classList.add('hidden');

        outputFile.classList.add('hidden');



        outputFile.innerText = title;

        resetFileBtn.classList.remove('hidden');

        submitFileBtn.classList.remove('hidden');



    };//end of function
}



if(submitFileBtn){
    submitFileBtn.onclick = function(e){

        e.preventDefault();
        progressFile.classList.remove('hidden');


        let downloadFile = document.getElementById("downloadFile").files[0];

        let formdata = new FormData();
        let _token = document.getElementById('prozessFileToken').value;
       

        formdata.append("downloadFile", downloadFile);
        formdata.append("_token", _token);
        formdata.append("ajax", true);
       



        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j=> {   let uploadUrl =  "/"+Helper.getCurrentLang(j)+"/admin/lesson/downloadFile";

                let send_image=new XMLHttpRequest();
                send_image.upload.addEventListener("progress", progressHandlerFile, false);
                send_image.addEventListener("load", completeHandlerFile, false);
                send_image.addEventListener("error", errorHandlerFile, false);
                send_image.addEventListener("abort", abortHandlerFile, false);
                send_image.open("POST", uploadUrl);
                send_image.send(formdata);

                resetFileBtn.setAttribute('disabled', 'disabled');

            })

    };// end of submit button
}



if(resetFileBtn) {
    resetFileBtn.onclick = function (e) {
        e.preventDefault();

        let _token = document.getElementById('prozessFileToken').value;
       


        document.getElementById('downloadFilePreview').setAttribute('src', '/img/download_file.jpg');
        document.getElementById('downloadFile').classList.remove('hidden');
        let formData = new FormData;
         formData.append('_token', _token);
         formData.append('ajax', true);
        

        fetch('/index/getLanguageComponents', {
            'method' : 'POST',
            'credentials' : 'same-origin'
        })
            .then( response => response.json())
            .then(j =>  "/"+Helper.getCurrentLang(j)+"/admin/lesson/deleteFile" )
            .then(deleteUrl =>
                                fetch( deleteUrl,
                                    {
                                        method : "POST",
                                        credentials: "same-origin",
                                        body:formData
                                    })
                )

            .then(responce => responce.json())
            .then(j => { outputFile.innerHTML = j.message;

                fileField.value = '';

            if(outputFile.classList.contains('hidden')) {
                outputFile.classList.remove('hidden')
            }

            });



        submitFileBtn.classList.add('hidden');
        resetFileBtn.classList.add('hidden');

    };
}
//end of image reset


