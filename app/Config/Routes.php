<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('vendor');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(true);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// Home Url
$routes->add('/', 'vendor\Vendor::index');


// admin Url
$routes->add('admin', 'admin\Admin::index');
$routes->add('admin/home', 'admin\Admin::home');
$routes->add('admin/admin-check', 'admin\Admin::admin_check');
$routes->add('admin/logout', 'admin\Admin::admin_logout');
$routes->add('admin/admin-list', 'admin\Admin::admin_add_view');
$routes->add('admin/admins', 'admin\Admin::admin_list');
$routes->add('admin/UserName/(:any)', 'admin\Admin::checkUserName/$1');
$routes->add('admin/UserName', 'admin\Admin::checkUserName');
$routes->add('admin/Email/(:any)', 'admin\Admin::checkEmail/$1');
$routes->add('admin/Email', 'admin\Admin::checkEmail');
$routes->add('admin/phoneNo/(:any)', 'admin\Admin::checkPhoneNo/$1');
$routes->add('admin/phoneNo', 'admin\Admin::checkPhoneNo');
$routes->add('admin/add/(:any)', 'admin\Admin::addAdmin/$1');
$routes->add('admin/add', 'admin\Admin::addAdmin');
$routes->add('admin/Delete', 'admin\Admin::DeleteAdmin');
$routes->add('admin/getAdmin', 'admin\Admin::editData');
$routes->add('admin/edit', 'admin\Admin::editData');
$routes->add('admin/profile/(:any)/(:any)', 'admin\Admin::admin_Profile/$1/$2');
$routes->add('admin/profileImage/(:any)', 'admin\Admin::profileImageUpload/$1');
$routes->add('admin/setting', 'admin\Setting::index');
$routes->add('admin/Setting-list', 'admin\Setting::setting_list');
$routes->add('admin/Setting-add', 'admin\Setting::addSetting');
$routes->add('admin/settingDelete', 'admin\Setting::DeleteSetting');
$routes->add('admin/getElement/(:any)', 'admin\Setting::getElement/$1');
$routes->add('admin/addValue/(:any)', 'admin\Setting::addValue/$1');


$routes->add('admin/Sales/(:any)', 'admin\Vendor::details/$1');
// Admin Leads

$routes->add('admin/leads', 'admin\Leads::index');
$routes->add('admin/addLeads', 'admin\Leads::addLeads');
$routes->add('admin/addLeads/(:any)', 'admin\Leads::addLeads/$1');
$routes->add('admin/listLeads', 'admin\Leads::listLeads');
$routes->add('admin/leadsDetails/(:any)', 'admin\Leads::leadsDetails/$1');
$routes->add('admin/leadFile', 'admin\Leads::leadFile');
$routes->add('admin/getLeads', 'admin\Leads::getLeadData');
$routes->add('admin/deleteLeads', 'admin\Leads::delete');
$routes->add('admin/getvendor', 'admin\Leads::getvendor');
$routes->add('admin/reflead', 'admin\Leads::reflead');

$routes->add('admin/assign_lead', 'admin\Leads::assign_lead');
$routes->add('admin/userAccess', 'admin\Admin::userAccess');
$routes->add('admin/notification', 'admin\Admin::notificationList');

$routes->add('admin/add_comments', 'admin\Leads::add_comments');
$routes->add('admin/change_status', 'admin\Leads::change_status');
$routes->add('admin/export', 'admin\Leads::exportCSV');
$routes->add('admin/reportleads', 'admin\Leads::reportleads');
//Admin Lead Status

$routes->add('admin/leadstatus', 'admin\Leadstatus::index');
$routes->add('admin/LeadStatusList', 'admin\Leadstatus::LeadStatusList');
$routes->add('admin/addStatus', 'admin\Leadstatus::addStatus');
$routes->add('admin/editStatus', 'admin\Leadstatus::editStatus');
$routes->add('admin/StatusDelete', 'admin\Leadstatus::StatusDelete');


//Admin Vendor

$routes->add('admin/vendorList', 'admin\Vendor::vendorList');
$routes->add('admin/VendorDelete', 'admin\Vendor::delete');
$routes->add('admin/vendorStatus', 'admin\Vendor::VendorStatus');
$routes->add('admin/vendor', 'admin\Vendor::index');
$routes->add('admin/VendorDetails/(:any)', 'admin\Vendor::details/$1');
$routes->add('admin/editVendor', 'admin\Vendor::editData');
$routes->add('admin/vendorUserName/(:any)', 'admin\Vendor::checkUserName/$1');
$routes->add('admin/vendorUserName', 'admin\Vendor::checkUserName');
$routes->add('admin/vendorEmail/(:any)', 'admin\Vendor::checkEmail/$1');
$routes->add('admin/vendorEmail', 'admin\Vendor::checkEmail');
$routes->add('admin/vendorphoneNo/(:any)', 'admin\Vendor::checkPhoneNo/$1');
$routes->add('admin/vendorphoneNo', 'admin\Vendor::checkPhoneNo');
$routes->add('admin/addvendor', 'admin\Vendor::addVendor');
$routes->add('admin/addvendor/(:any)', 'admin\Vendor::addVendor/$1');
$routes->add('admin/getcomm/(:any)', 'admin\Vendor::getcomm');
$routes->add('admin/getcomm', 'admin\Vendor::getcomm');



