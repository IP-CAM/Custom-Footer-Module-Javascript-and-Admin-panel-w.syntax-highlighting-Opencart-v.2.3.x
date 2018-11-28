<?php

class ControllerExtensionModuleCalltrackingJS extends Controller {

	protected function index() {

		//Load language file
		$this->language->load('extension/module/calltracking_js');

		//Set title from language file
      	$data['heading_title'] = $this->language->get('heading_title');

		//Load model
		$this->load->model('extension/module/calltracking_js');

		//Sample - get data from loaded model
		$data['customers'] = $this->model_extension_module_calltracking_js->getCustomerData();

		//Select template
		if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/extension/module/calltracking_js.tpl')) {
			$this->response->setOutput($this->load->view('extension/module/calltracking_js.tpl', $data));
		} else {
			$this->response->setOutput($this->load->view('extension/..module/calltracking_js.tpl', $data));
		}

	}
}

?>
