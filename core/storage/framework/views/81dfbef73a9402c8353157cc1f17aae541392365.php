
<?php $__env->startSection('panel'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Image'); ?></th>
                                    <th><?php echo app('translator')->get('Hotel'); ?></th>
                                    <th><?php echo app('translator')->get('URL'); ?></th>
                                    <th><?php echo app('translator')->get('End Date'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $ad->image_with_path = getImage(getFilePath('ads') . '/' . @$ad->image, getFileSize('ads'));
                                        $ad->redirect_to = $ad->url ? 'url' : ($ad->owner_id ? 'owner_id' : '');
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="user">
                                                <div class="thumb">
                                                    <img alt="" src="<?php echo e($ad->image_with_path); ?>">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($ad->owner_id): ?>
                                                <span><?php echo e(__($ad->owner->hotelSetting->name)); ?></span> <br>
                                                <a href="<?php echo e(route('admin.owners.detail', $ad->owner_id)); ?>"><?php echo e(__($ad->owner->fullname)); ?></a>
                                            <?php else: ?>
                                                <span>---</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($ad->url): ?>
                                                <a href="<?php echo e($ad->url); ?>" target="_blank"><?php echo e($ad->url); ?></a>
                                            <?php else: ?>
                                                <span>---</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e(showDateTime($ad->end_date, 'd M, Y')); ?></td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-modal_title="<?php echo app('translator')->get('Update Ad'); ?>" data-resource="<?php echo e($ad); ?>"><i class="las la-pencil-alt"></i><?php echo app('translator')->get('Edit'); ?></button>
                                                <button class="btn btn-sm btn-outline--danger confirmationBtn" data-action="<?php echo e(route('admin.ads.delete', $ad->id)); ?>" data-question="<?php echo app('translator')->get('Are you sure to delete this ad?'); ?>"><i class="las la-trash-alt"></i><?php echo app('translator')->get('Delete'); ?></button>
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
                <form action="<?php echo e(route('admin.ads.add')); ?>" enctype="multipart/form-data" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Image'); ?></label>
                            <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.image-uploader','data' => ['class' => 'w-100','type' => 'ads','required' => false,'accept' => '.png, .jpg, .jpeg, .gif','hint' => trans('Expected ratio: ') . getFileSize('ads') . 'px.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('image-uploader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-100','type' => 'ads','required' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'accept' => '.png, .jpg, .jpeg, .gif','hint' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(trans('Expected ratio: ') . getFileSize('ads') . 'px.')]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('End Date'); ?></label>
                            <input autocomplete="off" class="datepicker-here1 form-control bg--white" data-format="Y-m-d" data-language="en" data-position='top left' name="end_date" placeholder="<?php echo app('translator')->get('End Date'); ?>" type="text" required>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Redirect To'); ?></label>
                            <select class="form-control redirect_to" name="redirect_to">
                                <option value=""><?php echo app('translator')->get('None'); ?></option>
                                <option value="owner_id"><?php echo app('translator')->get('Hotel'); ?></option>
                                <option value="url"><?php echo app('translator')->get('URL'); ?></option>
                            </select>
                        </div>

                        <div class="form-group hotel d-none">
                            <label class="required"><?php echo app('translator')->get('Hotel'); ?></label>
                            <select class="select2-basic" name="owner_id">
                                <option selected value=""><?php echo app('translator')->get('Select One'); ?></option>
                                <?php $__currentLoopData = $owners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $owner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($owner->id); ?>" data-title="<?php echo e($owner->fullname); ?>"><?php echo e($owner->hotelSetting?->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group url d-none">
                            <label class="required"><?php echo app('translator')->get('URL'); ?></label>
                            <input type="text" name="url" class="form-control" placeholder="<?php echo app('translator')->get('Enter Valid URL'); ?>">
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
    <button class="btn btn-sm btn-outline--primary cuModalBtn addBtn" data-modal_title="<?php echo app('translator')->get('Add New Ad'); ?>"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script-lib'); ?>
    <script src="<?php echo e(asset('assets/global/js/vendor/datepicker.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/global/js/vendor/datepicker.en.js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style-lib'); ?>
    <link href="<?php echo e(asset('assets/global/css/vendor/datepicker.min.css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";
            $('.datepicker-here1').datepicker({
                dateFormat: 'yyyy-mm-dd',
                minDate: new Date(new Date().getTime() + 24 * 60 * 60 * 1000),
                autoClose: true
            });

            var formatState = (state, container) => {

                let title = $(state.element).data('title');
                if (title == undefined) {
                    return state.text;
                }

                let result = $("<div>");

                $('<span>', {
                    text: state.text,
                }).appendTo(result);

                $('<br>').appendTo(result);

                $('<small>', {
                    text: title
                }).appendTo(result);

                return result;
            }

            $('.addBtn').on('click', function() {
                var imgURL = "<?php echo e(getImage(null, getFileSize('ads'))); ?>";
                $("#cuModal").find(".image-upload-preview").css("background-image", `url(${imgURL})`);

                $('[name=owner_id]').val("").select2({
                    dropdownParent: $('#cuModal'),
                    templateResult: formatState
                });

                redirectToChangeHandler('');
            });

            $('.editBtn').on('click', function() {
                let resource = $(this).data('resource');
                $('[name=owner_id]').val(resource.owner_id).select2({
                    dropdownParent: $('#cuModal'),
                    templateResult: formatState
                });

                redirectToChangeHandler(resource.redirect_to);
            });

            const redirectToChangeHandler = (value) => {
                $('.hotel, .url').addClass('d-none');
                $('.hotel, .url').find('input, select').removeAttr('required');

                if (value) {
                    $(`[name=${value}]`).parent().removeClass('d-none');
                    $(`[name=${value}]`).attr('required', true);
                }

                $('[name=redirect_to]').val(value);
            }

            $('[name=redirect_to]').on('change', function() {
                redirectToChangeHandler(this.value);
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('style'); ?>
    <style>
        .datepicker {
            z-index: 9999;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hotel\hotellatest1\hotellatest\laravel\files\core\resources\views/admin/ads.blade.php ENDPATH**/ ?>