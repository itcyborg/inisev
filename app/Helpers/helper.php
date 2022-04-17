<?php
if(!function_exists('success_response')){
    function success_response($msg,$data=[],$code=200){
        return response()->json(
            [
                'data'=>$data,
                'status'=>'success',
                'message'=>$msg
            ],
            $code
        );
    }
}


if(!function_exists('error_response')){
    function error_response($error,$data=[],$code=500){
        return response()->json(
            [
                'error'=>$data,
                'status'=>'error',
                'message'=>$error
            ],
            $code
        );
    }
}
