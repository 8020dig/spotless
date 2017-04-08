jQuery(function($) {
  $( '.aecom-sortable' ).sortable({
    items: '> div'
  } );
	// script to choose parent tag too by child tag
	$(".urs_projects_checklist li label input[type=checkbox]").change(function() {
	    if(this.checked) {
	        //Do stuff
			$(this).parents(".urs_projects_checklist li").each(function(){
	        	$(this).find("label>input[type=checkbox]").eq(0).prop('checked', true);
			});
	    }else{
			$(this).parents(".urs_projects_checklist li").each(function(){
	        	$(this).find("label>input[type=checkbox]").eq(0).prop('checked', false);
			})    
		}
	});  
});
