<?php
    if (isset($seoContents) && count($seoContents)) {
        $seoContents = json_decode(json_encode($seoContents, true));
        $socialImageSize = explode('x', $seoContents->image_size);
    } elseif ($seo) {
        $seoContents = $seo;
        $socialImageSize = explode('x', getFileSize('seo'));
        $seoContents->image = getImage(getFilePath('seo') . '/' . $seo->image);
    } else {
        $seoContents = null;
    }

?>

<meta Content="<?php echo e($general->sitename(__($pageTitle))); ?>" name="title">

<?php if($seoContents): ?>
    <meta content="<?php echo e($seoContents->meta_description ?? $seoContents->description); ?>" name="description">
    <meta content="<?php echo e(implode(',', $seoContents->keywords)); ?>" name="keywords">
    <link href="<?php echo e(siteFavicon()); ?>" rel="shortcut icon" type="image/x-icon">

    
    <link href="<?php echo e(siteLogo()); ?>" rel="apple-touch-icon">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="<?php echo e($general->sitename($pageTitle)); ?>" name="apple-mobile-web-app-title">
    
    <meta content="<?php echo e($general->sitename($pageTitle)); ?>" itemprop="name">
    <meta content="<?php echo e($seoContents->description); ?>" itemprop="description">
    <meta content="<?php echo e($seoContents->image); ?>" itemprop="image">
    
    <meta content="website" property="og:type">
    <meta content="<?php echo e($seoContents->social_title); ?>" property="og:title">
    <meta content="<?php echo e($seoContents->social_description); ?>" property="og:description">
    <meta content="<?php echo e($seoContents->image); ?>" property="og:image" />
    <meta content="<?php echo e(pathinfo($seoContents->image)['extension']); ?>" property="og:image:type" />
    <meta content="<?php echo e($socialImageSize[0]); ?>" property="og:image:width" />
    <meta content="<?php echo e($socialImageSize[1]); ?>" property="og:image:height" />
    <meta content="<?php echo e(url()->current()); ?>" property="og:url">
    
    <meta content="summary_large_image" name="twitter:card">
<?php endif; ?>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/partials/seo.blade.php ENDPATH**/ ?>