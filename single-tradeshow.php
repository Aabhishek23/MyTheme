<?php get_header(); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); 
    $location = get_post_meta(get_the_ID(), '_tradeshow_location', true);
    $start_date = get_post_meta(get_the_ID(), '_tradeshow_start_date', true);
    $end_date = get_post_meta(get_the_ID(), '_tradeshow_end_date', true);
    $booth = get_post_meta(get_the_ID(), '_tradeshow_booth', true);
    $map_url = get_post_meta(get_the_ID(), '_tradeshow_map_url', true);
    $thumb = get_the_post_thumbnail_url(get_the_ID(), 'full');
?>

<main class="tradeshow-single" style="background: #09090b; color: #fff; min-height: 100vh;">
    <!-- Featured Image Hero -->
    <section class="ts-hero" style="height: 400px; background-image: linear-gradient(to bottom, rgba(0,0,0,0.3), #09090b), url('<?php echo esc_url($thumb); ?>'); background-size: cover; background-position: center; display: flex; align-items: flex-end; padding-bottom: 60px;">
        <div class="container">
            <a href="<?php echo home_url('/tradeshows'); ?>" style="color: #6366f1; text-decoration: none; font-weight: 600; display: block; margin-bottom: 20px;">&larr; Back to all Events</a>
            <h1 style="font-size: 3.5rem; line-height: 1; margin-bottom: 10px;"><?php the_title(); ?></h1>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); display: flex; align-items: center; gap: 10px;">
                📍 <?php echo esc_html($location); ?>
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <section style="padding: 80px 0;">
        <div class="container">
            <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 60px;">
                
                <!-- Content -->
                <div class="ts-main">
                    <div style="font-size: 1.1rem; line-height: 1.8; color: rgba(255,255,255,0.8);">
                        <h2 style="color: #fff; margin-bottom: 25px; border-left: 4px solid #6366f1; padding-left: 20px;">Event Overview</h2>
                        <?php the_content(); ?>
                    </div>
                </div>

                <!-- Info Sidebar -->
                <div class="ts-sidebar">
                    <div style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 24px; padding: 40px; position: sticky; top: 100px;">
                        <h3 style="margin-bottom: 30px; font-size: 1.6rem; color: #fff;">Visit Us</h3>
                        
                        <div style="display: grid; gap: 25px; margin-bottom: 40px;">
                            <div style="display: flex; gap: 20px; align-items: flex-start;">
                                <div style="font-size: 1.5rem;">📅</div>
                                <div>
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px;">When</div>
                                    <div style="font-weight: 700; font-size: 1.1rem;">
                                        <?php 
                                            if ($start_date) {
                                                echo date('F j', strtotime($start_date));
                                                if ($end_date && $start_date != $end_date) {
                                                    echo ' - ' . date('F j, Y', strtotime($end_date));
                                                } else {
                                                    echo ', ' . date('Y', strtotime($start_date));
                                                }
                                            }
                                        ?>
                                    </div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 20px; align-items: flex-start;">
                                <div style="font-size: 1.5rem;">🎪</div>
                                <div>
                                    <div style="font-size: 0.8rem; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px;">Our Booth</div>
                                    <div style="font-weight: 700; font-size: 1.1rem; color: #6366f1;">
                                        <?php echo esc_html($booth ? $booth : 'TBA'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php if ($map_url) : ?>
                            <a href="<?php echo esc_url($map_url); ?>" target="_blank" style="display: block; text-align: center; background: #6366f1; color: #fff; padding: 18px; border-radius: 14px; font-weight: 700; text-decoration: none; transition: transform 0.3s ease; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.2);">GET DIRECTIONS &rarr;</a>
                        <?php endif; ?>

                        <div style="margin-top: 40px; padding: 20px; background: rgba(255,255,255,0.02); border-radius: 12px; border: 1px dashed rgba(255,255,255,0.1);">
                            <p style="font-size: 0.85rem; margin: 0; color: rgba(255,255,255,0.5); line-height: 1.5;">Want to schedule a 1-on-1 meeting at the booth? <a href="<?php echo home_url('/contact-us'); ?>" style="color: #6366f1; font-weight: 600;">Request Appointment</a></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
</main>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
