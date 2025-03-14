<?php

/**
 * Module: Legal compliance
 */

// Prevent direct access to the plugin
defined( 'ABSPATH' ) || exit;

add_action( 'woocommerce_register_form', function() {
	// Get the settings array
	global $hc_gems_options;

	$regacceptppValue = isset( $hc_gems_options['regacceptpp'] ) ? wp_kses_post( wp_unslash( $hc_gems_options['regacceptpp'] ) ) : esc_html__( 'I\'ve read and accept the <a href="/privacy-policy/" target="_blank">Privacy Policy</a>', 'surbma-magyar-woocommerce' );

	if ( !is_checkout() && $regacceptppValue ) {
		woocommerce_form_field( 'reg_accept_pp', array(
			'type'          => 'checkbox',
			'class'         => array( 'form-row-wide', 'woocommerce-form-row', 'woocommerce-form-row--wide', 'privacy' ),
			'label'         => '<span class="hc-checkbox-text">' . $regacceptppValue . '</span>',
			'label_class'   => array( 'woocommerce-form__label', 'woocommerce-form__label-for-checkbox' ),
			'input_class'   => array( 'woocommerce-form__input', 'woocommerce-form__input-checkbox' ),
			'required'      => true
		) );
	}
}, 21 ); // With priority 20, it will be shown above Privacy Policy text.

add_filter( 'woocommerce_registration_errors', function( $errors, $username, $email ) {
	// Nonce verification before doing anything
	check_ajax_referer( 'woocommerce-register', 'woocommerce-register-nonce', false );

	// Get the settings array
	global $hc_gems_options;

	if ( !is_admin() && !is_checkout() && isset( $hc_gems_options['regacceptpp'] ) && $hc_gems_options['regacceptpp'] && empty( $_POST['reg_accept_pp'] ) ) {
		$acceptregppError = __( 'Privacy Policy', 'surbma-magyar-woocommerce' );
		/* translators: %s: Field label */
		$acceptregppError = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $acceptregppError ) . '</strong>' ); // phpcs:ignore WordPress.WP.I18n.TextDomainMismatch
		$errors->add( 'reg_accept_pp_error', $acceptregppError );
	}
	return $errors;
}, 10, 3 );

// Extra user metas to save after registration.
add_action( 'user_register', function( $user_id ) {
	// Nonce verification before doing anything
	check_ajax_referer( 'woocommerce-register', 'woocommerce-register-nonce', false );

	if ( !empty( $_POST['reg_accept_pp'] ) ) {
		update_user_meta( $user_id, 'reg_accept_pp', 1 );
	}

	// Get the settings array
	global $hc_gems_options;

	$regipValue = isset( $hc_gems_options['regip'] ) ? $hc_gems_options['regip'] : 0;
	if ( 1 == $regipValue ) {
		// Get real visitor IP behind CloudFlare network
		if ( isset( $_SERVER['HTTP_CF_CONNECTING_IP'] ) ) {
			$_SERVER['REMOTE_ADDR'] = filter_var( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ), FILTER_VALIDATE_IP );
			$_SERVER['HTTP_CLIENT_IP'] = filter_var( wp_unslash( $_SERVER['HTTP_CF_CONNECTING_IP'] ), FILTER_VALIDATE_IP );
		}
		$remote = isset( $_SERVER['REMOTE_ADDR'] ) ? filter_var( wp_unslash( $_SERVER['REMOTE_ADDR'] ), FILTER_VALIDATE_IP ) : '';
		$client = isset( $_SERVER['HTTP_CLIENT_IP'] ) ? filter_var( wp_unslash( $_SERVER['HTTP_CLIENT_IP'] ), FILTER_VALIDATE_IP ) : '';
		$forward = isset( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ? filter_var( wp_unslash( $_SERVER['HTTP_X_FORWARDED_FOR'] ), FILTER_VALIDATE_IP ) : '';

		if ( $remote ) {
			$ip = $remote;
		} elseif ( $client ) {
			$ip = $client;
		} else {
			$ip = $forward;
		}
		update_user_meta( $user_id, 'reg_ip', $ip );
	}
}, 10, 1 );

