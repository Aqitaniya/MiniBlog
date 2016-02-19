(function( $ ){
	
	//// ---> Проверка на существование элемента на странице
	jQuery.fn.exists = function() {
	   return jQuery(this).length;
	}
	
	$(function() {
		if(!is_mobile()){
			if($('#user_phone').exists()){
				$('#user_phone').each(function(){
					$(this).mask("(999) 999-99-99");
				});
				$('#user_phone')
					.addClass('rfield')
					.removeAttr('required')
					.removeAttr('pattern')
					.removeAttr('title')
					.attr({'placeholder':'(___) ___ __ __'});
			}
		   if($('#user_birth_date').exists()){
				$('#user_birth_date').each(function(){
					$(this).mask("9999-99-99");
				});
				$('#user_birth_date')
					.addClass('rfield')
					.removeAttr('required')
					.removeAttr('pattern')
					.removeAttr('title')
					.attr({'placeholder':'yyyy-mm-dd'});
				}
		}
	});
})( jQuery );
	