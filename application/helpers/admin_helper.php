<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

// --------------------------------------------------------------------


if (!function_exists('rec_show'))
{
    /**
     * rec_show()
     * 递归输出select table 等
     * @param mixed $array
     * @param string $sprintf
     * @param integer $reid
     * @param string $separator
     * @param bool $isselect
     * @param bool $isedit
     * @return void
     */
    function rec_show($array, $sprintf = '<option value="{id}"{selected}>{separator}{typename}</option>', $reid = 0, $separator = '', $isselect = false, $isedit = false)
    {
        foreach ($array as $arrayA) {
            if ($isedit && $arrayA['id'] == $isedit) {
                continue;
            }
            if ($arrayA['reid'] == $reid) {
                preg_match_all('/(?:{)(.+?)(?:})/i', $sprintf, $preg_match);
                $preg_match = $preg_match[1];
                foreach ($preg_match as $line) {
                    if (isset($arrayA[$line])) {
                        $str_replace_A[] = '{'.$line.'}';
                        $str_replace_B[] = $arrayA[$line];                        
                    }
                }
                $str_replace_A[] = '{separator}';
                $str_replace_B[] = $separator;
                $str_replace_A[] = '{selected}';
                $str_replace_B[] = $isselect && $arrayA['id'] == $isselect ? ' selected' : '';
                
                echo str_replace($str_replace_A, $str_replace_B, $sprintf);
                unset($str_replace_A);
                unset($str_replace_B);
                rec_show($array, $sprintf, $arrayA['id'], '&nbsp;&nbsp;'.$separator, $isselect, $isedit);
            }
        }
    }
}

// --------------------------------------------------------------------

/**
 * 提示信息显示
 * @param string $str
 * @return 
 */
if (!function_exists('admintip'))
{
    function admintip($str, $back = '', $expire = 3)
    {
        $CI = &get_instance();
        if (stripos($str, 'error:') === 0)
        {
            $str = str_replace('error:', '', $str);
            $status = 'error';
        }
        else
        {
            $status = 'success';
        }
        $CI->input->set_cookie('admintip', '<p class="' . $status . '">' . $str . '</p>',
            $expire);
        if ($back == '')
        {
            $back = getrefer();
        }
        redirect($back);
        exit;
    }
}

// --------------------------------------------------------------------

/**
 * 删除目录下所有文件
 * @param string $imagepath
 * @return 
 */
if (!function_exists('clean_files'))
{
    function clean_files($path)
    {
        if ($handle = opendir("$path")) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$path/$item" ) ) {
                        clean_files( "$path/$item" );
                    } else {
                        unlink( "$path/$item" ) ;
                    }
                }
            }
            closedir( $handle );
            rmdir( $path );
        }
    }
}

// --------------------------------------------------------------------

/**
 * 水印处理
 * @param string $imagepath
 * @return 
 */
if (!function_exists('watermark'))
{
    function watermark($imagepath)
    {
        include (getcwd() . '/application/config/image_lib.php');
        if ($config['wm_ing'] == 1)
        {
            $CI = &get_instance();
            $config['source_image'] = $imagepath;
            $CI->load->library('image_lib', $config);
            $CI->image_lib->watermark();
        }
    }
}

// --------------------------------------------------------------------

/**
 * 后台图片上传处理程序
 * @param 
 * @return string/json
 */
if (!function_exists('adminUpload'))
{
    function adminUpload($filename)
    {
        $upload_subpath = '/public/upload/' . date('Ym') . '/';
        $upload_path = getcwd() . $upload_subpath;
        if (!is_dir($upload_path))
        {
            mkdir($upload_path, 0777);
        }
        $CI = &get_instance();
        $upload['upload_path'] = $upload_path;
        $upload['allowed_types'] = 'gif|jpg|png';
        $upload['overwrite'] = false;
        $upload['encrypt_name'] = true;
        $upload['remove_spaces'] = true;
        $upload['max_size'] = '2048';
        $CI->load->library('upload', $upload);
        if ($CI->upload->do_upload($filename))
        {
            $return = $CI->upload->data();
            watermark($upload_path . $return['file_name']); //水印处理
            $litpic = base_url() . $upload_subpath . $return['file_name'];
        }
        else
        {
            $litpic = '';
        }
        return $litpic;
    }
}

// --------------------------------------------------------------------


/* End of file admin_helper.php */
/* Location: ./application/helpers/admin_helper.php */
