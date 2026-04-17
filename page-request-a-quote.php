<?php
/**
 * Template Name: Request a Quote
 */

$message_sent = false;
$error_message = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['full_name'])) {
    $to = get_option('admin_email');
    $subject = 'New PCB Quote Request from ' . sanitize_text_field($_POST['full_name']);
    
    $full_name = sanitize_text_field($_POST['full_name']);
    $email     = sanitize_email($_POST['email']);
    $company   = sanitize_text_field($_POST['company']);
    $phone     = sanitize_text_field($_POST['phone']);
    $address   = sanitize_textarea_field($_POST['address']);
    $service_type = sanitize_text_field($_POST['service_type']);
    $pin_count    = sanitize_text_field($_POST['pin_count']);
    $layers       = sanitize_text_field($_POST['target_layers']);
    $timeline     = sanitize_text_field($_POST['timeline']);
    $message      = sanitize_textarea_field($_POST['message']);

    $body = "You have a new Project request:\n\n";
    $body .= "--- Contact Details ---\n";
    $body .= "Name: $full_name\n";
    $body .= "Email: $email\n";
    $body .= "Company: $company\n";
    $body .= "Phone: $phone\n";
    $body .= "Address: $address\n\n";
    $body .= "--- Design Details ---\n";
    $body .= "Service: $service_type\n";
    $body .= "Pins: $pin_count\n";
    $body .= "Layers: $layers\n";
    $body .= "Timeline: $timeline\n\n";
    $body .= "--- Message ---\n";
    $body .= "$message\n";

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $full_name . ' <' . $email . '>');
    
    // File Attachment Handling with Safety Checks
    $attachments = array();
    $file_url = "";
    if (!empty($_FILES['gerber_file']['name'])) {
        $file = $_FILES['gerber_file'];
        $max_size = 20 * 1024 * 1024; // 20MB Limit
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if ($file['size'] > $max_size) {
            $error_message = "File is too large. Maximum limit is 20MB.";
        } elseif (!in_array($ext, array('zip', 'rar', '7z', 'pdf'))) {
            $error_message = "Only .zip, .rar, or .pdf files are allowed.";
        } else {
            // Use a more relaxed upload check and bypass internal type check
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            $upload_overrides = array(
                'test_form' => false,
                'test_type' => false // [FIX] Disable WordPress's internal mime check
            );
            $upload = wp_handle_upload($file, $upload_overrides);

            if (isset($upload['file'])) {
                $attachments[] = $upload['file'];
                $file_url = $upload['url'];
            } else {
                $error_message = "Upload Error: " . ($upload['error'] ?? 'Unknown error');
            }
        }
    }

    // Only save to DB if there's no error
    if (empty($error_message)) {
        $post_id = wp_insert_post(array(
            'post_title'   => 'Quote for ' . $full_name . ' (' . $company . ')',
            'post_content' => $body,
            'post_status'  => 'publish',
            'post_type'    => 'pcb_quote',
        ));

        if ($post_id) {
            update_post_meta($post_id, '_customer_email', $email);
            update_post_meta($post_id, '_customer_phone', $phone);
            update_post_meta($post_id, '_customer_address', $address);
            update_post_meta($post_id, '_service_type', $service_type);
            update_post_meta($post_id, '_pin_count', $pin_count);
            update_post_meta($post_id, '_target_layers', $layers);
            update_post_meta($post_id, '_timeline', $timeline);
            update_post_meta($post_id, '_file_url', $file_url);
            
            $message_sent = true; // [FIX] Show success if saved to DB
            
            // Try to send mail, but don't block success if it fails on Localhost
            @wp_mail($to, $subject, $body, $headers, $attachments);
        } else {
            $error_message = "Database error. Please try again.";
        }
    }
}

get_header(); ?>

