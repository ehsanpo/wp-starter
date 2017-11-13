<?php if( function_exists('acf_add_local_field_group') ):


acf_add_local_field_group(array (
	'key' => 'group_55a3cc9b76f9c',
	'title' => 'Google Analytics',
	'fields' => array (
		array (
			'key' => 'field_55a3ccaded136',
			'label' => 'Google Analytics ID',
			'name' => 'google_analytics_id',
			'type' => 'text',
			'placeholder' => 'UA-XXXXXXXX-X',
		),
	),
	'location' => array (
		array (
			array (
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'general-settings',
			),
		),
	),
));


endif;
