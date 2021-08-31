<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Settiing_model;

class Setting extends BaseController
{
    public $settingModel = null;
    function __construct()
    {
        $this->settingModel = new Settiing_model();
    }
    public function index()
    {
        $setting = settingSiteData();
        if (empty($this->session->admin)) {
            return redirect()->to(menuUrl('super'));
        }
        $data['setting'] = $setting;
        $header_data['setting'] = $setting;
        $footer_data['setting'] = $setting;
        $header_data['title'] = "Site Setting";
        $header_data['session'] = $this->session;
        echo view('admin/includs/header', $header_data);
        $data['adminMenu'] = view('admin/includs/admin_menu', $header_data);
        echo view('admin/setting-site', $data);
        $footer_data['page'] = "site_setting";
        echo view('admin/includs/footer', $footer_data);
    }
    public function addSetting()
    {
        $id = $this->request->getPost('ssm_id');
        if (!empty($this->request->getPost())) {
            $data = array(
                'ssm_name' => $this->request->getPost('Name'),
                'ssm_key' => $this->request->getPost('Key'),
                'ssm_type' => $this->request->getPost('type')
            );
            if($this->request->getPost('type') == 'Textbox'){
                $data['ssm_value'] = $this->request->getPost('textbox');
            } else if($this->request->getPost('type') == 'Checkbox'){
                $data['ssm_value'] = (!empty($this->request->getPost('checkbox')) ? 'true' : 'false');
            } else if($this->request->getPost('type') == 'Textarea'){
                $data['ssm_value'] = $this->request->getPost('textarea');
            } else if($this->request->getPost('type') == 'File'){
                if ($file = $this->request->getFile('newFile')) {
                    if ($file->isValid() && !$file->hasMoved()) {
                        $data['ssm_value'] = $file->getRandomName();
                        $file->move(ADMIN_SETTING_PATH, $data['ssm_value']);
                    }
                } else {
                    $data['ssm_value'] = $this->request->getPost('oldFile');
                }
            }
            if ($this->settingModel->addSetting($data, (!empty($id) ? $id : null))) {
                $output = array(
                    'status' => true,
                    'message' => 'Data Insert Successfully.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'opps! Something Was Wrong.'
                );
            }
            echo json_encode($output);
        }
    }
    public function setting_list()
    {
        if (empty($this->session->admin)) {
            return redirect()->to(base_url('admin'));
        }
        $list = $this->settingModel->get_datatables($_POST);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = '<td> ' . $key['ssm_name'] . ' </td>';
            $row[] = '<td> ' . $key['ssm_key'] . ' </td>';
            $row[] = '<td> ' . $key['ssm_type'] . ' </td>';
            $row[] = '<td> ' . ((!empty($key['ssm_value']) && $key['ssm_type'] == 'File') ? '<a href="' . getSettingUrl($key['ssm_value']) . '" download><i class="ti-file">' . $key['ssm_value'] . '</i></a>' : (!empty($key['ssm_value']) ? $key['ssm_value'] : '-')) . ' </td>';
            $row[] = '<td>
                <i class="ti-marker-alt mr-2" title="Edit" data-id="' . $key['ssm_id'] . '"></i>
                <i class="ti-trash" title="Delete" data-id="' . $key['ssm_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->settingModel->count_all($_POST),
            "recordsFiltered" => $this->settingModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function getElement($id = null)
    {
        if (empty($this->session->admin)) {
            return redirect()->to(base_url('admin'));
        }
        if (!empty($id)) {
            if ($element = $this->settingModel->getElementType($id)) {
                $output = array(
                    'status' => true,
                    'data' => $element[0]
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'No Data Found.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'No Id Found.'
            );
        }
        echo json_encode($output);
    }
    public function addValue($id = null)
    {
        if (empty($this->session->admin)) {
            return redirect()->to(base_url('admin'));
        }
        if (!empty($id)) {
            $data = null;
            $output = null;
            $oldData = $this->settingModel->getElementType($id);
            if (!empty($this->request->getFile('newFile')->getName())) {
                $file = $this->request->getFile('newFile');
                if ($file->isValid() && !$file->hasMoved()) {
                    $data['ssm_value'] = $file->getRandomName();
                    if ($file->move(ADMIN_SETTING_PATH, $data['ssm_value'])) {
                        if ($this->settingModel->addKeyValue($data, $id)) {
                            $output = array(
                                'status' => true,
                                'message' => 'File Upload Successfully.'
                            );
                        } else {
                            unlink(ADMIN_SETTING_PATH . $data['ssm_value']);
                            $output = array(
                                'status' => false,
                                'message' => 'Opps! Something Was Wrong.'
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
                        'message' => 'Opps! File Is Not Valid.'
                    );
                }
            } else if (!empty($this->request->getPost('textbox'))) {
                $data['ssm_value'] = $this->request->getPost('textbox');
                if ($this->settingModel->addKeyValue($data, $id)) {
                    $output = array(
                        'status' => true,
                        'message' => 'Setting Updated Successfully.'
                    );
                } else {
                    unlink(ADMIN_SETTING_PATH . $data['ssm_value']);
                    $output = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            } else if (!empty($this->request->getPost('textarea'))) {;
                $data['ssm_value'] = $this->request->getPost('textarea');
                if ($this->settingModel->addKeyValue($data, $id)) {
                    $output = array(
                        'status' => true,
                        'message' => 'Setting Updated Successfully.'
                    );
                } else {
                    unlink(ADMIN_SETTING_PATH . $data['ssm_value']);
                    $output = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            } else if (isset($_POST['checkbox']) && $oldData[0]['ssm_type'] == 'Checkbox') {
                $data['ssm_value'] = "true";
                if ($this->settingModel->addKeyValue($data, $id)) {
                    $output = array(
                        'status' => true,
                        'message' => 'Setting Updated Successfully.'
                    );
                } else {
                    unlink(ADMIN_SETTING_PATH . $data['ssm_value']);
                    $output = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            } else if(!isset($_POST['checkbox']) && $oldData[0]['ssm_type'] == 'Checkbox'){
                $data['ssm_value'] = "false";
                if ($this->settingModel->addKeyValue($data, $id)) {
                    $output = array(
                        'status' => true,
                        'message' => 'Setting Updated Successfully.'
                    );
                } else {
                    unlink(ADMIN_SETTING_PATH . $data['ssm_value']);
                    $output = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong.'
                    );
                }
            } else {
                if (!empty($file) && !empty($oldData['ssm_value'])) {
                    unlink(ADMIN_SETTING_PATH . $oldData['ssm_value']);
                }
                $output = array(
                    'status' => false,
                    'message' => 'File Not Found.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'Id Not Found.'
            );
        }
        echo json_encode($output);
    }
    public function DeleteSetting()
    {
        if(!empty($this->request->getPost('deleteSeting'))){
            if($this->settingModel->settingDelete($this->request->getPost('deleteSeting'))){
                $output = array(
                    'status' => true,
                    'message' => 'Setting Delete Successfully.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'opps! Something Was Wrong.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'opps! Something Was Wrong.'
            );
        }
        echo json_encode($output);
    }
}
