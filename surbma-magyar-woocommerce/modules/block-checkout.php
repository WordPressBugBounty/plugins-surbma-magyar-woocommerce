<?php

// Prevent direct access to the plugin
defined( 'ABSPATH' ) || exit;

/**
 * WooCommerce Block Checkout integration for HuCommerce.
 *
 * Registers the tax number (adószám) field in the WooCommerce block-based
 * checkout using the Additional Checkout Fields API (WooCommerce 8.4+).
 *
 * This module is only loaded when the Additional Fields API is available.
 */

// Register the tax number field for block checkout.
add_action( 'woocommerce_init', function() {
	if ( ! function_exists( 'woocommerce_register_additional_checkout_field' ) ) {
		return;
	}

	if ( 'hidden' === get_option( 'woocommerce_checkout_company_field', 'optional' ) ) {
		return;
	}

	woocommerce_register_additional_checkout_field(
		array(
			'id'         => 'surbma-hc/tax-number',
			'label'      => __( 'Tax number', 'surbma-magyar-woocommerce' ),
			'location'   => 'contact',
			'required'   => false,
			'type'       => 'text',
			'attributes' => array(
				'autocomplete' => 'off',
			),
		)
	);
} );

// Server-side validation: Hungarian tax number format check.
add_action( 'woocommerce_validate_additional_checkout_field', function( \WP_Error $errors, $field_key, $field_value ) {
	if ( 'surbma-hc/tax-number' !== $field_key ) {
		return;
	}

	$options = get_option( 'surbma_hc_fields' );
	$validatebillingtaxfieldValue = isset( $options['validatebillingtaxfield'] ) ? $options['validatebillingtaxfield'] : 0;

	if ( ! $validatebillingtaxfieldValue || empty( $field_value ) ) {
		return;
	}

	$pattern_short = '/^\d{11}$/';
	$pattern_full  = '/^\d{8}-\d{1}-\d{2}$/';
	$pattern_eu    = '/^HU\d{8}$/';

	if (
		! preg_match( $pattern_short, $field_value ) &&
		! preg_match( $pattern_full, $field_value ) &&
		! preg_match( $pattern_eu, $field_value )
	) {
		$errors->add(
			'surbma-hc-tax-number-invalid',
			__( '<strong>Billing VAT number</strong> field is invalid. Please check again!', 'surbma-magyar-woocommerce' )
		);
	}
}, 10, 3 );

// Copy field value to legacy order meta and user meta after order is placed.
add_action( 'woocommerce_store_api_checkout_order_processed', function( \WC_Order $order ) {
	$tax_number = $order->get_meta( 'surbma-hc/tax-number' );

	if ( '' === $tax_number || false === $tax_number ) {
		return;
	}

	$tax_number = sanitize_text_field( $tax_number );

	// Save to legacy billing meta key for backwards compatibility.
	$order->update_meta_data( '_billing_tax_number', $tax_number );
	$order->save_meta_data();

	// Save to user meta for "My Account" address page pre-fill.
	$customer_id = $order->get_customer_id();
	if ( $customer_id ) {
		update_user_meta( $customer_id, 'billing_tax_number', $tax_number );
	}
} );

// Pre-populate the field with the logged-in user's saved value.
add_filter( 'woocommerce_get_default_value_for_surbma-hc/tax-number', function( $value, $group, $wc_object ) {
	if ( ! is_user_logged_in() ) {
		return $value;
	}
	$saved = get_user_meta( get_current_user_id(), 'billing_tax_number', true );
	return $saved ? $saved : $value;
}, 10, 3 );
