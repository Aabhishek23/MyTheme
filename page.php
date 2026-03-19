<?php get_header(); ?> 

<main>
    <div class="container reveal" style="padding-top: 10rem; padding-bottom: 6rem;">
        <?php while(have_posts()) : the_post(); ?>
            <article style="background: var(--surface); padding: 4rem; border-radius: 0.75rem; border: 1px solid var(--glass-border);">
                <h1 style="font-size: 3.5rem; margin-bottom: 2.5rem; letter-spacing: -0.04em;"><?php the_title(); ?></h1>
                <div class="content reveal" style="font-size: 1.1rem; color: var(--text-muted);">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
