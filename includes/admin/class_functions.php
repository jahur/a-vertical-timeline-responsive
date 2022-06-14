<?php

namespace AVTLR\Includes\Admin;

class Admin_Functions{

    function __construct(){
        //add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );

        add_action( 'init', array($this, 'register_vtlr_post_type') );
		// Add Meta Box to post
		add_action( 'admin_init', array($this, 'single_repeater_meta_boxes'), 2 );
		// Save Meta Box values.
		add_action( 'save_post', array($this, 'single_repeatable_meta_box_save') );

		add_action( 'add_meta_boxes', array($this, 'cd_meta_box_add_vtlr') );
    }

    public function enqueue_scripts(){

       /* wp_enqueue_style( 'owl-carousel', plugins_url( '/css/owl.carousel.min.css', __FILE__ ), array(), time() );
        wp_enqueue_script('script-owl-carousel', plugin_dir_url(__FILE__) . '/js/owl.carousel.min.js', array('jquery'), time(), true);
        wp_enqueue_script('custom-js', plugin_dir_url(__FILE__) . '/js/custom.js', array('jquery'), time(), true);*/
    
    }

    public function register_vtlr_post_type() {
		$labels = array (
			'name'					=> _x( 'V Timeline', 'post type general name', 'vtlr' ),
			'singular_name'			=> _x( 'V Timeline', 'post type singular name', 'vtlr' ),
			'menu_name'				=> _x( 'V Timeline', 'admin menu', 'vtlr' ),
			'name_admin_bar'		=> _x( 'V Timeline', 'add new on admin bar', 'vtlr' ),
			'add_new'				=> _x( 'Add New', 'Timeline', 'vtlr' ),
			'add_new_item'			=> __( 'Add New Timeline', 'vtlr' ),
			'new_item'				=> __( 'New Timeline', 'vtlr' ),
			'edit_item'				=> __( 'Edit Timeline', 'vtlr' ),
			'view_item'				=> __( 'View Timeline', 'vtlr' ),
			'all_items'				=> __( 'All Timelines', 'vtlr' ),
			'search_items'			=> __( 'Search Timeline', 'vtlr' ),
			'parent_item_colon'		=> __( 'Parent Timeline:', 'vtlr' ),
			'not_found'				=> __( 'No timelines found.', 'vtlr' ),
			'not_found_in_trash'	=> __( 'No timeline found in Trash.', 'vtlr' )
		);
		$args = array(
			'labels'				=> $labels,
			'description'			=> __( 'Description.', 'vtlr' ),
			'public'				=> true,
			'publicly_queryable'	=> false,
			'show_ui'				=> true,
			'show_in_menu'			=> true,
			'query_var'				=> true,
			'rewrite'				=> array( 'slug' => 'vtlr' ),
			'capability_type'		=> 'post',
			'menu_icon'				=> 'dashicons-format-image',
			'has_archive'			=> true,
			'hierarchical'			=> false,
			'menu_position'			=> 35,
			'supports'				=> array ( 'title' )
		);
		
		register_post_type( 'vtlr', $args );

	}

	public function single_repeater_meta_boxes() {
		add_meta_box( 'single-repeter-data', 'Add timeline events', array($this, 'single_repeatable_meta_box_callback'), 'vtlr', 'normal', 'default');
	}


