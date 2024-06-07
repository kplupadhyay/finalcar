
<?php $__env->startSection('content'); ?>
    <?php
        $content = getContent('owner_request.content', true);
        $elements = getContent('owner_request.element', orderById: true);
    ?>
    <section class="owner-request mt-80 pb-80">
        <div class="container">
            <div class="row justify-content-center gy-4">
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
                                <form action="<?php echo e(route('carvendor.request.send')); ?>" method="POST" class="verify-gcaptcha">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Hotel Name'); ?></label>
                                                <input type="text" class="form--control" name="hotel_name" value="<?php echo e(old('hotel_name')); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Star Rating'); ?></label>
                                                <select name="star_rating" class="form-select form--control">
                                                    <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                                                    <?php for($i = 1; $i <= $general->max_star_rating; $i++): ?>
                                                        <option value="<?php echo e($i); ?>" <?php if(old('star_rating') == $i): echo 'selected'; endif; ?>><?php echo e($i); ?> <?php echo app('translator')->get('Star'); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Country'); ?></label>
                                                <select name="country" class="form-select form--control" required>
                                                    <option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($country->id); ?>" data-code="<?php echo e($country->code); ?>" data-mobile_code="<?php echo e($country->dial_code); ?>" <?php if(old('country') == $country->id): echo 'selected'; endif; ?>><?php echo e(__($country->name)); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('City'); ?></label>
                                                <select name="city" class="form-select form--control" required>
                                                    <option value="" selected disabled><?php echo app('translator')->get('Select Country First'); ?></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Location'); ?></label>
                                                <select name="location" class="form-select form--control" required>
                                                    <option value="" selected disabled><?php echo app('translator')->get('Select City First'); ?></option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Vendor First Name'); ?></label>
                                                <input type="text" name="firstname" class="form--control" value="<?php echo e(old('firstname')); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Vendor Last Name'); ?></label>
                                                <input type="text" name="lastname" class="form--control" value="<?php echo e(old('lastname')); ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <input type="hidden" name="country_code" value="<?php echo e(old('country_code')); ?>">
                                            <input type="hidden" name="mobile_code" value="<?php echo e(old('mobile_code')); ?>">
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Mobile'); ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-text mobileCode"></span>
                                                    <input type="number" name="mobile" class="form-control form--control checkUser" value="<?php echo e(old('mobile')); ?>" required>
                                                </div>
                                                <small class="text--danger mobileExist"></small>
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <?php
                                                $email = old('email');
                                                if (request()->email) {
                                                    $email = request()->email;
                                                }
                                            ?>
                                            <div class="form-group">
                                                <label class="form-label"><?php echo app('translator')->get('Email'); ?></label>
                                                <input type="email" name="email" class="form--control checkUser" value="<?php echo e($email); ?>" required>
                                                <small class="text--danger emailExist"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <?php if (isset($component)) { $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243 = $component; } ?>
<?php $component = App\View\Components\Captcha::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('captcha'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Captcha::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243)): ?>
<?php $component = $__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243; ?>
<?php unset($__componentOriginalc0af13564821b3ac3d38dfa77d6cac9157db8243); ?>
<?php endif; ?>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group">
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
<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            let cities = <?php echo json_encode($cities, 15, 512) ?>;
            let locations = <?php echo json_encode($locations, 15, 512) ?>;

            $('select[name=country]').change(function() {
                $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
                $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
                $('.mobileCode').text('+' + $('select[name=country] :selected').data('mobile_code'));

                let countryId = $(this).val();
                let options = `<option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>`;
                $.each(cities, function(index, city) {
                    if (city.country_id == countryId) {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    }
                });

                $('select[name=city]').html(options);
            });

            $('select[name=city]').on('change', function() {
                let cityId = $(this).val();
                let options = `<option value="" selected disabled><?php echo app('translator')->get('Select One'); ?></option>`;
                $.each(locations, function(index, location) {
                    if (location.city_id == cityId) {
                        options += `<option value="${location.id}">${location.name}</option>`;
                    }
                });

                $('select[name=location]').html(options);
            });


            var mobileCode = <?php echo json_encode($mobileCode, 15, 512) ?>;

            if (mobileCode != null && $(`option[data-mobile_code="${mobileCode}"]`).length > 0) {
                $(`option[data-mobile_code=${mobileCode}]`).attr('selected', '');
            } else {
                $('select[name=country]').find('option:nth-child(2)').attr('selected', true);
            }

            $('select[name=country]').trigger("change");

            $('input[name=mobile_code]').val($('select[name=country] :selected').data('mobile_code'));
            $('input[name=country_code]').val($('select[name=country] :selected').data('code'));
            $('.mobileCode').text('+' + $('select[name=country] :selected').data('mobile_code'));


            <?php if(old('city')): ?>
                $('select[name=country]').trigger("change");
                var cityId = "<?php echo e(old('city')); ?>";
                $('select[name=city]').val(cityId);
            <?php endif; ?>

            <?php if(old('location')): ?>
                $('select[name=city]').trigger("change");
                var locationId = "<?php echo e(old('location')); ?>";
                $('select[name=location]').val(locationId);
            <?php endif; ?>

            $('.checkUser').on('focusout', function(e) {
                var url = "<?php echo e(route('carvendor.check.user')); ?>";
                var value = $(this).val();
                var token = '<?php echo e(csrf_token()); ?>';
                if ($(this).attr('name') == 'mobile') {
                    var mobile = `${$('.mobileCode').text().substr(1)}${value}`;
                    var data = {
                        mobile: mobile,
                        _token: token
                    }
                }
                if ($(this).attr('name') == 'email') {
                    var data = {
                        email: value,
                        _token: token
                    }
                }
                $.post(url, data, function(response) {
                    if (response.data != false) {
                        $(`.${response.type}Exist`).text(`${response.type} already exist`);
                    } else {
                        $(`.${response.type}Exist`).text('');
                    }
                });
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.frontend', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/templates/basic/carowner_request.blade.php ENDPATH**/ ?>