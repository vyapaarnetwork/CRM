<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Leadtype_model;




class Leadtype extends BaseController
{
    public $leadtype = null;

    function __construct()
    {
        $this->leadtype = new Leadtype_model();



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
        $header_data['title'] = "LeadType";
        $header_data['session'] = $this->session;
        

        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/leadtype/leadtype', $data);
        $footer_data['page'] = "leadtype";
        echo view('include/footer', $footer_data);
    }
    public function LeadTypeList()
    {

        $list = $this->leadtype->get_datatables($_POST);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
                            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['lead_type_id'] . '"  value="' . $key['lead_type_id'] . '" name="lead_type_id[]">
                            <label class="custom-control-label" for="' . $key['lead_type_id'] . '""></label>
                        </div>';
            $row[] = '<th scope="row">' . $key['lead_type_id'] . '</th>';

            $row[] = '<th scope="row">' . $key['lead_source_name'] . '</th>';

            $row[] = '<td>
            <i class="ti-marker-alt mr-2" id= "edit_cat" data-id="' . $key['lead_type_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['lead_type_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->leadtype->count_all($_POST),
            "recordsFiltered" => $this->leadtype->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function delete()
    {
        if (!empty($leadtypeId = $this->request->getPost('deleteleadtype'))) {
            if ($this->leadtype->deleteleadtype($leadtypeId)) {
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
                'message' => 'No LeadType Selected.'
            );
        }
        echo json_encode($output);
    }



    public function addleadtype()
    {

        $data = array(
            'lead_type_id'          => $this->request->getPost('lead_type_id'),

            'lead_source_name'          => $this->request->getPost('lead_source_name')

        );

        if ($this->leadtype->insertleadtype($data)) {
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


    public function editleadtype()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->leadtype->getleadtype($this->request->getPost('editId'))) {
                $data[0]->lead_type_id = explode(" ", $data[0]->lead_type_id);
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
