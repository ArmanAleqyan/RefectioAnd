


function readURL(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blahas').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$("#file-logos").on("change", function () {
    readURL(this);
});


function readURL2(input) {

    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blaha').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}
$("#file-logo").on("change", function () {
    readURL2(this);
});




$( ".chanje" ).change(function() {
    $('.opensave').show();
});

$( ".deletbutton" ).click(function() {
    let img_get_src =  $(this).parent().parent().children('.card-img-top').attr('src');

    $(".atag").attr("href", "http://80.78.246.59/Refectio/public/admin/deleteProductImage/image_id="+$(this).attr("data-id"))

    $(".modalimg").attr("src", img_get_src);


});

