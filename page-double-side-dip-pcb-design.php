<?php
/**
 * Template Name: Double Side DIP PCB Design
 */
get_header(); ?>

<main class="pcb-design-template">
    <!-- Hero Section -->
    <section class="pcb-hero reveal" style="background-image: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('<?php echo get_template_directory_uri(); ?>/assets/images/pcb_hero_bg.png');">
        <div class="container">
            <div class="hero-content">
                <span class="badge">Through-Hole DIP Solutions</span>
                <h1>Double-Sided DIP PCB <br>Design &amp; Manufacturing</h1>
                <p>Robust double-sided through-hole PCB design for Dual In-line Package (DIP) components — ideal for industrial controls, power electronics, and high-reliability applications.</p>
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
                    <h2 class="section-title">Strength of Double-Sided Through-Hole Design</h2>
                    <p>Double-sided DIP PCBs utilize both top and bottom copper layers connected via plated through-holes, allowing placement of DIP components on either side. This design excels in high-current, high-voltage, and vibration-heavy environments where through-hole joints provide superior mechanical strength.</p>
                    <ul class="feature-list">
                        <li><strong>Superior Mechanical Strength:</strong> Through-hole solder joints withstand stress, vibration, and thermal cycling.</li>
                        <li><strong>Dual-Layer Routing:</strong> Top and bottom copper layers enable complex signal routing without extra layers.</li>
                        <li><strong>High Current Capacity:</strong> Ideal for power-heavy DIP ICs, relays, connectors, and transformers.</li>
                    </ul>
                </div>
                <div class="overview-image">
                    <!-- Image Slider -->
                    <div class="pcb-slider" id="dipSlider">
                        <div class="slider-track">
                            <div class="slide active">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/yellow.png" alt="DIP PCB Top Layer">
                                <div class="slide-label">Top Layer</div>
                            </div>
                            <div class="slide">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/redpcb.png" alt="DIP PCB Bottom Layer">
                                <div class="slide-label">Bottom Layer</div>
                            </div>
                            <div class="slide">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/pcb_feature.png" alt="DIP PCB Full Board">
                                <div class="slide-label">Full Board</div>
                            </div>
                        </div>
                        <!-- Navigation Tabs -->
                        <div class="slider-tabs">
                            <button class="stab active" onclick="goToSlide('dipSlider', 0)">Top Layer</button>
                            <button class="stab" onclick="goToSlide('dipSlider', 1)">Bottom Layer</button>
                            <button class="stab" onclick="goToSlide('dipSlider', 2)">Full Board</button>
                        </div>
                        <!-- Dot Indicators -->
                        <div class="slider-dots">
                            <span class="dot active" onclick="goToSlide('dipSlider', 0)"></span>
                            <span class="dot" onclick="goToSlide('dipSlider', 1)"></span>
                            <span class="dot" onclick="goToSlide('dipSlider', 2)"></span>
                        </div>
                        <div class="glass-card-overlay">
                            <span>ISO 9001:2015 Certified</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Specs Section -->
    <section id="specs" class="pcb-specs reveal">
        <div class="container">
            <div class="text-center">
                <h2 class="section-title">DIP Technical Specifications</h2>
                <p class="section-subtitle">Our manufacturing capabilities for double-sided DIP boards</p>
            </div>
            
            <div class="specs-grid">
                <div class="spec-card">
                    <div class="spec-icon">🔬</div>
                    <h3>Materials</h3>
                    <ul>
                        <li>FR-4 Standard / High TG</li>
                        <li>CEM-1 / CEM-3</li>
                        <li>Aluminum / Metal Core</li>
                        <li>Paper Phenolic (FR-1/FR-2)</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">📏</div>
                    <h3>Dimensions</h3>
                    <ul>
                        <li>Max Board Size: 500mm x 600mm</li>
                        <li>Thickness: 0.8mm - 3.2mm</li>
                        <li>Copper Weight: 1oz - 4oz</li>
                        <li>Tolerance: ±0.1mm</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">🎨</div>
                    <h3>Finishes</h3>
                    <ul>
                        <li>HASL (Lead-Free)</li>
                        <li>ENIG (Electroless Nickel)</li>
                        <li>OSP (Organic Solderability)</li>
                        <li>Immersion Silver/Tin</li>
                    </ul>
                </div>
                <div class="spec-card">
                    <div class="spec-icon">⚡</div>
                    <h3>DIP Design Rules</h3>
                    <ul>
                        <li>Min Drill Size: 0.3mm (PTH)</li>
                        <li>Min Annular Ring: 0.15mm</li>
                        <li>Via Plating: Cu Plated Through-Hole</li>
                        <li>Solder Mask: Both Sides</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="pcb-process reveal">
        <div class="container">
            <h2 class="section-title text-center">DIP Manufacturing Process</h2>
            <div class="process-timeline">
                <div class="process-step">
                    <div class="step-num">01</div>
                    <h4>Gerber Review</h4>
                    <p>DFM analysis for through-hole layout and drill files.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">02</div>
                    <h4>PTH Drilling</h4>
                    <p>CNC drilling and copper plating of through-holes.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">03</div>
                    <h4>Etching</h4>
                    <p>Chemical etching of dual copper layers for pattern.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">04</div>
                    <h4>Wave Soldering</h4>
                    <p>Automated wave solder for DIP component leads.</p>
                </div>
                <div class="process-step">
                    <div class="step-num">05</div>
                    <h4>Inspection</h4>
                    <p>Electrical test, AOI &amp; visual joint inspection.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="quote" class="pcb-cta reveal">
        <div class="container">
            <div class="cta-card">
                <h2>Start Your DIP PCB Project Today</h2>
                <p>Get a precise manufacturing quote within 24 hours. Our engineers are ready to assist with your Double-Sided DIP PCB requirements.</p>
                <div class="cta-btns">
                    <a href="<?php echo esc_url(home_url('/contact')); ?>" class="btn btn-primary btn-large">Request a Quote</a>
                    <a href="tel:+123456789" class="btn btn-outline-white">Call an Expert</a>
                </div>
            </div>
        </div>
    </section>
