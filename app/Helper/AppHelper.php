<?php

if(!function_exists('sendAjaxRequest')){

    function sendAjaxRequest($status=null, $msg=null, $redirectUrl=null, $data=null){
        $response = array();

        $response['status'] = $status;

        $response['msg'] = $msg;

        $response['data'] = $data??null;

        if(isset($redirectUrl) && $redirectUrl != null){
            $response['redirectUrl'] = $redirectUrl;
        }

        $response['token'] = csrf_token();

        echo json_encode($response);
    }

}


// get last executed query
if (!function_exists('getSqlquery')) {
    function getSqlquery($query, $debug = false) {
        try {
            if($query instanceof \Illuminate\Database\Query\Builder || $query instanceof \Illuminate\Database\Eloquent\Builder) {

                $bindings = $query->getBindings();

                $tranformbindings = [];

                foreach($bindings as $binding){

                    if(is_numeric($binding)){
                        $tranformbindings[] = $binding;
                    }else{
                        $tranformbindings[] = "'$binding'";
                    }
                }
                $sql = \Illuminate\Support\Str::replaceArray(
                    '?',$tranformbindings,
                    $query->toSql()
                );
                

                if($debug) {
                    echo "Final SQL: " . $sql . PHP_EOL;
                }

                return $sql;
            } else {
                throw new Exception("The provided query is not a valid Builder or Model instance.");
            }
        } catch (Exception $e) {
            if($debug){
                echo "Error: " . $e->getMessage();
            }
            return $e->getMessage();
        }
    }
}

?>