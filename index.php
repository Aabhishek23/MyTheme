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

    <!-- Connect with Us Section -->
    <section style="background: var(--primary); padding: 6rem 0; text-align: center;" class="reveal">
        <div class="container">
            <h2 style="font-size: 3.5rem; margin-bottom: 2.5rem; letter-spacing: -0.04em;">Connect with Us</h2>
            <a href="#" class="btn btn-primary" style="background: #fff; color: var(--primary); padding: 1rem 3rem;">Contact Sales</a>
        </div>
    </section>
</main>

<?php get_footer(); ?> 
