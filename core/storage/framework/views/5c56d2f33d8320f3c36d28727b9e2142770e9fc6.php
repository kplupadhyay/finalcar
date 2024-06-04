<?php if($general->app_video): ?>
    <div class="video-section pt-50 pb-120 wow" data-wow-duration="5s" id="video">
        <div class="container custom-container">
            <div class="video">
                <video id="backgroundVideo" src="<?php echo e(asset('assets/video/' . $general->app_video)); ?>" muted autoplay></video>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/sections/video.blade.php ENDPATH**/ ?>