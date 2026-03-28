<?php get_header(); ?> 

<main>
    <!-- Hero Slider Section -->
    <div class="hero-slider-wrapper">
        <?php
        $args = array(
            'post_type'      => 'hero_slide',
            'posts_per_page' => 5,
            'orderby'        => 'menu_order',
            'order'          => 'ASC',
        );
        $hero_query = new WP_Query($args);
        $slide_count = 0;

        if ($hero_query->have_posts()) :
            while ($hero_query->have_posts()) : $hero_query->the_post();
                $subtitle = get_post_meta(get_the_ID(), 'hero_subtitle', true);
                $btn_text = get_post_meta(get_the_ID(), 'hero_btn_text', true);
                $btn_link = get_post_meta(get_the_ID(), 'hero_btn_link', true);
                $btn2_text = get_post_meta(get_the_ID(), 'hero_btn2_text', true);
                $btn2_link = get_post_meta(get_the_ID(), 'hero_btn2_link', true);
                $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'full');
                ?>
                <section id="hero-<?php echo $slide_count; ?>" class="hero hero-slide <?php echo ($slide_count === 0) ? 'active' : ''; ?>" style="background-image: linear-gradient(rgba(9, 9, 11, 0.3), rgba(9, 9, 11, 0.3)), url('<?php echo esc_url($bg_image); ?>');">
                    <div class="container hero-content">
                        <?php if ($subtitle) : ?>
                            <p class="hero-subtitle"><?php echo esc_html($subtitle); ?></p>
                        <?php endif; ?>
                        <h1 class="hero-title"><?php the_title(); ?></h1>
                        <p><?php echo get_the_content(); ?></p>
                        <div class="hero-btns">
                            <a href="<?php echo esc_url($btn_link ? $btn_link : '#'); ?>" class="btn btn-primary"><?php echo esc_html($btn_text ? $btn_text : 'Press Release'); ?> &nbsp; &rarr;</a>
                            <a href="<?php echo esc_url($btn2_link ? $btn2_link : '#'); ?>" class="btn btn-secondary"><?php echo esc_html($btn2_text ? $btn2_text : 'Learn More'); ?> &nbsp; &rarr;</a>
                        </div>
                    </div>
                </section>
                <?php
                $slide_count++;
            endwhile;
            wp_reset_postdata();
        else :
            // Fallback to Customizer Settings
            ?>
            <section id="hero" class="hero active">
                <div class="container hero-content">
                    <p class="hero-subtitle"><?php echo esc_html(get_theme_mod('hero_subtitle', 'Innovation for the AI Era')); ?></p>
                    <h1 class="hero-title"><?php echo wp_kses_post(get_theme_mod('hero_title', 'Introducing Hardware-Assisted <span style="color: var(--primary);">Verification</span>')); ?></h1>
                    <p><?php echo esc_html(get_theme_mod('hero_description', 'Powering the era of pervasive intelligence from silicon to systems with industry-leading EDA tools.')); ?></p>
                    <div class="hero-btns">
                        <a href="#" class="btn btn-primary">Press Release &nbsp; &rarr;</a>
                        <a href="#" class="btn btn-secondary">Learn More &nbsp; &rarr;</a>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Slider Navigation (Bottom Tabs) -->
        <section class="slider-nav-section">
            <div class="container">
                <div class="slider-nav-container">
                    <?php
                    $nav_count = 0;
                    if ($hero_query->have_posts()) :
                        while ($hero_query->have_posts()) : $hero_query->the_post();
                            ?>
                            <div class="nav-slide-item <?php echo ($nav_count === 0) ? 'active' : ''; ?>" data-slide="<?php echo $nav_count; ?>">
                                <h3><?php the_title(); ?></h3>
                                <div class="progress-bar"></div>
                            </div>
                            <?php
                            $nav_count++;
                        endwhile;
                        wp_reset_postdata();
                    else:
                        // Static Fallback Tabs
                        $fallbacks = ['Synopsys Converge', 'Introducing HAV', 'Electronics Digital Twin', 'NVIDIA and Synopsys', 'Synopsys and Ansys'];
                        foreach($fallbacks as $i => $title) : ?>
                            <div class="nav-slide-item <?php echo ($i === 0) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>">
                                <h3><?php echo esc_html($title); ?></h3>
                                <div class="progress-bar"></div>
                            </div>
                        <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </section>
    </div>

    <!-- Pervasive Intelligence Section -->
    <section style="padding: 8rem 0; text-align: center;" class="reveal">
        <div class="container">
            <h2 style="font-size: 3rem; margin-bottom: 2rem;"><?php echo esc_html(get_theme_mod('pervasive_title', 'Powering the Era of Pervasive Intelligence from Silicon to Systems')); ?></h2>
            <div style="display: flex; justify-content: center; gap: 2rem; color: var(--text-muted); font-size: 1.1rem; font-weight: 500;">
                <?php
                $points_str = get_theme_mod('pervasive_points', 'Supercharge Productivity • Conquer Complexity • Accelerate Time-to-Market');
                $points = explode('•', $points_str);
                $count = count($points);
                foreach ($points as $index => $point) {
                    echo '<span>' . esc_html(trim($point)) . '</span>';
                    if ($index < $count - 1) {
                        echo '<span>•</span>';
                    }
                }
                ?>
            </div>

            <!-- Image Grid Added Below Text -->
            <div class="card-grid">
                <?php
                $default_titles_arr = array('Synopsys.ai', 'EDA', 'Systems', 'Silicon IP');
                for ($i = 1; $i <= 4; $i++) :
                    $img = get_theme_mod("pervasive_card_image_$i", '');
                    $title = get_theme_mod("pervasive_card_title_$i", $default_titles_arr[$i-1]);
                    $link = get_theme_mod("pervasive_card_link_$i", '#');
                    $bg = $img ? "background-image: url('" . esc_url($img) . "');" : "background: #18181b;";
                ?>
                <a href="<?php echo esc_url($link); ?>" class="card-item" style="<?php echo $bg; ?>">
                    <div class="card-item-title"><?php echo esc_html($title); ?></div>
                </a>
                <?php endfor; ?>
            </div>

        </div>
    </section>

    <!-- Design the Future Section -->
    <section style="background: #ffffff; padding: 6rem 0;" class="reveal">
        <div class="container">
            <h2 style="font-size: 2.5rem; text-align: center; margin-bottom: 4rem; font-weight: 300; color: #1f2937;">
                <?php echo esc_html(get_theme_mod('design_future_title', 'Design the Future Today with Synopsys')); ?>
            </h2>

            <div class="df-grid">
                <?php
                // Provide the exact same fallback defaults array so live site matches Customizer preview
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
                ?>

                <!-- Column 1 -->
                <div class="df-col">
                    <h3 class="df-col-title"><?php echo esc_html(get_theme_mod('design_future_col1_title', 'Industry')); ?></h3>
                    <div class="df-items">
                        <?php for ($i = 1; $i <= 4; $i++) : 
                            $icon = get_theme_mod("df_icon_$i", '');
                            $title = get_theme_mod("df_title_$i", $df_defaults[$i-1]['title']);
                            $desc = get_theme_mod("df_desc_$i", $df_defaults[$i-1]['desc']);
                            $link = get_theme_mod("df_link_$i", '#');
                            // Exclude layout if title and desc are entirely empty, to allow user to easily remove rows
                            if (empty($title) && empty($desc)) continue;
                            
                            $icon_src = $icon ? esc_url($icon) : 'https://via.placeholder.com/48x48?text=Icon';
                        ?>
                        <a href="<?php echo esc_url($link); ?>" class="df-item">
                            <div class="df-item-header">
                                <img src="<?php echo $icon_src; ?>" alt="Icon" class="df-item-icon">
                                <h4 class="df-item-title"><?php echo esc_html($title); ?></h4>
                            </div>
                            <p class="df-item-desc"><?php echo esc_html($desc); ?></p>
                        </a>
                        <?php endfor; ?>
                    </div>
                </div>

                <!-- Column 2 -->
                <div class="df-col">
                    <h3 class="df-col-title"><?php echo esc_html(get_theme_mod('design_future_col2_title', 'Technology')); ?></h3>
                    <div class="df-items">
                        <?php for ($i = 5; $i <= 8; $i++) : 
                            $icon = get_theme_mod("df_icon_$i", '');
                            $title = get_theme_mod("df_title_$i", $df_defaults[$i-1]['title']);
                            $desc = get_theme_mod("df_desc_$i", $df_defaults[$i-1]['desc']);
                            $link = get_theme_mod("df_link_$i", '#');

                            if (empty($title) && empty($desc)) continue;

                            $icon_src = $icon ? esc_url($icon) : 'https://via.placeholder.com/48x48?text=Icon';
                        ?>
                        <a href="<?php echo esc_url($link); ?>" class="df-item">
                            <div class="df-item-header">
                                <img src="<?php echo $icon_src; ?>" alt="Icon" class="df-item-icon">
                                <h4 class="df-item-title"><?php echo esc_html($title); ?></h4>
                            </div>
                            <p class="df-item-desc"><?php echo esc_html($desc); ?></p>
                        </a>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Ecosystem Partners Section -->
    <section style="background: #f8f9fa; padding: 5rem 0; text-align: center;" class="reveal">
        <div class="container">
            <h2 style="font-size: 2rem; font-weight: 300; color: #374151; margin-bottom: 4rem;">
                <?php echo esc_html(get_theme_mod('ecosystem_title', 'Ecosystem Partners')); ?>
            </h2>
            <?php $enable_marquee = get_theme_mod('ecosystem_marquee', true); ?>
            <div class="partner-logos-wrapper <?php echo $enable_marquee ? 'marquee-enabled' : ''; ?>">
                <div class="partner-logos">
                    <?php 
                    // To make a seamless marquee, we run 4 loops so the track is exceptionally wide. 
                    // This creates an infinite scrolling illusion.
                    $loops = $enable_marquee ? 4 : 1;
                    $has_logos = false;

                    for ($loop = 1; $loop <= $loops; $loop++) :
                        for ($i = 1; $i <= 6; $i++) :
                            $logo = get_theme_mod("ecosystem_logo_$i", '');
                            $link = get_theme_mod("ecosystem_link_$i", '#');
                            
                            if (empty($logo)) {
                                if (is_customize_preview()) {
                                    $logo = "https://via.placeholder.com/150x50?text=Logo+$i";
                                } else {
                                    continue;
                                }
                            }
                            $has_logos = true;
                    ?>
                    <a href="<?php echo esc_url($link); ?>" class="partner-logo" target="_blank" <?php echo ($loop > 1) ? 'aria-hidden="true"' : ''; ?>>
                        <img src="<?php echo esc_url($logo); ?>" alt="Ecosystem Partner <?php echo $i; ?>" loading="lazy">
                    </a>
                    <?php 
                        endfor; 
                    endfor; 
                    
                    if (!$has_logos && !is_customize_preview()) {
                        echo '<p style="color: #6b7280; font-size: 0.9rem;">No partners added yet.</p>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </section>

    <!-- What's New Section -->
    <section style="background: #ffffff; padding: 6rem 0; text-align: center;" class="reveal">
        <div class="container relative">
            <h2 style="font-size: 2.5rem; text-align: center; margin-bottom: 3rem; font-weight: 300; color: #1f2937;">
                <?php echo esc_html(get_theme_mod('whats_new_title', 'What\'s New')); ?>
            </h2>
            
            <div class="news-carousel-wrapper">
                <button class="news-nav news-prev" aria-label="Previous">&lt;</button>
                
                <div class="news-carousel">
                    <?php
                    $news_args = array(
                        'post_type'           => 'post',
                        'posts_per_page'      => 6,
                        'ignore_sticky_posts' => true,
                    );
                    $news_query = new WP_Query($news_args);

                    if ($news_query->have_posts()) :
                        while ($news_query->have_posts()) : $news_query->the_post();
                            $cats = get_the_category();
                            $cat_name = !empty($cats) ? $cats[0]->name : 'News Release';
                    ?>
                    <div class="news-card">
                        <a href="<?php the_permalink(); ?>" class="news-img-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => 'news-img', 'loading' => 'lazy']); ?>
                            <?php else : ?>
                                <img src="https://via.placeholder.com/600x350?text=News" alt="Placeholder" class="news-img" loading="lazy">
                            <?php endif; ?>
                        </a>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-badge"><?php echo esc_html($cat_name); ?></span>
                                <span class="news-date"><?php echo get_the_date('F j, Y'); ?></span>
                            </div>
                            <h3 class="news-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <a href="<?php the_permalink(); ?>" class="news-readmore">Learn more &gt;</a>
                        </div>
                    </div>
                    <?php
                        endwhile;
                        wp_reset_postdata();
                    else :
                        // Dummy cards if no posts exist
                        $dummy_data = array(
                            array('title' => 'Synopsys Supports New Arm AGI CPU with Full-Stack Design Solutions', 'date' => 'March 24, 2026'),
                            array('title' => 'Synopsys Introduces Software-Defined Hardware-Assisted Verification to Enable AI Proliferation', 'date' => 'March 11, 2026'),
                            array('title' => 'Synopsys Launches Electronics Digital Twin Platform to Accelerate Physical AI System Development', 'date' => 'March 10, 2026'),
                        );
                        foreach ($dummy_data as $i => $data) :
                    ?>
                    <div class="news-card">
                        <a href="#" class="news-img-link">
                            <img src="https://via.placeholder.com/600x350?text=Published+Post+Demo+<?php echo $i+1; ?>" alt="Placeholder" class="news-img" loading="lazy">
                        </a>
                        <div class="news-content">
                            <div class="news-meta">
                                <span class="news-badge">NEWS RELEASE</span>
                                <span class="news-date"><?php echo esc_html($data['date']); ?></span>
                            </div>
                            <h3 class="news-title"><a href="#"><?php echo esc_html($data['title']); ?></a></h3>
                            <a href="#" class="news-readmore">Learn more &gt;</a>
                        </div>
                    </div>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </div>

                <button class="news-nav news-next" aria-label="Next">&gt;</button>
            </div>
        </div>
    </section>

    <!-- Support & Careers Section -->
    <?php
    $sc_bg = get_theme_mod('sc_bg_color', '#f7f7fa');
    $sc_title_c = get_theme_mod('sc_title_color', '#1f2937');
    $sc_desc_c = get_theme_mod('sc_desc_color', '#4b5563');
    ?>
    <section class="support-careers-section reveal" style="background: <?php echo esc_attr($sc_bg); ?>; padding: 4rem 0;">
        <div class="container">
            <div class="sc-grid">
                <div class="sc-col">
                    <h2 class="sc-title" style="color: <?php echo esc_attr($sc_title_c); ?>; font-weight: 300;"><?php echo esc_html(get_theme_mod('sc_col1_title', 'Support & Services')); ?></h2>
                    <p class="sc-desc" style="color: <?php echo esc_attr($sc_desc_c); ?>; font-weight: 300;"><?php echo esc_html(get_theme_mod('sc_col1_desc', 'Explore the Synopsys Support Community! Login is required. View our service offerings as well.')); ?></p>
                    <a href="<?php echo esc_url(get_theme_mod('sc_col1_link_url', '#')); ?>" class="sc-link" style="color: <?php echo esc_attr($sc_title_c); ?>; font-weight: 600;"><?php echo esc_html(get_theme_mod('sc_col1_link_text', 'View Support & Services')); ?> &nbsp; &gt;</a>
                </div>
                <!-- Vertical Divider -->
                <div class="sc-divider" style="background: #e5e7eb;"></div>
                <div class="sc-col">
                    <h2 class="sc-title" style="color: <?php echo esc_attr($sc_title_c); ?>; font-weight: 300;"><?php echo esc_html(get_theme_mod('sc_col2_title', 'Careers')); ?></h2>
                    <p class="sc-desc" style="color: <?php echo esc_attr($sc_desc_c); ?>; font-weight: 300;"><?php echo esc_html(get_theme_mod('sc_col2_desc', 'Work at Synopsys and join a first-in-class team of technology professionals. Apply for a position today.')); ?></p>
                    <a href="<?php echo esc_url(get_theme_mod('sc_col2_link_url', '#')); ?>" class="sc-link" style="color: <?php echo esc_attr($sc_title_c); ?>; font-weight: 600;"><?php echo esc_html(get_theme_mod('sc_col2_link_text', 'View Careers')); ?> &nbsp; &gt;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Connect with Us Section -->
    <?php
    $grad_start = get_theme_mod('connect_grad_start', '#2d1a47');
    $grad_end = get_theme_mod('connect_grad_end', '#7c3aed');
    $connect_bg = "background: linear-gradient(to right, $grad_start, $grad_end);";
    ?>
    <section style="<?php echo $connect_bg; ?> padding: 4rem 0; text-align: center; color: #fff;" class="reveal">
        <div class="container">
            <h2 style="font-size: 2.8rem; margin-bottom: 2.5rem; letter-spacing: -0.04em; color: #fff; font-weight: 700;">
                <?php echo esc_html(get_theme_mod('connect_title', 'Connect with Us')); ?>
            </h2>
            <a href="<?php echo esc_url(get_theme_mod('connect_btn_link', '#')); ?>" class="btn btn-primary" style="background: #fff; color: <?php echo esc_attr($grad_start); ?>; padding: 1rem 3rem; border: none; font-weight: 600; border-radius: 4px;">
                <?php echo esc_html(get_theme_mod('connect_btn_text', 'Contact Sales')); ?>
            </a>
        </div>
    </section>
</main>

<?php get_footer(); ?> 
