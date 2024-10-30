<?php
/*
**************************************************************************

Plugin Name:  JSONLD Semantic Tags
Description:  Allows you to create semantic tags for posts and pages.
Version:      1.0
Author:       Dean Williams
License: 	  GPL2
Author URI:   https://webdesires.co.uk


**************************************************************************/


if(!class_exists('ST_Taxonomy'))
{
	global $havejs;

	class ST_Taxonomy
	{
		/**
		 * Construct the plugin object
		 */
		public function __construct()
		{
			global $havejs;
			$havejs = false;
        	// Initialize Settings
            //require_once(sprintf("%s/ST_settings.php", dirname(__FILE__)));
            //$SemanticTags_Plugin_Settings = new SemanticTags_Plugin_Settings();



			add_action( 'init', array($this, 'build_SemanticTags') , 11);

 			add_shortcode( 'semantic_tags', array( $this, 'get_semantic_tags' ) );






		} // END public function __construct

		/**
		 * Activate the plugin
		 */
		public static function activate()
		{

			// Do nothing
		} // END public static function activate

		/**
		 * Deactivate the plugin
		 */
		public static function deactivate()
		{
			// Do nothing
		} // END public static function deactivate





		public static function copy_below_table( $taxonomy ) {
		    echo 'Add rewrite rule on .htaccess	<code>RewriteRule ^semantictags/(.*)$ /semantictags [L,R=301]</code>';
		}


		public static function copy_above_form( $taxonomy ) {
		    echo '<p>Dolor sit amet</p>';
		}

		public function build_SemanticTags() {

			// Add new taxonomy, NOT hierarchical (like tags)
			$labels = array(
				'name'                       => _x( 'Semantic Tags', 'taxonomy general name' ),
				'singular_name'              => _x( 'Semantic Tags', 'taxonomy singular name' ),
				'search_items'               => __( 'Search Semantic Tags' ),
				'popular_items'              => __( 'Popular Semantic Tags' ),
				'all_items'                  => __( 'All Semantic Tags' ),
				'parent_item'                => null,
				'parent_item_colon'          => null,
				'edit_item'                  => __( 'Edit Semantic Tags' ),
				'update_item'                => __( 'Update Semantic Tags' ),
				'add_new_item'               => __( 'Add New Semantic Tags' ),
				'new_item_name'              => __( 'New Semantic Tags Name' ),
				'separate_items_with_commas' => __( 'Separate Semantic Tags with commas' ),
				'add_or_remove_items'        => __( 'Add or remove Semantic Tags' ),
				'choose_from_most_used'      => __( 'Choose from the most used Semantic Tags' ),
				'not_found'                  => __( 'No Semantic Tags found.' ),
				'menu_name'                  => __( 'Semantic Tags' ),
			);

			$args = array(
				'hierarchical'          => false,
				'labels'                => $labels,
				'show_ui'               => true,
				'show_admin_column'     => true,
				'update_count_callback' => '_update_post_term_count',
				'query_var'             => true,
				'rewrite'               => array( 'slug' => 'semantictags', true ),
			);

			$post_types = get_post_types('','names');
			register_taxonomy( 'semantictags', $post_types, $args );
			//flush_rewrite_rules();

			add_action( 'semantictags_add_form_fields', array('ST_Taxonomy','semantictags_taxonomy_add_new_meta_field'));
			add_action( 'semantictags_edit_form_fields', array('ST_Taxonomy','semantictags_taxonomy_edit_meta_field' ));
			add_action( 'edited_semantictags', array(&$this,'save_taxonomy_semantic_meta'));
			add_action( 'create_semantictags', array(&$this,'save_taxonomy_semantic_meta'));



		}





		public static function semantictags_taxonomy_add_new_meta_field() {

				?>


				<? /*<div class="form-field">
					<label for="term_meta[semantictag_term_meta_rel]"><?php _e( 'Rel', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_rel]" id="term_meta[semantictag_term_meta_rel]" value="">
					<p class="description"><?php _e( 'Enter rel. You can add mutliple attributes with a space between them like i.e rel="nofollow bookmark"','semantictags' ); ?></p>
				</div>*/ ?>
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_title]"><?php _e( 'Citation', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_title]" id="term_meta[semantictag_term_meta_title]" value="">
					<p class="description"><?php _e( 'Enter Citation"','semantictags' ); ?></p>
				</div>
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_link]"><?php _e( 'Link', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_link]" id="term_meta[semantictag_term_meta_link]" value="">
					<p class="description"><?php _e( 'Enter internal or external URL (Link)' ); ?></p>
				</div>
				<? /*
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_blank]"><?php _e( 'Target', 'semantictags' ); ?></label>
					<input type="checkbox" name="term_meta[semantictag_term_meta_blank]" id="term_meta[semantictag_term_meta_blank]" value="">
					<p class="description"><?php _e( 'Check if is _blank','semantictags' ); ?></p>
				</div>

				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_pop]"><?php _e( 'Popup', 'semantictags' ); ?></label>
					<input type="checkbox" name="term_meta[semantictag_term_meta_pop]" id="term_meta[semantictag_term_meta_pop]" value="">
					<p class="description"><?php _e( 'Check if is popup','semantictags' ); ?></p>
				</div>

				<div class="form-field">
					<p><h3>Advance settings</h3></p>
				</div>

				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_property]"><?php _e( 'Property', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_property]" id="term_meta[semantictag_term_meta_property]" value="">
					<p class="description"><?php _e( 'Enter property e.g. "ctag:label"','semantictags' ); ?></p>
				</div>
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_resource]"><?php _e( 'Resource', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_resource]" id="term_meta[semantictag_term_meta_resource]" value="">
					<p class="description"><?php _e( 'Enter resource URL (this will not be visible in the browser and not a clickable link)','semantictags' ); ?></p>
				</div>
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_content]"><?php _e( 'Content', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_content]" id="term_meta[semantictag_term_meta_content]" value="">
					<p class="description"><?php _e( 'Enter content','semantictags' ); ?></p>
				</div>
				<div class="form-field">
					<label for="term_meta[semantictag_term_meta_typeof]"><?php _e( 'Typeof', 'semantictags' ); ?></label>
					<input type="text" name="term_meta[semantictag_term_meta_typeof]" id="term_meta[semantictag_term_meta_typeof]" value="">
					<p class="description"><?php _e( 'Enter typeof e.g. "ctag:Tag"','semantictags' ); ?></p>
				</div>

*/ ?>




			<?php
		}


		// Edit term page
		public static function semantictags_taxonomy_edit_meta_field($term) {

			$t_id = $term->term_id;

			// retrieve the existing value(s) for this meta field. This returns an array
			$term_meta = get_option( "taxonomy_$t_id" ); ?>



			<? /*
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_rel]"><?php _e( 'Rel', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_rel]" id="term_meta[semantictag_term_meta_rel]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_rel'] ) ? esc_attr( $term_meta['semantictag_term_meta_rel'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter rel. You can add mutliple attributes with a space between them like i.e rel="nofollow bookmark"','semantictags' ); ?></p>
				</td>
			</tr>*/?>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_title]"><?php _e( 'Citation', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_title]" id="term_meta[semantictag_term_meta_title]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_title'] ) ? esc_attr( $term_meta['semantictag_term_meta_title'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter Citation attribute"','semantictags' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_link]"><?php _e( 'Link', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_link]" id="term_meta[semantictag_term_meta_link]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_link'] ) ? esc_attr( $term_meta['semantictag_term_meta_link'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter internal or external URL (Link)' ); ?></p>
				</td>
			</tr>
			<? /*
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_blank]"><?php _e( 'Target', 'semantictags' ); ?></label></th>
				<td>
					<?php
					$field_blank = 'off';
					$field_blank_checked = '';
					if (isset($term_meta['semantictag_term_meta_blank'])){
						if ($term_meta['semantictag_term_meta_blank'] == "_blank") {
							$field_blank_checked = 'checked="checked"';
							$field_blank = 'on';
						}
					}
					?>
					<input type="checkbox" name="term_meta[semantictag_term_meta_blank]" id="term_meta[semantictag_term_meta_blank]" value="<?php echo $field_blank;?>"  <?php echo $field_blank_checked; ?> >
					<p class="description"><?php _e( 'Check if is _blank','semantictags' ); ?></p>
				</td>
			</tr>


			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_pop]"><?php _e( 'Popup', 'semantictags' ); ?></label></th>
				<td>
					<?php
					$field_blank = 'off';
					$field_blank_checked = '';
					if (isset($term_meta['semantictag_term_meta_pop'])){
						if ($term_meta['semantictag_term_meta_pop'] == "yes") {
							$field_blank_checked = 'checked="checked"';
							$field_blank = 'on';
						}
					}
					?>
					<input type="checkbox" name="term_meta[semantictag_term_meta_pop]" id="term_meta[semantictag_term_meta_pop]" value="<?php echo $field_blank;?>"  <?php echo $field_blank_checked; ?> >
					<p class="description"><?php _e( 'Check if is popup','semantictags' ); ?></p>
				</td>
			</tr>

			<tr class="form-field">
				<th scope="row" valign="top">
					<p><h3>Advance settings</h3></p>
				</th>
				<td>

				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_property]"><?php _e( 'Property', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_property]" id="term_meta[semantictag_term_meta_property]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_property'] ) ? esc_attr( $term_meta['semantictag_term_meta_property'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter property e.g. "ctag:label"','semantictags' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_resource]"><?php _e( 'Resource', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_resource]" id="term_meta[semantictag_term_meta_resource]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_resource'] ) ? esc_attr( $term_meta['semantictag_term_meta_resource'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter resource URL (this will not be visible in the browser and not a clickable link)','semantictags' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_content]"><?php _e( 'Content', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_content]" id="term_meta[semantictag_term_meta_content]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_content'] ) ? esc_attr( $term_meta['semantictag_term_meta_content'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter content','semantictags' ); ?></p>
				</td>
			</tr>
			<tr class="form-field">
				<th scope="row" valign="top"><label for="term_meta[semantictag_term_meta_typeof]"><?php _e( 'Typeof', 'semantictags' ); ?></label></th>
				<td>
					<input type="text" name="term_meta[semantictag_term_meta_typeof]" id="term_meta[semantictag_term_meta_typeof]" value="<?php echo esc_attr( $term_meta['semantictag_term_meta_typeof'] ) ? esc_attr( $term_meta['semantictag_term_meta_typeof'] ) : ''; ?>">
					<p class="description"><?php _e( 'Enter typeof e.g. "ctag:Tag"','semantictags' ); ?></p>
				</td>
			</tr>

			*/ ?>

		<?php

		}


		// Save extra taxonomy fields callback function.
		public function save_taxonomy_semantic_meta( $term_id ) {
			if ( isset( $_POST['term_meta'] ) ) {
				//
				$t_id = $term_id;
				$term_meta = get_option( "taxonomy_$t_id" );

				$cat_keys = array_keys( $_POST['term_meta'] );
				foreach ( $cat_keys as $key ) {
					if ( isset ( $_POST['term_meta'][$key] ) ) {
						$term_meta[$key] = $_POST['term_meta'][$key];
					}
				}
				if ( isset ( $_POST['term_meta']['semantictag_term_meta_blank'] ) ) {
					$term_meta['semantictag_term_meta_blank'] = '_blank';
				} else {
					$term_meta['semantictag_term_meta_blank'] = '';
				}

				if ( isset ( $_POST['term_meta']['semantictag_term_meta_pop'] ) ) {
					$term_meta['semantictag_term_meta_pop'] = 'yes';
				} else {
					$term_meta['semantictag_term_meta_pop'] = '';
				}

				update_option( "taxonomy_$t_id", $term_meta );


			}
		}


		public static function get_semantic_tags($atts) {
			global $post, $havejs;
			extract(shortcode_atts(array('text' => '',), $atts));

			if ($havejs){
			?>
			<script type="text/javascript">
			function popitup(url) {
				newwindow=window.open(url,'name','height=1000,width=800');
				if (window.focus) {newwindow.focus()}
				return false;
			}
			</script>
			<?php
			} // end if havejs

			$havejs = true;
			$terms = array();
			if (isset($atts['text'])) {
				if ( $text != '' ) {
					$terms[] = get_term_by('name', $text, 'semantictags');
					if (empty($terms[0])){ $html = $text;}
				}
			} else {
				$terms = wp_get_post_terms( $post->ID, 'semantictags', '' );
			}

			if (!empty($terms[0])){
				foreach ($terms as $term) {
					$html .= self::get_template_tag($terms, $term);
				}
			}
			return $html;
		}

		public static function get_template_tag($terms , $term, $ispopup = NULL) {
			$html = '<span xmlns:ctag="http://commontag.org/ns#" about="'.get_the_title().'" rel="ctag:tagged">';
			$term_meta_options = get_option( "taxonomy_$term->term_id" );
			$term_info = get_term( $term );

			$semantictag_term_meta_pop = (isset($term_meta_options['semantictag_term_meta_pop'])) ? $term_meta_options['semantictag_term_meta_pop'] : '';
			$semantictag_term_meta_resource = (isset($term_meta_options['semantictag_term_meta_resource'])) ? $term_meta_options['semantictag_term_meta_resource'] : '';
			$semantictag_term_meta_blank = (isset($term_meta_options['semantictag_term_meta_blank'])) ? $term_meta_options['semantictag_term_meta_blank'] : '';
			$semantictag_term_meta_typeof = (isset($term_meta_options['semantictag_term_meta_typeof'])) ? $term_meta_options['semantictag_term_meta_typeof'] : '';
			$semantictag_term_meta_property = (isset($term_meta_options['semantictag_term_meta_property'])) ? $term_meta_options['semantictag_term_meta_property'] : '';
			$semantictag_term_meta_rel = (isset($term_meta_options['semantictag_term_meta_rel'])) ? $term_meta_options['semantictag_term_meta_rel'] : '';
			$semantictag_term_meta_link = (isset($term_meta_options['semantictag_term_meta_link'])) ? $term_meta_options['semantictag_term_meta_link'] : '';
			$semantictag_term_meta_content = (isset($term_meta_options['semantictag_term_meta_content'])) ? $term_meta_options['semantictag_term_meta_content'] : '';
			$semantictag_term_meta_name = (isset($term_meta_options['semantictag_term_meta_name'])) ? $term_meta_options['semantictag_term_meta_name'] : '';
			$semantictag_term_meta_title = (isset($term_meta_options['semantictag_term_meta_title'])) ? $term_meta_options['semantictag_term_meta_title'] : '';

			//if (substr($semantictag_term_meta_link, 0, 7) != 'http://') {
			      //$semantictag_term_meta_link = 'http://' . $semantictag_term_meta_link;
		    //}

			if (isset($term_meta_options['semantictag_term_meta_link']) && $term_meta_options['semantictag_term_meta_link'] != '') {
				//

				if ($semantictag_term_meta_pop == 'yes'){
					$pop_Frame = "'windowname1'";
					$pop_props = "'scrollbars=1, width=900, height=820'";
					$html .= '<a href="'.$semantictag_term_meta_link.'" onclick="return popitup(this.href)"'; //
				} else {
					$html .= '<a href="'. $semantictag_term_meta_link.'"'.' ';
				}
				$html .= ($semantictag_term_meta_blank == '_blank') ? ' target="_blank" ' : '';
				$html .= " class='semantictags' " ;
				$html .= ($semantictag_term_meta_typeof != '') ? ' typeof="'. $semantictag_term_meta_typeof.'"' : '';
				$html .= ($semantictag_term_meta_rel != '') ? ' rel="'. $semantictag_term_meta_rel.'"' : '';
				$html .= ($semantictag_term_meta_resource != '') ? ' resource="'. $semantictag_term_meta_resource.'"' : '';
				$html .= ($semantictag_term_meta_property != '') ? ' property="'. $semantictag_term_meta_property.'" ' : '';
				$html .= ($semantictag_term_meta_content != '') ? ' content="'. $semantictag_term_meta_content.'" ' : '';
				$html .= ($semantictag_term_meta_title != '') ? ' title="'. $semantictag_term_meta_title.'" ' : '';
				$html .= '>'.$term->name.'</a>';
			} else {

				$html .= '<span ';
				$html .= " class='semantictags' " ;
				$html .= ($semantictag_term_meta_typeof != '') ? ' typeof="'. $semantictag_term_meta_typeof.'"' : '';
				$html .= ($semantictag_term_meta_rel != '') ? ' rel="'. $semantictag_term_meta_rel.'"' : '';
				$html .= ($semantictag_term_meta_resource != '') ? ' resource="'. $semantictag_term_meta_resource.'"' : '';
				$html .= ($semantictag_term_meta_property != '') ? ' property="'. $semantictag_term_meta_property.'" ' : '';
				$html .= ($semantictag_term_meta_content != '') ? ' content="'. $semantictag_term_meta_content.'" ' : '';
				$html .= ($semantictag_term_meta_title != '') ? ' title="'. $semantictag_term_meta_title.'" ' : '';
					$html .= '>'.$term->name.'</span>';
			}

			$html .= '</span>';

			if ($term != end($terms)) {
				$html .= ', ';
			}

			//NEW CODE HERE
			$html = '';
			ob_start();
			if ($semantictag_term_meta_link != '') {
			?>
			<script type="application/ld+json">
{
"@context": "http://schema.org",
"@type": "CreativeWork",
"citation": "<?php echo $semantictag_term_meta_title; ?>",
"keywords": "<?php echo $term_info->name; ?>",
"url": "<?php echo $semantictag_term_meta_link; ?>"
}
</script>
			<?
			$html = ob_get_clean();
			}

			return $html;
		}

		// add sortcode e.g. [semantic_tags]


	} // END class ST_Taxonomy
} // END if(!class_exists('ST_Taxonomy'))
