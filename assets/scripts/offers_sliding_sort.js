$( "#slide_arrow" ).click(function() {
    $( "#cat_list" ).slideToggle(function() {
        $( "#slide_arrow" ).toggleClass( "fa-angle-down" );
        $( "#slide_arrow" ).toggleClass( "fa-angle-up" );
    });
  });