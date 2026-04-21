<?php 
/**
 * The template for displaying single career openings
 */
get_header(); ?>

<main class="single-career-page" style="background: #09090b; min-height: 100vh; padding: 100px 0; color: #fff;">
    <?php while ( have_posts() ) : the_post(); 
        $location = get_post_meta(get_the_ID(), '_job_location', true);
        $type = get_post_meta(get_the_ID(), '_job_type', true);
        $salary = get_post_meta(get_the_ID(), '_job_salary', true);
    ?>
    <div class="container">
        <!-- Header Info -->
        <div style="margin-bottom: 60px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 40px;">
            <a href="<?php echo home_url('/careers/'); ?>" style="color: #6366f1; text-decoration: none; font-weight: 700; margin-bottom: 20px; display: inline-block;">&larr; Back to Careers</a>
            <h1 style="font-size: 4rem; font-weight: 800; letter-spacing: -3px; margin-bottom: 20px; line-height: 1;"><?php the_title(); ?></h1>
            
            <div style="display: flex; gap: 30px; flex-wrap: wrap;">
                <div style="background: rgba(255,255,255,0.03); padding: 15px 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <span style="display: block; font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; margin-bottom: 5px;">Location</span>
                    <strong style="font-size: 1.1rem; color: #6366f1;">📍 <?php echo esc_html($location ?: 'Flexible'); ?></strong>
                </div>
                <div style="background: rgba(255,255,255,0.03); padding: 15px 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <span style="display: block; font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; margin-bottom: 5px;">Employment Type</span>
                    <strong style="font-size: 1.1rem; color: #6366f1;">💼 <?php echo esc_html($type ?: 'Full-time'); ?></strong>
                </div>
                <div style="background: rgba(255,255,255,0.03); padding: 15px 25px; border-radius: 15px; border: 1px solid rgba(255,255,255,0.05);">
                    <span style="display: block; font-size: 0.75rem; color: rgba(255,255,255,0.4); text-transform: uppercase; margin-bottom: 5px;">Compensation</span>
                    <strong style="font-size: 1.1rem; color: #6366f1;">💰 <?php echo esc_html($salary ?: 'Competitive'); ?></strong>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div style="display: grid; grid-template-columns: 1fr 350px; gap: 60px;">
            <div class="career-content" style="background: rgba(255,255,255,0.01); padding: 50px; border-radius: 30px; border: 1px solid rgba(255,255,255,0.05);">
                <h2 style="font-size: 2rem; margin-bottom: 30px; color: #fff;">Job Description & <span style="color: #6366f1;">Requirements</span></h2>
                <div style="line-height: 1.8; color: rgba(255,255,255,0.7); font-size: 1.1rem;">
                    <?php the_content(); ?>
                </div>
            </div>

            <!-- Sidebar CTA -->
            <div class="career-sidebar">
                <div style="position: sticky; top: 120px; background: linear-gradient(135deg, #6366f1, #a855f7); padding: 40px; border-radius: 30px; text-align: center; box-shadow: 0 30px 60px rgba(99, 102, 241, 0.2);">
                    <h3 style="color: #fff; margin-bottom: 15px; font-size: 1.5rem;">Interested in this role?</h3>
                    <p style="color: rgba(255,255,255,0.8); margin-bottom: 30px; font-size: 0.95rem;">Join our team and help us build the future of electronics.</p>
                    <a href="<?php echo home_url('/apply-now/?job=' . urlencode(get_the_title())); ?>" style="display: block; background: #fff; color: #6366f1; padding: 18px; border-radius: 15px; font-weight: 800; text-decoration: none; transition: 0.3s ease; font-size: 1.1rem;">Apply Now &rarr;</a>
                </div>
            </div>
        </div>
    </div>
    <?php endwhile; ?>
</main>

<style>
.career-content ul { list-style: disc; margin-left: 20px; margin-bottom: 20px; }
.career-content li { margin-bottom: 10px; }
.career-sidebar a:hover { transform: scale(1.05); box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
</style>

<?php get_footer(); ?>
