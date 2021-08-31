<?php

namespace App\Controllers\client;

use App\Controllers\BaseController;
use App\Models\Media_model;
use App\Models\Product_model;
use App\Libraries\Paginition;

class Product extends BaseController
{
    protected $notificatinModel = null;
    protected $productModel = null;
    protected $mediaModel = null;

    public function __construct()
    {
        $this->productModel = new Product_model();
        $this->mediaModel = new Media_model();
    }

    public function index()
    {
        if (empty($this->session->client['svm_id'])) {
            return redirect()->to(base_url());
        }
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Product';
        $headerData['page'] = 'product';
        $headerData['session'] = $this->session;
        echo view('client/includs/header', $headerData);
        $data['session'] = $this->session;
        echo view('client/Product/product', $data);
        echo view('client/includs/footer', $headerData);
    }

    public function getProductList()
    {
        $list = $this->productModel->get_datatables($_POST);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $key) {
            $no++;
            $row = array();
            $row[] = '<th scope="row">
                <a href="' . base_url('productDetails/' . $key['spm_slug']) . '">
                    <img src="' . getFrontEndImageUploadUrl('vendorProduct/' . $key['spm_image']) . '" alt="' . $key['spm_name'] . '" height="62px" class="pr-1" />
                    <span class="d-inline-block text-truncate" style="max-width:160px">'
                . $key['spm_name'] .
                '</span>
                </a>
            </th>';
            $row[] = '<td> ' . $key['spm_price'] . ' </td>';
            $row[] = '<td> ' . $key['spm_sell_price'] . ' </td>';
            $row[] = '<td> <span class="' . (($key['spm_status'] == "active") ? "text-success" : "text-danger") . '"> ' . ucfirst($key['spm_status']) . ' </span></td>';
            $row[] = '<td>' . $key['spm_created_at'] . '</td>';
            $row[] = '<td>
                <i class="fa fa-pencil-square mr-2" style="font-size:25px" data-id="' . $key['spm_id'] . '"></i>
                <i class="fa fa-trash" style="font-size:25px" data-id="' . $key['spm_id'] . '"></i>
            </td>';
            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->productModel->count_all($_POST),
            "recordsFiltered" => $this->productModel->count_filtered($_POST),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function addProductDetails()
    {
        if (!empty($this->request->getPost()) && !empty($productImage = $this->request->getFile('productImage'))) {
            if ($productDocument = $this->request->getFile('productDocument')) {
                if (!empty($productDocument->getName())) {
                    if ($productDocument->isValid() && !$productDocument->hasMoved()) {
                        $data['spm_document'] = $productDocument->getRandomName();
                        if (!$productDocument->move(VENDOR_PRODUCT_DOCUMENT, $data['spm_document'])) {
                            $output = array(
                                'status' => false,
                                'message' => 'Cant Move Document In Folder.'
                            );
                        }
                    } else {
                        $output = array(
                            'status' => false,
                            'message' => 'File Is Not Valid.'
                        );
                    }
                }
            }
            if ($productImage->isValid() && !$productImage->hasMoved()) {
                $data['spm_image'] = $productImage->getRandomName();
                if ($productImage->move(VENDOR_PRODUCT_IMAGE, $data['spm_image'])) {
                    $data['spm_name'] = $this->request->getPost('productName');
                    $data['spm_price'] = $this->request->getPost('productPrice');
                    $data['spm_sell_price'] = $this->request->getPost('productSellPrice');
                    $data['spm_descrioption'] = $this->request->getPost('productDescription');
                    $data['spm_type'] = 'vendor';
                    $data['spm_status'] = 'pending';
                    $data['spm_vendor_id'] = $this->session->client['svm_id'];
                    $New_slug = random_string('md5', 8);
                    $i = 1;
                    for ($i = 0; $i >= $i; $i++) {
                        if ($this->productModel->uniqueField('spm_slug', $New_slug) != 0) {
                            $New_slug = random_string('md5', 8);
                        } else {
                            break;
                        }
                    }
                    $data['spm_slug'] = $New_slug;
                    if ($product = $this->productModel->insertProduct($data)) {
                        $output = array(
                            'status' => true,
                            'message' => 'Product ' . $data['spm_name'] . ' Will Active As Soon As Possible.',
                            'data' => $product->connID->insert_id
                        );
                    } else {
                        $output = array(
                            'status' => false,
                            'message' => 'Opps! Something Was Wrong With Us.Please Try Again.'
                        );
                    }
                } else {
                    $output = array(
                        'status' => false,
                        'message' => 'Opps! Something Was Wrong In Image Upload.'
                    );
                }
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'File Is Not Valid.'
                );
            }
        } else {
            $output = array(
                'status' => false,
                'message' => 'Opps! Data Is Not Perfect.'
            );
        }
        echo json_encode($output);
    }

