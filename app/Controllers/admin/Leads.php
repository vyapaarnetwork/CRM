<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Admin_model;
use App\Models\Leads_model;
use App\Models\Leadstatus_model;
use App\Models\Notification_model;
use App\Models\Vendor_model;
use App\Models\Subcategories_model;
use App\Models\Categories_model;
use App\Models\Leadsource_model;
use App\Models\Customer_model;
use App\Models\VendorDetails_model;
use App\Models\Leadcomment_model;
use App\Models\Leadsaccept_model;
use phpDocumentor\Reflection\Types\Null_;

class Leads extends BaseController
{
    public $adminModel = null;
    public $leadsModel = null;
    public $userModel = null;
    public $vendorModel = null;
    public $notificatinModel = null;
    public $notification = null;
    public $subcategoriesModel = null;
    public $categoriesModel = null;
    public $leadsource = null;
    public $leadstatus = null;
    public $customerModel = null;
    public $VendorDetailsModel = null;
    public $commentmodel = null;
    public $acceptmodel = null;


    function __construct()
    {

        $this->notificatinModel = new Notification_model();
        $this->adminModel = new Admin_model();
        $this->leadsModel = new Leads_model();
        $this->vendorModel = new Vendor_model();
        $this->subcategoriesModel = new Subcategories_model();
        $this->categoriesModel = new Categories_model();
        $this->leadsource = new Leadsource_model();
        $this->leadstatus = new Leadstatus_model();
        $this->customerModel = new Customer_model();
        $this->VendorDetailsModel = new VendorDetails_model();
        $this->commentmodel = new Leadcomment_model();
        $this->acceptmodel = new Leadsaccept_model();


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
        $header_data['title'] = "Leads";
        $header_data['session'] = $this->session;

        $data['lead_source'] = $this->leadsource->getAllLeadsource();
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        $data['sources'] = $this->adminModel->getSources();

        $data['main_cat'] = $this->categoriesModel->getAllcategories();
        $data['country'] = getCountry();
        echo view('admin/leads/leads', $data);
        $footer_data['page'] = "leads";
        echo view('include/footer', $footer_data);
    }

