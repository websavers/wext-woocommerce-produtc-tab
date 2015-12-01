<?php 

/**
* Plugin Name: WEXT Woocommerce Product Tab
* Author: weXteam
* Author URI: http://wexteam.com
* Version: 1.0
* 
*
*/


/*--------- Some predeifne for WEXT woocommerce tab plugin -----------*/
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if try to eccessed directly
}

define('WEXT_WC_PRODUCT_TAB_DEFINE','/'.WP_PLUGIN_URI.'/'.plugin_basename(dirname(__FILE__)).'/');



/*---------Enqueue scripts and style---------*/
function wext_wc_enqueue_scripts(){
	wp_register_style('bootstrap', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css', array(), '3.3.6' );
	wp_register_style('customstyle', plugins_url( '/css/customstyle.css', __FILE__ ), array(), '1.0');
	
	wp_register_script('bootstrap-js', '//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js', array('jquery'), '3.3.6' );
	wp_register_script('tab-active', plugins_url( '/js/tab-active.js', __FILE__ ), array('jquery'), '1.0');

	wp_enqueue_style('bootstrap');
	wp_enqueue_style('customstyle');
	wp_enqueue_script('bootstrap-js');
	wp_enqueue_script('tab-active');
}
add_action('wp_enqueue_scripts', 'wext_wc_enqueue_scripts');



function wext_wc_product_tab_shortcode($atts){
   extract(shortcode_atts(array(
      'posts' => 1,
   ), $atts));
?>


<div class="category-tab"><!--category-tab-->
	<div class="col-md-12 col-sm-12">
		<?php if(!is_tax()) {
			$terms = get_terms("product_cat");
			$count = count($terms);
			if ( $count > 0 ){ ?>

				<ul class="nav nav-tabs">
					<?php
						$tab_count = 0;

						foreach ( $terms as $term ) {							
						echo '<li><a href="#'.$term->slug.'" data-toggle="tab">'.$term->name.'</a></li>';

						$tab_count ++;
						if ($tab_count == 6) {break;}

					} ?>
				</ul>

		<?php } } ?>

	</div>
	<div class="tab-content">
			
	<?php if(!is_tax()) {
			$terms = get_terms("product_cat");
			$count = count($terms);
			if ( $count > 0 ){ 
				foreach ( $terms as $term ) {	

					echo '<div class="tab-pane fade" id="'.$term->slug.'" >';

					?>
						<?php
						global $post;
						$args = array( 
								'posts_per_page' 	=> 4, 
								'post_type'			=> 'product', 
								'product_cat' 		=> $term->slug,
								'orderby' 			=> 'date', 
								'order' 			=> 'ASC', 
							);
						$myposts = get_posts( $args );

						foreach( $myposts as $post ) : setup_postdata($post); ?>
						
						<?php $h_c_p_img = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'home_cat_pod_image' );?>

			
						<div class="col-md-3 col-sm-6 col-xs-6 single-product-wrapper">
							<div class="product-image-wrapper">
								<div class="single-products">
									<div class="productinfo text-center">
										<img src="<?php echo $h_c_p_img[0]; ?>" alt="" />
										
										<?php global $product; if ( $price_html = $product->get_price_html() ) : ?>
												<h2><span class="price"><?php echo $price_html; ?></span></h2>
										<?php endif; ?>
										
										<p><?php the_title(); ?></p>
										
										<a class="btn btn-default add-to-cart button add_to_cart_button product_type_simple added" data-product_sku="5220" data-product_id="<?php the_id(); ?>" rel="nofollow" href="/ecommerce/?post_type=product&amp;add-to-cart=<?php the_id(); ?>"><i class="fa fa-shopping-cart"></i>Add to cart</a>
									</div>
									
								</div>
							</div>
						</div>
			
						<?php endforeach; ?>
					</div>
		<?php } } } ?>
	</div>
</div><!--/category-tab-->
   


<?php

   
}

function register_shortcodes(){
   add_shortcode('product-tab', 'wext_wc_product_tab_shortcode');
}
add_action( 'init', 'register_shortcodes');



