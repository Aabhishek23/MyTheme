<?php 
/**
 * Template Name: Webinars Page
 */
get_header(); ?>

<main class="webinars-archive">
    <!-- Hero/Header Section -->
    <section class="webinars-hero" style="background: linear-gradient(135deg, #09090b 0%, #18181b 100%); padding: 100px 0; color: #fff; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container">
            <h1 style="font-size: 4rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px;">Webinar<span style="color: var(--primary);">s</span></h1>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 700px; margin: 0 auto;">Stay ahead with our latest technical deep dives, industry trends, and product demonstrations delivered by experts.</p>
        </div>
    </section>

    <!-- Filters/Search -->
    <section class="webinars-filters" style="background: #09090b; padding: 30px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <div style="display: flex; justify-content: center; gap: 20px;">
                <span style="color: #fff; border-bottom: 2px solid var(--primary); padding-bottom: 5px; cursor: pointer;">All Webinars</span>
                <span style="color: rgba(255,255,255,0.5); cursor: pointer;">Upcoming</span>
                <span style="color: rgba(255,255,255,0.5); cursor: pointer;">On-Demand</span>
            </div>
        </div>
    </section>

    <!-- Webinars Grid -->
    <section class="webinars-list" style="background: #09090b; padding: 80px 0; min-height: 500px;">
        <div class="container">
            <div class="webinars-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
                <?php 
                // Using a custom query to ensure it works on a static page too
                $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                $args = array(
                    'post_type' => 'webinar',
                    'posts_per_page' => 12,
                    'paged' => $paged
                );
                $webinar_query = new WP_Query($args);

                if ($webinar_query->have_posts()) : while ($webinar_query->have_posts()) : $webinar_query->the_post(); 
                    $date = get_post_meta(get_the_ID(), '_webinar_date', true);
                    $time = get_post_meta(get_the_ID(), '_webinar_time', true);
                    $speaker = get_post_meta(get_the_ID(), '_webinar_speaker', true);
                    $is_live = get_post_meta(get_the_ID(), '_webinar_is_live', true);
                    $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'large');
                ?>
                    <div class="webinar-card" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 16px; overflow: hidden; transition: transform 0.3s ease, border-color 0.3s ease; position: relative;">
                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; display: block;">
                            <div class="webinar-thumb" style="height: 200px; background-image: url('<?php echo esc_url($bg_image); ?>'); background-size: cover; background-position: center; position: relative;">
                                <?php if ($is_live === 'yes') : ?>
                                    <span style="position: absolute; top: 15px; left: 15px; background: #ef4444; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; animation: pulse 2s infinite;">● Live Now</span>
                                <?php endif; ?>
                                <div style="position: absolute; bottom: 0; left: 0; right: 0; padding: 20px; background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <span style="background: var(--primary); color: #000; padding: 2px 8px; border-radius: 4px; font-size: 10px; font-weight: 600;"><?php echo !empty($date) ? date('M j, Y', strtotime($date)) : 'ON-DEMAND'; ?></span>
                                </div>
                            </div>
                            <div class="webinar-info" style="padding: 25px;">
                                <h3 style="margin: 0 0 15px; font-size: 1.4rem; line-height: 1.3; color: #fff;"><?php the_title(); ?></h3>
                                <div style="display: flex; flex-direction: column; gap: 8px; color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 20px;">
                                    <?php if ($speaker) : ?>
                                        <span>👤 <strong>Speaker:</strong> <?php echo esc_html($speaker); ?></span>
                                    <?php endif; ?>
                                    <?php if ($time) : ?>
                                        <span>⏰ <strong>Time:</strong> <?php echo esc_html($time); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div style="display: flex; justify-content: space-between; align-items: center;">
                                    <span style="color: var(--primary); font-weight: 600;">View Details &rarr;</span>
                                    <span style="font-size: 0.8rem; background: rgba(255,255,255,0.05); padding: 5px 10px; border-radius: 8px;">Technical</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; wp_reset_postdata(); else : ?>
                    <div style="grid-column: 1 / -1; text-align: center; color: rgba(255,255,255,0.3); padding: 100px 0;">
                        <p style="font-size: 1.5rem;">No webinars found. Status: Empty Repository.</p>
                        <p style="font-size: 1rem; margin-top: 10px; color: var(--primary);"><a href="<?php echo admin_url('post-new.php?post_type=webinar'); ?>" style="color: inherit;">+ Add Your First Webinar</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="webinars-cta" style="background: linear-gradient(to right, #4c1d95, #7c3aed); padding: 60px 0; text-align: center; color: #fff;">
        <div class="container">
            <h2 style="font-size: 2rem; margin-bottom: 20px;">Want to host a private technical session?</h2>
            <p style="margin-bottom: 30px; opacity: 0.9;">Our engineers can provide customized training for your team.</p>
            <a href="<?php echo home_url('/contact-us'); ?>" class="btn btn-primary" style="background: #fff; color: #7c3aed; padding: 12px 30px; text-decoration: none; font-weight: 700; border-radius: 8px; display: inline-block;">Contact Our Team &nbsp; &rarr;</a>
        </div>
    </section>
</main>

<style>
.webinar-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.4);
}
@keyframes pulse {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
</style>

<?php get_footer(); ?>
