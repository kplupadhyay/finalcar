<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'type' => null,
    'image' => null,
    'imagePath' => null,
    'size' => null,
    'name' => 'image',
    'id' => 'image-upload-input1',
    'accept' => '.png, .jpg, .jpeg',
    'required' => true,
    'hint' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'type' => null,
    'image' => null,
    'imagePath' => null,
    'size' => null,
    'name' => 'image',
    'id' => 'image-upload-input1',
    'accept' => '.png, .jpg, .jpeg',
    'required' => true,
    'hint' => null,
]); ?>
<?php foreach (array_filter(([
    'type' => null,
    'image' => null,
    'imagePath' => null,
    'size' => null,
    'name' => 'image',
    'id' => 'image-upload-input1',
    'accept' => '.png, .jpg, .jpeg',
    'required' => true,
    'hint' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>
<?php
    $size = $size ?? getFileSize($type);
    $imagePath = $imagePath ?? getImage(getFilePath($type) . '/' . $image, $size);
?>
<div <?php echo e($attributes->merge(['class' => 'image--uploader'])); ?>>
    <div class="image-upload-wrapper">
        <div class="image-upload-preview" style="background-image: url(<?php echo e($imagePath); ?>)">
        </div>
        <div class="image-upload-input-wrapper">
            <input type="file" class="image-upload-input" name="<?php echo e($name); ?>" id="<?php echo e($id); ?>" accept="<?php echo e($accept); ?>" <?php if($required): echo 'required'; endif; ?>>
            <label for="<?php echo e($id); ?>" class="bg--primary"><i class="la la-cloud-upload"></i></label>
        </div>
    </div>
    <?php if($size): ?>
        <div class="mt-2">
            <small class="mt-3 text-muted"> <?php echo app('translator')->get('Supported Files:'); ?>
                <b><?php echo e($accept); ?>.</b>
                <?php if($hint): ?>
                    <?php echo $hint ?>
                <?php else: ?>
                    <?php echo app('translator')->get('Image will be resized into'); ?> <b><?php echo e($size); ?></b> <?php echo app('translator')->get('px'); ?></b>
                <?php endif; ?>
            </small>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\xampp8.1\htdocs\hotellatest1\hotellatest\laravel\files\core\resources\views/components/image-uploader.blade.php ENDPATH**/ ?>