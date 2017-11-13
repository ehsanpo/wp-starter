<?php

class Section extends LayoutBlock {
	function __construct() {
		$this->id = 'section';
		$this->name = 'Section Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'content',
			'name' => 'content',
			'label' => __('Blocks in section', I18N_THEME),
			'type' => 'sections',
			'required' => 1
		);

	}

	function render($data, $styles) {
		$class= 'section ' . $styles['class'];

		self::render_sections($data['content'], array('class' => $class));



	}
}

new Section();
