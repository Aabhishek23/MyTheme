<?php
/**
 * Template Name: Track Your Order
 */
get_header(); ?>

<main class="premium-page track-page">
    <section class="page-hero">
        <div class="container">
            <div class="hero-content reveal">
                <span class="badge">REAL-TIME UPDATES</span>
                <h1>Track Your <span class="gradient-text">Project Status</span></h1>
                <p class="lead">Enter your order ID or tracking number to see the current stage of your PCB manufacturing or design process.</p>
            </div>
        </div>
    </section>

    <section class="track-form-section reveal">
        <div class="container">
            <div class="track-search-box">
                <form class="glass-search" action="#" method="GET">
                    <div class="search-input-wrapper">
                        <span class="search-icon">🔍</span>
                        <input type="text" name="order_id" placeholder="Enter Order ID (e.g., AIPL-9826)" required>
                        <button type="submit" class="track-btn">Track Order</button>
                    </div>
                </form>
                <div class="quick-help">
                    <p>Can't find your ID? Check your confirmation email or <a href="<?php echo home_url('/contact-us/'); ?>">contact support</a>.</p>
                </div>
            </div>

            <!-- Tracking Result Placeholder (Hidden by default) -->
            <?php if(isset($_GET['order_id'])): ?>
            <div class="track-result reveal">
                <div class="order-status-card">
                    <div class="card-header">
                        <div class="order-meta">
                            <span class="order-label">Order ID:</span>
                            <span class="order-value"><?php echo esc_html($_GET['order_id']); ?></span>
                        </div>
                        <div class="status-badge pulse">In Production</div>
                    </div>
                    
                    <div class="status-timeline">
                        <div class="step completed">
                            <div class="step-dot"></div>
                            <div class="step-label">Order Confirmed</div>
                            <div class="step-date">April 15, 2026</div>
                        </div>
                        <div class="step completed">
                            <div class="step-dot"></div>
                            <div class="step-label">Engineering Review (EQ)</div>
                            <div class="step-date">April 16, 2026</div>
                        </div>
                        <div class="step active">
                            <div class="step-dot"></div>
                            <div class="step-label">Imaging & Lamination</div>
                            <div class="step-info">Currently at 65% completion</div>
                        </div>
                        <div class="step">
                            <div class="step-dot"></div>
                            <div class="step-label">Drilling & Plating</div>
                        </div>
                        <div class="step">
                            <div class="step-dot"></div>
                            <div class="step-label">Testing & Inspection</div>
                        </div>
                        <div class="step">
                            <div class="step-dot"></div>
                            <div class="step-label">Shipping</div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Track Features -->
    <section class="track-features reveal">
        <div class="container">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="f-icon">⏱️</div>
                    <h3>Milestone Alerts</h3>
                    <p>Get notified via email as soon as your board moves to the next manufacturing stage.</p>
                </div>
                <div class="feature-card">
                    <div class="f-icon">📸</div>
                    <h3>AOI Reports</h3>
                    <p>Premium users can view Automated Optical Inspection images directly from our lab.</p>
                </div>
                <div class="feature-card">
                    <div class="f-icon">🚚</div>
                    <h3>Global Logistics</h3>
                    <p>Integration with DHL, FedEx, and BlueDart for real-time shipping tracking.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.premium-page { background: #000; color: #fff; padding-bottom: 8rem; }
.page-hero { padding: 12rem 0 6rem; text-align: center; }
.badge { background: rgba(0, 123, 255, 0.1); color: #007bff; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 2rem; border: 1px solid rgba(0, 123, 255, 0.2); }
.page-hero h1 { font-size: 3.5rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.04em; }
.page-hero .lead { font-size: 1.1rem; color: var(--text-muted); max-width: 600px; margin: 0 auto; }
.gradient-text { background: linear-gradient(135deg, #007bff, #00d2ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.track-form-section { padding-bottom: 6rem; }
.track-search-box { max-width: 800px; margin: 0 auto; }
.glass-search { background: var(--surface); padding: 0.5rem; border-radius: 1.5rem; border: 1px solid var(--glass-border); backdrop-filter: blur(20px); }
.search-input-wrapper { display: flex; align-items: center; gap: 1rem; padding: 0.5rem 1rem; }
.search-icon { font-size: 1.2rem; }
.search-input-wrapper input { flex: 1; background: transparent; border: none; padding: 1rem; color: #fff; font-size: 1.1rem; outline: none; }
.track-btn { background: #007bff; color: #fff; border: none; padding: 1rem 2.5rem; border-radius: 1rem; font-weight: 700; cursor: pointer; transition: 0.3s; }
.track-btn:hover { background: #0056b3; transform: scale(1.02); }

.quick-help { text-align: center; margin-top: 2rem; color: var(--text-muted); font-size: 0.9rem; }
.quick-help a { color: #007bff; text-decoration: none; font-weight: 600; }

.track-result { margin-top: 6rem; max-width: 800px; margin-left: auto; margin-right: auto; }
.order-status-card { background: var(--surface); border-radius: 2rem; border: 1px solid var(--glass-border); padding: 3rem; }
.card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4rem; padding-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.05); }
.order-meta { display: flex; flex-direction: column; gap: 0.5rem; }
.order-label { color: var(--text-muted); font-size: 0.85rem; font-weight: 600; text-transform: uppercase; }
.order-value { font-size: 1.4rem; font-weight: 800; font-family: monospace; color: #007bff; }
.status-badge { background: rgba(0, 210, 255, 0.1); color: #00d2ff; padding: 0.6rem 1.25rem; border-radius: 50px; font-weight: 700; border: 1px solid rgba(0, 210, 255, 0.2); }

.status-timeline { position: relative; padding-left: 3rem; }
.status-timeline::before { content: ''; position: absolute; left: 6px; top: 0; bottom: 0; width: 2px; background: rgba(255,255,255,0.1); }

.step { position: relative; margin-bottom: 3rem; color: var(--text-muted); }
.step:last-child { margin-bottom: 0; }
.step-dot { position: absolute; left: -34px; top: 0; width: 14px; height: 14px; background: #222; border: 2px solid #444; border-radius: 50%; z-index: 1; }
.step.completed .step-dot { background: #007bff; border-color: #007bff; box-shadow: 0 0 15px rgba(0,123,255,0.4); }
.step.active .step-dot { background: #00d2ff; border-color: #00d2ff; box-shadow: 0 0 15px rgba(0,210,255,0.4); }

.step-label { font-size: 1.1rem; font-weight: 700; margin-bottom: 0.25rem; }
.step.completed .step-label { color: #fff; }
.step.active .step-label { color: #00d2ff; }
.step-date, .step-info { font-size: 0.85rem; }

.track-features { padding: 8rem 0; border-top: 1px solid var(--glass-border); }
.features-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 3rem; }
.feature-card { text-align: center; }
.f-icon { font-size: 2.5rem; margin-bottom: 1.5rem; }
.feature-card h3 { font-size: 1.25rem; margin-bottom: 1rem; }
.feature-card p { color: var(--text-muted); font-size: 0.95rem; line-height: 1.5; }

@media (max-width: 768px) {
    .search-input-wrapper { flex-direction: column; align-items: stretch; }
    .features-grid { grid-template-columns: 1fr; }
    .page-hero h1 { font-size: 2.5rem; }
}
</style>

<?php get_footer(); ?>
