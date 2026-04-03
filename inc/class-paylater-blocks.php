<?php
/**
 * WooCommerce Blocks Support for "Pay Later / Contact Us" Gateway
 * This registers the custom gateway with the WooCommerce Blocks Checkout API
 * so it appears in the Blocks-based checkout without errors.
 */

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

final class Mytheme_PayLater_Blocks_Support extends AbstractPaymentMethodType {

    protected $name = 'mytheme_paylater';

    public function initialize() {
        $this->settings = get_option('woocommerce_mytheme_paylater_settings', []);
    }

    public function is_active(): bool {
        return true; // Always active
    }

    public function get_payment_method_script_handles(): array {
        // Register a tiny inline script so Blocks can register this gateway client-side
        wp_register_script(
            'mytheme-paylater-blocks',
            '',   // No external file needed — inline script below
            ['wc-blocks-registry', 'wc-settings', 'wp-element'],
            null,
            true
        );

        wp_add_inline_script(
            'mytheme-paylater-blocks',
            "
            ( function( wc, wcSettings, wp ) {
                var settings = wcSettings.getSetting( 'mytheme_paylater_data', {} );
                var label = wp.element.createElement(
                    'span',
                    null,
                    ( settings.title || 'Pay Later — We Will Contact You' )
                );
                var Content = function() {
                    return wp.element.createElement(
                        'p',
                        { style: { color: '#555', fontSize: '0.95rem', margin: '8px 0' } },
                        ( settings.description || 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे।' )
                    );
                };
                var PayLaterPaymentMethod = {
                    name: 'mytheme_paylater',
                    label: label,
                    content: wp.element.createElement( Content, null ),
                    edit: wp.element.createElement( Content, null ),
                    canMakePayment: function() { return true; },
                    ariaLabel: ( settings.title || 'Pay Later' ),
                    supports: { features: settings.supports || [] }
                };
                wc.blocksRegistry.registerPaymentMethod( PayLaterPaymentMethod );
            } )( window.wc, window.wcSettings, window.wp );
            "
        );

        return ['mytheme-paylater-blocks'];
    }

    public function get_payment_method_data(): array {
        return [
            'title'       => $this->get_setting('title', 'Pay Later — We Will Contact You'),
            'description' => $this->get_setting('description', 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे। (We will contact you shortly for payment details.)'),
            'supports'    => ['products'],
        ];
    }
}