	public function single_repeatable_meta_box_callback($post) {

		$single_repeter_group = get_post_meta($post->ID, 'vtlr_group_demo', true);
		$banner_img = get_post_meta($post->ID,'post_banner_img',true);
		wp_nonce_field( 'repeterBox', 'formType' );
		?>
		<script type="text/javascript">
			jQuery(document).ready(function( $ ){
				$( '#add-row' ).on('click', function() {
					var row = $( '.empty-row.custom-repeter-text' ).clone(true);
					row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
					row.insertBefore( '#repeatable-fieldset-one tbody>tr:last' );
					return false;
				});
	
				$( '.remove-row' ).on('click', function() {
					$(this).parents('tr').remove();
					return false;
				});

			});
	
		</script>
        <style>
            .avtlr-fields{margin-bottom:10px}
        </style>
		<table id="repeatable-fieldset-one" width="100%">
			<tbody class="container-drag">
				<?php
				if ( $single_repeter_group ) :
					foreach ( $single_repeter_group as $field ) {
						?>
						<tr draggable="true" class="drag-row">
							<td>
							<div class="avtlr-fields avtlr-datetext">
								<p><strong>Date or text</strong></p>
								<input type="text"  style="width:98%;" name="dateortext[]" value="<?php if($field['dateortext'] != '') echo esc_attr( $field['dateortext'] ); ?>" placeholder="Date or text" />
							</div>
						
							<div class="avtlr-fields avtlr-title">
								<p><strong>Title</strong></p>
								<input type="text"  style="width:98%;" name="title[]" value="<?php if($field['title'] != '') echo esc_attr( $field['title'] ); ?>" placeholder="Heading" />
							</div>
						
							<div class="avtlr-fields avtlr-description">
								<p><strong>Description</strong></p>
								<textarea style="width:98%;" name="textarea1[]" rows="4" placeholder="Description"><?php if ($field['textarea1'] != '') echo esc_attr( $field['textarea1'] ); ?></textarea>
							</div>
						
							<div class="avtlr-fields avtlr-remove"><a class="button remove-row" href="#1">Remove</a></div>
							</td>
						</tr>
						<?php
					}
				else :
					?> 
					<tr draggable="true" class="drag-row">
						<td>
						<div class="avtlr-fields avtlr-datetext">
							<p><strong>Date or text</strong></p>
                            <input type="text"   style="width:98%;" name="dateortext[]" placeholder="Date or text"/>
                        </div>
					
						<div class="avtlr-fields avtlr-title">
							<p><strong>Title</strong></p>
							<input type="text"   style="width:98%;" name="title[]" placeholder="Heading"/>
						</div>
					
						<div class="avtlr-fields avtlr-description">
							<p><strong>Description</strong></p>
							<textarea style="width:98%;" name="textarea1[]" rows="4"  placeholder="Description"></textarea>
						</div>
					
						<div class="avtlr-fields avtlr-remove"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></div>
					</td>
					</tr>
				<?php endif; ?>
				<tr draggable="true" class="empty-row custom-repeter-text drag-row" style="display: none">
				<td>
					<div class="avtlr-fields avtlr-datetext">
						<p><strong>Date or text</strong></p>
						<input type="text" style="width:98%;" name="dateortext[]" placeholder="Date or text"/>
					</div>
				
					<div class="avtlr-fields avtlr-title">
						<p><strong>Title</strong></p>
						<input type="text" style="width:98%;" name="title[]" placeholder="Heading"/>
					</div>
				
					<div class="avtlr-fields avtlr-description">
						<p><strong>Description</strong></p>
						<textarea style="width:98%;" name="textarea1[]" rows="4" placeholder="Description"></textarea>
					</div>
				
					<div class="avtlr-fields avtlr-remove"><a class="button remove-row" href="#">Remove</a></div>
				</td>
				</tr>
				
			</tbody>
		</table>
		<p><a id="add-row" class="avtlr-fields avtlr-add button" href="#">Add another</a></p>
		<?php
	}

    public function single_repeatable_meta_box_save($post_id) {

		if (!isset($_POST['formType']))
			return;

		if(isset($_POST['formType'])){
			if(!wp_verify_nonce($_POST['formType'], 'repeterBox'))
			return;
		}

	
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
			return;
	
		if (!current_user_can('edit_post', $post_id))
			return;
	
		$old = get_post_meta($post_id, 'vtlr_group_demo', true);
	
		$new = array();
		$datetext = $_POST['dateortext'];
		$titles = $_POST['title'];
		$tdescs = $_POST['textarea1'];
		$count = count( $titles );
		for ( $i = 0; $i < $count; $i++ ) {
			if ( $titles[$i] != '' ) {
				$new[$i]['dateortext'] = stripslashes( strip_tags( $datetext[$i] ) );
				$new[$i]['title'] = stripslashes( strip_tags( $titles[$i] ) );
				$new[$i]['textarea1'] = stripslashes( $tdescs[$i] );
			}
		}
	
		if ( !empty( $new ) && $new != $old ){
			update_post_meta( $post_id, 'vtlr_group_demo', $new );
		} elseif ( empty($new) && $old ) {
			delete_post_meta( $post_id, 'vtlr_group_demo', $old );
		}
		$repeter_status= $_REQUEST['repeter_status'];
		update_post_meta( $post_id, 'repeter_status', $repeter_status );
	}

	public function cd_meta_box_add_vtlr(){
		add_meta_box( 'my-meta-box-id', 'Vertical timeline shortcode', array($this,'cd_meta_box_vtlr'), 'vtlr', 'side', 'high' );
	}
	
	function cd_meta_box_vtlr()
	{ 
		$id = get_the_ID();
		?>
		<input type="text" name="vtlr_shortcode_preview" id="vtlr_shortcode_preview" value="&#91;vtimeline id&#61;&quot;<?php the_ID(); ?>&quot;&#93;" readonly/>
		<?php 
	}

}