// Let's show the registration extra user meta values in admin.
add_action( 'personal_options', function( $profileuser ) {
	$regacceptpp = get_the_author_meta( 'reg_accept_pp', $profileuser->ID ) == 1 ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : esc_html__( 'Not accepted', 'surbma-magyar-woocommerce' );
	$regdate = gmdate( 'r', strtotime( $profileuser->user_registered ) ) ? gmdate( 'r', strtotime( $profileuser->user_registered ) ) : esc_html__( 'Date is not available', 'surbma-magyar-woocommerce' );
	$regip = get_the_author_meta( 'reg_ip', $profileuser->ID ) ? get_the_author_meta( 'reg_ip', $profileuser->ID ) : esc_html__( 'IP address is not available', 'surbma-magyar-woocommerce' );
	?>
	<table class="form-table">
		<tr>
			<th><?php esc_html_e( 'Registration information', 'surbma-magyar-woocommerce' ); ?></th>
			<td>
				<p><strong><?php esc_html_e( 'Privacy Policy', 'surbma-magyar-woocommerce' ); ?>:</strong> <?php echo esc_html( $regacceptpp ); ?></p>
				<p><strong><?php esc_html_e( 'Registration date', 'surbma-magyar-woocommerce' ); ?>:</strong> <?php echo esc_html( $regdate ); ?></p>
				<p><strong><?php esc_html_e( 'Registration IP address', 'surbma-magyar-woocommerce' ); ?>:</strong> <?php echo esc_html( $regip ); ?></p>
			</td>
		</tr>
	</table>
<?php
}, 99, 1 );

// Let's show the registration extra user meta values on front-end account page.
add_action( 'woocommerce_edit_account_form', function() {
	$user_id = get_current_user_id();
	$user = get_userdata( $user_id );

	if ( !$user ) {
		return;
	}

	$regacceptpp = get_user_meta( $user_id, 'reg_accept_pp', true ) == 1 ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : esc_html__( 'Not accepted', 'surbma-magyar-woocommerce' );
	$regdate = gmdate( 'r', strtotime( $user->user_registered ) ) ? gmdate( 'r', strtotime( $user->user_registered ) ) : esc_html__( 'Date is not available', 'surbma-magyar-woocommerce' );
	$regip = get_user_meta( $user_id, 'reg_ip', true ) ? get_user_meta( $user_id, 'reg_ip', true ) : esc_html__( 'IP address is not available', 'surbma-magyar-woocommerce' );
	?>
	<fieldset class="hc-reg-fields">
		<legend><?php esc_html_e( 'Registration information', 'surbma-magyar-woocommerce' ); ?></legend>
		<p><?php esc_html_e( 'These fields are read-only, you can not modify them.', 'surbma-magyar-woocommerce' ); ?></p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="reg_accept_pp"><?php esc_html_e( 'Privacy Policy', 'surbma-magyar-woocommerce' ); ?>:</label>
			<input type="text" name="reg_accept_pp" value="<?php echo esc_attr( $regacceptpp ); ?>" class="input-text" readonly />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="reg_date"><?php esc_html_e( 'Registration date', 'surbma-magyar-woocommerce' ); ?>:</label>
			<input type="text" name="reg_date" value="<?php echo esc_attr( $regdate ); ?>" class="input-text" readonly />
		</p>
		<p class="woocommerce-form-row woocommerce-form-row--wide form-row form-row-wide">
			<label for="reg_ip"><?php esc_html_e( 'Registration IP address', 'surbma-magyar-woocommerce' ); ?>:</label>
			<input type="text" name="reg_ip" value="<?php echo esc_attr( $regip ); ?>" class="input-text" readonly />
		</p>
	</fieldset>
<?php
}, 10 );

// Disable WooCommerce default Terms & Conditions fields on Checkout page
add_action( 'init', function() {
	if ( ! is_admin() ) {
		add_filter( 'woocommerce_checkout_show_terms', '__return_false' );
	}
} );

// Get the position for the Terms & Conditions fields on Checkout page
$legalconfirmationsposition = $hc_gems_options['legalconfirmationsposition'] ?? 'woocommerce_review_order_before_submit';

