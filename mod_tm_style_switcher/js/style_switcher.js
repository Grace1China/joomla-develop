;(function($){
	$.fn.style_switcher = function(path, cookie_path){
		$('#style_switcher .color_scheme').click(function(){
			href = $(this).attr('data-scheme');
			$('link#color_scheme').attr({href: path+href+'.css'});
			$('#style_switcher_input').val(href);
			$('#style_switcher li').removeClass('active');
			$(this).closest('li').addClass('active');
			$('#style_switcher_button').removeAttr('disabled');
		})
		$('#style_switcher_button').click(function(){
			createCookie('color_scheme', '', 0, cookie_path);
			var form = $('#style_switcher_form'),
			value   = form.serializeArray(),
	        request = {
	            'option' : 'com_ajax',
	            'module' : 'tm_style_switcher',
	            'data'   : value,
	            'format' : 'raw'
	        };
			$.ajax({
	            type   : 'POST',
	            data   : request,
	            beforeSend: function(){
	            	$('#style_switcher').addClass('loading');
	            },
	            success: function (response) {
	            	$('#style_switcher').removeClass('loading').addClass(response)
	            	.delay(2000)
                    .queue(function(n){
                        $(this)
                        .removeClass(response);
                        n();
                    });
	            }
	        })
	        return false;
		})
	}
})(jQuery);