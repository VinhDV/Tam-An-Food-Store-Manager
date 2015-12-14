<?php 
session_start();
require_once($_SERVER["DOCUMENT_ROOT"] . 'Tam-An-Food-Store-Manager/'. 'config.php'); 
require_once(CLASS_PATH."AllClass.php");
require_once(CLASS_PATH."Management.php");
?>

<?php 
// function switcher for ajax call
// check which "action" ajax call
if(isset($_GET['q']) && !empty($_GET['q'])) {
    $get = json_decode($_GET['q'], true);
    $action = $get['action'];
    switch ($action) {
        case 'get_receipt_data_from_server':
        echo get_receipt_data_from_server()->json_encode();
        break;
        case 'get_data_from_submit': 
        $arr = get_data_from_submit();
        if(!empty($arr)){
            if(isset($get['isPrint']) && $get['isPrint'] == 1)
                send_data_to_server($arr[1]);
            else
                $_SESSION['PREVIEW_SERVER_DATA'] = $arr[1];
            echo json_encode($arr[0]);
        }
        else{
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array('message' => 'empty array', 'code' => 1100));                
        }
        break;
        case 'send_data_to_server':
        if(isset($_SESSION['PREVIEW_SERVER_DATA'])){
            send_data_to_server($_SESSION['PREVIEW_SERVER_DATA']);
            unset($_SESSION['PREVIEW_SERVER_DATA']);
        }else{
            header('HTTP/1.1 400 Bad Request');
            header('Content-Type: application/json; charset=UTF-8');
            echo json_encode(array('message' => 'session data missing', 'code' => 1000));
        }
        break;
    }
}

// get data from server
function get_receipt_data_from_server(){
    $manager = new Management();
    $data = $manager->get_list_of_product_info();
    $receipt = new Receipt();
    $receipt->get_data_from_array($data);
    return $receipt;
}

// get data from submit
function get_data_from_submit(){
    $flag = true;
    $arr = $_POST;
    $maxID = $GLOBALS['get']['max'];
    $cur = 0;
    $ID_list = null;
    if(isset($arr['product']))
        $ID_list[$cur++] = '';
    for($i = 0; $i < $maxID; $i++){
        if(isset($arr['product'.$i]))
            $ID_list[$cur++] = $i;
    }
    for($i = 0; $i < $cur; $i++){
        for($j = $i + 1; $j < $cur; $j++){
            if(isset($ID_list[$i]) && isset($ID_list[$j]) && $arr['product'.$ID_list[$i]] == $arr['product'.$ID_list[$j]]){
                $arr['product'.$ID_list[$i].'_quantity'] = floatval($arr['product'.$ID_list[$i].'_quantity']) + floatval($arr['product'.$ID_list[$j].'_quantity']);
                unset($arr['product'.$ID_list[$j]]);
                unset($arr['product'.$ID_list[$j].'_quantity']);
                unset($ID_list[$j]);
            }
        }
    } 
    for($i = 0; $i < $cur; $i++){
        if(isset($ID_list[$i]) && $arr['product'.$ID_list[$i].'_quantity'] == 0){
            unset($arr['product'.$ID_list[$i]]);
            unset($arr['product'.$ID_list[$i].'_quantity']);
            unset($ID_list[$i]);
        }
    }
    if (count($arr) == 0)
        return "";

    $cur = 0;
    $ID_list = null;
    if(isset($arr['product']))
        $ID_list[$cur++] = '';
    for($i = 0; $i < $maxID; $i++){
        if(isset($arr['product'.$i]))
            $ID_list[$cur++] = $i;
    }

    $cur = 0;
    $reArr = null;
    $seArr = null;
    foreach ($ID_list as $key => $value) {
        $tmp = json_decode($arr['product'.$value], true);
        if ($tmp['id'] == '-1')
            continue;
        $tmp1 = floatval($arr['product'.$value.'_quantity']);
        $reArr[$cur] = array($tmp, $tmp1);
        $seArr[$cur++] = array('id' => $tmp['id'] , 'quantity' => $tmp1);
    }
    return array($reArr, $seArr);
}

function send_data_to_server($data_array){
    // some function to send this array
}
?>