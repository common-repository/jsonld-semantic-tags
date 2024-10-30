<?php
/*
**************************************************************************

Plugin Name:  JSONLD Semantic Tags
Description:  Allows you to create semantic tags for posts and pages.
Version:      1.1.2
Author:       Dean Williams
License: 	  GPL2
Author URI:   https://webdesires.co.uk


**************************************************************************/

/*
How to use it
-------------------------

Choose one of the follow:

1. Tag cloud Widget
Go to admin panel on  Appearance-> Widgets.
Add SemanticWidget in a widget area of your choise.

2. Shortcode All
	Add the shortcode [semantic_tags] in any text field and show all the tags of the specific page.

3. Shortcode One word
	Replace any word in the text with the shortcode [semantic_tags text="tag-name"] (replace the "tag-name" with the tag of your choise)

4. Template page (For developers)
Replace get_the_tag_list('', __(', ' , '')) with SemanticTags_Plugin::get_semantic_tags() on index.php or function.php files.
Alternative you can add "echo  SemanticTags_Plugin::get_semantic_tags()" in any template page.

*/

//define( 'MYPLUGIN_FILE', __FILE__ );
require_once( dirname( __FILE__ ) . '/classes/ST_Taxonomy.php' );
require_once( dirname( __FILE__ ) . '/classes/ST_Widget.php' );
require_once( dirname( __FILE__ ) . '/classes/ST_settings.php' );

class semantic_tags {

	private static $instance = null;
	public $settings;
	public $taxonm;
	public $widget;
	public $name      = 'Semantic Tags'; //Human-readable name of plugin
	public $prefix    = '_semantic_tags'; //prefix to append to all options, API calls, etc.
	public $file      = null;
	public $folder    = null;
	public $version   = '1.2';


	/**
     * Creates or returns an instance of this class.
     *
     * @return  Foo A single instance of this class.
     */
    public static function get_instance() {

        if ( null == self::$instance ) {
            self::$instance = new self;
        }

        return self::$instance;

    } // end get_instance;


	/**
	 * Construct the primary class and auto-load all child classes
	 */
	public function __construct() {
		self::$instance = &$this;
		$this->file    	= __FILE__;
		$this->folder   = dirname(__FILE__);
		$this->settings = new SemanticTags_Plugin_Settings( $this );
		$this->taxonm 	= new ST_Taxonomy( $this );
		$this->widget 	= new ST_Widget();

		//init
		add_action( 'init', array( &$this, 'init' ) );

		register_activation_hook(__FILE__, array('ST_Taxonomy', 'activate'));
		register_deactivation_hook(__FILE__, array('ST_Taxonomy', 'deactivate'));

		if(isset($this->taxonm))
	    {
	        // Add the settings link to the plugins page


	       	add_filter("plugin_action_links_$this->file", array( &$this, 'settings_link' ) );

			add_action( 'wp_enqueue_scripts',  array( $this, 'load_resources' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'load_resources' ) );

			add_action('widgets_init', array( &$this, 'register_widget_SemanticTags' ) );


			//ABSPATH . 'wp-admin/includes/class-wp-list-table.php';
			add_action( 'admin_footer-edit-tags.php', array( &$this, 'wpse_56569_remove_cat_tag_description' ) );
	    }

	}


	/**
	 * Enqueues CSS, JavaScript, etc
	 */
	public static function load_resources() {
		if ( did_action( 'wp_enqueue_scripts' ) !== 1 && did_action( 'admin_enqueue_scripts' ) !== 1 )
			return;


		//wp_register_style( 'st_css', plugins_url('css/semantic_tags.css', __FILE__) );
		wp_register_style( 'st_css_admin', plugins_url('css/semantic_tags_admin.css', __FILE__) );

		if ( is_admin() ) {
			wp_enqueue_style( 'st_css_admin' );
		} else {
			//wp_enqueue_style( 'st_css' );
		}
	}


	public static function register_widget_SemanticTags() {
		register_widget('ST_Widget');
	}


    public static function settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=semantictags_plugin">Settings</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

	/**
	 * Init
	 */
	public static function init() {

	}

	public static function wpse_56569_remove_cat_tag_description(){
	    global $current_screen;
		// WE ARE AT /wp-admin/edit-tags.php?taxonomy=category
	    // OR AT /wp-admin/edit-tags.php?action=edit&taxonomy=category&tag_ID=1&post_type=post
	    switch ( $current_screen->id )
	    {
	        case 'edit-category':

	            break;
	        case 'edit-post_tag':

	            break;
			case 'edit-semantictags':
	            ?>
			    <script type="text/javascript">
			    jQuery(document).ready( function($) {
			        $('#addtag #tag-description').parent().remove();
					$('#addtag #tag-slug').parent().remove();
					$('#edittag #description').parent().parent().remove();
					$('#edittag #slug').parent().parent().remove();
			    });
			    </script>
			    <?php
	            break;
	    }


	}



}


$semantic_tags = semantic_tags::get_instance();

