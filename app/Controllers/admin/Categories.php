<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Notification_model;
use App\Models\Vendor_model;
use App\Models\Categories_model;

class Categories extends BaseController
{
    public $vendorModel = null;
    public $categoriesModel = null;
    public $notificatinModel = null;
    public $notification = null;
    function __construct()
    {
        $this->notificatinModel = new Notification_model();
        $this->vendorModel = new Vendor_model();
        $this->categoriesModel = new Categories_model();
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
        $header_data['title'] = "categories";
        $header_data['session'] = $this->session;
        

        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/categories/categories', $data);
        $footer_data['page'] = "categories";
        echo view('include/footer', $footer_data);
    }
    public function categoriesList()
    {

        $list = $this->categoriesModel->get_datatables($_POST);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
                            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['main_cat_id'] . '"  value="' . $key['main_cat_id'] . '" name="cat_name[]">
                            <label class="custom-control-label" for="' . $key['main_cat_id'] . '""></label>
                        </div>';
            $row[] = '<th scope="row">' . $key['main_cat_id'] . '</th>';

            $row[] = '<th scope="row">' . $key['cat_name'] . '</th>';

            $row[] = '<td>
            <i class="ti-marker-alt mr-2" id= "edit_cat" data-id="' . $key['main_cat_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['main_cat_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->categoriesModel->count_all($_POST),
            "recordsFiltered" => $this->categoriesModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function delete()
    {
        if (!empty($categoriesId = $this->request->getPost('deletecategories'))) {
            if ($this->categoriesModel->deletecategories($categoriesId)) {
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



    public function addcategories()
    {

        $data = array(
            'main_cat_id'          => $this->request->getPost('main_cat_id'),

            'cat_name'          => $this->request->getPost('cat_name')

        );

        if ($this->categoriesModel->insertcategories($data)) {
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


    public function editcategories()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->categoriesModel->getcategories($this->request->getPost('editId'))) {
                $data[0]->main_cat_id = explode(" ", $data[0]->main_cat_id);
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
