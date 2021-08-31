<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Leadstatus_model;




class Leadstatus extends BaseController
{
    public $leadstatus = null;


    function __construct()
    {

        $this->leadstatus = new Leadstatus_model();



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
        $header_data['title'] = "Lead Status";
        $header_data['session'] = $this->session;

        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/leadstatus/leadstatus', $data);
        $footer_data['page'] = "LeadStatus";
        echo view('include/footer', $footer_data);
    }
    public function LeadStatusList()
    {

        $list = $this->leadstatus->get_datatables($_POST);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
                            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['status_id'] . '"  value="' . $key['status_id'] . '" name="status_id[]">
                            <label class="custom-control-label" for="' . $key['status_id'] . '""></label>
                        </div>';
            $row[] = '<th scope="row">' . $key['status_id'] . '</th>';

            $row[] = '<th scope="row">' . $key['status_name'] . '</th>';

            $row[] = '<td>
            <i class="ti-marker-alt mr-2" id= "edit_cat" data-id="' . $key['status_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['status_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->leadstatus->count_all($_POST),
            "recordsFiltered" => $this->leadstatus->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function StatusDelete()
    {
        if (!empty($leadStatusID = $this->request->getPost('deleteStatus'))) {
            if ($this->leadstatus->deleteStatus($leadStatusID)) {
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
                'message' => 'No Status Selected.'
            );
        }
        echo json_encode($output);
    }



    public function addStatus()
    {

        $data = array(
            'status_id'          => $this->request->getPost('status_id'),

            'status_name'          => $this->request->getPost('status_name')

        );

        if ($this->leadstatus->insertStatus($data)) {
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


    public function editStatus()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->leadstatus->getStatus($this->request->getPost('editId'))) {
//                $data[0]->status = explode(" ", $data[0]->status);
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
