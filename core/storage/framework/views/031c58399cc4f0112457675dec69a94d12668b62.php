<div id="cronModal" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?php echo app('translator')->get('Please Set Cron Job Now'); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="las la-times"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group text-center border-bottom mb-4">
                    <div class="text--primary">
                        <i class="las la-info-circle"></i>
                        <?php echo app('translator')->get('Set the Cron time ASAP'); ?>
                    </div>
                    <p class="fst-italic">
                        <?php echo app('translator')->get('Once per 5-15 minutes is ideal while once every minute is the best option'); ?>
                    </p>
                </div>
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="justify-content-between d-flex flex-wrap">
                                <div>
                                    <label class="fw-bold"><?php echo app('translator')->get('Cron Command'); ?></label>
                                </div>
                            </div>
                            <div class="input-group">
                                <input type="text" class="form-control form-control-lg" id="cron" value="curl -s <?php echo e(route('cron')); ?>" readonly>
                                <button type="button" class="input-group-text copytext btn--primary copyCronPath border--primary" data-id="cron"> <?php echo app('translator')->get('Copy'); ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        (function($) {
            "use strict";

            setTimeout(() => {
                $('#cronModal').modal('show');
            }, 1000);

            $(document).on('click', '.copyCronPath', function() {
                var copyText = document.getElementById($(this).data('id'));
                copyText.select();
                copyText.setSelectionRange(0, 99999);
                document.execCommand('copy');
                notify('success', 'Copied: ' + copyText.value);
            });
        })(jQuery)
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\hotel\hotellatest1\hotellatest\laravel\files\core\resources\views/admin/partials/cron.blade.php ENDPATH**/ ?>