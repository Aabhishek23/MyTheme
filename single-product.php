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
                        // Custom Gallery: Main Image + Vertical Thumbnails
                        $product_id      = get_the_ID();
                        $main_image_id   = get_post_thumbnail_id($product_id);
                        $gallery_ids     = $product->get_gallery_image_ids();
                        $all_image_ids   = array_merge([$main_image_id], $gallery_ids);
                        $first_id        = $all_image_ids[0];
                        ?>
                        <div class="aipl-gallery-wrap">
                            <!-- Thumbnail column (left) -->
                            <div class="aipl-thumbs">
                                <?php foreach ($all_image_ids as $img_id) :
                                    $thumb_url = wp_get_attachment_image_url($img_id, 'thumbnail');
                                    $full_url  = wp_get_attachment_image_url($img_id, 'large');
                                ?>
                                    <div class="aipl-thumb <?php echo ($img_id === $first_id) ? 'active' : ''; ?>"
                                         onclick="aiplSetMain('<?php echo esc_js($full_url); ?>', this)">
                                        <img src="<?php echo esc_url($thumb_url); ?>" alt="">
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <!-- Main image (right) -->
                            <div class="aipl-main-img-wrap">
                                <?php
                                $main_url = wp_get_attachment_image_url($first_id, 'large');
                                ?>
                                <img id="aipl-main-img" src="<?php echo esc_url($main_url); ?>" alt="<?php the_title(); ?>">
                                <a href="<?php echo esc_url($main_url); ?>" id="aipl-fullview-link" target="_blank" class="click-to-view">Click to see full view</a>
                            </div>
                        </div>

                        <script>
                        function aiplSetMain(url, el) {
                            document.getElementById('aipl-main-img').src = url;
                            document.getElementById('aipl-fullview-link').href = url;
                            document.querySelectorAll('.aipl-thumb').forEach(function(t){ t.classList.remove('active'); });
                            el.classList.add('active');
                        }
                        </script>
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
