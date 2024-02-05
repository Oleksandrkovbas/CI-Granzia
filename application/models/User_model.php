<?php

	class User_model extends CI_Model {

		function __construct()
		{
			parent::__construct();

			$this->table = 'users';
			$this->primary_key = 'user_id';

			$this->add_rules = array(
				'user_name' => array(
		            'field' => 'user_name',
		            'label' => 'Username',
		            'rules' => 'trim|required|xss_clean|is_unique[users.user_name]',
		        ),
				'user_firstname' => array(
		            'field' => 'user_firstname',
		            'label' => 'First Name',
		            'rules' => 'trim|required|xss_clean',
		        ),
				'user_lastname' => array(
		            'field' => 'user_lastname',
		            'label' => 'Last Name',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'user_work_title' => array(
		            'field' => 'user_work_title',
		            'label' => 'Work Title',
		            'rules' => 'trim|required|xss_clean',
		        ),
				'user_password' => array(
		            'field' => 'user_password',
		            'label' => 'Password',
		            'rules' => 'trim|required',
		        ),
				// 'user_status' => array(
		        //     'field' => 'user_status',
		        //     'label' => 'User Status',
		        //     'rules' => 'trim|required',
		        // ),
				'user_email' => array(
		            'field' => 'user_email',
		            'label' => 'Email',
		            'rules' => 'trim|required|xss_clean|valid_email',
		        )
			);

			$this->edit_rules = array(
				/*'user_name' => array(
		            'field' => 'user_name',
		            'label' => 'Username',
		            'rules' => 'trim|required|xss_clean|is_unique[users.user_name]',
		        ),*/
				'user_firstname' => array(
		            'field' => 'user_firstname',
		            'label' => 'First Name',
		            'rules' => 'trim|required|xss_clean',
		        ),
				'user_lastname' => array(
		            'field' => 'user_lastname',
		            'label' => 'Last Name',
		            'rules' => 'trim|required|xss_clean',
		        ),
		        'user_work_title' => array(
		            'field' => 'user_work_title',
		            'label' => 'Work Title',
		            'rules' => 'trim|required|xss_clean',
		        ),
				// 'user_status' => array(
		        //     'field' => 'user_status',
		        //     'label' => 'User Status',
		        //     'rules' => 'trim|required',
		        // ),
				'user_email' => array(
		            'field' => 'user_email',
		            'label' => 'Email',
		            'rules' => 'trim|required|xss_clean|valid_email',
		        )
			);

			$this->column_headers = array(
				"User Name"	=>	"",
				"First Name"	=>	"",
				"Last Name"	=>	"",
				"Email"	=>	"",
				"Locations" => "",
				"Last Login"	=>	""
			);
		}

		function ViewAll($active_flag = false)
		{
			$this->db->select('*');
			$this->db->where('user_group_id != 1');
			$this->db->order_by("user_name", "asc");

			if($active_flag)
				$this->db->where('user_status', 1);

			$query = $this->db->get($this->table);

			$users = array();

			if($query->num_rows() > 0)
			{
				$users = $query->result_array();
			}
			return $users;
		}

		function GetInfoById($id)
		{
			$this->db->select('*');
			$this->db->where($this->primary_key, $id);
			$query = $this->db->get($this->table);

			if ($query->num_rows() == 1)
			{
				return $query->row_array();
			}
			else
			{
				return false;
			}
		}

		function Insert()
		{
			if(!$this->IsDuplicate($this->input->post('user_name')))
			{
				if($_FILES['user_image']['name'] != '')
				{
					$unique = $this->functions->GenerateUniqueFilePrefix();
					$image_file = $unique.'_'.preg_replace("/\s+/", "_", $_FILES['user_image']['name']);
					
					$config['file_name'] = $image_file;
					$config['upload_path'] = USERSPATH;
					$config['allowed_types'] = 'jpg|jpeg|png|webp';
					$config['max_size'] = '500';
					
					$this->upload->initialize($config);

					if (!$this->upload->do_upload('user_image'))
					{
						$data['error'] = array('error' => $this->upload->display_errors());
						print_r($data['error']);
						return false;
					}	
					else
					{
						$data['upload_data'] = $this->upload->data();

						$config['image_library'] = 'gd2';
						$config['source_image'] = USERSPATH.$image_file;
						$config['new_image'] = USERSPATH.'thumb/'.$image_file;
						$config['thumb_marker'] = false;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width']         = 480;
						//$config['height']       = '';
						$config['master_dim'] = 'auto'; //'width';

						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						if(!$this->image_lib->resize()) 
						{
	    					echo $this->image_lib->display_errors();
	    					print_r($data['error']);
	    					return false;
						}
						else
						{
							//
						}
					}	
				}
				

				$data = array(
					'user_firstname' 				=>	$this->input->post('user_firstname'),
					'user_lastname' 				=>	$this->input->post('user_lastname'),
					'user_work_title' 				=>	$this->input->post('user_work_title'),
					'user_email' 					=>	$this->input->post('user_email'),
					'user_image'					=>	$image_file,
					'user_status' 					=>	1,
					'user_name' 					=>	$this->input->post('user_name'),
					'user_group_id' 				=>	'2',
					'user_password' 				=>	password_hash($this->input->post('user_password').config_item('encryption_key'), PASSWORD_DEFAULT),
					'created_by' 					=>	$this->session->userdata('id'),
					'created_at' 					=>	date('Y-m-d H:i:s'),
					'updated_by' 					=>	$this->session->userdata('id'),
					'updated_at' 					=>	date('Y-m-d H:i:s'),
				);
				$this->db->insert($this->table, $data);
				$pk_id = $this->db->insert_id();

				return $pk_id;	
			}
			else
			{
				return false;
			}
		}

		function Update()
		{
			if(!$this->IsDuplicate($this->input->post('user_name'), $this->input->post('pk_id')))
			{
				if($_FILES['user_image']['name'] == '')
					$image_file = $this->input->post('oldimagefile');
				else
				{				
					$unique = $this->functions->GenerateUniqueFilePrefix();
					$image_file = $unique.'_'.preg_replace("/\s+/", "_", $_FILES['user_image']['name']);
					
					$config['file_name'] = $image_file ;
					$config['upload_path'] = USERSPATH ;
					$config['allowed_types'] = 'jpg|jpeg|png|webp';
					$config['max_size'] = '500';

					$this->upload->initialize($config);
		
					if (!$this->upload->do_upload('user_image'))
					{
						$data['error'] = array('error' => $this->upload->display_errors());
						print_r($data['error']);
						return false;
					}	
					else
					{
						if(file_exists(USERSPATH.'thumb/'.$this->input->post('oldimagefile')))
							@unlink(USERSPATH.'thumb/'.$this->input->post('oldimagefile'));

						if(file_exists(USERSPATH.$this->input->post('oldimagefile')))
							@unlink(USERSPATH.$this->input->post('oldimagefile'));

						$data['upload_data'] = $this->upload->data();

						$config['image_library'] = 'gd2';
						$config['source_image'] = USERSPATH.$image_file;
						$config['new_image'] = USERSPATH.'thumb/'.$image_file;
						$config['thumb_marker'] = false;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width']         = 480;
						//$config['height']       = '';
						$config['master_dim'] = 'auto'; //'width';

						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						if(!$this->image_lib->resize()) 
						{
        					echo $this->image_lib->display_errors();
        					print_r($data['error']);
        					return false;
    					}
    					else
    					{
    						//
    					}
					}	
				}

				if($this->input->post('user_status'))
					$user_status = $this->input->post('user_status');
				else
					$user_status = 0;

				$data = array(
					'user_firstname' 				=>	$this->input->post('user_firstname'),
					'user_lastname' 				=>	$this->input->post('user_lastname'),
					'user_work_title' 				=>	$this->input->post('user_work_title'),
					'user_email' 					=>	$this->input->post('user_email'),
					'user_image'					=>	$image_file,
					'user_status' 					=>	$user_status,
					//'user_name' 					=>	$this->input->post('user_name'),
					'user_group_id' 				=>	'2',
					'user_password' 				=>	password_hash($this->input->post('user_password').config_item('encryption_key'), PASSWORD_DEFAULT),
					'updated_by' 					=>	$this->session->userdata('id'),
					'updated_at' 					=>	date('Y-m-d H:i:s'),
				);

				if($this->input->post('user_password') == '')
				{
					unset($data['user_password']);
				}

				$this->db->where($this->primary_key, $this->input->post('pk_id'));
				$this->db->update($this->table, $data);

				return true;	
			}
			else
			{
				return false;
			}
		}

		function Delete()
		{
			if($this->input->post('pk_id'))
			{
				$rsFile = $this->GetInfoById($this->input->post('pk_id'));

				if(file_exists(USERSPATH.'thumb/'.$rsFile['user_image']))
					@unlink(USERSPATH.'thumb/'.$rsFile['user_image']);
				
				if(file_exists(USERSPATH.$rsFile['user_image']))
					@unlink(USERSPATH.$rsFile['user_image']);	

				$this->db->delete($this->table, array($this->primary_key => $this->input->post('pk_id')));
				return true;
			}
			else
				return false;
		}

		function IsDuplicate($user_name,$pk='')
		{
			$sql = "select * from ".$this->table . " where user_name = '".$user_name."' ";
			
			if(!empty($pk))
				$sql .= " AND user_id != '".$pk."' ";

			$rs = $this->db->query($sql);
			
			if ( $rs->num_rows() > 0 )
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		function UpdateProfile()
		{
			//if(!$this->IsDuplicate($this->input->post('user_email'), $this->input->post('user_id')))
			{
				if($_FILES['user_image']['name'] == '')
					$image_file = $this->input->post('oldimagefile');
				else
				{				
					$unique = $this->functions->GenerateUniqueFilePrefix();
					$image_file = $unique.'_'.preg_replace("/\s+/", "_", $_FILES['user_image']['name']);
					
					$config['file_name'] = $image_file ;
					$config['upload_path'] = USERSPATH ;
					$config['allowed_types'] = 'jpg|jpeg|png|webp';
					$config['max_size'] = '500';

					$this->upload->initialize($config);
		
					if (!$this->upload->do_upload('user_image'))
					{
						$data['error'] = array('error' => $this->upload->display_errors());
						print_r($data['error']);
						return false;
					}	
					else
					{
						if(file_exists(USERSPATH.'thumb/'.$this->input->post('oldimagefile')))
							@unlink(USERSPATH.'thumb/'.$this->input->post('oldimagefile'));

						if(file_exists(USERSPATH.$this->input->post('oldimagefile')))
							@unlink(USERSPATH.$this->input->post('oldimagefile'));

						$data['upload_data'] = $this->upload->data();

						$config['image_library'] = 'gd2';
						$config['source_image'] = USERSPATH.$image_file;
						$config['new_image'] = USERSPATH.'thumb/'.$image_file;
						$config['thumb_marker'] = false;
						$config['create_thumb'] = TRUE;
						$config['maintain_ratio'] = TRUE;
						$config['width']         = 480;
						//$config['height']       = '';
						$config['master_dim'] = 'auto'; //'width';

						$this->load->library('image_lib', $config);
						$this->image_lib->initialize($config);
						if(!$this->image_lib->resize()) 
						{
        					echo $this->image_lib->display_errors();
        					print_r($data['error']);
        					return false;
    					}
    					else
    					{
    						//
    					}
					}	
				}

				$data = array(
					'user_firstname'	=>	$this->input->post('user_firstname'),
					'user_lastname'		=>	$this->input->post('user_lastname'),
					//'user_name' 		=>	$this->input->post('user_name'),
					'user_email' 		=>	$this->input->post('user_email'),
					'user_work_title' 	=>	$this->input->post('user_work_title'),
					'user_website' 		=>	$this->input->post('user_website'),
					'user_phone' 		=>	$this->input->post('user_phone'),
					//'editor_api_key'    =>	$this->input->post('editor_api_key'),
					'user_image'		=>	$image_file,
					'user_password' 	=>	password_hash($this->input->post('user_password').config_item('encryption_key'), PASSWORD_DEFAULT),
					'updated_by' 		=>	$this->session->userdata('id'),
					'updated_at' 		=>	date('Y-m-d H:i:s'),
				);

				if($this->input->post('user_password') == '')
				{
					unset($data['user_password']);
				}
							
				$this->db->where('user_id', $this->input->post('user_id'));
				$this->db->update($this->table, $data);					
				return true;
			}
			//else
				//return false;
		}
	}
?>