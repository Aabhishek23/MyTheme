<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    $video_url = get_post_meta(get_the_ID(), '_webinar_video_url', true);
    $date = get_post_meta(get_the_ID(), '_webinar_date', true);
    $time = get_post_meta(get_the_ID(), '_webinar_time', true);
    $duration = get_post_meta(get_the_ID(), '_webinar_duration', true);
    $speaker = get_post_meta(get_the_ID(), '_webinar_speaker', true);
    $reg_link = get_post_meta(get_the_ID(), '_webinar_reg_link', true);
    $is_live = get_post_meta(get_the_ID(), '_webinar_is_live', true);

    // Convert YouTube URL to Embed URL
    $embed_url = '';
    if (!empty($video_url)) {
        if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $video_url, $match)) {
            $embed_url = 'https://www.youtube.com/embed/' . $match[1];
        }
    }
?>

<main class="webinar-single" style="background: #09090b; color: #fff; min-height: 100vh; padding-top: 100px;">
    <!-- Top Banner / Breadcrumb -->
    <section style="padding: 40px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <a href="<?php echo get_post_type_archive_link('webinar'); ?>" style="color: var(--primary); text-decoration: none; font-weight: 600;">&larr; Back to all Webinars</a>
        </div>
    </section>

    <!-- Main Content Area -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px;">
                
                <!-- Left: Video & Content -->
                <div class="webinar-main">
                    <h1 style="font-size: 3rem; margin-bottom: 20px; line-height: 1.1;"><?php the_title(); ?></h1>
                    
                    <div style="display: flex; gap: 15px; margin-bottom: 40px;">
                        <span style="background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 30px; font-size: 0.9rem; border: 1px solid rgba(255,255,255,0.2);">📅 <?php echo !empty($date) ? date('F j, Y', strtotime($date)) : 'On-Demand'; ?></span>
                        <span style="background: rgba(255,255,255,0.1); padding: 5px 15px; border-radius: 30px; font-size: 0.9rem; border: 1px solid rgba(255,255,255,0.2);">👤 <?php echo esc_html($speaker ? $speaker : 'Technical Expert'); ?></span>
                        <?php if ($is_live === 'yes') : ?>
                            <span style="background: #ef4444; color: #fff; padding: 5px 15px; border-radius: 30px; font-size: 0.9rem; font-weight: 700;">● LIVE</span>
                        <?php endif; ?>
                    </div>

                    <!-- Video Player Container -->
                    <div class="video-container" style="background: #000; border-radius: 20px; overflow: hidden; box-shadow: 0 30px 60px rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.1); margin-bottom: 40px;">
                        <?php if ($embed_url) : ?>
                            <style>
                                .video-responsive { padding-bottom: 56.25%; position: relative; height: 0; }
                                .video-responsive iframe { position: absolute; top: 0; left: 0; width: 100%; height: 100%; border:0; }
                            </style>
                            <div class="video-responsive">
                                <iframe src="<?php echo esc_url($embed_url); ?>" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        <?php else : ?>
                            <div style="padding: 100px 40px; text-align: center; color: rgba(255,255,255,0.4);">
                                <div style="font-size: 4rem; margin-bottom: 20px;">🎥</div>
                                <h2>Webinar Recording will be available soon</h2>
                                <p>If you have registered, you will receive an email once the video is online.</p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Post Content -->
                    <div class="webinar-description" style="font-size: 1.1rem; line-height: 1.8; color: rgba(255,255,255,0.8);">
                        <h2 style="color: #fff; margin-bottom: 20px;">About this Webinar</h2>
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Right: Sidebar / Register Card -->
                <div class="webinar-sidebar">
                    <div style="position: sticky; top: 100px; background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 30px; backdrop-filter: blur(10px);">
                        <h3 style="margin-bottom: 25px; font-size: 1.5rem;">Event Details</h3>
                        
                        <div style="display: grid; gap: 20px; margin-bottom: 30px;">
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="background: rgba(var(--primary-rgb), 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">⏱️</div>
                                <div>
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">Duration</div>
                                    <div style="font-weight: 600;"><?php echo esc_html($duration ? $duration : '60 Mins'); ?></div>
                                </div>
                            </div>
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="background: rgba(var(--primary-rgb), 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">🕖</div>
                                <div>
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">Time</div>
                                    <div style="font-weight: 600;"><?php echo esc_html($time ? $time : 'On-Demand'); ?></div>
                                </div>
                            </div>
                            <div style="display: flex; gap: 15px; align-items: center;">
                                <div style="background: rgba(var(--primary-rgb), 0.1); width: 40px; height: 40px; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 1.2rem;">💎</div>
                                <div>
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">Cost</div>
                                    <div style="font-weight: 600; color: #22c55e;">FREE / Complementary</div>
                                </div>
                            </div>
                        </div>

                        <?php if (!empty($reg_link)) : ?>
                            <a href="<?php echo esc_url($reg_link); ?>" class="btn btn-primary webinar-reg" style="display: block; text-align: center; width: 100%; background: var(--primary); color: #000; padding: 15px; border-radius: 12px; font-weight: 700; text-decoration: none; margin-bottom: 20px;">REGISTER FOR WEBINAR</a>
                        <?php else : ?>
                            <a href="<?php echo home_url('/contact-us'); ?>" class="btn btn-primary webinar-reg" style="display: block; text-align: center; width: 100%; background: var(--primary); color: #000; padding: 15px; border-radius: 12px; font-weight: 700; text-decoration: none; margin-bottom: 20px;">INQUIRE FOR DETAILS</a>
                        <?php endif; ?>

                        <?php 
                        $resource_url = get_post_meta(get_the_ID(), '_webinar_resource_url', true);
                        if (!empty($resource_url)) : ?>
                            <a href="<?php echo esc_url($resource_url); ?>" target="_blank" style="display: block; text-align: center; width: 100%; background: rgba(255,255,255,0.05); color: #fff; padding: 12px; border-radius: 12px; font-weight: 600; text-decoration: none; border: 1px solid rgba(255,255,255,0.1); margin-bottom: 20px;">📑 DOWNLOAD RESOURCES</a>
                        <?php endif; ?>

                        <p style="font-size: 0.8rem; text-align: center; color: rgba(255,255,255,0.4);">By registering, you agree to our Terms and Conditions.</p>
                        
                        <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1);">
                            <div style="display: flex; justify-content: space-around;">
                                <!-- Simple social share icons -->
                                <a href="#" style="color: #fff; opacity: 0.5;">LinkedIn</a>
                                <a href="#" style="color: #fff; opacity: 0.5;">Twitter</a>
                                <a href="#" style="color: #fff; opacity: 0.5;">Email</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Relevant Webinars Section -->
    <section style="background: rgba(255,255,255,0.02); padding: 80px 0; border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 50px;">Other Related Webinars</h2>
            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 30px;">
                <?php
                $related = new WP_Query(array(
                    'post_type' => 'webinar',
                    'posts_per_page' => 3,
                    'post__not_in' => array(get_the_ID())
                ));
                if ($related->have_posts()) : while ($related->have_posts()) : $related->the_post(); ?>
                    <!-- Small card -->
                    <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; background: rgba(255,255,255,0.03); border-radius: 12px; padding: 20px; border: 1px solid rgba(255,255,255,0.1); display: block;">
                        <h4 style="margin:0 0 10px; color: #fff;"><?php the_title(); ?></h4>
                        <span style="color: var(--primary); font-weight: 600; font-size: 0.8rem;">View Episode &rarr;</span>
                    </a>
                <?php endwhile; wp_reset_postdata(); endif; ?>
            </div>
        </div>
    </section>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
