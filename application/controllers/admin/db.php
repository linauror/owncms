<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Db extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->User_mdl->checkpurview();
        $this->db_backup_path = config_item('db_backup_path');
    }

    // ------------------------------------------------------------------------

    /**
     * Db::index()
     * 
     * @return void
     */
    public function index()
    {
        $dbfiles = glob($this->db_backup_path . '*.sql');
        $dbfiles && rsort($dbfiles);

        $html['db_backup_path'] = $this->db_backup_path;
        $html['dbfiles'] = $dbfiles;
        $this->load->view('admin/db', $html);
    }

    // ------------------------------------------------------------------------

    /**
     * Db::backup()
     * 
     * @return void
     */
    public function backup()
    {
        if (!is_really_writable($this->db_backup_path)) admintip('error:'.$this->db_backup_path.'目录不可写！');
        // 设置SQL文件保存文件名
        $fileName = date("YmdHis") . '.sql';
        $filePath = $this->db_backup_path . $fileName;
        $this->load->dbutil();
        $this->load->helper('file');
        $prefs = array('tables' => array(), // 包含了需备份的表名的数组.
            'ignore' => array('log'), // 备份时需要被忽略的表
            'format' => 'txt', // gzip, zip, txt
            'filename' => $fileName, // 文件名 - 如果选择了ZIP压缩,此项就是必需的
            'add_drop' => true, // 是否要在备份文件中添加 DROP TABLE 语句
            'add_insert' => true, // 是否要在备份文件中添加 INSERT 语句
            'newline' => "\n" // 备份文件中的换行符
            );
        $backup = $this->dbutil->backup($prefs);
        write_file($filePath, $backup);
        $this->User_mdl->userlog_add('【数据库备份/还原】备份数据：' . $filePath);
        admintip('成功备份数据！');
    }

    // ------------------------------------------------------------------------

    /**
     * Db::down()
     * 
     * @return void
     */
    public function down()
    {
        $dbfile = $this->input->get('db');
        $this->User_mdl->userlog_add('【数据库备份/还原】下载数据：' . $dbfile);
        $dbfileCode = file_get_contents($dbfile);
        $this->load->helper('download');
        force_download(str_replace(config_item('db_backup_path'), '', $dbfile), $dbfileCode);
    }

    // ------------------------------------------------------------------------

    /**
     * Db::del()
     * 
     * @return void
     */
    public function del()
    {
        $dbfile = $this->input->get('db');
        if (unlink($dbfile))
        {
            $this->User_mdl->userlog_add('【数据库备份/还原】删除数据：' . $dbfile);
            admintip('成功删除备份数据库文件！');
        }
        else
        {
            admintip('error:文件删除失败，请检查权限！');
        }
    }

    // ------------------------------------------------------------------------

    /**
     * Db::alldel()
     * 
     * @return void
     */
    public function alldel()
    {
        $post = $this->input->post('id');
        if ($post)
        {
            foreach ($post as $line)
            {
                unlink($line);
            }
            $this->User_mdl->userlog_add('【数据库备份/还原】批量删除备份');
            admintip('成功批量删除备份文件！');
        }
        else
        {
            admintip('error:请选择删除项目！');
        }
    }

    // ------------------------------------------------------------------------
}

/* End of file db.php */
/* Location: ./application/controllers/admin/db.php */
