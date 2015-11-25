<?php
	require_once($_SERVER["DOCUMENT_ROOT"] . 'Tam-An-Food-Store-Manager/'. 'config.php');
	require_once(CLASS_PATH . "Person.php");
	//this class conatin information about customer
	class Customer extends Person{
		private $customer_id;
		//Constructor
		// constructor receive basic info object
		/// dafault value of basic_info will be NULL
		public function __construct($basic_info = NULL, $customer_id=""){
 			parent::__construct($basic_info);
 			$this->customer_id = $customer_id;
 			$this->object_type = "Customer";
		}
		

		//Method:
		//convert to HTML for publication
		public function convert_to_HTML(){
			//dummy code for testing
			return $this->basic_info->convert_to_HTML();
		}

		// convert object to json format
		// code = true, return json encode, else just return object data encode as an array
		public function json_encode($code = true){
			//call parent to encode the basic info part
			$json = parent::json_encode(false);
			$json['customer_id'] = $this->customer_id;
	        $json['object_type'] = $this->object_type;

    		// code = true, return json encode, else just return object data encode as an array
			if ($code)
    			return json_encode($json);
    		else 
    			return $json;
		
		}

		//get data from json_data 
		public function get_data_from_json($json_data){
			// decode input using json decode
			$data = json_decode($json_data,true);
	 		// if json last error is equal to NONE -> get the data from it
 			if (json_last_error() == JSON_ERROR_NONE){
 				//get the data 
 				$this->get_data($data);
 			}
		} 

		//get data from an array data 
		public function get_data_from_array($data){
			// a right Basic info array must have  property basic info
			if ( isset($data['basic_info'])){
 				$this->get_data($data);
			}
		} 
		private function get_data($data){
			parent::get_data_from_array($data);
			$this->customer_id = $data['customer_id'];
		}
		
	}

	//test code
    // $basic = new BasicInfo("Trịnh Hoàng Triều","0903302234","thtrieu@apcs.vn","asdsadsad");
    // $e = new Customer($basic,"1AEEA2");
    // TEST($e->json_encode(false));
    // $ee = new Customer();
    // $ee->get_data_from_json($e->json_encode());
    // TEST($ee->json_encode(false));
?>