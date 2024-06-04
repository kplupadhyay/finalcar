<header class="site-header <?php echo e(request()->routeIs('home') ? '' : 'header-two'); ?>" id="fixed-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light d-flex justify-content-between">
            <a class="navbar-brand logo" href="<?php echo e(route('home')); ?>"><img src="<?php echo e(siteLogo()); ?>" alt=""></a>

            <div class="purchase-button d-block d-lg-none">
                <a class="btn btn--base pill" href="<?php echo e(route('vendor.request')); ?>"> <?php echo app('translator')->get('Register Your Hotel'); ?> </a>
            </div>
            <div class="purchase-button d-lg-block d-none">
                <a class="btn btn--base pill" href="<?php echo e(route('vendor.request')); ?>"> <?php echo app('translator')->get('Register Your Hotel'); ?> </a>
            </div>
        </nav>
    </div>
</header>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            const whiteLogo = `<?php echo e(siteLogo()); ?>`;
            const darkLogo = `<?php echo e(siteLogo('dark')); ?>`;
            const logoContainer = $('.navbar-brand.logo');

            $(window).on('scroll', function() {
                if ($(window).scrollTop() >= 350) {
                    $('.site-header').addClass('fixed-header');
                    logoContainer.find('img').attr('src', darkLogo);
                } else {
                    $('.site-header').removeClass('fixed-header');
                    logoContainer.find('img').attr('src', whiteLogo);
                }
            });

        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/partials/header.blade.php ENDPATH**/ ?>