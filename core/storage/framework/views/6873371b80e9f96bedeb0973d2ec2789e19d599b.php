
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Hotel'); ?></th>
                                    <th><?php echo app('translator')->get('Location'); ?></th>
                                    <th><?php echo app('translator')->get('Vendor'); ?></th>
                                    <th><?php echo app('translator')->get('Phone'); ?> | <?php echo app('translator')->get('Email'); ?></th>
                                    <th><?php echo app('translator')->get('Joined At'); ?></th>
                                    <th><?php echo app('translator')->get('Is Featured'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo e(@$owner->hotelSetting->name); ?></span>
                                        </td>
                                        <td>
                                            <div>
                                                <span>
                                                    <?php echo e(__(@$owner->hotelSetting->location->name)); ?>, <?php echo e(__(@$owner->hotelSetting->city->name)); ?>

                                                </span><br>
                                                <span><?php echo e(__(@$owner->hotelSetting->country->name)); ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="<?php echo e(route('admin.owners.detail', $owner->id)); ?>"><?php echo e($owner->fullname); ?></a>
                                        </td>
                                        <td>
                                            <span class="fw-bold">+<?php echo e($owner->mobile); ?></span> <br>
                                            <span class="fw-bold"><?php echo e($owner->email); ?></span>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($owner->created_at)); ?> <br> <?php echo e(diffForHumans($owner->created_at)); ?>

                                        </td>
                                        <td><?php echo $owner->featureBadge ?></td>

                                        <td>
                                            <div class="button--group">
                                                <a class="btn btn-sm btn-outline--primary" href="<?php echo e(route('admin.owners.detail', $owner->id)); ?>">
                                                    <i class="las la-desktop"></i><?php echo app('translator')->get('Details'); ?>
                                                </a>

                                                <?php if(!Route::is('admin.owners.banned')): ?>
                                                    <?php if($owner->is_featured): ?>
                                                        <button class="btn btn-sm btn-outline--dark confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure, you want to unfeature this vendor?'); ?>" data-action="<?php echo e(route('admin.owners.feature.status.update', $owner->id)); ?>"><i class="las la-times"></i><?php echo app('translator')->get('Unfeature'); ?></button>
                                                    <?php else: ?>
                                                        <button class="btn btn-sm btn-outline--success confirmationBtn" data-question="<?php echo app('translator')->get('Are you sure, you want to featured this vendor?'); ?>" data-action="<?php echo e(route('admin.owners.feature.status.update', $owner->id)); ?>"><i class="las la-check"></i><?php echo app('translator')->get('Feature'); ?></button>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>

                            </tbody>
                        </table><!-- table end -->
                    </div>
                </div>
                <?php if($owners->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($owners)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php if (isset($component)) { $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b = $component; } ?>
<?php $component = App\View\Components\ConfirmationModal::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('confirmation-modal'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\ConfirmationModal::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b)): ?>
<?php $component = $__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b; ?>
<?php unset($__componentOriginalc51724be1d1b72c3a09523edef6afdd790effb8b); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['placeholder' => 'Username / Email']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['placeholder' => 'Username / Email']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/admin/owners/list.blade.php ENDPATH**/ ?>