
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('Code'); ?></th>
                                    <th><?php echo app('translator')->get('Dial Code'); ?></th>
                                    <th><?php echo app('translator')->get('Cities'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="me-2"> <?php echo e($countries->firstItem() + $loop->index); ?>.</span><?php echo e(__($country->name)); ?>

                                        </td>
                                        <td><?php echo e(__($country->code)); ?></td>
                                        <td>+<?php echo e(__($country->dial_code)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.location.city.all')); ?>?search=<?php echo e($country->name); ?>"><span class="badge badge--primary"><?php echo e($country->total_city); ?></span></a>
                                        </td>
                                        <td><?php echo $country->statusBadge; ?></td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn" data-resource="<?php echo e($country); ?>" data-modal_title="<?php echo app('translator')->get('Update Country'); ?>" type="button"><i class="las la-pencil-alt"></i><?php echo app('translator')->get('Edit'); ?></button>
                                                <?php if($country->status == Status::DISABLE): ?>
                                                    <button class="btn btn-sm btn-outline--success me-1 confirmationBtn" data-action="<?php echo e(route('admin.location.country.status.update', $country->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure to enable this facility?'); ?>" type="button">
                                                        <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="<?php echo e(route('admin.location.country.status.update', $country->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure to disable this facility?'); ?>" type="button">
                                                        <i class="la la-eye-slash"></i> <?php echo app('translator')->get('Disable'); ?>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="4"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <?php if($countries->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($countries)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div id="cuModal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.location.country.add')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Name'); ?></label>
                            <input type="text" class="form-control" name="name" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Code'); ?></label>
                            <input type="text" class="form-control" name="code" required>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Dial Code'); ?></label>
                            <input type="text" class="form-control" name="dial_code" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn h-45 w-100 btn--primary"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
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
    <button class="btn btn-outline--primary cuModalBtn" data-modal_title="<?php echo app('translator')->get('Add New Country'); ?>" type="button"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
    <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp8.1\htdocs\hotellatest1\hotellatest\laravel\files\core\resources\views/admin/countries.blade.php ENDPATH**/ ?>