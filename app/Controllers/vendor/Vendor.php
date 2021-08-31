<?php

namespace App\Controllers\vendor;

use App\Controllers\BaseController;
use App\Models\Vendor_model;
use App\Models\Leads_model;
use App\Models\Leadcomment_model;
use App\Models\Leadsource_model;
use App\Models\Customer_model;
use App\Models\Admin_model;
use App\Models\Leadsaccept_model;
use App\Models\Categories_model;
use App\Models\Leadstatus_model;
use CodeIgniter\I18n\Time;


class Vendor extends BaseController
{
    public $vendorModel = null;
    public $adminModel = null;
    public $leadsModel = null;
    public $leadsource = null;
    public $commentmodel = null;
    public $customerModel = null;
    public $acceptmodel = null;
    public $categoriesModel = null;
    public $leadstatus = null;


    function __construct()
    {
        $this->vendorModel = new Vendor_model();
        $this->leadsModel = new Leads_model();
        $this->commentmodel = new Leadcomment_model();
        $this->leadsource = new Leadsource_model();
        $this->customerModel = new Customer_model();
        $this->adminModel = new Admin_model();
        $this->acceptmodel = new Leadsaccept_model();
        $this->categoriesModel = new Categories_model();
        $this->leadstatus = new Leadstatus_model();

    }

    public function index()
    {
        if (empty($this->session->vendor)) {

            $setting = settingSiteData();
            $data['setting'] = $setting;
            $header_data['setting'] = $setting;
            $footer_data['setting'] = $setting;
            $header_data['title'] = "Login";
            $data['header'] = view('include/header', $header_data);
            $footer_data['page'] = "vendor_login";
            $data['footer'] = view('include/footer', $footer_data);
            return view('login/auth_vendor', $data);
        } else {
            return redirect()->to(menuUrl('vendor', 'home'));
        }
    }

    public function home()
    {
        if (empty($this->session->vendor)) {
            return redirect()->to(base_url('vendor'));
        }

        // Lead Count
        $query = [
            'table' => ['tblleads_master'],
            'where' => ['lead_assign_id' => $this->session->vendor['vendor_id']],
            'whereIn' => ['lead_status' => ['accept', '1']],
            'count' => '1',
        ];

        $data['tlleads'] = get_dbdata($query);


        // Proposal Leads
        $query = array(
            'table' => ['tblleads_master'],
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '4'),
            'count' => '1',
        );

        $data['tlproposal'] = get_dbdata($query);

