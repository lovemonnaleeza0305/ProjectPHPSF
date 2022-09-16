<?php
$result = array();
$result['success'] = false;
$result['error_message'] = Registry::load('strings')->went_wrong;
$result['error_key'] = 'something_went_wrong';
$noerror = true;
if (role(['permissions' => ['site_users' => 'import_users']])) {
    include 'fns/filters/load.php';
    include 'fns/files/load.php';
    $noerror = true;
    if ($noerror) {
        if (isset($_FILES['csv_file']['name']) && !empty($_FILES['csv_file']['name'])) {
            $filename = 'import_location_'.strtotime("now").'.csv';
            $upload_info = [
                'upload' => 'csv_file',
                'folder' => 'assets/cache/',
                'saveas' => $filename,
                'real_path' => true,
                'only_allow' => ['text/csv', 'text/plain']
            ];
            $flag = true;
            $csv_file = files('upload', $upload_info);
            if ($csv_file['result']) {
                $csv_file_location = 'assets/cache/'.$filename;
                if (file_exists($csv_file_location)) {
                    if (($handle = fopen($csv_file_location, "r")) !== FALSE) {
                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                            if($flag) {
                                $flag = false;
                            } else{
                            settype($data[0], "integer");
                            settype($data[3], "float");
                            settype($data[4], "float");
                            $insert_data = [
                                "postal_code" => $data[0],
                                "residence" => $data[1],
                                "province" => $data[2],
                                "latitude" => $data[3],
                                "longitude" => $data[4],
                                "created_on" => Registry::load('current_user')->time_stamp,
                                "updated_on" => Registry::load('current_user')->time_stamp,
                            ];
                            DB::connect()->insert("site_location", $insert_data);
                            if (DB::connect()->error){
                                return false;
                            }
                        }
                        }
                        fclose($handle);
                    }
                    unlink($csv_file_location);
                }
            }
        }
        $result = array();
        $result['success'] = true;
        $result['todo'] = 'reload';
        $result['reload'] = 'site_users';
    }
}
?>