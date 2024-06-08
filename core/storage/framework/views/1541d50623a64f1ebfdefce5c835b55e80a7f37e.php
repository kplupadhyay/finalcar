<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag; ?>
<?php foreach($attributes->onlyProps([
    'style' => 1,
    'link' => null,
    'title' => null,
    'value' => null,
    'icon' => null,
    'bg' => null,
    'color' => null,
    'icon_color' => null,
    'icon_style' => 'outline',
    'overlay_icon' => 1,
    'query_string' => null,
    'parameters' => null,
]) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $attributes = $attributes->exceptProps([
    'style' => 1,
    'link' => null,
    'title' => null,
    'value' => null,
    'icon' => null,
    'bg' => null,
    'color' => null,
    'icon_color' => null,
    'icon_style' => 'outline',
    'overlay_icon' => 1,
    'query_string' => null,
    'parameters' => null,
]); ?>
<?php foreach (array_filter(([
    'style' => 1,
    'link' => null,
    'title' => null,
    'value' => null,
    'icon' => null,
    'bg' => null,
    'color' => null,
    'icon_color' => null,
    'icon_style' => 'outline',
    'overlay_icon' => 1,
    'query_string' => null,
    'parameters' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
} ?>
<?php $__defined_vars = get_defined_vars(); ?>
<?php foreach ($attributes as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
} ?>
<?php unset($__defined_vars); ?>

<?php
    $iconColor = $icon_color ?? $color;
    $widget = 'x-widget-' . $style;

    if ($link) {
        if (!Route::is('superowner.*') && !Route::is('admin.*')) {
            if (can($link)) {
                $link = route($link, $parameters);
            } else {
                $link = null;
            }
        } else {
            $link = route($link, $parameters);
        }
        $link = $link ? ($query_string ? $link . '?' . $query_string : $link) : null;
    }
?>

<?php if($style == 1): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget-1','data' => ['bg' => $bg,'color' => $color,'icon' => $icon,'iconColor' => $icon_color,'link' => $link,'title' => $title,'value' => $value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('widget-1'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bg),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'icon_color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon_color),'link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($link),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($style == 2): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget-2','data' => ['bg' => $bg,'color' => $color,'icon' => $icon,'iconColor' => $icon_color,'iconStyle' => $icon_style,'link' => $link,'overlayIcon' => $overlay_icon,'title' => $title,'value' => $value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('widget-2'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bg),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'icon_color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon_color),'icon_style' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon_style),'link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($link),'overlay_icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($overlay_icon),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($style == 3): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget-3','data' => ['bg' => $bg,'color' => $color,'icon' => $icon,'link' => $link,'title' => $title,'value' => $value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('widget-3'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bg),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($link),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($style == 4): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget-4','data' => ['bg' => $bg,'color' => $color,'link' => $link,'title' => $title,'value' => $value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('widget-4'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bg),'color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($color),'link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($link),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>

<?php if($style == 5): ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.widget-5','data' => ['bg' => $bg,'icon' => $icon,'link' => $link,'title' => $title,'value' => $value]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('widget-5'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['bg' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($bg),'icon' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($icon),'link' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($link),'title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($title),'value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($value)]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\xampp8\htdocs\car_book\core\resources\views/components/widget.blade.php ENDPATH**/ ?>