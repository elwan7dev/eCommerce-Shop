$(function () {
  "use strict";

  // Front-end Funcs
  // in ads page - to live prefview form 
  $('.live-name').keyup(function (e) { 
    $('.live-preview .card-title').text($(this).val());
  });

  $('.live-desc').keyup(function (e) { 
    $('.live-preview .card-text').text($(this).val());
  });

  $('.live-price').keyup(function (e) { 
    $('.live-preview .price-tag').text('$' + $(this).val());
  });



  // Back-end
  // hide placeholder on form focus
  $("[placeholder]")
    .focus(function () {
      // assign value of placeholder in data-text
      $(this).attr("data-text", $(this).attr("placeholder"));
      $(this).attr("placeholder", "");
    })
    .blur(function () {
      $(this).attr("placeholder", $(this).attr("data-text"));
    });

  // add astrisk for the required input fields
  // $("input").each(function () {
  //   // element == this
  //   if ($(this).attr("required") == "required") {
  //     $(this).after("<span class='astrisk'>*</span>");
  //   }
  // });

  // convert password field to text field when hover on eye icon.
  var passField = $(".password");
  $(".show-pass").hover(
    function () {
      // over
      passField.attr("type", "text");
    },
    function () {
      // out
      passField.attr("type", "password");
    }
  );

  // Confirmation Message on Button
  $(".confirm").click(function () {
    return confirm("Are You Sure?");
  });

  // $('#my-card').CardWidget(collapseTrigger , removeTrigger);

  // Categories View option 
  $('.cat h3').click(function () { 
    $(this).next('.full-view').fadeToggle();
    
  });

  $('.options span').click(function () { 

    $(this).addClass('active').siblings('span').removeClass('active');

    if ($(this).data('view') === 'full') {
      $('.cat .full-view').fadeIn();
    }else {
      $('.cat .full-view').fadeOut();
    }
    
  });


});
