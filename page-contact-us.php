<?php
$success_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['contact_name'])) {
    $name    = sanitize_text_field($_POST['contact_name']);
    $email   = sanitize_email($_POST['contact_email']);
    $subject = sanitize_text_field($_POST['contact_subject']);
    $message = sanitize_textarea_field($_POST['contact_message']);

    $post_id = wp_insert_post(array(
        'post_title'   => $name,
        'post_content' => $message,
        'post_status'  => 'publish',
        'post_type'    => 'contact_inquiry',
    ));

    if ($post_id) {
        update_post_meta($post_id, '_contact_email', $email);
        update_post_meta($post_id, '_contact_subject', $subject);
        update_post_meta($post_id, '_is_read', '0');
        $success_msg = "Your message has been received. We will get back to you soon!";
    }
}
get_header(); ?>

<main class="premium-page contact-page">
    <section class="page-hero">
        <div class="container">
            <div class="hero-content reveal">
                <span class="badge">GET IN TOUCH</span>
                <h1>Let's Start a <span class="gradient-text">Conversation</span></h1>
                <p class="lead">Have a technical question or need a quote? Our team of engineers is ready to help you bring your project to life.</p>
            </div>
        </div>
    </section>

    <section class="contact-methods reveal">
        <div class="container">
            <div class="contact-grid">
                <!-- Info Section -->
                <div class="contact-info">
                    <div class="info-card">
                        <div class="info-item">
                            <div class="info-icon">📍</div>
                            <div class="info-text">
                                <h3>Visit Our Lab</h3>
                                <p>AIMS Interactive Pvt Ltd,<br>Near Dubey Lodge, Wright Town,<br>Jabalpur, MP 482002, India</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">📞</div>
                            <div class="info-text">
                                <h3>Call Experts</h3>
                                <p>+91 9826541718<br>Mon-Sat: 11:00 AM - 7:00 PM</p>
                            </div>
                        </div>
                        <div class="info-item">
                            <div class="info-icon">✉️</div>
                            <div class="info-text">
                                <h3>Email Support</h3>
                                <p>info@aimsint.in</p>
                            </div>
                        </div>
                    </div>

                    <div class="social-links-box">
                        <h3>Follow Our Progress</h3>
                        <div class="social-icons">
                            <a href="#" class="social-btn">LinkedIn</a>
                            <a href="#" class="social-btn">Twitter</a>
                            <a href="#" class="social-btn">Instagram</a>
                        </div>
                    </div>
                </div>

                <!-- Form Section -->
                <div class="contact-form-container">
                    <?php if ($success_msg) : ?>
                        <div class="success-alert">
                            <span class="alert-icon">✅</span>
                            <p><?php echo esc_html($success_msg); ?></p>
                        </div>
                    <?php endif; ?>

                    <form class="glass-form" action="" method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Your Name</label>
                                <input type="text" name="contact_name" placeholder="John Doe" required>
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" name="contact_email" placeholder="john@example.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <select name="contact_subject">
                                <option value="General Inquiry">General Inquiry</option>
                                <option value="Technical Support">Technical Support</option>
                                <option value="Order Status">Order Status</option>
                              
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Message</label>
                            <textarea name="contact_message" rows="5" placeholder="Tell us about your project..." required></textarea>
                        </div>
                        <button type="submit" class="submit-btn-glow">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Map Section -->
    <section class="map-section reveal">
        <div class="container">
            <div class="map-wrapper">
                <div class="compass-rose">
                    <span class="north">N</span>
                    <span class="south">S</span>
                    <span class="east">E</span>
                    <span class="west">W</span>
                    <div class="needle"></div>
                </div>
                <iframe 
                    src="https://maps.google.com/maps?q=AIMS%20Interactive%20Pvt%20Ltd%20Jabalpur&t=&z=15&ie=UTF8&iwloc=&output=embed" 
                    allowfullscreen="" 
                    loading="lazy">
                </iframe>
            </div>
        </div>
    </section>
</main>

