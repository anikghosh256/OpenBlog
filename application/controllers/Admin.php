<?php
/**
 * @name        OpenBlog - An Open Source Blog Application
 * @author      Anik Ghosh
 * @link        https://github.com/anikghosh356/OpenBlog
 * @license     https://opensource.org/licenses/MIT	MIT License
 *
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function dashboard(){

        if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }
        
        $data['pageTitle']= 'Admin Dashboard';
        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));

        $data['views']= $this->getViews(30);
        $data['allTimePageView']= $this->allTimePageView()[0];
        $data['allTimeUniqueView']= $this->allTimePageView()[1];
        $data['recentPosts']=$this->Member_model->getRecentPost(6);

        $data['getPostComCount']= $this->getPostComCount();

        $this->load->view('admin/templates/header',$data);
		$this->load->view('admin/dashboard', $data);
		$this->load->view('admin/templates/footer',$data);
    }

    public function create(){
			if($this->session->userdata('logged_in')){
	        	if ($this->session->userdata('user_role') != 'admin') {
	        		redirect('member');
	        	}
	        }else{
	        	redirect('Login');
	        }

	        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
			$data['pageTitle'] = 'Create Post';
			$data['categories']= $this->Admin_model->getCategories();

			$this->form_validation->set_rules('postTitle', 'Title', 'required|trim');
			$this->form_validation->set_rules('category', 'Category', 'required|trim');
			$this->form_validation->set_rules('postContent', 'Body', 'required');
			$this->form_validation->set_rules('tags', 'Tags', 'required|trim');
			if($this->form_validation->run() === FALSE){
				$this->load->view('admin/templates/header',$data);
				$this->load->view('admin/create', $data);
				$this->load->view('admin/templates/footer',$data);
			} else {
				// Upload Image
				// Get filename.
				$temp = explode(".", $_FILES["postThumbnail"]["name"]);
				// Get extension.
				$imageType = strtolower(end($temp));
				$ThumbnailName = sha1(microtime()) . "." . $imageType;

				$config['upload_path'] = './images/temp';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF';
				$config['max_size'] = '5000';
				$config['max_width'] = '4000';
				$config['max_height'] = '4000';
				$config['file_name'] =$ThumbnailName;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('postThumbnail')){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = 'noimage.jpg';

				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $ThumbnailName;
					//thumbnail resizeing

					//580x250
	        		$this->doResize($post_image, '580', '250', '580x250');

	        		// 290x170
	        		$this->doResize($post_image, '290', '170', '290x170');

	        		//90x65
	        		$this->doResize($post_image,'90', '65', '90x65');
				}
        		
				$this->Admin_model->createPost($post_image);
				// Set message
				$this->session->set_flashdata('post_created', 'Your post has been created');
				redirect('admin');
			}
    }

    public function edit($slug=''){
			if($this->session->userdata('logged_in')){
	        	if ($this->session->userdata('user_role') != 'admin') {
	        		redirect('member');
	        	}
	        }else{
	        	redirect('Login');
	        }

	        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
			$data['pageTitle'] = 'Edit Posts';
			$data['categories']= $this->Admin_model->getCategories();

			if ($slug=='') {
		       $data['recentPostsByUser']=$this->Member_model->getRecentPost(FALSE);

				$this->load->view('admin/templates/header',$data);
				$this->load->view('admin/sedit', $data);
				$this->load->view('admin/templates/footer',$data);
			}else{

				$data['postedit']=$this->Admin_model->editpost($slug);
				if ($data['postedit']) {
					$this->load->view('admin/templates/header',$data);
					$this->load->view('admin/edit', $data);
					$this->load->view('admin/templates/footer',$data);
				}else{
					redirect('admin/edit');
				}

				
			}
		
    }

	public function delete($slug=''){
			if($this->session->userdata('logged_in')){
	        	if ($this->session->userdata('user_role') != 'admin') {
	        		redirect('member');
	        	}
	        }else{
	        	redirect('Login');
	        }

	        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
			$data['pageTitle'] = 'Delete Posts';
			$data['categories']= $this->Admin_model->getCategories();

			if ($slug=='') {
		       $data['recentPostsByUser']=$this->Member_model->getRecentPost(FALSE);

				$this->load->view('admin/templates/header',$data);
				$this->load->view('admin/sdelete', $data);
				$this->load->view('admin/templates/footer',$data);
			}else{

				$this->Admin_model->deletePost($slug);
				// Set message
				$this->session->set_flashdata('post_deleted', 'Your post has been deleted');
				redirect('admin/dashboard');

				}
		
    }

    public function update($slug=''){
    	if($this->session->userdata('logged_in')){
	        	if ($this->session->userdata('user_role') != 'admin') {
	        		redirect('member');
	        	}
	        }else{
	        	redirect('Login');
	        }
    	if ($slug=='') {
    		$this->session->set_flashdata('wrong', 'something wrong..!!');
				redirect('admin/dashboard');
    	}

		$this->form_validation->set_rules('postTitle', 'Title', 'required|trim');
		$this->form_validation->set_rules('category', 'Category', 'required|trim');
		$this->form_validation->set_rules('postContent', 'Body', 'required');
		$this->form_validation->set_rules('tags', 'Tags', 'required|trim');
		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('wrong', 'somthing wrong..!!');
				redirect('admin/dashboard');
		}else{
			$this->Admin_model->updatePost($slug);
			// Set message
			$this->session->set_flashdata('post_updated', 'Your post has been updated');
			redirect('admin/dashboard');
		}


    }

    public function categories(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Categories';
	    $data['categories']= $this->Admin_model->getCategories();


	    $this->load->view('admin/templates/header',$data);
		$this->load->view('admin/categories', $data);
		$this->load->view('admin/templates/footer',$data);

    }

 
    public function addcat(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }

        $this->form_validation->set_rules('catName', 'Category Name', 'required|trim');
		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('wrong', 'something wrong..!!');
				redirect('admin/categories');
		} else {
			$this->Admin_model->addcat();
			// Set message
			$this->session->set_flashdata('catCreaded', 'Your Category has been created');
			redirect('admin/Categories');
		}

    }
    public function categoryEdit($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }
        if ($id =='') {
        	redirect('admin/Categories');
        }

        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Edit Category';
	    $data['categories']= $this->Admin_model->getCategories();
	    $data['category']= $this->Admin_model->getCategory($id);



        $this->form_validation->set_rules('catName', 'Category Name', 'required|trim');
        $this->form_validation->set_rules('catPosition', 'Category Position', 'required|trim');
		if($this->form_validation->run() === FALSE){
			$this->load->view('admin/templates/header',$data);
			$this->load->view('admin/categoryEdit', $data);
			$this->load->view('admin/templates/footer',$data);
		} else {
			$this->Admin_model->updateCat($id);
			// Set message
			$this->session->set_flashdata('catUpdated', 'Your Category has been updated');
			redirect('admin/Categories');
		}

    }

    public function categoryDelete($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }
        if ($id =='') {
        	redirect('admin/Categories');
        }
        $this->Admin_model->deleteCat($id);
		// Set message
		$this->session->set_flashdata('catDeleted', 'Your Category has been deleted');
		redirect('admin/Categories');


    }

    public function comments(){

		if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['comments']= $this->Admin_model->getAllComments();
	    $data['pageTitle'] = 'comments';


	    $this->load->view('admin/templates/header',$data);
		$this->load->view('admin/comments', $data);
		$this->load->view('admin/templates/footer',$data);
    }

    public function delCom($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    if ($id=='') {
	    	redirect('admin/comments');
	    }

	    if ($this->Member_model->updateComC($this->Member_model->getComAuthA($id)['com_for']) &&  $this->Admin_model->delCom($id) ) {

	    	$this->session->set_flashdata('com_deleted', 'Comment has been deleted');
			redirect('admin/comments');
	    }else{
	    	$this->session->set_flashdata('com_error', 'something worng ..!');
			redirect('admin/comments');
	    }
	    
    }

    public function users($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));

	    if ($id=='') {
	    	
		    $data['users']= $this->Admin_model->getAllUsers();
		    $data['pageTitle'] = 'All member of this site';

		    $this->load->view('admin/templates/header',$data);
			$this->load->view('admin/users', $data);
			$this->load->view('admin/templates/footer',$data);

	    }else{

			$data['user']= $this->Admin_model->getUser($id);
		    $data['pageTitle'] = 'Profile of '.$data['user']['fullName'];

		    $this->load->view('admin/templates/header',$data);
			$this->load->view('admin/profile', $data);
			$this->load->view('admin/templates/footer',$data);
	    }
    }


    public function uDelete($id){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    if ($id=='') {
	    	redirect('admin/users');
	    }

	    if ($this->Member_model->updateComC($this->Admin_model->uDelete($id)) ) {

	    	$this->session->set_flashdata('user_deleted', 'Comment has been deleted');
			redirect('admin/users');
	    }else{
	    	$this->session->set_flashdata('user_error', 'something worng ..!');
			redirect('admin/users');
	    }
    }

    public function socialIcons(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Social Icons';
	    $data['socialIcons']= $this->Page_model->getsocialIcons();


	    $this->load->view('admin/templates/header',$data);
		$this->load->view('admin/socialIcons', $data);
		$this->load->view('admin/templates/footer',$data);

    }

    public function addSLink(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }

        $this->form_validation->set_rules('SocialName', 'Name', 'required|trim');
        $this->form_validation->set_rules('socialLink', 'Link', 'required|trim');
        $this->form_validation->set_rules('socialIcon', 'Icon', 'required|trim');
		if($this->form_validation->run() === FALSE){
			$this->session->set_flashdata('wrong', 'something wrong..!!');
				redirect('admin/socialIcons');
		} else {
			$this->Admin_model->addSLink();
			// Set message
			$this->session->set_flashdata('sCreaded', 'Your Link has been created');
			redirect('admin/socialIcons');
		}
    }

    public function sLinkEdit($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }
        if ($id =='') {
        	redirect('admin/socialIcons');
        }

        $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Edit Social link';
	    $data['socialIcons']= $this->Page_model->getsocialIcons();
	    $data['sLink']= $this->Admin_model->getSocialIcon($id);



        $this->form_validation->set_rules('SocialName', 'Name', 'required|trim');
        $this->form_validation->set_rules('socialLink', 'Link', 'required|trim');
        $this->form_validation->set_rules('socialIcon', 'Icon', 'required|trim');
        
        if (empty($_FILES["profileImage"]["name"] )) {
					$post_image = 'noAvatar.jpg';
			}else{
				// Upload Image
				// Get filename.
				$temp = explode(".", $_FILES["profileImage"]["name"]);
				// Get extension.
				$imageType = strtolower(end($temp));
				$profileImage = sha1(microtime()) . "." . $imageType;

				$config['upload_path'] = './images/temp';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF';
				$config['max_size'] = '5000';
				$config['max_width'] = '4000';
				$config['max_height'] = '4000';
				$config['file_name'] =$profileImage;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('profileImage')){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = 'noAvatar.jpg';

				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $profileImage;
					//thumbnail resizeing

	        		//90x65
	        		$this->doResize($post_image,'90', '65', 'profile');
				}
			}
			
		if($this->form_validation->run() === FALSE){

			$this->load->view('admin/templates/header',$data);
			$this->load->view('admin/socialLinkEdit', $data);
			$this->load->view('admin/templates/footer',$data);
		} else {
			$this->Admin_model->updateSlink($id);
			// Set message
			$this->session->set_flashdata('sUpdated', 'Your Social Link has been updated');
			redirect('admin/socialIcons');
		}

    }

    public function sLinkDelete($id=''){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
        }else{
        	redirect('Login');
        }
        if ($id =='') {
        	redirect('admin/socialIcons');
        }
        $this->Admin_model->deleteSIcon($id);
		// Set message
		$this->session->set_flashdata('sDeleted', 'Your Social Icon has been deleted');
		redirect('admin/socialIcons');


    }

    public function websiteDetails(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Website Details';
	    $data['siteDetails']= $this->Page_model->getsiteDetails();


	    $this->load->view('admin/templates/header',$data);
		$this->load->view('admin/websiteDetails', $data);
		$this->load->view('admin/templates/footer',$data);
    }

    public function editDetails(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Website Details';
	    $data['siteDetails']= $this->Page_model->getsiteDetails();


	    

		$this->form_validation->set_rules('siteTitle', 'Site Title', 'required|trim');
        $this->form_validation->set_rules('siteTagline', 'TagLine', 'required|trim');
        $this->form_validation->set_rules('siteDes', 'Description', 'trim');
		if($this->form_validation->run() === FALSE){
			$this->load->view('admin/templates/header',$data);
			$this->load->view('admin/editDetails', $data);
			$this->load->view('admin/templates/footer',$data);
		} else {
			$this->Admin_model->updateSD($data['siteDetails']['d_id']);
			// Set message
			$this->session->set_flashdata('siteUpdated', 'Your Site Details  has been updated');
			redirect('admin/websiteDetails');
		}
    }

    public function editLogo(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Update Logo';
	    $data['siteDetails']= $this->Page_model->getsiteDetails();
	    $d_id=$data['siteDetails']['d_id'];


				
		if(empty($_FILES["logoImg"]["name"] )){
			$this->load->view('admin/templates/header',$data);
			$this->load->view('admin/editLogo', $data);
			$this->load->view('admin/templates/footer',$data);
		} else {

			// Upload Image
				// Get filename.
				$temp = explode(".", $_FILES["logoImg"]["name"]);
				// Get extension.
				$imageType = strtolower(end($temp));
				$logoImg = sha1(microtime()) . "." . $imageType;

				$config['upload_path'] = './images';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF';
				$config['max_size'] = '5000';
				$config['max_width'] = '4000';
				$config['max_height'] = '4000';
				$config['file_name'] =$logoImg;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('logoImg')){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = '';

				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $logoImg;
				}


			$this->Admin_model->updateLogo($d_id, $post_image);
			// Set message
			$this->session->set_flashdata('siUpdate', 'Your Site Logo  has been updated');
			redirect('admin/websiteDetails');
		}
    }

    public function editFav(){
    	if($this->session->userdata('logged_in')){
        	if ($this->session->userdata('user_role') != 'admin') {
        		redirect('member');
        	}
	    }else{
	        redirect('Login');
	    }
	    $data['lUser']= $this->Member_model->getUserDetils($this->session->userdata('username'));
	    $data['pageTitle'] = 'Update FavIcon';
	    $data['siteDetails']= $this->Page_model->getsiteDetails();
	    $d_id=$data['siteDetails']['d_id'];


				
		if(empty($_FILES["favImg"]["name"] )){
			$this->load->view('admin/templates/header',$data);
			$this->load->view('admin/editfav', $data);
			$this->load->view('admin/templates/footer',$data);
		} else {

			// Upload Image
				// Get filename.
				$temp = explode(".", $_FILES["favImg"]["name"]);
				// Get extension.
				$imageType = strtolower(end($temp));
				$favImg = sha1(microtime()) . "." . $imageType;

				$config['upload_path'] = './images';
				$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|JPG|PNG|GIF';
				$config['max_size'] = '5000';
				$config['max_width'] = '4000';
				$config['max_height'] = '4000';
				$config['file_name'] =$favImg;
				$this->load->library('upload', $config);
				if(!$this->upload->do_upload('favImg')){
					$errors = array('error' => $this->upload->display_errors());
					$post_image = '';

				} else {
					$data = array('upload_data' => $this->upload->data());
					$post_image = $favImg;
				}


			$this->Admin_model->updateFav($d_id, $post_image);
			// Set message
			$this->session->set_flashdata('fiUpdate', 'Your favicon has been updated');
			redirect('admin/websiteDetails');
		}
    }


    public function upload_tImg(){
    	$url = array(
    		base_url()
		);

		reset($_FILES);
		$temp = current($_FILES);

		if (is_uploaded_file($temp['tmp_name'])) {
		    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
		        header("HTTP/1.1 400 Invalid file name,Bad request");
		        return;
		    }
		    
		    // Validating File extensions
		    if (! in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array(
		        "gif",
		        "jpg",
		        "png"
		    ))) {
		        header("HTTP/1.1 400 Not an Image");
		        return;
		    }
		    
		    $fileName ="images/post/" .md5(microtime()).$temp['name'];
		    move_uploaded_file($temp['tmp_name'], $fileName);
		    
		    // Return JSON response with the uploaded file path.
		    echo json_encode(array(
		        'file_path' => base_url().$fileName
		    ));
		}
    }


    //thumbnail crop
    public function doResize($filename, $width, $height, $path){
        $destination_thumbs="./images/".$path."/";
        $upload_path="./images/temp/";
        $this->load->library('image_moo') ;
        $this->image_moo
        ->load($upload_path.$filename)
        ->resize_crop($width,$height)
        ->save($destination_thumbs.$filename);
    
    }

    //get views 
    public function getViews($limit= FALSE){
    	
    	return $this->ViewCounter_model->getViews($limit);
    	
    }

    public function allTimePageView(){
    	$datas= $this->ViewCounter_model->allTimePageView();
    	$allTimePageView= 0;
    	foreach ($datas as $data) {
    		$allTimePageView += $data['page_view'];
    	}

    	$allTimeUniqueView= 0;
    	foreach ($datas as $data) {
    		$allTimeUniqueView += $data['unique_visit'];
    	}

    	return  array($allTimePageView, $allTimeUniqueView);
    }

    public function getPostComCount(){
    	$postCount= $this->Admin_model->postCount();
    	$comCount= $this->Admin_model->comCount();

    	return  array('postCount' =>$postCount ,'comCount' =>$comCount );
    }


}
