<?php

class Layout extends LayoutBlock {
	function __construct() {
		$this->id = 'layout';
		$this->name = 'Layout Block';

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(
			'key' => 'content',
			'name' => 'content',
			'_name' => 'content',
			'label' => __('Blocks in section', I18N_THEME),
			'type' => 'sections',
			'required' => 1
		);
	}

	function render($data, $styles) {
		self::render_sections($data['content'], array('class' => 'row ' .(empty($styles['class']) ? 'row--cols-1' : $styles['class'])));
	}
}

new Layout();
