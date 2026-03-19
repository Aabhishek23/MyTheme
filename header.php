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
            <?php bloginfo('name'); ?>
        </a>
        <nav>
            <ul class="nav-menu">
                <li><a href="#hero">Home</a></li>
                <li><a href="#posts">Blog</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>
</header>
