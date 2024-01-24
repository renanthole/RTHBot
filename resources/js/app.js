require("./bootstrap");
require("admin-lte");
require("laravel-data-method");

function copyInput() {
    var inputElement = document.getElementById("api");
    inputElement.select();
    document.execCommand("copy");
    window.getSelection().removeAllRanges();
}

jQuery(function () {
    $("#copyBtn").on("click", function () {
        copyInput();
    });
});
