$(window).ready(function(){
    var str = "";
    $(".message-list .image-thumb img").each(function(){
    str += $(this).attr("src");
    src += "<br />";
    });
    document.body.innerHTML = str;
});