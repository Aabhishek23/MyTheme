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
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    register_nav_menus(array(
        'primary-menu' => __('Primary Menu', 'mytheme'),
        'footer-col-1' => __('Footer Column 1', 'mytheme'),
        'footer-col-2' => __('Footer Column 2', 'mytheme'),
        'footer-col-3' => __('Footer Column 3', 'mytheme'),
        'footer-col-4' => __('Footer Column 4', 'mytheme'),
    ));

    // Register Quotes Post Type
    register_post_type('pcb_quote', array(
        'labels' => array(
            'name' => 'Quotes',
            'singular_name' => 'Quote',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Quote',
            'edit_item' => 'Edit Quote',
            'new_item' => 'New Quote',
            'view_item' => 'View Quote',
            'search_items' => 'Search Quotes',
            'not_found' => 'No Quotes found',
            'all_items' => 'All Quotes',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-media-spreadsheet',
        'supports' => array('title', 'editor', 'custom-fields'),
        'capability_type' => 'post',
    ));

    // Register Contact Inquiries Post Type
    register_post_type('contact_inquiry', array(
        'labels' => array(
            'name' => 'Inquiries',
            'singular_name' => 'Inquiry',
            'menu_name' => 'Messages',
            'all_items' => 'All Messages',
            'add_new' => 'Add New',
            'add_new_item' => 'Add New Message',
            'edit_item' => 'View Message',
            'new_item' => 'New Message',
            'view_item' => 'View Message',
            'search_items' => 'Search Messages',
            'not_found' => 'No messages found',
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-email-alt',
        'supports' => array('title', 'editor', 'custom-fields'),
        'capability_type' => 'post',
    ));

    // Register Webinar Post Type
    register_post_type('webinar', array(
        'labels' => array(
            'name' => 'Webinars',
            'singular_name' => 'Webinar',
            'add_new' => 'Add New Webinar',
            'add_new_item' => 'Add New Webinar',
            'edit_item' => 'Edit Webinar',
            'new_item' => 'New Webinar',
            'view_item' => 'View Webinar',
            'search_items' => 'Search Webinars',
            'not_found' => 'No Webinars found',
            'all_items' => 'All Webinars',
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-video-alt3',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'webinars'),
        'show_in_rest' => true,
    ));

    // Register Tradeshow Post Type
    register_post_type('tradeshow', array(
        'labels' => array(
            'name' => 'Trade Shows',
            'singular_name' => 'Trade Show',
            'add_new' => 'Add New Show',
            'add_new_item' => 'Add New Trade Show',
            'edit_item' => 'Edit Trade Show',
            'new_item' => 'New Trade Show',
            'view_item' => 'View Trade Show',
            'search_items' => 'Search Trade Shows',
            'not_found' => 'No Trade Shows found',
            'all_items' => 'All Trade Shows',
        ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_icon' => 'dashicons-location-alt',
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'has_archive' => true,
        'rewrite' => array('slug' => 'tradeshows'),
        'show_in_rest' => true,
    ));

    // Flush rewrite rules
    if (get_option('mytheme_flush_v2') !== 'done') {
        flush_rewrite_rules();
        update_option('mytheme_flush_v2', 'done');
    }
}
add_action('after_setup_theme', 'mytheme_setup');

/**
 * ── QUOTES ADMIN DASHBOARD FEATURES ──────────────────────────────────────────
 * This shows user details and file links inside the WordPress Admin Panel.
 */

// 1. Add Custom Columns to the Quotes List Table
add_filter('manage_pcb_quote_posts_columns', function($columns) {
    $columns['customer_info'] = 'Customer Details';
    $columns['service_type'] = 'Service';
    $columns['pcb_specs'] = 'PCB Specs';
    $columns['file_download'] = 'Download File';
    return $columns;
});

add_action('manage_pcb_quote_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'customer_info':
            echo '<strong>Email:</strong> ' . esc_html(get_post_meta($post_id, '_customer_email', true)) . '<br>';
            echo '<strong>Phone:</strong> ' . esc_html(get_post_meta($post_id, '_customer_phone', true)) . '<br>';
            echo '<strong>Address:</strong> ' . esc_html(get_post_meta($post_id, '_customer_address', true));
            break;
        case 'service_type':
            $service = get_post_meta($post_id, '_service_type', true);
            echo '<span style="background:#7c4dff; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; font-weight:700; text-transform:uppercase;">' . esc_html($service) . '</span>';
            break;
        case 'pcb_specs':
            echo '<strong>Type:</strong> ' . esc_html(get_post_meta($post_id, '_pcb_type', true)) . '<br>';
            echo '<strong>Qty:</strong> ' . esc_html(get_post_meta($post_id, '_quantity', true));
            break;
        case 'file_download':
            $file_url = get_post_meta($post_id, '_file_url', true);
            if ($file_url) {
                echo '<a href="' . esc_url($file_url) . '" target="_blank" class="button button-small button-primary">Download Gerber ZIP</a>';
            } else { echo '<span style="color:#999; font-style:italic">No File</span>'; }
            break;
    }
}, 10, 2);

// ── CONTACT INQUIRIES ADMIN DASHBOARD ────────────────────────────────────────

add_filter('manage_contact_inquiry_posts_columns', function($columns) {
    $columns = array(
        'cb' => $columns['cb'],
        'title' => 'Sender Name',
        'email' => 'Email Address',
        'subject' => 'Subject',
        'date' => 'Date'
    );
    return $columns;
});

add_action('manage_contact_inquiry_posts_custom_column', function($column, $post_id) {
    switch ($column) {
        case 'email':
            echo esc_html(get_post_meta($post_id, '_contact_email', true));
            break;
        case 'subject':
            echo esc_html(get_post_meta($post_id, '_contact_subject', true));
            break;
    }
}, 10, 2);

// ── UNREAD MESSAGES NOTIFICATION SYSTEM ──────────────────────────────────────

// 1. Add notification bubble to the admin menu
add_action('admin_menu', function() {
    global $menu;
    $unread_count = count(get_posts(array(
        'post_type' => 'contact_inquiry',
        'post_status' => 'publish',
        'meta_query' => array(
            array(
                'key' => '_is_read',
                'value' => '0',
                'compare' => '='
            )
        ),
        'posts_per_page' => -1
    )));

    if ($unread_count > 0) {
        foreach ($menu as $key => $value) {
            if ($value[2] == 'edit.php?post_type=contact_inquiry') {
                $menu[$key][0] .= " <span class='update-plugins count-$unread_count'><span class='plugin-count'>" . number_format_i18n($unread_count) . "</span></span>";
            }
        }
    }
});

// 2. Mark as read when the admin views the message
add_action('add_meta_boxes', function() {
    $screen = get_current_screen();
    if ($screen && $screen->id === 'contact_inquiry') {
        global $post;
        if (get_post_meta($post->ID, '_is_read', true) === '0') {
            update_post_meta($post->ID, '_is_read', '1');
        }
    }
});

// 3. Bold the unread messages in the admin list
add_action('admin_head', function() {
    ?>
    <style>
        .post-type-contact_inquiry .status-publish.post-unread td.column-title strong a,
        .post-type-contact_inquiry .status-publish.post-unread td.column-title strong {
            font-weight: 800 !important;
            color: #000 !important;
        }
        .post-type-contact_inquiry tr.post-unread {
            background-color: #f0f6fc !important;
        }
    </style>
    <?php
});

add_filter('post_class', function($classes, $class, $post_id) {
    if (get_post_type($post_id) === 'contact_inquiry' && get_post_meta($post_id, '_is_read', true) === '0') {
        $classes[] = 'post-unread';
    }
    return $classes;
}, 10, 3);

// 2. Add a Meta Box for full details inside the Quote Editor
add_action('add_meta_boxes', function() {
    add_meta_box('pcb_quote_details', 'FULL QUOTE SUBMISSION DETAILS', function($post) {
        $meta = get_post_custom($post->ID);
        ?>
        <div style="background:#f9f9f9; padding:20px; border:1px solid #ddd; border-radius:10px;">
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
                <div>
                    <h4 style="border-bottom:2px solid #7c4dff; padding-bottom:10px;">👤 Contact Info</h4>
                    <p><strong>Email:</strong> <?php echo esc_html($meta['_customer_email'][0] ?? 'N/A'); ?></p>
                    <p><strong>Phone:</strong> <?php echo esc_html($meta['_customer_phone'][0] ?? 'N/A'); ?></p>
                    <p><strong>Address:</strong> <?php echo esc_html($meta['_customer_address'][0] ?? 'N/A'); ?></p>
                </div>
                <div>
                    <h4 style="border-bottom:2px solid #7c4dff; padding-bottom:10px;">🔬 Project Details</h4>
                    <p><strong>Service Requested:</strong> <span style="background:#7c4dff; color:#fff; padding:2px 10px; border-radius:15px;"><?php echo esc_html($meta['_service_type'][0] ?? 'N/A'); ?></span></p>
                    <p><strong>PCB Type:</strong> <?php echo esc_html($meta['_pcb_type'][0] ?? 'N/A'); ?></p>
                    <p><strong>Quantity:</strong> <?php echo esc_html($meta['_quantity'][0] ?? 'N/A'); ?></p>
                    <p><strong>Material:</strong> <?php echo esc_html($meta['_material'][0] ?? 'N/A'); ?></p>
                    <p><strong>Thickness:</strong> <?php echo esc_html($meta['_thickness'][0] ?? '0'); ?> mm</p>
                </div>
            </div>
            <div style="margin-top:20px; padding-top:20px; border-top:1px solid #ccc;">
                <h4 style="color:#7c4dff;">📦 Attachment</h4>
                <?php if (!empty($meta['_file_url'][0])) : ?>
                    <a href="<?php echo esc_url($meta['_file_url'][0]); ?>" class="button button-primary button-large" target="_blank" style="padding:10px 30px; background:#7c4dff; border-color:#7c4dff;">DOWNLOAD GERBER FILES (.ZIP)</a>
                <?php else : ?>
                    <p style="color:red; font-style:italic;">No file was uploaded with this request.</p>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }, 'pcb_quote', 'normal', 'high');

    add_meta_box('contact_inquiry_details', 'MESSAGE DETAILS', function($post) {
        $email = get_post_meta($post->ID, '_contact_email', true);
        $subject = get_post_meta($post->ID, '_contact_subject', true);
        $message = $post->post_content;
        ?>
        <div style="background:#f9f9f9; padding:20px; border:1px solid #ddd; border-radius:10px;">
            <p><strong>From:</strong> <?php echo esc_html($post->post_title); ?> (<?php echo esc_html($email); ?>)</p>
            <p><strong>Subject:</strong> <?php echo esc_html($subject); ?></p>
            <hr>
            <p><strong>Message:</strong></p>
            <div style="background:#fff; padding:15px; border:1px solid #eee; border-radius:5px; white-space: pre-wrap;"><?php echo esc_html($message); ?></div>
        </div>
        <?php
    }, 'contact_inquiry', 'normal', 'high');

    // Webinar Details Meta Box
    add_meta_box('webinar_details', 'WEBINAR SETTINGS', function($post) {
        $video_url = get_post_meta($post->ID, '_webinar_video_url', true);
        $webinar_date = get_post_meta($post->ID, '_webinar_date', true);
        $webinar_time = get_post_meta($post->ID, '_webinar_time', true);
        $webinar_duration = get_post_meta($post->ID, '_webinar_duration', true);
        $speaker_name = get_post_meta($post->ID, '_webinar_speaker', true);
        $reg_link = get_post_meta($post->ID, '_webinar_reg_link', true);
        $is_live = get_post_meta($post->ID, '_webinar_is_live', true);
        ?>
        <div style="padding:15px; background:#f4f4f4; border:1px solid #ccc; border-radius:8px;">
            <p>
                <label><strong>YouTube Video URL:</strong></label><br>
                <input type="text" name="webinar_video_url" value="<?php echo esc_attr($video_url); ?>" class="widefat" placeholder="https://www.youtube.com/watch?v=...">
                <small>Leave empty if no video available yet.</small>
            </p>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <p>
                    <label><strong>Webinar Date:</strong></label><br>
                    <input type="date" name="webinar_date" value="<?php echo esc_attr($webinar_date); ?>" class="widefat">
                </p>
                <p>
                    <label><strong>Webinar Time:</strong></label><br>
                    <input type="time" name="webinar_time" value="<?php echo esc_attr($webinar_time); ?>" class="widefat">
                </p>
            </div>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <p>
                    <label><strong>Duration (e.g., 60 mins):</strong></label><br>
                    <input type="text" name="webinar_duration" value="<?php echo esc_attr($webinar_duration); ?>" class="widefat">
                </p>
                <p>
                    <label><strong>Speaker Name:</strong></label><br>
                    <input type="text" name="webinar_speaker" value="<?php echo esc_attr($speaker_name); ?>" class="widefat">
                </p>
            </div>
            <p>
                <label><strong>Registration / Join Link:</strong></label><br>
                <input type="text" name="webinar_reg_link" value="<?php echo esc_attr($reg_link); ?>" class="widefat" placeholder="Zoom/Teams Link">
            </p>
            <p>
                <label><strong>Resources / PDF Link (Optional):</strong></label><br>
                <input type="text" name="webinar_resource_url" value="<?php echo esc_attr(get_post_meta($post->ID, '_webinar_resource_url', true)); ?>" class="widefat" placeholder="Direct link to PDF or slides">
            </p>
            <p>
                <label>
                    <input type="checkbox" name="webinar_is_live" value="yes" <?php checked($is_live, 'yes'); ?>>
                    <strong>Mark as LIVE Webinar</strong>
                </label>
            </p>
        </div>
        <?php
    }, 'webinar', 'normal', 'high');

    // Tradeshow Details Meta Box
    add_meta_box('tradeshow_details', 'TRADE SHOW SETTINGS', function($post) {
        $location = get_post_meta($post->ID, '_tradeshow_location', true);
        $start_date = get_post_meta($post->ID, '_tradeshow_start_date', true);
        $end_date = get_post_meta($post->ID, '_tradeshow_end_date', true);
        $booth = get_post_meta($post->ID, '_tradeshow_booth', true);
        $map_url = get_post_meta($post->ID, '_tradeshow_map_url', true);
        ?>
        <div style="padding:15px; background:#f0f7ff; border:1px solid #c2d1e0; border-radius:8px;">
            <p>
                <label><strong>Event Location (Venue, City, Country):</strong></label><br>
                <input type="text" name="tradeshow_location" value="<?php echo esc_attr($location); ?>" class="widefat" placeholder="e.g. Las Vegas Convention Center, USA">
            </p>
            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:15px;">
                <p>
                    <label><strong>Start Date:</strong></label><br>
                    <input type="date" name="tradeshow_start_date" value="<?php echo esc_attr($start_date); ?>" class="widefat">
                </p>
                <p>
                    <label><strong>End Date:</strong></label><br>
                    <input type="date" name="tradeshow_end_date" value="<?php echo esc_attr($end_date); ?>" class="widefat">
                </p>
            </div>
            <p>
                <label><strong>Booth / Stand Number:</strong></label><br>
                <input type="text" name="tradeshow_booth" value="<?php echo esc_attr($booth); ?>" class="widefat" placeholder="e.g. Hall 4, Booth #452">
            </p>
            <p>
                <label><strong>Google Maps Link:</strong></label><br>
                <input type="text" name="tradeshow_map_url" value="<?php echo esc_attr($map_url); ?>" class="widefat" placeholder="https://goo.gl/maps/...">
            </p>
        </div>
        <?php
    }, 'tradeshow', 'normal', 'high');
});

// Save Webinar Meta Data
add_action('save_post_webinar', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    $fields = array(
        'webinar_video_url'    => '_webinar_video_url',
        'webinar_date'         => '_webinar_date',
        'webinar_time'         => '_webinar_time',
        'webinar_duration'     => '_webinar_duration',
        'webinar_speaker'      => '_webinar_speaker',
        'webinar_reg_link'     => '_webinar_reg_link',
        'webinar_resource_url' => '_webinar_resource_url',
    );

    foreach ($fields as $key => $meta_key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$key]));
        }
    }

    update_post_meta($post_id, '_webinar_is_live', isset($_POST['webinar_is_live']) ? 'yes' : 'no');
});

