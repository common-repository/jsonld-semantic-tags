<?php

class ST_Widget extends WP_Widget
{
	
	public function __construct()
	{
		parent::__construct(
			'semantictags_widget',
			'SemanticWidget',
			array('description' => 'Allows you to create a new widget to SemanticTags!')
		);
	}

	public function widget($args, $item)
	{
		?>
		<script type="text/javascript">
			function popitup(url) {
			 newwindow=window.open(url,'name','height=1000,width=800');
			 if (window.focus) {newwindow.focus()}
			 return false;
			}
		</script>
		<?php
		extract($args);
		$widget_title = apply_filters('widget_title', $item['title']);
		$hide_empty = (isset($item['hide_empty'])) ? true : false;
		$order_options = (isset($item['order_options'])) ? explode('/', $item['order_options']) : array('', '');
		$html = '';
		
		$get_terms_args = array(
			'hide_empty' => $hide_empty,
			'orderby'    => (isset($order_options[0])) ? $order_options[0] : 'name',
			'order'      => (isset($order_options[1])) ? $order_options[1] : 'ASC',
			'number'     => (isset($item['max_terms'])) ? $item['max_terms'] : '',
			'exclude'    => (isset($item['exclude'])) ? $item['exclude'] : '',
			'include'    => (isset($item['include'])) ? $item['include'] : '',			
			'pad_counts' => true
		);
		

		$terms = get_terms($item['semantic_tags'], $get_terms_args);
		if (empty($terms) && isset($item['hide_widget_empty']))
			return;
			
		

		echo $before_widget;
			if (! empty($widget_title))
				echo $before_title . $widget_title . $after_title;
			?>

				<div class="tagcloud">
					<?php foreach ($terms as $term): 
						$html .= ST_Taxonomy::get_template_tag($terms, $term);
					?>

					<?php endforeach; ?>	
						
				</div>
			<?php
			echo $html ;
		echo $after_widget;
	}

