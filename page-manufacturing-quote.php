<?php
/**
 * Template Name: Manufacturing Quote
 */

$message_sent = false;
$error_message = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['full_name'])) {
    $to = get_option('admin_email');
    $subject = 'New High-Precision Manufacturing Quote from ' . sanitize_text_field($_POST['full_name']);
    
    $full_name = sanitize_text_field($_POST['full_name']);
    $email     = sanitize_email($_POST['email']);
    $phone     = sanitize_text_field($_POST['phone']);
    $address   = sanitize_textarea_field($_POST['address']);
    
    $body = "You have a new High-Precision Manufacturing request:\n\n";
    $body .= "--- Contact Details ---\n";
    $body .= "Name: $full_name\n";
    $body .= "Email: $email\n";
    $body .= "Phone: $phone\n";
    $body .= "Address: $address\n\n";
    
    $body .= "--- PCB Specifications ---\n";
    foreach ($_POST as $key => $value) {
        if (!in_array($key, array('full_name', 'email', 'submit'))) {
            $body .= ucfirst(str_replace('_', ' ', $key)) . ": " . sanitize_text_field($value) . "\n";
        }
    }

    $headers = array('Content-Type: text/plain; charset=UTF-8', 'From: ' . $full_name . ' <' . $email . '>');
    
    // File Attachment Handling
    $attachments = array();
    $file_url = "";
    if (!empty($_FILES['gerber_file']['name'])) {
        // ... handled below ...
    } elseif (isset($_FILES['gerber_file']) && $_FILES['gerber_file']['error'] == UPLOAD_ERR_INI_SIZE) {
        $error_message = "File is too large. Please check your PHP settings (upload_max_filesize).";
    }

    if (empty($error_message) && !empty($_FILES['gerber_file']['name'])) {
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        $upload_overrides = array('test_form' => false, 'test_type' => false);
        $upload = wp_handle_upload($_FILES['gerber_file'], $upload_overrides);
        if (isset($upload['file'])) {
            $attachments[] = $upload['file'];
            $file_url = $upload['url'];
        } else {
            $error_message = "Upload Error: " . ($upload['error'] ?? 'Unknown error');
        }
    }

    // Only proceed if no upload error
    if (empty($error_message)) {
        // Save to custom post type 'pcb_quote'
        $post_id = wp_insert_post(array(
            'post_title'   => 'Mfg Quote: ' . $full_name,
            'post_content' => $body,
            'post_status'  => 'publish',
            'post_type'    => 'pcb_quote',
        ));

        if ($post_id) {
            update_post_meta($post_id, '_customer_email', $email);
            update_post_meta($post_id, '_customer_phone', $phone);
            update_post_meta($post_id, '_customer_address', $address);
            update_post_meta($post_id, '_service_type', 'manufacturing');
            update_post_meta($post_id, '_file_url', $file_url);
            $message_sent = true;
            @wp_mail($to, $subject, $body, $headers, $attachments);
        }
    }
}

get_header(); ?>

