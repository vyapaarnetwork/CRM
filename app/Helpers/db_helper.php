
<?php

// DB_Helper Created by Karan Mankodiya
//Sample Code

// $query = array(
//     'table' => array('tblleads_master'),
//     // 'select' => array('vendor_m_id','vendor_bankdetails'),
//     // 'join' => array('tblvendor_master' => 'tblvendor_master.vendor_id = tblvendor_details.vendor_m_id'),
//     'where' => array('lead_value' => '1231'),
//     // 'or_where' => array('lead_source_id' => '2','lead_value' => '1231'),
//     // 'like' => array('lead_value' => '1231','lead_verfied' => 'no'),
//     // 'orderby' => array('lead_id' => 'desc','lead_slug' => 'asc'),
//     // 'count' => '1',
//     // 'object_data' => '1'
// );

// edit function
// $data = array('lead_description' => 'updateageain');

// $query = array(
//     'table' => array('tblleads_master'),
//     'where' => array('lead_id' => '2'),
//     'data' => $data,

// );

// insert function


//      $data = array('lead_description' => 'updateageain');

// $query = array(
//     'table' => array('tblleads_master'),
//     'data' => $data,
//     'lastid' => '1'

// );

// Delete Data
// $query = array(
//     'table' => array('tblleads_master'),
//     'where' => array('lead_id' => '2'),
// );


// End Sample code


function add_dbdata($qurey)
{
    $database = \Config\Database::connect();
    $db = $database->table($qurey['table']);

    if (!empty($qurey['lasted']) && $qurey['lasted'] == '1') {

        $result =  $db->insert($qurey['data']);

        $result = $result->connID->insert_id;
    } else {
        $result =  $db->insert($qurey['data']);
    }
    return $result;
}




function edit_dbdata($qurey)
{
    $database = \Config\Database::connect();
    $db = $database->table($qurey['table']);

    if (!empty($qurey['where'])) {
        $db->where($qurey['where']);
    }

    $result =  $db->update($qurey['data']);

    return $result;
}

function del_dbdata($qurey)
{

    $database = \Config\Database::connect();
    $db = $database->table($qurey['table']);

    $db->where($qurey['where']);
    $result =      $db->delete();

    return $result;
}




function get_dbdata($qurey)
{

    $database = \Config\Database::connect();
    $db = $database->table($qurey['table']);
    // Select
    if (!empty($qurey['select'])) {
        $db->select($qurey['select']);
    }

    // join 
    if (!empty($qurey['join'])) {

        foreach ($qurey['join'] as $key => $value) {

            if (is_array($value)) {

                if (count($value) == 3) {
                    $db->join($value[0], $value[1], $value[2]);
                } else {
                    foreach ($value as $key1 => $value1) {
                        $db->join($key1, $value1);
                    }
                }
            } else {
                $db->join($key, $value);
            }
        }
    }

    if (!empty($qurey['where'])) {
        $db->where($qurey['where']);
    }

    if (!empty($qurey['or_where'])) {
        $db->where($qurey['or_where']);
    }

    if (!empty($qurey['whereIn'])) {
        foreach ($qurey['whereIn'] as $value => $key) {



            $db->whereIn($value, $key);
        }
    }

    if (!empty($qurey['like'])) {
        $db->like($qurey['like']);
    }


    if (!empty($qurey['orderby'])) {
        foreach ($qurey['orderby'] as $key => $value) {

            if (is_array($value)) {
                foreach ($qurey['orderby'] as $orderby => $orderval) {
                    $db->orderBy($orderby, $orderval);
                }
            } else {
                $db->orderBy($key, $value);
            }
        }
    }



    // result in object or array
    if (!empty($qurey['object_data']) && $qurey['object_data'] == '1') {
        $result = $db->get()->getResultObject();
    } elseif (!empty($qurey['count']) && $qurey['count'] == '1') {

        $result = $db->get()->resultID->num_rows;
    } elseif (!empty($qurey['array_data']) && $qurey['array_data'] == '1') {

        $result = $db->get()->getResultArray();
    }else{
        $result = $db->get();
    }


    return $result;
}
?>

