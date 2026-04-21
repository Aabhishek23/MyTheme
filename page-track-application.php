<?php 
/**
 * Template Name: Track Application Status
 */
get_header(); ?>

<main class="page-track-app" style="background: #09090b; min-height: 100vh; padding: 120px 0; color: #fff;">
    <div class="container">
        <div style="max-width: 600px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 3rem; margin-bottom: 10px; letter-spacing: -2px;">Track <span style="color: #6366f1;">Application</span></h1>
            <p style="color: rgba(255,255,255,0.5); margin-bottom: 50px;">Enter your email to check the status of your job application.</p>

            <form method="post" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1); padding: 40px; border-radius: 24px; backdrop-filter: blur(20px);">
                <div style="margin-bottom: 25px; text-align: left;">
                    <label style="display: block; margin-bottom: 10px; color: rgba(255,255,255,0.7);">Your Registered Email Address</label>
                    <input type="email" name="track_email" required placeholder="example@email.com" style="width: 100%; padding: 15px; border-radius: 12px; background: #000; border: 1px solid rgba(255,255,255,0.1); color: #fff;">
                </div>
                <button type="submit" name="submit_track" style="width: 100%; background: #6366f1; color: #fff; padding: 18px; border-radius: 12px; font-weight: 800; border: none; cursor: pointer;">Track Status &rarr;</button>
            </form>

            <?php 
            if (isset($_POST['submit_track'])) {
                $email = sanitize_email($_POST['track_email']);
                
                $args = array(
                    'post_type'  => 'job_application',
                    'meta_query' => array(
                        array(
                            'key'     => '_app_email',
                            'value'   => $email,
                            'compare' => '='
                        )
                    )
                );
                $query = new WP_Query($args);

                echo '<div style="margin-top: 40px; text-align: left;">';
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $status = get_post_meta(get_the_ID(), '_app_status', true) ?: 'Under Review';
                        $job = get_post_meta(get_the_ID(), '_app_job', true);
                        
                        $status_color = '#6366f1';
                        if ($status == 'Rejected') $status_color = '#ef4444';
                        if ($status == 'Shortlisted') $status_color = '#22c55e';
                        
                        echo '<div style="background: rgba(255,255,255,0.05); padding: 25px; border-radius: 15px; border-left: 5px solid '.$status_color.'; margin-bottom: 15px;">';
                        echo '<h3 style="margin: 0; font-size: 1.1rem; color: #fff;">' . esc_html($job) . '</h3>';
                        echo '<p style="margin: 10px 0 0; font-size: 0.9rem; color: rgba(255,255,255,0.5);">Application Status: <strong style="color: '.$status_color.'; text-transform: uppercase;">' . esc_html($status) . '</strong></p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p style="color: #ef4444; background: rgba(239, 68, 68, 0.1); padding: 15px; border-radius: 10px; text-align: center;">No application found for this email address.</p>';
                }
                echo '</div>';
                wp_reset_postdata();
            }
            ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
