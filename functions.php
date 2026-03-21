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
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@700&family=Roboto:wght@400;500;700&display=swap', array(), null);
    
    // Main Styles
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_styles');

function mytheme_scripts() {
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mytheme_scripts');

function mytheme_admin_scripts($hook) {
    if ('nav-menus.php' === $hook) {
        wp_enqueue_media();
    }
}
add_action('admin_enqueue_scripts', 'mytheme_admin_scripts');

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
        <li class="nav-item mega">
            <a href="#">Solutions <span style="font-size: 0.6rem;">▼</span></a>
            <div class="mega-menu">
                <div class="mega-column">
                    <h4>Industry</h4>
                    <ul>
                        <li><a href="#"><span>✈️</span> Aerospace & Government</a></li>
                        <li><a href="#"><span>📟</span> AI Chip Development</a></li>
                        <li><a href="#"><span>🚗</span> Automotive</a></li>
                        <li><a href="#"><span>☁️</span> Edge AI</a></li>
                        <li><a href="#"><span>🖥️</span> HPC & Data Center</a></li>
                        <li><a href="#"><span>📱</span> Mobile</a></li>
                    </ul>
                </div>
                <div class="mega-column">
                    <h4>Technology</h4>
                    <ul>
                        <li><a href="#"><span>🧠</span> Artificial Intelligence</a></li>
                        <li><a href="#"><span>🌐</span> Cloud</a></li>
                        <li><a href="#"><span>🧊</span> Electronics Digital Twins</a></li>
                        <li><a href="#"><span>⚡</span> Energy-Efficient SoCs</a></li>
                        <li><a href="#"><span>📦</span> Multi-Die</a></li>
                        <li><a href="#"><span>👁️</span> Photonics & Optics</a></li>
                    </ul>
                </div>
                <div class="featured-content">
                    <img src="https://via.placeholder.com/400x250" alt="Featured Content">
                    <h4>Navigating Software-Defined Vehicle Development</h4>
                    <p>Discover strategies to boost SDV innovation, reduce costs, and enhance reliability.</p>
                    <a href="#" style="color: #5d3fd3; font-weight: 600;">Download &rarr;</a>
                </div>
            </div>
        </li>
        <li class="nav-item"><a href="#">Products</a></li>
        <li class="nav-item"><a href="#">Resources</a></li>
    </ul>
    <?php
}

/**
 * Add Hero Section Settings to Customizer
 */
function mytheme_customize_register($wp_customize) {
    // Add Hero Section
    $wp_customize->add_section('hero_section', array(
        'title'    => __('Hero Section Settings', 'mytheme'),
        'priority' => 30,
    ));

    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => 'Innovation for the AI Era',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('hero_subtitle', array(
        'label'    => __('Hero Subtitle', 'mytheme'),
        'section'  => 'hero_section',
        'type'     => 'text',
    ));

    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => 'Introducing Hardware-Assisted Verification',
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('hero_title', array(
        'label'    => __('Hero Title', 'mytheme'),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));

    // Hero Description
    $wp_customize->add_setting('hero_description', array(
        'default'           => 'Powering the era of pervasive intelligence from silicon to systems with industry-leading EDA tools.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('hero_description', array(
        'label'    => __('Hero Description', 'mytheme'),
        'section'  => 'hero_section',
        'type'     => 'textarea',
    ));
}
add_action('customize_register', 'mytheme_customize_register');

/**
 * Register Hero Slides Custom Post Type
 */
function mytheme_register_hero_cpt() {
    $labels = array(
        'name'               => _x('Hero Slides', 'post type general name', 'mytheme'),
        'singular_name'      => _x('Hero Slide', 'post type singular name', 'mytheme'),
        'menu_name'          => _x('Hero Slides', 'admin menu', 'mytheme'),
        'name_admin_bar'     => _x('Hero Slide', 'add new on admin bar', 'mytheme'),
        'add_new'            => _x('Add New', 'slide', 'mytheme'),
        'add_new_item'       => __('Add New Hero Slide', 'mytheme'),
        'new_item'           => __('New Hero Slide', 'mytheme'),
        'edit_item'          => __('Edit Hero Slide', 'mytheme'),
        'view_item'          => __('View Hero Slide', 'mytheme'),
        'all_items'          => __('All Hero Slides', 'mytheme'),
        'search_items'       => __('Search Hero Slides', 'mytheme'),
        'not_found'          => __('No slides found.', 'mytheme'),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array('slug' => 'hero-slide'),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 5,
        'menu_icon'          => 'dashicons-images-alt2',
        'supports'           => array('title', 'editor', 'thumbnail', 'custom-fields'),
    );

    register_post_type('hero_slide', $args);
}
add_action('init', 'mytheme_register_hero_cpt');

