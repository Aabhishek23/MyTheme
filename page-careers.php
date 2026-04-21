<?php 
/**
 * Template Name: Careers Page
 */
get_header(); ?>

<main class="page-careers">
    <!-- Hero Section -->
    <section class="careers-hero" style="background: linear-gradient(135deg, #09090b 0%, #1e1b4b 100%); padding: 120px 0; color: #fff; text-align: center; position: relative; overflow: hidden;">
        <div class="container" style="position: relative; z-index: 2;">
            <span class="badge" style="background: rgba(99, 102, 241, 0.1); color: #6366f1; padding: 8px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; margin-bottom: 20px; display: inline-block; border: 1px solid rgba(99, 102, 241, 0.2);">WE'RE HIRING</span>
            <h1 style="font-size: 4.5rem; font-weight: 800; margin-bottom: 20px; letter-spacing: -3px; line-height: 1.1;">Build the Future of <span style="color: #6366f1;">Electronics</span></h1>
            <p style="font-size: 1.25rem; color: rgba(255,255,255,0.7); max-width: 700px; margin: 0 auto;">Join a team of passionate engineers and innovators dedicated to pushing the boundaries of PCB design and manufacturing.</p>
        </div>
        <div class="hero-glow" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); width: 600px; height: 600px; background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%); pointer-events: none;"></div>
    </section>

    <!-- Why Join Us -->
    <section class="careers-values" style="padding: 100px 0; background: #09090b;">
        <div class="container">
            <div style="text-align: center; margin-bottom: 60px;">
                <h2 style="font-size: 2.5rem; margin-bottom: 15px; color: #fff;">Why Work with <span style="color: #6366f1;">AIPL?</span></h2>
                <p style="color: rgba(255,255,255,0.5);">We foster a culture of innovation, precision, and continuous learning.</p>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 30px;">
                <div class="value-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 40px; border-radius: 24px; transition: all 0.3s ease;">
                    <div style="font-size: 2.5rem; margin-bottom: 20px;">🔬</div>
                    <h3 style="color: #fff; margin-bottom: 15px;">Cutting-edge Tech</h3>
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.95rem; line-height: 1.6;">Work with state-of-the-art manufacturing equipment and the latest design software.</p>
                </div>
                <div class="value-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 40px; border-radius: 24px; transition: all 0.3s ease;">
                    <div style="font-size: 2.5rem; margin-bottom: 20px;">🎓</div>
                    <h3 style="color: #fff; margin-bottom: 15px;">Growth & Learning</h3>
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.95rem; line-height: 1.6;">Continuous professional development through workshops, certifications, and mentorship.</p>
                </div>
                <div class="value-card" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 40px; border-radius: 24px; transition: all 0.3s ease;">
                    <div style="font-size: 2.5rem; margin-bottom: 20px;">🌍</div>
                    <h3 style="color: #fff; margin-bottom: 15px;">Global Impact</h3>
                    <p style="color: rgba(255,255,255,0.5); font-size: 0.95rem; line-height: 1.6;">Your work will power critical technologies used by industries around the globe.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Open Positions -->
    <section id="positions" style="padding: 100px 0; background: rgba(255,255,255,0.02); border-top: 1px solid rgba(255,255,255,0.05);">
        <div class="container">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 50px;">
                <div>
                    <h2 style="font-size: 2.5rem; color: #fff; margin-bottom: 10px;">Open <span style="color: #6366f1;">Positions</span></h2>
                    <p style="color: rgba(255,255,255,0.5);">Find the role that fits your passion and expertise.</p>
                </div>
                <span style="color: rgba(255,255,255,0.3); font-weight: 600;">3 Openings Found</span>
            </div>

            <div class="positions-list">
                <?php 
                $args = array(
                    'post_type' => 'career',
                    'posts_per_page' => -1,
                );
                $career_query = new WP_Query($args);

                if ($career_query->have_posts()) : 
                    while ($career_query->have_posts()) : $career_query->the_post(); 
                        $location = get_post_meta(get_the_ID(), '_job_location', true);
                        $type = get_post_meta(get_the_ID(), '_job_type', true);
                        $salary = get_post_meta(get_the_ID(), '_job_salary', true);
                ?>
                    <div class="job-item" style="background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.1); border-radius: 20px; padding: 30px; margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; transition: all 0.3s ease;">
                        <div>
                            <h3 style="color: #fff; font-size: 1.5rem; margin-bottom: 5px;"><?php the_title(); ?></h3>
                            <div style="display: flex; gap: 20px; color: rgba(255,255,255,0.4); font-size: 0.85rem;">
                                <span>📍 <?php echo esc_html($location ?: 'Flexible'); ?></span>
                                <span>💼 <?php echo esc_html($type ?: 'Full-time'); ?></span>
                                <span>💰 <?php echo esc_html($salary ?: 'Competitive'); ?></span>
                            </div>
                        </div>
                        <div style="display: flex; gap: 15px;">
                            <a href="<?php the_permalink(); ?>" style="border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; transition: 0.3s ease;">View Details</a>
                            <a href="<?php echo home_url('/apply-now/?job=' . urlencode(get_the_title())); ?>" style="background: #6366f1; color: #fff; padding: 12px 24px; border-radius: 12px; font-weight: 700; text-decoration: none; transition: 0.3s ease;">Quick Apply &rarr;</a>
                        </div>
                    </div>
                <?php endwhile; wp_reset_postdata(); else : ?>
                    <div style="text-align: center; color: rgba(255,255,255,0.2); padding: 60px; border: 2px dashed rgba(255,255,255,0.05); border-radius: 20px;">
                        <p style="font-size: 1.2rem;">Currently, there are no open positions. Please check back later!</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section style="padding: 100px 0; text-align: center; background: #09090b;">
        <div class="container">
            <div style="background: linear-gradient(90deg, #6366f1, #a855f7); padding: 80px; border-radius: 40px; box-shadow: 0 40px 80px rgba(99, 102, 241, 0.2);">
                <h2 style="font-size: 3rem; color: #fff; margin-bottom: 20px; letter-spacing: -1px;">Don't see a fit?</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 1.2rem; max-width: 600px; margin: 0 auto 40px;">Send us your CV anyway! We are always looking for exceptional talent to join our innovative journey.</p>
                <a href="<?php echo home_url('/apply-now/?job=Speculative%20Application'); ?>" style="background: #fff; color: #6366f1; padding: 18px 45px; border-radius: 20px; font-weight: 800; font-size: 1.1rem; text-decoration: none; box-shadow: 0 10px 20px rgba(0,0,0,0.2); display: inline-block;">Send Speculative CV</a>
            </div>
        </div>
    </section>
</main>

<style>
.value-card:hover {
    transform: translateY(-10px);
    border-color: #6366f1 !important;
    background: rgba(255,255,255,0.05) !important;
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
}
.job-item:hover {
    transform: translateX(15px);
    border-color: #6366f1 !important;
    background: rgba(255,255,255,0.08) !important;
}
</style>

<?php get_footer(); ?>
