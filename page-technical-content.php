<?php
/**
 * Template Name: Technical Content
 */
get_header(); ?>

<main class="premium-page tech-content-page">
    <section class="page-hero">
        <div class="container">
            <div class="hero-content reveal">
                <span class="badge">KNOWLEDGE CENTER</span>
                <h1><?php the_title(); ?></h1>
                <?php if(has_excerpt()): ?>
                    <p class="lead"><?php echo get_the_excerpt(); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="content-body reveal">
        <div class="container">
            <div class="tech-grid">
                <!-- Main Content -->
                <div class="main-content-area">
                    <article class="glass-article">
                        <div class="article-inner">
                            <?php 
                            if(have_posts()):
                                while(have_posts()): the_post();
                                    the_content();
                                endwhile;
                            else:
                                ?>
                                <div class="placeholder-content">
                                    <h3>Overview</h3>
                                    <p>Welcome to our technical documentation. This section covers in-depth information about <strong><?php the_title(); ?></strong> as part of our commitment to engineering excellence.</p>
                                    
                                    <div class="info-box-blue">
                                        <h4>Key Highlights</h4>
                                        <ul>
                                            <li>Industry-standard compliance and certification details.</li>
                                            <li>Best practices for design and manufacturability (DFM).</li>
                                            <li>Technical specifications for advanced PCB applications.</li>
                                        </ul>
                                    </div>

                                    <p>We are currently updating our digital library with the latest whitepapers and technical data sheets. If you need specific documentation immediately, please reach out to our engineering support team.</p>
                                    
                                    <div class="contact-cta">
                                        <a href="<?php echo home_url('/contact-us/'); ?>" class="btn-outline">Ask an Engineer</a>
                                    </div>
                                </div>
                                <?php
                            endif;
                            ?>
                        </div>
                    </article>
                </div>

                <!-- Sidebar -->
                <aside class="tech-sidebar">
                    <div class="sidebar-widget">
                        <h3>Related Resources</h3>
                        <ul class="widget-links">
                            <li><a href="<?php echo home_url('/design-guidelines/'); ?>">Design Guidelines</a></li>
                            <li><a href="<?php echo home_url('/component-library/'); ?>">Component Library</a></li>
                            <li><a href="<?php echo home_url('/how-to-export-gerber-files/'); ?>">Gerber Export Guide</a></li>
                            <li><a href="<?php echo home_url('/quality-certifications/'); ?>">Quality & Certifications</a></li>
                        </ul>
                    </div>

                    <div class="sidebar-widget promo">
                        <div class="promo-card">
                            <h4>Ready to start?</h4>
                            <p>Get a precise manufacturing quote in minutes.</p>
                            <a href="<?php echo home_url('/request-a-quote/'); ?>" class="btn-primary-mini">Get a Quote</a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<style>
.premium-page { background: #000; color: #fff; padding-bottom: 8rem; }
.page-hero { padding: 12rem 0 4rem; text-align: center; }
.badge { background: rgba(0, 123, 255, 0.1); color: #007bff; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 2rem; border: 1px solid rgba(0, 123, 255, 0.2); }
.page-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.04em; }
.page-hero .lead { font-size: 1.1rem; color: var(--text-muted); max-width: 600px; margin: 0 auto; line-height: 1.6; }

.content-body { padding: 4rem 0; }
.tech-grid { display: grid; grid-template-columns: 1fr 300px; gap: 4rem; }

.glass-article { background: var(--surface); border-radius: 2rem; border: 1px solid var(--glass-border); position: relative; overflow: hidden; }
.article-inner { padding: 4rem; font-size: 1.1rem; line-height: 1.8; color: #ddd; }

.article-inner h2, .article-inner h3 { color: #fff; margin: 2.5rem 0 1.5rem; }
.article-inner p { margin-bottom: 1.5rem; }

.info-box-blue { background: rgba(0, 123, 255, 0.05); border: 1px solid rgba(0, 123, 255, 0.2); border-radius: 1rem; padding: 2rem; margin: 2.5rem 0; }
.info-box-blue h4 { color: #007bff; margin-top: 0; margin-bottom: 1rem; font-size: 1.2rem; }
.info-box-blue ul { padding-left: 1.5rem; margin: 0; }
.info-box-blue li { margin-bottom: 0.75rem; }

.contact-cta { margin-top: 3rem; }
.btn-outline { display: inline-block; padding: 1rem 2.5rem; border: 1px solid #007bff; color: #007bff; border-radius: 0.75rem; text-decoration: none; font-weight: 700; transition: 0.3s; }
.btn-outline:hover { background: #007bff; color: #fff; }

.sidebar-widget { background: var(--surface); border-radius: 1.5rem; border: 1px solid var(--glass-border); padding: 2rem; margin-bottom: 2rem; }
.sidebar-widget h3 { font-size: 1.1rem; margin-bottom: 1.5rem; color: #fff; }
.widget-links { list-style: none; padding: 0; margin: 0; }
.widget-links li { margin-bottom: 1rem; }
.widget-links a { color: var(--text-muted); text-decoration: none; font-size: 0.95rem; transition: 0.3s; display: block; }
.widget-links a:hover { color: #007bff; transform: translateX(5px); }

.promo-card { text-align: center; }
.promo-card h4 { font-size: 1.2rem; margin-top: 0; margin-bottom: 0.75rem; color: #fff; }
.promo-card p { font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1.5rem; }
.btn-primary-mini { background: #007bff; color: #fff; text-decoration: none; padding: 0.75rem 1.5rem; border-radius: 0.5rem; font-weight: 700; display: inline-block; font-size: 0.9rem; transition: 0.3s; }
.btn-primary-mini:hover { background: #0056b3; transform: scale(1.05); }

@media (max-width: 992px) {
    .tech-grid { grid-template-columns: 1fr; }
    .page-hero h1 { font-size: 2.5rem; }
    .article-inner { padding: 2.5rem; }
}
</style>

<?php get_footer(); ?>
