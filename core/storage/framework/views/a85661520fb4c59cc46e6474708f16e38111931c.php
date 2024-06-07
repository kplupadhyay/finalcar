
<?php $__env->startSection('panel'); ?>
    <div class="row ">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Name'); ?></th>
                                    <th><?php echo app('translator')->get('City'); ?></th>
                                    <th><?php echo app('translator')->get('Country'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td>
                                            <span class="me-2"> <?php echo e($locations->firstItem() + $loop->index); ?>.</span><?php echo e(__($location->name)); ?>

                                        </td>
                                        <td><?php echo e(__(@$location->city->name)); ?></td>
                                        <td><?php echo e(__(@$location->city->country->name)); ?></td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--primary cuModalBtn editBtn" data-modal_title="<?php echo app('translator')->get('Update Location'); ?>" data-resource="<?php echo e($location); ?>"><i class="las la-pencil-alt"></i><?php echo app('translator')->get('Edit'); ?></button>
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

                <?php if($locations->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo e(paginateLinks($locations)); ?>

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
                <form action="<?php echo e(route('admin.carlocation.add')); ?>" enctype="multipart/form-data" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-body">
                        <div class="form-group">
                            <label><?php echo app('translator')->get('Country'); ?></label>
                            <select class="form-control select2-basic allCountries" required>
                                <option disabled selected value=""><?php echo app('translator')->get('Select One'); ?></option>
                                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option data-cities="<?php echo e($country->cities); ?>" value="<?php echo e($country->id); ?>"><?php echo e(__($country->name)); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('City'); ?></label>
                            <select class="select2-basic allCities" name="city_id" required></select>
                        </div>

                        <div class="form-group">
                            <label><?php echo app('translator')->get('Name'); ?></label>
                            <input class="form-control" name="name" required />
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
    <button class="btn btn-sm btn-outline--primary cuModalBtn addBtn" data-modal_title="<?php echo app('translator')->get('Add New Location'); ?>"><i class="las la-plus"></i><?php echo app('translator')->get('Add New'); ?></button>
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

            var modal = $('#cuModal');

            $('.addBtn').on('click', function() {
                $('.select2-basic').val('').select2({
                    dropdownParent: modal
                });

                var option = `<option value=""><?php echo app('translator')->get('Select Country First'); ?></option>`;
                $('[name=city_id]').html(option);
            });

            $('.editBtn').on('click', function() {
                let data = $(this).data('resource');

                if (data.is_popular) {
                    modal.find("[name=is_popular]").bootstrapToggle('on');
                } else {
                    modal.find("[name=is_popular]").bootstrapToggle('off');
                }

                $('.allCountries').val(data.city.country_id).trigger("change");

                setTimeout(() => {
                    $('.select2-basic').select2({
                        dropdownParent: modal
                    });
                }, 100);
            });

            $('.allCountries').on('change', function() {
                let cities = $(this).find('option:selected').data('cities');

                if (cities.length > 0) {
                    var option = new Option(`<?php echo app('translator')->get('Select One'); ?>`, '');
                    let newOptions = [];
                    newOptions.push(option);

                    $.each(cities, function(index, city) {
                        var option = new Option(city.name, city.id);
                        newOptions.push(option);
                    });

                    $('[name=city_id]').html(newOptions);
                }
            });

        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/admin/carlocation.blade.php ENDPATH**/ ?>