<main class="quote-page">
    <!-- Hero Section -->
    <section class="quote-hero reveal">
        <div class="container">
            <div class="text-center">
                <span class="badge">AIPL Design Studio</span>
                <h1>PCB Design &amp; Consultancy</h1>
                <p>Collaborate with our expert engineers to design high-performance, manufacture-ready PCBs. From concept to full schematic and layout, we deliver precision engineering.</p>
                <div class="mfg-cta-banner">
                    <p>Looking for PCB Manufacturing only?</p>
                    <a href="<?php echo esc_url(home_url('/manufacturing-quote')); ?>" class="mfg-link-btn">Go to Online Manufacturing Quote &rarr;</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quote Form Section -->
    <section class="quote-form-section">
        <div class="container">
            <div class="quote-container">
                <div class="quote-info-sidebar">
                    <div class="info-card">
                        <h3>Why Choose Us?</h3>
                        <ul class="info-list">
                            <li><span>✓</span> PCB Design (Schematic & Layout)</li>
                            <li><span>✓</span> Technical Consultancy Services</li>
                            <li><span>✓</span> High-Precision Manufacturing</li>
                            <li><span>✓</span> 24h Engineering Support</li>
                            <li><span>✓</span> ISO 9001:2015 Certified Quality</li>
                        </ul>
                    </div>
                    <div class="contact-card">
                        <p>Need immediate help?</p>
                        <a href="tel:+123456789" class="phone-link">+123 456 789</a>
                        <p>support@aipl.com</p>
                    </div>
                </div>

                <div class="quote-main-form">
                    <?php if ($message_sent) : ?>
                        <div class="success-message">
                            <h2>✅ Request Sent Successfully!</h2>
                            <p>Thank you, <?php echo esc_html($full_name); ?>. Our engineers will review your Gerber files and get back to you at <?php echo esc_html($email); ?> shortly.</p>
                            <a href="<?php echo esc_url(home_url('/request-a-quote')); ?>" class="btn btn-outline">Send Another Request</a>
                        </div>
                    <?php else : ?>
                        <?php if ($error_message) echo '<p class="error-text">'.$error_message.'</p>'; ?>
                        <form id="pcbQuoteForm" class="glass-form" method="POST" enctype="multipart/form-data">
                        <div class="form-step">
                            <h2 class="form-title">1. Basic Information</h2>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Full Name *</label>
                                    <input type="text" name="full_name" placeholder="John Doe" required>
                                </div>
                                <div class="form-group">
                                    <label>Email Address *</label>
                                    <input type="email" name="email" placeholder="john@example.com" required>
                                </div>
                                <div class="form-group">
                                    <label>Phone Number *</label>
                                    <input type="tel" name="phone" placeholder="+1 234 567 890" required>
                                </div>
                                <div class="form-group">
                                    <label>Company Name</label>
                                    <input type="text" name="company" placeholder="Example Corp">
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <h2 class="form-title">2. Design Requirements</h2>
                            <div class="form-grid">
                                <div class="form-group">
                                    <label>Design Service Required *</label>
                                    <select name="service_type" required>
                                        <option value="design_layout">Full PCB Layout (from Schematic)</option>
                                        <option value="schematic_layout">Full Design (Schematic + Layout)</option>
                                        <option value="consultancy">Technical Consultancy / Review</option>
                                        <option value="reverse_engineering">Reverse Engineering</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Estimated Pin Count</label>
                                    <input type="text" name="pin_count" placeholder="e.g. 100-500 pins">
                                </div>
                                <div class="form-group">
                                    <label>Target Layers</label>
                                    <select name="target_layers">
                                        <option value="2">2 Layers</option>
                                        <option value="4">4 Layers</option>
                                        <option value="6">6 Layers</option>
                                        <option value="8+">8+ Layers</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Project Timeline</label>
                                    <select name="timeline">
                                        <option value="urgent">Urgent (1-3 days)</option>
                                        <option value="standard" selected>Standard (1-2 weeks)</option>
                                        <option value="flexible">Flexible</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-step">
                            <h2 class="form-title">3. Delivery Address</h2>
                            <div class="form-group">
                                <label>Shipping / Billing Address *</label>
                                <textarea name="address" rows="3" placeholder="Enter your full address here..." required></textarea>
                            </div>
                        </div>

                        <div class="form-step">
                            <h2 class="form-title">4. Files &amp; Message</h2>
                            <div class="form-group">
                                <label>Upload Project Files (.zip, .rar, or .pdf)</label>
                                <div class="file-drop-zone">
                                    <input type="file" name="gerber_file" id="gerber" hidden>
                                    <label for="gerber" class="drop-label">
                                        <div class="drop-icon">📂</div>
                                        <span>Click to browse or drag your files here</span>
                                        <small>Upload Gerber files, Schematics, or Project Briefs (Max 20MB)</small>
                                    </label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Additional Instructions</label>
                                <textarea name="message" rows="4" placeholder="Tell us more about your project requirements..."></textarea>
                            </div>
                        </div>

                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary btn-full">Submit Design Brief</button>
                            <p class="form-note">By submitting, you agree to our privacy policy and NDA terms.</p>
                        </div>
                    </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>
