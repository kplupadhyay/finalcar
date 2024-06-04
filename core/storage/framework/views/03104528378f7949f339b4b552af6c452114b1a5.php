<?php
    $bannerContent = getContent('banner.content', true);
?>
<section class="banner-section section-style">
    <div class="hero-section bg-overlay" style="background-image: url(<?php echo e(getImage('assets/images/frontend/banner/' . @$bannerContent->data_values->image, '1885x995')); ?>);">
        <div class="hero-section-content">
            <div class="custom-container container">
                <div class="row justify-content-center gy-5 align-items-center">
                    <div class="col-lg-12">
                        <div class="hero-content">
                            <h1 class="hero-title" data-color="title-base" data-break="-3"><?php echo e(@$bannerContent->data_values->heading); ?></h1>

                            <p class="hero-description"> <?php echo e(@$bannerContent->data_values->subheading); ?> </p>

                            <div class="hero-content">
                                <div class="d-flex hero-button-wrapper justify-content-center flex-wrap gap-2">
                                    <a class="btn btn--base" href="<?php echo e(@$bannerContent->data_values->android_download_link); ?>" target="_blank">
                                        <i class="fab fa-google-play"></i> <?php echo app('translator')->get('Play Store'); ?></a>

                                    <a class="btn btn-outline--base" href="<?php echo e(@$bannerContent->data_values->iso_download_link); ?>" target="_blank"><i class="fab fa-app-store"></i> <?php echo app('translator')->get('App Store'); ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php echo $__env->make($activeTemplate . 'sections.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script>
        (function($) {
            "use strict";

            let elements = document.querySelectorAll('[data-break]');

            Array.from(elements).forEach(element => {
                let html = element.innerHTML;
                if (typeof html != 'string') {
                    return false;
                }
                let breakLength = parseInt(element.getAttribute('data-break'));
                html = html.split(" ");
                var colorText = [];
                if (breakLength < 0) {
                    colorText = html.slice(breakLength);
                } else {
                    colorText = html.slice(0, breakLength);
                }
                let solidText = [];
                html.filter(ele => {
                    if (!colorText.includes(ele)) {
                        solidText.push(ele);
                    }
                });

                var color = element.getAttribute('data-color');
                var mainColor = colorText.slice(0, 2);
                var available = colorText.slice(2, 3);

                colorText = `<span class="${color}">${mainColor.toString().replaceAll(',', ' ')} <span class="text-white">${available}</span></span>`;
                solidText = solidText.toString().replaceAll(',', ' ');
                breakLength < 0 ? element.innerHTML = `${solidText} ${colorText}` : element.innerHTML = `${colorText} ${solidText}`
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/sections/banner.blade.php ENDPATH**/ ?>