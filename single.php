<?php get_header(); ?> 

<main>
    <div class="container reveal" style="padding-top: 8rem; padding-bottom: 4rem;">
        <?php while(have_posts()) : the_post(); ?>
            <article class="glass" style="padding: 3rem;">
                <h1 style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
                <div class="post-meta" style="color: var(--text-muted); margin-bottom: 2rem;">
                    Published on <?php echo get_the_date(); ?> by <?php the_author(); ?>
                </div>
                <div class="content reveal">
                    <?php the_content(); ?>
                </div>
                <div class="post-footer" style="margin-top: 3rem; padding-top: 2rem; border-top: 1px solid var(--glass-border);">
                    <a href="<?php echo esc_url(home_url('/#posts')); ?>" style="color: var(--primary); font-weight: 600;">&larr; Back to Blog</a>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