// Show our Terms & Conditions fields on Checkout page
add_action( $legalconfirmationsposition, function( $checkout = '' ) {
	if ( ! $checkout ) {
		$checkout = WC()->checkout();
	}

	// Get the settings array
	global $hc_gems_options;

	$legalcheckouttitleValue = isset( $hc_gems_options['legalcheckouttitle'] ) ? $hc_gems_options['legalcheckouttitle'] : esc_html__( 'Legal confirmations', 'surbma-magyar-woocommerce' );
	$legalcheckouttextValue = isset( $hc_gems_options['legalcheckouttext'] ) ? $hc_gems_options['legalcheckouttext'] : '';
	$legalconfirmationsposition = isset( $hc_gems_options['legalconfirmationsposition'] ) ? $hc_gems_options['legalconfirmationsposition'] : 'woocommerce_review_order_before_submit';
	$accepttosValue = isset( $hc_gems_options['accepttos'] ) ? wp_kses_post( wp_unslash( $hc_gems_options['accepttos'] ) ) : esc_html__( 'I\'ve read and accept the <a href="/tos/" target="_blank">Terms of Service</a>', 'surbma-magyar-woocommerce' );
	$acceptppValue = isset( $hc_gems_options['acceptpp'] ) ? wp_kses_post( wp_unslash( $hc_gems_options['acceptpp'] ) ) : esc_html__( 'I\'ve read and accept the <a href="/privacy-policy/" target="_blank">Privacy Policy</a>', 'surbma-magyar-woocommerce' );
	$acceptcustom1Value = isset( $hc_gems_options['acceptcustom1'] ) ? wp_kses_post( wp_unslash( $hc_gems_options['acceptcustom1'] ) ) : '';
	$legalcheckout_custom1optionalValue = isset( $hc_gems_options['legalcheckout-custom1optional'] ) && 1 == $hc_gems_options['legalcheckout-custom1optional'] ? false : true;
	$acceptcustom2Value = isset( $hc_gems_options['acceptcustom2'] ) ? wp_kses_post( wp_unslash( $hc_gems_options['acceptcustom2'] ) ) : '';
	$legalcheckout_custom2optionalValue = isset( $hc_gems_options['legalcheckout-custom2optional'] ) && 1 == $hc_gems_options['legalcheckout-custom2optional'] ? false : true;

	echo '<div id="surbma_hc_legal_checkout">';

	if ( $legalcheckouttitleValue ) {
		if ( 'woocommerce_review_order_before_submit' == $legalconfirmationsposition ) {
			$legalcheckouttitleValue = '<p id="surbma_hc_legal_checkout_title"><strong>' . $legalcheckouttitleValue . '</strong></p>';
		} else {
			$legalcheckouttitleValue = '<h3 id="surbma_hc_legal_checkout_title">' . $legalcheckouttitleValue . '</h3>';
		}
		echo wp_kses_post( $legalcheckouttitleValue );
	}

	if ( $legalcheckouttextValue ) {
		echo '<p id="surbma_hc_legal_checkout_text">' . wp_kses_post( $legalcheckouttextValue ) . '</p>';
	}

	if ( $accepttosValue ) {
		woocommerce_form_field( 'accept_tos', array(
			'type'          => 'checkbox',
			'class'         => array( 'form-row-wide', 'woocommerce-form-row', 'woocommerce-form-row--wide', 'tos' ),
			'label'         => '<span class="hc-checkbox-text">' . $accepttosValue . '</span>',
			'label_class'   => array( 'woocommerce-form__label', 'woocommerce-form__label-for-checkbox' ),
			'input_class'   => array( 'woocommerce-form__input', 'woocommerce-form__input-checkbox' ),
			'required'      => true
		), $checkout->get_value( 'accept_tos' ));
	}

	if ( $acceptppValue ) {
		woocommerce_form_field( 'accept_pp', array(
			'type'          => 'checkbox',
			'class'         => array( 'form-row-wide', 'woocommerce-form-row', 'woocommerce-form-row--wide', 'pp' ),
			'label'         => '<span class="hc-checkbox-text">' . $acceptppValue . '</span>',
			'label_class'   => array( 'woocommerce-form__label', 'woocommerce-form__label-for-checkbox' ),
			'input_class'   => array( 'woocommerce-form__input', 'woocommerce-form__input-checkbox' ),
			'required'      => true
		), $checkout->get_value( 'accept_pp' ) );
	}

	if ( $acceptcustom1Value ) {
		woocommerce_form_field( 'accept_custom1', array(
			'type'          => 'checkbox',
			'class'         => array( 'form-row-wide', 'woocommerce-form-row', 'woocommerce-form-row--wide', 'custom1' ),
			'label'         => '<span class="hc-checkbox-text">' . $acceptcustom1Value . '</span>',
			'label_class'   => array( 'woocommerce-form__label', 'woocommerce-form__label-for-checkbox' ),
			'input_class'   => array( 'woocommerce-form__input', 'woocommerce-form__input-checkbox' ),
			'required'      => $legalcheckout_custom1optionalValue
		), $checkout->get_value( 'accept_custom1' ) );
	}

	if ( $acceptcustom2Value ) {
		woocommerce_form_field( 'accept_custom2', array(
			'type'          => 'checkbox',
			'class'         => array( 'form-row-wide', 'woocommerce-form-row', 'woocommerce-form-row--wide', 'custom2' ),
			'label'         => '<span class="hc-checkbox-text">' . $acceptcustom2Value . '</span>',
			'label_class'   => array( 'woocommerce-form__label', 'woocommerce-form__label-for-checkbox' ),
			'input_class'   => array( 'woocommerce-form__input', 'woocommerce-form__input-checkbox' ),
			'required'      => $legalcheckout_custom2optionalValue
		), $checkout->get_value( 'accept_custom2' ) );
	}

	echo '</div>';
} );

