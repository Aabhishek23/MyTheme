<?php
/**
 * Template Name: About Us
 */
get_header(); ?>

<main class="premium-page about-page">
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <div class="hero-content reveal">
                <span class="badge">WHO WE ARE</span>
                <h1>Engineering the <span class="gradient-text">Future of PCBs</span></h1>
                <p class="lead">We are a premier PCB design and manufacturing firm dedicated to delivering high-precision solutions for the most demanding industries.</p>
            </div>
        </div>
        <div class="hero-bg-glow"></div>
    </section>

    <!-- Company Stats -->
    <section class="stats-section reveal">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <span class="stat-number">10+</span>
                    <span class="stat-label">Years Experience</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">5k+</span>
                    <span class="stat-label">Projects Completed</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">99%</span>
                    <span class="stat-label">Customer Satisfaction</span>
                </div>
                <div class="stat-card">
                    <span class="stat-number">24h</span>
                    <span class="stat-label">Quick Turnaround</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Our Values -->
    <section class="values-section reveal">
        <div class="container">
            <div class="section-header">
                <h2>Our Core <span class="gradient-text">Values</span></h2>
                <p>What drives us to deliver excellence every single day.</p>
            </div>
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon">🎯</div>
                    <h3>Precision</h3>
                    <p>Every micron counts. We utilize state-of-the-art technology to ensure absolute accuracy in every board we manufacture.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">⚡</div>
                    <h3>Innovation</h3>
                    <p>We're not just order-takers; we're innovators. We help you optimize your designs for better manufacturability and performance.</p>
                </div>
                <div class="value-card">
                    <div class="value-icon">🛡️</div>
                    <h3>Reliability</h3>
                    <p>Our boards power critical systems worldwide. We never compromise on quality, ensuring your prototypes and production runs are rock-solid.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="about-content-section reveal">
        <div class="container">
            <div class="content-wrapper">
                <div class="text-content">
                    <h2>Our Journey</h2>
                    <p>Founded by a team of passionate engineers, we realized early on that the electronics industry needed more than just a PCB supplier—it needed a partner.</p>
                    <p>Over the last decade, we've evolved from a small design studio into a full-scale manufacturing powerhouse, serving clients from stealth startups to Fortune 500 tech giants.</p>
                    <p>Today, we specialize in high-density interconnect (HDI) boards, high-frequency RF designs, and complex multi-layer systems that push the boundaries of what's possible.</p>
                </div>
                <div class="image-content">
                    <div class="glass-image-frame">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/about-team.jpg" alt="Our Team" onerror="this.src='https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&q=80&w=800'">
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.premium-page {
    background: #000;
    color: #fff;
    overflow: hidden;
}

.page-hero {
    padding: 12rem 0 8rem;
    position: relative;
    text-align: center;
}

.hero-bg-glow {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(0, 123, 255, 0.15) 0%, rgba(0, 0, 0, 0) 70%);
    pointer-events: none;
    z-index: 0;
}

.badge {
    background: rgba(0, 123, 255, 0.1);
    color: #007bff;
    padding: 0.5rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    letter-spacing: 0.1em;
    border: 1px solid rgba(0, 123, 255, 0.2);
    margin-bottom: 2rem;
    display: inline-block;
}

.page-hero h1 {
    font-size: 4rem;
    font-weight: 800;
    margin-bottom: 1.5rem;
    letter-spacing: -0.04em;
    line-height: 1.1;
}

.page-hero .lead {
    font-size: 1.25rem;
    color: var(--text-muted);
    max-width: 700px;
    margin: 0 auto;
}

.gradient-text {
    background: linear-gradient(135deg, #007bff, #00d2ff);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Stats */
.stats-section {
    padding: 4rem 0;
    background: rgba(255, 255, 255, 0.02);
    border-top: 1px solid var(--glass-border);
    border-bottom: 1px solid var(--glass-border);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 2rem;
}

.stat-card {
    text-align: center;
}

.stat-number {
    display: block;
    font-size: 3rem;
    font-weight: 800;
    background: linear-gradient(135deg, #fff, #888);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: 0.5rem;
}

.stat-label {
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

/* Values */
.values-section {
    padding: 8rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 4rem;
}

.section-header h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.section-header p {
    color: var(--text-muted);
}

.values-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 3rem;
}

.value-card {
    background: var(--surface);
    padding: 3rem;
    border-radius: 1.5rem;
    border: 1px solid var(--glass-border);
    transition: 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.value-card:hover {
    transform: translateY(-10px);
    border-color: rgba(0, 123, 255, 0.4);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
}

.value-icon {
    font-size: 2.5rem;
    margin-bottom: 1.5rem;
}

.value-card h3 {
    font-size: 1.5rem;
    margin-bottom: 1rem;
}

.value-card p {
    color: var(--text-muted);
    line-height: 1.6;
}

/* Journey Content */
.about-content-section {
    padding: 8rem 0;
}

.content-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

.text-content h2 {
    font-size: 2.5rem;
    margin-bottom: 2rem;
}

.text-content p {
    font-size: 1.1rem;
    color: var(--text-muted);
    line-height: 1.8;
    margin-bottom: 1.5rem;
}

.glass-image-frame {
    padding: 1rem;
    background: var(--glass-bg);
    border: 1px solid var(--glass-border);
    border-radius: 2rem;
    backdrop-filter: blur(10px);
}

.glass-image-frame img {
    width: 100%;
    border-radius: 1.5rem;
    display: block;
}

@media (max-width: 992px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .values-grid { grid-template-columns: 1fr; }
    .content-wrapper { grid-template-columns: 1fr; }
    .page-hero h1 { font-size: 3rem; }
}
</style>

<?php get_footer(); ?>
