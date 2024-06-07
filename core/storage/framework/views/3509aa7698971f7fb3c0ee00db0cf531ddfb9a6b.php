
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('User'); ?></th>
                                    <th><?php echo app('translator')->get('Email'); ?> - <?php echo app('translator')->get('Phone'); ?></th>
                                    <th><?php echo app('translator')->get('Country'); ?></th>
                                    <th><?php echo app('translator')->get('Joined At'); ?></th>
                                    <?php if(Route::is('admin.users.deleted')): ?>
                                        <th><?php echo app('translator')->get('Deleted At'); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"><?php echo e($user->fullname); ?></span>
                                            <br>
                                            <span class="small">
                                                <a href="<?php echo e(route('admin.users.detail', $user->id)); ?>"><span>@</span><?php echo e($user->username); ?></a>
                                            </span>
                                        </td>
                                        <td>
                                            <?php echo e($user->email); ?>

                                            <?php if($user->mobile): ?>
                                                <br> +<?php echo e($user->mobile); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span class="fw-bold" title="<?php echo e(@$user->address->country); ?>"><?php echo e($user->country_code ?? '...'); ?></span>
                                        </td>
                                        <td>
                                            <?php echo e(showDateTime($user->created_at)); ?> <br> <?php echo e(diffForHumans($user->created_at)); ?>

                                        </td>
                                        <?php if(Route::is('admin.users.deleted')): ?>
                                            <td>
                                                <?php echo e(showDateTime($user->deleted_at)); ?> <br> <?php echo e(diffForHumans($user->deleted_at)); ?>

                                            </td>
                                        <?php endif; ?>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary" href="<?php echo e(route('admin.users.detail', $user->id)); ?>">
                                                <i class="las la-desktop"></i> <?php echo app('translator')->get('Details'); ?>
                                            </a>

                                            <?php if(Route::is('admin.users.deleted')): ?>
                                                <button class="btn btn-sm btn-outline--dark confirmationBtn" data-action="<?php echo e(route('admin.users.restore', $user->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure that you want to restore this user\'s account?'); ?>"><i class="las la-trash-restore-alt"></i><?php echo app('translator')->get('Restore'); ?></button>
                                            <?php else: ?>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="<?php echo e(route('admin.users.delete', $user->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure that you want to delete this user\'s account?'); ?>"><i class="las la-trash-alt"></i><?php echo app('translator')->get('Delete'); ?></button>
                                            <?php endif; ?>
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
                <?php if($users->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($users)); ?>

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

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/admin/users/list.blade.php ENDPATH**/ ?>