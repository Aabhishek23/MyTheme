<?php
/**
 * Template Name: Single Side SMD PCB Design
 */
get_header(); ?>

<main class="pcb-design-template">
    <!-- Hero Section -->
    <section class="pcb-hero reveal" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/images/pcb_hero_bg.png');">
        <div class="container">
            <div class="hero-content">
                <span class="badge">Advanced SMD Solutions</span>
                <h1>Single-Sided SMD PCB <br>Design & Manufacturing</h1>
                <p>Specialized single-sided PCB design optimized for Surface Mount Device (SMD) components, balancing performance and production efficiency.</p>
                <div class="hero-btns">
                    <a href="#quote" class="btn btn-primary">Request a Quote</a>
                    <a href="#specs" class="btn btn-outline">Technical Specs</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Overview Section -->
    <section class="pcb-overview reveal">
        <div class="container">
            <div class="grid-2">
                <div class="overview-text">
                    <h2 class="section-title">SMD Optimization for Single-Sided Boards</h2>
                    <p>Our Single-Sided SMD PCB design process focuses on maximizing land pattern accuracy and solder mask precision. By leveraging SMD technology on a single conductive layer, we provide lightweight and compact solutions for modern electronics.</p>
                    <ul class="feature-list">
                        <li><strong>SMD Compatibility:</strong> Precision-engineered for 0402, 0603, and fine-pitch ICs.</li>
                        <li><strong>Automated Assembly:</strong> Optimized for pick-and-place manufacturing.</li>
                        <li><strong>Thermal Management:</strong> Enhanced layouts for heat dissipation in SMD components.</li>
                    </ul>
                </div>
                <div class="overview-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/images/yellow.png" alt="Single Sided SMD PCB Feature">
                    <div class="glass-card-overlay">
                        <span>High-Precision SMD Layout</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Specs Section -->
    <section id="specs" class="pcb-specs reveal">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">SMD Technical Specifications</h2>
                <p class="section-subtitle">Engineered for Surface Mount Technology</p>
            </div>
            
            <div class="specs-grid">
                <div class="spec-card">
                    <div class="spec-icon">🔬</div>
                    <h3>Materials</h3>
                    <ul>
                        <li>FR-4 High TG (Recommended for Reflow)</li>
                        <li>CEM-3 / Aluminum Base</li>
                        <li>Metal Core PCB (MCPCB)</li>
                        <li>Polyimide (Flexible)</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">📏</div>
                    <h3>SMD Precision</h3>
                    <ul>
                        <li>Min Pad Pitch: 0.4mm</li>
                        <li>Solder Mask Clearance: 2 mil</li>
                        <li>Copper Weight: 1oz - 2oz</li>
                        <li>Profile: V-Cut / Routing</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">🎨</div>
                    <h3>Surface Finishes</h3>
                    <ul>
                        <li>ENIG (Highly Recommended for SMD)</li>
                        <li>Immersion Silver / Tin</li>
                        <li>Lead-Free HASL</li>
                        <li>Hard Gold / ENEPIG</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">⚡</div>
                    <h3>SMD Design Rules</h3>
                    <ul>
                        <li>Min Trace/Space: 3/3 mil</li>
                        <li>Via-in-Pad capable</li>
                        <li>Solder Mask: Matte/Glossy Green, Black</li>
                        <li>Silkscreen: High-Resolution White</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="pcb-process reveal">
        <div class="container">
            <h2 class="section-title text-center">SMD Focused Process</h2>
            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-num">01</div>
                    <h4>DFM Analysis</h4>
                    <p>Design for Manufacturing review for SMD layout.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">02</div>
                    <h4>Stencil Fab</h4>
                    <p>Laser-cut stainless steel stencils for paste.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">03</div>
                    <h4>Reflow Soldering</h4>
                    <p>Controlled thermal profiles for SMD pads.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">04</div>
                    <h4>Automated AOI</h4>
                    <p>Camera-based inspection of component solder.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">05</div>
                    <h4>X-Ray Test</h4>
                    <p>Verification of BGA and hidden SMD joints.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="quote" class="pcb-cta reveal">
        <div class="container">
            <div class="cta-card">
                <h2>Start Your SMD Project Today</h2>
                <p>Get a specialized quote for your Single-Sided SMD PCB requirements. Experience precision manufacturing tailored for modern surface-mount technology.</p>
                <div class="cta-btns">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-large">Request SMD Quote</a>
                    <a href="tel:+123456789" class="btn btn-outline-white">Consult an Engineer</a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
/* Section Spacing */
.pcb-design-template section { padding: 6rem 0; }

