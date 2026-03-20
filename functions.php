<?php 
function mytheme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 250,
        'width'       => 250,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'mytheme'),
    ));
}
add_action('after_setup_theme', 'mytheme_setup');

// Add nav-item class to WordPress menu items for CSS compatibility
function mytheme_add_menu_class($classes, $item, $args) {
    if (isset($args->theme_location) && $args->theme_location == 'primary-menu') {
        $classes[] = 'nav-item';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'mytheme_add_menu_class', 1, 3);

function mytheme_styles() {
    // Google Fonts
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@700&display=swap', array(), null);
    
    // Main Styles
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_styles');

function mytheme_scripts() {
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mytheme_scripts');

function mytheme_default_menu() {
    ?>
    <ul class="nav-menu">
        <li class="nav-item">
            <a href="#">Why <?php echo esc_html(get_bloginfo('name') ? get_bloginfo('name') : 'Synopsys'); ?> <span style="font-size: 0.6rem;">▼</span></a>
            <div class="mega-menu">
                <div>
                    <h4>Our Company</h4>
                    <ul>
                        <li><a href="#">Careers</a></li>
                        <li><a href="#">Ecosystem Partners</a></li>
                        <li><a href="#">Global Offices</a></li>
                        <li><a href="#">Investors</a></li>
                        <li><a href="#">Leadership</a></li>
                    </ul>
                </div>
                <div class="featured-content">
                    <h4>Why <?php echo esc_html(get_bloginfo('name') ? get_bloginfo('name') : 'Synopsys'); ?>?</h4>
                    <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">Our Technology, Your Innovation™. Trusted industry leader.</p>
                    <a href="#" style="color: var(--secondary); font-weight: 600;">Learn more &rarr;</a>
                </div>
            </div>
        </li>
        <li class="nav-item"><a href="#">Solutions</a></li>
        <li class="nav-item"><a href="#">Products</a></li>
        <li class="nav-item"><a href="#">Resources</a></li>
    </ul>
    <?php
}
?>
