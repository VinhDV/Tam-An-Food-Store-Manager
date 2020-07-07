<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . 'Tam-An-Food-Store-Manager/'. 'config.php');
	require_once(CLASS_PATH."Rest.inc.php");
	require_once(CLASS_PATH."Database.php");
	require_once(CLASS_PATH."JsonEncoder.php");
	require_once(CLASS_PATH."Package.php");
	require_once(CLASS_PATH."ListOfPeople.php");
	require_once(CLASS_PATH."Feature.php");

	class Server extends REST{
		const DB_VARIABLE_NAME = "db";
		const VIEW_VARIABLE_NAME = "jsonEncoder";

		//Properties
		private $db;
		private $jsonEncoder;

		//Constructor
		public function __construct(){
				// Init parent contructor
				parent::__construct();				
				// obtain a new database Object to control database
				$this->db = new Database();
				// Initiate Database connection
				$this->db->connect();
				
				//call JsonEncoder to convert the list into json code
				$this->jsonEncoder =  JsonEncoder::get_json_encoder();
		}
			
		
		//Method
		/*
		 * Public method for access server.
		 * This method dynmically call the method based on the query string
		 *
		 */
		public function process(){
			
			//if has a request from submit button, then capture it
			$client_data = NULL;
			//TEST($json_data);
			if (isset($_REQUEST['request']))
				$input = $_REQUEST['request'];
			else{
				//else, get the json data from input
				$json_data = file_get_contents('php://input');
				//decode data into array
				$data = json_decode($json_data, true);
				
				//use a package to store the object
				$package = new Package();
				//data is in json encode form, so must decode it
				$package->get_data_from($data, true);
		  		
		  		// get request
				$input = $package->get_message();
				// get data of clients if available
				$client_data = $package->get_data(); 
			}
				
			//change value in $input into lower case
			$func = strtolower(trim(str_replace("/","",$input)));
			//replace 'space' with '_'
			$func = str_replace(" ","_", $func);
			
			//if the method exist, call it
			if((int)method_exists($this,$func) > 0)
				$this->$func($client_data);
			else
				$this->response('',404);				
				// If the method not exist with in this class, response would be "Page not found".
		}


		///send a package to db to execute
		private function send_package($msg, $data, $target){
			$package = new Package($msg, $data);
			$this->$target->execute($package);
		}

		
		//get package executed from database
		private function get_package_from($target){
			return $this->$target->get_package();
		}



		//add receipt to database.
		private function add_receipt($client_data = NULL){
			if (!is_null($client_data)){
				$this->send_package(Feature::ADD_RECEIPT
									,$client_data, self::DB_VARIABLE_NAME);
			}
		}


		//input: array of product id
		private function remove_product($client_data = NULL){
			if (!is_null($client_data)){
				$this->send_package(Feature::REMOVE_PRODUCT
									,$client_data, self::DB_VARIABLE_NAME);
			}
		}


		//input:  list of product
		private function push_alter_product_data($client_data = NULL){
			if (!is_null($client_data)){

				$this->send_package(Feature::PUSH_ALTER_PRODUCT_DATA
									,$client_data ,self::DB_VARIABLE_NAME);

			}
		}

		//input: list of product
		private function push_new_product_data($client_data = NULL){
			if (!is_null($client_data)){
				$this->send_package(Feature::PUSH_NEW_PRODUCT_DATA
									,$client_data ,self::DB_VARIABLE_NAME);

			}
		}
		

		//check user login info
		//client data must be array with this function
		private function check_user_login($client_data = NULL){
			
			if (!is_null($client_data)){
				
				// if exist users, return client data
				$this->send_package(Feature::CHECK_USER_LOGIN
									, $client_data ,self::DB_VARIABLE_NAME);
				
				$user_data = $this->get_package_from(self::DB_VARIABLE_NAME);
				
				//encode to json
				$json_data = json_encode($user_data);
				//respone
				$this->response($json_data, 200);
			}
		}
		

		//get the list of product info (name, unit)
		private function get_list_of_product_info($client_data = NULL){
			//access to database db, call function to query list of product info
			if (!is_null($client_data)){
				$client_data = $client_data['query'];
			}

			$this->send_package(Feature::GET_LIST_OF_PRODUCT_INFO
									, $client_data, self::DB_VARIABLE_NAME);
				
			$list_product_info = $this->get_package_from(self::DB_VARIABLE_NAME);
			
			//call method convert list product into json
			if (!is_null($list_product_info))
				$json_data = $this->jsonEncoder->list_product_to_json_data($list_product_info);
			else{
				$json_data = array();
				$json_data['error'] = 'No data';
				$json_data= json_encode($json_data);
			}
			//response with the data encode with json, status 200 = OK
			$this->response($json_data, 200);
			
		}

		//get the list of import product info (name, unit)
		private function get_list_of_import_product_info($client_data = NULL){
			//access to database db, call function to query list of product info
			if (!is_null($client_data)){
				$client_data = $client_data['query'];
			}
			
			$this->send_package(Feature::GET_LIST_OF_PRODUCT_INFO
									, $client_data ,self::DB_VARIABLE_NAME);
				
			$list_product_info = $this->get_package_from(self::DB_VARIABLE_NAME);
			
			//call method convert list product into json
			if (!is_null($list_product_info))
				$json_data = $this->jsonEncoder->list_import_product_to_json_data($list_product_info);
			else{
				$json_data = array();
				$json_data['error'] = 'No data';
				$json_data= json_encode($json_data);
			}
			//response with the data encode with json, status 200 = OK
			$this->response($json_data, 200);
			
		}

		//NOT DONE YET VVVVV
		//check if the function are existed or not
		// private function check_username_existed($client_data = NULL){
		// 	if (!is_null($client_data)){
		// 		// return a message
		// 		$package = new Package(Database::CHECK_USERNAME_EXISTED, $client_data);
		// 		$data = $this->db->execute($package);
				 
		// 		$json_data = json_encode($data);
		// 		$this->response($json_data, 200);
		// 	}
		// }


		// //add account to database
		// private function sign_up($client_data = NULL){
		// 	if (!is_null($client_data)){
		// 		// return a message
		// 		$data = $this->db->sign_up($client_data);
		// 		$json_data = json_encode($data);
		// 		$this->response($json_data, 200);
		// 	}
		// }


		// //get list of user name
		// private function get_list_of_user_name($client_data = NULL){
		// 	//access to database db, call function to query list of product info
		// 	$list_of_user_name = $this->db->get_list_of_user_name();

		// 	//call JsonEncoder to convert the list of user name to json data
		// 	$json_data = $this->jsonEncoder->list_user_name_to_json_data($list_of_user_name);
			
		// 	//response with the data encode with json, status 200 = OK
		// 	$this->response($json_data, 200);
		// }
		
	}

	//Server will work indepently. These code is to start the server
	$server = new Server();
	$server->process();



