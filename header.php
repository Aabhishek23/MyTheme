<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="main-header">
    <div class="container header-content">
        <div class="logo">
            <?php
if (has_custom_logo()) {
    the_custom_logo();
}
else {
    echo '<a href="' . esc_url(home_url('/')) . '" rel="home"><strong>' . (get_bloginfo('name') ? esc_html(get_bloginfo('name')) : 'SYNOPSYS') . '</strong><span style="font-weight: 300;">®</span></a>';
}
?>
        </div>
        <nav>
            <?php
wp_nav_menu(array(
    'theme_location' => 'primary-menu',
    'container'      => false,
    'menu_class'     => 'nav-menu',
    'fallback_cb'    => 'mytheme_default_menu',
));
?>
        </nav>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <?php if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout())) : ?>
                <a href="<?php echo wc_get_cart_url(); ?>" class="header-cart" title="Aapka Shopping Cart">
                    <span style="font-size: 1.2rem;">🛒</span>
                    <span class="cart-count"><?php echo is_object(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0; ?></span>
                </a>
            <?php endif; ?>
            <?php if (is_user_logged_in()) : 
                $current_user = wp_get_current_user();
                $account_url  = get_permalink(get_option('mytheme_account_page_id')) ?: get_permalink(get_page_by_path('my-account'));
            ?>
                <div class="header-user-menu">
                    <button class="header-user-btn" id="userMenuToggle">
                        <span class="user-avatar">👤</span>
                        <span class="user-name"><?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?></span>
                        <span style="font-size:0.6rem;">▼</span>
                    </button>
                    <div class="header-user-dropdown" id="userDropdown">
                        <a href="<?php echo esc_url($account_url ?: '#'); ?>">👤 My Account</a>
                        <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">📦 Mere Orders</a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>">🛒 Checkout</a>
                        <?php endif; ?>
                        <div class="user-dropdown-divider"></div>
                        <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="user-logout">🚪 Logout</a>
                    </div>
                </div>
            <?php else :
                $login_url = get_permalink(get_option('mytheme_account_page_id')) ?: get_permalink(get_page_by_path('my-account'));
                if (!$login_url) $login_url = wp_login_url();
            ?>
                <a href="<?php echo esc_url($login_url); ?>" class="header-login-btn">
                    Login
                </a>
            <?php endif; ?>
            <a href="#" class="contact-btn">Contact Sales</a>
        </div>
        <script>
        (function() {
            var btn = document.getElementById('userMenuToggle');
            var dd  = document.getElementById('userDropdown');
            if (btn && dd) {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    dd.classList.toggle('open');
                });
                document.addEventListener('click', function() { dd.classList.remove('open'); });
            }
        })();
        </script>

    </div>
</header>
