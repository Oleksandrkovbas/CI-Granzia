<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class UserLogin_Model extends CI_Model
{
    public $table_name = 'users';

    public $rules = array(
        'user_name' => array(
            'field' => 'user_name',
            'label' => 'User Name',
            'rules' => 'trim|required|xss_clean',
        ),
        'password' => array(
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'trim|required',
        ),
    );

    public function login($username, $password)
    {
        $this->db->where('user_name', $username);
        //$this->db->where('user_group_id', 2);
		$this->db->where('user_group_id!=', 1);
        $this->db->where('user_status', '1');
        $query = $this->db->get($this->table_name);

        if ($query->num_rows() == 1)
        {
            $user = $query->row_array();

            if(password_verify($password.config_item('encryption_key'), $user['user_password']))
            {
                $data = array(
                        'id'            => $user['user_id'],
                        'username'      => $user['user_name'],
                        'firstname'     => $user['user_firstname'],
                        'lastname'      => $user['user_lastname'],
                        'email'         => $user['user_email'],
                        'work_title'    => $user['user_work_title'],
                        'image'         => $user['user_image'],
                        'loggedin'      => false,
                        'user_loggedin' => true,
                        'group_id'      => $user['user_group_id'],
                );

                $this->session->set_userdata($data);

                $login_time = array("user_last_login" => date("Y-m-d H:i:s"));
                $this->db->where('user_id', $user['user_id']);
                $this->db->update($this->table_name, $login_time);

                return true;
            }
            else
            {
                return false;
            }
        }
        else {
          return false;
        }
    }

    public function logout()
    {
        $this->session->sess_destroy();
    }

    public function loggedin()
    {
        return (bool) $this->session->userdata('user_loggedin');
    }

    function IsValidUser($email)
    {
        $this->db->select('*');
        $this->db->where('user_email', $email);

        $query = $this->db->get($this->table_name);

        if ( $query->num_rows() == 1 )
        {
            return $query->row_array();
        }
        else
        {
            return false;
        }
    }
}