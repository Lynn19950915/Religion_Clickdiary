
	// Hdiary
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		
	    $("select[id='group_view']").selectpicker('mobile');
	    $("select[id='group_post']").selectpicker('mobile');
	    
	    $.fn.selectpicker.Constructor.DEFAULTS.mobile = true;

	    $("select[id='group_view']").selectpicker();
	    $("select[id='group_post']").selectpicker();
	} else {
		$("select[id='group_view']").selectpicker();
		$("select[id='group_post']").selectpicker();
	}



	$("select[id='group_view']").selectpicker();
	$("select[id='group_post']").selectpicker();

	$("select[id='group_view']").selectpicker('refresh');
	$("select[id='group_post']").selectpicker('refresh');

	// Create Alter
	$.fn.selectpicker.Constructor.DEFAULTS.mobile = true;
	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
	    $("select[id='same_group']").selectpicker('mobile');
	    $("select[id='same_group']").selectpicker('refresh');
	} else {
		$("select[id='same_group']").selectpicker();
	}

	if( /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {
		$("select[id='same_group']").selectpicker('refresh')
	}