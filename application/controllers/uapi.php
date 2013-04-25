<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Uapi extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Uapi::checklogin()
     * 检测登录，检测到登录既返回用户信息
     * @return void
     */
    public function checklogin()
    {
        if ($this->User_mdl->uid) {
            $user_info = $this->User_mdl->get('*', $this->User_mdl->uid);
            $user_info['avatar'] = 'http://www.gravatar.com/avatar/'.md5(strtolower($user_info['usermail']));
            exit(json_encode($user_info));
        }
        exit('');
    } 
}

/* End of file uapi.php */
/* Location: ./application/controllers/uapi.php */
