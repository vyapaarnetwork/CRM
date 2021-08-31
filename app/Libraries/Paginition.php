<?php
/*
===================     Devlope By Jogi Gaurang             ===================
===================     Created Date :- 13-08-2020          ===================
===================     Latest Upload :- You Can User IT    ===================
*/

// This Library Is Use For Customise paginition

namespace App\Libraries;

class Paginition
{
    private $data = array(
        'get'                       => false,
        'url'                       => '',
        'total_rows'                => 0,
        'page_items'                => 10,
        'f_page'                    => 1,
        'display_page_link'         => 5,
        'first_link_text'           => '&lsaquo; First',
        'next_link_text'            => '&gt; Next',
        'previous_link_text'        => '&lt; Previous',
        'last_link_text'            => 'Last &rsaquo;',
        'full_tag_name'             => 'ul',
        'first_tag_name'            => 'li',
        'last_tag_name'             => 'li',
        'cur_tag_names'             => array('strong'),
        'next_tag_name'             => array('strong'),
        'prev_tag_name'             => array('strong'),
    );
    private $data_class = array(
        'full_tag_class'    => array(),
        'first_tag_class'   => array(),
        'last_tag_class'    => array(),
        'cur_tag_class'     => array(),
        'next_tag_class'    => array(),
        'prev_tag_class'    => array(),
        'attribute_class'   => array(),
    );
    private $paginition_query_string = '';
    private $cur_page = '';
    public function __construct($array = array(), $array_class = array())
    {
        if (!empty($array['get'])) {
            $this->set_get($array['get']);
        }
        if (!empty($array['url'])) {
            $this->set_url($array['url']);
        }
        if (!empty($array['total_rows'])) {
            $this->set_total_rows($array['total_rows']);
        }
        if (!empty($array['page_items'])) {
            $this->set_page_items($array['page_items']);
        }
        if (!empty($array['f_page'])) {
            $this->set_f_page($array['f_page']);
        }
        if (!empty($array['display_page_link'])) {
            $this->set_display_page_link($array['display_page_link']);
        }
        if (!empty($array['first_link_text'])) {
            $this->set_first_link_text($array['first_link_text']);
        }
        if (!empty($array['next_link_text'])) {
            $this->set_next_link_text($array['next_link_text']);
        }
        if (!empty($array['previous_link_text'])) {
            $this->set_previous_link_text($array['previous_link_text']);
        }
        if (!empty($array['last_link_text'])) {
            $this->set_last_link_text($array['last_link_text']);
        }
        if (!empty($array['full_tag_name'])) {
            $this->set_full_tag_name($array['full_tag_name']);
        }
        if (!empty($array['first_tag_name'])) {
            $this->set_first_tag_name($array['first_tag_name']);
        }
        if (!empty($array['last_tag_name'])) {
            $this->set_last_tag_name($array['last_tag_name']);
        }
        if (!empty($array['cur_tag_names'])) {
            $this->set_cur_tag_names($array['cur_tag_names']);
        }
        if (!empty($array['next_tag_name'])) {
            $this->set_next_tag_name($array['next_tag_name']);
        }
        if (!empty($array['prev_tag_name'])) {
            $this->set_full_tag_class($array['prev_tag_name']);
        }
        if (!empty($array_class['full_tag_class'])) {
            $this->set_full_tag_class($array_class['full_tag_class']);
        }
        if (!empty($array_class['first_tag_class'])) {
            $this->set_first_tag_class($array_class['first_tag_class']);
        }
        if (!empty($array_class['last_tag_class'])) {
            $this->set_last_tag_class($array_class['last_tag_class']);
        }
        if (!empty($array_class['cur_tag_class'])) {
            $this->set_cur_tag_class($array_class['cur_tag_class']);
        }
        if (!empty($array_class['next_tag_class'])) {
            $this->set_next_tag_class($array_class['next_tag_class']);
        }
        if (!empty($array_class['prev_tag_class'])) {
            $this->set_prev_tag_class($array_class['prev_tag_class']);
        }
        if (!empty($array_class['attribute_class'])) {
            $this->set_attribute_class($array_class['attribute_class']);
        }
    }
    private function init()
    {
        if ($this->get_total_rows() / $this->get_page_items() > 1) {
            $this->paginition_query_string = '{data}';
            $page = $this->get_total_rows() / $this->get_page_items();
            if (!empty($main = $this->get_full_tag_name())) {
                if (!is_array($main)) {
                    $this->paginition_query_string = str_replace('{data}', '<' . $main . ' {class}> {data} </' . $main . '>', $this->paginition_query_string);
                } else {
                    $main_data = null;
                    foreach ($main as $key => $val) {
                        $main_data = '<' . $val . ' {class}> {data}</' . $val . '>';
                        $this->paginition_query_string = str_replace('{data}', $main_data, $this->paginition_query_string);
                        if (!empty($this->get_full_tag_class()[$key])) {
                            if (is_array($class = $this->get_full_tag_class()[$key])) {
                                $this->paginition_query_string = str_replace('{class}', 'class="' . implode(' ', $class) . '"', $this->paginition_query_string);
                            } else {
                                $this->paginition_query_string = str_replace('{class}', 'class="' . $class . '"', $this->paginition_query_string);
                            }
                        } else {
                            $this->paginition_query_string = str_replace('{class}', '', $this->paginition_query_string);
                        }
                    }
                }
            } else {
                echo "full Tag Is Not Defind.";
                die;
            }
            $data_page_number   = '';
            if (!empty($first_tag = $this->get_first_tag_name())) {
                $data_page_number = '<' . $first_tag . ' {class}><a {class_a} href="' . ($this->cur_page != 1 ? $this->get_url() . '/1' : '#') . '">' . $this->get_first_link_text() . '</a></' . $first_tag . '>';
                if (!empty($class_pre = $this->get_prev_tag_class())) {
                    $extera_pre = '';
                    if ($this->cur_page == 1) {
                        $extera_pre = ' disabled';
                    }
                    if (is_array($class_pre)) {
                        $data_page_number = str_replace('{class}', 'class="{class} ' . implode(' ', $class_pre) . $extera_pre . '"', $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class}', 'class="{class} ' . $class_pre . $extera_pre . '"', $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class}', 'class"{class}"', $data_page_number);
                }
                if (!empty($this->get_attribute_class())) {
                    if (is_array($class = $this->get_attribute_class())) {
                        $data_page_number = str_replace('{class_a}', 'class="' . implode(' ', $class) . '"', $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class_a}', 'class="' . $class . '"', $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class_a}', '', $data_page_number);
                }
                if (!empty($class_pre_f = $this->get_first_tag_class())) {
                    if (is_array($class_pre_f)) {
                        $data_page_number = str_replace('{class}', implode(' ', $class_pre_f), $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class}', $class_pre_f, $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class}', '', $data_page_number);
                }
                $data_page_number .= '<' . $first_tag . ' {class}><a {class_a} href="' . ($this->cur_page != 1 ? $this->get_url() . '/' . ($this->get_cur_page() - 1) : '#') . '">' . $this->get_previous_link_text() . '</a></' . $first_tag . '>';
                if (!empty($class_pre = $this->get_prev_tag_class())) {
                    $extera_pre = '';
                    if ($this->cur_page == 1) {
                        $extera_pre = ' disabled';
                    }
                    if (is_array($class_pre)) {
                        $data_page_number = str_replace('{class}', 'class="{class} ' . implode(' ', $class_pre) . $extera_pre . '"', $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class}', 'class="{class} ' . $class_pre . $extera_pre . '"', $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class}', 'class"{class}"', $data_page_number);
                }
                if (!empty($this->get_attribute_class())) {
                    if (is_array($class = $this->get_attribute_class())) {
                        $data_page_number = str_replace('{class_a}', 'class="' . implode(' ', $class) . '"', $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class_a}', 'class="' . $class . '"', $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class_a}', '', $data_page_number);
                }
                if (!empty($class_pre_f = $this->get_first_tag_class())) {
                    if (is_array($class_pre_f)) {
                        $data_page_number = str_replace('{class}', implode(' ', $class_pre_f), $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class}', $class_pre_f, $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class}', '', $data_page_number);
                }
            }
            $i_val = 0;
            if ($page == $this->get_cur_page()) {
                $i_val = ($page + 1) - $this->get_display_page_link();
                $page_try = $page;
            } else {
                if ($this->get_cur_page() == 1) {
                    $i_val = $this->get_cur_page();
                    $page_try = $i_val + ($this->get_display_page_link() - 1);
                } else {
                    $i_val = ($this->get_cur_page() - 1);
                    $page_try = $i_val + $this->get_display_page_link();
                    if ($page_try > $page) {
                        $page_try = $page;
                        $i_val = $page - ($this->get_display_page_link() - 1);
                    }
                }
            }
            for ($i = $i_val; $i <= $page_try; $i++) {
                if (!empty($first_tag = $this->get_first_tag_name())) {
                    $data_page_number .= '<' . $first_tag . ' {class}>{data}</' . $first_tag . '>';
                }
                if (!empty($class = $this->get_first_tag_class())) {
                    $extera = '';
                    if ($this->cur_page == $i) {
                        $extera = " active";
                    }
                    if (is_array($class)) {
                        $data_page_number = str_replace('{class}', 'class="' . implode(' ', $class) . $extera . '"', $data_page_number);
                    } else {
                        $data_page_number = str_replace('{class}', 'class="' . $class . $extera . '"', $data_page_number);
                    }
                } else {
                    $data_page_number = str_replace('{class}', '', $data_page_number);
                }
                if (!empty($this->get_attribute_class())) {
                    if (is_array($class = $this->get_attribute_class())) {
                        $attribute = '<a href="' . $this->get_url() . '/' . $i . '" class="' . implode(' ', $class) . '">' . $i . '</a>';
                        $data_page_number = str_replace('{class_a}', 'class="' . implode(' ', $class) . '"', $data_page_number);
                    } else {
                        $attribute = '<a href="' . $this->get_url() . '/' . $i . '" class="' . $class . '">' . $i . '</a>';
                        $data_page_number = str_replace('{class_a}', 'class="' . $class . '"', $data_page_number);
                    }
                } else {
                    $attribute = '<a href="' . $this->get_url() . '/' . $i . '">' . $i . '</a>';
                    $data_page_number = str_replace('{class_a}', '', $data_page_number);
                }
                $data_page_number = str_replace('{data}', $attribute, $data_page_number);
            }
            $data_page_number .= '<' . $first_tag . ' {class}><a {class_a} href="' . ($this->cur_page != $page ? $this->get_url() . '/' . ($this->get_cur_page() + 1) : '#') . '">' . $this->get_next_link_text() . '</a></' . $first_tag . '>';
            if (!empty($class_next = $this->get_next_tag_class())) {
                $extera_pre = '';
                if ($this->cur_page == $page) {
                    $extera_pre = ' disabled';
                }
                if (is_array($class_next)) {
                    $data_page_number = str_replace('{class}', 'class="{class} ' . implode(' ', $class_next) . $extera_pre . '"', $data_page_number);
                } else {
                    $data_page_number = str_replace('{class}', 'class="{class} ' . $class_next . $extera_pre . '"', $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class}', 'class"{class}"', $data_page_number);
            }
            if (!empty($this->get_attribute_class())) {
                if (is_array($class = $this->get_attribute_class())) {
                    $data_page_number = str_replace('{class_a}', 'class="' . implode(' ', $class) . '"', $data_page_number);
                } else {
                    $data_page_number = str_replace('{class_a}', 'class="' . $class . '"', $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class_a}', '', $data_page_number);
            }
            if (!empty($class_pre_f = $this->get_first_tag_class())) {
                if (is_array($class_pre_f)) {
                    $data_page_number = str_replace('{class}', implode(' ', $class_pre_f), $data_page_number);
                } else {
                    $data_page_number = str_replace('{class}', $class_pre_f, $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class}', '', $data_page_number);
            }
            $data_page_number .= '<' . $first_tag . ' {class}><a {class_a} href="' . ($this->cur_page != $page ? $this->get_url() . '/' . $page : '#') . '">' . $this->get_last_link_text() . '</a></' . $first_tag . '>';
            if (!empty($class_next = $this->get_next_tag_class())) {
                $extera_pre = '';
                if ($this->cur_page == $page) {
                    $extera_pre = ' disabled';
                }
                if (is_array($class_next)) {
                    $data_page_number = str_replace('{class}', 'class="{class} ' . implode(' ', $class_next) . $extera_pre . '"', $data_page_number);
                } else {
                    $data_page_number = str_replace('{class}', 'class="{class} ' . $class_next . $extera_pre . '"', $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class}', 'class"{class}"', $data_page_number);
            }
            if (!empty($this->get_attribute_class())) {
                if (is_array($class = $this->get_attribute_class())) {
                    $data_page_number = str_replace('{class_a}', 'class="' . implode(' ', $class) . '"', $data_page_number);
                } else {
                    $data_page_number = str_replace('{class_a}', 'class="' . $class . '"', $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class_a}', '', $data_page_number);
            }
            if (!empty($class_pre_f = $this->get_first_tag_class())) {
                if (is_array($class_pre_f)) {
                    $data_page_number = str_replace('{class}', implode(' ', $class_pre_f), $data_page_number);
                } else {
                    $data_page_number = str_replace('{class}', $class_pre_f, $data_page_number);
                }
            } else {
                $data_page_number = str_replace('{class}', '', $data_page_number);
            }
            $this->paginition_query_string = str_replace('{data}', $data_page_number, $this->paginition_query_string);
        }
        return $this->get_paginition_query_string();
    }
    public function set_get(bool $get)
    {
        $this->data['get'] = $get;
    }
    public function get_get()
    {
        return $this->data['get'];
    }
    public function set_url($url)
    {
        $this->data['url'] = $url;
    }
    public function get_url()
    {
        return $this->data['url'];
    }
    public function get_total_rows()
    {
        return $this->data['total_rows'];
    }
    public function set_total_rows($totalRows)
    {
        $this->data['total_rows'] = $totalRows;
    }
    public function get_page_items()
    {
        return $this->data['page_items'];
    }
    public function set_page_items($pageItems)
    {
        $this->data['page_items'] = $pageItems;
    }
    public function get_f_page()
    {
        return $this->data['f_page'];
    }
    public function set_f_page($fPage)
    {
        $this->data['f_page'] = $fPage;
    }
    public function get_display_page_link()
    {
        return $this->data['display_page_link'];
    }
    public function set_display_page_link($display_page_link)
    {
        $this->data['display_page_link'] = $display_page_link;
    }
    public function get_first_link_text()
    {
        return $this->data['first_link_text'];
    }
    public function set_first_link_text($firstLinkText)
    {
        $this->data['first_link_text'] = $firstLinkText;
    }
    public function get_next_link_text()
    {
        return $this->data['next_link_text'];
    }
    public function set_next_link_text($nextLinkText)
    {
        $this->data['next_link_text'] = $nextLinkText;
    }
    public function get_previous_link_text()
    {
        return $this->data['previous_link_text'];
    }
    public function set_previous_link_text($previousLinkText)
    {
        $this->data['previous_link_text'] = $previousLinkText;
    }
    public function get_last_link_text()
    {
        return $this->data['last_link_text'];
    }
    public function set_last_link_text($lastLinkText)
    {
        $this->data['last_link_text'] = $lastLinkText;
    }
    public function get_full_tag_name()
    {
        return $this->data['full_tag_name'];
    }
    public function set_full_tag_name($fullTagName)
    {
        $this->data['full_tag_name'] = $fullTagName;
    }
    public function get_first_tag_name()
    {
        return $this->data['first_tag_name'];
    }
    public function set_first_tag_name($firstTagName)
    {
        $this->data['first_tag_name'] = $firstTagName;
    }
    public function get_last_tag_name()
    {
        return $this->data['last_tag_name'];
    }
    public function set_last_tag_name($lastTagName)
    {
        $this->data['last_tag_name'] = $lastTagName;
    }
    public function get_cur_tag_names()
    {
        return $this->data['cur_tag_names'];
    }
    public function set_cur_tag_names($curTagNames)
    {
        $this->data['cur_tag_names'] = $curTagNames;
    }
    public function get_next_tag_name()
    {
        return $this->data['next_tag_name'];
    }
    public function set_next_tag_name($nextTagName)
    {
        $this->data['next_tag_name'] = $nextTagName;
    }
    public function get_prev_tag_name()
    {
        return $this->data['prev_tag_name'];
    }
    public function set_prev_tag_name($prevTagName)
    {
        $this->data['prev_tag_name'] = $prevTagName;
    }
    public function get_paginition_query_string()
    {
        return $this->paginition_query_string;
    }
    public function get_full_tag_class()
    {
        return $this->data_class['full_tag_class'];
    }
    public function set_full_tag_class($fullTagClass)
    {
        $this->data_class['full_tag_class'] = $fullTagClass;
    }
    public function get_first_tag_class()
    {
        return $this->data_class['first_tag_class'];
    }
    public function set_first_tag_class($firstTagClass)
    {
        $this->data_class['first_tag_class'] = $firstTagClass;
    }
    public function get_last_tag_class()
    {
        return $this->data_class['last_tag_class'];
    }
    public function set_last_tag_class($lastTagClass)
    {
        $this->data_class['last_tag_class'] = $lastTagClass;
    }
    public function get_cur_tag_class()
    {
        return $this->data_class['cur_tag_class'];
    }
    public function set_cur_tag_class($curTagClass)
    {
        $this->data_class['cur_tag_class'] = $curTagClass;
    }
    public function get_next_tag_class()
    {
        return $this->data_class['next_tag_class'];
    }
    public function set_next_tag_class($nextTagClass)
    {
        $this->data_class['next_tag_class'] = $nextTagClass;
    }
    public function get_prev_tag_class()
    {
        return $this->data_class['prev_tag_class'];
    }
    public function set_prev_tag_class($prevTagClass)
    {
        $this->data_class['prev_tag_class'] = $prevTagClass;
    }
    public function get_attribute_class()
    {
        return $this->data_class['attribute_class'];
    }
    public function set_attribute_class($attribute_class)
    {
        $this->data_class['attribute_class'] = $attribute_class;
    }
    public function get_cur_page()
    {
        return $this->cur_page;
    }
    public function set_cur_page($cur_page)
    {
        $this->cur_page = $cur_page;
    }
    public function set_page_current()
    {
        $url = $_SERVER['REQUEST_URI'];
        $page_find = explode('/', $url);
        $array_count = count($page_find) - 1;
        if (is_numeric($page_find[$array_count])) {
            $this->set_cur_page($page_find[$array_count]);
        } else {
            $this->set_cur_page(1);
        }
        $this->init();
    }
}