<style>
.premium-page { background: #000; color: #fff; overflow: hidden; }
.page-hero { padding: 10rem 0 6rem; text-align: center; }
.badge { background: rgba(0, 123, 255, 0.1); color: #007bff; padding: 0.5rem 1rem; border-radius: 50px; font-size: 0.8rem; font-weight: 700; display: inline-block; margin-bottom: 2rem; border: 1px solid rgba(0, 123, 255, 0.2); }
.page-hero h1 { font-size: 4rem; font-weight: 800; margin-bottom: 1.5rem; letter-spacing: -0.04em; }
.page-hero .lead { font-size: 1.25rem; color: var(--text-muted); max-width: 700px; margin: 0 auto; }
.gradient-text { background: linear-gradient(135deg, #007bff, #00d2ff); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }

.contact-methods { padding: 4rem 0 8rem; }
.contact-grid { display: grid; grid-template-columns: 400px 1fr; gap: 4rem; }

.info-card { background: var(--surface); padding: 3rem; border-radius: 1.5rem; border: 1px solid var(--glass-border); margin-bottom: 2rem; }
.info-item { display: flex; gap: 1.5rem; margin-bottom: 2.5rem; }
.info-item:last-child { margin-bottom: 0; }
.info-icon { font-size: 1.8rem; background: rgba(255,255,255,0.05); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; border-radius: 1rem; border: 1px solid var(--glass-border); }
.info-text h3 { font-size: 1.1rem; margin-bottom: 0.5rem; }
.info-text p { color: var(--text-muted); line-height: 1.5; font-size: 0.95rem; }

.social-links-box h3 { font-size: 1.1rem; margin-bottom: 1.5rem; }
.social-icons { display: flex; gap: 1rem; }
.social-btn { padding: 0.75rem 1.5rem; background: var(--surface); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: #fff; text-decoration: none; font-size: 0.9rem; transition: 0.3s; }
.social-btn:hover { background: #fff; color: #000; transform: translateY(-3px); }

.glass-form { background: var(--surface); padding: 4rem; border-radius: 2rem; border: 1px solid var(--glass-border); backdrop-filter: blur(20px); }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.form-group { margin-bottom: 2rem; }
.form-group label { display: block; margin-bottom: 0.75rem; font-size: 0.9rem; font-weight: 600; color: rgba(255, 255, 255, 0.7); }
.form-group input, .form-group select, .form-group textarea { width: 100%; padding: 1rem; background: rgba(255,255,255,0.03); border: 1px solid var(--glass-border); border-radius: 0.75rem; color: #fff; font-size: 1rem; outline: none; transition: 0.3s; }
.form-group select option { background: #111; color: #fff; }
.form-group input:focus, .form-group select:focus, .form-group textarea:focus { border-color: #007bff; background: rgba(0,123,255,0.05); color: #fff; }

.submit-btn-glow { width: 100%; padding: 1.25rem; background: #007bff; color: #fff; border: none; border-radius: 0.75rem; font-size: 1.1rem; font-weight: 700; cursor: pointer; transition: 0.4s; box-shadow: 0 10px 20px rgba(0,123,255,0.2); }
.submit-btn-glow:hover { transform: translateY(-3px); box-shadow: 0 15px 30px rgba(0,123,255,0.4); background: #0056b3; }

.map-section { padding-bottom: 8rem; }
.map-wrapper { height: 450px; background: #111; border-radius: 2rem; border: 1px solid var(--glass-border); overflow: hidden; position: relative; }
.map-wrapper iframe { width: 100%; height: 100%; border: 0; filter: grayscale(0.5) brightness(0.8) contrast(1.2); opacity: 0.9; transition: 0.5s; }
.map-wrapper:hover iframe { filter: grayscale(0) brightness(1) contrast(1); opacity: 1; }

.compass-rose { position: absolute; top: 25px; right: 25px; width: 60px; height: 60px; background: rgba(0,0,0,0.7); border: 1px solid rgba(255,255,255,0.2); border-radius: 50%; z-index: 10; display: flex; align-items: center; justify-content: center; backdrop-filter: blur(8px); pointer-events: none; }
.compass-rose span { position: absolute; font-size: 11px; font-weight: 900; color: #fff; text-shadow: 0 2px 4px rgba(0,0,0,0.5); }
.north { top: 5px; color: #ff3b30 !important; }
.south { bottom: 5px; }
.east { right: 7px; }
.west { left: 7px; }
.needle { width: 2px; height: 34px; background: linear-gradient(to bottom, #ff3b30 50%, #fff 50%); border-radius: 5px; box-shadow: 0 0 10px rgba(255,59,48,0.3); }

.success-alert { background: rgba(0, 255, 127, 0.1); border: 1px solid rgba(0, 255, 127, 0.3); padding: 1.5rem; border-radius: 1rem; margin-bottom: 2rem; display: flex; align-items: center; gap: 1rem; color: #00ff7f; animation: slideDown 0.5s ease-out; }
@keyframes slideDown { from { transform: translateY(-20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
.alert-icon { font-size: 1.5rem; }

@media (max-width: 992px) {
    .contact-grid { grid-template-columns: 1fr; }
    .form-row { grid-template-columns: 1fr; }
}
</style>

<?php get_footer(); ?>
