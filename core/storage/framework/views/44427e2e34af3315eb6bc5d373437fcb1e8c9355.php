<script src="<?php echo e(asset('assets/global/js/firebase/firebase-8.3.2.js')); ?>"></script>

<script>
    "use strict";   
    
    var permission = null;
    var authenticated = '<?php echo e(auth()->user() || authOwner() ? true : false); ?>';
    var pushNotify = <?php echo json_encode($general->push_notify, 15, 512) ?>;
    var firebaseConfig = <?php echo json_encode($general->firebase_config, 15, 512) ?>;

    function pushNotifyAction(){ 
        permission = Notification.permission;

        if(!('Notification' in window)){
            notify('info', 'Push notifications not available in your browser. Try Chromium.')
        }
        else if(permission === 'denied' || permission == 'default'){ //Notice for users dashboard
            $('.notice').append(`
                <div class="col-lg-12">
                    <div class="custom--card mb-4">
                        <div class="card-header justify-content-between d-flex flex-wrap notice_notify">
                            <h5 class="alert-heading"><?php echo app('translator')->get('Please Allow / Reset Browser Notification'); ?> <i class='las la-bell text--danger'></i></h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-0 small"><?php echo app('translator')->get('If you want to get push notification then you have to allow notification from your browser'); ?></p>
                        </div>
                    </div> 
                </div>
            `);
        }
    }

    //If enable push notification from admin panel
    if(pushNotify == 1){
        pushNotifyAction();
    }

    //When users allow browser notification
    if(permission != 'denied' && firebaseConfig){ 
   
        //Firebase 
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();

        navigator.serviceWorker.register("<?php echo e(asset('assets/global/js/firebase/firebase-messaging-sw.js')); ?>")
        
        .then((registration) => {
            messaging.useServiceWorker(registration);
            
            function initFirebaseMessagingRegistration() {
                messaging
                .requestPermission()
                .then(function () {
                    return messaging.getToken()
                })
                .then(function (token){   
                    $.ajax({ 
                        url: '<?php echo e(route("add.device.token")); ?>',
                        type: 'POST',
                        data: {
                            token: token,
                            '_token': "<?php echo e(csrf_token()); ?>"
                        },
                        success: function(response){
                        },
                        error: function (err) {
                        },
                    });
                }).catch(function (error){
                });
            }

            messaging.onMessage(function (payload){ 
                const title = payload.notification.title;
                const options = {
                    body: payload.notification.body,
                    icon: payload.notification.icon, 
                    click_action:payload.notification.click_action,
                    vibrate: [200, 100, 200]
                };
                new Notification(title, options);
            });

            //For authenticated users
            if(authenticated){
                initFirebaseMessagingRegistration();
            }

        });

    }
</script><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/hotellatest/Laravel/Files/core/resources/views/partials/push_script.blade.php ENDPATH**/ ?>