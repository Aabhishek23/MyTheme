<?php get_header(); ?> 

<main>
    <div class="container reveal default-page-container">
        <?php while(have_posts()) : the_post(); ?>
            <article class="default-page-article">
                <h1 class="default-page-title"><?php the_title(); ?></h1>
                <div class="content reveal" style="font-size: 1.1rem; color: var(--text-muted);">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>