add_action( 'woocommerce_checkout_process', function() {
	// Nonce verification before doing anything
	check_ajax_referer( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce', false );

	// Get the settings array
	global $hc_gems_options;

	$legalcheckout_custom1optionalValue = isset( $hc_gems_options['legalcheckout-custom1optional'] ) && 1 == $hc_gems_options['legalcheckout-custom1optional'] ? false : true;
	$legalcheckout_custom2optionalValue = isset( $hc_gems_options['legalcheckout-custom2optional'] ) && 1 == $hc_gems_options['legalcheckout-custom2optional'] ? false : true;

	if ( isset( $hc_gems_options['accepttos'] ) && $hc_gems_options['accepttos'] && empty( $_POST['accept_tos'] ) ) {
		$accepttosError = __( 'Terms of Service', 'surbma-magyar-woocommerce' );
		/* translators: %s: Field label */
		$accepttosError = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $accepttosError ) . '</strong>' ); // phpcs:ignore WordPress.WP.I18n.TextDomainMismatch
		wc_add_notice( $accepttosError, 'error' );
	}

	if ( isset( $hc_gems_options['acceptpp'] ) && $hc_gems_options['acceptpp'] && empty( $_POST['accept_pp'] ) ) {
		$acceptppError = __( 'Privacy Policy', 'surbma-magyar-woocommerce' );
		/* translators: %s: Field label */
		$acceptppError = sprintf( __( '%s is a required field.', 'woocommerce' ), '<strong>' . esc_html( $acceptppError ) . '</strong>' ); // phpcs:ignore WordPress.WP.I18n.TextDomainMismatch
		wc_add_notice( $acceptppError, 'error' );
	}

	if ( $legalcheckout_custom1optionalValue && isset( $hc_gems_options['acceptcustom1'] ) && $hc_gems_options['acceptcustom1'] && isset( $hc_gems_options['acceptcustom1label'] ) && $hc_gems_options['acceptcustom1label'] && empty( $_POST['accept_custom1'] ) ) {
		$custom1errormessage = '<strong>' . $hc_gems_options['acceptcustom1label'] . '</strong> ' . esc_html__( 'is a required field.', 'surbma-magyar-woocommerce' );
		wc_add_notice( $custom1errormessage, 'error' );
	}

	if ( $legalcheckout_custom2optionalValue && isset( $hc_gems_options['acceptcustom2'] ) && $hc_gems_options['acceptcustom2'] && isset( $hc_gems_options['acceptcustom2label'] ) && $hc_gems_options['acceptcustom2label'] && empty( $_POST['accept_custom2'] ) ) {
		$custom2errormessage = '<strong>' . $hc_gems_options['acceptcustom2label'] . '</strong> ' . esc_html__( 'is a required field.', 'surbma-magyar-woocommerce' );
		wc_add_notice( $custom2errormessage, 'error' );
	}
} );

