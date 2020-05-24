import Dropzone from 'dropzone';
import naja from "naja";

Dropzone.autoDiscover = false;

(function () {
    'use strict';

    const dz = document.getElementById('dz-container');
    const upload = dz.dataset.upload;
    const success = dz.dataset.success;
    const acceptedFiles = dz.dataset.acceptedFiles;

    let myDropzone = new Dropzone("#dz-container", {
        url: upload,
        maxFilesize: 4, // 4MB
        acceptedFiles: acceptedFiles,
        dictDefaultMessage: "Click or drop files here"
    });
    myDropzone.on('queuecomplete', function () {
        naja.makeRequest('GET', success)
            .then(payload => {
                console.log('payload');
                console.log(payload);
            })
            .catch(error => {
                console.error('error');
                console.error(error);
            });
    });
})();