<footer style="background: #000; padding: 6rem 0 3rem; border-top: 1px solid var(--glass-border);">
    <div class="container">
        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 4rem; margin-bottom: 4rem; text-align: left;">
            <?php 
            $footer_titles = array(
                'footer_col1_title' => 'Company',
                'footer_col2_title' => 'Resources',
                'footer_col3_title' => 'Trending',
                'footer_col4_title' => 'Learn',
            );
            
            for($i = 1; $i <= 4; $i++) : ?>
            <div>
                <h4 style="margin-bottom: 1.5rem; font-size: 1.1rem; color: #fff;"><?php echo esc_html(get_theme_mod("footer_col{$i}_title", $footer_titles["footer_col{$i}_title"])); ?></h4>
                <?php
                if (has_nav_menu("footer-col-{$i}")) {
                    wp_nav_menu(array(
                        'theme_location' => "footer-col-{$i}",
                        'container'      => false,
                        'menu_class'     => 'footer-menu',
                        'fallback_cb'    => false,
                        'items_wrap'     => '<ul id="%1$s" class="%2$s" style="list-style: none; color: var(--text-muted); font-size: 0.9rem; padding: 0;">%3$s</ul>',
                    ));
                } else {
                    // Default static content if no menu is assigned
                    ?>
                    <ul class="footer-menu" style="list-style: none; color: var(--text-muted); font-size: 0.9rem; padding: 0;">
                        <?php if($i == 1) : ?>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/about-us/'); ?>">About Us</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/contact-us/'); ?>">Contact Us</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/pcb-manufacturing-capabilities/'); ?>">PCB Manufacturing Capabilities</a></li>
                            <!-- <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/quality-certifications/'); ?>">Quality & Certifications</a></li> -->
                        <?php elseif($i == 2) : ?>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/request-a-quote/'); ?>">Get a Quote</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/track-your-order/'); ?>">Track Your Order</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/design-guidelines/'); ?>">Design Guidelines</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/component-library/'); ?>">Component Library</a></li>
                        <?php elseif($i == 3) : ?>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/hdi-pcb-design/'); ?>">HDI PCB Design</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/high-frequency-pcbs/'); ?>">High-Frequency PCBs</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/flex-rigid-flex-pcbs/'); ?>">Flex & Rigid-Flex PCBs</a></li>
                        <?php elseif($i == 4) : ?>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/what-is-an-hdi-pcb/'); ?>">What is an HDI PCB?</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/how-to-export-gerber-files/'); ?>">How to Export Gerber Files?</a></li>
                            <li style="margin-bottom: 0.75rem;"><a href="<?php echo home_url('/understanding-impedance-control/'); ?>">Understanding Impedance Control</a></li>
                        <?php endif; ?>
                    </ul>
                    <?php
                }
                ?>
            </div>
            <?php endfor; ?>
        </div>
        <div style="padding-top: 2rem; border-top: 1px solid var(--glass-border); display: flex; justify-content: space-between; align-items: center; color: var(--text-muted); font-size: 0.85rem;">
            <p><?php echo wp_kses_post(get_theme_mod('footer_copyright_text', sprintf('&copy; 2025 %s, Inc. All Rights Reserved.', get_bloginfo('name')))); ?></p>
            <div style="background: var(--surface); padding: 0.5rem 1rem; border-radius: 4px; border: 1px solid var(--glass-border);">
                🌐 English ▼
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
