<?php
/**
 * @name        OpenBlog - An Open Source Blog Application
 * @author      Anik Ghosh
 * @link        https://github.com/anikghosh356/OpenBlog
 * @license     https://opensource.org/licenses/MIT	MIT License
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

  public function register(){
      if($this->session->userdata('logged_in')){
         redirect('Home');
       }
       $data['pageTitle'] = 'Create an account';
       $data['categories']= $this->Admin_model->getCategories();
       $data['socialIcons']= $this->Page_model->getsocialIcons();
       //page meta
       $this->load->helper('url');
       $data['pageMeta']= array(
        'pageUrl' => current_url(), 
        'pageThumbnail'=>$this->Page_model->getsiteDetails()['site_logo'],
        'siteLogo'=>$this->Page_model->getsiteDetails()['site_logo'],
        'favIcon'=> $this->Page_model->getsiteDetails()['site_favicon'],
        'siteName'=> $this->Page_model->getsiteDetails()['site_name'],
        'pageDes'=>'Create a account'

       );

       $this->form_validation->set_rules('username', 'Username', 'trim|required|callback_check_username_exists');
       $this->form_validation->set_rules('email', 'Email', 'trim|required|callback_check_email_exists');
       $this->form_validation->set_rules('fullName', 'Full Name', 'trim|required');
       $this->form_validation->set_rules('password1', 'Password', 'trim|required');
       $this->form_validation->set_rules('password2', 'Confirm Password', 'trim|required|matches[password1]');



  		if($this->form_validation->run() === FALSE){

           $this->load->view('templates/header', $data);
           $this->load->view('user/register' ,$data);
           $this->load->view('templates/userfooter');
  			} else {

        // Encrypt password
        $enc_password = md5($this->input->post('password1')."@#**");
        $this->User_model->register($enc_password);
        $this->UserActivity->addActivity($this->security->xss_clean($this->input->post('username')), 'You are now registered user..');
		$this->session->set_flashdata('user_registered', 'You are now registered and can log in');
		redirect('Login');
      }

  	}

  public function login(){
  		$this->load->library('user_agent');
  	
    if($this->session->userdata('logged_in')){
				redirect('Home');
			}
			$data['pageTitle'] = 'Log In';
			$data['categories']= $this->Admin_model->getCategories();
			$data['socialIcons']= $this->Page_model->getsocialIcons();
			//page meta
	       $this->load->helper('url');
	       $data['pageMeta']= array(
	        'pageUrl' => current_url(), 
	        'pageThumbnail'=>$this->Page_model->getsiteDetails()['site_logo'],
	        'siteLogo'=>$this->Page_model->getsiteDetails()['site_logo'],
	        'favIcon'=> $this->Page_model->getsiteDetails()['site_favicon'],
	        'siteName'=> $this->Page_model->getsiteDetails()['site_name'],
	        'pageDes'=>'Create a account'

	       );

			$this->form_validation->set_rules('userName', 'Username', 'trim|required');
			$this->form_validation->set_rules('passWord', 'Password', 'trim|required');
			if($this->form_validation->run() === FALSE){
				$this->load->view('templates/header',$data);
				$this->load->view('user/login', $data);
				$this->load->view('templates/userfooter');
			} else {

				// Get username
				$username = $this->security->xss_clean($this->input->post('userName'));
				// Get and encrypt the password
				$password = md5($this->input->post('passWord')."@#**");
				// Login user
				$userData = $this->User_model->login($username, $password);
				
				if($userData){
					// Create session
					$userdata = array(
						'user_id' => $userData['user_id'],
						'username' => $userData['userName'],
						'user_role' => $userData['userPosition'],
						'userImg' => $userData['userImg'],
						'logged_in' => true
					);
					$this->session->set_userdata($userdata);
					$this->UserActivity->addActivity($this->session->userdata('username'), 'You are now logged in..');
					// Set message
					if ($this->session->userdata('user_role') == 'admin') {
						$this->session->set_flashdata('user_loggedin', 'You are now logged in');
					redirect('Admin');
					}else{
						
						$this->session->set_flashdata('user_loggedin', 'You are now logged in');
					redirect('home');
					}
					
				} else {
					// Set message
					$this->session->set_flashdata('login_failed', 'Login is invalid');
					redirect('login');
				}
			}
		}

    // Log user out
		public function logout(){
			$this->UserActivity->addActivity($this->session->userdata('username'), 'You are now logged out..');
			// Unset user data
			$this->session->unset_userdata('logged_in');
			$this->session->unset_userdata('user_id');
      $this->session->unset_userdata('username');
			$this->session->unset_userdata('user_role');
			// Set message
			
			$this->session->set_flashdata('user_loggedout', 'You are now logged out');
			redirect('Login');
		}


  public function do_crop($filename){
        $destination_thumbs="./uploads/thumb/";
        $upload_path="./uploads/";
        $this->load->library('image_moo') ;
        $this->image_moo
        ->load($upload_path.$filename)
        ->resize(200,200)
        ->save($destination_thumbs.$filename);
      }


    // Check if username exists
	public function check_username_exists($username){
		$this->form_validation->set_message('check_username_exists', 'That username is taken. Please choose a different one');
		if($this->User_model->check_username_exists($username)){
			return true;
		} else {
			return false;
		}
	}

    // Check if email exists
    public function check_email_exists($email){
      $this->form_validation->set_message('check_email_exists', 'That email is taken. Please set a different one');
      if($this->User_model->check_email_exists($email)){
        return true;
      } else {
        return false;
      }
    }



}
