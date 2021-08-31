<?php

namespace App\Controllers\client;

use App\Controllers\BaseController;
use App\Models\Admin_model;
use App\Models\Notification_model;
use App\Models\SaleasAssociate_model;
use App\Models\Vendor_model;

class Home extends BaseController
{
    protected $vendorModel = null;
    protected $salesModel = null;
    protected $adminModel = null;
    protected $notificatinModel = null;

    public function __construct()
    {
        $this->vendorModel = new Vendor_model();
        $this->salesModel = new SaleasAssociate_model();
        $this->adminModel = new Admin_model();
        $this->notificatinModel = new Notification_model();
    }

    public function index()
    {
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Home';
        $headerData['page'] = 'home';
        $headerData['session'] = $this->session;
        echo view('client/includes/header', $headerData);
        $data['session'] = $this->session;
        echo view('client/home', $data);
        echo view('client/includes/footer', $headerData);
    }

    public function checkVendor()
    {
        if ($this->request->getPost('user') == 'sales') {
            if ($this->salesModel->getUnique($this->request->getPost('codetwo'), $this->request->getPost('val')) == 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        } else {
            if ($this->vendorModel->getUnique($this->request->getPost('code'), $this->request->getPost('val')) == 0) {
                echo json_encode(['status' => true]);
            } else {
                echo json_encode(['status' => false]);
            }
        }
        exit;
    }

    public function registerVendor()
    {
        if (!empty($this->request->getPost())) {
            $setting = settingSiteData();
            $New_slug = random_string('md5', 8);
            $i = 1;
            for ($i = 0; $i >= $i; $i++) {
                if ($this->vendorModel->getUnique('svm_slug', $New_slug) != 0) {
                    $New_slug = random_string('md5', 8);
                } else {
                    break;
                }
            }
            if ($this->request->getPost('user') == 'sales') {
                $smsMessageAdmin = 'You Recive new Registration As Sales Associate Name Is' . $this->request->getPost('name') . "In Pending Active It As Soon As Possible.";
                $smsMessageClient = 'Hi ' . $this->request->getPost('name') . '
                Thank You For Your Registration In ' . $setting['site_name'] . ' As Sales Associate.';
                $data = array(
                    'ssam_username' => $this->request->getPost('uName'),
                    'ssam_name' => $this->request->getPost('name'),
                    'ssam_email' => $this->request->getPost('email'),
                    'ssam_phone' => $this->request->getPost('mobileNo'),
                    'ssam_password' => md5($this->request->getPost('password')),
                    'ssam_company_name' => $this->request->getPost('company'),
                    'ssam_status' => 'pending'
                );
                $data['ssam_slug'] = $New_slug;
            } else {
                $smsMessageAdmin = 'You Recive new Registration As Vendor Name Is' . $this->request->getPost('name') . "In Pending Active It As Soon As Possible.";
                $smsMessageClient = 'Hi ' . $this->request->getPost('name') . '
                Thank You For Your Registration In ' . $setting['site_name'] . ' As Vendor.';
                $data = array(
                    'svm_username' => $this->request->getPost('uName'),
                    'svm_name' => $this->request->getPost('name'),
                    'svm_email' => $this->request->getPost('email'),
                    'svm_phone' => $this->request->getPost('mobileNo'),
                    'svm_password' => md5($this->request->getPost('password')),
                    'svm_company_name' => $this->request->getPost('company'),
                    'svm_status' => 'pending'
                );
                $data['svm_slug'] = $New_slug;
            }

            if ($this->request->getPost('user') == 'sales') {
                if ($this->salesModel->insertSales($data)) {
                    $id = $New_slug;
                    $adminUser = $this->adminModel->getSuperAdmins();
                    if (!empty($adminUser[0])) {
                        foreach ($adminUser as $key) {
                            $data = array(
                                'snm_notification' => "New " . $this->request->getPost('name') . " Sales Assoicate Register",
                                'snm_notification_admin' => 0,
                                'snm_notification_reciver' => $key['sam_id'],
                                'snm_notification_read' => 0,
                                'snm_notification_link' => base_url('admin/Sales/' . $id),
                            );
                            $this->notificatinModel->addNotification($data);
                            $email = view('client/emailTemplate/adminEmailTemplate');
                            $replace = array(
                                '{{siteUrl}}',
                                '{{vendorName}}',
                                '{{vendorUrl}}'
                            );
                            $replaceWith = array(
                                base_url(),
                                $this->request->getPost('name'),
                                base_url('admin/Sales/' . $New_slug)
                            );
                            $email = str_replace($replace, $replaceWith, $email);
                            send_mail($key['sam_email'], 'New Vendor Registration', $email);
                            sms_sent($smsMessageAdmin, $key['sam_mobile_no']);
                        }
                        $email = view('client/emailTemplate/vendorEmailTemplate');
                        $replace = array('{{siteUrl}}', '{{vendorUrl}}');
                        $replaceWith = array(base_url(), base_url('verifyEmail/' . $New_slug));
                        $email = str_replace($replace, $replaceWith, $email);
                        send_mail($this->request->getPost('email'), 'Registration', $email);
                        sms_sent($smsMessageClient, $this->request->getPost('mobileNo'));
                    }

                    $array = array(
                        'status' => true,
                        'message' => 'Register Successfully.'
                    );
                } else {
                    $array = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            } else {
                if ($this->vendorModel->insertVendor($data)) {
                    $id = $New_slug;
                    $adminUser = $this->adminModel->getSuperAdmins();
                    if (!empty($adminUser[0])) {
                        foreach ($adminUser as $key) {
                            $data = array(
                                'snm_notification' => "New " . $this->request->getPost('name') . " Vendor Register",
                                'snm_notification_admin' => 0,
                                'snm_notification_reciver' => $key['sam_id'],
                                'snm_notification_read' => 0,
                                'snm_notification_link' => base_url('admin/VendorDetails/' . $id),
                            );
                            $this->notificatinModel->addNotification($data);
                            $email = view('client/emailTemplate/adminEmailTemplate');
                            $replace = array(
                                '{{siteUrl}}',
                                '{{vendorName}}',
                                '{{vendorUrl}}'
                            );
                            $replaceWith = array(
                                base_url(),
                                $this->request->getPost('name'),
                                base_url('admin/vendorDetails/' . $New_slug)
                            );
                            $email = str_replace($replace, $replaceWith, $email);
                            send_mail($key['sam_email'], 'New Vendor Registration', $email);
                        }
                        $email = view('client/emailTemplate/vendorEmailTemplate');
                        $replace = array('{{siteUrl}}', '{{vendorUrl}}');
                        $replaceWith = array(base_url(), base_url('verifyEmail/' . $New_slug));
                        $email = str_replace($replace, $replaceWith, $email);
                        send_mail($this->request->getPost('email'), 'Registration', $email);
                    }
                    $array = array(
                        'status' => true,
                        'message' => 'Register Successfully.'
                    );
                } else {
                    $array = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            }
            echo json_encode($array);
        } else {
            echo json_encode(array(
                'status' => false,
                'message' => 'No Data To Prossed.'
            ));
        }
    }

    public function loginVendor()
    {
        $array = [];
        if (!empty($this->request->getPost('uName')) && !empty($this->request->getPost('password'))) {
            if ($vendor = $this->vendorModel->loginUser($this->request->getPost('uName'), $this->request->getPost('password'))) {
                $this->session->set('client', $vendor[0]);
                $array = array(
                    'status' => true,
                    'message' => 'Login Successfully.'
                );
            } else {
                if ($sales = $this->salesModel->loginUser($this->request->getPost('uName'), $this->request->getPost('password'))) {
                    $this->session->set('client', $sales[0]);
                    $array = array(
                        'status' => true,
                        'message' => 'Login Successfully.'
                    );
                } else {
                    $array = array(
                        'status' => false,
                        'message' => 'User Name Or Password Is Not Currect.'
                    );
                }
            }
        } else {
            $array = array(
                'status' => false,
                'message' => 'Opps! Something Was Wrong.'
            );
        }
        echo json_encode($array);
    }

    public function logoutVendor()
    {
        $this->session->remove('client');
        return redirect()->to(base_url());
    }

    public function email()
    {
        echo view('client/emailTemplate/salesEmailTemplate');
    }

    public function verifyEmail($slug = null)
    {
        if (!empty($slug)) {
            if ($this->vendorModel->alreadyVerifyEmail($slug) == 0) {
                if ($this->vendorModel->verifyEmail($slug)) {
                    $data['verify'] = 'success';
                } else {
                    $data['verify'] = 'error';
                }
            } else {
                $data['verify'] = 'already';
            }
        }
    }

    public function forgotPassword()
    {
        if (!empty($this->request->getPost('uName'))) {
            $vendor = $this->vendorModel->getVendorForgot($this->request->getPost('uName'));
            if (empty($vendor)) {
                $vendor = $this->salesModel->getSalesForgot($this->request->getPost('uName'));
            }
            if ($vendor) {
                if (!empty($vendor[0])) {
                    if (!empty($vendor[0]['svm_name']) && !empty($vendor[0]['svm_slug']) && !empty($vendor[0]['svm_email'])) {
                        $userName = $vendor[0]['svm_name'];
                        $userSlug = $vendor[0]['svm_slug'];
                        $userEmail = $vendor[0]['svm_email'];
                    } else if (!empty($vendor[0]['ssam_name']) && !empty($vendor[0]['ssam_slug']) && !empty($vendor[0]['ssam_email'])) {
                        $userName = $vendor[0]['ssam_name'];
                        $userSlug = $vendor[0]['ssam_slug'];
                        $userEmail = $vendor[0]['ssam_email'];
                    }
                    $email = view('client/emailTemplate/forgotEmailTemplate');
                    $replace = array(
                        '{{siteUrl}}',
                        '{{userName}}',
                        '{{forgotUrl}}'
                    );
                    $replaceWith = array(
                        base_url(),
                        $userName,
                        base_url('changePassword/' . $userSlug)
                    );
                    $email = str_replace($replace, $replaceWith, $email);
                    send_mail($userEmail, 'New Vendor Registration', $email);
                    $output = array(
                        'status' => true,
                        'message' => 'We Send You A Mail At ' . emailSecuare($userEmail) . '<br />Please Check You Email Address And Reset Your Password.'
                    );
                } else {
                    $output = array(
                        'status' => false,
                        'message' => 'User Not Found.'
                    );
                }
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Looking Like This User Not Register Yet.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'No Data Found.'
            );
        }
        echo json_encode($output);
    }

    public function changePassword($slug = null)
    {
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Change Password';
        $headerData['page'] = 'changePassword';
        $headerData['session'] = $this->session;
        echo view('client/includs/header', $headerData);
        $data['session'] = $this->session;
        $data['user'] = $slug;
        echo view('client/Password/changePassword', $data);
        echo view('client/includs/footer', $headerData);
    }

    public function passwordChange()
    {
        if (!empty($this->request->getPost('slug'))) {
            if ($this->vendorModel->changePassword($this->request->getPost('slug'), $this->request->getPost('password'))) {
                $output = array(
                    'status' => true,
                    'message' => 'Your Password Was Change Please Login.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Opps! Something Was Wrong Please Try Againg.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'Something Is Incurrect.'
            );
        }
        echo json_encode($output);
    }
}
