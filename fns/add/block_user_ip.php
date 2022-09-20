<?php
    $current_user_id = Registry::load('current_user')->id;
    $block_user_id = $data['user_id'];
    $res = DB::connect()->select('ip_blocked_users', ['user'], [
        "user" => $current_user_id,
        "blocked_user" => $block_user_id
    ]);
    if (count($res) == 0)
        DB::connect()->insert("ip_blocked_users", [
            "user" => $current_user_id,
            "blocked_user" => $block_user_id
        ]);
    $result = array();
    $result['success'] = true;
    $result['todo'] = 'reload';
    $result['reload'] = 'avatars';
?>