/**
 * Add custom "Menu Icon" field to the Menu editor (Appearance > Menus)
 */
function mytheme_add_menu_icon_field($item_id, $item, $args, $depth) {
    ?>
    <p class="field-custom-icon description-wide" style="margin: 10px 0;">
        <label for="edit-menu-item-custom-icon-<?php echo $item_id; ?>">
            <?php _e('Menu Icon (Emoji or Icon Name)', 'mytheme'); ?><br />
            <div style="display: flex; gap: 5px; margin-top: 5px;">
                <input type="text" id="edit-menu-item-custom-icon-<?php echo $item_id; ?>" 
                       class="widefat code edit-menu-item-custom-icon" 
                       name="menu-item-custom-icon[<?php echo $item_id; ?>]" 
                       value="<?php echo esc_attr(get_post_meta($item_id, '_menu_item_custom_icon', true)); ?>" 
                       placeholder="e.g. 🧠 or ☁️" />
                <button type="button" class="button custom-icon-upload-button" data-id="<?php echo $item_id; ?>">Select</button>
            </div>
        </label>
        <span class="description" style="font-size: 11px; color: #666;">Add an icon/emoji or click "Select" to upload an image.</span>
    </p>
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'mytheme_add_menu_icon_field', 10, 4);

/**
 * Save the "Menu Icon" custom field value
 */
function mytheme_update_menu_icon_meta($menu_id, $menu_item_db_id, $args) {
    if (isset($_POST['menu-item-custom-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_custom_icon', $_POST['menu-item-custom-icon'][$menu_item_db_id]);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_custom_icon');
    }
}
add_action('wp_update_nav_menu_item', 'mytheme_update_menu_icon_meta', 10, 3);

/**
 * Filter the menu item title to prepend the saved icon
 */
function mytheme_display_menu_icon($title, $item, $args, $depth) {
    $icon = get_post_meta($item->ID, '_menu_item_custom_icon', true);
    $description = $item->description;
    
    $icon_html = '';
    if (!empty($icon)) {
        // Detect if the icon input is an image URL (PNG, SVG, etc.)
        if (filter_var($icon, FILTER_VALIDATE_URL) || preg_match('/\.(png|svg|jpg|jpeg|webp)$/i', $icon)) {
            $icon_html = '<span class="menu-icon img-icon"><img src="' . esc_url($icon) . '" alt="" style="width: 20px; height: 20px; object-fit: contain;"></span> ';
        } else {
            // Otherwise treat it as it's an emoji/text
            $icon_html = '<span class="menu-icon">' . $icon . '</span> ';
        }
    }
    
    if ($depth === 2 && !empty($description)) {
        // This is a sub-subcategory link (e.g. Fusion Compiler)
        $title = $icon_html . '<div class="menu-label"><span class="menu-title">' . $title . '</span><span class="menu-desc">' . esc_html($description) . '</span></div>';
    } else if ($depth === 1) {
        // This is a Column Header (e.g. EDA, System)
        $title = $icon_html . '<span class="menu-header-text">' . $title . '</span>';
    } else if (!empty($icon)) {
        $title = $icon_html . '<span class="menu-text">' . $title . '</span>';
    }
    
    return $title;
}
add_filter('nav_menu_item_title', 'mytheme_display_menu_icon', 10, 4);

function mytheme_menu_icon_script() {
    $screen = get_current_screen();
    if (!$screen || $screen->id !== 'nav-menus') return;
    ?>
    <script>
    jQuery(document).ready(function($){
        $(document).on('click', '.custom-icon-upload-button', function(e) {
            e.preventDefault();
            var button = $(this);
            var id = button.data('id');
            var custom_uploader = wp.media({
                title: 'Select Icon',
                button: { text: 'Use this icon' },
                multiple: false
            }).on('select', function() {
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                jQuery('#edit-menu-item-custom-icon-' + id).val(attachment.url);
            }).open();
        });
    });
    </script>
    <?php
}
add_action('admin_footer', 'mytheme_menu_icon_script');
?>