    public function addLeads()
    {


        if ($this->request->getPost('exiting_customer') == 1) {
            $customer = array(
                'customer_name' => $this->request->getPost('customer_name'),
                'customer_email' => $this->request->getPost('customer_email'),
                'customer_phone' => $this->request->getPost('customer_phone'),
                'customer_company' => $this->request->getPost('customer_company'),


                'customer_position' => $this->request->getPost('customer_position'),
            );


            $address = array(
                'address' => $this->request->getPost('customer_address'),
                'city' => $this->request->getPost('customer_city'),
                'state' => $this->request->getPost('customer_state'),
                'zipcode' => $this->request->getPost('customer_zipcode'),
                'country' => $this->request->getPost('customer_country'),

            );
            $customer['customer_address'] = json_encode($address);
            $customer_id = $this->customerModel->insertCustomer($customer);

            $data['lead_customer_id'] = $customer_id;
        } else {
            $data['lead_customer_id'] = $this->request->getPost('lead_customer_id');
        }

        if (is_numeric($this->request->getPost('lead_assign_id'))) {
            $assign_id = $this->request->getPost('lead_assign_id');
        } else {
            $assign_id = NULL;
        }

        $lead = array(
            'lead_id' => $this->request->getPost('lead_id'),

            'lead_customer_id' => $data['lead_customer_id'],
            'lead_maincat_name' => $this->request->getPost('lead_maincat_name'),
            'lead_subcat_name' => $this->request->getPost('lead_subcat_name'),
            'lead_assign_id' => $assign_id,
            'lead_value' => $this->request->getPost('lead_value'),
            'lead_commission' => $this->request->getPost('lead_commission'),

            'lead_source_id' => $this->request->getPost('lead_source_id'),
            'lead_description' => $this->request->getPost('lead_description')

        );
        $leadid = $this->leadsModel->addLead($lead);
        $customer_name = $this->customerModel->getCustomer($data['lead_customer_id']);

        $data = array(
            'lead_m_id' => $leadid
        );
        $this->acceptmodel->acceptleads($data);

        if ($leadid) {

            // Admin Send 
            $email = view('admin/emailTemplate/leadEmailTemplate.php');
            $replace = array(
                '{{siteUrl}}',
                '{{customername}}',
                '{{mainservices}}',
                '{{price}}',
            );
            $replaceWith = array(
                base_url(),
                $customer_name[0]['customer_name'],
                $this->request->getPost('lead_maincat_name'),
                $this->request->getPost('lead_value'),
            );

            $email = str_replace($replace, $replaceWith, $email);

            $setting = settingSiteData();


            send_mail($setting['site_email'], 'Enquiry for' . $this->request->getPost('lead_maincat_name') . ' from Vyapaar Network', $email);
            $message = "Vyapaar Network Enquiry For more details login to https://crm.vyapaar.net For Support call: 8591323637";
            sms_sent($message, $setting['contact_number']);

            // Vendor Send Email

            if (!empty($lead['lead_assign_id'] && is_numberic($lead['lead_assign_id']))) {
                $vendor = $this->vendorModel->getVendor($lead['lead_assign_id']);
                $location = json_decode($customer_name[0]['customer_address']);


                $email = view('admin/emailTemplate/asignleademail_vendor.php');
                $replace = array(
                    '{{siteUrl}}',
                    '{{partner}}',
                    '{{customername}}',
                    '{{service}}',
                    '{{city}}',
                    '{{state}}'
                );
                $replaceWith = array(
                    base_url(),
                    $vendor[0]->vendor_name,
                    $customer_name[0]['customer_name'],
                    $this->request->getPost('lead_maincat_name'),
                    $location->city,
                    $location->state


                );

                $email = str_replace($replace, $replaceWith, $email);

                $setting = settingSiteData();


                send_mail($vendor[0]->vendor_email, 'Enquiry for ' . $this->request->getPost('lead_maincat_name') . ' from Vyapaar Network', $email);
                $message = "Vyapaar Network Enquiry For more details login to https://crm.vyapaar.net For Support call: 8591323637";
                sms_sent($message, $vendor[0]->vendor_phone);

            }


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

    public function listLeads()
    {

        $list = $this->leadsModel->get_datatables($_POST);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {

            $no++;
            $row = array();
            $row[] = '<td> <a href="' . base_url('admin/leadsDetails/' . $key['lead_slug']) . '">' . $key['lead_slug'] . '</td>';
            $row[] = '<td> <a href="' . base_url('admin/customerDetails/' . (!empty($this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_slug']) ? $this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_slug'] : 'None')) . '">' . (!empty($this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_name']) ? $this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_name'] : 'None') . '</td>';
            $row[] = '<td> ' . (!empty($this->leadsource->getLeadsource($key['lead_source_id'])[0]->lead_source_name) ? $this->leadsource->getLeadsource($key['lead_source_id'])[0]->lead_source_name : 'None') . '</td>';
            $row[] = '<td> ' . (!empty($this->vendorModel->getVendor($key['lead_assign_id'])[0]->vendor_name) ? $this->vendorModel->getVendor($key['lead_assign_id'])[0]->vendor_name : '<button class="btn btn-success btn-sm"   onclick="assign_lead(' . $key['lead_id'] . ')">Assign Lead</button>') . '</td>';
            $row[] = '<td> ' . $key['lead_maincat_name'] . '/' . $key['lead_subcat_name'] . '</td>';

            $row[] = '<td> ' . (!empty($this->leadstatus->getStatus($key['lead_status'])[0]->status_name) ? $this->leadstatus->getStatus($key['lead_status'])[0]->status_name : 'None') . '</td>';
            $row[] = '<td> ' . date('d, M Y h:i A', strtotime($key['lead_creted_at'])) . '</td>';
            $row[] = '<td>
                <i class="ti-marker-alt mr-2" data-id="' . $key['lead_id'] . '"></i>
                <i class="ti-trash" data-id="' . $key['lead_id'] . '"></i>
            </td>';
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

    public function delete()
    {
        if (!empty($this->request->getPost('lead_id'))) {
            if ($this->leadsModel->deleteLead($this->request->getPost('lead_id'))) {
                $output = array(
                    'status' => true,
                    'message' => 'data Deleted Successfully.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Opps! Something Was Wrong.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'Nothing To Delete.'
            );
        }
        echo json_encode($output);
    }

    public function leadsDetails($id = null)
    {
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        if (empty($id)) {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'leads'));
        }
        $leads = $this->leadsModel->getLeadDetails($id);
        if (!empty($leads)) {
            $data['leadDetails'] = $leads[0];
        } else {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'leads'));
        }
        $data['customer'] = $this->customerModel->getCustomer($data['leadDetails']['lead_customer_id'])[0];
        $vendor = $this->vendorModel->getVendor($data['leadDetails']['lead_assign_id']);

        if (!empty($vendor)) {
            $data['vendor'] = $vendor[0];
        }
        $data['leadsource'] = $this->leadsource->getLeadsource($data['leadDetails']['lead_source_id']);

        $data['comments'] = $this->commentmodel->getLeadComments($data['leadDetails']['lead_id']);

        if (!empty($data['comments'][0]['vendor_m_id'])) {
            $data['commentsvendor'] = $this->vendorModel->getVendor($data['comments'][0]['vendor_m_id']);
        }
        if (!empty($data['comments'][0]['admin_m_id'])) {
            $data['commentsadmin'] = $this->adminModel->getAdmin($data['comments'][0]['admin_m_id']);
        }
        $data['userdata'] = $this->session->admin;
        $setting = settingSiteData();
        $data['setting'] = $setting;
        $data['lead_status'] = $this->leadstatus->getAllStatus();
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Lead Details";
        $header_data['session'] = $this->session;
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);

        echo view('admin/leads/leadDetails', $data);
        $footer_data['page'] = "leadDetails";
        echo view('include/footer', $footer_data);
    }

