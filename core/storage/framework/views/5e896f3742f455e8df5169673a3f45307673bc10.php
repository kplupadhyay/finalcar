<?php
    $content = getContent('feature.content', true);
    $elements = getContent('feature.element', orderById: true);
?>

<section class="feature-section ptb-100" id="feature">
    <div class="container custom-container">
        <h2 class="section-title wow fadeInUp" data-wow-duration="600ms"> <?php echo e(__(@$content->data_values->heading)); ?> </h2>
        <div class="row">
            <div class="col-12 p-fix-scroll">
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="feature-wrapper section-style wow fadeInUp <?php echo e($key == 0 ? 'demo' : null); ?>" data-wow-duration="600ms">
                        <div class="feature_thumb">
                            <img src="<?php echo e(getImage('assets/images/frontend/feature/' . @$item->data_values->image, '150x40')); ?>" alt="Image">
                        </div>
                        <div class="feature-content">
                            <h2 class="feature-content__title"> <?php echo e(__(@$item->data_values->title)); ?> </h2>
                            <?php echo @$item->data_values->features ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/sections/feature.blade.php ENDPATH**/ ?>