;(function($){
	$.fn.style_switcher = function(path, cookie_path){
		$('#style_switcher .color_scheme').click(function(){
			href = $(this).attr('data-scheme');
			$('link#color_scheme').attr({href: path+href+'.css'});
			$('#style_switcher li').removeClass('active');
			$(this).closest('li').addClass('active');
			createCookie('color_scheme', href, 0, cookie_path);
		})
		$('#style_switcher_button').click(function(){
	        return false;
		})
	}
})(jQuery);