    public function getvendor()
    {
        if (!empty($this->request->getPost())) {
            if (!empty($this->request->getPost('id'))) {
                $lead_cat = $this->leadsModel->getLeadData($this->request->getPost('id'))[0];
            } else {
                $lead_cat = $this->request->getPost();
            }

            $vendors['vendors'] = $this->VendorDetailsModel->get_vendors($lead_cat);


            $output = '';
            $output = '<option value="">Select Vendor</option>';
            if (!empty($vendors['vendors'])) {
                foreach ($vendors['vendors'] as $row) {

                    $output .= '<option value="' . $row['vendor_m_id'] . '">' . $row['vendor_name'] . '</option>';
                }
            } else {
                $output .= '<option>No Vendor Found</option>';
            }
            echo $output;
        }
    }

    public function reflead()
    {
        if (!empty($this->request->getPost())) {
            if (!empty($this->request->getPost('id'))) {
                $ref = $this->leadsModel->getLeadData($this->request->getPost('id'))[0];
            }

            if (!empty($ref['lead_by_vendor'])) {
                $output = '<div class="col-md-6 mb-3">
 <div class="form-group"><label class="control-label">Referral Commission</label>
 <input type="text" name="lead_v_commission" id="lead_v_commission" class="form-control" placeholder="Referral Commission"></div>
</div>';
                echo $output;
            }

        }
    }

    public function assign_lead()
    {

        $commission = $this->request->getPost('lead_commission');

        if (!empty($this->request->getPost('lead_v_commission'))) {
            $vendor_commission = $this->request->getPost('lead_v_commission');
        } else {
            $vendor_commission = NULL;
        }
        $lead = array(

            'lead_assign_id' => $this->request->getPost('lead_assign_id'),
            'lead_id' => $this->request->getPost('lead_id'),
            'lead_commission' => $commission,
            'lead_v_commission' => $vendor_commission


        );
        if ($this->leadsModel->addLead($lead)) {

            $lead = $this->leadsModel->getLeadData($this->request->getPost('lead_id'));
            $vendor = $this->vendorModel->getVendor($this->request->getPost('lead_assign_id'));
            $customer_name = $this->customerModel->getCustomer($lead[0]['lead_customer_id']);


            $email = view('admin/emailTemplate/asignleademail.php');
            $replace = array(
                '{{siteUrl}}',
                '{{vendor_name}}',
                '{{mainservices}}',
                '{{token}}'
            );
            $replaceWith = array(
                base_url(),
                $vendor[0]->vendor_name,
                $lead[0]['lead_maincat_name'],
                $lead[0]['lead_slug']

            );

            $email = str_replace($replace, $replaceWith, $email);

            $setting = settingSiteData();


            send_mail($setting['site_email'], 'Enquiry for ' . $lead[0]['lead_maincat_name'] . ' from Vyapaar Network', $email);
            $message = "Vyapaar Network Enquiry For more details login to https://crm.vyapaar.net For Support call: 8591323637";
            sms_sent($message, $setting['contact_number']);

            // Vendor Send Email


            $vendor = $this->vendorModel->getVendor($this->request->getPost('lead_assign_id'));
            $location = json_decode($customer_name[0]['customer_address']);


            $email = view('admin/emailTemplate/asignleademail_vendor.php');
            $replace = array(
                '{{siteUrl}}',
                '{{partner}}',
                '{{customername}}',
                '{{service}}',
                '{{city}}',
                '{{state}}'
            );
            $replaceWith = array(
                base_url(),
                $vendor[0]->vendor_name,
                $customer_name[0]['customer_name'],
                $this->request->getPost('lead_maincat_name'),
                $location->city,
                $location->state


            );

            $email = str_replace($replace, $replaceWith, $email);

            $setting = settingSiteData();


            send_mail($vendor[0]->vendor_email, 'Enquiry for ' . $this->request->getPost('lead_maincat_name') . ' from Vyapaar Network', $email);

            $message = "Vyapaar Network Enquiry For more details login to https://crm.vyapaar.net For Support call: 8591323637";
            sms_sent($message, $vendor[0]->vendor_phone);


            $output = [
                'status' => true,
                'message' => 'Data Save Successfully.'
            ];
        } else {
            $output = [
                'status' => False,
                'message' => 'Ops! Something Was Wrong Please Try Later.'
            ];
        }
        echo json_encode($output);
    }

