(function($){

	$(function(){

		$("#edit-field-business-category-tid,#edit-items-per-page").selectbox({
			onOpen: function (inst) {
				$(this).parent().parent().parent().find('.sbSelector').addClass('changeback');
			},
			onClose: function (inst) {
				$(this).parent().parent().parent().find('.sbSelector').removeClass('changeback');
			},
			
			effect: "slide"

		});

		var regcode = Drupal.settings.regcode_simple.regcode_key;
		var regcode_dis = Drupal.settings.regcode_discount.regcode_key;

		 $("#edit-regcode-simple").keyup(function(e){ 
	       regcode_check(); 
	    }); 

		 $('<span>$</span>').insertBefore('#edit-profile-silver-field-sub-total-und-0-value,'+
		 	'#edit-profile-silver-field-discount-und-0-value,'+
		 	'#edit-profile-silver-field-tax-und-0-value,'+
		 	'#edit-profile-silver-field-total-und-0-value,'+
		 	'#edit-profile-gold-field-sub-total-gold-und-0-value,'+
		 	'#edit-profile-gold-field-discount-gold-und-0-value,'+
		 	'#edit-profile-gold-field-tax-gold-und-0-value,'+
		 	'#edit-profile-gold-field-total-gold-und-0-value');
	

		function regcode_check() {

			if(regcode==$('#edit-regcode-simple').val())
			{
				$('#edit-profile-silver-field-discount-und-0-value,#edit-profile-gold-field-discount-gold-und-0-value').attr('value',regcode_dis);
			}
			else
			{
				$('#edit-profile-silver-field-discount-und-0-value,#edit-profile-gold-field-discount-gold-und-0-value').attr('value','0.00');
			}

			var dis = parseFloat($('#edit-profile-silver-field-discount-und-0-value,#edit-profile-gold-field-discount-gold-und-0-value').val()).toFixed(2);
			var tax = parseFloat($('#edit-profile-silver-field-tax-und-0-value,#edit-profile-gold-field-tax-gold-und-0-value').val()).toFixed(2);
			var subtotal = parseFloat($('#edit-profile-silver-field-sub-total-und-0-value,#edit-profile-gold-field-sub-total-gold-und-0-value').val()).toFixed(2);
			var afterdis =  subtotal-dis;
			var afterdis_tax = 8/100*afterdis;
			var total = parseFloat(afterdis+afterdis_tax).toFixed(2);

			$('#edit-profile-silver-field-total-und-0-value,#edit-profile-gold-field-total-gold-und-0-value').attr('value',total);
			
			
		}


	});

})(jQuery)