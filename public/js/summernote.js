$(document).ready(function () {
    // $('#summernote').summernote();
    $(".edit_summer_dsc").summernote({
        tabsize: 2,
        height: 200,
        toolbar: [
            ["style", ["style"]],
            ["font", ["bold", "underline", "clear"]],
            ["color", ["color"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link"]],
        ],
    });
});
