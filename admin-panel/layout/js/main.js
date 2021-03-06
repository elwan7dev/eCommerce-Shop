$(function () {
  "use strict";

  // Calls the selectBoxIt method on your HTML select box
  // $("select").selectBoxIt({

  //   // Uses the Twitter Bootstrap theme for the drop down
    
  //   // Uses the jQueryUI 'shake' effect when opening the drop down
  //   showEffect: "shake",

  //   // Sets the animation speed to 'slow'
  //   showEffectSpeed: 'slow',

  //   // Sets jQueryUI options to shake 1 time when opening the drop down
  //   showEffectOptions: { times: 1 },

  //   // Uses the jQueryUI 'explode' effect when closing the drop down
  //   hideEffect: "explode"

  // });

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

  // sub-categories in Categories page  
  $('.child-link').hover(function () {
      // over
      // $('.show-delete').fadeIn();
      $(this).find('.show-delete').fadeIn(100);
    }, function () {
      // out
      $(this).find('.show-delete').fadeOut(100);
    }
  );

  $("#myTags").tagit({
   // Options
   fieldName: "tag",
   availableTags: ["c++", "java", "php", "javascript", "ruby", "python", "c"],
   autocomplete: {delay: 0, minLength: 2},
   showAutocompleteOnFocus: true,
   removeConfirmation: false,
   caseSensitive: true,
   allowDuplicates: false,
   allowSpaces: false,
   readOnly: false,
   tagLimit: null,
   singleField: false,
   singleFieldDelimiter: ',',
   singleFieldNode: null,
   tabIndex: null,
   placeholderText: null,

   // Events
   beforeTagAdded: function(event, ui) {
       console.log(ui.tag);
   },
   afterTagAdded: function(event, ui) {
       console.log(ui.tag);
   },
   beforeTagRemoved: function(event, ui) {
       console.log(ui.tag);
   },
   onTagExists: function(event, ui) {
       console.log(ui.tag);
   },
   onTagClicked: function(event, ui) {
       console.log(ui.tag);
   },
   onTagLimitExceeded: function(event, ui) {
       console.log(ui.tag);
   }
  });


});
