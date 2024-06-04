<?php
    $brandContent = getContent('brand.content', true);
    $brandElements = getContent('brand.element', orderById: true);
?>

<div class="client-section wow fadeInUp pt-80" id="brand" data-wow-duration="600ms">
    <div class="container-fluid">
        <h5 class="title"> <?php echo e(@$brandContent->data_values->heading); ?> </h5>
        <div class="client-logos client-slider">
            <?php $__currentLoopData = $brandElements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brandElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(getImage('assets/images/frontend/brand/' . @$brandElement->data_values->image, '150x40')); ?>" alt="">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/sections/brand.blade.php ENDPATH**/ ?>