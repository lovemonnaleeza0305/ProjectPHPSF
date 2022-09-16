<?php

if (isset($data["group_id"])) {
    $data["group_id"] = filter_var($data["group_id"], FILTER_SANITIZE_NUMBER_INT);
}
$user_id = Registry::load('current_user')->id;
if (isset($data['user_id'])) {
    $data['user_id'] = filter_var($data['user_id'], FILTER_SANITIZE_NUMBER_INT);
    if (!empty($data['user_id'])) {
        $user_id = $data['user_id'];
    }
}
$group_id = 0;
$columns = $join = $where = null;
$output = array();
$output['loaded'] = new stdClass();
$output['loaded']->format = 'grid';
$output['loaded']->offset = array();
$output['loaded']->title = Registry::load('strings')->media;

if (role(['permissions' => ['storage' => 'access_storage']])) {
    $output['loaded']->load_more = true;
    $columns = $where = null;
    $columns = [
        'id','file_name', 'file_path','thumbnail', 'file_type', 'attachment_type',
    ];
    $where = [
        "user_id" => $user_id,
        "is_show" => 1,
    ];
    $where["ORDER"] = ['id' => 'DESC'];
    if (!empty($data["offset"])) {
        $data["offset"] = array_map('intval', explode(',', $data["offset"]));
        $where["id[!]"] = $data["offset"];
    } 
    $where["LIMIT"] = 5;
    
    $media_files = DB::connect()->select('file_attachments', $columns, $where);
    $index = 0;

    if (count($media_files) < 5) {
        unset($output['loaded']->load_more);
    }
    if (!empty($data["offset"])) {
        $output['loaded']->offset = $data["offset"];
    }
    
    foreach ($media_files as $media_file) {
        $output['loaded']->offset[] = $media_file['id'];
        if (file_exists($media_file['file_path'])) {
            if ($media_file['attachment_type'] === 'image_files' && isset($media_file['thumbnail'])) {
                $output['content'][$index] = new stdClass();
                
                if (file_exists($media_file['thumbnail'])) {
                    $output['content'][$index]->image = $media_file['thumbnail'];
                } else {
                    $output['content'][$index]->image = Registry::load('config')->site_url.'assets/files/defaults/image_thumb.jpg';
                }

                $output['content'][$index]->attributes = [
                    'class' => 'preview_image',
                    'load_image' => Registry::load('config')->site_url.$media_file['file_path'],
                ];

            } else if ($media_file['attachment_type'] === 'video_files' && isset($media_file['file_name'])) {
                $output['content'][$index] = new stdClass();
                $output['content'][$index]->image = Registry::load('config')->site_url.'assets/files/defaults/video_thumb.jpg';

                if (isset($media_file['thumbnail']) && file_exists($media_file['thumbnail'])) {
                    $output['content'][$index]->image = Registry::load('config')->site_url.$media_file['thumbnail'];
                }

                $output['content'][$index]->attributes = [
                    'class' => 'preview_video',
                    'mime_type' => $media_file['file_type'],
                    'thumbnail' => $output['content'][$index]->image,
                    'video_file' => Registry::load('config')->site_url.$media_file['file_path'],
                ];


            } else if ($media_file['attachment_type'] === 'audio_files') {
                $output['content'][$index] = new stdClass();
                $output['content'][$index]->image = Registry::load('config')->site_url.'assets/files/defaults/audio_thumb.jpg';

                $output['content'][$index]->attributes = [
                    'class' => 'preview_video',
                    'thumbnail' => $output['content'][$index]->image,
                    'mime_type' => $media_file['file_type'],
                    'video_file' => Registry::load('config')->site_url.$media_file['file_path'],
                ];

            }
        }
        $index++;
    }
}
?>