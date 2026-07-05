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
            
            <!-- Mobile Drawer Welcome Card -->
            <div class="mobile-welcome-card">
                <div class="mobile-welcome-avatar">
                    <?php if (is_user_logged_in()) : 
                        $current_user = wp_get_current_user();
                        $profile_photo_url = get_user_meta($current_user->ID, '_profile_photo_url', true);
                        if ($profile_photo_url) : ?>
                            <img src="<?php echo esc_url($profile_photo_url); ?>" alt="Avatar" class="welcome-avatar-img">
                        <?php else : 
                            $name_to_use = trim($current_user->first_name . ' ' . $current_user->last_name) ?: $current_user->display_name;
                            $initial = strtoupper(substr($name_to_use ?: $current_user->user_login, 0, 1));
                            ?>
                            <div class="welcome-avatar-initial"><?php echo esc_html($initial); ?></div>
                        <?php endif; ?>
                    <?php else : ?>
                        <span class="welcome-avatar-logo">A</span>
                    <?php endif; ?>
                </div>
                <div class="mobile-welcome-text">
                    <h3>Welcome!</h3>
                    <p><?php echo is_user_logged_in() ? 'Glad to see you here, ' . esc_html($current_user->first_name ?: $current_user->display_name) . '.' : 'Glad to see you here.'; ?></p>
                </div>
            </div>

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
                    
                    // Dynamic avatar display logic
                    $profile_photo_url = get_user_meta($current_user->ID, '_profile_photo_url', true);
                    $avatar_html = '';
                    if ($profile_photo_url) {
                        $avatar_html = '<img src="' . esc_url($profile_photo_url) . '" alt="Avatar" class="header-avatar-img" style="width: 28px; height: 28px; border-radius: 50%; object-fit: cover; margin-right: 6px; border: 1px solid rgba(255,255,255,0.2); vertical-align: middle;">';
                    } else {
                        $name_to_use = trim($current_user->first_name . ' ' . $current_user->last_name) ?: $current_user->display_name;
                        $company_to_use = get_user_meta($current_user->ID, 'billing_company', true) ?: get_user_meta($current_user->ID, '_company_name', true);
                        
                        $initial = '';
                        if ($name_to_use) {
                            $initial = strtoupper(substr($name_to_use, 0, 1));
                        } elseif ($company_to_use) {
                            $initial = strtoupper(substr($company_to_use, 0, 1));
                        } else {
                            $initial = strtoupper(substr($current_user->user_login, 0, 1));
                        }
                        
                        $avatar_html = '<span class="header-avatar-letter" style="width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, #007bff, #00d2ff); color: #fff; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 700; margin-right: 6px; vertical-align: middle; font-family: \'Poppins\', sans-serif;">' . esc_html($initial) . '</span>';
                    }
                ?>
                    <div class="header-user-menu">
                        <button class="header-user-btn" id="userMenuToggle" style="display: flex; align-items: center;">
                            <?php echo $avatar_html; ?>
                            <span class="user-name"><?php echo esc_html($current_user->first_name ?: $current_user->display_name); ?></span>
                            <span style="font-size:0.6rem; margin-left: 4px;">▼</span>
                        </button>
                        <div class="header-user-dropdown" id="userDropdown">
                            <a href="<?php echo esc_url($account_url ?: '#'); ?>"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>My Account</a>
                            <a href="<?php echo esc_url(home_url('/profile-wp.php')); ?>"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Edit Profile</a>
                            <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>My Orders</a>
                            <a href="<?php echo esc_url(wc_get_checkout_url()); ?>"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>Checkout</a>
                            <a href="<?php echo esc_url(home_url('/track-application/')); ?>"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>Job Status</a>
                            <?php endif; ?>
                            <div class="user-dropdown-divider"></div>
                            <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="user-logout"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Logout</a>
                        </div>
                    </div>
                    <div class="header-mobile-user-links">
                        <a href="<?php echo esc_url($account_url ?: '#'); ?>" class="header-user-link"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>My Account</a>
                        <a href="<?php echo esc_url(home_url('/profile-wp.php')); ?>" class="header-user-link"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"></circle><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 1 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path></svg>Edit Profile</a>
                        <?php if (class_exists('WooCommerce')) : ?>
                        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="header-user-link"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>My Orders</a>
                        <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="header-user-link"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>Checkout</a>
                        <a href="<?php echo esc_url(home_url('/track-application/')); ?>" class="header-user-link"><svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>Job Status</a>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="header-logout-btn">
                        <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>Logout
                    </a>
                <?php else :
                    $login_url = get_permalink(get_option('mytheme_account_page_id')) ?: get_permalink(get_page_by_path('my-account'));
                    if (!$login_url) $login_url = wp_login_url();
                ?>
                    <a href="<?php echo esc_url($login_url); ?>" class="header-login-btn">
                        <svg class="dropdown-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 6px;"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>Login
                    </a>
                <?php endif; ?>
                <a href="<?php echo esc_url(get_permalink(get_page_by_path('contact-us')) ?: home_url('/contact-us/')); ?>" class="contact-btn">Contact Us</a>
            </div>
        </nav>
        <div class="mobile-overlay" id="mobileOverlay"></div>
    </div>
</header>
