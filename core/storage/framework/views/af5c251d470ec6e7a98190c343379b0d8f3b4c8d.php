
<?php $__env->startSection('content'); ?>
    <?php
        $content = getContent('owner_request.content', true);
        $elements = getContent('owner_request.element', orderById: true);
        $vendorContent = getContent('vendor_form_data.content', true);
    ?>
    <section class="owner-request mt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center gy-sm-5 gy-4">
                <div class="col-lg-5">
                    <div class="get-facilities pe-lg-5">
                        <div class="section-heading style-left">
                            <h3 class="section-heading__title" s-break="-2"><?php echo e(__(@$content->data_values->heading)); ?></h3>
                            <p class="section-heading__desc"><?php echo e(__(@$content->data_values->subheading)); ?></p>
                        </div>
                        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="get-facilities__item">
                                <span class="get-facilities__icon"> <?php echo $item->data_values->icon; ?> </span>
                                <div class="get-facilities__conent">
                                    <h6 class="get-facilities__title"><?php echo e(__($item->data_values->title)); ?></h6>
                                    <p class="get-facilities__desc"><?php echo e(__($item->data_values->description)); ?></p>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="owner-form">
                        <div class="card custom--card custom--card--lg">
                            <div class="card-header bg-transparent">
                                <h4 class="title fw-bold mb-2"><?php echo e(__(@$content->data_values->form_title)); ?></h4>
                                <p class="desc fs-14"><?php echo e(__(@$content->data_values->form_subtitle)); ?></p>
                            </div>
                            <div class="card-body">
                                <form action="<?php echo e(route('carvendor.send.form.data', session()->get('OWNER_ID') ?? 0)); ?>" method="POST" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <?php if (isset($component)) { $__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0 = $component; } ?>
<?php $component = App\View\Components\ViserForm::resolve(['identifier' => 'act','identifierValue' => 'owner_form'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('viser-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ViserForm::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0)): ?>
<?php $component = $__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0; ?>
<?php unset($__componentOriginale40beaa5cbfa24869bd0b7ba4d9f41184a3f12f0); ?>
<?php endif; ?>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-0">
                                                <button type="submit" class="btn btn--base w-100"><?php echo app('translator')->get('Send Request'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8\htdocs\car_book\core\resources\views/templates/basic/carrequest_form_data.blade.php ENDPATH**/ ?>