<div class="mfg-page-wrapper">
<main class="mfg-quote-page">
    <div class="mfg-container">
        <!-- Header -->
        <header class="mfg-header">
            <div class="header-left">
                <h1>Online PCB Quote</h1>
                <p>Fast, Reliable, High Precision Manufacturing</p>
            </div>
            <div class="header-links">
                <a href="#">Instructions For Ordering ></a>
                <a href="#">Upload History</a>
            </div>
        </header>

        <?php if ($error_message) echo '<p style="color:red; text-align:center; font-weight:700; background:rgba(255,0,0,0.1); padding:10px; border-radius:5px;">'.$error_message.'</p>'; ?>
        <form id="mfgQuoteForm" method="POST" enctype="multipart/form-data">
            <!-- Gerber Upload Section -->
            <section class="upload-section">
                <div class="gerber-box">
                    <input type="file" name="gerber_file" id="gerber_upload" hidden>
                    <label for="gerber_upload" class="upload-btn">
                        <span class="icon">📁</span> Add gerber file
                    </label>
                    <p class="upload-note">Only accept zip or rar, Max 100 MB, <a href="#">View example ></a></p>
                    <p class="privacy-note">🔒 All uploads are secure and confidential.</p>
                </div>
            </section>

            <!-- Main Specs -->
            <section class="specs-grid">
                <!-- Base Material -->
                <div class="spec-row">
                    <label>Base Material</label>
                    <div class="segmented-control">
                        <label class="segment active">
                            <input type="radio" name="base_material" value="FR-4" checked>
                            <span class="label-text">FR-4</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="base_material" value="Flex">
                            <span class="label-text">Flex</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="base_material" value="Aluminum">
                            <span class="label-text">Aluminum</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="base_material" value="Copper Core">
                            <span class="label-text">Copper Core</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="base_material" value="Rogers">
                            <span class="label-text">Rogers</span>
                        </label>
                    </div>
                </div>

                <!-- Layers -->
                <div class="spec-row">
                    <label>Layers</label>
                    <div class="segmented-control mini">
                        <?php foreach([1, 2, 4, 6, 8, 10, 12, 14, 16] as $layer): ?>
                        <label class="segment <?php echo $layer == 2 ? 'active' : ''; ?>">
                            <input type="radio" name="layers" value="<?php echo $layer; ?>" <?php echo $layer == 2 ? 'checked' : ''; ?>>
                            <span class="label-text"><?php echo $layer; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Dimensions -->
                <div class="spec-row">
                    <label>Dimensions</label>
                    <div class="input-group-row">
                        <input type="number" name="dim_length" value="100" class="mini-input">
                        <span class="multiplier">x</span>
                        <input type="number" name="dim_width" value="100" class="mini-input">
                        <select name="dim_unit" class="unit-select">
                            <option value="mm">mm</option>
                            <option value="inch">inch</option>
                        </select>
                    </div>
                </div>

                <!-- PCB Qty -->
                <div class="spec-row">
                    <label>PCB Qty</label>
                    <div class="segmented-control mini">
                        <?php foreach([5, 10, 30, 50, 100] as $qty): ?>
                        <label class="segment <?php echo $qty == 5 ? 'active' : ''; ?>">
                            <input type="radio" name="pcb_qty" value="<?php echo $qty; ?>" <?php echo $qty == 5 ? 'checked' : ''; ?>>
                            <span class="label-text"><?php echo $qty; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- PCB Thickness -->
                <div class="spec-row">
                    <label>PCB Thickness</label>
                    <div class="segmented-control mini">
                        <?php foreach(['0.4mm', '0.8mm', '1.0mm', '1.2mm', '1.6mm', '2.0mm'] as $thk): ?>
                        <label class="segment <?php echo $thk == '1.6mm' ? 'active' : ''; ?>">
                            <input type="radio" name="pcb_thickness" value="<?php echo $thk; ?>" <?php echo $thk == '1.6mm' ? 'checked' : ''; ?>>
                            <span class="label-text"><?php echo $thk; ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- PCB Color -->
                <div class="spec-row">
                    <label>PCB Color</label>
                    <div class="color-control">
                        <?php 
                        $colors = array(
                            'green' => '#2e7d32',
                            'purple' => '#7b1fa2',
                            'red' => '#d32f2f',
                            'yellow' => '#fbc02d',
                            'blue' => '#1976d2',
                            'white' => '#ffffff',
                            'black' => '#212121'
                        );
                        foreach($colors as $name => $hex): 
                        ?>
                        <label class="color-segment <?php echo $name == 'green' ? 'active' : ''; ?>" title="<?php echo ucfirst($name); ?>">
                            <input type="radio" name="pcb_color" value="<?php echo $name; ?>" <?php echo $name == 'green' ? 'checked' : ''; ?>>
                            <span class="color-dot" style="background: <?php echo $hex; ?>;"></span>
                            <span class="color-name"><?php echo ucfirst($name); ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <!-- Surface Finish -->
                <div class="spec-row">
                    <label>Surface Finish</label>
                    <div class="segmented-control">
                        <label class="segment active">
                            <input type="radio" name="surface_finish" value="HASL" checked>
                            <span class="label-text">HASL(with lead)</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="surface_finish" value="LeadFree HASL">
                            <span class="label-text">LeadFree HASL</span>
                        </label>
                        <label class="segment">
                            <input type="radio" name="surface_finish" value="ENIG">
                            <span class="label-text">ENIG</span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Submit Section -->
            <section class="footer-form">
                <div class="contact-box">
                    <h3>Contact Information</h3>
                    <div class="form-grid-flex">
                        <div class="input-wrap">
                            <label>Full Name *</label>
                            <input type="text" name="full_name" placeholder="John Doe" required>
                        </div>
                        <div class="input-wrap">
                            <label>Email Address *</label>
                            <input type="email" name="email" placeholder="john@company.com" required>
                        </div>
                    </div>
                    <div class="form-grid-flex" style="margin-top: 20px;">
                        <div class="input-wrap">
                            <label>Phone Number *</label>
                            <input type="tel" name="phone" placeholder="+1 234 567 890" required>
                        </div>
                    </div>
                    <div class="form-grid-flex" style="margin-top: 20px;">
                        <div class="input-wrap">
                            <label>Shipping Address *</label>
                            <textarea name="address" rows="3" placeholder="Enter your full shipping address..." required style="width: 100%; padding: 0.85rem; border: 1.5px solid var(--mfg-border); border-radius: 6px;"></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" class="mfg-submit-btn">PROCEED TO QUOTE</button>
            </section>
        </form>

        <?php if ($message_sent): ?>
            <div class="success-overlay">
                <div class="msg-card">
                    <div class="success-icon">✅</div>
                    <h2>Project Saved Successfully!</h2>
                    <p>Our engineering team will review your Gerber files and specifications within 24 hours.</p>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="reload-btn" style="text-decoration:none; display:inline-block;">Send Another Request</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
