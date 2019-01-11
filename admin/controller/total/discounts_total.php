<?php
/*
@author  nikifalex
@skype   logoffice1
@link    http://opencartmodules.ru
*/

class ControllerTotalDiscountsTotal extends Controller {
    private $error = array();

    private static function cmpd($a, $b)
    {
        if ($a["summ"]==$b["summ"]) {
            return 0;
        }
        return ($a["summ"]<$b["summ"]) ? -1 : 1;
    }


    public function index() {
        $this->load->language('total/discounts_total');

        $this->document->setTitle($this->language->get('heading_title'));

        $this->load->model('setting/setting');

        if (($this->request->server['REQUEST_METHOD'] == 'POST') && ($this->validate())) {
            $this->model_setting_setting->editSetting('discounts_total', $this->request->post);

            $this->session->data['success'] = $this->language->get('text_success');

            $this->response->redirect($this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'));
        }

        $data['heading_title'] = $this->language->get('heading_title');
        $data['text_edit'] = $this->language->get('text_edit');

        $data['text_enabled'] = $this->language->get('text_enabled');
        $data['text_disabled'] = $this->language->get('text_disabled');

        $data['entry_status'] = $this->language->get('entry_status');
        $data['entry_sort_order'] = $this->language->get('entry_sort_order');
        $data['entry_discounts_table'] = $this->language->get('entry_discounts_table');
        $data['entry_discounts_add'] = $this->language->get('entry_discounts_add');
        $data['entry_discounts_from'] = $this->language->get('entry_discounts_from');
        $data['entry_discounts_discount'] = $this->language->get('entry_discounts_discount');
        $data['entry_discounts_delete'] = $this->language->get('entry_discounts_delete');
        $data['entry_order_status'] = $this->language->get('entry_order_status');
        $data['entry_last_days'] = $this->language->get('entry_last_days');

        $data['entry_calc_type'] = $this->language->get('entry_calc_type');
        $data['calc_types'] = explode('|',$this->language->get('calc_types'));
        $data['note'] = $this->language->get('note');

        $data['button_save'] = $this->language->get('button_save');
        $data['button_cancel'] = $this->language->get('button_cancel');

        if (isset($this->error['warning'])) {
            $data['error_warning'] = $this->error['warning'];
        } else {
            $data['error_warning'] = '';
        }

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_total'),
            'href'      => $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('total/discounts_total', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );

        $data['action'] = $this->url->link('total/discounts_total', 'token=' . $this->session->data['token'], 'SSL');

        $data['cancel'] = $this->url->link('extension/total', 'token=' . $this->session->data['token'], 'SSL');


        $this->load->model('localisation/order_status');
        $data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();


        if (isset($this->request->post['discounts_total_status'])) {
            $data['discounts_total_status'] = $this->request->post['discounts_total_status'];
        } else {
            $data['discounts_total_status'] = $this->config->get('discounts_total_status');
        }

        if (isset($this->request->post['discounts_total_order_status_id'])) {
            $data['discounts_total_order_status_id'] = $this->request->post['discounts_total_order_status_id'];
        } else {
            $data['discounts_total_order_status_id'] = $this->config->get('discounts_total_order_status_id');
        }

        if (isset($this->request->post['discounts_total_calc_type_id'])) {
            $data['discounts_total_calc_type_id'] = $this->request->post['discounts_total_calc_type_id'];
        } else {
            $data['discounts_total_calc_type_id'] = $this->config->get('discounts_total_calc_type_id');
        }



        if (isset($this->request->post['discounts_total_sort_order'])) {
            $data['discounts_total_sort_order'] = $this->request->post['discounts_total_sort_order'];
        } else {
            $data['discounts_total_sort_order'] = $this->config->get('discounts_total_sort_order');
        }

        if (isset($this->request->post['discounts_total_last_days'])) {
            $data['discounts_total_last_days'] = $this->request->post['discounts_total_last_days'];
        } else {
            $data['discounts_total_last_days'] = $this->config->get('discounts_total_last_days');
        }


        if (isset($this->request->post['discounts_table'])) {
            $data['discounts_table'] = $this->request->post['discounts_total_discounts_table'];
        } else {
            $d=$this->config->get('discounts_total_discounts_table');
            if (is_array($d)) {
                usort($d, array('ControllerTotalDiscountsTotal', 'cmpd'));
                $data['discounts_table'] = $d;
            } else {
                $data['discounts_table'] = array();
            }
        }

        if (count($data['discounts_table'])==0)
            $data['discounts_table'][]=array('summ'=>'0', 'value'=>'0');


        $data['header'] = $this->load->controller('common/header');
        $data['column_left'] = $this->load->controller('common/column_left');
        $data['footer'] = $this->load->controller('common/footer');

        $this->response->setOutput($this->load->view('total/discounts_total.tpl', $data));

    }

    private function validate() {
        if (!$this->user->hasPermission('modify', 'total/discounts_total')) {
            $this->error['warning'] = $this->language->get('error_permission');
        }
        return !$this->error;
    }
}
?>