document.addEventListener('DOMContentLoaded', function () {

    const input = document.querySelector("input[data-image]");
    const img = document.querySelector("img[data-image]");

    if (input === null || img === null) {
        return;
    }

    const reader = new FileReader();
    let file;

    reader.onload = function(e) {
        img.src = e.target.result;
    };

    input.addEventListener('change', function (e) {
        const f = e.target.files[0];
        file = f;
        reader.readAsDataURL(f);
    });

    img.addEventListener('click', function (e) {
        input.click();
    });
});