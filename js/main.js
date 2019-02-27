$(function() {
    // Hide any folder names / accordions that are empty
  $('.js-count').each(function(){
    if ($(this).text() === "0") {
      $(this).closest( ".js-collection" ).remove();
    }
  });

  $( ".svg-collection-title" ).each(function( i ) {
    // console.log( i + ": " + $( this ).text() );

    // Create nav links
    // substring to remove the common "icons/" path
    $('#svg-nav').append('<a class="nav-link" data-toggle="collapse" href="' +
        $(this).attr("href") + '">' +
        $(this).text().substring(6) +
      "</a>");
  });

  // Expand first collection of SVGs after loading
  $('.svg-collection-title').first().click();

  // to have all expanded by default
  // $('.svg-collection-title').click();

  $('#all-show').click(function() {
    $('.w-icons.collapse').collapse('show');
  });
  $('#all-hide').click(function() {
    $('.w-icons.collapse').collapse('hide');
  });


  // SPRITES!
  // Select icon
  $(".svg-icon").click(function() {
    $(this).toggleClass("active");
  });

});
