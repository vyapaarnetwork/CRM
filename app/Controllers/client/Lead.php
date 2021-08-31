<?php

namespace App\Controllers\client;

use App\Controllers\BaseController;

use App\Models\Leads_model;
use App\Models\Notification_model;

class Lead extends BaseController
{
    public $commentModel = null;
    public $leadMetaModel = null;
    protected $leadsModel = null;
    protected $notificatinModel = null;

    public function __construct()
    {
        $this->leadsModel = new Leads_model();
        $this->notificatinModel = new Notification_model();
    }

    public function index()
    {
        if (empty($this->session->client['svm_id'])) {
            return redirect()->to(base_url());
        }
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Leads';
        $headerData['page'] = 'lead';
        $headerData['session'] = $this->session;
        echo view('client/includs/header', $headerData);
        $data['session'] = $this->session;
        echo view('client/Leads/leads', $data);
        echo view('client/includs/footer', $headerData);
    }

    public function list()
    {
        $list = $this->leadsModel->get_datatables($_POST, $this->session->client['svm_slug']);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = '<td><a href="' . base_url('leadDetails/' . $key['slm_id']) . '">' . $key['sam_name'] . ' <i class="fa fa-eye"></i></a></td>';
            $row[] = '<td> ' . $key['sum_user_phone'] . '</td>';
            $row[] = '<td> ' . (!empty($key['slm_source_from']) ? $key['slm_source_from'] : 'Admin') . '</td>';
            $row[] = '<td> ' . $key['slm_leads_value'] . '</td>';
            $row[] = '<td> ' . $key['slm_leads_status'] . '</td>';
            $row[] = '<td> ' . date('d, M Y h:i A', strtotime($key['slm_inserted_at'])) . '</td>';
            $row[] = '<td> ' . date('d, M Y h:i A', strtotime($key['slm_updated_at'])) . '</td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->leadsModel->count_all($_POST),
            "recordsFiltered" => $this->leadsModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function detail($id = null)
    {
        if (empty($this->session->client['svm_id'])) {
            return redirect()->to(base_url());
        }
        if (empty($id)) {
            return redirect()->to(base_url('leads'));
        }
        $leads = $this->leadsModel->getLeadDetails($id);
        if (!empty($leads)) {
            $data['leadDetails'] = $leads[0];
        } else {
            return redirect()->to(menuUrl($this->session->admin['sam_admin_type'], 'leads'));
        }
        $data['comments'] = $this->commentModel->getLeadComments($leads[0]['slm_id']);
        $data['assign'] = $this->leadMetaModle->isKeyEx($leads[0]['slm_id'], 'assign_lead');
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Lead Details';
        $headerData['page'] = 'leadDetails';
        $headerData['session'] = $this->session;
        echo view('client/includs/header', $headerData);
        $data['session'] = $this->session;
        echo view('client/Leads/leadDetails', $data);
        echo view('client/includs/footer', $headerData);
    }
}