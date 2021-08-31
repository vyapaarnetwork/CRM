<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Vendor_model;
use App\Models\VendorDetails_model;
use App\Models\Categories_model;
use App\Models\Subcategories_model;

class Vendor extends BaseController
{
    public $vendorModel = null;
    public $VendorDetailsModel =null;
    public $categoriesModel = null;
    public $subcategoriesModel = null;

    function __construct()
    {
        $this->vendorModel = new Vendor_model();
        $this->VendorDetailsModel = new VendorDetails_model();

        $this->categoriesModel = new Categories_model();
        $this->subcategoriesModel = new Subcategories_model();


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
        $header_data['title'] = "Vendor";
        $header_data['session'] = $this->session;
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/vendor/vendor', $data);
        $footer_data['page'] = "Vendor";
        echo view('include/footer', $footer_data);
    }
    public function vendorList()
    {
        $list = $this->vendorModel->get_datatables($_POST);


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $verify = unserialize($key['vendor_verifed']);
            $no++;
            $row = array();
            $row[] =   '<div class="custom-control custom-checkbox text-center">
            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['vendor_id'] . '"  value="' . $key['vendor_id'] . '" name="admin_slug[]">
            <label class="custom-control-label" for="' . $key['vendor_id'] . '""></label>
        </div>';
            $row[] = '<th scope="row"><a href="' . base_url('admin/VendorDetails/' . $key['vendor_slug']) . '">' . $key['vendor_name'] . '</a> </th>';
            $row[] = '<td> ' . $key['vendor_username'] . ' </td>';
            $row[] = '<td>' . $key['vendor_email'] . (($verify['email'] == '1') ? " <i class='fas fa-check-circle text-success' title='Email Verified'></i>" : " <i class='fas fa-times-circle text-danger' title='Email Not Verified'></i>") . "</td>";
            $row[] = '<td>' . $key['vendor_phone'] . (($verify['mobile'] == '1') ? " <i class='fas fa-check-circle text-success' title='Mobile Verified'></i>" : " <i class='fas fa-times-circle text-danger' title='Mobile Not Verified'></i>") . "</td>";

            $row[] = '<td> ' . ucfirst(str_replace('_', ' ', $key['vendor_status'])) . ' </td>';
            $row[] = '<td>
            <i class="ti-marker-alt mr-2" data-id="' . $key['vendor_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['vendor_id'] . '"></i>
            </td>';

            $data[] = $row;
        }
        $output =
            array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->vendorModel->count_all($_POST),
                "recordsFiltered" => $this->vendorModel->count_filtered($_POST),
                "data" => $data,
            );
        echo json_encode($output);
    }
    public function checkUserName($id = null)
    {
        $count = $this->vendorModel->checkUserNameExists($this->request->getPost('val'), $id);
        if ($count == 0) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function checkEmail($id = null)
    {

        $count = $this->vendorModel->checkEmailExists($this->request->getPost('val'), $id);

        if ($count == 0) {
            $output = [
                'status' => true,
                'message' => 'Email Is Valid.'
            ];
            echo json_encode($output);
        } else {
            $output = [
                'status' => false,
                'message' => 'Email Is Not Valid. Please Try Something Different.'
            ];
            echo json_encode($output);
        }
    }
    public function checkPhoneNo($id = null)
    {
        $count = $this->vendorModel->checkPhoneNoExists($this->request->getPost('val'), $id);

        if ($count == 0) {
            $output = [
                'status' => true,
                'message' => 'Mobile Number Is Valid.'
            ];
            echo json_encode($output);
        } else {
            $output = [
                'status' => false,
                'message' => 'Mobile Number Is Not Valid. Please Try Something Different.'
            ];
            echo json_encode($output);
        }
    }

    public function addVendor($id = null)
    {

        $data = array(
            'vendor_name'          => $this->request->getPost('vendor_name'),
            'vendor_username'     => $this->request->getPost('vendor_username'),
            'vendor_email'         => $this->request->getPost('vendor_email'),
            'vendor_password'      => md5($this->request->getPost('vendor_password')),
            'vendor_phone'     => $this->request->getPost('vendor_phone'),
            'vendor_status' => $this->request->getPost('vendor_status'),
        );
        if (!empty($this->request->getPost('vendor_id'))) {
            $id = $this->request->getPost('vendor_id');
        }        
        if (empty($id)) {
            $New_slug =  rand(11000, 70000);
            $i = 1;
            for ($i = 0; $i >= $i; $i++) {
                if ($this->vendorModel->checkSlug($New_slug) != 0) {
                    $New_slug = rand(11000, 70000);
                } else {
                    break;
                }
            }
            $data['vendor_slug'] = $New_slug;
        }
        $verify = array(
            'email' => '0',
            'mobile' => '0'
        );
        $data['vendor_verifed'] = serialize($verify);

       
       
        if (empty($data['vendor_password'])) {
            unset($data['vendor_password']);
        }
        

        if ($this->vendorModel->insertVendor($data, (!empty($id) ? $id : null))) {
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
    public function editData()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->vendorModel->getVendor($this->request->getPost('editId'))) {
                $data[0]->vendor_name = explode(" ", $data[0]->vendor_name);


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
    public function getcomm()
    {
        if (!empty($this->request->getPost('getcomm'))) {
            if ($data = $this->VendorDetailsModel->getcomm($this->request->getPost('getcomm'))) {
                // $data[0]->vendor_name = explode(" ", $data[0]->vendor_name);


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

    public function delete()
    {
        if (!empty($vendorId = $this->request->getPost('deleteVendor'))) {
            if ($this->vendorModel->deleteVendor($vendorId)) {
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
                'message' => 'No Vendor Selected.'
            );
        }
        echo json_encode($output);
    }
    public function VendorStatus()
    {
        if (!empty($this->request->getPost())) {
            if ($this->vendorModel->updateStatus($this->request->getPost('editVendor'), $this->request->getPost('status'))) {
                $output = array(
                    'status' => true,
                    'message' => 'Vendor Update Successfully.'
                );
            } else {
                $output = array(
                    'status' => true,
                    'message' => 'Opps! Something Was Wrong.'
                );
            }
        } else {
            $output = array(
                'status' => true,
                'message' => 'No Vendor Found.'
            );
        }
        echo json_encode($output);
    }

    public function vendorcompany()
    {
        if (!empty($this->request->getPost())) {

            $bankdata = array(
                'bankname' =>  $this->request->getPost('bank_name'),
                'bankaccountnumber' =>  $this->request->getPost('bank_number'),
                'ifsccode' =>  $this->request->getPost('ifsc_code'),
            );
            $cat = array(
                'main_cat' => $this->request->getPost('main_cat'),
                'sub_cat' => $this->request->getPost('sub_cat'),
            );


            $slug = $this->request->getPost('vendor_slug');            
            $data = array(
                'vendor_m_id' => $this->request->getPost('vendor_m_id'),
                'vendor_type' =>  $this->request->getPost('vendor_type'),
                'vendor_compnay' =>  $this->request->getPost('vendor_compnay'),
                'vendor_pancard' =>  $this->request->getPost('vendor_pancard'),

                'vendor_gst' =>  $this->request->getPost('vendor_gst'),
                'vendor_cin' =>  $this->request->getPost('vendor_cin'),
                'vendor_commission' =>  $this->request->getPost('vendor_commission'),


                'vendor_bankdetails' =>  json_encode($bankdata),
                'vendor_categoriers' =>  json_encode($cat)
            );
         
            if ($this->VendorDetailsModel->vendorcompany($data)) {
                $output = array(
                    'status' => true,
                    'message' => 'Vendor Update Successfully.'
                );
            } else {
                $output = array(
                    'status' => true,
                    'message' => 'Opps! Something Was Wrong.'
                );
            }
        } else {
            $output = array(
                'status' => true,
                'message' => 'No Vendor Found.'
            );
        }
        echo json_encode($output);
        return redirect()->to(base_url('admin/VendorDetails/'.$slug));



    }
    public function vendorcat()
{
    $vendor_m_id = $this->request->getPost('vendor_id');
    $get_cat = $this->VendorDetailsModel->get_cat($vendor_m_id);
    $cat = unserialize($get_cat);
    print_r(implode(",",$cat['main_cat']));die;
    echo  str_replace('"', '', $cat);
}


    public function details($slug = null)
    {
        if (empty($slug)) {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'vendor'));
        }
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        $data['vendor'] = $this->vendorModel->getVendorBySlug2($slug);
        if (!empty($data['vendor'])) {
            $header_data['title'] = "Vendor Details";
        } else if (empty($data['vendor'])) {
            $data['slaes'] = $this->salesModle->getSaleBySlug($slug);
            $header_data['title'] = "Sales Associate Details";
        } else {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'vendor'));
        }
        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['session'] = $this->session;
        $data['main_cat'] =  $this->categoriesModel->getAllcategories();
        $data['sub_cat'] =  $this->subcategoriesModel->getAllSubcat();

        $vendorId = $this->vendorModel->getUserBySlug($slug);

        
        $data['vendor_details'] = $this->VendorDetailsModel->getDetails($vendorId);


        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/vendor/vendorDetails', $data);
        $footer_data['page'] = "vendorDetails";
        echo view('include/footer', $footer_data);
    }
   
}
