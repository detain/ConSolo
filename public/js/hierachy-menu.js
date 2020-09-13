$(document).ready(function() {
  $('.sub-nav > a').click(function() {
    if ($(this).parent('.sub-nav').hasClass('open')) {
      $(this).parent('.sub-nav').removeClass('open');
      $(this).parent('.sub-nav').children('ul').slideUp("slow");
    } else {
      $(this).parent('.sub-nav').addClass('open');
      $(this).parent('.sub-nav').children('ul').slideDown("slow");
    };
  });
});