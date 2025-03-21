<?php

/**
 * Module: Check field formats (Masking)
 */

// Prevent direct access to the plugin
defined( 'ABSPATH' ) || exit;

// jQuery Mask Plugin: https://igorescobar.github.io/jQuery-Mask-Plugin/
add_action( 'wp_enqueue_scripts', function() {
	if ( is_checkout() || is_wc_endpoint_url( 'edit-address' ) ) {
		wp_enqueue_script( 'surbma_hc_jquery_mask', SURBMA_HC_PLUGIN_URL . '/assets/js/jquery.mask.min.js', array( 'jquery' ), '1.14.16', true );
	}
} );

add_action( 'wp_footer', function() {
	// Make sure, we are on the right page
	if ( !is_checkout() && !is_wc_endpoint_url( 'edit-address' ) ) {
		return;
	}

	// Get the settings array
	global $hc_gems_options;

	// Get the settings
	$maskcheckoutfieldsplaceholderValue = $hc_gems_options['maskcheckoutfieldsplaceholder'] ?? 0;
	$maskbillingtaxfieldValue = $hc_gems_options['maskbillingtaxfield'] ?? 0;
	$maskbillingpostcodefieldValue = $hc_gems_options['maskbillingpostcodefield'] ?? 0;
	$maskbillingphonefieldValue = $hc_gems_options['maskbillingphonefield'] ?? 0;
	$maskshippingpostcodefieldValue = $hc_gems_options['maskshippingpostcodefield'] ?? 0;
	?>
<script id="cps-hc-wcgems-mask-checkout-fields">
jQuery(document).ready(function($){
	// Mask the Billing fields
	function HCmaskcheckoutbillingfields(){
<?php if ( 1 == $maskcheckoutfieldsplaceholderValue ) { ?>
		var options = {
			translation : {
				'H': {pattern: /[0-9]|H/},
				'X': {pattern: /[0-9U]/},
				'Y': {pattern: /[0-9]|-/},
				'Z': {pattern: /[0-9]|-/, optional: true},
				'U': {pattern: /[U]/}
			},
			placeholder: '_____________',
			onKeyPress: function(cep, e, field, options) {
				// console.log('cep:', cep);
				// console.log('e:', e);
				// console.log('field:', field);
				// console.log('options:', options);
				var masks = ['00000000-0-00', '00000000000', '00000000Y', 'HU00000000', 'HX000000Y0Z99'];
				if ( typeof cep == 'undefined' || cep.length < 1 ) {
					var mask = masks[4];
				} else {
					if ( cep[0].match(/[H]/) ) {
						var mask = masks[3];
					} else {
						var mask = masks[2];
						if ( cep.length > 8 ) {
							if ( cep[8].match(/\d/) ) {
								var mask = masks[1];
							} else {
								var mask = masks[0];
							}
						}
					}
				}
				$('#billing_tax_number').mask(mask, options);
			}
		};
		<?php if ( 1 == $maskbillingtaxfieldValue ) { ?>
		$('#billing_tax_number').mask('HX000000Y0Z99', options);
		<?php } ?>

		<?php if ( 1 == $maskbillingpostcodefieldValue ) { ?>
		$('#billing_postcode').mask('0000', {placeholder: '____'});
		<?php } ?>

		<?php if ( 1 == $maskbillingphonefieldValue ) { ?>
		$('#billing_phone').mask('+36000000009', {placeholder: '+36_________'});
		<?php } ?>
<?php } else { ?>
		var options = {
			translation : {
				'H': {pattern: /[0-9]|H/},
				'X': {pattern: /[0-9U]/},
				'Y': {pattern: /[0-9]|-/},
				'Z': {pattern: /[0-9]|-/, optional: true},
				'U': {pattern: /[U]/}
			},
			onKeyPress: function(cep, e, field, options) {
				// console.log('cep:', cep);
				// console.log('e:', e);
				// console.log('field:', field);
				// console.log('options:', options);
				var masks = ['00000000-0-00', '00000000000', '00000000Y', 'HU00000000', 'HX000000Y0Z99'];
				if ( typeof cep == 'undefined' || cep.length < 1 ) {
					var mask = masks[4];
				} else {
					if ( cep[0].match(/[H]/) ) {
						var mask = masks[3];
					} else {
						var mask = masks[2];
						if ( cep.length > 8 ) {
							if ( cep[8].match(/\d/) ) {
								var mask = masks[1];
							} else {
								var mask = masks[0];
							}
						}
					}
				}
				$('#billing_tax_number').mask(mask, options);
			}
		};
		<?php if ( 1 == $maskbillingtaxfieldValue ) { ?>
		$('#billing_tax_number').mask('HX000000Y0Z99', options);
		<?php } ?>

		<?php if ( 1 == $maskbillingpostcodefieldValue ) { ?>
		$('#billing_postcode').mask('0000');
		<?php } ?>

		<?php if ( 1 == $maskbillingphonefieldValue ) { ?>
		$('#billing_phone').mask('+36000000009');
		<?php } ?>
<?php } ?>
		$('#billing_phone').focus(function() {
			if( $('#billing_phone').val() == '' || $('#billing_phone').val() == '+' || $('#billing_phone').val() == '+3' ){
				$('#billing_phone').val('+36');
			}
		});
	}

	// Unmask the Billing fields
	function HCunmaskcheckoutbillingfields(){
		$('#billing_tax_number').unmask();
		$('#billing_postcode').unmask();
		$('#billing_phone').unmask();
	}

	// Mask the Billing fields if Country is HU
	if( $('#billing_country').val() == 'HU' ){
		HCmaskcheckoutbillingfields();
	}
	// Check if Billing Country has changed
	$('#billing_country').change(function() {
		if( $('#billing_country').val() == 'HU' ){
			HCmaskcheckoutbillingfields();
		} else {
			HCunmaskcheckoutbillingfields();
		}
	});

	// Mask the Shipping fields
	function HCmaskcheckoutshippingfields(){
		<?php if ( 1 == $maskshippingpostcodefieldValue ) { ?>
			<?php if ( 1 == $maskcheckoutfieldsplaceholderValue ) { ?>
			$('#shipping_postcode').mask('0000', {placeholder: '____'});
			<?php } else { ?>
			$('#shipping_postcode').mask('0000');
			<?php } ?>
		<?php } ?>
	}

	// Unmask the Shipping fields
	function HCunmaskcheckoutshippingfields(){
		$('#shipping_postcode').unmask();
	}

	// Mask the Shipping fields if Country is HU
	if( $('#shipping_country').val() == 'HU' ){
		HCmaskcheckoutshippingfields();
	}
	// Check if Shipping Country has changed
	$('#shipping_country').change(function() {
		if( $('#shipping_country').val() == 'HU' ){
			HCmaskcheckoutshippingfields();
		} else {
			HCunmaskcheckoutshippingfields();
		}
	});

	// DEBUG
	/*
	$('#billing_tax_number').keyup(function() {
		console.log($('#billing_tax_number').val());
		console.log($('#billing_tax_number').cleanVal());
	}).keyup();
	*/
});
</script>
<?php
} );
