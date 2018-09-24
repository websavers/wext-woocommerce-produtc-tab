<?php 

/*
Plugin Name: WS Woocommerce Product Tab
Plugin URI: https://websavers.ca
Description: WEXT Woocommerce Product Tab is most popular & best tab plugin for woocommerce supported online shop website. WEXT Woocommerce Product Tab plugin show product from category. 
Author: Websavers Inc.
Author URI: https://websavers.ca
Original Author: weXteam
Original Author URI: http://wexteam.com
Version: 1.5


*/


/*-----------------------------------------------------
 * Some predeifne for wcpt
 *-----------------------------------------------------*/
if ( !defined( 'ABSPATH' ) ) {
	exit; // Exit if try to eccessed directly
}



/*-----------------------------------------------------
 * Settings file and api add for wcpt
 *-----------------------------------------------------*/
require_once dirname( __FILE__ ) . '/wcpt-settings-api.php';
require_once dirname( __FILE__ ) . '/wcpt-settings-fild.php';

new Wext_Wc_Product_Tab();



/*-----------------------------------------------------
 * trigger setting api class
 *-----------------------------------------------------*/
function wext_wcpt_get_option( $option, $section, $default = '' ) {
 
    $options = get_option( $section );
 
    if ( isset( $options[$option] ) ) {
        return $options[$option];
    }
 
    return $default;
}



/*---------------------------------------------------
 * Enqueue scripts and style for wcpt
 *---------------------------------------------------*/
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



/*---------------------------------------------------
 * Add style in header for settings options
 *---------------------------------------------------*/
function wext_wcpt_style_settings(){
?>

<style>
	.category-tab ul{
		background:<?php echo wext_wcpt_get_option( 'wext_wcpt_tab_panel_color', 'wext_wcpt_style', '#40403E' );?>;
		border-bottom: 1px solid <?php echo wext_wcpt_get_option( 'wext_wcpt_tab_color', 'wext_wcpt_style', '#FE980F' );?>;
	}
	.category-tab .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
		background-color:<?php echo wext_wcpt_get_option( 'wext_wcpt_tab_color', 'wext_wcpt_style', '#FE980F' );?>;
		 color:<?php echo wext_wcpt_get_option( 'wext_wcpt_tab_font_hover_color', 'wext_wcpt_style', '#FFFFFF' );?>;
	}
	.category-tab .nav-tabs>li>a:hover{
		background-color:<?php echo wext_wcpt_get_option( 'wext_wcpt_tab_color', 'wext_wcpt_style', '#FE980F' );?>;
	}
	.category-tab ul li a{
	    color:<?php echo wext_wcpt_get_option( 'wext_wcpt_tab_font_color', 'wext_wcpt_style', '#B3AFA8' );?>;
	}
	.category-tab .productinfo h2{
	    color:<?php echo wext_wcpt_get_option( 'wext_wcpt_pro_price_color', 'wext_wcpt_style', '#FE980F' );?>;
	}
	.category-tab .productinfo p{
		color:<?php echo wext_wcpt_get_option( 'wext_wcpt_pro_name_color', 'wext_wcpt_style', '#696763' );?>;
	}
	.category-tab .product-image-wrapper{
	    border: <?php echo wext_wcpt_get_option( 'wext_wcpt_pro_border', 'wext_wcpt_style', '1' );?>px solid #ccc;
	}
</style>

<?php
}
add_action('wp_head','wext_wcpt_style_settings');



/*--------------------------------------------------------
 * Shortcode function for wext woocommerce product tab
 *--------------------------------------------------------*/
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
						if ($tab_count == wext_wcpt_get_option( 'wext_wcpt_tab_number', 'wext_wcpt_settings', 5 )) {break;}

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
							'posts_per_page'=> wext_wcpt_get_option( 'wext_wcpt_product_number', 'wext_wcpt_settings', 4 ), 
							'post_type'		=> 'product', 
							'product_cat' 	=> $term->slug,
							'orderby' 		=> wext_wcpt_get_option( 'wext_wcpt_product_orderby', 'wext_wcpt_settings', 'name' ), 
							'order' 		=> wext_wcpt_get_option( 'wext_wcpt_product_order', 'wext_wcpt_settings', 'ASC' ), 
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



/*---------------------------------------------------------
 * Shortcode button for wext woocommerce product tab
 *----------------------------------------------------------*/
function wext_wcpt_buttons() {
	add_filter ("mce_external_plugins", "wext_wcpt_external_js");
	add_filter ("mce_buttons", "wext_wcpt_awesome_buttons");
}

function wext_wcpt_external_js($plugin_array) {
	$plugin_array['wextwcpt'] = plugins_url('js/custom-shortcode-button.js', __FILE__);
	return $plugin_array;
}

function wext_wcpt_awesome_buttons($buttons) {
	array_push ($buttons, 'wext_wcpt');
	return $buttons;
}
add_action ('init', 'wext_wcpt_buttons');



/*---------------------------------------------------------
 * Settings link in plugin page for wcpt
 *----------------------------------------------------------*/
function wcpt_plugin_add_settings_link( $links ) {
    $settings_link = '<a href="admin.php?page=wext_wc_tab_settings">' . __( 'Settings' ) . '</a>';
    array_push( $links, $settings_link );
  	return $links;
}
$plugin = plugin_basename( __FILE__ );
add_filter( "plugin_action_links_$plugin", 'wcpt_plugin_add_settings_link' );


