<?php
/**
 * @package WordPress
 * @subpackage proradio
 * @version 1.0.0
 * Theme function for custom parts:
 * Latest posts list
 *
 * Example:
 * [qt-post-list-horizontal post_type="" include_by_id="1,2,3" custom_query="..." tax_filter="category:trending, post_tag:video" items_per_page="9" orderby="date" order="DESC" meta_key="name_of_key" offset="" exclude="" el_class="" el_id=""]
*/
// don't load directly
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

if(!function_exists( 'proradio_template_post_list_horizontal' )){
	function proradio_template_post_list_horizontal( $atts = array() ){
		
		/*
		 *	Defaults
		 * 	All parameters can be bypassed by same attribute in the shortcode
		 */
		extract( shortcode_atts( array(
			// Query parameters
			'post_type' 			=> 'post',
			'include_by_id'			=> false,
			'custom_query'			=> false,
			'tax_filter'			=> false,
			'items_per_page'		=> 5,
			'orderby'				=> 'date',
			'order'					=> 'DESC',
			'meta_key'				=> false,
			'offset'				=> 0,
			'exclude'				=> '',
			'e_loadmore'			=> false,
			// Global parameters
			'el_id'					=>  uniqid('qt-post-list-'.get_the_ID()),
			'el_class'				=> '',
			'list_id'				=> false // required for compatibility with WPBakery Page Builder
		), $atts ) );

		ob_start();
		$list_id = md5( serialize($atts) );
		$paged = 1;
		include 'helpers/query-prep.php';
		$wp_query = new WP_Query( $args );
		$max = $wp_query->max_num_pages;
		if ( $wp_query->have_posts() ) : 
			?>
			<div id="<?php echo esc_attr( $list_id ); ?>" class="proradio-container proradio-post-list-horizontal">
				<?php  
				/**
				 * Loop
				 */
				while ( $wp_query->have_posts() ) : $wp_query->the_post();
					$post = $wp_query->post;
					setup_postdata( $post );
					get_template_part ('template-parts/post/post-horizontal');
					wp_reset_postdata();
				endwhile; 
				include 'helpers/loadmore.php';
				?>
			</div>
			<?php
		else: 
			esc_html_e("Sorry, there is nothing for the moment.", "proradio");
		endif; 
		wp_reset_postdata();
		return ob_get_clean();		
	}
}

// Set TTG Core shortcode functionality
if(function_exists('proradio_core_custom_shortcode')) {
	proradio_core_custom_shortcode("qt-post-list-horizontal","proradio_template_post_list_horizontal");
}

/**
 *  Visual Composer integration
 */
add_action( 'vc_before_init', 'proradio_template_post_list_horizontal_vc' );
if(!function_exists('proradio_template_post_list_horizontal_vc')){
	function proradio_template_post_list_horizontal_vc() {
		vc_map( 
			array(
				"name" => esc_html__( "Post list - Horizontal", "proradio" ),
				"base" => "qt-post-list-horizontal",
				"icon" => get_theme_file_uri( '/inc/proradio-core-setup/theme-functions/img/post-list-horizontal.png' ),
				"description" => esc_html__( "List of posts with horizontal design", "proradio" ),
				"category" => esc_html__( "Theme shortcodes", "proradio"),
				"params" => array_merge(
					proradio_vc_query_fields($items_per_page_std = 5)
				)
			)
		);
	}
}