

<?php $__env->startSection('panel'); ?>
    <div class="row justify-content-center">
        <?php if(request()->routeIs('admin.cardeposit.list') || request()->routeIs('admin.cardeposit.method') || request()->routeIs('admin.users.deposits') || request()->routeIs('admin.users.deposits.method')): ?>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 b-radius--5 bg--success has-link">
                    <a class="item-link" href="<?php echo e(route('admin.deposit.successful')); ?>"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white"><?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($successful)); ?></h2>
                        <p class="text-white"><?php echo app('translator')->get('Successful Deposit'); ?></p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 b-radius--5 bg--6 has-link">
                    <a class="item-link" href="<?php echo e(route('admin.deposit.pending')); ?>"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white"><?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($pending)); ?></h2>
                        <p class="text-white"><?php echo app('translator')->get('Pending Deposit'); ?></p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--pink">
                    <a class="item-link" href="<?php echo e(route('admin.deposit.rejected')); ?>"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white"><?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($rejected)); ?></h2>
                        <p class="text-white"><?php echo app('translator')->get('Rejected Deposit'); ?></p>
                    </div>
                </div><!-- widget-two end -->
            </div>
            <div class="col-xxl-3 col-sm-6 mb-30">
                <div class="widget-two box--shadow2 has-link b-radius--5 bg--dark">
                    <a class="item-link" href="<?php echo e(route('admin.deposit.initiated')); ?>"></a>
                    <div class="widget-two__content">
                        <h2 class="text-white"><?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($initiated)); ?></h2>
                        <p class="text-white"><?php echo app('translator')->get('Initiated Deposit'); ?></p>
                    </div>
                </div><!-- widget-two end -->
            </div>
        <?php endif; ?>

        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table table--light style--two">
                            <thead>
                                <tr>
                                    <th><?php echo app('translator')->get('Gateway | Transaction'); ?></th>
                                    <th><?php echo app('translator')->get('Initiated At'); ?></th>
                                    <th><?php echo app('translator')->get('Initiated By'); ?></th>
                                    <th><?php echo app('translator')->get('Amount'); ?></th>
                                    <th><?php echo app('translator')->get('Conversion'); ?></th>
                                    <th><?php echo app('translator')->get('Status'); ?></th>
                                    <th><?php echo app('translator')->get('Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $deposit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $details = $deposit->detail ? json_encode($deposit->detail) : null;
                                    ?>
                                    <tr>
                                        <td>
                                            <span class="fw-bold"> <a href="<?php echo e(appendQuery('method', @$deposit->gateway->alias)); ?>"><?php echo e(__(@$deposit->gateway->name)); ?></a> </span>
                                            <br>
                                            <small> <?php echo e($deposit->trx); ?> </small>
                                        </td>

                                        <td>
                                            <?php echo e(showDateTime($deposit->created_at)); ?><br><?php echo e(diffForHumans($deposit->created_at)); ?>

                                        </td>
                                        <td>
                                            <?php if($deposit->user_id): ?>
                                                <a href="<?php echo e(appendQuery('search', @$deposit->user->username)); ?>"><span>@</span><?php echo e($deposit->user->username); ?></a><br>
                                                <small class="text-muted"><?php echo app('translator')->get('User'); ?></small>
                                            <?php elseif($deposit->owner_id): ?>
                                                <a href="<?php echo e(appendQuery('search', @$deposit->owner->firstname)); ?>"><?php echo e($deposit->owner->fullname); ?></a> <br>
                                                <small class="text-muted"><?php echo app('translator')->get('Vendor'); ?></small>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e(__($general->cur_sym)); ?><?php echo e(showAmount($deposit->amount)); ?> + <span class="text-danger" title="<?php echo app('translator')->get('charge'); ?>"><?php echo e(showAmount($deposit->charge)); ?> </span>
                                            <br>
                                            <strong title="<?php echo app('translator')->get('Amount with charge'); ?>">
                                                <?php echo e(showAmount($deposit->amount + $deposit->charge)); ?> <?php echo e(__($general->cur_text)); ?>

                                            </strong>
                                        </td>
                                        <td>
                                            1 <?php echo e(__($general->cur_text)); ?> = <?php echo e(showAmount($deposit->rate)); ?> <?php echo e(__($deposit->method_currency)); ?>

                                            <br>
                                            <strong><?php echo e(showAmount($deposit->final_amo)); ?> <?php echo e(__($deposit->method_currency)); ?></strong>
                                        </td>
                                        <td>
                                            <?php echo $deposit->statusBadge ?>
                                        </td>
                                        <td>
                                            <a class="btn btn-sm btn-outline--primary ms-1" href="<?php echo e(route('admin.deposit.details', $deposit->id)); ?>">
                                                <i class="la la-desktop"></i> <?php echo app('translator')->get('Details'); ?>
                                            </a>
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
                <?php if($deposits->hasPages()): ?>
                    <div class="card-footer py-4">
                        <?php echo paginateLinks($deposits) ?>
                    </div>
                <?php endif; ?>
            </div><!-- card end -->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('breadcrumb-plugins'); ?>
    <?php if(!request()->routeIs('admin.users.deposits') && !request()->routeIs('admin.users.deposits.method') && !request()->routeIs('admin.owners.deposits') && !request()->routeIs('admin.owners.deposits.method')): ?>
        <div class="input-group w-auto flex-fill">
            <select class="from-control bg--white" form="searchForm" name="payment_by">
                <option value=""><?php echo app('translator')->get('Initiated By All'); ?></option>
                <option <?php if(request()->payment_by == 'user_id'): echo 'selected'; endif; ?> value="user_id"><?php echo app('translator')->get('User'); ?></option>
                <option <?php if(request()->payment_by == 'owner_id'): echo 'selected'; endif; ?> value="owner_id"><?php echo app('translator')->get('Vendor'); ?></option>
            </select>
        </div>
        <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.search-form','data' => ['dateSearch' => 'yes']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('search-form'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['dateSearch' => 'yes']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
    <?php endif; ?>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";

        $('[name=payment_by]').on('change', function() {
            $('#searchForm').submit();
        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\hotel\hotellatest1\hotellatest\laravel\files\core\resources\views/admin/cardeposit/carlog.blade.php ENDPATH**/ ?>