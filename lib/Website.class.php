<?php
require_once($loc . "lib/smarty/Smarty.class.php");

class Website extends Smarty {
	function __construct($settings = null) {
		parent::__construct();
		
		global $loc;
		if (!empty($settings)) {
			if (isset($settings["smarty"]["template_dir"]) && isset($settings["smarty"]["template"]))
				$this->setTemplateDir($loc . $settings["smarty"]["template_dir"] . $settings["smarty"]["template"]);
			if (isset($settings["smarty"]["compile_dir"]))
				$this->setCompileDir($loc . $settings["smarty"]["compile_dir"]);
			if (isset($settings["smarty"]["debug"])) {
				$this->debugging = $settings["smarty"]["debug"];
			}
		}
	}
		
	function display($src) {
		parent::display($src);
	}
	
	function generateSrc($src) {
		$html = parent::fetch($src);
		return $html;
	}
}
?>