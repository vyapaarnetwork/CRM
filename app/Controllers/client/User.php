<?php

namespace App\Controllers\client;

use App\Controllers\BaseController;
use App\Models\Admin_model;
use App\Models\Bank_model;
use App\Models\Notification_model;
use App\Models\Vendor_model;
use CodeIgniter\HTTP\Message;

class User extends BaseController
{
    protected $vendorModel = null;
    protected $adminModel = null;
    protected $bankModel = null;
    protected $notificatinModel = null;

    public function __construct()
    {
        $this->vendorModel = new Vendor_model();
        $this->adminModel = new Admin_model();
        $this->bankModel = new Bank_model();
        $this->notificatinModel = new Notification_model();
    }

    public function profile($slug = null)
    {
        if (empty($this->session->client['svm_id'])) {
            return redirect()->to(base_url());
        }
        if (!empty($slug)) {
            $data['user'] = (!empty($user = $this->vendorModel->getUserBySlug($slug, false, true)) ? $user[0] : null);
            $data['slug'] = $slug;
            $headerData['setting'] = settingSiteData();
            $headerData['title'] = 'Profile Details';
            $headerData['page'] = 'profileDetails';
            $headerData['session'] = $this->session;
            echo view('client/includs/header', $headerData);
            $data['session'] = $this->session;
            echo view('client/Profile/profile', $data);
            echo view('client/includs/footer', $headerData);
        }
    }

    public function uploadProfilePic()
    {
        if (!empty($this->request->getPost('svm_slug'))) {
            if ($imagefile = $this->request->getFile('profilePic')) {
                if ($imagefile->isValid() && !$imagefile->hasMoved()) {
                    $oldData = $this->vendorModel->getUserBySlug($this->request->getPost('svm_slug'));
                    $data['svm_image'] = $imagefile->getRandomName();
                    if ($imagefile->move(VENDOR_IMAGE_PATH, $data['svm_image'])) {
                        if ($this->vendorModel->UpdateVendorProfilePicBySlug($data, $this->request->getPost('svm_slug'))) {
                            $vendorData = $this->vendorModel->getUserBySlug($this->request->getPost('svm_slug'), true);
                            $this->session->set('client', $vendorData[0]);
                            if (!empty($oldData[0]->svm_image) && file_exists(VENDOR_IMAGE_PATH . $oldData[0]->svm_image)) {
                                unlink(VENDOR_IMAGE_PATH . $oldData[0]->svm_image);
                            }
                            $output = array(
                                'status' => True,
                                'message' => 'Profile Image Successfully Updated.',
                                'data' => getFrontEndImageUploadUrl('vendorImage/' . $data['svm_image'])
                            );
                        } else {
                            unlink(VENDOR_IMAGE_PATH . $data['svm_image']);
                            $output = array(
                                'status' => false,
                                'message' => 'Something Is Wrong With Updating Data.'
                            );
                        }
                    } else {
                        $output = array(
                            'status' => false,
                            'message' => 'Something Was Wrong In Uploading File.'
                        );
                    }
                } else {
                    $output = array(
                        'status' => false,
                        'message' => 'File Type is Not Valid.'
                    );
                }
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'File Not selected.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'No Data Found For Update.'
            );
        }
        echo json_encode($output);
    }

    public function getVendorData()
    {
        if (!empty($this->request->getPost('slug'))) {
            if (!empty($vendorData = $this->vendorModel->getUserBySlug($this->request->getPost('slug')))) {
                $output = array(
                    'status' => true,
                    'data' => $vendorData[0]
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
                'message' => 'User Not Found.'
            );
        }
        echo json_encode($output);
    }

    public function vendorUpdate()
    {
        if ($this->request->getPost('svm_slug')) {
            if (!empty($this->request->getPost('svm_name'))) {
                $data['svm_name'] = $this->request->getPost('svm_name');
            }
            if (!empty($this->request->getPost('svm_company_name'))) {
                $data['svm_company_name'] = $this->request->getPost('svm_company_name');
            }

            if ($this->vendorModel->UpdateVendorProfilePicBySlug($data, $this->request->getPost('svm_slug'))) {
                $output = array(
                    'status' => true,
                    'message' => 'Profile Update Successfully.',
                    'data' => $data
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
                'message' => 'No Data Found To Update.'
            );
        }
        echo json_encode($output);
    }

    public function bankData()
    {
        if (!empty($this->request->getPost('slug'))) {
            if ($bankData = $this->vendorModel->getUserBySlug($this->request->getPost('slug'), false, true)) {
                $output = array(
                    'status' => true,
                    'data' => $bankData[0]
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Oppa! Something Was Wrong.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'Nothing To Found.'
            );
        }
        echo json_encode($output);
    }

    public function bankUpdate()
    {
        $data['sbm_type'] = 'vendor';
        if ($this->request->getPost('vendor_id')) {
            $data['sbm_vendor_id'] = $this->request->getPost('vendor_id');
        }
        if ($this->request->getPost('name')) {
            $data['sbm_holder_name'] = $this->request->getPost('name');
        }
        if ($this->request->getPost('number')) {
            $data['sbm_account_no'] = $this->request->getPost('number');
        }
        if ($this->request->getPost('code')) {
            $data['sbm_ifsc_code'] = $this->request->getPost('code');
        }
        if ($this->bankModel->addBankDetails($data, (!empty($this->request->getPost('id')) ? $this->request->getPost('id') : null))) {
            $output = array(
                'status' => true,
                'message' => (!empty($this->request->getPost('id')) ? 'Bank Details Update Successfully.' : 'Bank Details Save Successfully.'),
                'data' => $data
            );
        } else {
            $output = array(
                'status' => false,
                'message' => 'Opps! Something Was Wrong.'
            );
        }
        echo json_encode($output);
    }
}
