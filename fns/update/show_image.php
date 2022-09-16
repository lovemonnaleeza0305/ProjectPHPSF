<?php

include 'fns/filters/load.php';
include 'fns/files/load.php';
$user_id = Registry::load('current_user')->id;
if (isset($data['user_id'])) {
        $data['user_id'] = filter_var($data['user_id'], FILTER_SANITIZE_NUMBER_INT);
        if (!empty($data['user_id'])) {
                $user_id = $data['user_id'];
        }
}
$update_data = $where = null;
$update_data = [
        'is_show' => $data['is_show'], 
        'updated_on' => Registry::load('current_user')->time_stamp];
$where = ['AND' => ['file_name' => $data['file_name'], "user_id" => $user_id]];
DB::connect()->update("file_attachments", $update_data, $where);
$result['result'] = true;
?>