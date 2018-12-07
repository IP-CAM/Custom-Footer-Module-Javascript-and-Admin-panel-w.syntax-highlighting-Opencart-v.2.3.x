<?php

class ControllerExtensionModuleCalltrackingJS extends Controller {

	private $error = array();

	public function index() {

		//Load language file
    	$this->load->language('extension/module/calltracking_js');

    	$store_id = 0;


		$this->load->model('setting/setting');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('calltrackingjs', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('extension/extension', 'token=' . $this->session->data['token'] . '&type=module', true));
		}

		$text_strings = array(
				'heading_title',
				'button_save',
				'button_cancel',
				'button_add_module',
				'button_remove',
				'placeholder',
				'entry_code',
				'text_signup',
				'entry_status',
				'error_code',
				'text_enabled',
				'text_disabled'
		);

		foreach ($text_strings as $text) {
			$data[$text] = $this->language->get($text);
		}


		//error handling
 		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['code'])) {
			$data['error_code'] = $this->error['code'];
		} else {
			$data['error_code'] = '';
		}


  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], 'true'),
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_module'),
			'href'      => $this->url->link('extension/extension', 'token=' . $this->session->data['token'], 'true'),
      		'separator' => ' :: '
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('extension/module/calltracking_js', 'token=' . $this->session->data['token'], 'true'),
      		'separator' => ' :: '
   		);

		$data['action'] = $this->url->link('extension/module/calltracking_js', '&token=' . $this->session->data['token'], '&store_id=' . $store_id, true);

		$data['cancel'] = $this->url->link('extension/extension', 'token=' . $this->session->data['token'], true);

		$data['token'] = $this->session->data['token'];


		if (isset($this->request->post['calltrackingjs_code'])) {
			$data['calltrackingjs_code'] = $this->request->post['calltrackingjs_code'];
		} else {
			$data['calltrackingjs_code'] = $this->model_setting_setting->getSettingValue('calltrackingjs_code', $store_id);
		}
		
		if (isset($this->request->post['calltrackingjs_status'])) {
			$data['calltrackingjs_status'] = $this->request->post['calltrackingjs_status'];
		} else {
			$data['calltrackingjs_status'] = $this->model_setting_setting->getSettingValue('calltrackingjs_status', $store_id);
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		//Send the output
		$this->response->setOutput($this->load->view('extension/module/calltracking_js', $data));
	}

	/*
	 *
	 * Check that user actions are authorized && code area is filled
	 *
	 */
	private function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/calltracking_js')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		if (!$this->request->post['calltrackingjs_code']) {
			$this->error['code'] = $this->language->get('error_code');
		}

		return !$this->error;
	}


}
?>
