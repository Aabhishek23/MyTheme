<?php get_header(); ?> 

<main>
    <section id="hero" class="hero">
        <div class="container hero-content reveal">
            <h1>Experience Tomorrow's <span style="color: var(--primary);">Design</span> Today</h1>
            <p>Welcome to a WordPress experience that's fast, interactive, and beautifully crafted for the modern web.</p>
            <a href="#posts" class="btn">Explore Work</a>
        </div>
    </section>

    <div id="posts" class="container reveal">
        <h2 style="margin-bottom: 2rem; font-size: 2.5rem;">Latest Insights</h2>
        <div class="posts-grid">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <article class="glass post-card reveal">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="excerpt" style="color: var(--text-muted); margin-bottom: 1.5rem;">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" style="color: var(--accent); font-weight: 600;">Read More &rarr;</a>
                </article>
            <?php endwhile; else : ?>
                <p>No posts found.</p>
            <?php endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?> 
