<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class pub extends Admin_Controller {

	private $api_url;
	const MODULE="api_client/";

	function __construct(){
		parent::__construct();
		$this->api_url=get_setting('own_api_url');
		$this->breadcrumb->append_crumb('List IIT categories',base_url().self::MODULE.'index');
	}

	function index(){
		try {
			$response = json_decode(file_get_contents("$this->api_url/pub/categories"),true);
			if(!$response) throw new Exception("Couldnt reach API", 1);
			$this->template_data['link']=base_url().'api_client/pub/';
			$this->template_data['rows']=$response['data'];
			$this->template_data['category_m']=$response['model'];
			$this->template_data['subview']=self::MODULE.'categories/list';
			$this->load->view('admin/main_layout',$this->template_data);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	function add(){

	}
	
	function native_curl_get($db_username)
	{
		$username = 'admin';
		$password = '1234';
		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, "$this->api_url/user/username/$db_username");
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);
		$result = json_decode($buffer,true);
		if(isset($result['username']) && $result['username'] == $db_username){
			return $result;
		}
		else{
			return null;
		}
	}

}

