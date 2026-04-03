<?php
/**
 * Custom Thank You / Order Received Page
 * Premium UI with animations, order cards, and next steps.
 */
defined('ABSPATH') || exit;
?>

<?php get_header(); ?>

<!-- ─── Styles ────────────────────────────────────────────── -->
<style>
/* ── Reset & Base ── */
.thankyou-page {
    background: #0a0a0f;
    min-height: 100vh;
    padding: 120px 0 80px;
    font-family: 'Inter', 'Poppins', sans-serif;
    color: #f1f5f9;
    overflow: hidden;
    position: relative;
}

/* ── Confetti Canvas ── */
#confetti-canvas {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    pointer-events: none;
    z-index: 999;
}

/* ── Container ── */
.ty-container {
    max-width: 860px;
    margin: 0 auto;
    padding: 0 24px;
    position: relative;
    z-index: 2;
}

/* ── Success Hero ── */
.ty-hero {
    text-align: center;
    margin-bottom: 56px;
}

/* Animated Checkmark Circle */
.ty-check-wrap {
    width: 100px;
    height: 100px;
    margin: 0 auto 28px;
    position: relative;
}
.ty-check-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #22c55e, #16a34a);
    display: flex;
    align-items: center;
    justify-content: center;
    animation: popIn 0.6s cubic-bezier(0.175,0.885,0.32,1.275) both;
    box-shadow: 0 0 0 0 rgba(34,197,94,0.5);
    animation: popIn 0.6s cubic-bezier(0.175,0.885,0.32,1.275) both, pulse 2s 0.7s ease-in-out infinite;
}
.ty-check-circle svg {
    width: 50px;
    height: 50px;
    stroke: #fff;
    stroke-width: 3;
    stroke-dasharray: 80;
    stroke-dashoffset: 80;
    animation: drawCheck 0.5s 0.4s ease forwards;
    fill: none;
}
@keyframes popIn {
    0%   { transform: scale(0); opacity: 0; }
    70%  { transform: scale(1.1); }
    100% { transform: scale(1);  opacity: 1; }
}
@keyframes pulse {
    0%, 100% { box-shadow: 0 0 0 0   rgba(34,197,94,0.45); }
    50%       { box-shadow: 0 0 0 20px rgba(34,197,94,0); }
}
@keyframes drawCheck {
    to { stroke-dashoffset: 0; }
}

/* Hero Text */
.ty-hero-badge {
    display: inline-block;
    background: rgba(34,197,94,0.12);
    color: #4ade80;
    border: 1px solid rgba(34,197,94,0.3);
    padding: 6px 18px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 600;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 16px;
    animation: fadeUp 0.5s 0.3s both;
}
.ty-hero h1 {
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 800;
    letter-spacing: -0.03em;
    margin: 0 0 14px;
    background: linear-gradient(135deg, #ffffff 0%, #a0aec0 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    animation: fadeUp 0.5s 0.4s both;
}
.ty-hero-msg {
    font-size: 1.1rem;
    color: #94a3b8;
    line-height: 1.7;
    max-width: 520px;
    margin: 0 auto;
    animation: fadeUp 0.5s 0.5s both;
}
.ty-hero-msg strong {
    color: #f1f5f9;
}

@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ── Order Meta Strip ── */
.ty-meta-strip {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 12px;
    margin-bottom: 32px;
    animation: fadeUp 0.5s 0.55s both;
}
@media(min-width: 600px) {
    .ty-meta-strip { grid-template-columns: repeat(4, 1fr); }
}
.ty-meta-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 12px;
    padding: 18px 16px;
    text-align: center;
    backdrop-filter: blur(10px);
    transition: border-color 0.2s;
}
.ty-meta-card:hover {
    border-color: rgba(34,197,94,0.3);
}
.ty-meta-label {
    font-size: 0.72rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    margin-bottom: 6px;
}
.ty-meta-value {
    font-size: 1.05rem;
    font-weight: 700;
    color: #f1f5f9;
}
.ty-meta-value.green { color: #4ade80; }

/* ── Next Steps ── */
.ty-steps {
    display: grid;
    grid-template-columns: 1fr;
    gap: 12px;
    margin-bottom: 32px;
    animation: fadeUp 0.5s 0.65s both;
}
@media(min-width: 640px) {
    .ty-steps { grid-template-columns: repeat(3, 1fr); }
}
.ty-step {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    padding: 22px 18px;
    display: flex;
    align-items: flex-start;
    gap: 14px;
    transition: all 0.25s;
}
.ty-step:hover {
    background: rgba(34,197,94,0.06);
    border-color: rgba(34,197,94,0.25);
    transform: translateY(-3px);
}
.ty-step-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    background: rgba(34,197,94,0.12);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    flex-shrink: 0;
}
.ty-step-title {
    font-weight: 700;
    font-size: 0.9rem;
    color: #f1f5f9;
    margin-bottom: 4px;
}
.ty-step-desc {
    font-size: 0.8rem;
    color: #64748b;
    line-height: 1.5;
}

