
$(document).ready(function () {

    $('#search_form').hide();
    $(document).on('click', '#toggleSearch', function(event) 
    {
          $('#search_form').toggle(300);

          if($(this).text() == 'EXPAND SEARCH') {
		        $(this).text('COLLAPSE SEARCH');
		    } else {
		        $(this).text('EXPAND SEARCH');        
		    }
         
    });



});