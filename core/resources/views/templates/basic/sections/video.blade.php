@if ($general->app_video)
    <div class="video-section pt-50 pb-120 wow" data-wow-duration="5s" id="video">
        <div class="container custom-container">
            <div class="video">
                <video id="backgroundVideo" src="{{ asset('assets/video/' . $general->app_video) }}" muted autoplay></video>
            </div>
        </div>
    </div>
@endif
