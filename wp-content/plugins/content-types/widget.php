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

}