    public function addProductCatlog()
    {
        if (!empty($productCatlog = $this->request->getFiles())) {
            $data = null;
            foreach ($productCatlog['file'] as $key) {
                if ($key->isValid() && !$key->hasMoved()) {
                    $name = $key->getRandomName();
                    $data[] = [
                        'smm_product_id' => $this->request->getPost('id'),
                        'smm_value' => $name
                    ];
                    if (!$key->move(VENDOR_PRODUCT_IMAGE, $name)) {
                        echo json_encode(
                            array(
                                'status' => false,
                                'message' => 'File Can Not Move.'
                            )
                        );
                        die;
                    }
                } else {
                    if (!empty($data)) {
                        foreach ($data as $delete) {
                            if (!empty($delete['smm_value']) && file_exists(VENDOR_PRODUCT_IMAGE . $delete['smm_value'])) {
                                unlink(VENDOR_PRODUCT_IMAGE . $delete['smm_value']);
                            }
                        }
                    }
                    echo json_encode(array(
                        'status' => false,
                        'message' => 'There Was Something Wrong with File.'
                    ));
                    die;
                }
            }
            if ($this->mediaModel->addMedia($data)) {
                $output = array(
                    'status' => true,
                    'message' => 'Product Catlog Upload Successfully.'
                );
            } else {
                $output = array(
                    'status' => false,
                    'message' => 'Opps! Something Was Wrong To Add Catlog.'
                );
            }
            echo json_encode($output);
        }
    }

    public function productList()
    {
        $pagnition_data = array(
            'url' => base_url('product/list'),
            'total_rows' => $this->productModel->getCountProductForPage($this->request->getPost('search')),
            'page_items' => 5,
            'display_page_link' => 4,
            'first_link_text' => '<i class="fa fa-backward fa-1" aria-hidden="true"></i>',
            'next_link_text' => '<i class="fa fa-chevron-right fa-1" aria-hidden="true"></i>',
            'previous_link_text' => '<i class="fa fa-chevron-left fa-1" aria-hidden="true"></i>',
            'last_link_text' => '<i class="fa fa-forward fa-1" aria-hidden="true"></i>',
            'full_tag_name' => array('nav', 'ul'),
            'first_tag_name' => 'li',
            'cur_tag_names' => array('strong'),
            'next_tag_name' => array('strong'),
            'prev_tag_name' => array('strong'),
        );
        $pagnition_data_class = array(
            'full_tag_class' => array(
                array(
                    'Page',
                    'navigation',
                    'mt-5'
                ),
                array(
                    'pagination',
                )
            ),
            'first_tag_class' => array('page-item'),
            'last_tag_class' => array(''),
            'cur_tag_class' => array('active'),
            'next_tag_class' => array(''),
            'prev_tag_class' => array(''),
            'attribute_class' => array('page-link'),
        );
        $page = new Paginition($pagnition_data, $pagnition_data_class);
        $page->set_page_current();
        $data['page'] = $page->get_paginition_query_string();
        $headerData['setting'] = settingSiteData();
        $headerData['title'] = 'Product List';
        $headerData['page'] = 'productList';
        $headerData['session'] = $this->session;
        echo view('client/includs/header', $headerData);
        $data['session'] = $this->session;
        $data['product'] = $this->productModel->getProductForPage($this->request->getPost('search'));
        echo view('client/Product/productList', $data);
        echo view('client/includs/footer', $headerData);
    }
}
