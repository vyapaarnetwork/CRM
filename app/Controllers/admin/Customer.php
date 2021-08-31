<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Customer_model;
use App\Models\Leads_model;



class Customer extends BaseController
{
    public $customerModel = null;
    public $leadsModel = null;

    function __construct()
    {
        $this->customerModel = new Customer_model();
        $this->leadsModel = new Leads_model();




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
        $header_data['title'] = "Customers";
        $header_data['session'] = $this->session;
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        $data['country'] = getCountry();

        echo view('admin/customer/customer', $data);
        $footer_data['page'] = "customers";
        echo view('include/footer', $footer_data);
    }
    public function customerList()
    {
        $list = $this->customerModel->get_datatables($_POST);


        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =   '<div class="custom-control custom-checkbox text-center">
            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['customer_id'] . '"  value="' . $key['customer_id'] . '" name="customer_slug[]">
            <label class="custom-control-label" for="' . $key['customer_id'] . '""></label>
        </div>';
            $row[] = '<th scope="row"><a href="' . base_url('admin/customerDetails/' . $key['customer_slug']) . '">' . $key['customer_name'] . '</a> </th>';
            $row[] = '<td>' . $key['customer_email'] . "</td>";

            $row[] = '<td>' . $key['customer_phone'] . "</td>";
            $row[] = '<td>' . $key['customer_company'] . "</td>";
            $row[] = '<td>' . $key['customer_created_at'] . "</td>";



            $row[] = '<td>
            <i class="ti-marker-alt mr-2" data-id="' . $key['customer_id'] . '"></i>

                <i class="ti-trash" data-id="' . $key['customer_id'] . '"></i>
            </td>';

            $data[] = $row;
        }
        $output =
            array(
                "draw" => $_POST['draw'],
                "recordsTotal" => $this->customerModel->count_all($_POST),
                "recordsFiltered" => $this->customerModel->count_filtered($_POST),
                "data" => $data,
            );
        echo json_encode($output);
    }

    public function checkEmail($id = null)
    {

        $count = $this->customerModel->checkEmailExists($this->request->getPost('val'), $id);

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

    public function addCustomer($id = null)
    {
        $data = array(
            'customer_name'          => $this->request->getPost('name'),
            'customer_email'         => $this->request->getPost('email'),
            'customer_phone'     => $this->request->getPost('mobileNo'),
            'customer_company'     => $this->request->getPost('customer_company'),


            'customer_position'     => $this->request->getPost('customer_position'),
        );


        // if (empty($id)) {
        //     $New_slug = random_string('sha1', 5);
        //     $i = 1;
        //     for ($i = 0; $i >= $i; $i++) {
        //         if ($this->customerModel->checkSlug($New_slug) != 0) {
        //             $New_slug = random_string('sha1', 5);
        //         } else {
        //             break;
        //         }
        //     }
        //     $data['customer_slug'] = $New_slug;
        // }
        $address = array(
            'address' => $this->request->getPost('address'),
            'city' => $this->request->getPost('city'),
            'state' => $this->request->getPost('state'),
            'zipcode' => $this->request->getPost('zipcode'),
            'country' => $this->request->getPost('country'),

        );
        $data['customer_address'] = json_encode($address);

        if ($this->customerModel->insertCustomer($data, (!empty($id) ? $id : null))) {
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
    public function editData()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->customerModel->getCustomer($this->request->getPost('editId'))) {
                $data[0]->customer_name = explode(" ", $data[0]->customer_name);


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
        if (!empty($customerId = $this->request->getPost('deleteCustomer'))) {
            if ($this->customerModel->deleteCustomer($customerId)) {
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
    public function details($slug = null)
    {
        if (empty($slug)) {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'vendor'));
        }
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        $data['customer'] = $this->customerModel->getCustomerBySlug($slug);
        $header_data['title'] = "Customer Details";



        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['session'] = $this->session;
        


        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/customer/customerDetails', $data);
        $footer_data['page'] = "customerDetails";
        echo view('include/footer', $footer_data);
    }

    public function get_customer()
    {
        if (!empty($this->request->getPost())) {

            $data['post_data'] = $this->request->getPost('searchTerm');
            if(!empty($this->session->vendor)) {
               $customer  = $this->leadsModel->getVendorClient();
               if(!empty($customer[0]->lead_customer_id)){
                   $data['customer_id'] = $customer[0]->lead_customer_id;

               }else{
                   $data['customer_id'] = '';
               }
                       }
            $customer['get_customer'] = $this->customerModel->getSearch($data);

   
        echo json_encode($customer['get_customer']);



        }

    
    }
}
