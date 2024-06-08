
<?php $__env->startSection('content'); ?>
    <section class="cta congratulations ptb-80">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="process">
                        <div class="process-content">
                            <img alt="<?php echo app('translator')->get('congrats'); ?>" src="<?php echo e(getImage('assets/images/congrats.png')); ?>" />
                            <h3><i class="las la-smile"></i> <?php echo app('translator')->get('Congratulations'); ?></h3>
                            <h6><?php echo app('translator')->get('Your registration process has been completed. Please wait for admin response.'); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function ($) {
            $(".page-title-section").remove();
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8\htdocs\car_book\core\resources\views/templates/basic/carregistration_completed.blade.php ENDPATH**/ ?>