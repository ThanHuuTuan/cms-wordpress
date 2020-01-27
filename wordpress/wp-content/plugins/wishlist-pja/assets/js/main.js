jQuery(document).ready(function() {
	jQuery('.pja-wl-btn').click(function(e) {
		e.preventDefault();
		var curr_btn = jQuery(this);
		var product_id = jQuery(this).data('product');

		curr_btn.off('click');
		curr_btn.addClass('pja-wl-btn-disabled');

	    post_data = 'action=pja-wl-addtowishlist&p=' + product_id;

	    jQuery.ajax({
			type: 'post',
			url: pjawl_ajaxurl,
			data: post_data,
			dataType: 'json',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				curr_btn.addClass('pja-wl-btn-ko');
				curr_btn.text(pjawl_msg_ko);				
			},
			success: function(data, textStatus){
				if(data.response && data.response == 'OK') {
					curr_btn.addClass('pja-wl-btn-ok');
					curr_btn.text(pjawl_msg_ok);
				} else {
					curr_btn.addClass('pja-wl-btn-ko');
					curr_btn.text(pjawl_msg_ko);
				}			
			}
		});
	});
});

jQuery(document).ready(function() {
	jQuery('.pja-wl-drop-btn').click(function(e) {
		e.preventDefault();
		var curr_btn = jQuery(this);
		var product_id = jQuery(this).data('product');

		curr_btn.off('click');
		curr_btn.addClass('pja-wl-drop-btn-disabled');

	    post_data = 'action=pja-wl-removefromuserwishlist&p=' + product_id;

	    jQuery.ajax({
			type: 'post',
			url: pjawl_ajaxurl,
			data: post_data,
			dataType: 'json',
			error: function(XMLHttpRequest, textStatus, errorThrown){
				curr_btn.addClass('pja-wl-drop-btn-ko');
				curr_btn.text(pjawl_msg_ko);	
				console.log('weird place');			
			},
			success: function(data, textStatus){
				if(data.response && data.response == 'OK') {
					curr_btn.addClass('pja-wl-drop-btn-ok');
					curr_btn.text(pjawl_msg_drop);
				} else {
					curr_btn.addClass('pja-wl-drop-btn-ko');
					curr_btn.text(pjawl_msg_ko);
					console.log('weird place 2');	
				}			
			}
		});
	});
});