add_action( 'woocommerce_checkout_create_order', function( $order ) {
	// Nonce verification before doing anything
	check_ajax_referer( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce', false );

	if ( !empty( $_POST['accept_tos'] ) ) {
		$order->add_meta_data( 'accept_tos', true, true );
	}

	if ( !empty( $_POST['accept_pp'] ) ) {
		$order->add_meta_data( 'accept_pp', true, true );
	}

	if ( !empty( $_POST['accept_custom1'] ) ) {
		$order->add_meta_data( 'accept_custom1', true, true );
	}

	if ( !empty( $_POST['accept_custom2'] ) ) {
		$order->add_meta_data( 'accept_custom2', true, true );
	}
} );

add_action( 'woocommerce_admin_order_data_after_billing_address', function( $order ) {
	// Get the settings array
	global $hc_gems_options;

	$acceptcustom1labelValue = isset( $hc_gems_options['acceptcustom1label'] ) && $hc_gems_options['acceptcustom1label'] ? $hc_gems_options['acceptcustom1label'] : __( 'Custom 1 checkbox', 'surbma-magyar-woocommerce' );
	$acceptcustom2labelValue = isset( $hc_gems_options['acceptcustom2label'] ) && $hc_gems_options['acceptcustom2label'] ? $hc_gems_options['acceptcustom2label'] : __( 'Custom 2 checkbox', 'surbma-magyar-woocommerce' );

	$accepttos = $order->get_meta( 'accept_tos', true ) ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : false;
	$acceptpp = $order->get_meta( 'accept_pp', true ) ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : false;
	$acceptcustom1 = $order->get_meta( 'accept_custom1', true ) ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : false;
	$acceptcustom2 = $order->get_meta( 'accept_custom2', true ) ? esc_html__( 'Accepted', 'surbma-magyar-woocommerce' ) : false;

	if ( $accepttos ) {
		echo '<p><strong>' . esc_html__( 'Terms of Service', 'surbma-magyar-woocommerce' ) . ':</strong> ' . esc_html( $accepttos ) . '</p>';
	}
	if ( $acceptpp ) {
		echo '<p><strong>' . esc_html__( 'Privacy Policy', 'surbma-magyar-woocommerce' ) . ':</strong> ' . esc_html( $acceptpp ) . '</p>';
	}
	if ( $acceptcustom1 ) {
		echo '<p><strong>' . esc_html( $acceptcustom1labelValue ) . ':</strong> ' . esc_html( $acceptcustom1 ) . '</p>';
	}
	if ( $acceptcustom2 ) {
		echo '<p><strong>' . esc_html( $acceptcustom2labelValue ) . ':</strong> ' . esc_html( $acceptcustom2 ) . '</p>';
	}
}, 10, 1 );

add_action( 'woocommerce_review_order_before_submit', function() {
	// Get the settings array
	global $hc_gems_options;

	$beforeorderbuttonmessageValue = isset( $hc_gems_options['beforeorderbuttonmessage'] ) ? wp_unslash( $hc_gems_options['beforeorderbuttonmessage'] ) : '';

	if ( $beforeorderbuttonmessageValue ) {
		echo '<div class="surbma-hc-before-submit" style="margin: 0 0 1em;text-align: center;">' . wp_kses_post( $beforeorderbuttonmessageValue ) . '</div>';
	}
} );

add_action( 'woocommerce_review_order_after_submit', function() {
	// Get the settings array
	global $hc_gems_options;

	$afterorderbuttonmessageValue = isset( $hc_gems_options['afterorderbuttonmessage'] ) ? wp_unslash( $hc_gems_options['afterorderbuttonmessage'] ) : '';

	if ( $afterorderbuttonmessageValue ) {
		echo '<div class="surbma-hc-before-submit" style="margin: 1em 0 0;text-align: center;">' . wp_kses_post( $afterorderbuttonmessageValue ) . '</div>';
	}
} );
