<?php 
/**
 * Template Name: Job Application Page
 */
get_header(); ?>

<main class="page-job-application" style="background: #09090b; min-height: 100vh; padding: 120px 0;">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto;">
            <div style="text-align: center; margin-bottom: 50px;">
                <h1 style="font-size: 3.5rem; color: #fff; margin-bottom: 10px; letter-spacing: -2px;">Send Your <span style="color: #6366f1;">Application</span></h1>
                <p style="color: rgba(255,255,255,0.5); font-size: 1.1rem;">
                    <?php 
                    $applying_for = isset($_GET['job']) ? esc_html($_GET['job']) : 'a position';
                    echo 'Applying for: <strong style="color: #6366f1;">' . $applying_for . '</strong>';
                    ?>
                </p>
            </div>

            <div class="glass-form-container" style="background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.1); padding: 50px; border-radius: 30px; backdrop-filter: blur(20px);">
                <form id="job-application-form" enctype="multipart/form-data">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Full Name *</label>
                            <input type="text" name="name" required style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;">
                        </div>
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Email Address *</label>
                            <input type="email" name="email" required style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Phone Number</label>
                            <input type="tel" name="phone" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;">
                        </div>
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Upload Resume / CV *</label>
                            <input type="file" name="resume" required accept=".pdf,.doc,.docx" style="width: 100%; background: rgba(99, 102, 241, 0.05); border: 1px dashed rgba(255,255,255,0.2); padding: 12px; border-radius: 12px; color: #fff !important;">
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Experience (Years)</label>
                            <input type="number" name="experience" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;">
                        </div>
                        <div>
                            <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">LinkedIn Profile (URL)</label>
                            <input type="url" name="linkedin" placeholder="https://linkedin.com/in/yourprofile" style="width: 100%; background: rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;">
                        </div>
                    </div>

                    <div style="margin-bottom: 40px;">
                        <label style="display: block; color: rgba(255,255,255,0.7); margin-bottom: 10px; font-weight: 600;">Tell us about yourself *</label>
                        <textarea name="about" rows="5" required style="width: 100%; background: #000 !important; border: 1px solid rgba(255,255,255,0.1); padding: 15px; border-radius: 12px; color: #fff !important;"></textarea>
                    </div>

                    <button type="submit" style="width: 100%; background: #6366f1; color: #fff; padding: 20px; border-radius: 15px; font-size: 1.1rem; font-weight: 800; border: none; cursor: pointer; transition: 0.3s ease; box-shadow: 0 10px 30px rgba(99, 102, 241, 0.4);">Submit Application</button>
                </form>
            </div>
            <div id="application-response" style="margin-top: 20px; display: none; padding: 20px; border-radius: 12px; text-align: center; font-weight: 700;"></div>
        </div>
    </div>
</main>

<script>
document.getElementById('job-application-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const btn = form.querySelector('button');
    const responseDiv = document.getElementById('application-response');
    const formData = new FormData(form);
    
    formData.append('action', 'submit_job_application');
    formData.append('job', '<?php echo isset($_GET['job']) ? esc_js($_GET['job']) : 'General Application'; ?>');

    btn.disabled = true;
    btn.innerText = 'Sending...';

    fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            responseDiv.innerText = '✅ Success! Your application has been sent. We will contact you soon.';
            responseDiv.style.background = 'rgba(34, 197, 94, 0.1)';
            responseDiv.style.color = '#22c55e';
            responseDiv.style.display = 'block';
            form.style.display = 'none';
        } else {
            alert('Something went wrong. Please try again.');
            btn.disabled = false;
            btn.innerText = 'Submit Application';
        }
    })
    .catch(err => {
        console.error(err);
        btn.disabled = false;
        btn.innerText = 'Submit Application';
    });
});
</script>

<?php get_footer(); ?>
