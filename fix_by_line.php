<?php
$file = 'functions.php';
$lines = file($file);

$replacements = [
    1838 => "        \$cod_settings['title']       = 'Pay Later — We Will Contact You';\n",
    1839 => "        \$cod_settings['description'] = 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे। (We will contact you shortly for payment details via Bank Transfer / UPI / Cash.)';\n",
    1849 => "        return 'Pay Later — We Will Contact You';\n",
    1857 => "        return 'हम आपसे जल्द ही भुगतान के लिए संपर्क करेंगे। <br><small>(We will contact you for payment via Bank Transfer / UPI / Cash.)</small>';\n",
    1868 => "        \$order->update_status('on-hold', 'Awaiting manual payment confirmation — customer to be contacted.');\n",
    1875 => "    return '🎉 <strong>Order placed successfully!</strong> Hum aapse jald se jald sampark karenge payment ke liye.<br><em>(शॉपिंग करने के लिए धन्यवाद! हम आपसे जल्द से जल्द संपर्क करेंगे।)</em>';\n",
    1918 => "                <div class=\"auth-icon\" style=\"font-size:3rem; text-align:center; margin-bottom:1rem;\">🔑</div>\n",
    1939 => "                <div class=\"auth-avatar\">👤</div>\n",
    1943 => "                    <a href=\"<?php echo esc_url(wc_get_checkout_url()); ?>\" class=\"auth-btn auth-btn-primary\">🛒 Checkout</a>\n",
    1944 => "                    <a href=\"<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>\" class=\"auth-btn auth-btn-outline\">📦 My Orders</a>\n",
    1945 => "                    <a href=\"<?php echo esc_url(wp_logout_url(home_url())); ?>\" class=\"auth-btn auth-btn-danger\">🚪 Logout</a>\n",
    1968 => "                🔑 Login\n",
    1971 => "                ✨ Register\n",
    1978 => "                <div class=\"auth-icon\">🔑</div>\n",
    1988 => "                    <label for=\"auth-username\">📧 Email or Username</label>\n",
    1992 => "                    <label for=\"auth-password\">🔒 Password</label>\n",
    1995 => "                        <button type=\"button\" class=\"toggle-pwd\" data-target=\"auth-password\">👁️</button>\n",
    2006 => "                    <span class=\"btn-text\">Login →</span>\n",
    2008 => "                <p class=\"auth-switch\">Don't have an account? <a href=\"#\" class=\"switch-tab\" data-tab=\"register\">Register ✨</a></p>\n",
    2015 => "                <div class=\"auth-icon\">✨</div>\n",
    2028 => "                        <label for=\"reg-firstname\">👤 First Name *</label>\n",
    2032 => "                        <label for=\"reg-lastname\">👤 Last Name</label>\n",
    2037 => "                    <label for=\"reg-email\">📧 Email Address *</label>\n",
    2041 => "                    <label for=\"reg-password\">🔒 Password *</label>\n",
    2044 => "                        <button type=\"button\" class=\"toggle-pwd\" data-target=\"reg-password\">👁️</button>\n",
    2049 => "                    <label for=\"reg-confirm-password\">🔒 Confirm Password *</label>\n",
    2052 => "                        <button type=\"button\" class=\"toggle-pwd\" data-target=\"reg-confirm-password\">👁️</button>\n",
    2057 => "                    <span class=\"btn-text\">Create Account →</span>\n",
    2059 => "                <p class=\"auth-switch\">Already have an account? <a href=\"#\" class=\"switch-tab\" data-tab=\"login\">Login 🔑</a></p>\n",
    2065 => "            <p>🔒 Your information is completely safe. We never share it.</p>\n",
    2089 => "                    this.textContent = '🙈';\n",
    2092 => "                    this.textContent = '👁️';\n",
    2110 => "                    showMsg(regForm, 'error', '❌ Passwords do not match!');\n",
    2127 => "                        showMsg(regForm, 'success', '✅ ' + res.data.message);\n",
    2132 => "                        showMsg(regForm, 'error', '❌ ' + res.data.message);\n",
    2133 => "                        btn.querySelector('.btn-text').textContent = 'Create Account →';\n",
    2138 => "                    showMsg(regForm, 'error', '❌ Something went wrong. Please try again.');\n",
    2139 => "                    btn.querySelector('.btn-text').textContent = 'Create Account →';\n",
    2167 => "                        showMsg(loginForm, 'success', '✅ ' + res.data.message);\n",
    2172 => "                        showMsg(loginForm, 'error', '❌ ' + res.data.message);\n",
    2173 => "                        btn.querySelector('.btn-text').textContent = 'Login →';\n",
    2179 => "                    showMsg(loginForm, 'error', '❌ Something went wrong. Please try again.');\n",
    2180 => "                    btn.querySelector('.btn-text').textContent = 'Login →';\n",
    2370 => "            <button onclick=\"document.getElementById('mytheme-login-notice').style.display='none'\" style=\"position:absolute;top:8px;right:12px;background:none;border:none;color:rgba(255,255,255,0.5);font-size:18px;cursor:pointer;\">×</button>\n",
    2371 => "            <p style=\"margin:0 0 0.5rem;font-weight:700;font-size:1rem;\">🔍 Please Login!</p>\n",
    2373 => "            <a href=\"<?php echo esc_url(\$account_page); ?>\" style=\"display:block;text-align:center;background:linear-gradient(135deg,#7c3aed,#a855f7);color:#fff;padding:0.6rem 1rem;border-radius:8px;font-weight:600;font-size:0.9rem;text-decoration:none;\">Login / Register →</a>\n",
];

foreach ($replacements as $num => $content) {
    if (isset($lines[$num - 1])) {
        $lines[$num - 1] = $content;
    }
}

file_put_contents($file, implode('', $lines));
echo "Fixed by line numbers\n";
?>