/* Hero */
.pcb-hero {
    height: 80vh;
    display: flex;
    align-items: center;
    color: #fff;
    background-size: cover;
    background-position: center;
    margin-top: -80px; /* Offset for header if transparent */
    padding-top: 250px !important;
}
.pcb-hero h1 { font-size: 4rem; font-weight: 800; line-height: 1.1; margin: 1.5rem 0; }
.pcb-hero p { font-size: 1.25rem; opacity: 0.9; max-width: 600px; margin-bottom: 2.5rem; }
.badge { background: var(--secondary); padding: 0.5rem 1rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color:Black;}

/* Grid & Utilities */
.grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.text-center { text-align: center; }
.btn { display: inline-block; padding: 1rem 2rem; border-radius: 0.5rem; font-weight: 600; text-decoration: none; transition: all 0.3s ease; }
.btn-primary { background: var(--secondary); color: #000; }
.btn-primary:hover { background: #4a2fa0; color: #fff; transform: translateY(-2px); }
.btn-outline { border: 2px solid #fff; color: #fff; margin-left:1rem; }
.btn-outline:hover { background: #fff; color: #000; }
.btn-secondary { background: #fff; color: #000; }
.btn-secondary:hover { color: var(--secondary); }
.btn-large { padding: 1.25rem 3rem; font-size: 1.1rem; }
.btn-outline-white { border: 2px solid rgba(255,255,255,0.3); color: #fff; }

/* Overview */
.section-title { font-size: 2.5rem; margin-bottom: 1.5rem; font-weight: 700; color: var(--primary); }
.overview-text p { font-size: 1.1rem; color: var(--text-muted); line-height: 1.6; }
.feature-list { list-style: none; padding: 0; margin-top: 2rem; }
.feature-list li { margin-bottom: 1rem; padding-left: 2rem; position: relative; }
.feature-list li::before { content: "✓"; position: absolute; left: 0; color: var(--secondary); font-weight: 900; }
.overview-image { position: relative; border-radius: 1rem; overflow: hidden; box-shadow: 0 40px 80px rgba(0,0,0,0.1); }
.glass-card-overlay { position: absolute; bottom: 2rem; right: 2rem; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); padding: 1rem 1.5rem; border-radius: 0.5rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.3);color:rgba(49, 49, 49, 1); }

/* Specs Grid */
.specs-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-top: 4rem; }
.spec-card { background: var(--surface); padding: 2.5rem; border-radius: 1rem; border: 1px solid var(--glass-border); transition: 0.3s; }
.spec-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.05); border-color: var(--secondary); }
.spec-icon { font-size: 2.5rem; margin-bottom: 1.5rem; }
.spec-card h3 { margin-bottom: 1.25rem; font-size: 1.25rem; }
.spec-card ul { list-style: none; padding: 0; }
.spec-card li { margin-bottom: 0.5rem; color: var(--text-muted); font-size: 0.95rem; }

/* Process Timeline */
.process-timeline { display: flex; justify-content: space-between; margin-top: 4rem; position: relative; }
.process-timeline::before { content: ""; position: absolute; top: 1.5rem; left: 5%; right: 5%; height: 2px; background: #e2e8f0; z-index: 0; }
.process-step { flex: 1; text-align: center; position: relative; z-index: 1; padding: 0 1rem; }
.step-num { width: 3rem; height: 3rem; background: #fff; border: 2px solid var(--secondary); color: var(--secondary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; font-weight: 800;color:rgba(45, 45, 45, 1); }
.process-step h4 { margin-bottom: 0.5rem; }
.process-step p { font-size: 0.85rem; color: var(--text-muted); }

/* CTA Section */
.pcb-cta { background: #f8fafc; }
.cta-card { background: linear-gradient(135deg, var(--secondary), #4a2fa0); padding: 5rem; border-radius: 2rem; color: #fff; text-align: center; }
.cta-card h2 { font-size: 3rem; margin-bottom: 1.5rem; }
.cta-card p { font-size: 1.2rem; opacity: 0.9; max-width: 700px; margin: 0 auto 3rem; }
.cta-btns { display: flex; gap: 1.5rem; justify-content: center; }

@media (max-width: 768px) {
    .grid-2 { grid-template-columns: 1fr; }
    .pcb-hero h1 { font-size: 2.5rem; }
    .process-timeline { flex-direction: column; gap: 3rem; }
    .process-timeline::before { display: none; }
    .cta-card { padding: 3rem 1.5rem; }
    .cta-btns { flex-direction: column; }
    .btn-outline { margin-left: 0; margin-top: 1rem; }
}
</style>

<?php get_footer(); ?>