/* ── Order Details Card ── */
.ty-order-card {
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.08);
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 24px;
    animation: fadeUp 0.5s 0.7s both;
}
.ty-order-card-title {
    padding: 18px 22px;
    border-bottom: 1px solid rgba(255,255,255,0.07);
    font-weight: 700;
    font-size: 1rem;
    color: #f1f5f9;
    display: flex;
    align-items: center;
    gap: 10px;
}
.ty-order-card-title span { font-size: 1.2rem; }

/* Order Items */
.ty-items { padding: 8px 0; }
.ty-item-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 22px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: background 0.2s;
}
.ty-item-row:last-child { border-bottom: none; }
.ty-item-row:hover { background: rgba(255,255,255,0.03); }
.ty-item-name {
    font-size: 0.95rem;
    color: #cbd5e1;
    font-weight: 500;
}
.ty-item-qty {
    font-size: 0.78rem;
    color: #64748b;
    margin-top: 3px;
}
.ty-item-price {
    font-weight: 700;
    color: #f1f5f9;
    font-size: 0.95rem;
    white-space: nowrap;
}

/* Totals */
.ty-totals { padding: 0; }
.ty-total-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 22px;
    font-size: 0.9rem;
    color: #94a3b8;
    border-bottom: 1px solid rgba(255,255,255,0.05);
}
.ty-total-row:last-child {
    border-bottom: none;
    font-size: 1.05rem;
    font-weight: 800;
    color: #4ade80;
    padding: 16px 22px;
    background: rgba(34,197,94,0.06);
}
.ty-total-row:last-child span:first-child { color: #f1f5f9; }

/* ── Address Grid ── */
.ty-addr-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 16px;
    margin-bottom: 32px;
    animation: fadeUp 0.5s 0.75s both;
}
@media(min-width: 600px) {
    .ty-addr-grid { grid-template-columns: 1fr 1fr; }
}
.ty-addr-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(255,255,255,0.07);
    border-radius: 14px;
    padding: 20px;
}
.ty-addr-label {
    font-size: 0.78rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.07em;
    font-weight: 600;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.ty-addr-text {
    font-size: 0.9rem;
    color: #cbd5e1;
    line-height: 1.7;
}
.ty-addr-text a { color: #94a3b8; }

/* ── CTA Buttons ── */
.ty-cta-row {
    display: flex;
    gap: 14px;
    flex-wrap: wrap;
    justify-content: center;
    animation: fadeUp 0.5s 0.8s both;
    margin-bottom: 48px;
}
.ty-btn {
    padding: 13px 30px;
    border-radius: 10px;
    font-weight: 700;
    font-size: 0.95rem;
    text-decoration: none;
    transition: all 0.25s;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    border: none;
}
.ty-btn-primary {
    background: #22c55e;
    color: #fff;
    box-shadow: 0 4px 20px rgba(34,197,94,0.35);
}
.ty-btn-primary:hover {
    background: #16a34a;
    transform: translateY(-2px);
    box-shadow: 0 8px 28px rgba(34,197,94,0.5);
    color: #fff;
    text-decoration: none;
}
.ty-btn-secondary {
    background: rgba(255,255,255,0.07);
    color: #f1f5f9;
    border: 1px solid rgba(255,255,255,0.12);
}
.ty-btn-secondary:hover {
    background: rgba(255,255,255,0.12);
    transform: translateY(-2px);
    color: #f1f5f9;
    text-decoration: none;
}

/* ── Glow BG Effect ── */
.ty-glow {
    position: fixed;
    top: -200px;
    left: 50%;
    transform: translateX(-50%);
    width: 700px;
    height: 700px;
    background: radial-gradient(circle, rgba(34,197,94,0.08) 0%, transparent 70%);
    pointer-events: none;
    z-index: 0;
}
</style>

<canvas id="confetti-canvas"></canvas>
<div class="ty-glow"></div>

<div class="thankyou-page">
  <div class="ty-container">

    <?php if ($order = wc_get_order(get_query_var('order-received'))) : ?>

      <!-- ── Hero ─────────────────────────────────── -->
      <div class="ty-hero">
        <div class="ty-check-wrap">
          <div class="ty-check-circle">
            <svg viewBox="0 0 52 52">
              <polyline points="14,27 22,35 38,17"/>
            </svg>
          </div>
        </div>
        <div class="ty-hero-badge">✅ Order Confirmed</div>
        <h1>Order Placed Successfully!</h1>
        <div class="ty-hero-msg">
          🎉 <strong>Thank you, <?php echo esc_html($order->get_billing_first_name()); ?>!</strong><br>
          Hum aapse jald se jald sampark karenge payment ke liye.<br>
          <small style="color:#64748b;">(शॉपिंग करने के लिए धन्यवाद! हम आपसे जल्द से जल्द संपर्क करेंगे।)</small>
        </div>
      </div>

      <!-- ── Order Meta Strip ──────────────────────── -->
      <div class="ty-meta-strip">
        <div class="ty-meta-card">
          <div class="ty-meta-label">Order Number</div>
          <div class="ty-meta-value">#<?php echo $order->get_order_number(); ?></div>
        </div>
        <div class="ty-meta-card">
          <div class="ty-meta-label">Date</div>
          <div class="ty-meta-value"><?php echo wc_format_datetime($order->get_date_created()); ?></div>
        </div>
        <div class="ty-meta-card">
          <div class="ty-meta-label">Total</div>
          <div class="ty-meta-value green"><?php echo $order->get_formatted_order_total(); ?></div>
        </div>
        <div class="ty-meta-card">
          <div class="ty-meta-label">Status</div>
          <div class="ty-meta-value" style="color:#fbbf24;">⏳ On Hold</div>
        </div>
      </div>

      <!-- ── Next Steps ────────────────────────────── -->
      <div class="ty-steps">
        <div class="ty-step">
          <div class="ty-step-icon">📧</div>
          <div>
            <div class="ty-step-title">Confirmation Email</div>
            <div class="ty-step-desc">Order details sent to <strong style="color:#94a3b8;"><?php echo esc_html($order->get_billing_email()); ?></strong></div>
          </div>
        </div>
        <div class="ty-step">
          <div class="ty-step-icon">📞</div>
          <div>
            <div class="ty-step-title">We'll Call You</div>
            <div class="ty-step-desc">Our team will contact you on <strong style="color:#94a3b8;"><?php echo esc_html($order->get_billing_phone()); ?></strong> for payment.</div>
          </div>
        </div>
        <div class="ty-step">
          <div class="ty-step-icon">🚚</div>
          <div>
            <div class="ty-step-title">Shipment</div>
            <div class="ty-step-desc">After payment confirmation, your order will be dispatched.</div>
          </div>
        </div>
      </div>

      <!-- ── Order Items Card ──────────────────────── -->
      <div class="ty-order-card">
        <div class="ty-order-card-title"><span>🛍️</span> Order Details</div>
        <div class="ty-items">
          <?php foreach ($order->get_items() as $item_id => $item) :
              $product = $item->get_product();
              $subtotal = $order->get_formatted_line_subtotal($item);
          ?>
          <div class="ty-item-row">
            <div>
              <div class="ty-item-name"><?php echo esc_html($item->get_name()); ?></div>
              <div class="ty-item-qty">Qty: <?php echo $item->get_quantity(); ?></div>
            </div>
            <div class="ty-item-price"><?php echo $subtotal; ?></div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="ty-totals">
          <div class="ty-total-row">
            <span>Subtotal</span>
            <span><?php echo $order->get_subtotal_to_display(); ?></span>
          </div>
          <?php if ($order->get_shipping_total() > 0) : ?>
          <div class="ty-total-row">
            <span>Shipping</span>
            <span><?php echo wc_price($order->get_shipping_total()); ?></span>
          </div>
          <?php else : ?>
          <div class="ty-total-row">
            <span>Shipping</span>
            <span style="color:#4ade80;">Free</span>
          </div>
          <?php endif; ?>
          <?php if ($order->get_discount_total() > 0) : ?>
          <div class="ty-total-row">
            <span>Discount</span>
            <span style="color:#f87171;">-<?php echo wc_price($order->get_discount_total()); ?></span>
          </div>
          <?php endif; ?>
          <div class="ty-total-row">
            <span>Total Payable</span>
            <span><?php echo $order->get_formatted_order_total(); ?></span>
          </div>
        </div>
      </div>

      <!-- ── Addresses ─────────────────────────────── -->
      <div class="ty-addr-grid">
        <div class="ty-addr-card">
          <div class="ty-addr-label">📦 Shipping Address</div>
          <div class="ty-addr-text">
            <?php echo wp_kses_post($order->get_formatted_shipping_address()); ?>
            <?php if ($order->get_shipping_phone()) : ?>
              <br>📞 <?php echo esc_html($order->get_shipping_phone()); ?>
            <?php endif; ?>
          </div>
        </div>
        <div class="ty-addr-card">
          <div class="ty-addr-label">🧾 Billing Address</div>
          <div class="ty-addr-text">
            <?php echo wp_kses_post($order->get_formatted_billing_address()); ?>
            <br>📞 <?php echo esc_html($order->get_billing_phone()); ?>
            <br>✉️ <a href="mailto:<?php echo esc_attr($order->get_billing_email()); ?>"><?php echo esc_html($order->get_billing_email()); ?></a>
          </div>
        </div>
      </div>

      <!-- ── CTA Buttons ───────────────────────────── -->
      <div class="ty-cta-row">
        <a href="<?php echo esc_url(wc_get_page_permalink('shop')); ?>" class="ty-btn ty-btn-primary">
          🛒 Continue Shopping
        </a>
        <a href="<?php echo esc_url(wc_get_account_endpoint_url('orders')); ?>" class="ty-btn ty-btn-secondary">
          📋 View My Orders
        </a>
      </div>

    <?php else : ?>
      <!-- fallback if order not found -->
      <div class="ty-hero">
        <h1>Thank you for your order!</h1>
        <p class="ty-hero-msg">Hum aapse jald sampark karenge.</p>
      </div>
    <?php endif; ?>

  </div><!-- .ty-container -->
</div><!-- .thankyou-page -->

<!-- ─── Confetti Script ─────────────────────────────── -->
<script>
(function() {
  var canvas = document.getElementById('confetti-canvas');
  var ctx = canvas.getContext('2d');
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  var pieces = [];
  var colors = ['#22c55e','#4ade80','#86efac','#fbbf24','#f9a8d4','#a78bfa','#60a5fa'];
  var total = 120;

  for (var i = 0; i < total; i++) {
    pieces.push({
      x: Math.random() * canvas.width,
      y: Math.random() * canvas.height - canvas.height,
      w: Math.random() * 10 + 5,
      h: Math.random() * 6 + 3,
      color: colors[Math.floor(Math.random() * colors.length)],
      rotation: Math.random() * 360,
      speed: Math.random() * 3 + 1.5,
      rotSpeed: Math.random() * 4 - 2,
      opacity: Math.random() * 0.7 + 0.3
    });
  }

  var startTime = Date.now();
  var duration = 4000; // 4 seconds of confetti

  function draw() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    var elapsed = Date.now() - startTime;
    if (elapsed > duration) { canvas.style.display = 'none'; return; }

    pieces.forEach(function(p) {
      ctx.save();
      ctx.globalAlpha = p.opacity * (1 - elapsed / duration);
      ctx.translate(p.x + p.w / 2, p.y + p.h / 2);
      ctx.rotate(p.rotation * Math.PI / 180);
      ctx.fillStyle = p.color;
      ctx.fillRect(-p.w / 2, -p.h / 2, p.w, p.h);
      ctx.restore();

      p.y += p.speed;
      p.rotation += p.rotSpeed;
    });

    requestAnimationFrame(draw);
  }

  // Start after a short delay so page is ready
  setTimeout(draw, 300);
})();
</script>

<?php get_footer(); ?>
