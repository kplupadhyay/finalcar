<?php
    $policyPages = getContent('policy_pages.element', false, null, true);
    $socialElements = getContent('social_icon.element', orderById: true);
?>

<?php echo $__env->make($activeTemplate . 'sections.cta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<footer class="footer">
    <div class="footer__inner">
        <div class="custom-container container">
            <div class="footer-wrapper">
                <div class="row g-4 justify-content-xl-between justify-content-center">
                    <div class="col-lg-2">
                        <a class="logo" href="<?php echo e(route('home')); ?>">
                            <img src="<?php echo e(siteLogo()); ?>" alt="">
                        </a>
                    </div>
                    <div class="col-lg-8">
                        <ul class="footer-list">
                            <?php $__currentLoopData = $policyPages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $policy): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="footer-list__item">
                                    <a class="link" href="<?php echo e(route('policy.pages', [slug($policy->data_values->title), $policy->id])); ?>"> <?php echo e(__($policy->data_values->title)); ?> </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                    <div class="col-lg-2">
                        <ul class="social-list">
                            <?php $__currentLoopData = $socialElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $socialElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="social-list__item"><a class="social-list__link flex-center" href="<?php echo e(@$socialElement->data_values->url); ?>" target="_blank"> <?php echo $socialElement->data_values->social_icon ?></a> </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="footer-bottom">
                        <p class="footer-bottom__desc">
                            <?php echo app('translator')->get('Copyright'); ?> &copy; <?php echo e(date('Y')); ?>. <?php echo app('translator')->get('All Rights Reserved By'); ?> <a class="t-link" href="<?php echo e(route('home')); ?>"><?php echo e(__($general->site_name)); ?></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/partials/footer.blade.php ENDPATH**/ ?>