</div>

<style>
/* Header Overrides for Visibility */
.main-header {
    background: rgba(255, 255, 255, 0.7) !important;
    backdrop-filter: blur(15px);
    -webkit-backdrop-filter: blur(15px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.1);
}
.main-header .nav-menu > .menu-item > a, 
.main-header .nav-menu > .nav-item > a,
.main-header .logo {
    color: #111111 !important;
    -webkit-text-fill-color: #111111 !important;
}

/* JLCPCB Style Simulation with Premium Touch */
:root {
    --mfg-blue: #007bff;
    --mfg-blue-hover: #0056b3;
    --mfg-bg: #f8f9fc;
    --mfg-card-bg: #ffffff;
    --mfg-border: #dae1e7;
    --mfg-text: #2d3436;
    --mfg-muted: #636e72;
    --mfg-orange: #ff6a00;
}

.mfg-page-wrapper { background: var(--mfg-bg); min-height: 100vh; padding: 10rem 1rem 4rem; }
.mfg-quote-page { color: var(--mfg-text); font-family: 'Segoe UI', Roboto, sans-serif; }
.mfg-container { max-width: 900px; margin: 0 auto; background: var(--mfg-card-bg); padding: 2rem 2.5rem; border-radius: 12px; box-shadow: 0 10px 40px rgba(0,0,0,0.05); }

