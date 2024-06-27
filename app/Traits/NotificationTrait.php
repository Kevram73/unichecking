<?php

namespace App\Traits;


trait NotificationTrait {
    public function info_msg($message){
        return array(
            'message' => $message,
            'alert-type' => 'info'
        );
    }

    public function success_msg($message){
        return array(
            'message' => $message,
            'alert-type' => 'success'
        );
    }

    public function warning_msg($message){
        return array(
            'message' => $message,
            'alert-type' => 'warning'
        );
    }

    public function error_msg($message){
        return array(
            'message' => $message,
            'alert-type' => 'error'
        );
    }


}
