<?php

use App\Models\Project;
use App\Models\User;

if (! function_exists('changeDateFormat')) {
    function changeDateFormat($format,$date){
        return date($format, strtotime($date));
    }
}

if(!function_exists('displayStatus')){
    function displayStatus($status){
        echo ($status)?'<label class="badge badge-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Active</label>':'<label class="badge badge-danger"><i class="fa fa-ban" aria-hidden="true"></i> Inactive</label>';
    }
}

if(!function_exists('getUserNameById')){
    function getUserNameById($id){
        return User::find($id)->name;
    }
}

if(!function_exists('getProjectNameById')){
    function getProjectNameById($id){
        return Project::find($id)->project_name;
    }
}

if(!function_exists('projectStatus')){
    function projectStatus($status){
        switch($status) {
            case(1):
                $msg = '<label class="badge badge-warning"><i class="fa fa-tasks" aria-hidden="true"></i> To Do</label>';
                break;
            case(2):
                $msg = '<label class="badge badge-danger"><i class="fa fa-pause" aria-hidden="true"></i> On Hold</label>';
                break;
            case(3):
                $msg = '<label class="badge badge-primary"><i class="fa fa-spinner" aria-hidden="true"></i> In Process</label>';
                break;
            case(4):
                $msg = '<label class="badge badge-success"><i class="fa fa-check-circle" aria-hidden="true"></i> Done</label>';
                break;
            default:
                $msg = 'There is not status found.';
        }
        echo $msg;
    }
}

if(!function_exists('currencyName')){
    function currencyName($code){
        switch($code) {
            case(1):
                $currency = 'USD (&#36;)';
                break;
            case(2):
                $currency = 'INR (&#x20B9;)';
                break;
            case(3):
                $currency = 'EUR (&euro;)';
                break;
            case(4):
                $currency = 'AUD (&#36;)';
                break;
            default:
                $currency = 'USD (&#36;)';
        }
        echo $currency;
    }
}


if(!function_exists('taskPriority')){
    function taskPriority($priority){
        switch($priority) {
            case(1):
                $msg = 'Highest';
                break;
            case(2):
                $msg = 'High';
                break;
            case(3):
                $msg = 'Low';
                break;
            case(4):
                $msg = 'Lowest';
                break;
            default:
                $msg = 'N/A';
        }
        return $msg;
    }
}