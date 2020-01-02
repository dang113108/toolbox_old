$(document).ready(function(){
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    if (this.hash !== "") {
      event.preventDefault();

      var hash = this.hash;

      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){

        window.location.hash = hash;
      });
    }
  });

  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
      if (pos < winTop + 600) {
        $(this).addClass("slide");
      }
    });
  });
})

$(function(){
  function footerPosition(){
    $("footer").removeClass("footer_class");
var contentHeight = document.body.scrollHeight,//网页正文全文高度
winHeight = window.innerHeight;//可视窗口高度，不包括浏览器顶部工具栏
if(!(contentHeight > winHeight)){
//当网页正文高度小于可视窗口高度时，为footer添加类fixed-bottom
$("footer").addClass("footer_class");
}
}
footerPosition();
$(window).resize(footerPosition);
});