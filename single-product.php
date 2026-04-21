<?php
/**
 * The Template for displaying all single products
 */

get_header(); ?>

<main class="boat-single-product-page shubham-style">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
            <?php global $product; ?>
            <div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'boat-single-product', $product ); ?>>
                
                <div class="boat-product-breadcrumb">
                    <?php woocommerce_breadcrumb(); ?>
                </div>

                <div class="boat-single-main-grid">
                    <!-- Left: Product Image Gallery -->
                    <div class="boat-single-gallery">
                        <?php
                        // Main product image and thumbnails
                        do_action( 'woocommerce_before_single_product_summary' );
                        ?>
                    </div>

                    <!-- Right: Product Information Summary -->
                    <div class="boat-single-summary">
                        <header class="boat-summary-header">
                            <div class="shubham-rating-wishlist">
                                <?php if ( $product->get_average_rating() ) : ?>
                                    <div class="shubham-rating"><?php woocommerce_template_single_rating(); ?></div>
                                <?php else : ?>
                                    <div class="shubham-rating empty">⭐⭐⭐⭐⭐</div>
                                <?php endif; ?>
                            </div>
                            
                            <h1 class="shubham-title"><?php the_title(); ?></h1>
                            
                            <div class="shubham-price-section">
                                <label>Price</label>
                                <div class="shubham-price-box">
                                    <?php echo $product->get_price_html(); ?>
                                </div>
                            </div>
                        </header>

                        <!-- Add to Cart / Add Button -->
                        <div class="shubham-add-to-cart">
                            <?php
                            // Check if simple product, variable, etc.
                            woocommerce_template_single_add_to_cart();
                            ?>
                        </div>

                        <!-- Why Shop From Us Section -->
                        <div class="why-shop-section">
                            <h3 class="why-shop-title">Why Shop From <?php bloginfo('name'); ?>?</h3>
                            
                            <div class="why-shop-item">
                                <div class="icon">🏆</div>
                                <div class="text">
                                    <strong>Quality Assurance</strong>
                                    <p>Delivering high-precision solutions that meet the strictest industry standards.</p>
                                </div>
                            </div>
                            
                            <div class="why-shop-item">
                                <div class="icon">👨‍🔬</div>
                                <div class="text">
                                    <strong>Expert Support</strong>
                                    <p>We provide expert technical support to ensure you get the best product solutions.</p>
                                </div>
                            </div>
                            
                            <div class="why-shop-item">
                                <div class="icon">📦</div>
                                <div class="text">
                                    <strong>Reliable Logistics</strong>
                                    <p>Safe and efficient shipping ensuring your orders reach you on time, every time.</p>
                                </div>
                            </div>
                        </div>

                        <div class="shubham-description">
                            <h3>Description</h3>
                            <div class="content">
                                <?php the_excerpt(); ?>
                            </div>
                        </div>

                        <div class="shubham-meta">
                            <p><strong>Unit:</strong> 1 Unit</p>
                        </div>
                    </div>
                </div>

                <!-- Bottom Sections: Full Description/Reviews -->
                <div class="boat-single-tabs-section">
                    <?php do_action( 'woocommerce_after_single_product_summary' ); ?>
                </div>

            </div>
        <?php endwhile; ?>
    </div>
</main>

<?php get_footer(); ?>

<?php get_footer(); ?>
