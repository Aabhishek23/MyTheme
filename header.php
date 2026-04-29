<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#7c3aed">
    <script>
        // Polyfill for Reddit tracking to prevent Uncaught Errors
        !function(w){if(!w.rdt){var p=w.rdt=function(){p.sendEvent?p.sendEvent.apply(p,arguments):p.callQueue.push(arguments)};p.callQueue=[];}}(window);
        // Polyfill for Snapchat tracking to prevent Uncaught Errors
        !function(e){if(!e.snaptr){var a=e.snaptr=function(){a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};a.queue=[];}}(window);
    </script>
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
    echo '<a href="' . esc_url(home_url('/')) . '" rel="home"><strong>' . (get_bloginfo('name') ? esc_html(get_bloginfo('name')) : 'AIPL') . '</strong><span style="font-weight: 300;">®</span></a>';
}
?>
        </div>
        <?php if (class_exists('WooCommerce') && (is_woocommerce() || is_cart() || is_checkout() || is_product())) : ?>
            <a href="<?php echo wc_get_cart_url(); ?>" class="mobile-header-cart" title="View your shopping cart">
                <span class="cart-icon">🛒</span>
                <span class="cart-count"><?php echo is_object(WC()->cart) ? WC()->cart->get_cart_contents_count() : 0; ?></span>
            </a>
        <?php endif; ?>
        <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="Toggle Menu">
            ☰
        </button>
        <nav id="siteNav">
            <button class="mobile-close-btn" id="mobileCloseBtn" aria-label="Close Menu">&times;</button>
            <?php
wp_nav_menu(array(
    'theme_location' => 'primary-menu',
    'container'      => false,
    'menu_class'     => 'nav-menu',
    'fallback_cb'    => 'mytheme_default_menu',
));
?>
            <div class="header-right-actions" id="headerActions">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="header-cart" title="View your shopping cart">
                        <span class="cart-icon">🛒</span>
                        <span class="cart-label">My Cart</span>
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
                            <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>">📦 My Orders</a>
                            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>">🛒 Checkout</a>
                            <a href="<?php echo esc_url(home_url('/track-application/')); ?>">💼 Job Status</a>
                            <?php endif; ?>
                            <div class="user-dropdown-divider"></div>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="user-logout">🚪 Logout</a>
                        </div>
                    </div>
                    <div class="header-mobile-user-links">
                        <a href="<?php echo esc_url($account_url ?: '#'); ?>" class="header-user-link">👤 My Account</a>
                        <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="header-user-link">📦 My Orders</a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="header-user-link">🛒 Checkout</a>
                        <a href="<?php echo esc_url(home_url('/track-application/')); ?>" class="header-user-link">💼 Job Status</a>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="header-logout-btn">
                        🚪 Logout
                    </a>
                <?php else :
                    $login_url = get_permalink(get_option('mytheme_account_page_id')) ?: get_permalink(get_page_by_path('my-account'));
                    if (!$login_url) $login_url = wp_login_url();
                ?>
                    <a href="<?php echo esc_url($login_url); ?>" class="header-login-btn">
                        👤 Login
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact-us')) ?: home_url('/contact-us/')); ?>" class="contact-btn">Contact Us</a>
            </div>
        </nav>
        <div class="mobile-overlay" id="mobileOverlay"></div>
    </div>
</header>
