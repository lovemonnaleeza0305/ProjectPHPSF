<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/jquery/jquery-min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/bootstrap/bootstrap.bundle.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/jquery.marquee/jquery.marquee.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/summernote/summernote-lite.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/recordrtc/recordrtc.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/colorpicker/dist/js/bootstrap-colorpicker.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/videojs/video.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/viewerjs/viewer.min.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/thirdparty/viewerjs/jquery-viewer.js'.$cache_timestamp; ?>"></script>

<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/aside.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/audio_message.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/audio_player.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/emojis.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/form.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/grid_list.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/info_box.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/main.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/message_editor.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/messages.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/middle.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/realtime.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/chat_page/statistics.js'.$cache_timestamp; ?>"></script>

<script src="<?php echo Registry::load('config')->site_url.'assets/js/entry_page/script.js'.$cache_timestamp; ?>"></script>

<script src="<?php echo Registry::load('config')->site_url.'assets/js/common/api_request.js'.$cache_timestamp; ?>"></script>

<script src="<?php echo Registry::load('config')->site_url.'assets/js/custom/countries.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/custom/jquery.mockjax.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/custom/jquery.autocomplete.js'.$cache_timestamp; ?>"></script>
<script src="<?php echo Registry::load('config')->site_url.'assets/js/custom/jquery-ui.js'.$cache_timestamp; ?>"></script>

<!-- <script src="<?php echo Registry::load('config')->site_url.'assets/js/combined_js_chat_page.js'.$cache_timestamp; ?>"></script> -->
<?php include 'layouts/chat_page/web_push_service_scripts.php'; ?>

<?php
if (Registry::load('settings')->progressive_web_application === 'enable') {
    ?>
    <script type="module">
        import 'https://cdn.jsdelivr.net/npm/@pwabuilder/pwainstall';
        const el = document.createElement('pwa-update');
        document.body.appendChild(el);
    </script>
    <script>
        $(window).on('load', function() {
            if ("serviceWorker" in navigator) {
                navigator.serviceWorker.register(baseurl+"pwa-sw.js");
            }
        });
    </script>

    <?php

}
if (Registry::load('current_user')->logged_in) {

    $bg_image = get_image(['from' => 'site_users/backgrounds', 'search' => Registry::load('current_user')->id, 'replace_with_default' => false]);

    if (!empty($bg_image)) {
        ?>
        <style>
            body {
                background: url('<?php echo $bg_image;
                ?>');
                background-size: cover;
                background-position: center;
            }
        </style>
        <?php
    }
}

?>
<?php
include 'layouts/chat_page/google_analytics.php';
include 'assets/headers_footers/chat_page/footer.php';
?>
</html>