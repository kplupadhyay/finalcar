<?php
    $dashboardContent = getContent('dashboard.content', true);
?>

<section class="dashboard-one  wow fadeInUp">
    <div class="container custom-container">
        <div class="dashboard-thumb">
            <img src="<?php echo e(getImage('assets/images/frontend/dashboard/' . @$dashboardContent->data_values->image, '1340x860')); ?>" alt="dashboard screenshort">
        </div>
    </div>
</section><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/templates/basic/sections/dashboard.blade.php ENDPATH**/ ?>