    public function add_comments()
    {

        $data = array(
            'comments' => $this->request->getPost('comments'),

            'admin_m_id' => $this->session->admin['admin_slug'],
            'lead_m_id' => $this->request->getPost('lead_m_id'),

        );

        if ($this->commentmodel->leadcomment($data)) {
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

    public function change_status()
    {

        $data = array(
            'lead_status' => $this->request->getPost('lead_status'),

            'lead_id' => $this->request->getPost('lead_id'),

        );

        if ($this->leadsModel->change_status($data)) {
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


    public function reportleads()
    {

        $setting = settingSiteData();
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Leads";
        $header_data['session'] = $this->session;

        $data['lead_source'] = $this->leadsource->getAllLeadsource();
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        $data['sources'] = $this->adminModel->getSources();

        $data['main_cat'] = $this->categoriesModel->getAllcategories();

        echo view('admin/leads/reportlead', $data);
        $footer_data['page'] = "reportlead";
        echo view('include/footer', $footer_data);
    }

    public function exportCSV()
    {
        // file name 

        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        $qurey = array(

            'table' => array('tblleads_master'),
            'select' => array('lead_creted_at', 'lead_slug', 'tblvendor_master.vendor_name', 'tblvendor_master.vendor_phone', 'tblvendor_master.vendor_email', 'lead_subcat_name', 'tblcustomer_master.customer_name', 'tblcustomer_master.customer_phone', 'tblcustomer_master.customer_email', 'lead_value', 'lead_status'),
            'join' => array('tblvendor_master' => 'tblvendor_master.vendor_id = tblleads_master.lead_assign_id', 'tblcustomer_master' => 'tblcustomer_master.customer_id = tblleads_master.lead_customer_id'),

            'return' => '1'
        );

        $leads = get_dbdata($qurey);

        $leaddata = $leads->getResultArray();


        foreach ($leaddata as $key) {

            $row = array();
            $row[] = $key['lead_creted_at'];
            $row[] = $key['lead_slug'];
            $row[] = $key['vendor_name'];
            $row[] = $key['vendor_phone'];
            $row[] = $key['vendor_email'];
            $row[] = $key['lead_subcat_name'];
            $row[] = $key['customer_name'];
            $row[] = $key['customer_phone'];
            $row[] = $key['customer_email'];
            $row[] = $key['lead_value'];
            $row[] = $this->leadstatus->getStatus($key['lead_status'])[0]->status_name;


            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $leads->resultID->num_rows,
            "recordsFiltered" => $leads->resultID->num_rows,

            'data' => $data
        );

        echo json_encode($output);
    }

    public function leadFile()
    {

        if ($imageFile = $this->request->getFile('lead_documents')) {
            $lead['lead_documents'] = $imageFile->getRandomName();
            $lead['lead_id'] = $this->request->getPost('lead_id');
            if ($imageFile->move(LEADS_DOCUMENT_PATH, $lead['lead_documents'])) {

                $result = $this->leadsModel->addLead($lead);


                $output = [
                    'error' => '0',
                    'message' => ''
                ];

                echo json_encode($output);
            }
        }
    }

    public function getState()
    {
        if ($this->request->getPost('country_id')) {
            if ($state = getdbState($this->request->getPost('country_id'))) {
                foreach ($state as $states) {
                    $output = '<option value ="' . $states->name . '">' . $states->name . '</option>';
                    echo $output;
                }
            } else {
                $output = '<option value="">No Data Found</option>';
                echo $output;
            }

        } else {
            $output = '<option value="">Select Country First</option>';
            echo $output;
        }

    }

    public function getCity()
    {

        if ($this->request->getPost('customer_state')) {
            if ($city = getdbCity($this->request->getPost('customer_state'))) {
                foreach ($city as $cities) {
                    $output = '<option value ="' . $cities->name . '">' . $cities->name . '</option>';
                    echo $output;
                }
            } else {
                $output = '<option value="">No Data Found</option>';
                echo $output;
            }

        } else {
            $output = '<option value="">Select State First</option>';
            echo $output;
        }

    }
}