.mfg-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #f1f3f5; padding-bottom: 1.5rem; margin-bottom: 2rem; }
.mfg-header h1 { font-size: 1.5rem; font-weight: 800; margin: 0; color: #1e272e; }
.mfg-header p { font-size: 0.9rem; color: var(--mfg-muted); margin-top: 0.25rem; }
.header-links a { font-size: 0.9rem; color: var(--mfg-blue); text-decoration: none; margin-left: 2rem; font-weight: 600; }

/* Upload section */
.upload-section { background: #f0f7ff; border: 2px dashed #b8daff; border-radius: 12px; padding: 4rem 2rem; text-align: center; margin-bottom: 4rem; transition: 0.3s; }
.upload-section:hover { border-color: var(--mfg-blue); background: #e6f2ff; }
.upload-btn { background: var(--mfg-blue); color: #fff; padding: 1.25rem 4rem; border-radius: 50px; font-weight: 700; cursor: pointer; display: inline-block; transition: 0.3s; box-shadow: 0 4px 15px rgba(0,123,255,0.3); }
.upload-btn:hover { background: var(--mfg-blue-hover); transform: translateY(-3px); }
.upload-note { margin-top: 1.5rem; color: var(--mfg-muted); font-size: 0.9rem; }
.upload-note a { color: var(--mfg-blue); font-weight: 600; }
.privacy-note { font-size: 0.8rem; color: #95afc0; margin-top: 1rem; }

/* Specs Grid */
.specs-grid { display: flex; flex-direction: column; gap: 2.5rem; }
.spec-row { display: grid; grid-template-columns: 220px 1fr; align-items: center; }
.spec-row > label { font-size: 0.95rem; font-weight: 700; color: #485460; }

/* Segmented Control */
.segmented-control { display: flex; gap: 0.5rem; flex-wrap: wrap; }
.segment { border: 1.5px solid var(--mfg-border); padding: 0.5rem 1.2rem; border-radius: 4px; cursor: pointer; transition: 0.2s; position: relative; font-weight: 600; font-size: 0.85rem; color: #57606f; }
.segment input { position: absolute; opacity: 0; }
.segment:hover { border-color: #bbcfdf; }
.segment.active { border-color: var(--mfg-blue); color: var(--mfg-blue); background: #f0f7ff; box-shadow: inset 0 0 0 1px var(--mfg-blue); }
.segment.active::after { content: '✓'; position: absolute; right: 0; bottom: 0; font-size: 8px; color: #fff; background: var(--mfg-blue); width: 14px; height: 14px; clip-path: polygon(100% 0, 0% 100%, 100% 100%); line-height: 18px; text-align: right; padding-right: 2px; }

.segmented-control.mini .segment { padding: 0.5rem 1.2rem; min-width: 60px; text-align: center; }

/* Dimensions Row */
.input-group-row { display: flex; align-items: center; gap: 1rem; }
.mini-input { width: 100px; padding: 0.75rem; border: 1.5px solid var(--mfg-border); border-radius: 6px; font-weight: 600; }
.multiplier { font-weight: 700; color: #ccc; }
.unit-select { padding: 0.75rem 1rem; border: 1.5px solid var(--mfg-border); border-radius: 6px; background: #f8f9fa; font-weight: 600; }

/* Color Control */
.color-control { display: flex; gap: 1rem; flex-wrap: wrap; }
.color-segment { border: 1.5px solid var(--mfg-border); padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; display: flex; align-items: center; gap: 0.75rem; transition: 0.2s; min-width: 100px; }
.color-segment.active { border-color: var(--mfg-blue); background: #f0f7ff; }
.color-dot { width: 18px; height: 18px; border-radius: 3px; border: 1px solid rgba(0,0,0,0.1); }
.color-name { font-size: 0.85rem; font-weight: 600; }
.color-segment input { display: none; }

/* Footer */
.footer-form { margin-top: 5rem; padding-top: 3rem; border-top: 2px solid #efefef; }
.contact-box { background: #fdfdfd; padding: 2.5rem; border-radius: 12px; border: 1px solid var(--mfg-border); margin-bottom: 2.5rem; }
.contact-box h3 { margin: 0 0 1.5rem 0; font-size: 1.2rem; color: #1e272e; }
.form-grid-flex { display: flex; gap: 2rem; }
.input-wrap { flex: 1; display: flex; flex-direction: column; gap: 0.5rem; }
.input-wrap label { font-size: 0.85rem; font-weight: 700; color: var(--mfg-muted); }
.input-wrap input { padding: 0.85rem; border: 1.5px solid var(--mfg-border); border-radius: 6px; }

.mfg-submit-btn { background: var(--mfg-orange); color: #fff; border: none; padding: 0.85rem 3rem; border-radius: 6px; font-size: 1.1rem; font-weight: 700; cursor: pointer; display: block; margin: 0 auto; transition: 0.3s; letter-spacing: 0.03em; box-shadow: 0 4px 10px rgba(255, 106, 0, 0.2); }
.mfg-submit-btn:hover { background: #e65f00; transform: translateY(-2px); box-shadow: 0 6px 20px rgba(255, 106, 0, 0.3); }

/* Success Overlay */
.success-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(5px); display: flex; align-items: center; justify-content: center; z-index: 2000; padding: 20px; }
.msg-card { background: #fff; padding: 4rem; border-radius: 20px; text-align: center; max-width: 500px; box-shadow: 0 30px 60px rgba(0,0,0,0.3); }
.success-icon { font-size: 4rem; margin-bottom: 1.5rem; }
.msg-card h2 { font-size: 1.75rem; margin-bottom: 1rem; color: #1e272e; }
.msg-card p { color: var(--mfg-muted); line-height: 1.6; margin-bottom: 2rem; }
.reload-btn { background: var(--mfg-blue); color: #fff; border: none; padding: 1rem 2.5rem; border-radius: 50px; font-weight: 700; cursor: pointer; transition: 0.3s; }
.reload-btn:hover { background: var(--mfg-blue-hover); }

@media (max-width: 768px) {
    .spec-row { grid-template-columns: 1fr; gap: 1rem; }
    .form-grid-flex { flex-direction: column; }
    .mfg-header { flex-direction: column; gap: 1rem; }
    .header-links a { margin: 0 1rem 0 0; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle segment selection
    const segments = document.querySelectorAll('.segment, .color-segment');
    segments.forEach(seg => {
        seg.addEventListener('click', function() {
            const input = this.querySelector('input');
            if (input) {
                const name = input.getAttribute('name');
                document.querySelectorAll(`input[name="${name}"]`).forEach(otherInput => {
                    otherInput.parentElement.classList.remove('active');
                });
                this.classList.add('active');
                input.checked = true;
            }
        });
    });

    // Handle file upload feedback
    const fileInput = document.getElementById('gerber_upload');
    const uploadLabel = document.querySelector('.upload-btn');
    if (fileInput && uploadLabel) {
        fileInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const fileName = this.files[0].name;
                uploadLabel.innerHTML = '<span class="icon">✅</span> ' + fileName;
                uploadLabel.style.background = "#2ecc71"; // Change to green on success
                uploadLabel.style.boxShadow = "0 4px 15px rgba(46, 204, 113, 0.3)";
            }
        });
    }
});
</script>

<?php get_footer(); ?>
