(function($) {

  $(document).ready(() => {
    $("#users a").on('click', function(e) {
      e.preventDefault();
      console.log("clicked")
    })
  })
})(jQuery);