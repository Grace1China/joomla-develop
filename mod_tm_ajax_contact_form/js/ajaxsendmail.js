;(function($){
	$.fn.ajaxsendmail = function(validator, success, id){
        var form = $(this),
		value   = form.serializeArray(),
        request = {
            'option' : 'com_ajax',
            'module' : 'tm_ajax_contact_form',
            'data'   : value,
            'format' : 'raw'
        };
		$.ajax({
            type   : 'POST',
            data   : request,
            beforeSend: function(){
                $("#message_"+id)
                .addClass("loader")
                .removeClass("error")
                .removeClass("success")
            },
            success: function (response) {
                switch(response) {
                    case success:
                        $("#message_"+id).
                        removeClass("loader").
                        removeClass("error").
                        addClass("success")
                        .html('<span>'+response+'</span>')
                        .delay(2000)
                        .queue(function(n){
                            $(this)
                            .html('')
                            .removeClass("success");
                            n();
                        });
                        $('#contact-form_'+ id).trigger('reset');
                        validator.resetForm();
                        if (!$.support.placeholder) {
                            $('.mod_tm_ajax_contact_form *[placeholder]').each(function(n){
                                $(this)
                                .parent('.controls')
                                .find('>.mod_tm_ajax_contact_form_placeholder')
                                .show();
                            })
                        }
                        break;
                    default:
                        $("#message_"+id)
                        .removeClass("loader")
                        .removeClass("success")
                        .addClass("error")
                        .html(response)
                        .delay(2000)
                        .queue(function(n){
                            $(this)
                            .html('')
                            .removeClass("error");
                            n();
                        });  
                        break;
                }
            }
        });
	}
})(jQuery);