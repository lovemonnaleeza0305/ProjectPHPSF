<?php
    // $blacklist = "<?php \n";
    // $blacklist .= '$ip_blacklist = [';

    // include('assets/cache/ip_blacklist.cache');
    // $ip_blacklist = array_unique($ip_blacklist);

    // $ip = $data["user_ip"];
    // // var_dump($data);
    // $total_ip_addresses = count($ip_blacklist);
    // $ip_index = 1;

    // foreach ($ip_blacklist as $ip_address) {

    //     $ip_address = strip_tags($ip_address);
    //     if (!empty(trim($ip_address)) && trim($ip_address) != $ip) {
    //         $blacklist .= "\n".'"'.addslashes($ip_address).'"';
    //         if ($total_ip_addresses !== $ip_index) {
    //             $blacklist .= ',';
    //         }
    //     }
    //     $ip_index = $ip_index+1;
    // }

    // $blacklist .= "\n];\n";

    // $build = fopen("assets/cache/ip_blacklist.cache", "w");
    // fwrite($build, $blacklist);
    // fclose($build);
    $user_id =  $data["user_id"];
    $blocked_user_id = $data["blocked_user_id"];

    DB::connect()->delete("ip_blocked_users", [
        'user' => $user_id,
        'blocked_user' => $blocked_user_id
    ]);

    $result['success'] = true;
    $result['todo'] = 'refresh';
    
?>