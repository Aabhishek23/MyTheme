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
    'container' => false,
    'menu_class' => 'nav-menu',
    'fallback_cb' => 'mytheme_default_menu', // Use a function to show the hardcoded menu
));
?>
        </nav>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="#" style="font-size: 1.2rem;">🔍</a>
            <a href="#" class="contact-btn">Contact Sales</a>
        </div>
    </div>
</header>
