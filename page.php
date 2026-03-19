<?php get_header(); ?> 

<main>
    <div class="container reveal" style="padding-top: 8rem; padding-bottom: 4rem;">
        <?php while(have_posts()) : the_post(); ?>
            <article class="glass" style="padding: 3rem;">
                <h1 style="margin-bottom: 2rem;"><?php the_title(); ?></h1>
                <div class="content reveal">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