$routes->add('admin/vendorcompany', 'admin\Vendor::vendorcompany');

// Admin Customer
$routes->add('admin/customer', 'admin\Customer::index');
$routes->add('admin/customerList', 'admin\Customer::customerList');

$routes->add('admin/addcustomer', 'admin\Customer::addCustomer');
$routes->add('admin/addcustomer/(:any)', 'admin\Customer::addCustomer/$1');
$routes->add('admin/CustomerEmail/(:any)', 'admin\Customer::checkEmail/$1');
$routes->add('admin/CustomerEmail', 'admin\Customer::checkEmail');
$routes->add('admin/CustomerDelete', 'admin\Customer::delete');

$routes->add('admin/customerDetails/(:any)', 'admin\Customer::details/$1');
$routes->add('admin/getcustomer', 'admin\Customer::get_customer');



// Main Categories 

$routes->add('admin/categories', 'admin\Categories::index');
$routes->add('admin/categoriesDetails/(:any)', 'admin\Categories::details/$1');
$routes->add('admin/categoriesList', 'admin\Categories::categoriesList');
$routes->add('admin/categoriesDelete', 'admin\Categories::delete');
$routes->add('admin/addcategories', 'admin\Categories::addcategories');
$routes->add('admin/editcategories', 'admin\Categories::editcategories');

// sub Categories

$routes->add('admin/Subcategories', 'admin\Subcategories::index');
$routes->add('admin/SubcategoriesList', 'admin\Subcategories::SubcategoriesList');
$routes->add('admin/editSubcategories', 'admin\Subcategories::editSubcategories');
$routes->add('admin/addSubcategories', 'admin\Subcategories::addSubcategories');
$routes->add('admin/SubcategoriesDelete', 'admin\Subcategories::delete');
$routes->add('admin/getSubcategories', 'admin\Subcategories::getSubcategories');

// Lead Source

$routes->add('admin/leadsource', 'admin\Leadsource::index');
$routes->add('admin/LeadSourceList', 'admin\Leadsource::LeadSourceList');
$routes->add('admin/editleadsource', 'admin\Leadsource::editleadsource');
$routes->add('admin/addleadsource', 'admin\Leadsource::addleadsource');
$routes->add('admin/leadsourceDelete', 'admin\Leadsource::delete');

// Lead Type

$routes->add('admin/leadtype', 'admin\Leadtype::index');
//$routes->add('admin/LeadSourceList', 'admin\Leadsource::LeadSourceList');
//$routes->add('admin/editleadsource', 'admin\Leadsource::editleadsource');
$routes->add('admin/addleadtype', 'admin\Leadsource::addleadtype');
//$routes->add('admin/leadsourceDelete', 'admin\Leadsource::delete');




$routes->add('admin/product', 'admin\Product::index');
$routes->add('admin/productList', 'admin\Product::productList');
$routes->add('admin/productDelete', 'admin\Product::Productdelete');
$routes->add('admin/ProductStatus', 'admin\Product::ProductStatus');
$routes->add('admin/ProductDetails/(:any)', 'admin\Product::Details/$1');
$routes->add('admin/sales', 'admin\Sales::index');
$routes->add('admin/salesList', 'admin\Sales::salesList');
$routes->add('admin/salesDelete', 'admin\Sales::delete');
$routes->add('admin/salesStatus', 'admin\Sales::salesStatus');
$routes->add('admin/leadComment', 'admin\Leads::comment');
$routes->add('admin/leadAssign', 'admin\Leads::assign');
$routes->add('admin/leadCommentDelete', 'admin\Leads::deleteComment');

// Staff Url
$routes->add('staff', 'admin\Admin::index');
$routes->add('staff/home', 'admin\Admin::home');
$routes->add('staff/admin-list', 'admin\Admin::admin_add_view');
$routes->add('staff/logout', 'admin\Admin::admin_logout');
$routes->add('staff/profile/(:any)/(:any)', 'admin\Admin::admin_Profile/$1/$2');
$routes->add('staff/setting', 'admin\Setting::index');
$routes->add('staff/leads', 'admin\Leads::index');
$routes->add('staff/email', 'admin\Admin::emailTemplate');
$routes->add('staff/vendor', 'admin\Vendor::index');
$routes->add('staff/VendorDetails/(:any)', 'admin\Vendor::details/$1');
$routes->add('staff/Sales/(:any)', 'admin\Vendor::details/$1');
$routes->add('staff/product', 'admin\Product::index');
$routes->add('staff/ProductDetails/(:any)', 'admin\Product::Details/$1');
$routes->add('staff/sales', 'admin\Sales::index');

