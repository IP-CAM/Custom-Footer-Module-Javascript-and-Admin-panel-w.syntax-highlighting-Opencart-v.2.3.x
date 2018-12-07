<?php

class ControllerExtensionModuleCalltrackingJS extends Controller {

	protected function index() {

		$code = html_entity_decode($this->config->get('calltrackingjs_code'), ENT_QUOTES, 'UTF-8');

		$this->document->setCallTracking($code);

	}
}

?>
