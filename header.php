<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header class="main-header">
    <div class="container header-content">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            <strong>SYNOPSYS</strong><span style="font-weight: 300;">®</span>
        </a>
        <nav>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="#">Why Synopsys <span style="font-size: 0.6rem;">▼</span></a>
                    <div class="mega-menu">
                        <div>
                            <h4>Our Company</h4>
                            <ul>
                                <li><a href="#">Careers</a></li>
                                <li><a href="#">Ecosystem Partners</a></li>
                                <li><a href="#">Global Offices</a></li>
                                <li><a href="#">Investors</a></li>
                                <li><a href="#">Leadership</a></li>
                            </ul>
                        </div>
                        <div class="featured-content">
                            <h4>Why Synopsys?</h4>
                            <p style="font-size: 0.9rem; color: var(--text-muted); margin-bottom: 1rem;">Our Technology, Your Innovation™. Trusted industry leader.</p>
                            <a href="#" style="color: var(--secondary); font-weight: 600;">Learn more &rarr;</a>
                        </div>
                    </div>
                </li>
                <li class="nav-item"><a href="#">Solutions</a></li>
                <li class="nav-item"><a href="#">Products</a></li>
                <li class="nav-item"><a href="#">Resources</a></li>
            </ul>
        </nav>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="#" style="font-size: 1.2rem;">🔍</a>
            <a href="#" class="contact-btn">Contact Sales</a>
        </div>
    </div>
</header>