// employee Url
$routes->add('employee', 'admin\Admin::index');
$routes->add('employee/home', 'admin\Admin::home');
$routes->add('employee/admin-list', 'admin\Admin::admin_add_view');
$routes->add('employee/logout', 'admin\Admin::admin_logout');
$routes->add('employee/profile/(:any)/(:any)', 'admin\Admin::admin_Profile/$1/$2');
$routes->add('employee/setting', 'admin\Setting::index');
$routes->add('employee/leads', 'admin\Leads::index');
$routes->add('employee/vendor', 'admin\Vendor::index');
$routes->add('employee/VendorDetails/(:any)', 'admin\Vendor::details/$1');
$routes->add('employee/Sales/(:any)', 'admin\Vendor::details/$1');
$routes->add('employee/product', 'admin\Product::index');
$routes->add('employee/ProductDetails/(:any)', 'admin\Product::Details/$1');
$routes->add('employee/sales', 'admin\Sales::index');

// sales_associate Url
$routes->add('sales-associate', 'admin\Admin::index');
$routes->add('sales-associate/home', 'admin\Admin::home');
$routes->add('sales-associate/admin-list', 'admin\Admin::admin_add_view');
$routes->add('sales-associate/logout', 'admin\Admin::admin_logout');
$routes->add('sales-associate/profile/(:any)/(:any)', 'admin\Admin::admin_Profile/$1/$2');
$routes->add('sales-associate/setting', 'admin\Setting::index');
$routes->add('sales-associate/leads', 'admin\Leads::index');
$routes->add('sales-associate/vendor', 'admin\Vendor::index');
$routes->add('sales-associate/VendorDetails/(:any)', 'admin\Vendor::details/$1');
$routes->add('sales-associate/Sales/(:any)', 'admin\Vendor::details/$1');
$routes->add('sales-associate/product', 'admin\Product::index');
$routes->add('sales-associate/ProductDetails/(:any)', 'admin\Product::Details/$1');
$routes->add('sales-associate/sales', 'admin\Sales::index');


// Front End Vendor Main

$routes->add('vendor', 'vendor\Vendor::index');
$routes->add('vendor/password/reset', 'vendor\Vendor::forget_pass');
$routes->add('vendor/password/forgetPassword', 'vendor\Vendor::forgotPassword');
$routes->add('reset-password?(:any)', 'vendor\Vendor::resetPassword');
$routes->add('vendor/change-password', 'vendor\Vendor::resetPassword');


$routes->add('vendor/vendor-check', 'vendor\Vendor::vendor_check');
$routes->add('vendor/home', 'vendor\Vendor::home');
$routes->add('vendor/logout', 'vendor\Vendor::vendor_logout');
$routes->add('vendor/listLeads', 'vendor\Vendor::listLeads');
$routes->add('vendor/leads', 'vendor\Vendor::leads');
$routes->add('vendor/addLeads', 'vendor\Vendor::addLeads');
$routes->add('vendor/getSubcategories', 'admin\Subcategories::getSubcategories');

$routes->add('vendor/CustomerEmail/(:any)', 'admin\Customer::checkEmail/$1');
$routes->add('vendor/CustomerEmail', 'admin\Customer::checkEmail');

$routes->add('vendor/accept_lead', 'vendor\Vendor::accept_lead');
$routes->add('vendor/add_comments', 'vendor\Vendor::add_comments');

$routes->add('vendor/leadsDetails/(:any)', 'vendor\Vendor::leadsDetails/$1');
$routes->add('vendor/getcustomer', 'admin\Customer::get_customer');


// Vendor referrallead

$routes->add('vendor/referrallead','vendor/Vendor::referrallead');


// FrontEnd Section Start


// Vendor FrontEnd

$routes->add('/vendorData', 'client\User::getVendorData');
$routes->add('/vendorUpdate', 'client\User::vendorUpdate');
$routes->add('/vendorBankData', 'client\User::bankData');
$routes->add('/vendorBankUpdate', 'client\User::bankUpdate');

/**
 * Common Route
 */

$routes->add('/get/state','admin\Leads::getState');
$routes->add('/get/city','admin\Leads::getCity');


// API Call URL
// $routes->post('api/createLeads', 'api\Leads::create');
$routes->resource('ImportLead');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
