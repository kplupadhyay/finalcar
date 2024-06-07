
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('City'); ?></th>
                                    <th><?php echo app('translator')->get('Country'); ?></th>
                                    <th><?php echo app('translator')->get('Locations'); ?></th>
                                    <th><?php echo app('translator')->get('Is Popular'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $cities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $city->image_with_path = getImage(getFilePath('city') . '/' . @$city->image, getFileSize('city'));
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb me-2">
                                                    <img alt="" class="thumb" src="<?php echo e($city->image_with_path); ?>">
                                                </div>
                                                <span><?php echo e(__($city->name)); ?></span>
                                            </div>
                                        </td>
                                        <td><?php echo e(__(@$city->country->name)); ?></td>
                                        <td>
                                            <a href="<?php echo e(route('admin.carlocation.all')); ?>?search=<?php echo e($city->name); ?>">
                                                <span class="badge badge--primary"><?php echo e($city->total_location); ?></span>
                                            </a>
                                        </td>
                                        <td><?php echo $city->popularBadge; ?></td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-modal_title="<?php echo app('translator')->get('Update City'); ?>" data-resource="<?php echo e($city); ?>"><i class="las la-pencil-alt"></i><?php echo app('translator')->get('Edit'); ?></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td class="text-center" colspan="100%"><?php echo e(__($emptyMessage)); ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php if($cities->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($cities)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div aria-hidden="true" class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.carlocation.cit.add')); ?>" enctype="multipart/form-data" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Image'); ?></label>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image-uploader','data' => ['required' => false,'class' => 'w-100','type' => 'city']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'w-100','type' => 'city']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Country'); ?></label>
                            <select class="form-control select2-basic" name="country_id" required>
                                <option disabled selected value=""><?php echo app('translator')->get('Select One'); ?></option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($country->id); ?>"><?php echo e(__($country->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Name'); ?></label>
                            <input class="form-control" name="name" required />
                        </div>
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Is Popular'); ?></label>
                            <input data-bs-toggle="toggle" data-height="50" data-off="<?php echo app('translator')->get('No'); ?>" data-offstyle="-danger" data-on="<?php echo app('translator')->get('Yes'); ?>" data-onstyle="-success" data-size="large" data-width="100%" name="is_popular" type="checkbox">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit"><?php echo app('translator')->get('Submit'); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <button class="btn btn-sm btn-outline--primary cuModalBtn addBtn" data-modal_title="<?php echo app('translator')->get('Add New City'); ?>"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
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

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            var a = 10;
            var b = 10;

            var modal = $('#cuModal');

            $('.addBtn').on('click', function() {
                $('.select2-basic').val('').select2({
                    dropdownParent: modal
                });

                var imgURL = "<?php echo e(getImage(null, getFileSize('city'))); ?>";
                modal.find(".image-upload-preview").css("background-image", `url(${imgURL})`);
            });

            $('.editBtn').on('click', function() {
                let data = $(this).data('resource');

                if (data.is_popular == 1) {
                    modal.find("[name=is_popular]").bootstrapToggle('on');
                } else {
                    modal.find("[name=is_popular]").bootstrapToggle('off');
                }

                setTimeout(() => {
                    $('.select2-basic').select2({
                        dropdownParent: modal
                    });
                }, 100);
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/admin/carcities.blade.php ENDPATH**/ ?>