	public function form($item)
	{
		$fields_args = array(
			'title' => array(
				'id'    => $this->get_field_id('title'), 'name'  => $this->get_field_name('title'),	'value' => (isset($item['title'])) ? $item['title'] : __('New Title')
			),
			'taxonomies' => array(
				'name'   => $this->get_field_name('semantic_tags'), 'value'  => (isset($item['semantic_tags'])) ? $item['semantic_tags'] : ''
			),
			'max_terms' => array(
				'id'    => $this->get_field_id('max_terms'), 'name'  => $this->get_field_name('max_terms'), 'value' => (isset($item['max_terms'])) ? $item['max_terms'] : ''
			),
			'hide_widget_empty' => array(
				'id'    => $this->get_field_id('hide_widget_empty'), 'name'  => $this->get_field_name('hide_widget_empty'),	'value' => (isset($item['hide_widget_empty'])) ? 'true' : ''
			),
			'hide_empty' => array(
				'id'    => $this->get_field_id('hide_empty'), 'name'  => $this->get_field_name('hide_empty'), 'value' => (isset($item['hide_empty'])) ? 'true' : ''
			),
			'order_options' => array(
				'id'    => $this->get_field_id('order_options'), 'name'  => $this->get_field_name('order_options'),	'value' => (isset($item['order_options'])) ? $item['order_options'] : 'name'
			),
			'exclude' => array(
				'id'    => $this->get_field_id('exclude'), 'name'  => $this->get_field_name('exclude'), 'value' => (isset($item['exclude'])) ? $item['exclude'] : ''
			),
			'include' => array(
				'id'    => $this->get_field_id('include'), 'name'  => $this->get_field_name('include'), 'value' => (isset($item['include'])) ? $item['include'] : ''
			)
		);

		$taxonomies = get_taxonomies(array('_builtin' => false), 'objects');

		?>
			<p>
				<label for="<?php echo $fields_args['title']['id']; ?>"><?php _e('Title:'); ?></label>
				<input class="widefat" id="<?php echo $fields_args['title']['id']; ?>" name="<?php echo $fields_args['title']['name']; ?>" type="text" value="<?php echo esc_attr($fields_args['title']['value']); ?>">
			</p>
			



			<p style='font-weight: bold;'><?php _e('Options:'); ?></p>
			
			<p>
				<label for="<?php echo $fields_args['order_options']['id']; ?>"><?php _e('Order SemanticTags By:'); ?></label><br>
				<select id="<?php echo $fields_args['order_options']['id']; ?>" name="<?php echo $fields_args['order_options']['name']; ?>">
					<option value="id/ASC" <?php selected($fields_args['order_options']['value'], 'id/ASC'); ?>>ID Ascending</option>
					<option value="id/DESC" <?php selected($fields_args['order_options']['value'], 'id/DESC'); ?>>ID Descending</option>
					<option value="count/ASC" <?php selected($fields_args['order_options']['value'], 'count/ASC'); ?>>Count Ascending</option>
					<option value="count/DESC" <?php selected($fields_args['order_options']['value'], 'count/DESC'); ?>>Count Descending</option>
					<option value="name/ASC" <?php selected($fields_args['order_options']['value'], 'name/ASC'); ?>>Name Ascending</option>
					<option value="name/DESC" <?php selected($fields_args['order_options']['value'], 'name/DESC'); ?>>Name Descending</option>				
					<option value="slug/ASC" <?php selected($fields_args['order_options']['value'], 'slug/ASC'); ?>>Slug Ascending</option>
					<option value="slug/DESC" <?php selected($fields_args['order_options']['value'], 'slug/DESC'); ?>>Slug Descending</option>
				</select>
			</p>

			<p>
				<input id="<?php echo $fields_args['hide_widget_empty']['id']; ?>" name="<?php echo $fields_args['hide_widget_empty']['name']; ?>" type="checkbox" value="true" <?php checked($fields_args['hide_widget_empty']['value'], 'true'); ?>>
				<label for="<?php echo $fields_args['hide_widget_empty']['id']; ?>"><?php _e('Hide Widget If There Are No SemanticTags To Display?'); ?></label>
			</p>

			<p>
				<input id="<?php echo $fields_args['hide_empty']['id']; ?>" name="<?php echo $fields_args['hide_empty']['name']; ?>" type="checkbox" value="true" <?php checked($fields_args['hide_empty']['value'], 'true'); ?>>
				<label for="<?php echo $fields_args['hide_empty']['id']; ?>"><?php _e('Hide SemanticTags That Have No Related Posts?'); ?></label>
			</p>

			<p>
				<label for="<?php echo $fields_args['exclude']['id']; ?>"><?php _e('Ids To Exclude From Being Displayed:'); ?></label>
				<input class="widefat" id="<?php echo $fields_args['exclude']['id']; ?>" name="<?php echo $fields_args['exclude']['name']; ?>" type="text" value="<?php echo esc_attr($fields_args['exclude']['value']); ?>" placeholder="Separate ids with a comma ','">
			</p>
			
			<p>
				<label for="<?php echo $fields_args['max_terms']['id']; ?>"><?php _e('Maximum Number Of SemanticTags:'); ?></label>
				<input class="widefat" id="<?php echo $fields_args['max_terms']['id']; ?>" name="<?php echo $fields_args['max_terms']['name']; ?>" type="text" value="<?php echo esc_attr($fields_args['max_terms']['value']); ?>" placeholder="Empty To Display All">
			</p>
			
			
			<p>
				<label for="<?php echo $fields_args['include']['id']; ?>"><?php _e('Only Display SemanticTags With The Following Ids:'); ?></label>
				<input class="widefat" id="<?php echo $fields_args['include']['id']; ?>" name="<?php echo $fields_args['include']['name']; ?>" type="text" value="<?php echo esc_attr($fields_args['include']['value']); ?>" placeholder="Separate ids with a comma ','">
			</p>



		<?php
	}

	public function update($new_item, $old_item)
	{
		$item['title'] = strip_tags($new_item['title']);
		$item['hide_widget_empty'] = $new_item['hide_widget_empty'];
		$item['hide_empty']        = $new_item['hide_empty'];
		$item['order_options']     = $new_item['order_options'];
		$item['max_terms']         = $new_item['max_terms'];
		$item['exclude']           = $new_item['exclude'];
		$item['include']           = $new_item['include'];
		$item['semantic_tags'] 	   = array('semantictags');
		
		return $item;
	}


}
