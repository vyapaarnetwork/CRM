<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Notification_model;
use App\Models\Leadsource_model;




class Leadsource extends BaseController
{
    public $leadsource = null;
    public $vendorModel = null;
    public $categoriesModel = null;
    public $notificatinModel = null;
    public $notification = null;
    public $salesModle = null;

    function __construct()
    {
        $this->notificatinModel = new Notification_model();
        $this->leadsource = new Leadsource_model();


        if (!empty($this->session->admin)) {
            $this->notification = $this->notificatinModel->getNotification($this->session->admin['admin_id']);
        }
    }
    public function index()
    {
        $setting = settingSiteData();
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Leadsource";
        $header_data['session'] = $this->session;
        

        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/leadsource/leadsource', $data);
        $footer_data['page'] = "leadsource";
        echo view('include/footer', $footer_data);
    }
    public function LeadSourceList()
    {

        $list = $this->leadsource->get_datatables($_POST);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
                            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['lead_source_id'] . '"  value="' . $key['lead_source_id'] . '" name="lead_source_id[]">
                            <label class="custom-control-label" for="' . $key['lead_source_id'] . '""></label>
                        </div>';
            $row[] = '<th scope="row">' . $key['lead_source_id'] . '</th>';

            $row[] = '<th scope="row">' . $key['lead_source_name'] . '</th>';

            $row[] = '<td>
            <i class="ti-marker-alt mr-2" id= "edit_cat" data-id="' . $key['lead_source_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['lead_source_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->leadsource->count_all($_POST),
            "recordsFiltered" => $this->leadsource->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function delete()
    {
        if (!empty($leadsourceId = $this->request->getPost('deleteLeadsource'))) {
            if ($this->leadsource->deleteLeadsource($leadsourceId)) {
                $output = array(
                    'status' => true,
                    'message' => 'Data Deleted Successfully.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Opps! Something Was Wrong Please Try Again.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'No Categorier Selected.'
            );
        }
        echo json_encode($output);
    }



    public function addleadsource()
    {

        $data = array(
            'lead_source_id'          => $this->request->getPost('lead_source_id'),

            'lead_source_name'          => $this->request->getPost('lead_source_name')

        );

        if ($this->leadsource->insertLeadsource($data)) {
            $output = [
                'status' => true,
                'message' => 'Data Save Successfully.'
            ];
            echo json_encode($output);
        } else {
            $output = [
                'status' => False,
                'message' => 'Opps! Something Was Wrong Please Try Later.'
            ];
            echo json_encode($output);
        }
    }


    public function editleadsource()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->leadsource->getLeadsource($this->request->getPost('editId'))) {
                $data[0]->lead_source_id = explode(" ", $data[0]->lead_source_id);
                $output = [
                    'status' => true,
                    'data' => $data
                ];
            } else {
                $output = [
                    'status' => false,
                    'message' => 'No Data Found.'
                ];
            }
            echo json_encode($output);
        }
    }
}