// $tmp = array();
// $tmp['action'] = "Đổi giá trị.";
// $tmp['bought'] = "132";

// $tmp['id'] = "19";
// $tmp['name'] = "Đèn đá tượng phật32ASD33";
// $tmp['percentage'] = "13242424242.999998";
// $tmp['sale'] = "17480000000.76";
// $tmp['unit_name'] ="kgeee";

// $tmp2 = array();
// $tmp2['action'] = "Đổi giá trị.";
// $tmp2['bought'] = "133242";

// $tmp2['id'] = "21";
// $tmp2['name'] = "Đèn đá xây dựng323ASD23";
// $tmp2['percentage'] = "13242424242.999998";
// $tmp2['sale'] = "17480000000.76";
// $tmp2['unit_name'] ="kgeee";
// $arr[0]= $tmp;
// $arr[1]= $tmp2;

// $receipt = new Receipt();
// foreach ($arr as $product){
//         if (isset($product['id'])){    
//                 $import_product = new ImportProduct($product['bought']);
//                 $import_product->add_attribute($product['name'],new Unit($product['unit_name'], $product['sale']),$product['id']);
//                 $receipt->add($import_product);
           
//         }
// }
// $package = new Package('push_alter_product_data', $receipt->json_encode(true));

// //decode data into array
// 				$data = json_decode($package->json_encode(), true);
				
// 				//use a package to store the object
// 				$package = new Package();
// 				//data is in json encode form, so must decode it
// 				$package->get_data_from($data, true);
		  		
// 		  		// get request
// 				$input = $package->get_message();
// 				// get data of clients if available
// 				$client_data = $package->get_data(); 

				
// $server->push_alter_product_data($client_data);
?>	