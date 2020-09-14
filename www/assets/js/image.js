document.addEventListener('DOMContentLoaded', function () {
    ImagePicker.init();
});

let ImagePicker = function () {
    'use strict';
    // Private functions
    let initImagePicker = function () {
        let container = document.querySelector('.imagepicker');

        if (container) {
            let button = container.querySelector('button');
            let input = container.querySelector('input[type=file]');
            let img = container.querySelector('img');

            // click
            button.onclick = function (event) {
                button.querySelector('input[type=file]').click();
            };
            // change
            input.onchange = function (event) {
                let files = event.target.files;
                if (files && files.length > 0) {
                    let file = files[0];
                    let reader = new FileReader();
                    reader.onload = (result) => {
                        img.src = reader.result;
                        img.parentElement.classList.remove('d-none');
                    };
                    reader.readAsDataURL(file);
                }
            };
        }
    };
    return {
        // public functions
        init: function () {
            initImagePicker();
        }
    };
}();