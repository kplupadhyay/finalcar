
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Title'); ?></th>
                                    <th><?php echo app('translator')->get('Image'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $amenities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><span class="me-2"><?php echo e($amenities->firstItem() + $loop->index); ?>.</span> <?php echo e($item->title); ?></td>
                                        <td>
                                            <img alt="" src="<?php echo e($item->image_url); ?>">
                                        </td>
                                        <td> <?php echo $item->statusBadge ?> </td>

                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-has_status="1" data-modal_title="<?php echo app('translator')->get('Update Amenity'); ?>" data-resource="<?php echo e($item); ?>" type="button">
                                                    <i class="la la-pencil"></i><?php echo app('translator')->get('Edit'); ?>
                                                </button>

                                                <?php if($item->status == Status::DISABLE): ?>
                                                    <button class="btn btn-sm btn-outline--success me-1 confirmationBtn" data-action="<?php echo e(route('admin.hotel.amenity.status', $item->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure to enable this amenities?'); ?>" type="button">
                                                        <i class="la la-eye"></i> <?php echo app('translator')->get('Enable'); ?>
                                                    </button>
                                                <?php else: ?>
                                                    <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="<?php echo e(route('admin.hotel.amenity.status', $item->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure to disable this amenities?'); ?>" type="button">
                                                        <i class="la la-eye-slash"></i> <?php echo app('translator')->get('Disable'); ?>
                                                    </button>
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
                        </table>
                    </div>
                </div>
                <?php if($amenities->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($amenities)); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="cuModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"> <?php echo app('translator')->get('Add Amenity'); ?></h5>
                    <button aria-label="Close" class="close" data-bs-dismiss="modal" type="button">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="<?php echo e(route('admin.hotel.amenity.save')); ?>" enctype="multipart/form-data" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label> <?php echo app('translator')->get('Amenities Title'); ?></label>
                            <input class="form-control" name="title" required type="text" value="<?php echo e(old('title')); ?>">
                        </div>
                        <div class="form-group">
                            <label> <?php echo app('translator')->get('Image'); ?></label>
                            <div class="input-group">
                                <input accept=".jpg,.png,.jpeg" class="form-control image-input" name="image" type="file">
                                <span class="input-group-text imagePreview"></span>
                            </div>
                            <small class="text--xsm"><?php echo app('translator')->get('Supported Files: .jpg, .png, .jpeg'); ?>. <?php echo app('translator')->get('Image will be resized into:'); ?> <?php echo e(getFileSize('amenity')); ?>px</small>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit"><?php echo app('translator')->get('Submit'); ?></button>
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
    <button class="btn btn-sm btn-outline--primary addBtn cuModalBtn" data-modal_title="<?php echo app('translator')->get('Add New Amenity'); ?>" type="button">
        <i class="las la-plus"></i><?php echo app('translator')->get('Add New '); ?>
    </button>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            $('#cuModal').on('shown.bs.modal', function(e) {
                $(document).off('focusin.modal');
            });

            $('#cuModal').on('hidden.bs.modal', function(e) {
                $(this).find('.imagePreview').html("");
            });

            $('.addBtn').on('click', function() {
                $('#cuModal').find("[for=image]").addClass('required');
                $('#cuModal').find('[name=image]').attr('required', true);
            });

            $('.editBtn').on('click', function() {
                let resource = $(this).data('resource');
                $('#cuModal').find("[for=image]").removeClass('required');
                $('#cuModal').find('[name=image]').attr('required', false);
                $('#cuModal').find('.imagePreview').html(`<img src="${resource.image_url}" alt=""/>`);
            });

            $('.image-input').on('change', function(e) {
                var reader = new FileReader();
                console.log(e.target.result);
                reader.onload = function(e) {
                    $('#cuModal').find('.imagePreview').html(`<img src="${e.target.result}" alt=""/>`);
                }
                reader.readAsDataURL(this.files[0]);
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp8\htdocs\car_book\core\resources\views/admin/amenities.blade.php ENDPATH**/ ?>