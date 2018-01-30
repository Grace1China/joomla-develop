;(function($){
	$.fn.ajaxcaptcha = function(validator, success, error, recaptcha_error, id){
    	var form = $(this);
    	value   = form.serializeArray(),
        request = {
            'option' : 'com_ajax',
            'module' : 'tm_ajax_contact_form',
            'data'   : value,
            'format' : 'raw',
            'method' : 'recaptcha'
        };
        $.ajax({
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                $("#message"+id)
                .addClass("loader")
                .removeClass("error")
                .removeClass("success");

                $('#contact-form_'+id+' #recaptcha_table')
                .removeClass('recaptcha_error');

				$('#recaptcha_message_'+id)
				.html("");
            },
            success: function(response){
				switch(response) {
					case "captcha_error":
						$("#message_"+id)
						.removeClass("loader")
						.removeClass("error")
						.removeClass("success")
						.html('');

						$('#contact-form_'+id+' #recaptcha_table')
						.addClass('recaptcha_error');

						$('#recaptcha_message_'+id)
						.html(recaptcha_error);
						break;
					case "success":
						$('#contact-form_'+id+' #recaptcha_table')
						.removeClass('recaptcha_error');

						$('#recaptcha_message_'+id)
						.html("");

						$(form).ajaxsendmail(validator, success, id);
						break;
					default:
						$("#message_"+id)
						.removeClass("loader")
						.removeClass("success")
						.addClass("error")
						.html(error)
						.delay(2000)
                        .queue(function(n){
                            $(this)
                            .html('')
                            .removeClass("error");
                            n();
                        });
				}
                Recaptcha.reload();
			}
        });
	}
})(jQuery);
