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
    $('#svg-nav').append('<li><a data-toggle="collapse" href="' +
        $(this).attr("href") + '">' +
        $(this).text().substring(6) +
      "</a></li>");
  });

  // Expand first collection of SVGs after loading
  $('.svg-collection-title').first().click();

  // SPRITES!

  $( "#target" ).click(function() {
    //
  });

});
