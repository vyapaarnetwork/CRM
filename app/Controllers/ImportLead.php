<?php

namespace App\Controllers;

use App\Models\Admin_model;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Leads_model;
use App\Models\Customer_model;

class ImportLead extends ResourceController
{
    protected $helpers = ['Utility', 'url', 'form', 'text'];

    public $customerModel = null;

    use ResponseTrait;
    public function __construct()
    {
        $this->leadsModel = new Leads_model();
        $this->customerModel = new Customer_model();
        $this->adminModel = new Admin_model();
    }
    public function create()
    {
        $data = file_get_contents('php://input');
        $item = json_decode($data);

        $apikey   = !empty($item->apikey) ? $item->apikey:'';
        if (api_verify($apikey)) {



            $customer = array(
                'customer_name' => $item->cust_name,
                'customer_phone' => $item->phone,
                'customer_email' => $item->cust_email,
            );
          


            $lead = array(
             'lead_source_id' => $item->lead_source,
             'lead_value' => $item->product_price,
             'lead_description' => $item->comment,
             'lead_maincat_name' => $item->product_main_cat,
             'lead_subcat_name' => $item->sub_cat_name
            );

            $customerdata = $this->customerModel->get_count($customer['customer_email']);

            if ($customerdata->resultID->num_rows > 0) {

                $lead['lead_customer_id'] = $customerdata->getResultArray()[0]['customer_id'];
            } else {
          

                $lead['lead_customer_id'] = $this->customerModel->insertCustomer($customer);
            }



            // if($user = $this->userModel->addUser($userData)){
            //     $leads['slm_user_id'] = $user->connID->insert_id;
            //     if($lead = $this->leadsModel->addLead($leads)){
            //         $id = $lead->connID->insert_id;
            //         $adminUser = $this->adminModel->getSuperAdmins();
            //         if(!empty($adminUser[0])){
            //             foreach($adminUser as $key){
            //                 $data = array(
            //                     'snm_notification' => "New Lead About " . $item->product_name . " From WebSite",
            //                     'snm_notification_admin' => 0,
            //                     'snm_notification_reciver' => $key['sam_id'],
            //                     'snm_notification_read' => 0,
            //                     'snm_notification_link' => base_url('admin/leadsDetails/' . $id),
            //                 );
            //                 $this->notificatinModel->addNotification($data);
            //                 $email = view('admin/emailTemplate/leadEmailTemplate');
            //                 $replace = array(
            //                     '{{siteUrl}}',
            //                     '{{userName}}',
            //                     '{{adminName}}',
            //                     '{{price}}',
            //                     '{{leadUrl}}'
            //                 );
            //                 $replaceWith = array(
            //                     base_url(),
            //                     $key['sam_name'],
            //                     $key['sam_name'],
            //                     $item->product_price,
            //                     base_url('admin/leadsDetails/' . $id)
            //                 );
            //                 $email = str_replace($replace, $replaceWith, $email);
            //                 send_mail($key['sam_email'], 'Lead Details', $email);
            //             }
            //         }
            //     }
            // }


        } else {
            echo 'API key invaild';
            die;
        }
    }
}
