<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Admin_model;
use \App\Models\Notification_model;

class Admin extends BaseController
{
    public $adminModel = null;
    public $notificationModel = null;
    public $notification = null;
    function __construct()
    {
        $this->adminModel = new Admin_model();
        $this->notificationModel = new Notification_model();
    }
    public function index()
    {


        if (empty($this->session->admin)) {
            $setting = settingSiteData();
            $data['setting'] = $setting;
            $header_data['setting'] = $setting;
            $footer_data['setting'] = $setting;
            $header_data['title'] = "Login";
            $data['header'] = view('include/header', $header_data);
            $footer_data['page'] = "admin_login";
            $data['footer'] = view('include/footer', $footer_data);
            return view('login/auth_admin', $data);
        } else {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'home'));
        }
    }
    public function home()
    {
        if (empty($this->session->admin)) {
            return redirect()->to(base_url('admin'));
        }

        // Vendor Count

        $query = array(
            'table' => array('tblvendor_master'),

            'count' => '1',
        );

        $data['tlvendor'] = get_dbdata($query);

        // Customer Count

        $query = array(
            'table' => array('tblcustomer_master'),

            'count' => '1',
        );

        $data['tlcustomer'] = get_dbdata($query);

        // Lead Count
        $query = [
            'table' => ['tblleads_master'],
            'whereIn' => ['lead_status' => ['accept', '1']],
            'count' => '1',];

        $data['tlleads'] = get_dbdata($query);

        // Proposal Leads
        $query = array(
            'table' => ['tblleads_master'],
            'where' => array('lead_status' => '4'),
            'count' => '1',
        );

        $data['tlproposal'] = get_dbdata($query);

        // qualification Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_status' => '2'),
            'count' => '1',
        );

        $data['tlqualification'] = get_dbdata($query);


        // need_analysis Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_status' => '3'),
            'count' => '1',
        );

        $data['tlneed_analysis'] = get_dbdata($query);




        // Lost Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_status' => '7'),
            'count' => '1',
        );

        $data['tlclleads'] = get_dbdata($query);

        // Won Leads
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_status' => '6'),
            'count' => '1',
        );

        $data['tlwonleads'] = get_dbdata($query);
        // Negotiation/Review
        $query = array(
            'table' => array('tblleads_master'),
            'where' => array('lead_status' => '5'),
            'count' => '1',
        );

        $data['tlnego'] = get_dbdata($query);




        $setting = settingSiteData();
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Dashboard";
        $header_data['model'] = 'Admin';
        $header_data['session'] = $this->session;
        $data['header'] = view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        $footer_data['page'] = "admin_dashboard";
        $data['footer'] = view('include/footer', $footer_data);
        return view('admin/dashboard/' . $this->session->admin['admin_type'] . '_dashboard', $data);
    }
    public function admin_check()
    {
        $admin = $this->adminModel->chechAdminAuth($_POST['user_address'], $_POST['password']);
        if (count($admin) > 0) {
            $this->session->set("admin", $admin[0]);
            $return = array(
                "status" => true,
                'message' => 'Login Successfull.',
                'url' => menuUrl($this->session->admin['admin_type'], 'home')
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
    public function admin_logout()
    {
        $this->session->destroy();
        return redirect()->to(base_url('admin'));
    }
    public function admin_add_view()
    {
        if (!empty($this->session->admin) && $this->session->admin['admin_type'] == "super") {
            $header_data['title'] = "Admin's";
            $setting = settingSiteData();
            $data['setting'] = $setting;
            $header_data['setting'] = $setting;
            $footer_data['setting'] = $setting;
            $header_data['session'] = $this->session;
            $header_data['notfs'] = $this->notification;
            echo view('include/header', $header_data);
            $data['adminMenu'] = view('include/menu_bar', $header_data);
            echo view('admin/admin_list', $data);
            $footer_data['page'] = "admin_list";
            echo view('include/footer', $footer_data);
        } else {
            return redirect()->to(menuUrl('admin'));
        }
    }
    public function admin_list()
    {
        $list = $this->adminModel->get_datatables($_POST);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] =  '<div class="custom-control custom-checkbox text-center">
            <input type="checkbox" class="vendorIds custom-control-input" id="' . $key['admin_id'] . '"  value="' . $key['admin_id'] . '" name="admin_id[]">
            <label class="custom-control-label" for="' . $key['admin_id'] . '""></label>
        </div>';
            $row[] = '<th scope="row"> <a href="' . base_url('admin/profile/' . $key['admin_type'] . '/' . $key['admin_slug']) . '">' . $key['admin_name'] . '</a></th>';
            $row[] = '<td> ' . $key['admin_username'] . ' </td>';
            $row[] = '<td> ' . $key['admin_email'] . ' </td>';
            $row[] = '<td> ' . $key['admin_mobile'] . ' </td>';
            $row[] = '<td> ' . ucfirst(str_replace('_', ' ', $key['admin_type'])) . ' </td>';
            $row[] = '<td> <span class="' . (($key['admin_status'] == "active") ? "text-success" : "text-danger") . '"> ' . ucfirst($key['admin_status']) . ' </span></td>';
            $row[] = '<td>
                <i class="ti-marker-alt mr-2" data-id="' . $key['admin_id'] . '"></i>
                <i class="ti-trash" data-id="' . $key['admin_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->adminModel->count_all($_POST),
            "recordsFiltered" => $this->adminModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function checkUserName($id = null)
    {
        $count = $this->adminModel->checkUserNameExists($this->request->getPost('val'), $id);
        if ($count == 0) {
            echo json_encode(['status' => true]);
        } else {
            echo json_encode(['status' => false]);
        }
    }
    public function checkEmail($id = null)
    {
        $count = $this->adminModel->checkEmailExists($this->request->getPost('val'), $id);
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
        $count = $this->adminModel->checkPhoneNoExists($this->request->getPost('val'), $id);
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
    public function addAdmin($id = null)
    {

        $data = array(
            'admin_name'          => $this->request->getPost('name'),
            'admin_username'     => $this->request->getPost('uName'),
            'admin_email'         => $this->request->getPost('email'),
            'admin_password'      => md5($this->request->getPost('password')),
            'admin_mobile'     => $this->request->getPost('mobileNo'),
            'admin_type'    => $this->request->getPost('type')
        );
        if (empty($id)) {
            $New_slug =  rand(80000, 90000);
            $i = 1;
            for ($i = 0; $i >= $i; $i++) {
                if ($this->adminModel->checkSlug($New_slug) != 0) {
                    $New_slug = rand(80000, 90000);
                } else {
                    break;
                }
            }
            $data['admin_slug'] = $New_slug;
        }
        if (empty($this->request->getPost('password'))) {
            unset($data['admin_password']);
        }
        if ($this->adminModel->insertAdmin($data, (!empty($id) ? $id : null))) {
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
    public function deleteAdmin()
    {
        if (!empty($this->request->getPost('deleteAdmin'))) {
            if ($this->adminModel->adminDelete($this->request->getPost('deleteAdmin'))) {
                $output = [
                    'status' => true,
                    'message' => 'Delete Data Successfully.'
                ];
            } else {
                $output = [
                    'status' => false,
                    'message' => 'Opps! Something Wrong Can\'t Delete Data.'
                ];
            }
        } else {
            $output = [
                'status' => false,
                'message' => 'Opps! Something Was Wrong Please Try Later.'
            ];
        }
        echo json_encode($output);
    }
    public function editData()
    {
        if (!empty($this->request->getPost('editId'))) {
            if ($data = $this->adminModel->getAdmin($this->request->getPost('editId'))) {
                $data[0]->admin_name = explode(" ", $data[0]->admin_name);
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
    public function admin_Profile($type = null, $slug = null)
    {
        $setting = settingSiteData();
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('admin'));
        }
        if (!empty($slug) && !empty($type)) {
            $userData = $this->adminModel->getUserData($slug);
        } else {
            return redirect()->to(menuUrl($this->session->admin['admin_type'], 'admin-list'));
        }
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $data['user'] = $userData;
        $header_data['title'] = ucwords(str_replace("_", " ", $type)) . " Profile";
        $header_data['page'] = "profile";
        $header_data['session'] = $this->session;
        $header_data['notfs'] = $this->notification;
        echo view('include/header', $header_data);
        $data['adminMenu'] = view('include/menu_bar', $header_data);
        echo view('admin/profile/Profile', $data);
        $footer_data['page'] = "profile";
        echo view('include/footer', $footer_data);
    }
    public function profileImageUpload($sam_id = null)
    {
        if (!empty($sam_id)) {
            if ($imagefile = $this->request->getFile('imageFile')) {
                if ($imagefile->isValid() && !$imagefile->hasMoved()) {
                    $oldData = $this->adminModel->getUserImg($sam_id);
                    $data['admin_image'] = $imagefile->getRandomName();
                    if ($imagefile->move(ADMIN_PROFILE_IMAGE, $data['admin_image'])) {
                        if ($this->adminModel->UploadAdminProfile($data, $sam_id)) {
                            $userImage = $this->adminModel->getUserImg($sam_id);
                            if (!empty($oldData->admin_image)) {
                                unlink(ADMIN_PROFILE_IMAGE . $oldData->admin_image);
                            }
                            $output = array(
                                'status' => True,
                                'message' => 'Profile Image Successfully Updated.',
                                'data' => getImageUrl($userImage->admin_image)
                            );
                        } else {
                            unlink(ADMIN_PROFILE_IMAGE . $data['admin_image']);
                            $output = array(
                                'status' => false,
                                'message' => 'Something Is Wrong With Updating Data.'
                            );
                        }
                    } else {
                        $output = array(
                            'status' => false,
                            'message' => 'Something Is Wrong With Uploading Image File.'
                        );
                    }
                } else {
                    $output = array(
                        'status' => false,
                        'message' => 'Image File Is Not Valid.'
                    );
                }
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'No File Found.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'No User Id Found Plase Reload The Page.'
            );
        }
        echo json_encode($output);
    }
    public function userAccess()
    {
        $accessData = explode(',', $this->request->getPost('value'));
        if ($access = $this->adminModel->getUserAccess($this->request->getPost('user_id'))) {
            $userAccess = unserialize($access[0]['admin_access']);
            $userAccess[$accessData[0]] = $accessData[1];
            $data['admin_access'] = serialize($userAccess);
            if ($this->adminModel->updateUserAccess($data, $this->request->getPost('user_id'))) {
                $output = array(
                    'status' => true,
                    'message' => 'Access Updated SuccessFully.'
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
                'message' => 'Opps! Something Was Wrong.'
            );
        }
        echo json_encode($output);
    }

   
}
