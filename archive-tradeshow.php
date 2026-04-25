<?php get_header(); ?>

<main class="tradeshows-archive">
    <!-- Hero Section -->
    <section class="tradeshows-hero" style="background: linear-gradient(135deg, #09090b 0%, #1e1b4b 100%); padding: 100px 0; color: #fff; text-align: center; border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container">
            <h1 style="font-size: 4rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -2px;">Trade <span style="color: #6366f1;">Shows</span></h1>
            <p style="font-size: 1.2rem; color: rgba(255,255,255,0.7); max-width: 700px; margin: 0 auto;">Meet our team at leading industry events worldwide. Explore our latest innovations in person.</p>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="tradeshows-filters" style="background: #09090b; padding: 30px 0; border-bottom: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <div class="ts-tabs" style="display: flex; justify-content: center; gap: 20px;">
                <span class="ts-tab active" data-filter="all" style="color: #fff; border-bottom: 2px solid #6366f1; padding-bottom: 5px; cursor: pointer; font-weight: 600;">All Events</span>
                <span class="ts-tab" data-filter="upcoming" style="color: rgba(255,255,255,0.5); cursor: pointer; font-weight: 600;">Upcoming</span>
                <span class="ts-tab" data-filter="past" style="color: rgba(255,255,255,0.5); cursor: pointer; font-weight: 600;">Past Events</span>
            </div>
        </div>
    </section>

    <!-- Content Grid -->
    <section class="tradeshows-list" style="background: #09090b; padding: 80px 0; min-height: 500px;">
        <div class="container">
            <div class="tradeshows-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(350px, 1fr)); gap: 30px;">
                <?php 
                $today = date('Y-m-d');
                if (have_posts()) : while (have_posts()) : the_post(); 
                    $location = get_post_meta(get_the_ID(), '_tradeshow_location', true);
                    $start_date = get_post_meta(get_the_ID(), '_tradeshow_start_date', true);
                    $end_date = get_post_meta(get_the_ID(), '_tradeshow_end_date', true);
                    $booth = get_post_meta(get_the_ID(), '_tradeshow_booth', true);
                    $bg_image = get_the_post_thumbnail_url(get_the_ID(), 'large');

                    // Determine Type for Filtering
                    $type = 'past';
                    if (empty($end_date) || $end_date >= $today) {
                        $type = 'upcoming';
                    }
                ?>
                    <div class="tradeshow-card" data-type="<?php echo esc_attr($type); ?>" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; overflow: hidden; transition: all 0.3s ease; position: relative; backdrop-filter: blur(10px);">
                        <a href="<?php the_permalink(); ?>" style="text-decoration: none; color: inherit; display: block;">
                            <div class="ts-thumb" style="height: 220px; background-image: url('<?php echo esc_url($bg_image); ?>'); background-size: cover; background-position: center; position: relative;">
                                <?php if ($type === 'upcoming') : ?>
                                    <span style="position: absolute; top: 15px; left: 15px; background: #ef4444; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; text-transform: uppercase; z-index: 2;">Upcoming</span>
                                <?php endif; ?>
                                <div style="position: absolute; top: 20px; right: 20px; background: rgba(0,0,0,0.6); backdrop-filter: blur(5px); padding: 5px 12px; border-radius: 8px; font-size: 0.8rem; color: #fff; border: 1px solid rgba(255,255,255,0.1);">
                                    📍 <?php echo esc_html($location); ?>
                                </div>
                            </div>
                            <div class="ts-info" style="padding: 25px;">
                                <div style="color: #6366f1; font-weight: 700; font-size: 0.8rem; text-transform: uppercase; margin-bottom: 10px;">
                                    📅 <?php 
                                        if ($start_date) {
                                            echo date('M j', strtotime($start_date));
                                            if ($end_date && $start_date != $end_date) {
                                                echo ' - ' . date('M j, Y', strtotime($end_date));
                                            } else {
                                                echo ', ' . date('Y', strtotime($start_date));
                                            }
                                        }
                                    ?>
                                </div>
                                <h3 style="margin: 0 0 15px; font-size: 1.5rem; line-height: 1.2; color: #fff;"><?php the_title(); ?></h3>
                                <p style="color: rgba(255,255,255,0.5); font-size: 0.9rem; margin-bottom: 20px;">
                                    <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                                </p>
                                <div style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid rgba(255,255,255,0.05);">
                                    <?php if ($booth) : ?>
                                        <span style="font-size: 0.8rem; color: rgba(255,255,255,0.4);">Booth: <strong><?php echo esc_html($booth); ?></strong></span>
                                    <?php endif; ?>
                                    <span style="color: #6366f1; font-weight: 600; font-size: 0.9rem;">Show Details &rarr;</span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endwhile; else : ?>
                    <div style="grid-column: 1 / -1; text-align: center; color: rgba(255,255,255,0.2); padding: 100px 0; border: 2px dashed rgba(255,255,255,0.05); border-radius: 20px;">
                        <span style="font-size: 3rem; display: block; margin-bottom: 20px;">🎪</span>
                        <p style="font-size: 1.2rem;">No upcoming Trade Shows scheduled at the moment.</p>
                        <p><a href="<?php echo admin_url('post-new.php?post_type=tradeshow'); ?>" style="color:#6366f1;">+ Add Your First Trade Show</a></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.ts-tab');
    const cards = document.querySelectorAll('.tradeshow-card');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const filter = tab.getAttribute('data-filter');

            // Update tab styles
            tabs.forEach(t => {
                t.style.color = 'rgba(255,255,255,0.5)';
                t.style.borderBottom = 'none';
            });
            tab.style.color = '#fff';
            tab.style.borderBottom = '2px solid #6366f1';

            // Filter cards
            cards.forEach(card => {
                if (filter === 'all' || card.getAttribute('data-type') === filter) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});
</script>

<style>
.tradeshow-card:hover {
    transform: translateY(-8px);
    border-color: #6366f1 !important;
    background: rgba(255,255,255,0.05) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
}
</style>

<?php get_footer(); ?>
