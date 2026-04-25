<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 */

get_header(); ?>

<main class="boat-shop-page boat-tabbed-section">
    <div class="container">
        <header class="boat-section-header" style="margin-top: 5rem;">
            <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>
                <h1 class="boat-section-title woocommerce-products-header__title page-title">
                    <?php 
                    $title = woocommerce_page_title(false);
                    $title_parts = explode(' ', $title);
                    $last_word = array_pop($title_parts);
                    echo implode(' ', $title_parts) . ' <span class="underlined">' . esc_html($last_word) . '</span>';
                    ?>
                </h1>
            <?php endif; ?>
            
            <div class="boat-header-actions">
                <?php do_action( 'woocommerce_before_shop_loop' ); ?>
            </div>
        </header>

        <div class="boat-shop-content">
            <?php if ( woocommerce_product_loop() ) : ?>
                
                <div class="boat-product-grid products columns-<?php echo esc_attr( wc_get_loop_prop( 'columns' ) ); ?>">
                    <?php
                    if ( wc_get_loop_prop( 'total' ) ) {
                        while ( have_posts() ) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action( 'woocommerce_shop_loop' );

                            global $product;
                            $average_rating = $product->get_average_rating();
                            $sale_price = $product->get_sale_price();
                            $regular_price = $product->get_regular_price();
                            $discount = 0;
                            if ($regular_price > 0 && $sale_price > 0) {
                                $discount = round((($regular_price - $sale_price) / $regular_price) * 100);
                            }
                            
                            $feature_text = get_post_meta(get_the_ID(), '_boat_feature_text', true);
                            if (!$feature_text) $feature_text = 'New Launch';
                            
                            $badge_text = get_post_meta(get_the_ID(), '_boat_badge_text', true);
                            $extra_badge = get_post_meta(get_the_ID(), '_boat_extra_badge', true);
                            ?>
                            <div class="boat-product-card <?php echo esc_attr( implode( ' ', wc_get_product_class( '', $product ) ) ); ?>">
                                <div class="boat-card-image-wrapper">
                                    <div class="boat-badges-top">
                                        <?php if ($extra_badge) : ?>
                                            <span class="boat-badge boat-badge-extra">🏷️ <?php echo esc_html($extra_badge); ?></span>
                                        <?php endif; ?>
                                        <?php if ($badge_text) : ?>
                                            <span class="boat-badge boat-badge-main">🚀 <?php echo esc_html($badge_text); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium', array('class' => 'boat-card-image')); ?>
                                    </a>
                                    
                                    <div class="boat-feature-strip">
                                        <span class="boat-feature-text"><?php echo esc_html($feature_text); ?></span>
                                        <div class="boat-rating">
                                            <span class="boat-star">★</span> <?php echo number_format($average_rating, 1); ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="boat-card-content">
                                    <h3 class="boat-product-title">
                                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                    </h3>
                                    
                                    <div class="boat-price-row">
                                        <div class="boat-prices">
                                            <div class="price-main">
                                                <span class="boat-current-price"><?php echo get_woocommerce_currency_symbol() . ($sale_price ? $sale_price : $regular_price); ?></span>
                                                <span class="boat-discount"><?php echo ($discount > 0) ? $discount . '% off' : ''; ?></span>
                                            </div>
                                            <?php if ($sale_price) : ?>
                                                <span class="boat-old-price"><?php echo get_woocommerce_currency_symbol() . $regular_price; ?></span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="boat-colors">
                                            <span class="boat-dots"><span class="dot"></span><span class="dot darker"></span></span>
                                            <span class="boat-color-count"><?php echo esc_html(get_post_meta(get_the_ID(), '_boat_color_count', true)); ?></span>
                                        </div>
                                    </div>
                                    
                                    <?php 
                                    /**
                                     * Hook: woocommerce_after_shop_loop_item.
                                     * @hooked woocommerce_template_loop_add_to_cart - 10
                                     */
                                    // Optionally remove the default button if it breaks layout, 
                                    // or style it inside the card.
                                    // do_action( 'woocommerce_after_shop_loop_item' ); 
                                    ?>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>

                <?php
                /**
                 * Hook: woocommerce_after_shop_loop.
                 *
                 * @hooked woocommerce_pagination - 10
                 */
                do_action( 'woocommerce_after_shop_loop' );
            else :
                /**
                 * Hook: woocommerce_no_products_found.
                 *
                 * @hooked wc_no_products_found - 10
                 */
                do_action( 'woocommerce_no_products_found' );
            endif; ?>
        </div>
    </div>
</main>

<?php get_footer(); ?>
