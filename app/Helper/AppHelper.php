<?php
if(!function_exists('sendAjaxRequest')){
    function sendAjaxRequest($status=null, $msg=null, $redirectUrl=null){
        $response = array();

        $response['status'] = $status;

        $response['msg'] = $msg;

        if(isset($redirectUrl) && $redirectUrl != null){
            $response['redirectUrl'] = $redirectUrl;
        }

        $response['token'] = csrf_token();

        echo json_encode($response);
    }

}
?>