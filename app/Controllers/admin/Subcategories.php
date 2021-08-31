<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Notification_model;
use App\Models\Vendor_model;
use App\Models\Categories_model;
use App\Models\Subcategories_model;
use App\Models\VendorDetails_model;

use PHPUnit\Util\Printer;

class Subcategories extends BaseController
{
    public $vendorModel = null;
    public $categoriesModel = null;
    public $subcategoriesModel = null;
    public $notificatinModel = null;
    public $notification = null;
    public $VendorDetailsModel = null;
    function __construct()
    {
        $this->notificatinModel = new Notification_model();
        $this->vendorModel = new Vendor_model();
        $this->categoriesModel = new categories_model();
        $this->subcategoriesModel = new Subcategories_model();
        $this->VendorDetailsModel = new VendorDetails_model();

        if (!empty($this->session->admin)) {
            $this->notification = $this->notificatinModel->getNotification($this->session->admin['sam_id']);
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
        $header_data['title'] = "Subcategories";
        $header_data['session'] = $this->session;
        
        $data['main_cat'] = $this->categoriesModel->getAllcategories();
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/subcategories/subcategories', $data);
        $footer_data['page'] = "subcategories";
        echo view('include/footer', $footer_data);
    }
    public function SubcategoriesList()
    {

       
        $list = $this->subcategoriesModel->get_datatables($_POST);
        
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
                            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['sub_id'] . '"  value="' . $key['sub_id'] . '" name="sub_cat_name[]">
                            <label class="custom-control-label" for="' . $key['sub_id'] . '" style="top: -15px;"></label>
                        </div>';
            $row[] = '<th scope="row">' . $key['sub_id'] . '</th>';
            $row[] = '<th scope="row">' . $key['main_cat_name'] . '</th>';


            $row[] = '<th scope="row">' . $key['sub_cat_name'] . ' </th>';
           
            $row[] = '<td>
            <i class="ti-marker-alt mr-2" id= "edit_cat" data-id="' . $key['sub_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['sub_id'] . '"></i>
            </td>';
            $data[] = $row;
            
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->subcategoriesModel->count_all($_POST),
            "recordsFiltered" => $this->subcategoriesModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function delete()
    {
        if (!empty($subcategoriesId = $this->request->getPost('deleteSubcategories'))) {
            if ($this->subcategoriesModel->deleteSubcategories($subcategoriesId)) {
                $output = array(
                    'status' => true,
                    'message' => 'Status Updated Successfully.'
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
   


    public function addSubcategories()
    {

        $data = array(
            'sub_id'          => $this->request->getPost('sub_id'),

            'sub_cat_name'          => $this->request->getPost('sub_cat_name'),
            'main_cat_name'          => $this->request->getPost('main_cat_name')
 
        );
     
        if ($this->subcategoriesModel->insertSubcategories($data)) {
            $output = [
                'status' => true,
                'message' => 'Admin Data Save Successfully.'
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


    public function editSubcategories()
    {
        
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->subcategoriesModel->getSubcategories($this->request->getPost('editId'))) {
                $data[0]->sub_id = explode(" ", $data[0]->sub_id);
                $data[0]->main_cat_name = explode(" ", $data[0]->main_cat_name);

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
    public function getSubcategories()
    {
        
        if (!empty($this->request->getPost('selected'))) {
            $vendor= json_decode($this->VendorDetailsModel->getCatdetails($this->request->getPost('vendor')));
            // $selcat = json_decode($vendor['vendor_categoriers']);
            if(!empty($vendor)){
            $data['vendor'] = $vendor->sub_cat;
            }
            if ($data['sub_cat'] = $this->subcategoriesModel->selectSubcategories($this->request->getPost('selected'))) {
                // $data[0]->sub_id = explode(" ", $data[0]->sub_id);
                $output = '';
                $output .='  <option value="">Select</option>';
                foreach($data['sub_cat'] as $value)

                {
                //   $output .= '<option value="'.$value['sub_cat_name'].'"'.(!empty($ok)?(($value['sub_cat_name'] == $ok)? ' selected':'' ):"").'>'.$value['sub_cat_name'].'</option>';
                $output .= '
              

                <option value="'.$value['sub_cat_name'].'"';
                if(!empty($data['vendor'])){
                    foreach($data['vendor'] as $vendor){
                        if($value['sub_cat_name'] == $vendor){
                            $output .=  "selected";
                        }
                    }
                 }
               $output .= '>'.$value['sub_cat_name'].'</option>';

                }
            

                echo $output;
               }
               
               
        }
    }
   

}
