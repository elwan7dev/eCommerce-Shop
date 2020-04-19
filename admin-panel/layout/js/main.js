$(function () {
  "use strict";

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

  
});
