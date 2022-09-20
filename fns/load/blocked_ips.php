<?php

    $columns = [
        'user_id', 'display_name', 'email_address', 'username'
    ];

    $current_user_id = Registry::load('current_user')->id;
    $condition = ["user" => $current_user_id];

    $site_users = DB::connect()->select('ip_blocked_users', ['blocked_user'], $condition);

    $i = 1;
    $output = array();
    $output['loaded'] = new stdClass();
    $output['loaded']->title = Registry::load('strings')->ip_blocked;
    $output['loaded']->offset = array();

    if (!empty($data["offset"])) {
        $output['loaded']->offset = $data["offset"];
    }

    $output['sortby'][1] = new stdClass();
    $output['sortby'][1]->sortby = Registry::load('strings')->sort_by_default;
    $output['sortby'][1]->class = 'load_aside';
    $output['sortby'][1]->attributes['load'] = Registry::load('strings')->ip_blocked;

    $output['sortby'][2] = new stdClass();
    $output['sortby'][2]->sortby = Registry::load('strings')->name;
    $output['sortby'][2]->class = 'load_aside sort_asc';
    $output['sortby'][2]->attributes['load'] = Registry::load('strings')->ip_blocked;
    $output['sortby'][2]->attributes['sort'] = 'name_asc';

    $output['sortby'][3] = new stdClass();
    $output['sortby'][3]->sortby = Registry::load('strings')->name;
    $output['sortby'][3]->class = 'load_aside sort_desc';
    $output['sortby'][3]->attributes['load'] = Registry::load('strings')->ip_blocked;
    $output['sortby'][3]->attributes['sort'] = 'name_desc';

    $offset = 0;
    $domain = "http://localhost:8080";
    foreach ($site_users as $site_user) {

        $blocked_user = DB::connect()->select('site_users', $columns, ["user_id" => $site_user["blocked_user"]]);
        $blocked_user = $blocked_user[0];
        $output['loaded']->offset[] = $site_user['blocked_user'];

        $output['content'][$i] = new stdClass();
        $output['content'][$i]->image = "assets/files/site_users/profile_pics/default.png";
        $output['content'][$i]->title = $blocked_user["display_name"];
        $output['content'][$i]->class = "blocked_user";
        $output['content'][$i]->icon = 0;
        $output['content'][$i]->unread = 0;

        $output['content'][$i]->subtitle = $blocked_user["username"];

        $output['options'][$i][1] = new stdClass();
        $output['options'][$i][1]->option = "Remove From List";
        $output['options'][$i][1]->class = 'ask_confirmation';
        $output['options'][$i][1]->attributes['data-update'] = 'site_ip_unban';
        $output['options'][$i][1]->attributes['data-user_id'] = $current_user_id;
        $output['options'][$i][1]->attributes['data-blocked_user_id'] = $site_user['blocked_user'];
        $output['options'][$i][1]->attributes['confirmation'] = "Are you sure to unblock ip address of this user?";
        $output['options'][$i][1]->attributes['submit_button'] = Registry::load('strings')->yes;
        $output['options'][$i][1]->attributes['cancel_button'] = Registry::load('strings')->no;

        // $output['options'][$i][2] = new stdClass();
        // $output['options'][$i][2]->option = Registry::load('strings')->profile;
        // $output['options'][$i][2]->class = 'get_info';
        // $output['options'][$i][2]->attributes['user_id'] = $offset;

        $i++;
    }

?>