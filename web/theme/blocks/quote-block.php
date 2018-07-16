<?php

class quoteBlock extends TwigBlock {
	function __construct() {
		$this->id = "quote-block";
		$this->name = "quote Block";

		parent::__construct();
	}

	function define(&$fields) {
		$fields[] = array(

		);
		
	}

	function get_template_data($data) {
		return $data;
	}
}

new quoteBlock();