        // qualification Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '2'),
            'count' => '1',
        );

        $data['tlqualification'] = get_dbdata($query);


        // need_analysis Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '4'),
            'count' => '1',
        );

        $data['tlneed_analysis'] = get_dbdata($query);


        // Negotiation/Review
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '5'),
            'count' => '1',
        );

        $data['tlnego'] = get_dbdata($query);

        // Lost Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '7'),
            'count' => '1',
        );

        $data['tlclleads'] = get_dbdata($query);

        // Won Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '6'),
            'count' => '1',
        );

        $data['tlwonleads'] = get_dbdata($query);


        $query = array(
            'table' => array('tblleads_master'),
            'select' => array('sum(lead_value)'),
            'where' => array('lead_assign_id' => $this->session->vendor['vendor_id'], 'lead_status' => '6'),

        );

        $data['tlrevanue'] = get_dbdata($query);


        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Dashboard";
        $header_data['model'] = 'Admin';
        $header_data['session'] = $this->session;
        $data['header'] = view('include/header', $header_data);
        $data['adminMenu'] = view('include/v_menu_bar', $header_data);
        $footer_data['page'] = "vendor_dashboard";
        $data['footer'] = view('include/footer', $footer_data);
        return view('vendor/dashboard/vendor_dashboard', $data);
    }

    public function vendor_check()
    {

        $vendor = $this->vendorModel->chechVendorAuth($_POST['user_address'], $_POST['password']);
        if (count($vendor) > 0) {
            $this->session->set("vendor", $vendor[0]);
            $return = array(
                "status" => true,
                'message' => 'Login Successfull.',
                'url' => menuUrl('vendor', 'home')
            );
            echo json_encode($return);
            return;
        } else {
            $return = array(
                'status' => False,
                'message' => "Email Address Or Password Is Not Valid."
            );
            echo json_encode($return);
            return;
        }
    }

    public function vendor_logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('vendor'));
    }

    /**
     * @return string
     * Author : Karan Mankodiya
     * Date: 19-08-21
     * Vendor Password Reset Section Start
     */

    public function forget_pass()
    {
        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Password Reset";
        $data['header'] = view('include/header', $header_data);
        $footer_data['page'] = "pass_forget";
        $data['footer'] = view('include/footer', $footer_data);
        return view('login/recover_pass', $data);
    }


    public function forgotPassword()
    {
        if (!empty($this->request->getPost())) {

            $vendor = $this->vendorModel->getVendorForgot($this->request->getPost('vendor_email'));
            if ($vendor) {
                $query = array(
                    'table' => array('tblvendor_forget'),
                    'data' => array(
                        'vendor_m_id' => $vendor[0]['vendor_id'],
                        'forget_token' => bin2hex(random_bytes(18)),
                    ));

                $data = add_dbdata($query);

                $email = view('vendor/emailTemplate/passwordReset.php');
                $replace = array(
                    '{siteUrl}',


                );
                $replaceWith = array(
                    base_url().'/vendor/reset-password?code='.$query['data']['forget_token'],



                );

                $email = str_replace($replace, $replaceWith, $email);
                send_mail($this->request->getPost('vendor_email'), 'Reset your password', $email);



                $output = array(
                    'status' => true,
                    'message' => 'Password Reset Link Shared on Email ID.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'User Not Found'
                );
            }
            echo json_encode($output);


        }
        else{
            $output = array(
                'status' => false,
                'message' => 'Invalid Inputs'
            );
            echo json_encode($output);
        }
    }
    public function resetPassword(){
        if($this->request->getGet()) {



            $setting = settingSiteData();
            $data['setting'] = $setting;
            $header_data['setting'] = $setting;
            $footer_data['setting'] = $setting;
            $header_data['title'] = "Password Reset";
            $data['header'] = view('include/header', $header_data);
            $footer_data['page'] = "pass_forget";
            $data['footer'] = view('include/footer', $footer_data);
            $token = $this->request->getGet('code');

            $query = array(
                'table' => array('tblvendor_forget'),
                'where' => array('forget_token' => $token),
                             );

            $data['forget_data'] = get_dbdata($query);
            if($data['forget_data']->resultID->num_rows > 0) {
                $create = Time::parse($data['forget_data']->getResultObject()[0]->create_at);
                $current = new Time('now');
                $diff = $create->difference($current);
                $data['forget_m_data'] = $data['forget_data']->getResultObject()[0];

                if($diff->getHours() < 2 ) {
                         return view('login/password', $data);
                 }
                 else{
                     return view('login/expired', $data);
                 }

            }
            else{
                return view('login/expired', $data);
            }

        }
        elseif($this->request->getPost()){

            $new_pass = $this->request->getPost('new_pass');
            $token = $this->request->getPost('token');

            $query = array(
                'table' => array('tblvendor_forget'),
                'where' => array('forget_token' => $token),
            );

            $data['forget_data'] = get_dbdata($query);
            if($data['forget_data']->resultID->num_rows > 0) {
                $create = Time::parse($data['forget_data']->getResultObject()[0]->create_at);
                $current = new Time('now');
                $diff = $create->difference($current);
                if($diff->getHours() < 2 ) {

                    $vendor_data = array('vendor_password' => md5($new_pass));

                    $query = array(
                        'table' => array('tblvendor_master'),
                        'where' => array('vendor_id' => $data['forget_data']->getResultObject()[0]->vendor_m_id),
                        'data' => $vendor_data
                    );
                    if(edit_dbdata($query)){
                        $output = array(
                            'status' => true,
                            'message' => 'Password Updated.'
                        );
                        $query = array(
                            'table' => array('tblvendor_forget'),
                            'where' => array('forget_token' => $token),
                        );
                        del_dbdata($query);

                        echo json_encode($output);
                    }
                    else{
                        $output = array(
                            'status' => false,
                            'message' => 'Invalid Data,Reset Again.'
                        );
                        echo json_encode($output);
                    }

                }
                else{
                    $output = array(
                        'status' => false,
                        'message' => 'Invalid Data,Reset Again.'
                    );
                    echo json_encode($output);
                }


            }else {
                $output = array(
                    'status' => false,
                    'message' => 'Invalid Data,Reset Again.'
                );
                echo json_encode($output);
            }




        }
        else{
            die('Opps...Something Wrong..');

        }

    }

    /**
     * @return \CodeIgniter\HTTP\RedirectResponse
     * Author : Karan Mankodiya
     * Create Date: 19-08-21
     * Update Date : -
     * Vendor Lead Section
     */

    public function leads()
    {


        $setting = settingSiteData();
        if (empty($this->session->vendor)) {
            return redirect()->to(menuUrl('vendor'));
        }
        $this->session->remove('refer');
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Leads";
        $header_data['session'] = $this->session;
        $data['lead_source'] = $this->leadsource->getAllLeadsource();
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/v_menu_bar', $header_data);
        // $data['sources'] = $this->adminModel->getSources();

        $data['main_cat'] = $this->categoriesModel->getAllcategories();
        echo view('vendor/leads/lead_vendor', $data);
        $footer_data['page'] = "v_leads";
        echo view('include/footer', $footer_data);
    }

    public function referrallead()
    {


        $setting = settingSiteData();
        if (empty($this->session->vendor)) {
            return redirect()->to(menuUrl('vendor'));
        }
        $this->session->set("refer", array('refer' => '1'));
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "ReferralLead";
        $header_data['session'] = $this->session;
        $data['lead_source'] = $this->leadsource->getAllLeadsource();
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/v_menu_bar', $header_data);
        // $data['sources'] = $this->adminModel->getSources();

        $data['main_cat'] = $this->categoriesModel->getAllcategories();
        echo view('vendor/leads/lead_vendor', $data);
        $footer_data['page'] = "v_leads";
        echo view('include/footer', $footer_data);
    }

    public function listLeads()
    {

        $list = $this->leadsModel->get_datatables($_POST);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {

            $no++;
            $row = array();
            $row[] = '<td> <a href="' . base_url('vendor/leadsDetails/' . $key['lead_slug']) . '">' . $key['lead_slug'] . '</td>';
            $row[] = '<td> ' . (!empty($this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_name']) ? $this->customerModel->getCustomer($key['lead_customer_id'])[0]['customer_name'] : 'None') . '</td>';
            $row[] = '<td> ' . (!empty($this->leadsource->getLeadsource($key['lead_source_id'])[0]->lead_source_name) ? $this->leadsource->getLeadsource($key['lead_source_id'])[0]->lead_source_name : 'None') . '</td>';
            $row[] = '<td> ' . $key['lead_maincat_name'] . '/' . $key['lead_subcat_name'] . '</td>';

            $row[] = '<td> ' . (!empty($this->leadstatus->getStatus($key['lead_status'])[0]->status_name) ? $this->leadstatus->getStatus($key['lead_status'])[0]->status_name : 'None') . '</td>';

            $row[] = '<td> ' . date('d, M Y h:i A', strtotime($key['lead_creted_at'])) . '</td>';

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

    public function leadsDetails($id = null)
    {

        if (empty($this->session->vendor)) {
            return redirect()->to(menuUrl('vendor'));
        }

        if (empty($id)) {
            return redirect()->to(menuUrl('vendor', 'leads'));
        }
        $hasaccess = $this->leadsModel->hasaccess($id);
        if ($hasaccess <= 0) {
            $this->session->set("flashdata", array('status' => 'error', 'msg' => "You Don't have access to this lead."));

            return redirect()->to(menuUrl('vendor', 'leads'));
        }
        $leads = $this->leadsModel->getLeadDetails($id);
        if (!empty($leads)) {
            $data['leadDetails'] = $leads[0];
        } else {
            return redirect()->to(menuUrl('vendor', 'leads'));
        }
        $data['customer'] = $this->customerModel->getCustomer($data['leadDetails']['lead_customer_id'])[0];
        $vendor = $this->vendorModel->getVendor($data['leadDetails']['lead_assign_id']);

        if (!empty($vendor)) {
            $data['vendor'] = $vendor[0];
        }
        $data['leadsource'] = $this->leadsource->getLeadsource($data['leadDetails']['lead_source_id']);

        $data['comments'] = $this->commentmodel->getLeadComments($data['leadDetails']['lead_id']);


        $data['accept'] = $this->acceptmodel->getacceptleads($leads[0]['lead_id']);

        $data['userdata'] = $this->session->vendor;
        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Lead Details";
        $data['lead_status'] = $this->leadstatus->getAllStatus();

        $header_data['session'] = $this->session;

        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/v_menu_bar', $header_data);

        echo view('vendor/leads/leadDetails', $data);
        $footer_data['page'] = "v_leadDetails";
        echo view('include/footer', $footer_data);
    }

    public function accept_lead()
    {

        $data = array(

            'lead_m_id' => $this->request->getPost('lead_id'),
            'vendor_m_id' => $this->session->vendor['vendor_slug']

        );


        if ($this->acceptmodel->accept_lead($data)) {
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

    public function add_comments()
    {

        $data = array(
            'comments' => $this->request->getPost('comments'),

            'vendor_m_id' => $this->session->vendor['vendor_slug'],
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


    // Vendor Lead Add


    public function addLeads()
    {

        if ($this->request->getPost('exiting_customer') == 1) {
            $customer = array(
                'customer_name'          => $this->request->getPost('customer_name'),
                'customer_email'         => $this->request->getPost('customer_email'),
                'customer_phone'     => $this->request->getPost('customer_phone'),
                'customer_company'     => $this->request->getPost('customer_company'),


                'customer_postition'     => $this->request->getPost('customer_postition'),
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
        if(!empty($this->request->getPost('self_assign'))){
            $assign_id = $this->session->vendor['vendor_id'];
            $vendorBy = null;

        }
        else{
            $assign_id = null;
            $vendorBy = $this->session->vendor['vendor_id'];
        }


        $lead = array(
            'lead_id' => $this->request->getPost('lead_id'),

            'lead_customer_id' => $data['lead_customer_id'],
            'lead_maincat_name' => $this->request->getPost('lead_maincat_name'),
            'lead_subcat_name' => $this->request->getPost('lead_subcat_name'),
            'lead_by_vendor' => $vendorBy,
            'lead_value' => $this->request->getPost('lead_value'),

            'lead_source_id' => '3',
            'lead_description' => $this->request->getPost('lead_description'),
            'lead_assign_id' => $assign_id

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

            if (!empty($lead['lead_assign_id'])) {
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
}
