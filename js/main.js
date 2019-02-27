$(function() {
  // Hide any folder names / accordions that are empty
  $('.js-count').each(function(){
    if ($(this).text() === "0") {
      $(this).closest( ".js-collection" ).remove();
    }
  });

  // Create nav links
  $( ".svg-collection-title" ).each(function( i ) {
    // substring to remove the common "icons/" path
    $('#svg-nav').append('<a class="nav-link p-0" data-toggle="collapse" href="' +
        $(this).attr("href") + '">' +
        $(this).text().substring(6) +
      "</a>");
    // console.log( i + ": " + $( this ).text() );
  });

  // Expand first collection of SVGs after loading
  $('.svg-collection-title').first().click();

  // to have all expanded by default
  // $('.svg-collection-title').click();

  // Expand / collapse all SVG collections
  $('#all-show').click(function() {
    $('.w-icons.collapse').collapse('show');
  });
  $('#all-hide').click(function() {
    $('.w-icons.collapse').collapse('hide');
  });


  // SPRITES!
  // Selectable icon
  $(".svg-icon").click(function() {
    $(this).toggleClass("active");
  });

  // Clipboard usage - uses 3rd party
  // Copy the sprite textarea contents
  new ClipboardJS('.js-copy');

  // Copy the SVG code purely
  var clipboard = new ClipboardJS('.svg-copyer', {
    text: function(trigger) {
      return $(trigger).siblings('.svg-icon').find('.svg-copy').html();
    }
  });
  // // Debugging tools to uncomment:
  // clipboard.on('success', function(e) {
  //   console.info('Action:', e.action);
  //   console.info('Text:', e.text);
  //   console.info('Trigger:', e.trigger);
  //   e.clearSelection();
  // });
  // clipboard.on('error', function(e) {
  //   console.error('Action:', e.action);
  //   console.error('Trigger:', e.trigger);
  // });


});