</main>

<script>
function goToSlide(sliderId, index) {
    const slider = document.getElementById(sliderId);
    const slides = slider.querySelectorAll('.slide');
    const tabs   = slider.querySelectorAll('.stab');
    const dots   = slider.querySelectorAll('.dot');
    slides.forEach((s, i) => s.classList.toggle('active', i === index));
    tabs.forEach((t, i)   => t.classList.toggle('active', i === index));
    dots.forEach((d, i)   => d.classList.toggle('active', i === index));
    // Reset auto-cycle timer
    if (window['_timer_' + sliderId]) clearInterval(window['_timer_' + sliderId]);
    window['_timer_' + sliderId] = setInterval(() => {
        const current = [...slides].findIndex(s => s.classList.contains('active'));
        goToSlide(sliderId, (current + 1) % slides.length);
    }, 3000);
}
document.addEventListener('DOMContentLoaded', () => {
    ['dipSlider'].forEach(id => {
        window['_timer_' + id] = setInterval(() => {
            const slider = document.getElementById(id);
            if (!slider) return;
            const slides = slider.querySelectorAll('.slide');
            const current = [...slides].findIndex(s => s.classList.contains('active'));
            goToSlide(id, (current + 1) % slides.length);
        }, 3000);
    });
});
</script>
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
    margin-top: -80px;
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
.glass-card-overlay { position: absolute; top: 1rem; right: 1rem; background: rgba(255,255,255,0.8); backdrop-filter: blur(10px); padding: 1rem 1.5rem; border-radius: 0.5rem; font-weight: 700; border: 1px solid rgba(255,255,255,0.3);color:rgba(49, 49, 49, 1); }

/* PCB Image Slider */
.pcb-slider { position: relative; border-radius: 1rem; overflow: hidden; box-shadow: 0 40px 80px rgba(0,0,0,0.12); }
.slider-track { position: relative; }
.slide { display: none; position: relative; }
.slide.active { display: block; animation: fadeSlide 0.5s ease; }
@keyframes fadeSlide { from { opacity: 0; transform: scale(1.03); } to { opacity: 1; transform: scale(1); } }
.slide img { width: 100%; height: 550px; object-fit: cover; display: block; }
.slide-label { position: absolute; top: 1rem; left: 1rem; background: rgba(0,0,0,0.55); backdrop-filter: blur(6px); color: #fff; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; padding: 0.35rem 0.85rem; border-radius: 2rem; }

/* Tabs */
.slider-tabs { display: flex; gap: 0; border-top: 1px solid rgba(255,255,255,0.15); background: rgba(10,10,20,0.75); backdrop-filter: blur(8px); }
.stab { flex: 1; padding: 0.65rem 0.5rem; border: none; background: transparent; color: rgba(255,255,255,0.6); font-size: 0.78rem; font-weight: 600; cursor: pointer; transition: all 0.25s; border-bottom: 2px solid transparent; text-transform: uppercase; letter-spacing: 0.05em; }
.stab:hover { color: #fff; background: rgba(255,255,255,0.08); }
.stab.active { color: var(--secondary, #f0c040); border-bottom-color: var(--secondary, #f0c040); background: rgba(255,255,255,0.05); }

/* Dots */
.slider-dots { display: flex; justify-content: center; gap: 0.5rem; padding: 0.6rem 0; background: rgba(10,10,20,0.75); }
.dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255,255,255,0.3); cursor: pointer; transition: background 0.3s, transform 0.3s; }
.dot.active { background: var(--secondary, #f0c040); transform: scale(1.3); }

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
