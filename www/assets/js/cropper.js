import Cropper from 'cropperjs';

// Class definition
let KTCropperDemo = function () {
    'use strict';
    // Private functions
    let initAspectRatio = {
        get(key) {
            switch (key) {
                case '16:9':
                    return 16 / 9;
                case '4:3':
                    return 4 / 3;
                case '1:1':
                    return 1;
                case '21:9':
                    return 21 / 9;
                default:
                    return 16 / 9;
            }
        }
    };
    let initCropperDemo = function () {
        let image = document.getElementById('cropper-img');
        let button = document.getElementById('cropper-btn');
        let lg = document.getElementById('cropper-preview-lg');
        let ratio = image.dataset.aspectRatio;
        console.log(ratio);
        let options = {
            viewMode: 1,
            aspectRatio: initAspectRatio.get(ratio),
            preview: '.img-preview',
            zoomOnTouch: false,
            zoomOnWheel: false,
            ready: function (e) {
                console.log(e.type);
            },
            cropstart: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropmove: function (e) {
                console.log(e.type, e.detail.action);
            },
            cropend: function (e) {
                console.log(e.type, e.detail.action);
            },
            crop: function (e) {
                console.log(e.type);
            },
        };
        let cropper = new Cropper(image, options);
    };

    return {
        // public functions
        init: function () {
            initCropperDemo();
        },
    };
}();

document.addEventListener('DOMContentLoaded', () => {
    // KTCropperDemo.init();


    // const container = document.getElementById('cropper');
    // if (container) {
    //     let image = container.querySelector('img');
    //     let btn = container.querySelector('button');
    //     let input = container.querySelector('input[type=file]');
    //     let $modal = $('#cropper-modal');
    //     let btnModal = document.getElementById('cropper-modal-btn');
    //     let imageModal = document.getElementById('cropper-modal-image');
    //     let cropper;
    //
    //     let aspectRatio = input.dataset.aspectRatio;
    //     let uploadedImageURL;
    //
    //     // Button - click
    //     btn.addEventListener('click', () => {
    //         input.click();
    //     });
    //     // Input - change
    //     input.addEventListener('change', (e) => {
    //         let files = e.target.files;
    //         let done = (url) => {
    //             input.value = '';
    //             imageModal.src = url;
    //             $modal.modal('show');
    //         };
    //         let reader;
    //         let file;
    //         let url;
    //
    //         if (files && files.length > 0) {
    //             file = files[0];
    //
    //             if (URL) {
    //                 done(URL.createObjectURL(file));
    //             } else if (FileReader) {
    //                 reader = new FileReader();
    //                 reader.onload = (e) => {
    //                     done(reader.result);
    //                 };
    //                 reader.readAsDataURL(file);
    //             }
    //         }
    //     });
    //
    //     $modal
    //         .on('shown.bs.modal', function () {
    //             cropper = new Cropper(imageModal, {
    //                 aspectRatio: 1,
    //                 viewMode: 3
    //             })
    //         })
    //         .on('hidden.bs.modal', function () {
    //             cropper.destroy();
    //             cropper = null;
    //         });
    //
    //     btnModal.addEventListener('click', function () {
    //         let initialAvatarURL;
    //         let canvas;
    //
    //         $modal.modal('hide');
    //
    //         if (cropper) {
    //             canvas = cropper.getCroppedCanvas();
    //             image.src = canvas.toDataURL();
    //         }
    //     });
    // }
});
