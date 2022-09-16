<?php

include 'fns/filters/load.php';
include 'fns/files/load.php';
$current_user_id = Registry::load('current_user')->id;
$user_id = $data['see_user_id'];
if ($current_user_id != $user_id ) {
        $columns = $where = $join = $seen_users = null;
        $columns = [
                'seen_users',
        ];
        $where["user_id"] = $user_id;
        $where["LIMIT"] = 1;
        $seen_users = DB::connect()->select('site_users', $columns,$where);
        $exploded = explode(',',$seen_users[0]['seen_users']);
        $is_seend = false;
        for ( $i = 0; $i<count($exploded)-1; $i++) {
                if($exploded[$i] == $current_user_id) {
                        $is_seend = true;
                }
        }
        if(!$is_seend) {
                var_dump($seen_users[0]['seen_users'],$exploded);
                $new_seen_users = $seen_users[0]['seen_users'].(string)$current_user_id.",";
                $update_data = $where = null;
                $update_data = [
                        'seen_users' => $new_seen_users, 
                        'updated_on' => Registry::load('current_user')->time_stamp];
                $where['user_id'] = $user_id;
                DB::connect()->update("site_users", $update_data, $where);
        }
}

$result['result'] = true;
?>