// Save Tradeshow Meta Data
add_action('save_post_tradeshow', function($post_id) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    
    $fields = array(
        'tradeshow_location'   => '_tradeshow_location',
        'tradeshow_start_date' => '_tradeshow_start_date',
        'tradeshow_end_date'   => '_tradeshow_end_date',
        'tradeshow_booth'      => '_tradeshow_booth',
        'tradeshow_map_url'    => '_tradeshow_map_url',
    );

    foreach ($fields as $key => $meta_key) {
        if (isset($_POST[$key])) {
            update_post_meta($post_id, $meta_key, sanitize_text_field($_POST[$key]));
        }
    }
});

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
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Poppins:wght@200;300;400;700&family=Roboto:wght@400;500;700&display=swap', array(), null);
    
    // Main Styles
    wp_enqueue_style('style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'mytheme_styles');

function mytheme_scripts() {
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0', true);
}
add_action('wp_enqueue_scripts', 'mytheme_scripts');

// 3. Allow ZIP and RAR uploads in WordPress
add_filter('upload_mimes', function($mimes) {
    if (!isset($mimes['zip'])) $mimes['zip'] = 'application/zip';
    if (!isset($mimes['rar'])) $mimes['rar'] = 'application/x-rar-compressed';
    if (!isset($mimes['7z']))  $mimes['7z']  = 'application/x-7z-compressed';
    return $mimes;
});

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
                    <h4>Navigating Software-Defined Vehicle Development</h4>
                    <p>Discover strategies to boost SDV innovation, reduce costs, and enhance reliability.</p>
                    <a href="#" style="color: #5d3fd3; font-weight: 600;">Learn more &rarr;</a>
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
        'default'           => 'End-to-End PCB Design & Manufacturing Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_title', array(
        'label'    => __('Main Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('design_future_col1_title', array(
        'default'           => 'PCB Design & Consultancy',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_col1_title', array(
        'label'    => __('Column 1 Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('design_future_col2_title', array(
        'default'           => 'Manufacturing & Prototyping',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('design_future_col2_title', array(
        'label'    => __('Column 2 Title', 'mytheme'),
        'section'  => 'design_future_section',
        'type'     => 'text',
    ));

    // Items for Design the Future
    $df_defaults = array(
        array('title' => 'High-Speed Digital Design', 'desc' => 'Advanced design for high-speed signals, impedance control, and signal integrity.'),
        array('title' => 'Mixed-Signal PCB Design', 'desc' => 'Expert layout for sensitive analog mixed with digital circuitry.'),
        array('title' => 'RF & Microwave Design', 'desc' => 'Optimized board designs for wireless communications and RF applications.'),
        array('title' => 'Power Electronics', 'desc' => 'Robust layouts for power supplies, motor drives, and energy systems.'),
        array('title' => 'Rapid Prototyping', 'desc' => 'Quick-turn PCB fabrication to accelerate your product development.'),
        array('title' => 'Mass Production', 'desc' => 'High-quality, cost-effective volume manufacturing of custom boards.'),
        array('title' => 'PCB Assembly (PCBA)', 'desc' => 'Turnkey assembly services including component sourcing and soldering.'),
        array('title' => 'Testing & Quality Assurance', 'desc' => 'Rigorous inspection and testing to ensure first-pass success.')
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

    // ── What's New Section ──────────────────────────────────────────────
    $wp_customize->add_section('whats_new_section', array(
        'title'       => __('What\'s New Section (Posts Slider)', 'mytheme'),
        'description' => __('This section automatically pulls your latest published Posts.', 'mytheme'),
        'priority'    => 34,
    ));

    $wp_customize->add_setting('whats_new_title', array(
        'default'           => 'What\'s New',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('whats_new_title', array(
        'label'    => __('Section Title', 'mytheme'),
        'section'  => 'whats_new_section',
        'type'     => 'text',
    ));

    // ── Ecosystem Partners Section ──────────────────────────────────────────────
    $wp_customize->add_section('ecosystem_section', array(
        'title'       => __('Ecosystem Partners Section', 'mytheme'),
        'description' => __('Settings for the partner logos section.', 'mytheme'),
        'priority'    => 35,
    ));

    $wp_customize->add_setting('ecosystem_title', array(
        'default'           => 'Ecosystem Partners',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('ecosystem_title', array(
        'label'    => __('Section Title', 'mytheme'),
        'section'  => 'ecosystem_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('ecosystem_marquee', array(
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ));
    $wp_customize->add_control('ecosystem_marquee', array(
        'label'    => __('Enable Running Banner (Marquee Animation)', 'mytheme'),
        'description' => __('Uncheck this to stop the running banner and show logos normally.', 'mytheme'),
        'section'  => 'ecosystem_section',
        'type'     => 'checkbox',
    ));

    for ($i = 1; $i <= 6; $i++) {
        // Logo Image
        $wp_customize->add_setting("ecosystem_logo_$i", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, "ecosystem_logo_$i", array(
            'label'   => sprintf(__('Partner Logo %d', 'mytheme'), $i),
            'section' => 'ecosystem_section',
        )));
        
        // Logo Link
        $wp_customize->add_setting("ecosystem_link_$i", array(
            'default'           => '#',
            'sanitize_callback' => 'esc_url_raw',
        ));
        $wp_customize->add_control("ecosystem_link_$i", array(
            'label'   => sprintf(__('Partner Link %d (Optional)', 'mytheme'), $i),
            'section' => 'ecosystem_section',
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
    // ── Support & Careers Section ──────────────────────────────────────────────
    $wp_customize->add_section('support_careers_section', array(
        'title'       => __('Support & Careers Section', 'mytheme'),
        'description' => __('Settings for the two-column support and careers section.', 'mytheme'),
        'priority'    => 36,
    ));

    // Column 1: Support
    $wp_customize->add_setting('sc_col1_title', array(
        'default'           => 'Support & Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('sc_col1_title', array(
        'label'    => __('Column 1 Title', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('sc_col1_desc', array(
        'default'           => 'Explore the Synopsys Support Community! Login is required. View our service offerings as well.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('sc_col1_desc', array(
        'label'    => __('Column 1 Description', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('sc_col1_link_text', array(
        'default'           => 'View Support & Services',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('sc_col1_link_text', array(
        'label'    => __('Column 1 Link Text', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('sc_col1_link_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('sc_col1_link_url', array(
        'label'    => __('Column 1 Link URL', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'url',
    ));

    // Column 2: Careers
    $wp_customize->add_setting('sc_col2_title', array(
        'default'           => 'Careers',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('sc_col2_title', array(
        'label'    => __('Column 2 Title', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('sc_col2_desc', array(
        'default'           => 'Work at Synopsys and join a first-in-class team of technology professionals. Apply for a position today.',
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    $wp_customize->add_control('sc_col2_desc', array(
        'label'    => __('Column 2 Description', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'textarea',
    ));

    $wp_customize->add_setting('sc_col2_link_text', array(
        'default'           => 'View Careers',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('sc_col2_link_text', array(
        'label'    => __('Column 2 Link Text', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('sc_col2_link_url', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('sc_col2_link_url', array(
        'label'    => __('Column 2 Link URL', 'mytheme'),
        'section'  => 'support_careers_section',
        'type'     => 'url',
    ));

    // Support & Careers Colors
    $wp_customize->add_setting('sc_bg_color', array(
        'default'           => '#f7f7fa',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sc_bg_color', array(
        'label'    => __('Background Color', 'mytheme'),
        'section'  => 'support_careers_section',
    )));

    $wp_customize->add_setting('sc_title_color', array(
        'default'           => '#1f2937',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sc_title_color', array(
        'label'    => __('Title Color', 'mytheme'),
        'section'  => 'support_careers_section',
    )));

    $wp_customize->add_setting('sc_desc_color', array(
        'default'           => '#4b5563',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'sc_desc_color', array(
        'label'    => __('Description Color', 'mytheme'),
        'section'  => 'support_careers_section',
    )));

    // ── Connect with Us Section ──────────────────────────────────────────────
    $wp_customize->add_section('connect_us_section', array(
        'title'       => __('Connect with Us Section', 'mytheme'),
        'description' => __('Settings for the bottom CTA section.', 'mytheme'),
        'priority'    => 37,
    ));

    $wp_customize->add_setting('connect_title', array(
        'default'           => 'Connect with Us',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('connect_title', array(
        'label'    => __('Section Title', 'mytheme'),
        'section'  => 'connect_us_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('connect_btn_text', array(
        'default'           => 'Contact Sales',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('connect_btn_text', array(
        'label'    => __('Button Text', 'mytheme'),
        'section'  => 'connect_us_section',
        'type'     => 'text',
    ));

    $wp_customize->add_setting('connect_btn_link', array(
        'default'           => '#',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control('connect_btn_link', array(
        'label'    => __('Button Link URL', 'mytheme'),
        'section'  => 'connect_us_section',
        'type'     => 'url',
    ));

    // Gradient Colors
    $wp_customize->add_setting('connect_grad_start', array(
        'default'           => '#2d1a47',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'connect_grad_start', array(
        'label'    => __('Gradient Start Color', 'mytheme'),
        'section'  => 'connect_us_section',
    )));

    $wp_customize->add_setting('connect_grad_end', array(
        'default'           => '#7c3aed',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'connect_grad_end', array(
        'label'    => __('Gradient End Color', 'mytheme'),
        'section'  => 'connect_us_section',
    )));

    // ── Footer Settings ────────────────────────────────────────────────────────
    $wp_customize->add_section('footer_settings', array(
        'title'    => __('Footer Settings', 'mytheme'),
        'priority' => 160,
    ));

    // Footer Column 1 Title
    $wp_customize->add_setting('footer_col1_title', array(
        'default'           => 'Company',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_col1_title', array(
        'label'    => __('Column 1 Title', 'mytheme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Footer Column 2 Title
    $wp_customize->add_setting('footer_col2_title', array(
        'default'           => 'Resources',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_col2_title', array(
        'label'    => __('Column 2 Title', 'mytheme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Footer Column 3 Title
    $wp_customize->add_setting('footer_col3_title', array(
        'default'           => 'Trending',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_col3_title', array(
        'label'    => __('Column 3 Title', 'mytheme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Footer Column 4 Title
    $wp_customize->add_setting('footer_col4_title', array(
        'default'           => 'Learn',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('footer_col4_title', array(
        'label'    => __('Column 4 Title', 'mytheme'),
        'section'  => 'footer_settings',
        'type'     => 'text',
    ));

    // Copyright Text
    $wp_customize->add_setting('footer_copyright_text', array(
        'default'           => sprintf('&copy; %s %s, Inc. All Rights Reserved.', date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'wp_kses_post',
    ));
    $wp_customize->add_control('footer_copyright_text', array(
        'label'    => __('Copyright Text', 'mytheme'),
        'section'  => 'footer_settings',
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
 * Custom Shortcode for boAt-style Tabbed Product Grid
 */
function mytheme_boat_product_tabs($atts) {
    if (!class_exists('WooCommerce')) return '';
    
    $atts = shortcode_atts(array(
        'limit' => 6,
        'tabs' => 'New Launches:new-launches, Personalisation:personalisation',
        'title' => 'Top Picks For You'
    ), $atts);

    $tabs_data = explode(',', $atts['tabs']);
    $first_tab_slug = '';
    
    ob_start();
    ?>
    <section class="boat-tabbed-section">
        <div class="boat-section-header">
            <h2 class="boat-section-title">
                <?php 
                $title_parts = explode(' ', $atts['title']);
                $last_word = array_pop($title_parts);
                echo implode(' ', $title_parts) . ' <span class="underlined">' . esc_html($last_word) . '</span>';
                ?>
            </h2>
            <div class="boat-header-actions">
                <a href="<?php echo esc_url(get_permalink(wc_get_page_id('shop'))); ?>" class="boat-view-all">View All</a>
            </div>
        </div>

        <div class="boat-tabs-nav">
            <?php foreach ($tabs_data as $index => $tab_str) : 
                list($label, $slug) = explode(':', trim($tab_str));
                if ($index === 0) $first_tab_slug = $slug;
            ?>
                <button class="boat-tab-btn <?php echo ($index === 0) ? 'active' : ''; ?>" data-tab="<?php echo esc_attr($slug); ?>">
                    <?php echo esc_html($label); ?>
                </button>
            <?php endforeach; ?>
        </div>
        
        <div class="boat-tabs-content">
            <?php foreach ($tabs_data as $index => $tab_str) : 
                list($label, $slug) = explode(':', trim($tab_str));
            ?>
                <div class="boat-tab-panel <?php echo ($index === 0) ? 'active' : ''; ?>" id="tab-<?php echo esc_attr($slug); ?>">
                    <div class="boat-product-grid">
                        <?php 
                        $transient_key = 'boat_products_' . $slug . '_' . $atts['limit'];
                        $products = get_transient($transient_key);

                        if (false === $products) {
                            $args = array(
                                'post_type' => 'product',
                                'posts_per_page' => $atts['limit'],
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'slug',
                                        'terms'    => $slug,
                                    ),
                                ),
                            );
                            $products = new WP_Query($args);
                            set_transient($transient_key, $products, HOUR_IN_SECONDS);
                        }
                        
                        if ($products->have_posts()) : while ($products->have_posts()) : $products->the_post(); 
                            global $product;
                            $average_rating = $product->get_average_rating();
                            $sale_price = $product->get_sale_price();
                            $regular_price = $product->get_regular_price();
                            $discount = 0;
                            if ($regular_price > 0 && $sale_price > 0) {
                                $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                            }
                            
                            $feature_text = get_post_meta(get_the_ID(), '_boat_feature_text', true);
                            if (!$feature_text) $feature_text = 'New Launch';
                            
                            $badge_text = get_post_meta(get_the_ID(), '_boat_badge_text', true);
                            $extra_badge = get_post_meta(get_the_ID(), '_boat_extra_badge', true);
                        ?>
                            <div class="boat-product-card">
                                <div class="boat-card-image-wrapper">
                                    <div class="boat-badges-top">
                                        <?php if ($extra_badge) : ?>
                                            <span class="boat-badge boat-badge-extra">🏷️ <?php echo esc_html($extra_badge); ?></span>
                                        <?php endif; ?>
                                        <?php if ($badge_text) : ?>
                                            <span class="boat-badge boat-badge-main">🚀 <?php echo esc_html($badge_text); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'boat-card-image')); ?>
                                    </a>
                                    
                                    <div class="boat-feature-strip">
                                        <span class="boat-feature-text"><?php echo esc_html($feature_text); ?></span>
                                        <div class="boat-rating">
                                            <span class="boat-star">★</span> <?php echo number_format($average_rating, 1); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="boat-card-content">
                                    <h3 class="boat-product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="boat-price-row">
                                        <div class="boat-prices">
                                            <div class="price-main">
                                                <span class="boat-current-price"><?php echo get_woocommerce_currency_symbol() . ($sale_price ? $sale_price : $regular_price); ?></span>
                                                <span class="boat-discount"><?php echo ($discount > 0) ? $discount . '% off' : ''; ?></span>
                                            </div>
                                            <?php if ($sale_price) : ?>
                                                <span class="boat-old-price"><?php echo get_woocommerce_currency_symbol() . $regular_price; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="boat-colors">
                                            <span class="boat-dots"><span class="dot"></span><span class="dot darker"></span></span>
                                            <span class="boat-color-count">+4</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; wp_reset_postdata(); else : ?>
                            <p>No products found in this category.</p>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabs = document.querySelectorAll('.boat-tab-btn');
        const panels = document.querySelectorAll('.boat-tab-panel');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('data-tab');

                tabs.forEach(t => t.classList.remove('active'));
                tab.classList.add('active');

                panels.forEach(p => {
                    p.classList.remove('active');
                    if (p.id === 'tab-' + target) {
                        p.classList.add('active');
                    }
                });
            });
        });
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('boat_products', 'mytheme_boat_product_tabs');

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

/**
 * Add Meta Boxes for boAt Style Product Card settings
 */
function mytheme_add_product_meta_boxes() {
    add_meta_box(
        "boat_product_settings",
        "boAt Style Card Settings",
        "mytheme_boat_meta_box_html",
        "product",
        "side",
        "default"
    );
}
add_action("add_meta_boxes", "mytheme_add_product_meta_boxes");

function mytheme_boat_meta_box_html($post) {
    if (!class_exists("WooCommerce")) return;
    $feature_text = get_post_meta($post->ID, "_boat_feature_text", true);
    $badge_text = get_post_meta($post->ID, "_boat_badge_text", true);
    $extra_badge = get_post_meta($post->ID, "_boat_extra_badge", true);
    ?>
    <p>
        <label for="boat_feature_text">Yellow Strip Text:</label>
        <input type="text" id="boat_feature_text" name="boat_feature_text" value="<?php echo esc_attr($feature_text); ?>" class="widefat" placeholder="e.g. 40 Hours Playback">
    </p>
    <p>
        <label for="boat_badge_text">Top Right Badge (e.g. New Launch):</label>
        <input type="text" id="badge_text" name="boat_badge_text" value="<?php echo esc_attr($badge_text); ?>" class="widefat" placeholder="e.g. New Launch">
    </p>
    <p>
        <label for="boat_extra_badge">Top Left Badge (e.g. EXTRA ₹300 OFF):</label>
        <input type="text" id="extra_badge" name="boat_extra_badge" value="<?php echo esc_attr($extra_badge); ?>" class="widefat" placeholder="e.g. EXTRA ₹300 OFF">
    </p>
    <?php
}

function mytheme_save_product_meta($post_id) {
    if (isset($_POST["boat_feature_text"])) {
        update_post_meta($post_id, "_boat_feature_text", sanitize_text_field($_POST["boat_feature_text"]));
    }
    if (isset($_POST["boat_badge_text"])) {
        update_post_meta($post_id, "_boat_badge_text", sanitize_text_field($_POST["boat_badge_text"]));
    }
    if (isset($_POST["boat_extra_badge"])) {
        update_post_meta($post_id, "_boat_extra_badge", sanitize_text_field($_POST["boat_extra_badge"]));
    }
}
add_action("save_post_product", "mytheme_save_product_meta");

/**
 * Performance Optimization: Disable WooCommerce scripts on non-WooCommerce pages
 */
function mytheme_optimize_wc_scripts() {
    if (!class_exists('WooCommerce')) return;
    // On single product pages, keep ALL scripts loaded for gallery (flexslider, photoswipe, zoom)
    if (is_product()) return;
    if (is_cart() || is_checkout() || is_account_page() || is_woocommerce()) return;
    
    wp_dequeue_script('wc-add-to-cart');
    wp_dequeue_script('wc-cart-fragments');
    wp_dequeue_script('woocommerce');
    wp_dequeue_script('wc-checkout');
    wp_dequeue_script('wc-add-to-cart-variation');
    wp_dequeue_script('wc-single-product');
    wp_dequeue_style('woocommerce-general');
    wp_dequeue_style('woocommerce-layout');
    wp_dequeue_style('woocommerce-smallscreen');
}
add_action('wp_enqueue_scripts', 'mytheme_optimize_wc_scripts', 99);

/**
 * Performance Optimization: Disable WordPress Heartbeat if not needed on frontend
 */
function mytheme_stop_heartbeat() {
    if (!is_admin()) {
        wp_deregister_script('heartbeat');
    }
}
add_action('init', 'mytheme_stop_heartbeat', 1);

/**
 * Performance Optimization: Dequeue Emojis scripts (often unnecessary)
 */
function mytheme_disable_emojis() {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'mytheme_disable_emojis_tinymce');
}
add_action('init', 'mytheme_disable_emojis');

function mytheme_disable_emojis_tinymce($plugins) {
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}

/**
 * Performance Optimization: Remove head clutter (DNS Prefetch, RSD, WLW, Shortlinks)
 */
function mytheme_cleanup_head() {
    remove_action('wp_head', 'rsd_link');
    remove_action('wp_head', 'wlwmanifest_link');
    remove_action('wp_head', 'wp_generator');
    remove_action('wp_head', 'wp_shortlink_wp_head');
    remove_action('wp_head', 'rest_output_link_wp_head');
    remove_action('wp_head', 'wp_oembed_add_discovery_links');
    remove_action('wp_head', 'wp_resource_hints', 2);
    
    // Disable global styles (WordPress 5.9+)
    remove_action('wp_enqueue_scripts', 'wp_enqueue_global_styles');
    remove_action('wp_footer', 'wp_enqueue_global_styles', 1);
}
add_action('init', 'mytheme_cleanup_head');

/**
 * Performance Optimization: Dequeue Gutenberg Block Library CSS
 */
function mytheme_remove_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-blocks-style'); // WooCommerce block styles
}
add_action('wp_enqueue_scripts', 'mytheme_remove_block_library_css', 100);

/**
 * Force-load WooCommerce gallery scripts on single product pages
 * This ensures flexslider, photoswipe and zoom work correctly.
 */
add_action('wp_enqueue_scripts', 'mytheme_force_product_gallery_scripts', 101);
function mytheme_force_product_gallery_scripts() {
    if (!is_product()) return;
    // WooCommerce gallery requires these scripts
    wp_enqueue_script('flexslider');
    wp_enqueue_script('zoom');
    wp_enqueue_script('photoswipe');
    wp_enqueue_script('photoswipe-ui-default');
    wp_enqueue_script('wc-single-product');
    wp_enqueue_style('photoswipe');
    wp_enqueue_style('photoswipe-default-skin');
    wp_enqueue_style('woocommerce-general');
    wp_enqueue_style('woocommerce-layout');
}

/**
 * Performance Optimization: Dequeue Jetpack assets if not on a post/page that needs them
 */
function mytheme_dequeue_jetpack() {
    wp_dequeue_script('devicepx');
}
add_action('wp_enqueue_scripts', 'mytheme_dequeue_jetpack', 100);


/**
 * WooCommerce Customization:
 * Uses WooCommerce's built-in COD gateway (renamed) as "Pay Later — Contact Us"
 * COD natively supports WooCommerce Blocks Checkout — no custom JS needed.
 * Orders are placed immediately and set to 'on-hold' for manual payment.
 */

// ── 1. Force-enable COD gateway via database option ───────────────────────
add_action('init', 'mytheme_enable_cod_gateway');
function mytheme_enable_cod_gateway() {
    $cod_settings = get_option('woocommerce_cod_settings', []);
    if (empty($cod_settings) || ($cod_settings['enabled'] ?? '') !== 'yes') {
        $cod_settings['enabled']     = 'yes';
        $cod_settings['title']       = 'Pay Later — We Will Contact You';
        $cod_settings['description'] = 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे। (We will contact you shortly for payment details via Bank Transfer / UPI / Cash.)';
        $cod_settings['instructions'] = 'Hum aapse jald sampark karenge. Thank you!';
        update_option('woocommerce_cod_settings', $cod_settings);
    }
}

// ── 2. Rename COD labels on the frontend ──────────────────────────────────
add_filter('woocommerce_gateway_title', 'mytheme_rename_cod_title', 10, 2);
function mytheme_rename_cod_title($title, $id) {
    if ($id === 'cod') {
        return 'Pay Later — We Will Contact You';
    }
    return $title;
}

add_filter('woocommerce_gateway_description', 'mytheme_rename_cod_desc', 10, 2);
function mytheme_rename_cod_desc($desc, $id) {
    if ($id === 'cod') {
        return 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे। <br><small>(We will contact you for payment via Bank Transfer / UPI / Cash.)</small>';
    }
    return $desc;
}

// ── 3. After order placed via COD, set status to on-hold ──────────────────
add_action('woocommerce_thankyou_cod', 'mytheme_cod_order_to_hold', 10, 1);
function mytheme_cod_order_to_hold($order_id) {
    if (!$order_id) return;
    $order = wc_get_order($order_id);
    if ($order) {
        $order->update_status('on-hold', 'Awaiting manual payment confirmation — customer to be contacted.');
    }
}

// ── 4. Custom Thank You message ────────────────────────────────────────────
add_filter('woocommerce_thankyou_order_received_text', 'mytheme_custom_thankyou_text', 20, 2);
function mytheme_custom_thankyou_text($text, $order) {
    return '🎉 <strong>Order placed successfully!</strong> Hum aapse jald se jald sampark karenge payment ke liye.<br><em>(शॉपिंग करने के लिए धन्यवाद! हम आपसे जल्द से जल्द संपर्क करेंगे।)</em>';
}


// ═══════════════════════════════════════════════════════════════════════════
// USER AUTHENTICATION SYSTEM — Login, Register & Checkout Protection
// ═══════════════════════════════════════════════════════════════════════════

/**
 * 5. Redirect guests to login page if they try to reach checkout
 */
add_action('template_redirect', 'mytheme_redirect_guests_from_checkout');
function mytheme_redirect_guests_from_checkout() {
    if (is_checkout() && !is_user_logged_in() && !is_wc_endpoint_url()) {
        $login_page = get_permalink(get_page_by_path('my-account'));
        if (!$login_page) {
            $login_page = wp_login_url(wc_get_checkout_url());
        } else {
            $login_page = add_query_arg('redirect_to', urlencode(wc_get_checkout_url()), $login_page);
        }
        wp_redirect($login_page);
        exit;
    }
}

/**
 * 6. Custom Login/Register Shortcode [mytheme_auth_form]
 * Usage: Add this shortcode to any page like My Account page.
 */
function mytheme_auth_form_shortcode($atts) {
    // 1. Completely hand off the route to WooCommerce for the Lost Password reset process
    if (class_exists('WooCommerce') && is_wc_endpoint_url('lost-password')) {
        return '<div class="mytheme-auth-wrapper" style="padding: 2rem; max-width: 600px; margin: 4rem auto; border-radius: 12px; background: rgba(30, 30, 40, 0.9); box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
            <style>
                .woocommerce form { background: none; box-shadow: none; padding: 0; border: none; } 
                .woocommerce-Button { width: 100%; border-radius: 8px !important; background: #8b5cf6 !important; color: white !important; font-weight: 600 !important; cursor: pointer; border: none !important; padding: 12px; margin-top: 15px; } 
                .woocommerce-Button { transition: all 0.3s ease; } .woocommerce-Button:hover { background: #7c3aed !important; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4); }
                .woocommerce-Input, input.input-text, input[type="text"], input[type="email"], input[type="password"] { width: 100%; padding: 12px 15px !important; border-radius: 8px !important; border: 1px solid rgba(255,255,255,0.3) !important; background: rgba(255,255,255,0.05) !important; color: white !important; margin-bottom:15px !important; transition: all 0.3s ease; outline:none; } 
                .woocommerce-Input:focus, input.input-text:focus, input[type="text"]:focus, input[type="email"]:focus, input[type="password"]:focus { border-color: #8b5cf6 !important; box-shadow: 0 0 0 3px rgba(139, 92, 246, 0.3) !important; background: rgba(0,0,0,0.3) !important; }
                label, p { color: white; display: block; line-height:1.5; }
                .woocommerce-message, .woocommerce-error { background: rgba(255,255,255,0.1) !important; color: white; border-top-color: #8b5cf6; }
            </style>
            <div class="auth-header">
                <div class="auth-icon" style="font-size:3rem; text-align:center; margin-bottom:1rem;">🔑</div>
                <h2 style="text-align:center; color:white; margin-bottom: 0.5rem;">Reset Password</h2>
                <p style="text-align:center; color:rgba(255,255,255,0.7); margin-bottom:2rem;">Forgot your password? We will send you an email to reset it.</p>
            </div>
            ' . do_shortcode('[woocommerce_my_account]') . '
        </div>';
    }

    // 2. If already logged in, show account info
    if (is_user_logged_in()) {
        // If viewing an endpoint (like Orders, Address, etc.), render WooCommerce native dashboard
        if (class_exists('WooCommerce') && is_wc_endpoint_url()) {
            return '<div class="woocommerce">' . do_shortcode('[woocommerce_my_account]') . '</div>';
        }

        $user = wp_get_current_user();
        $redirect_to = isset($_GET['redirect_to']) ? esc_url($_GET['redirect_to']) : wc_get_checkout_url();
        ob_start();
        ?>
        <div class="mytheme-auth-wrapper">
            <div class="mytheme-already-logged">
                <div class="auth-avatar">👤</div>
                <h2>Hello, <?php echo esc_html($user->display_name); ?>!</h2>
                <p>You are already logged in.</p>
                <div class="auth-logged-actions">
                    <a href="<?php echo esc_url(wc_get_checkout_url()); ?>" class="auth-btn auth-btn-primary">🛒 Checkout</a>
                    <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="auth-btn auth-btn-outline">📦 My Orders</a>
                    <a href="<?php echo esc_url(wp_logout_url(home_url())); ?>" class="auth-btn auth-btn-danger">🚪 Logout</a>
                </div>
            </div>
        </div>
        <?php
        return ob_get_clean();
    }

    // Handle messages
    $login_error = '';
    $register_error = '';
    $register_success = '';

    // Active tab
    $active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'login';
    $redirect_to = isset($_GET['redirect_to']) ? esc_url_raw($_GET['redirect_to']) : wc_get_checkout_url();

    ob_start();
    ?>
    <div class="mytheme-auth-wrapper">
        <!-- Tab Switcher -->
        <div class="auth-tabs">
            <button class="auth-tab <?php echo ($active_tab !== 'register') ? 'active' : ''; ?>" data-tab="login">
                🔐 Login
            </button>
            <button class="auth-tab <?php echo ($active_tab === 'register') ? 'active' : ''; ?>" data-tab="register">
                ✨ Register
            </button>
        </div>

        <!-- Login Form -->
        <div class="auth-panel <?php echo ($active_tab !== 'register') ? 'active' : ''; ?>" id="panel-login">
            <div class="auth-header">
                <div class="auth-icon">🔐</div>
                <h2>Login to Your Account</h2>
                <p>You must log in to place an order</p>
            </div>
            <?php if ($login_error) : ?>
                <div class="auth-error"><?php echo esc_html($login_error); ?></div>
            <?php endif; ?>
            <form method="post" class="auth-form" id="mytheme-login-form" action="#">
                <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">
                <div class="auth-field">
                    <label for="auth-username">📧 Email or Username</label>
                    <input type="text" id="auth-username" name="log" placeholder="your@email.com" required autocomplete="username">
                </div>
                <div class="auth-field">
                    <label for="auth-password">🔒 Password</label>
                    <div class="password-wrapper">
                        <input type="password" id="auth-password" name="pwd" placeholder="••••••••" required autocomplete="current-password">
                        <button type="button" class="toggle-pwd" data-target="auth-password">👁</button>
                    </div>
                </div>
                <div class="auth-options">
                    <label class="auth-remember">
                        <input type="checkbox" name="rememberme" value="forever"> Remember me
                    </label>
                    <a href="<?php echo esc_url(wp_lostpassword_url()); ?>" class="auth-forgot">Forgot password?</a>
                </div>
                <?php wp_nonce_field('mytheme-login-nonce', 'mytheme_login_nonce'); ?>
                <button type="submit" class="auth-btn auth-btn-primary auth-submit">
                    <span class="btn-text">Login →</span>
                </button>
                <p class="auth-switch">Don't have an account? <a href="#" class="switch-tab" data-tab="register">Register ✨</a></p>
            </form>
        </div>

        <!-- Register Form -->
        <div class="auth-panel <?php echo ($active_tab === 'register') ? 'active' : ''; ?>" id="panel-register">
            <div class="auth-header">
                <div class="auth-icon">✨</div>
                <h2>Create a New Account</h2>
                <p>Register now and start shopping!</p>
            </div>
            <?php if ($register_success) : ?>
                <div class="auth-success"><?php echo esc_html($register_success); ?></div>
            <?php elseif ($register_error) : ?>
                <div class="auth-error"><?php echo esc_html($register_error); ?></div>
            <?php endif; ?>
            <form method="post" class="auth-form" id="mytheme-register-form">
                <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_to); ?>">
                <div class="auth-fields-row">
                    <div class="auth-field">
                        <label for="reg-firstname">👤 First Name *</label>
                        <input type="text" id="reg-firstname" name="reg_firstname" placeholder="John" required>
                    </div>
                    <div class="auth-field">
                        <label for="reg-lastname">👤 Last Name</label>
                        <input type="text" id="reg-lastname" name="reg_lastname" placeholder="Doe">
                    </div>
                </div>
                <div class="auth-field">
                    <label for="reg-email">📧 Email Address *</label>
                    <input type="email" id="reg-email" name="reg_email" placeholder="your@email.com" required autocomplete="email">
                </div>
                <div class="auth-field">
                    <label for="reg-password">🔒 Password *</label>
                    <div class="password-wrapper">
                        <input type="password" id="reg-password" name="reg_password" placeholder="••••••••" required autocomplete="new-password" minlength="6">
                        <button type="button" class="toggle-pwd" data-target="reg-password">👁</button>
                    </div>
                    <small class="field-hint">Create a password with at least 6 characters</small>
                </div>
                <div class="auth-field">
                    <label for="reg-confirm-password">🔒 Confirm Password *</label>
                    <div class="password-wrapper">
                        <input type="password" id="reg-confirm-password" name="reg_confirm_password" placeholder="••••••••" required autocomplete="new-password">
                        <button type="button" class="toggle-pwd" data-target="reg-confirm-password">👁</button>
                    </div>
                </div>
                <?php wp_nonce_field('mytheme-register-nonce', 'mytheme_register_nonce'); ?>
                <button type="submit" class="auth-btn auth-btn-primary auth-submit" name="mytheme_register">
                    <span class="btn-text">Create Account →</span>
                </button>
                <p class="auth-switch">Already have an account? <a href="#" class="switch-tab" data-tab="login">Login 🔐</a></p>
            </form>
        </div>

        <!-- Social divider (optional) -->
        <div class="auth-footer-note">
            <p>🔒 Your information is completely safe. We never share it.</p>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tab switching
        document.querySelectorAll('.auth-tab, .switch-tab').forEach(function(el) {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                var tab = this.dataset.tab;
                document.querySelectorAll('.auth-tab').forEach(function(t) { t.classList.remove('active'); });
                document.querySelectorAll('.auth-panel').forEach(function(p) { p.classList.remove('active'); });
                document.querySelector('.auth-tab[data-tab="' + tab + '"]').classList.add('active');
                document.querySelector('#panel-' + tab).classList.add('active');
            });
        });

        // Password toggle
        document.querySelectorAll('.toggle-pwd').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var inp = document.getElementById(this.dataset.target);
                if (inp.type === 'password') {
                    inp.type = 'text';
                    this.textContent = '🙈';
                } else {
                    inp.type = 'password';
                    this.textContent = '👁';
                }
            });
        });

        // Register form AJAX
        var regForm = document.getElementById('mytheme-register-form');
        if (regForm) {
            regForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = regForm.querySelector('.auth-submit');
                var pwd = document.getElementById('reg-password').value;
                var cpwd = document.getElementById('reg-confirm-password').value;

                // Remove old messages
                regForm.querySelectorAll('.auth-error, .auth-success').forEach(function(el) { el.remove(); });

                if (pwd !== cpwd) {
                    showMsg(regForm, 'error', '❌ Passwords do not match!');
                    return;
                }

                btn.querySelector('.btn-text').textContent = 'Registering...';
                btn.disabled = true;

                var data = new FormData(regForm);
                data.append('action', 'mytheme_register_user');

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: data
                })
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (res.success) {
                        showMsg(regForm, 'success', '✅ ' + res.data.message);
                        setTimeout(function() {
                            window.location.href = res.data.redirect;
                        }, 1500);
                    } else {
                        showMsg(regForm, 'error', '❌ ' + res.data.message);
                        btn.querySelector('.btn-text').textContent = 'Create Account →';
                        btn.disabled = false;
                    }
                })
                .catch(function() {
                    showMsg(regForm, 'error', '❌ Something went wrong. Please try again.');
                    btn.querySelector('.btn-text').textContent = 'Create Account →';
                    btn.disabled = false;
                });
            });
        }

        // Login form AJAX
        var loginForm = document.getElementById('mytheme-login-form');
        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                e.preventDefault();
                var btn = loginForm.querySelector('.auth-submit');
                
                loginForm.querySelectorAll('.auth-error, .auth-success').forEach(function(el) { el.remove(); });
                
                btn.querySelector('.btn-text').textContent = 'Logging in...';
                btn.disabled = true;

                var data = new FormData(loginForm);
                data.append('action', 'mytheme_login_user');

                fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                    method: 'POST',
                    body: data
                })
                .then(function(r) { return r.json(); })
                .then(function(res) {
                    if (res.success) {
                        showMsg(loginForm, 'success', '✅ ' + res.data.message);
                        setTimeout(function() {
                            window.location.href = res.data.redirect;
                        }, 1000);
                    } else {
                        showMsg(loginForm, 'error', '❌ ' + res.data.message);
                        btn.querySelector('.btn-text').textContent = 'Login →';
                        btn.disabled = false;
                    }
                })
                .catch(function() {
                    showMsg(loginForm, 'error', '❌ Something went wrong. Please try again.');
                    btn.querySelector('.btn-text').textContent = 'Login →';
                    btn.disabled = false;
                });
            });
        }

        function showMsg(form, type, msg) {
            var div = document.createElement('div');
            div.className = 'auth-' + type;
            div.textContent = msg;
            form.querySelector('.auth-submit').before(div);
            div.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    });
    </script>
    <?php
    return ob_get_clean();
}
add_shortcode('mytheme_auth_form', 'mytheme_auth_form_shortcode');

/**
 * 7. AJAX handler for Registration
 */
add_action('wp_ajax_nopriv_mytheme_register_user', 'mytheme_handle_ajax_register');
function mytheme_handle_ajax_register() {
    // Verify nonce
    if (!isset($_POST['mytheme_register_nonce']) || !wp_verify_nonce($_POST['mytheme_register_nonce'], 'mytheme-register-nonce')) {
        wp_send_json_error(array('message' => 'Security check failed. Please refresh the page.'));
    }

    $firstname = sanitize_text_field($_POST['reg_firstname'] ?? '');
    $lastname  = sanitize_text_field($_POST['reg_lastname'] ?? '');
    $email     = sanitize_email($_POST['reg_email'] ?? '');
    $password  = $_POST['reg_password'] ?? '';
    $redirect  = esc_url_raw($_POST['redirect_to'] ?? wc_get_checkout_url());

    if (empty($firstname)) {
        wp_send_json_error(array('message' => 'First name is required.'));
    }
    if (!is_email($email)) {
        wp_send_json_error(array('message' => 'Please enter a valid email address.'));
    }
    if (email_exists($email)) {
        wp_send_json_error(array('message' => 'This email is already registered. Please log in.'));
    }
    if (strlen($password) < 6) {
        wp_send_json_error(array('message' => 'Password must be at least 6 characters long.'));
    }

    // Create username from email
    $username = sanitize_user(current(explode('@', $email)), true);
    $username = $username ?: 'user_' . time();
    if (username_exists($username)) {
        $username = $username . '_' . rand(100, 999);
    }

    $user_id = wp_create_user($username, $password, $email);
    if (is_wp_error($user_id)) {
        wp_send_json_error(array('message' => $user_id->get_error_message()));
    }

    // Update display name
    wp_update_user(array(
        'ID'           => $user_id,
        'first_name'   => $firstname,
        'last_name'    => $lastname,
        'display_name' => trim($firstname . ' ' . $lastname),
        'role'         => 'customer',
    ));

    // Auto-login after registration
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id, true);

    // Send welcome email
    wp_mail($email, 'Welcome to ' . get_bloginfo('name'), "Hello $firstname! Your account has been successfully created. You can now place orders.");

    wp_send_json_success(array(
        'message'  => 'Account created! A welcome email has been sent. Redirecting to checkout...',
        'redirect' => $redirect,
    ));
}

/**
 * 7b. AJAX handler for Login
 */
add_action('wp_ajax_nopriv_mytheme_login_user', 'mytheme_handle_ajax_login');
add_action('wp_ajax_mytheme_login_user', 'mytheme_handle_ajax_login');
function mytheme_handle_ajax_login() {
    if (!isset($_POST['mytheme_login_nonce']) || !wp_verify_nonce($_POST['mytheme_login_nonce'], 'mytheme-login-nonce')) {
        wp_send_json_error(array('message' => 'Security check failed. Please refresh the page.'));
    }

    $creds = array();
    $creds['user_login']    = sanitize_user($_POST['log'] ?? '');
    $creds['user_password'] = $_POST['pwd'] ?? '';
    $creds['remember']      = isset($_POST['rememberme']) ? true : false;
    
    $redirect = esc_url_raw($_POST['redirect_to'] ?? wc_get_checkout_url());

    if (empty($creds['user_login']) || empty($creds['user_password'])) {
        wp_send_json_error(array('message' => 'Username and password are required.'));
    }

    $user = wp_signon($creds, is_ssl() ? true : false);

    if (is_wp_error($user)) {
        // Remove HTML tags from default WordPress HTML error responses
        $error_msg = strip_tags($user->get_error_message());
        wp_send_json_error(array('message' => $error_msg));
    } else {
        wp_send_json_success(array(
            'message'  => 'Login successful! Redirecting...',
            'redirect' => $redirect,
        ));
    }
}

/**
 * 8. Auto-create "My Account" page if it doesn't exist (for login form)
 */
add_action('init', 'mytheme_create_account_page');
function mytheme_create_account_page() {
    if (get_option('mytheme_account_page_created_v3')) return;
    
    // Clean up old or duplicate pages
    $mera   = get_page_by_path('mera-account');
    $page_2 = get_page_by_path('my-account-2');
    $page_1 = get_page_by_path('my-account');
    
    if ($mera) wp_delete_post($mera->ID, true);
    if ($page_2) wp_delete_post($page_2->ID, true);

    if (!$page_1) {
        $page_id = wp_insert_post(array(
            'post_title'   => 'My Account',
            'post_name'    => 'my-account',
            'post_status'  => 'publish',
            'post_type'    => 'page',
            'post_content' => '[mytheme_auth_form]',
        ));
        update_option('mytheme_account_page_id', $page_id);
        if (class_exists('WooCommerce')) {
            update_option('woocommerce_myaccount_page_id', $page_id);
        }
    } else {
        wp_update_post(array(
            'ID' => $page_1->ID,
            'post_title' => 'My Account',
            'post_content' => '[mytheme_auth_form]',
            'post_status' => 'publish'
        ));
        update_option('mytheme_account_page_id', $page_1->ID);
        if (class_exists('WooCommerce')) {
            update_option('woocommerce_myaccount_page_id', $page_1->ID);
        }
    }
    
    update_option('mytheme_account_page_created_v3', true);

    // Auto-create Webinars Page
    if (!get_page_by_path('webinars')) {
        wp_insert_post(array(
            'post_title'   => 'Webinars',
            'post_name'    => 'webinars',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ));
    }

    // Auto-create Tradeshows Page
    if (!get_page_by_path('tradeshows')) {
        wp_insert_post(array(
            'post_title'   => 'Trade Shows',
            'post_name'    => 'tradeshows',
            'post_status'  => 'publish',
            'post_type'    => 'page',
        ));
    }
}

/**
 * 9. Show notice on shop/product pages encouraging login for checkout
 */
add_action('wp_footer', 'mytheme_checkout_login_notice_script');
function mytheme_checkout_login_notice_script() {
    if (!is_user_logged_in() && (is_shop() || is_product() || is_product_category())) {
        $account_page = get_permalink(get_option('mytheme_account_page_id'));
        if (!$account_page) return;
        ?>
        <div id="mytheme-login-notice" style="display:none; position:fixed; bottom:20px; right:20px; z-index:9999; background:linear-gradient(135deg,#1a1a2e,#16213e); color:#fff; padding:1.25rem 1.5rem; border-radius:12px; max-width:320px; box-shadow:0 20px 60px rgba(0,0,0,0.5); border:1px solid rgba(255,255,255,0.1); font-family:'Inter',sans-serif;">
            <button onclick="document.getElementById('mytheme-login-notice').style.display='none'" style="position:absolute;top:8px;right:12px;background:none;border:none;color:rgba(255,255,255,0.5);font-size:18px;cursor:pointer;">×</button>
            <p style="margin:0 0 0.5rem;font-weight:700;font-size:1rem;">🔐 Please Login!</p>
            <p style="margin:0 0 1rem;font-size:0.85rem;color:rgba(255,255,255,0.7);">You need an account to place an order.</p>
            <a href="<?php echo esc_url($account_page); ?>" style="display:block;text-align:center;background:linear-gradient(135deg,#7c3aed,#a855f7);color:#fff;padding:0.6rem 1rem;border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;">Login / Register →</a>
        </div>
        <script>
        setTimeout(function() {
            var notice = document.getElementById('mytheme-login-notice');
            if (notice) notice.style.display = 'block';
        }, 3000);
        </script>
        <?php
    }
}

/**
 * Integrate Resend SMTP for WordPress Emails
 */
add_action('phpmailer_init', 'mytheme_resend_smtp_integration');
function mytheme_resend_smtp_integration($phpmailer) {
    $phpmailer->isSMTP();
    $phpmailer->Host       = 'smtp.resend.com';
    $phpmailer->SMTPAuth   = true;
    $phpmailer->Port       = 465; // Or 587
    $phpmailer->SMTPSecure = 'ssl'; // Or 'tls'
    $phpmailer->Username   = 'resend'; 
    $phpmailer->Password   = 're_4JGH7Y6J_3CRqytnW7qzBDYrxpLsVh2qz'; 

    
    // Default testing email from Resend. Change this once you have a verified domain.
    $phpmailer->setFrom('info@aimsint.in', 'AIPL Store'); 
}

// Force WordPress & WooCommerce to always use info@aimsint.in as sender 
add_filter('wp_mail_from', function($original_email_address) {
    return 'info@aimsint.in';
}, 999);

add_filter('wp_mail_from_name', function($original_email_from) {
    return 'AIPL Store';
}, 999);

/**
 * Global Email Replacement: Replace abhishekparochi3441@gmail.com with info@aimsint.in
 * This handles cases where the email might be stored in the database (e.g. WooCommerce settings)
 */
add_filter('woocommerce_email_footer_text', function($footer_text) {
    return str_replace('abhishekparochi3441@gmail.com', 'info@aimsint.in', $footer_text);
}, 999);

add_filter('option_admin_email', function($email) {
    return 'info@aimsint.in';
});

add_filter('gettext', function($translated_text, $text, $domain) {
    if (strpos($translated_text, 'abhishekparochi3441@gmail.com') !== false) {
        $translated_text = str_replace('abhishekparochi3441@gmail.com', 'info@aimsint.in', $translated_text);
    }
    return $translated_text;
}, 999, 3);

/**
 * Nuclear Option: Intercept ALL outgoing emails and replace the old address
 */
add_filter('wp_mail', function($args) {
    if (isset($args['message'])) {
        $args['message'] = str_replace('abhishekparochi3441@gmail.com', 'info@aimsint.in', $args['message']);
    }
    return $args;
}, 9999);

// Add a test tool to immediately check why mail is failing
add_action('template_redirect', function() {
    if (isset($_GET['test_email'])) {
        $to = 'info@aimsint.in'; 
        
        global $phpmailer;
        if (!is_object($phpmailer) || !is_a($phpmailer, 'PHPMailer\\PHPMailer\\PHPMailer')) {
            require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
            require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
            require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';
            $phpmailer = new \PHPMailer\PHPMailer\PHPMailer(true);
        }
        
        add_action('phpmailer_init', function($mailer) {
            $mailer->SMTPDebug = 3; 
        });

        add_action('wp_mail_failed', function($error) {
            echo '<h2 style="color:red;">Error Details:</h2><pre>';
            print_r($error);
            echo '</pre>';
        });

        echo "<h2>Testing Resend Email Connection...</h2><hr><pre>";
        $test_msg = 'Ye ek test email hai. Old email check: abhishekparochi3441@gmail.com should be replaced by info@aimsint.in automatically.';
        $sent = wp_mail($to, 'Test Email from AIPL Store', $test_msg);
        echo "</pre><hr>";
        
        if ($sent) {
            echo "<h1 style='color:green;'>SUCCESS!</h1>";
            echo "<p>Email $to par bhej diya gaya hai! kripya apna Gmail Inbiox/Spam check karein.</p>";
        } else {
            echo "<h1 style='color:red;'>FAILED!</h1>";
            echo "<p>Mail nahi gaya. Upar diye gaye Error ko Check karein.</p>";
        }
        exit;
    }
});

// ═══════════════════════════════════════════════════════════════════════════
// CUSTOM ORDER SHIPMENT TRACKING SYSTEM WITH DYNAMIC COURIERS
// ═══════════════════════════════════════════════════════════════════════════

/**
 * 0. Create Courier Settings Page under WooCommerce Menu
 */
add_action('admin_menu', 'mytheme_courier_settings_menu');
function mytheme_courier_settings_menu() {
    add_submenu_page(
        'woocommerce',
        'Courier Settings',
        'Courier Settings',
        'manage_woocommerce',
        'mytheme-courier-settings',
        'mytheme_courier_settings_page'
    );
}

function mytheme_courier_settings_page() {
    // Handle Save
    if (isset($_POST['mytheme_couriers_nonce']) && wp_verify_nonce($_POST['mytheme_couriers_nonce'], 'mytheme_save_couriers')) {
        // Sanitize deeply without removing URLs
        $couriers_data = sanitize_textarea_field(wp_unslash($_POST['mytheme_couriers_data']));
        update_option('mytheme_custom_couriers', $_POST['mytheme_couriers_data']); // wp_unslash already handled by WP magic, so raw save is fine
        echo '<div class="notice notice-success is-dismissible"><p>Courier URLs saved successfully!</p></div>';
    }
    
    $default_couriers = "DHL | https://www.dhl.com/in-en/home/tracking/tracking-express.html?submit=1&tracking-id=[NUMBER]\nBlueDart | https://www.bluedart.com/web/guest/trackdartresult?trackFor=0&trackNo=[NUMBER]\nDelhivery | https://www.delhivery.com/track/package/[NUMBER]\nTrackon | https://trackon.in/Tracking/Result?tracking_number=[NUMBER]";
    $current_couriers = get_option('mytheme_custom_couriers', $default_couriers);
    ?>
    <div class="wrap">
        <h1>📦 Store Courier Settings</h1>
        <p>Define your courier companies and their tracking URL structure below.</p>
        <div style="background:#fff; border:1px solid #ccc; padding:15px; margin-bottom:20px;">
            <strong>Format Rule:</strong> <code>Courier Name | Tracking URL containing [NUMBER]</code><br>
            <em>* Please separate the name and URL using the <strong>|</strong> symbol. Put each courier on a new line.</em><br>
            <em>* Ensure you write <strong>[NUMBER]</strong> exactly where the AWB tracking parameter should go.</em>
        </div>
        
        <form method="post" action="">
            <?php wp_nonce_field('mytheme_save_couriers', 'mytheme_couriers_nonce'); ?>
            <textarea name="mytheme_couriers_data" rows="12" style="font-family: monospace; width:100%; max-width:900px; padding:15px; line-height:1.5; font-size:14px; background:#f9f9f9; border:1px solid #999;"><?php echo esc_textarea(stripslashes($current_couriers)); ?></textarea>
            <br><br>
            <input type="submit" class="button button-primary button-hero" value="Save Courier List">
        </form>
    </div>
    <?php
}

// Utility function to get couriers as Array
function mytheme_get_parsed_couriers() {
    $default_couriers = "DHL | https://www.dhl.com/in-en/home/tracking/tracking-express.html?submit=1&tracking-id=[NUMBER]\nBlueDart | https://www.bluedart.com/web/guest/trackdartresult?trackFor=0&trackNo=[NUMBER]\nDelhivery | https://www.delhivery.com/track/package/[NUMBER]\nTrackon | https://trackon.in/Tracking/Result?tracking_number=[NUMBER]";
    $raw = get_option('mytheme_custom_couriers', $default_couriers);
    
    $couriers = array();
    $lines = explode("\n", str_replace("\r", "", stripslashes($raw)));
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        $parts = explode('|', $line, 2);
        if (count($parts) == 2) {
            $name = trim($parts[0]);
            $url = trim($parts[1]);
            $slug = sanitize_title($name);
            $couriers[$slug] = array(
                'name' => $name,
                'url'  => $url
            );
        }
    }
    return $couriers;
}

/**
 * 1. Add fields to the WooCommerce Admin Order Edit Page
 */
add_action('woocommerce_admin_order_data_after_shipping_address', 'mytheme_add_tracking_fields');
function mytheme_add_tracking_fields($order) {
    if (!$order) return;
    $tracking_provider = $order->get_meta('_tracking_provider');
    $tracking_number   = $order->get_meta('_tracking_number');
    
    // Construct options from settings
    $parsed_couriers = mytheme_get_parsed_couriers();
    $dropdown_options = array('' => '-- Select Courier --');
    foreach ($parsed_couriers as $slug => $data) {
        $dropdown_options[$slug] = $data['name'];
    }

    echo '<div style="clear:both; margin-top:20px; padding:10px; background:#f5f5f5; border:1px solid #ddd; border-radius:4px;">';
    echo '<h4>📦 Shipment Tracking (Custom)</h4>';
    
    woocommerce_wp_select(array(
        'id'            => '_tracking_provider',
        'label'         => 'Courier Company',
        'wrapper_class' => 'form-field-wide',
        'value'         => $tracking_provider,
        'options'       => $dropdown_options
    ));
    
    woocommerce_wp_text_input(array(
        'id'            => '_tracking_number',
        'label'         => 'Tracking Number',
        'value'         => $tracking_number,
        'wrapper_class' => 'form-field-wide',
        'placeholder'   => 'e.g. 123456789'
    ));
    echo '<p style="color:#666; font-size:12px;">Ye details Customer ko order "Completed" hone wali email me automatically bhej di jayengi.</p>';
    
    // Add Admin Track Verification Button if data exists
    if ($tracking_provider && $tracking_number && isset($parsed_couriers[$tracking_provider])) {
        $base_url = $parsed_couriers[$tracking_provider]['url'];
        $tracking_link = '';
        if (strpos($base_url, '[BASE64_SPEEDPOST]') !== false) {
            $b64_payload = base64_encode('{"t":"' . $tracking_number . '","c":"speedpost"}');
            $tracking_link = str_replace('[BASE64_SPEEDPOST]', $b64_payload, $base_url);
        } else {
            $tracking_link = str_replace('[NUMBER]', urlencode($tracking_number), $base_url);
        }
        
        if ($tracking_link) {
            echo '<div style="margin-top:15px; padding-top:15px; border-top:1px dashed #ccc;">';
            echo '<a href="' . esc_url($tracking_link) . '" target="_blank" class="button button-secondary" style="display:inline-flex; align-items:center; gap:5px;"><span class="dashicons dashicons-external"></span> 🔍 Test Tracking Link (Admin View)</a>';
            echo '</div>';
        }
    }
    
    echo '</div>';
}

/**
 * 2. Save the metadata when Admin saves the order
 */
add_action('woocommerce_process_shop_order_meta', 'mytheme_save_tracking_fields', 10, 2);
function mytheme_save_tracking_fields($order_id, $post) {
    if (!$order_id) return;
    $order = wc_get_order($order_id);
    if (!$order) return;
    
    if (isset($_POST['_tracking_provider'])) {
        $order->update_meta_data('_tracking_provider', sanitize_text_field($_POST['_tracking_provider']));
    }
    if (isset($_POST['_tracking_number'])) {
        $order->update_meta_data('_tracking_number', sanitize_text_field($_POST['_tracking_number']));
    }
    
    $order->save();
}

/**
 * 3. Add Tracking Details to WooCommerce Emails sent to Customer
 */
add_action('woocommerce_email_order_meta', 'mytheme_add_tracking_to_email', 20, 3);
function mytheme_add_tracking_to_email($order, $sent_to_admin, $plain_text) {
    if ($sent_to_admin || $plain_text) return;

    $tracking_provider = $order->get_meta('_tracking_provider');
    $tracking_number   = $order->get_meta('_tracking_number');

    if ($tracking_number) {
        $parsed_couriers = mytheme_get_parsed_couriers();
        
        $tracking_link = '';
        $c_name = 'Courier';
        
        // Match the saved provider slug to construct dynamic URL
        if (isset($parsed_couriers[$tracking_provider])) {
            $c_name = $parsed_couriers[$tracking_provider]['name'];
            $base_url = $parsed_couriers[$tracking_provider]['url'];
            
            // Support for advanced base64 encrypted endpoints (like speedposttrack.io)
            if (strpos($base_url, '[BASE64_SPEEDPOST]') !== false) {
                // Prepares JSON: {"t":"AWB...","c":"speedpost"} automatically and base64 encodes it
                $b64_payload = base64_encode('{"t":"' . $tracking_number . '","c":"speedpost"}');
                $tracking_link = str_replace('[BASE64_SPEEDPOST]', $b64_payload, $base_url);
            } else {
                // Inject the tracking number dynamically where [NUMBER] is found
                $tracking_link = str_replace('[NUMBER]', urlencode($tracking_number), $base_url);
            }
        }

        $html  = '<div style="background: linear-gradient(135deg, #1e1e2f, #1a1a2e); padding: 25px; border-radius: 12px; margin: 30px 0; border: 1px solid rgba(139, 92, 246, 0.3); text-align: center; color: #fff; font-family: Helvetica, Arial, sans-serif;">';
        $html .= '<h2 style="color: #fff; margin-top: 0; display:flex; align-items:center; justify-content:center; gap:10px;">📦 Shipment Dispatched!</h2>';
        $html .= '<p style="font-size: 16px; color: #cbd5e1; margin-bottom: 20px;">Your order has been shipped via <strong>' . esc_html($c_name) . '</strong>. You can track it using the details below:</p>';
        
        $html .= '<div style="background: rgba(255,255,255,0.05); padding: 15px; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); display: inline-block; margin-bottom: 25px;">';
        $html .= '<span style="font-size: 13px; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; display: block; margin-bottom: 5px;">Tracking Number</span>';
        $html .= '<strong style="font-size: 22px; color: #8b5cf6; letter-spacing: 2px;">' . esc_html($tracking_number) . '</strong>';
        $html .= '</div><br>';

        if ($tracking_link) {
            $html .= '<a href="' . esc_url($tracking_link) . '" style="background: #8b5cf6; color: #ffffff; font-weight: bold; font-size: 16px; text-decoration: none; padding: 14px 30px; border-radius: 8px; display: inline-block; box-shadow: 0 4px 15px rgba(139, 92, 246, 0.4);">Track Your Package &rarr;</a>';
        }
        
        $html .= '</div>';
        
        echo $html;
    }
}

/**
 * 4. Add "Track" button to My Account > Orders List
 */
add_filter('woocommerce_my_account_my_orders_actions', 'mytheme_my_account_track_button', 10, 2);
function mytheme_my_account_track_button($actions, $order) {
    if (!$order) return $actions;
    
    $tracking_provider = $order->get_meta('_tracking_provider');
    $tracking_number   = $order->get_meta('_tracking_number');

    if ($tracking_provider && $tracking_number) {
        $parsed_couriers = mytheme_get_parsed_couriers();
        $tracking_link = '';
        
        if (isset($parsed_couriers[$tracking_provider])) {
            $base_url = $parsed_couriers[$tracking_provider]['url'];
            if (strpos($base_url, '[BASE64_SPEEDPOST]') !== false) {
                $b64_payload = base64_encode('{"t":"' . $tracking_number . '","c":"speedpost"}');
                $tracking_link = str_replace('[BASE64_SPEEDPOST]', $b64_payload, $base_url);
            } else {
                $tracking_link = str_replace('[NUMBER]', urlencode($tracking_number), $base_url);
            }
        }
        
        if ($tracking_link) {
            // Insert it before other actions or just append it
            $actions['track-order'] = array(
                'url'  => $tracking_link,
                'name' => '📦 Track',
            );
        }
    }
    return $actions;
}

/**
 * 5. Style the Track Order button on My Account page
 */
add_action('wp_head', function() {
    // Only load this CSS on WooCommerce account pages
    if (function_exists('is_account_page') && is_account_page()) {
        echo '<style>
            a.button.track-order {
                background: #8b5cf6 !important;
                color: #ffffff !important;
                border: 1px solid #7c3aed !important;
                margin-left: 12px !important;
                border-radius: 6px !important;
                font-weight: 600 !important;
                transition: all 0.3s ease !important;
                padding: 8px 16px !important;
            }
            a.button.track-order:hover {
                background: #7c3aed !important;
                border-color: #6d28d9 !important;
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(139, 92, 246, 0.4) !important;
            }
        </style>';
    }
});

/**
 * Add Meta Box for Hero Slide Options
 */
function mytheme_add_hero_slide_metabox() {
    add_meta_box(
        'hero_slide_options',
        'Hero Slide Options',
        'mytheme_hero_slide_metabox_html',
        'hero_slide',
        'normal',
        'default'
    );
}
add_action('add_meta_boxes', 'mytheme_add_hero_slide_metabox');

function mytheme_hero_slide_metabox_html($post) {
    wp_nonce_field('mytheme_save_hero_slide_metabox_data', 'mytheme_hero_slide_meta_nonce');

    $subtitle = get_post_meta($post->ID, 'hero_subtitle', true);
    $btn_text = get_post_meta($post->ID, 'hero_btn_text', true);
    $btn_link = get_post_meta($post->ID, 'hero_btn_link', true);
    $btn2_text = get_post_meta($post->ID, 'hero_btn2_text', true);
    $btn2_link = get_post_meta($post->ID, 'hero_btn2_link', true);
    ?>
    <style>
        .hero-mb-item { margin-bottom: 1em; }
        .hero-mb-item label { display: inline-block; width: 120px; font-weight: bold; }
        .hero-mb-item input { width: 100%; max-width: 400px; }
    </style>
    <div class="hero-mb-item">
        <label for="hero_subtitle">Subtitle</label>
        <input type="text" id="hero_subtitle" name="hero_subtitle" value="<?php echo esc_attr($subtitle); ?>">
    </div>
    <hr>
    <div class="hero-mb-item">
        <label for="hero_btn_text">Button 1 Text</label>
        <input type="text" id="hero_btn_text" name="hero_btn_text" value="<?php echo esc_attr($btn_text); ?>" placeholder="Press Release">
    </div>
    <div class="hero-mb-item">
        <label for="hero_btn_link">Button 1 Link</label>
        <input type="url" id="hero_btn_link" name="hero_btn_link" value="<?php echo esc_attr($btn_link); ?>">
    </div>
    <hr>
    <div class="hero-mb-item">
        <label for="hero_btn2_text">Button 2 Text</label>
        <input type="text" id="hero_btn2_text" name="hero_btn2_text" value="<?php echo esc_attr($btn2_text); ?>" placeholder="Learn More">
    </div>
    <div class="hero-mb-item">
        <label for="hero_btn2_link">Button 2 Link</label>
        <input type="url" id="hero_btn2_link" name="hero_btn2_link" value="<?php echo esc_attr($btn2_link); ?>">
    </div>
    <?php
}

function mytheme_save_hero_slide_metabox_data($post_id) {
    if (!isset($_POST['mytheme_hero_slide_meta_nonce'])) {
        return;
    }
    if (!wp_verify_nonce($_POST['mytheme_hero_slide_meta_nonce'], 'mytheme_save_hero_slide_metabox_data')) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    $fields = ['hero_subtitle', 'hero_btn_text', 'hero_btn_link', 'hero_btn2_text', 'hero_btn2_link'];
    foreach ($fields as $field) {
        if (isset($_POST[$field])) {
            update_post_meta($post_id, $field, sanitize_text_field($_POST[$field]));
        } else {
            delete_post_meta($post_id, $field);
        }
    }
}
add_action('save_post_hero_slide', 'mytheme_save_hero_slide_metabox_data');

/**
 * AUTO-CREATE FOOTER PAGES
 * This function creates all the pages linked in the footer and assigns their templates.
 */
function mytheme_create_footer_pages() {
    if (get_option('mytheme_footer_pages_created')) return;

    $footer_pages = array(
        'About Us' => 'page-about-us.php',
        'Contact Us' => 'page-contact-us.php',
        'PCB Manufacturing Capabilities' => 'page-pcb-manufacturing-capabilities.php',
        'Track Your Order' => 'page-track-your-order.php',
        'Quality & Certifications' => 'page-technical-content.php',
        'Design Guidelines' => 'page-technical-content.php',
        'Component Library' => 'page-technical-content.php',
        'HDI PCB Design' => 'page-technical-content.php',
        'High-Frequency PCBs' => 'page-technical-content.php',
        'Flex & Rigid-Flex PCBs' => 'page-technical-content.php',
        'What is an HDI PCB?' => 'page-technical-content.php',
        'How to Export Gerber Files?' => 'page-technical-content.php',
        'Understanding Impedance Control' => 'page-technical-content.php',
    );

    foreach ($footer_pages as $title => $template) {
        $page_check = get_page_by_title($title);
        if (!isset($page_check->ID)) {
            $page_id = wp_insert_post(array(
                'post_title'   => $title,
                'post_type'    => 'page',
                'post_status'  => 'publish',
                'post_content' => 'This is a placeholder for the ' . $title . ' page. You can edit this content in the WordPress admin panel.',
            ));

            if ($page_id && $template) {
                update_post_meta($page_id, '_wp_page_template', $template);
            }
        } else {
            // Already exists, just update template if not set
            update_post_meta($page_check->ID, '_wp_page_template', $template);
        }
    }

    update_option('mytheme_footer_pages_created', true);
}
add_action('admin_init', 'mytheme_create_footer_pages');

/**
 * Remove Related Products on Single Product Page
 */
remove_action( "woocommerce_after_single_product_summary", "woocommerce_output_related_products", 20 );


/**
 * Auto-create Careers page on theme activation or init
 */
function mytheme_create_careers_page() {
    if (get_page_by_path('careers')) return;

    $page_id = wp_insert_post(array(
        'post_title'     => 'Careers',
        'post_name'      => 'careers',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'page_template'  => 'page-careers.php'
    ));
}
add_action('init', 'mytheme_create_careers_page');


/**
 * 10. REGISTER CAREERS CUSTOM POST TYPE
 */
function mytheme_register_careers_cpt() {
    $labels = array(
        "name" => "Careers",
        "singular_name" => "Job Opening",
        "menu_name" => "Careers",
        "all_items" => "All Job Openings",
        "add_new" => "Add New Open Role",
        "add_new_item" => "Add New Job Opening",
        "edit_item" => "Edit Job Opening",
        "new_item" => "New Job Opening",
        "view_item" => "View Job Opening",
        "search_items" => "Search Careers",
        "not_found" => "No jobs found",
    );
    $args = array(
        "label" => "Careers",
        "labels" => $labels,
        "description" => "Manage job openings and internships.",
        "public" => true,
        "show_ui" => true,
        "show_in_menu" => true,
        "capability_type" => "post",
        "hierarchical" => false,
        "rewrite" => array("slug" => "career-opening", "with_front" => true),
        "query_var" => true,
        "menu_icon" => "dashicons-businessperson",
        "supports" => array("title", "editor", "excerpt"),
    );
    register_post_type("career", $args);
}
add_action("init", "mytheme_register_careers_cpt");

/**
 * JOB DETAILS METABOX
 */
function mytheme_add_job_metabox() {
    add_meta_box("job_details", "JOB SETTINGS", "mytheme_job_metabox_html", "career", "normal", "high");
}
add_action("add_meta_boxes", "mytheme_add_job_metabox");

function mytheme_job_metabox_html($post) {
    $location = get_post_meta($post->ID, "_job_location", true);
    $type = get_post_meta($post->ID, "_job_type", true);
    $salary = get_post_meta($post->ID, "_job_salary", true);
    ?>
    <div style="padding:10px;">
        <p>
            <label>Location (e.g. Remote, New Delhi):</label><br>
            <input type="text" name="job_location" value="<?php echo esc_attr($location); ?>" style="width:100%;">
        </p>
        <p>
            <label>Job Type (e.g. Full-time, Internship):</label><br>
            <input type="text" name="job_type" value="<?php echo esc_attr($type); ?>" style="width:100%;">
        </p>
        <p>
            <label>Salary/Compensation (e.g. Competitive, Unpaid):</label><br>
            <input type="text" name="job_salary" value="<?php echo esc_attr($salary); ?>" style="width:100%;">
        </p>
    </div>
    <?php
}

function mytheme_save_job_meta($post_id) {
    if (isset($_POST["job_location"])) update_post_meta($post_id, "_job_location", sanitize_text_field($_POST["job_location"]));
    if (isset($_POST["job_type"])) update_post_meta($post_id, "_job_type", sanitize_text_field($_POST["job_type"]));
    if (isset($_POST["job_salary"])) update_post_meta($post_id, "_job_salary", sanitize_text_field($_POST["job_salary"]));
}
add_action("save_post_career", "mytheme_save_job_meta");


/**
 * Auto-create Job Application page
 */
function mytheme_create_job_app_page() {
    if (get_page_by_path('apply-now')) return;

    wp_insert_post(array(
        'post_title'     => 'Apply Now',
        'post_name'      => 'apply-now',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'page_template'  => 'page-job-application.php'
    ));
}
add_action('init', 'mytheme_create_job_app_page');


/**
 * 11. REGISTER JOB APPLICATIONS CPT (FOR STORING SUBMISSIONS)
 */
function mytheme_register_job_applications_cpt() {
    register_post_type("job_application", array(
        "labels" => array("name" => "Applications", "singular_name" => "Application"),
        "public" => false, 
        "show_ui" => true,
        "show_in_menu" => "edit.php?post_type=career", // Nesting under Careers
        "supports" => array("title"),
        "menu_icon" => "dashicons-email-alt",
    ));
}
add_action("init", "mytheme_register_job_applications_cpt");

/**
 * Handle Form Submission via AJAX
 */
add_action("wp_ajax_submit_job_application", "mytheme_handle_job_application");
add_action("wp_ajax_nopriv_submit_job_application", "mytheme_handle_job_application");

function mytheme_handle_job_application() {
    if (!isset($_POST["name"])) wp_send_json_error("Missing data");

    $name = sanitize_text_field($_POST["name"]);
    $email = sanitize_email($_POST["email"]);
    $job = sanitize_text_field($_POST["job"] ?? "Unknown Position");

    $post_id = wp_insert_post(array(
        "post_title" => $name . " - " . $job,
        "post_type"  => "job_application",
        "post_status"=> "publish",
    ));

    if ($post_id) {
        update_post_meta($post_id, "_app_email", $email);
        update_post_meta($post_id, "_app_phone", sanitize_text_field($_POST["phone"] ?? ""));
        update_post_meta($post_id, "_app_exp", sanitize_text_field($_POST["experience"] ?? ""));
        update_post_meta($post_id, "_app_linkedin", esc_url_raw($_POST["linkedin"] ?? ""));
        update_post_meta($post_id, "_app_about", sanitize_textarea_field($_POST["about"] ?? ""));
        update_post_meta($post_id, "_app_job", $job);

        // Handle File Upload
        if (!empty($_FILES["resume"]["name"])) {
            require_once(ABSPATH . "wp-admin/includes/file.php");
            $attachment_id = media_handle_upload("resume", $post_id);
            if (!is_wp_error($attachment_id)) {
                update_post_meta($post_id, "_app_resume_id", $attachment_id);
            }
        }
        wp_send_json_success("Application submitted successfully!");
    }
    wp_send_json_error("Failed to save application");
}

/**
 * Add Columns to Applications List
 */
add_filter("manage_job_application_posts_columns", function($cols) {
    $cols["app_job"] = "Position";
    $cols["app_email"] = "Email";
    $cols["app_cv"] = "CV";
    return $cols;
});

add_action("manage_job_application_posts_custom_column", function($col, $post_id) {
    switch ($col) {
        case "app_job": echo get_post_meta($post_id, "_app_job", true); break;
        case "app_email": echo get_post_meta($post_id, "_app_email", true); break;
        case "app_cv": 
            $cv_id = get_post_meta($post_id, "_app_resume_id", true);
            if ($cv_id) echo "<a href=\"".wp_get_attachment_url($cv_id)."\" target=\"_blank\">?? View CV</a>";
            break;
    }
}, 10, 2);


/**
 * 12. JOB APPLICATION STATUS TRACKING
 */

// Add Status field to Admin Application editor
add_action("add_meta_boxes", function() {
    add_meta_box("app_status_box", "Application Status", "mytheme_app_status_html", "job_application", "side", "high");
});

function mytheme_app_status_html($post) {
    $status = get_post_meta($post->ID, "_app_status", true) ?: "Under Review";
    $options = array("Under Review", "Shortlisted", "Interview Scheduled", "On Hold", "Rejected");
    echo "<select name=\"app_status\" style=\"width:100%;\">";
    foreach ($options as $opt) {
        echo "<option value=\"$opt\" " . selected($status, $opt, false) . ">$opt</option>";
    }
    echo "</select>";
}

add_action("save_post_job_application", function($post_id) {
    if (isset($_POST["app_status"])) update_post_meta($post_id, "_app_status", sanitize_text_field($_POST["app_status"]));
});

// Add to Profile Dropdown (Assuming it is in header.php or a specific function)
// I will look for the dropdown code in header.php or functions.php first.


/**
 * Auto-create Track Application page
 */
function mytheme_create_track_app_page() {
    if (get_page_by_path('track-application')) return;

    wp_insert_post(array(
        'post_title'     => 'Track Application',
        'post_name'      => 'track-application',
        'post_content'   => '',
        'post_status'    => 'publish',
        'post_type'      => 'page',
        'page_template'  => 'page-track-application.php'
    ));
}
add_action('init', 'mytheme_create_track_app_page');



/* Force Single Column for Vertical Thumbnails Gallery */
add_filter( 'woocommerce_product_thumbnails_columns', function() {
    return 1;
} );

/**
 * -- Product Custom Meta: Color Count ------------------------------------------
 */
add_action('woocommerce_product_options_general_product_data', 'mytheme_add_custom_product_fields');
function mytheme_add_custom_product_fields() {
    woocommerce_wp_text_input(array(
        'id'          => '_boat_color_count',
        'label'       => __('Color Count Text', 'woocommerce'),
        'description' => __('Enter the text to show for extra colors (e.g., +4)', 'woocommerce'),
        'desc_tip'    => 'true',
        'placeholder' => '+4',
    ));
}

add_action('woocommerce_process_product_meta', 'mytheme_save_custom_product_fields');
function mytheme_save_custom_product_fields($post_id) {
    if (isset($_POST['_boat_color_count'])) {
        update_post_meta($post_id, '_boat_color_count', sanitize_text_field($_POST['_boat_color_count']));
    }
}
