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
 * Add Hero Section + Mega Menu Featured Panel Settings to Customizer
 */
function mytheme_customize_register($wp_customize) {
    // ── Hero Section ──────────────────────────────────────────────────────────
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

    // ── Pervasive Intelligence Section ─────────────────────────────────────────
    $wp_customize->add_section('pervasive_section', array(
        'title'       => __('Pervasive Intelligence Section', 'mytheme'),
        'description' => __('Settings for the section right below the hero banner.', 'mytheme'),
        'priority'    => 32,
    ));

    // Section Title
    $wp_customize->add_setting('pervasive_title', array(
        'default'           => 'Powering the Era of Pervasive Intelligence from Silicon to Systems',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pervasive_title', array(
        'label'    => __('Section Title', 'mytheme'),
        'section'  => 'pervasive_section',
        'type'     => 'text',
    ));

    // Bullet Points
    $wp_customize->add_setting('pervasive_points', array(
        'default'           => 'Supercharge Productivity • Conquer Complexity • Accelerate Time-to-Market',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('pervasive_points', array(
        'label'    => __('Bullet Points (Separate with the bullet dot •)', 'mytheme'),
        'description' => __('Write your points and separate them using the dot character (•)', 'mytheme'),
        'section'  => 'pervasive_section',
        'type'     => 'text',
    ));

    // Pervasive Image Cards
    $default_titles = ['Synopsys.ai', 'EDA', 'Systems', 'Silicon IP'];
    for ($i = 1; $i <= 4; $i++) {
        // Card Image
        $wp_customize->add_setting("pervasive_card_image_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "pervasive_card_image_$i", array(
            'label'   => sprintf(__('Card %d Image', 'mytheme'), $i),
            'section' => 'pervasive_section',
        )));

        // Card Title
        $wp_customize->add_setting("pervasive_card_title_$i", array(
            'default'           => $default_titles[$i-1],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("pervasive_card_title_$i", array(
            'label'   => sprintf(__('Card %d Title', 'mytheme'), $i),
            'section' => 'pervasive_section',
            'type'    => 'text',
        ));

        // Card Link
        $wp_customize->add_setting("pervasive_card_link_$i", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("pervasive_card_link_$i", array(
            'label'   => sprintf(__('Card %d Link', 'mytheme'), $i),
            'section' => 'pervasive_section',
            'type'    => 'url',
        ));
    }

    // ── Design the Future Section ───────────────────────────────────────────────
    $wp_customize->add_section('design_future_section', array(
        'title'       => __('Design the Future Section', 'mytheme'),
        'description' => __('Settings for the two-column features section.', 'mytheme'),
        'priority'    => 33,
    ));

    $wp_customize->add_setting('design_future_title', array(
        'default'           => 'Design the Future Today with Synopsys',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_title', array(
        'label'    => __('Main Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('design_future_col1_title', array(
        'default'           => 'Industry',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_col1_title', array(
        'label'    => __('Column 1 Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('design_future_col2_title', array(
        'default'           => 'Technology',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_col2_title', array(
        'label'    => __('Column 2 Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    // Items for Design the Future
    $df_defaults = array(
        array('title' => 'AI Chip Development', 'desc' => 'Achieve first-pass silicon success in your AI chip development journey.'),
        array('title' => 'HPC & Data Center', 'desc' => 'Accelerate development of AI, server, edge, networking & storage SoCs.'),
        array('title' => 'Mobile/5G', 'desc' => 'Unleash bandwidth and harness security for a 5G world.'),
        array('title' => 'Automotive', 'desc' => 'Drive the future of software-defined vehicles.'),
        array('title' => 'Artificial Intelligence (AI)', 'desc' => 'Increase silicon performance & accelerate innovation.'),
        array('title' => 'Multi-Die', 'desc' => 'A comprehensive solution for fast heterogeneous integration.'),
        array('title' => 'Energy-Efficient Design', 'desc' => 'End-to-end solution for low power design, verification & IP.'),
        array('title' => 'Memory', 'desc' => 'Next-generation memory solutions.')
    );

    for ($i = 1; $i <= 8; $i++) {
        $col = ($i <= 4) ? 1 : 2;
        $num = ($i <= 4) ? $i : $i - 4;
        
        $wp_customize->add_setting("df_icon_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "df_icon_$i", array(
            'label'   => sprintf(__('Col %d - Item %d Icon', 'mytheme'), $col, $num),
            'section' => 'design_future_section',
        )));

        $wp_customize->add_setting("df_title_$i", array(
            'default'           => $df_defaults[$i-1]['title'],
            'sanitize_callback' => 'sanitize_text_field',
        ));
        $wp_customize->add_control("df_title_$i", array(
            'label'   => sprintf(__('Col %d - Item %d Title', 'mytheme'), $col, $num),
            'section' => 'design_future_section',
            'type'    => 'text',
        ));

        $wp_customize->add_setting("df_desc_$i", array(
            'default'           => $df_defaults[$i-1]['desc'],
            'sanitize_callback' => 'sanitize_textarea_field',
        ));
        $wp_customize->add_control("df_desc_$i", array(
            'label'   => sprintf(__('Col %d - Item %d Description', 'mytheme'), $col, $num),
            'section' => 'design_future_section',
            'type'    => 'textarea',
        ));
        
        $wp_customize->add_setting("df_link_$i", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("df_link_$i", array(
            'label'   => sprintf(__('Col %d - Item %d Link', 'mytheme'), $col, $num),
            'section' => 'design_future_section',
            'type'    => 'url',
        ));
    }

    // ── Mega Menu Featured Panel ──────────────────────────────────────────────
    $wp_customize->add_section('mega_featured_panel', array(
        'title'       => __('🗂️ Mega Menu Featured Panel', 'mytheme'),
        'description' => __('This content appears on the RIGHT side of any menu item that has "Enable Mega Featured Panel" checked (Appearance > Menus).', 'mytheme'),
        'priority'    => 35,
    ));

    // Featured Image
    $wp_customize->add_setting('mega_featured_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'mega_featured_image', array(
        'label'   => __('Featured Image', 'mytheme'),
        'section' => 'mega_featured_panel',
    )));

    // Featured Title
    $wp_customize->add_setting('mega_featured_title', array(
        'default'           => 'Navigating Software-Defined Vehicle Development',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mega_featured_title', array(
        'label'   => __('Featured Title', 'mytheme'),
        'section' => 'mega_featured_panel',
        'type'    => 'text',
    ));

    // Featured Description
    $wp_customize->add_setting('mega_featured_desc', array(
        'default'           => 'Discover strategies to boost SDV innovation, reduce costs, and enhance reliability.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('mega_featured_desc', array(
        'label'   => __('Featured Description', 'mytheme'),
        'section' => 'mega_featured_panel',
        'type'    => 'textarea',
    ));

    // Featured Button Text
    $wp_customize->add_setting('mega_featured_btn_text', array(
        'default'           => 'Download',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('mega_featured_btn_text', array(
        'label'   => __('Button Text', 'mytheme'),
        'section' => 'mega_featured_panel',
        'type'    => 'text',
    ));

    // Featured Button Link
    $wp_customize->add_setting('mega_featured_btn_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('mega_featured_btn_link', array(
        'label'   => __('Button Link (URL)', 'mytheme'),
        'section' => 'mega_featured_panel',
        'type'    => 'url',
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
 * Add custom "Menu Icon" field AND "Enable Mega Featured Panel" checkbox
 * to the Menu editor (Appearance > Menus)
 */
function mytheme_add_menu_icon_field($item_id, $item, $args, $depth) {
    $featured_enabled  = get_post_meta($item_id, '_menu_item_featured_panel', true);
    $feat_image        = get_post_meta($item_id, '_menu_item_feat_image', true);
    $feat_title        = get_post_meta($item_id, '_menu_item_feat_title', true);
    $feat_desc         = get_post_meta($item_id, '_menu_item_feat_desc', true);
    $feat_btn_text     = get_post_meta($item_id, '_menu_item_feat_btn_text', true);
    $feat_btn_link     = get_post_meta($item_id, '_menu_item_feat_btn_link', true);
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

    <?php /* ── Featured Panel Section ─────────────────────────────────────── */ ?>
    <div class="field-featured-panel description-wide" style="margin: 10px 0; padding: 12px; background: #f0f6fc; border-left: 4px solid #2271b1; border-radius: 4px;">

        <p style="margin: 0 0 8px;">
            <label for="edit-menu-item-featured-panel-<?php echo $item_id; ?>" style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: 700; color: #2271b1;">
                <input type="checkbox" 
                       id="edit-menu-item-featured-panel-<?php echo $item_id; ?>" 
                       name="menu-item-featured-panel[<?php echo $item_id; ?>]" 
                       value="1" 
                       <?php checked($featured_enabled, '1'); ?>
                       class="mega-panel-toggle" data-target="mega-fields-<?php echo $item_id; ?>" />
                <?php _e('✨ Enable Mega Featured Panel (right-side card)', 'mytheme'); ?>
            </label>
        </p>

        <div id="mega-fields-<?php echo $item_id; ?>" style="<?php echo ($featured_enabled === '1') ? '' : 'display:none;'; ?> margin-top: 10px; border-top: 1px dashed #b4c9e3; padding-top: 10px;">

            <?php /* Image */ ?>
            <p style="margin: 0 0 8px;">
                <label style="display:block; font-weight:600; margin-bottom:4px; font-size:12px;">📷 <?php _e('Featured Image', 'mytheme'); ?></label>
                <div style="display: flex; gap: 5px;">
                    <input type="text"
                           id="edit-menu-item-feat-image-<?php echo $item_id; ?>"
                           name="menu-item-feat-image[<?php echo $item_id; ?>]"
                           class="widefat"
                           value="<?php echo esc_attr($feat_image); ?>"
                           placeholder="https://..." />
                    <button type="button" class="button feat-image-upload-button" data-id="<?php echo $item_id; ?>">Select</button>
                </div>
            </p>

            <?php /* Title */ ?>
            <p style="margin: 0 0 8px;">
                <label style="display:block; font-weight:600; margin-bottom:4px; font-size:12px;">📝 <?php _e('Featured Title', 'mytheme'); ?></label>
                <input type="text"
                       name="menu-item-feat-title[<?php echo $item_id; ?>]"
                       class="widefat"
                       value="<?php echo esc_attr($feat_title); ?>"
                       placeholder="<?php _e('e.g. Navigating Software-Defined Vehicle…', 'mytheme'); ?>" />
            </p>

            <?php /* Description */ ?>
            <p style="margin: 0 0 8px;">
                <label style="display:block; font-weight:600; margin-bottom:4px; font-size:12px;">📄 <?php _e('Featured Description', 'mytheme'); ?></label>
                <textarea name="menu-item-feat-desc[<?php echo $item_id; ?>]" class="widefat" rows="2"
                          placeholder="<?php _e('Short description…', 'mytheme'); ?>"><?php echo esc_textarea($feat_desc); ?></textarea>
            </p>

            <?php /* Button Text */ ?>
            <p style="margin: 0 0 8px;">
                <label style="display:block; font-weight:600; margin-bottom:4px; font-size:12px;">🔘 <?php _e('Button Text', 'mytheme'); ?></label>
                <input type="text"
                       name="menu-item-feat-btn-text[<?php echo $item_id; ?>]"
                       class="widefat"
                       value="<?php echo esc_attr($feat_btn_text); ?>"
                       placeholder="<?php _e('e.g. Download', 'mytheme'); ?>" />
            </p>

            <?php /* Button Link */ ?>
            <p style="margin: 0 0 0;">
                <label style="display:block; font-weight:600; margin-bottom:4px; font-size:12px;">🔗 <?php _e('Button Link (URL)', 'mytheme'); ?></label>
                <input type="url"
                       name="menu-item-feat-btn-link[<?php echo $item_id; ?>]"
                       class="widefat"
                       value="<?php echo esc_attr($feat_btn_link); ?>"
                       placeholder="https://" />
            </p>

        </div><!-- #mega-fields -->
    </div><!-- .field-featured-panel -->
    <?php
}
add_action('wp_nav_menu_item_custom_fields', 'mytheme_add_menu_icon_field', 10, 4);

/**
 * Save the "Menu Icon", "Featured Panel" toggle, and all per-item featured fields
 */
function mytheme_update_menu_icon_meta($menu_id, $menu_item_db_id, $args) {
    // ── Menu Icon ─────────────────────────────────────────────────────────────
    if (isset($_POST['menu-item-custom-icon'][$menu_item_db_id])) {
        update_post_meta($menu_item_db_id, '_menu_item_custom_icon', $_POST['menu-item-custom-icon'][$menu_item_db_id]);
    } else {
        delete_post_meta($menu_item_db_id, '_menu_item_custom_icon');
    }

    // ── Featured Panel toggle ──────────────────────────────────────────────────
    update_post_meta(
        $menu_item_db_id,
        '_menu_item_featured_panel',
        isset($_POST['menu-item-featured-panel'][$menu_item_db_id]) ? '1' : '0'
    );

    // ── Per-item featured content fields ──────────────────────────────────────
    $fields = array(
        'menu-item-feat-image'    => '_menu_item_feat_image',
        'menu-item-feat-title'    => '_menu_item_feat_title',
        'menu-item-feat-desc'     => '_menu_item_feat_desc',
        'menu-item-feat-btn-text' => '_menu_item_feat_btn_text',
        'menu-item-feat-btn-link' => '_menu_item_feat_btn_link',
    );
    foreach ($fields as $post_key => $meta_key) {
        if (isset($_POST[$post_key][$menu_item_db_id])) {
            update_post_meta($menu_item_db_id, $meta_key, sanitize_text_field($_POST[$post_key][$menu_item_db_id]));
        } else {
            delete_post_meta($menu_item_db_id, $meta_key);
        }
    }
}
add_action('wp_update_nav_menu_item', 'mytheme_update_menu_icon_meta', 10, 3);

/**
 * Add 'mega' class to any top-level menu item that has featured panel enabled
 */
function mytheme_add_mega_class($classes, $item, $args, $depth) {
    if ($depth === 0 && get_post_meta($item->ID, '_menu_item_featured_panel', true) === '1') {
        $classes[] = 'mega';
    }
    return $classes;
}
add_filter('nav_menu_css_class', 'mytheme_add_mega_class', 10, 4);

/**
 * Inject featured-content panel into the sub-menu of enabled top-level items.
 * Hooks into 'wp_nav_menu' to get the full HTML output including the outer <ul>.
 */
function mytheme_inject_featured_panel($nav_menu, $args) {
    // Only run for the primary-menu
    if (!isset($args->theme_location) || $args->theme_location !== 'primary-menu') {
        return $nav_menu;
    }

    // Get all top-level menu items for the primary menu
    $menu_locations = get_nav_menu_locations();
    if (empty($menu_locations['primary-menu'])) return $nav_menu;

    $menu_obj = wp_get_nav_menu_object($menu_locations['primary-menu']);
    if (!$menu_obj) return $nav_menu;

    $menu_items = wp_get_nav_menu_items($menu_obj->term_id);
    if (!$menu_items) return $nav_menu;

    foreach ($menu_items as $menu_item) {
        // Only process top-level items
        if ($menu_item->menu_item_parent != 0) continue;

        $featured_enabled = get_post_meta($menu_item->ID, '_menu_item_featured_panel', true);
        if ($featured_enabled !== '1') continue;

        // Read per-item content
        $feat_image    = get_post_meta($menu_item->ID, '_menu_item_feat_image',    true);
        $feat_title    = get_post_meta($menu_item->ID, '_menu_item_feat_title',    true);
        $feat_desc     = get_post_meta($menu_item->ID, '_menu_item_feat_desc',     true);
        $feat_btn_text = get_post_meta($menu_item->ID, '_menu_item_feat_btn_text', true);
        $feat_btn_link = get_post_meta($menu_item->ID, '_menu_item_feat_btn_link', true);

        if (empty($feat_title))    $feat_title    = 'Featured Content';
        if (empty($feat_btn_text)) $feat_btn_text = 'Learn More';
        if (empty($feat_btn_link)) $feat_btn_link = '#';

        $img_html = '';
        if (!empty($feat_image)) {
            $img_html = '<img src="' . esc_url($feat_image) . '" alt="' . esc_attr($feat_title) . '">';
        }

        // Build the featured-content <li> to inject inside the sub-menu
        $featured_li  = '<li class="featured-content">' . "\n";
        $featured_li .= '  <div class="featured-content-inner">' . "\n";
        $featured_li .= $img_html . "\n";
        $featured_li .= '  <h4>' . esc_html($feat_title) . '</h4>' . "\n";
        if (!empty($feat_desc)) {
            $featured_li .= '  <p>' . esc_html($feat_desc) . '</p>' . "\n";
        }
        $featured_li .= '  <a href="' . esc_url($feat_btn_link) . '">' . esc_html($feat_btn_text) . ' &rarr;</a>' . "\n";
        $featured_li .= '  </div>' . "\n";
        $featured_li .= '</li>' . "\n";

        $item_id = $menu_item->ID;

        // ── Balanced UL-tag counting to find the DIRECT sub-menu's closing </ul> ──
        // This ensures we inject as a sibling column, NOT inside a nested sub-menu.
        $search      = 'id="menu-item-' . $item_id . '"';
        $li_pos      = strpos($nav_menu, $search);

        if ($li_pos !== false) {
            // Find the first <ul after this <li> — that is the direct sub-menu
            $first_ul = strpos($nav_menu, '<ul', $li_pos);

            if ($first_ul !== false) {
                $depth       = 0;
                $scan        = $first_ul;
                $html_len    = strlen($nav_menu);
                $inject_pos  = false;

                while ($scan < $html_len) {
                    $pos_open  = strpos($nav_menu, '<ul',  $scan);
                    $pos_close = strpos($nav_menu, '</ul>', $scan);

                    if ($pos_close === false) break;

                    if ($pos_open !== false && $pos_open < $pos_close) {
                        // Found another opening <ul> — go deeper
                        $depth++;
                        $scan = $pos_open + 3; // move past '<ul'
                    } else {
                        // Found </ul>
                        $depth--;
                        if ($depth === 0) {
                            // This </ul> closes our DIRECT sub-menu → inject here
                            $inject_pos = $pos_close;
                            break;
                        }
                        $scan = $pos_close + 5; // move past '</ul>'
                    }
                }

                if ($inject_pos !== false) {
                    // Insert featured_li just BEFORE the direct sub-menu's closing </ul>
                    $nav_menu = substr_replace($nav_menu, $featured_li, $inject_pos, 0);
                }
            }
        }
    }

    return $nav_menu;
}
add_filter('wp_nav_menu', 'mytheme_inject_featured_panel', 10, 2);


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

        // ── Toggle featured fields visibility when checkbox changes ──────────
        $(document).on('change', '.mega-panel-toggle', function() {
            var target = $(this).data('target');
            if ($(this).is(':checked')) {
                $('#' + target).slideDown(200);
            } else {
                $('#' + target).slideUp(200);
            }
        });

        // ── Menu Icon upload button ─────────────────────────────────────────
        $(document).on('click', '.custom-icon-upload-button', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            wp.media({
                title: 'Select Icon',
                button: { text: 'Use this icon' },
                multiple: false
            }).on('select', function() {
                var attachment = this.state().get('selection').first().toJSON();
                $('#edit-menu-item-custom-icon-' + id).val(attachment.url);
            }.bind(wp.media())).open();
        });

        // ── Featured Panel image upload button ─────────────────────────────
        $(document).on('click', '.feat-image-upload-button', function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var uploader = wp.media({
                title: 'Select Featured Image',
                button: { text: 'Use this image' },
                multiple: false
            }).on('select', function() {
                var attachment = uploader.state().get('selection').first().toJSON();
                $('#edit-menu-item-feat-image-' + id).val(attachment.url);
            }).open();
        });

    });
    </script>
    <?php
}
add_action('admin_footer', 'mytheme_menu_icon_script');
?>