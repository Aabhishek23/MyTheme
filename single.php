<?php get_header(); ?> 

<main>
    <div class="container reveal" style="padding-top: 10rem; padding-bottom: 6rem;">
        <?php while(have_posts()) : the_post(); ?>
            <article style="background: var(--surface); padding: 4rem; border-radius: 0.75rem; border: 1px solid var(--glass-border);">
                <h1 style="font-size: 3.5rem; margin-bottom: 1.5rem; letter-spacing: -0.04em;"><?php the_title(); ?></h1>
                <div class="post-meta" style="color: var(--secondary); font-weight: 600; margin-bottom: 3rem; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 0.1em;">
                    Published on <?php echo get_the_date(); ?> &nbsp;•&nbsp; By <?php the_author(); ?>
                </div>
                <div class="content reveal" style="font-size: 1.1rem; color: var(--text-muted);">
                    <?php the_content(); ?>
                </div>
                <div class="post-footer" style="margin-top: 4rem; padding-top: 2rem; border-top: 1px solid var(--glass-border);">
                    <a href="<?php echo esc_url(home_url('/#posts')); ?>" style="color: var(--accent); font-weight: 600; display: inline-flex; align-items: center; gap: 0.5rem;">
                        &larr; Back to Insights
                    </a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
