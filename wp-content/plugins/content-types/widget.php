<?php

class zap_content_type extends WP_Widget {


	function __construct() {
		// widget actual processes
	
		// Widget settings.
		$widget_ops = array('classname' => 'zapct-widget', 'description' => __('Du contenu centralisé qui se répète sur vos blogues'));

		// Widget control settings.
		$control_ops = array('id' => -1, 'id_base' => 'zapct-widget');

		// Create the widget.
		$this->WP_Widget('zapct-widget', __('Content Type', 'zapct-widget'), $widget_ops, $control_ops);
	}
	
	function form($instance) {
		// Set up some default widget settings.
		$defaults = array('title' => __('Content Type', 'zapct-widget'), 'id' => -1);
		
		$instance = wp_parse_args((array) $instance, $defaults);
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'youtube-widget'); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" style="width: 100%;" />
		</p>
		
		
	}

}