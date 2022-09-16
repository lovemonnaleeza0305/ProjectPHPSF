<?php
$result = array();
$result['success'] = false;
$result['error_message'] = Registry::load('strings')->went_wrong;
$result['error_key'] = 'something_went_wrong';
$noerror = true;
if (role(['permissions' => ['site_users' => 'import_users']])) {
    include 'fns/filters/load.php';
    include 'fns/files/load.php';

    
   
}
?>