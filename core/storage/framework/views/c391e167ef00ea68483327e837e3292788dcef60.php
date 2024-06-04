<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/WebPage" lang="<?php echo e(config('app.locale')); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> <?php echo e($general->siteName(__($pageTitle))); ?></title>
    <?php echo $__env->make('partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <link href="<?php echo e(asset($activeTemplateTrue . 'css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/all.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/global/css/line-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/plugins.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/slick.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/animate.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/style.css')); ?>?v=<?php echo e(time()); ?>" rel="stylesheet">
    <link href="<?php echo e(asset($activeTemplateTrue . 'css/custom.css')); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('style-lib'); ?>

    <?php echo $__env->yieldPushContent('style'); ?>

    <link href="<?php echo e(asset($activeTemplateTrue . 'css/color.php')); ?>?color=<?php echo e($general->base_color); ?>" rel="stylesheet">
</head>

<body>
    <div class="preloader">
        <div class="loader-p"></div>
    </div>

    <div class="body-overlay"></div>
    <a class="scroll-top"><i class="fas fa-angle-double-up"></i></a>

    <?php echo $__env->make($activeTemplate . 'partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php if(!request()->routeIs('home')): ?>
        <section class="text-cetner  pt-80 page-title-section">
            <h2 class="text-center"><?php echo e(@$pageTitle); ?></h2>
        </section>
    <?php endif; ?>

    <main data-bs-spy="scroll" data-bs-target="#navbar-example2" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary" tabindex="0">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <?php echo $__env->make($activeTemplate . 'partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php
        $cookie = App\Models\Frontend::where('data_keys', 'cookie.data')->first();
    ?>
    <?php if($cookie->data_values->status == Status::ENABLE && !\Cookie::get('gdpr_cookie') && !Route::is('deposit.*')): ?>
        <!-- cookies dark version start -->
        <div class="cookies-card custom-card hide text-center">
            <div class="cookies-card__icon bg--base">
                <i class="las la-cookie-bite"></i>
            </div>
            <p class="cookies-card__content mt-4"><?php echo e($cookie->data_values->short_desc); ?> <a class="text--base" href="<?php echo e(route('cookie.policy')); ?>" target="_blank"><?php echo app('translator')->get('learn more'); ?></a></p>
            <div class="cookies-card__btn mt-4">
                <a class="btn btn--base w-100 policy" href="javascript:void(0)"><?php echo app('translator')->get('Allow'); ?></a>
            </div>
        </div>
    <?php endif; ?>

    <script src="<?php echo e(asset('assets/global/js/jquery-3.7.1.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/popper.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/aos.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/navscroll.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/wow.min.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/plugins.js')); ?>"></script>
    <script src="<?php echo e(asset($activeTemplateTrue . 'js/slick.min.js')); ?>"></script>

    <?php echo $__env->yieldPushContent('script-lib'); ?>

    <script src="<?php echo e(asset($activeTemplateTrue . 'js/main.js')); ?>"></script>

    <?php echo $__env->make('partials.plugins', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('script'); ?>

    <?php echo $__env->make('partials.notify', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('partials.push_script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        (function($) {
            "use strict";


            $(".langSel").on("change", function() {
                window.location.href = "<?php echo e(route('home')); ?>/change/" + $(this).val();
            });

            $('.policy').on('click', function() {
                $.get('<?php echo e(route('cookie.accept')); ?>', function(response) {
                    $('.cookies-card').addClass('d-none');
                });
            });

            var inputElements = $('[type=text],[type=password],select,textarea');
            $.each(inputElements, function(index, element) {
                element = $(element);
                element.closest('.form-group').find('label').attr('for', element.attr('name'));
                element.attr('id', element.attr('name'))
            });

            setTimeout(function() {
                $('.cookies-card').removeClass('hide')
            }, 2000);


            let elements = document.querySelectorAll('[s-break]');

            Array.from(elements).forEach(element => {
                let html = element.innerHTML;

                if (typeof html != 'string') {
                    return false;
                }

                let breakFrom = parseInt(element.getAttribute('s-break'));
                html = html.split(" ");
                let breakLength = element.getAttribute('s-length') != null ? parseInt(element.getAttribute('s-length')) : html.length;

                var prepend = [];
                var styledText = [];
                var append = [];

                if (breakFrom < 0) {
                    var startFrom = html.length + breakFrom;
                    prepend = html.slice(0, startFrom);
                    styledText = html.slice(startFrom, breakLength);
                    append = html.slice(startFrom + breakLength, html.length);

                } else {
                    breakFrom = breakFrom - 1;
                    prepend = html.slice(0, breakFrom);
                    styledText = html.slice(breakFrom, breakFrom + breakLength);
                    append = html.slice(breakFrom + breakLength, html.length);
                }

                var classLists = element.getAttribute('s-class') || "fw--bolder";

                styledText = `<span class="${classLists}">${styledText.toString().replaceAll(',', ' ')}</span>`;
                prepend = prepend.toString().replaceAll(',', ' ');
                append = append.toString().replaceAll(',', ' ');

                element.innerHTML = `${prepend} ${styledText} ${append}`;
            });

            $('#payment-form').on('submit', function() {
                $(this).find('button[type=submit]').html(`<span class="spinner-border spinner-border-sm"></span>`)
            })
        })(jQuery);
    </script>
</body>

</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/layouts/frontend.blade.php ENDPATH**/ ?>