</main>

<style>
/* Base Styles */
.quote-page { background: #000; color: #fff; padding-bottom: 8rem; }
.container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

/* Hero */
.quote-hero { padding: 10rem 0 4rem; background: linear-gradient(to bottom, #111, #000); position: relative; overflow: hidden; }
.mfg-cta-banner { background: rgba(124, 77, 255, 0.1); border: 1px solid rgba(124, 77, 255, 0.2); display: inline-flex; align-items: center; gap: 2rem; padding: 1rem 2rem; border-radius: 50px; margin-top: 3rem; }
.mfg-cta-banner p { font-size: 0.95rem; color: #ccc; margin: 0; }
.mfg-link-btn { color: #7c4dff; text-decoration: none; font-weight: 700; font-size: 0.95rem; transition: 0.3s; }
.mfg-link-btn:hover { color: #fff; transform: translateX(5px); }
.quote-hero h1 { font-size: 3.5rem; font-weight: 800; margin: 1.5rem 0; }
.quote-hero p { font-size: 1.25rem; color: #aaa; max-width: 700px; margin: 0 auto; }
.badge { background: #7c4dff; color: #fff; padding: 0.5rem 1.2rem; border-radius: 2rem; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; }

/* Layout Grid */
.quote-container { display: grid; grid-template-columns: 350px 1fr; gap: 4rem; margin-top: 4rem; }

/* Sidebar */
.quote-info-sidebar { display: flex; flex-direction: column; gap: 2rem; }
.info-card { background: rgba(255,255,255,0.03); border: 1px solid rgba(255,255,255,0.05); padding: 2.5rem; border-radius: 1.5rem; }
.info-card h3 { font-size: 1.5rem; margin-bottom: 1.5rem; color: #7c4dff; }
.info-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 1rem; }
.info-list li { display: flex; gap: 1rem; color: #ccc; }
.info-list li span { color: #7c4dff; font-weight: 900; }
.contact-card { text-align: center; padding: 2rem; }
.phone-link { font-size: 1.5rem; font-weight: 700; color: #fff; text-decoration: none; display: block; margin: 0.5rem 0; }

/* Form Styles */
.quote-main-form { }
.glass-form { background: rgba(255,255,255,0.05); backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); padding: 4rem; border-radius: 2rem; box-shadow: 0 40px 100px rgba(0,0,0,0.4); }
.form-step { margin-bottom: 4rem; }
.form-title { font-size: 1.5rem; margin-bottom: 2rem; color: #7c4dff; font-weight: 700; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem; }

.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.form-group { margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; }
.form-group label { font-size: 0.9rem; font-weight: 600; color: #888; }

input, select, textarea { 
    background: rgba(0,0,0,0.3); 
    border: 1px solid rgba(255,255,255,0.1); 
    padding: 1rem 1.25rem; 
    border-radius: 0.75rem; 
    color: #fff; 
    font-size: 1rem; 
    transition: all 0.3s;
}
input:focus, select:focus, textarea:focus { border-color: #7c4dff; outline: none; background: rgba(0,0,0,0.5); }

/* Project Type Cards */
.project-type-selector { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; }
.type-card { cursor: pointer; position: relative; }
.type-card input { position: absolute; opacity: 0; cursor: pointer; height: 0; width: 0; }
.card-content { 
    background: rgba(255,255,255,0.03); 
    border: 2px solid rgba(255,255,255,0.05); 
    padding: 2rem; 
    border-radius: 1.5rem; 
    display: flex; 
    align-items: center; 
    gap: 1.5rem; 
    transition: 0.3s;
}
.type-card:hover .card-content { border-color: rgba(124, 77, 255, 0.3); background: rgba(124, 77, 255, 0.05); }
.type-card input:checked + .card-content { border-color: #7c4dff; background: rgba(124, 77, 255, 0.1); box-shadow: 0 10px 30px rgba(124,77,255,0.2); }
.card-icon { font-size: 2.5rem; }
.card-text h3 { font-size: 1.25rem; font-weight: 700; color: #fff; margin-bottom: 0.25rem; }
.card-text p { font-size: 0.9rem; color: #888; }
.type-card input:checked + .card-content .card-text h3 { color: #7c4dff; }

/* Success State */
.success-message { text-align: center; padding: 4rem; background: rgba(0, 255, 100, 0.05); border: 1px solid rgba(0, 255, 100, 0.2); border-radius: 2rem; }
.success-message h2 { color: #00ff66; margin-bottom: 1rem; }
.success-message p { color: #ccc; margin-bottom: 2rem; }
.error-text { color: #ff4d4d; margin-bottom: 1rem; text-align: center; font-weight: 700; }

/* File Drop Zone */
.file-drop-zone { border: 2px dashed rgba(255,255,255,0.15); border-radius: 1rem; padding: 3rem; text-align: center; transition: 0.3s; cursor: pointer; }
.file-drop-zone:hover { border-color: #7c4dff; background: rgba(124, 77, 255, 0.05); }
.drop-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.drop-label span { display: block; font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem; }
.drop-label small { color: #555; }

/* Footer & Buttons */
.form-footer { text-align: center; margin-top: 2rem; }
.btn { display: inline-block; padding: 1.25rem 3rem; border-radius: 1rem; font-weight: 700; text-decoration: none; cursor: pointer; transition: 0.3s; border: none; }
.btn-primary { background: #7c4dff; color: #fff; }
.btn-primary:hover { background: #6200ea; transform: translateY(-3px); box-shadow: 0 10px 25px rgba(124, 77, 255, 0.4); }
.btn-full { width: 100%; font-size: 1.1rem; }
.form-note { margin-top: 1.5rem; font-size: 0.85rem; color: #555; }

/* Responsive */
@media (max-width: 968px) {
    .quote-container { grid-template-columns: 1fr; gap: 3rem; }
    .quote-info-sidebar { order: 2; }
    .quote-main-form { order: 1; }
    .glass-form { padding: 2.5rem; }
}
@media (max-width: 600px) {
    .form-grid { grid-template-columns: 1fr; }
    .quote-hero h1 { font-size: 2.5rem; }
}
/* Design Studio Theme Overrides */
.quote-main-form .glass-form { border-top: 4px solid #7c4dff; }
.form-title { letter-spacing: 0.05em; font-size: 1.2rem; margin-bottom: 2rem; }
.mfg-cta-banner { display: flex; align-items: center; justify-content: center; gap: 2rem; margin-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 2rem; }
.file-drop-zone.highlight { border-color: #7c4dff; background: rgba(124, 77, 255, 0.15); }
</style>

<?php get_footer(); ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('gerber');
    const dropZone = document.querySelector('.file-drop-zone');
    const dropLabel = document.querySelector('.drop-label span');
    const dropIcon = document.querySelector('.drop-icon');

    function updateFileStatus(file) {
        if (file) {
            dropLabel.innerHTML = "📝 Selected: <strong>" + file.name + "</strong>";
            dropZone.style.borderColor = "#7c4dff";
            dropZone.style.background = "rgba(124, 77, 255, 0.1)";
            dropIcon.innerHTML = "✅";
        }
    }

    fileInput.addEventListener('change', function(e) {
        updateFileStatus(this.files[0]);
    });

    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults (e) {
        e.preventDefault();
        e.stopPropagation();
    }

    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.add('highlight'), false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, () => dropZone.classList.remove('highlight'), false);
    });

    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        let dt = e.dataTransfer;
        let files = dt.files;
        fileInput.files = files; 
        updateFileStatus(files[0]);
    }
});
</script>
