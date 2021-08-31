<?php
function getImageUrl($ext = null)
{
    return base_url('/uploads/admin/ProfileImage/' . (!empty($ext) ? $ext : ""));
}
function getBackendImageUrl($ext = null)
{
    return base_url('/assets/images/users/' . (!empty($ext) ? $ext : ""));
}
function getLogo($ext = null)
{
    return base_url('/assets/images/' . (!empty($ext) ? $ext : ""));
}
function getSettingUrl($ext = null)
{
    return base_url('uploads/admin/settingFiles/' . (!empty($ext) ? $ext : ""));
}
function getBackEndUrl($ext = null)
{
    return base_url('uploads/admin/' . (!empty($ext) ? $ext : ""));
}
function getFrontEndUrl($ext = null)
{
    return base_url('/assets/frontend-assest/' . (!empty($ext) ? $ext : ""));
}
function getFrontEndImageUploadUrl($ext = null)
{
    return base_url('/uploads/client/' . (!empty($ext) ? $ext : ""));
}
function countUnreadNotification($user_id)
{
    $notificationModel = new \App\Models\Notification_model;
    return $notificationModel->unReadNotification($user_id);
}
function menuUrl($type, $method = null)
{
    
    if ($type == 'super') {
        return base_url('admin' . (!empty($method) ? '/' . $method : ''));
    } else if ($type == 'staff') {
        return base_url('staff' . (!empty($method) ? '/' . $method : ''));
    } else {
        return base_url($type . '/' . (!empty($method) ? '/' . $method : ''));
    }
}
function humanTiming($time)
{
    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) continue;
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}
function send_mail($to, $subject, $mail)
{
    $config = array(
        'protocol'      => 'smtp',
        'SMTPHost'      => 'vyapaar.net',
        'SMTPUser'      => 'smtp@vyapaar.net',
        'SMTPPass'      => '@PQw)mXyK9bm',
        'SMTPPort'      => 587,
        'wordWrap'      => TRUE,
        'mailType'      => 'html',
        'charset'       => 'UTF-8',
    );

    $email = \Config\Services::email();
    $email->initialize($config);
    $email->setFrom('crm@vyapaar.net', 'Vyappar CRM');
    $email->setTo($to);
    $email->setSubject($subject);
    $email->setMessage($mail);
    $email->send();
    

}
function settingSiteData()
{
    $settingModel = new \App\Models\Settiing_model;
    return $settingModel->getSettings();
}
function emailSecuare($emailToSecure)
{
    $emailToSecure = explode("@", $emailToSecure);
    $emailToSecure[2] = substr($emailToSecure[0], -3);
    return str_repeat("*", (strlen($emailToSecure[0]) - 3)) . $emailToSecure[2] . "@" . $emailToSecure[1];
}
function api_verify($apikey){
    $setting = settingSiteData();
    if($setting['website_api'] == $apikey){
        return true;
    }
    else{
        return false;
    }


}

function sms_sent($message = null, $number = null)
{
    if (!empty($number)) {
        $setting = settingSiteData();
        $sms_link = null;
        $sms_link_data = null;
        if (!empty($setting['sms_api'])) {
            $sms_link = $setting['sms_api'];
        } else {
            return false;
        }
        if (!empty($setting['sms_api_access_token'])) {
            $sms_link_data = '?access_token=' . $setting['sms_api_access_token'];
        } else {
            return false;
        }
        if (!empty($setting['sms_sender'])) {
            $sms_link_data .= (empty($sms_link_data) ? '&' : '&') . 'sender=' . $setting['sms_sender'];
        } else {
            return false;
        }
        if (!empty($setting['sms_service'])) {
            $sms_link_data .= (empty($sms_link_data) ? '&' : '&') . 'service=' . $setting['sms_service'];
        } else {
            return false;
        }
        if (!empty($message)) {
            $sms_link_data .= (!empty($sms_link_data) ? '&' : '&') . 'message=' . $message;
        } else {
            return false;
        }
        if (!empty($setting['template_id'])) {
            $sms_link_data .= (!empty($sms_link_data) ? '&' : '&') . 'template_id=' . $setting['template_id'];
        } else {
            return false;
        }
        $sms_link_data .= (!empty($sms_link_data) ? '&' : '&') . 'to=' . $number;
        $ch         =   curl_init();
        $url        =   $sms_link.$sms_link_data;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);
        curl_close($ch);
    } else {
        return false;
    }

}
function getCountry()
{


    $query = array(
        'table' => 'tblcountries',
        'array_data' => '1'
    );
    return get_dbdata($query);



}
function getdbState($country_id)
{
    $query = array(
        'table' => 'tblcountries',
        'where' => array('name' => $country_id),
        'object_data' => '1'
    );
    $id = get_dbdata($query);


        $query = array(
            'table' => 'tblstates',
            'where' => array('country_id' => $id[0]->id),
            'object_data' => '1'
        );
        return get_dbdata($query);



}
function getdbCity($state_id)
{
    $query = array(
        'table' => 'tblstates',
        'where' => array('name' => $state_id),
        'object_data' => '1'
    );
    $id = get_dbdata($query);


    $query = array(
        'table' => 'tblcities',
        'where' => array('state_id' => $id[0]->id),
        'object_data' => '1'
    );
    return get_dbdata($query);



}