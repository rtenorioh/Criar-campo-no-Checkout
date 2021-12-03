add_action( 'woocommerce_after_order_notes', 'novo_campo_woocommerce' );
	function novo_campo_woocommerce( $checkout ) {
		echo '<div style="visibility: hidden;" id="novo_campo_woocommerce">';
		woocommerce_form_field(
			'billing_ibge',
			array(
				'type' => 'text',
				'class' => array('novo_campo form-row-wide'),
				'label' => __('IBGE'),
				'placeholder' => __(''),
			),
			$checkout->get_value( 'billing_ibge' )
		); 
		echo '</div>'; 
	}

add_action('woocommerce_checkout_process', 'validar_novo_campo_woocommerce');
	function validar_novo_campo_woocommerce() {
		if (
			empty( $_POST['billing_ibge'])
		)
		 wc_add_notice(
			__( 'Por favor, digite novamente seu CEP.'),
		'error'
		);
	}

add_action( 'woocommerce_checkout_update_order_meta', 'novo_campo_checkout_order' );
	function novo_campo_checkout_order( $order_id ) {
		if ( ! empty( $_POST['billing_ibge'] ) ) {
			update_post_meta(
				$order_id,
				IBGE,
				sanitize_text_field( $_POST['billing_ibge'] ) 
			); 
		}
	}

add_action( 'woocommerce_admin_order_data_after_billing_address', 'mostrar_novo_campo', 10, 1 );
	function mostrar_novo_campo($order){
		echo '<p><strong>'.__( 'billing_ibge').':</strong> ' . get_post_meta( $order->id, 'IBGE', true ) . '</p>';
	}
