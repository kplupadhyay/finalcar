<div class="sidebar bg--dark"">
    <button class="res-sidebar-close-btn"><i class="las la-times"></i></button>
    <div class="sidebar__inner">
        <div class="sidebar__logo">
            <a class="sidebar__main-logo" href="<?php echo e(route('admin.dashboard')); ?>"><img alt="<?php echo app('translator')->get('image'); ?>" src="<?php echo e(siteLogo()); ?>"></a>
        </div>
          
        <!-- <h1 class="text-align:center">Cars</h1> -->
        <div class="sidebar__menu-wrapper" id="sidebar__menuWrapper">
            <ul class="sidebar__menu">
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.dashboard')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Dashboard'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.location*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-globe"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Locations'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.location*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.location.country.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.location.country.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Countries'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.location.city.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.location.city.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Cities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.location.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.location.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Locations'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.ads.all')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.ads.all')); ?>">
                        <i class="menu-icon las la-ad"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Ads'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.hotel*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-tools"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Hotel Attributes'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.hotel*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.amenity.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.amenity.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Amenities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.facility.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.facility.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Facilities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.bed.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.bed.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Bed Types'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
               

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.hotel*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-tools"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Car Attributes'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.hotel*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.amenity.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.amenity.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car1'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.facility.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.facility.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car2'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.bed.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.bed.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car3'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.users*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Registered Users'); ?></span>
                        <?php if($bannedUsersCount > 0 || $emailUnverifiedUsersCount > 0 || $mobileUnverifiedUsersCount > 0): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="sidebar-submenu <?php echo e(menuActive('admin.users*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.active')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.active')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Active Users'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.banned')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.banned')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Banned Users'); ?></span>
                                    <?php if($bannedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($bannedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.email.unverified')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.email.unverified')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Email Unverified'); ?></span>

                                    <?php if($emailUnverifiedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($emailUnverifiedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.mobile.unverified')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.mobile.unverified')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Mobile Unverified'); ?></span>
                                    <?php if($mobileUnverifiedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($mobileUnverifiedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Users'); ?></span>
                                </a>
                            </li>
                            
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.deleted')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.deleted')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Deleted Users'); ?></span>
                                </a>
                            </li>

                            <hr class="my-0">
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.notification.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.notification.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Send Notification to All'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive(['admin.vendor.request', 'admin.vendor.request.detail'])); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.vendor.request')); ?>">
                        <i class="menu-icon las la-hand-point-right"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Vendor Requests'); ?></span>
                        <?php if($ownerRequestCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto"><?php echo e($ownerRequestCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.owners*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-hotel"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Hotels'); ?></span>
                        <?php if($bannedOwnersCount > 0): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="sidebar-submenu <?php echo e(menuActive('admin.owners*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.owners.active')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.owners.active')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Active Hotels'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.owners.banned')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.owners.banned')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Banned Hotels'); ?></span>
                                    <?php if($bannedOwnersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($bannedOwnersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.owners.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.owners.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Hotels'); ?></span>
                                </a>
                            </li>

                            <hr class="my-0">
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.owners.notification.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.owners.notification.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Send Notification to All'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.deposit*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-file-invoice-dollar"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Payments'); ?></span>
                        <?php if(0 < $pendingDepositsCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.deposit*', 2)); ?> ">
                        <ul>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.pending')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.deposit.pending')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Pending Payments'); ?></span>
                                    <?php if($pendingDepositsCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($pendingDepositsCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.approved')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.deposit.approved')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Approved Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.successful')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.deposit.successful')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Successful Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.rejected')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.deposit.rejected')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Rejected Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.initiated')); ?> ">

                                <a class="nav-link" href="<?php echo e(route('admin.deposit.initiated')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Initiated Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.deposit.list')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.deposit.list')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Payments'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.withdraw*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-bank"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Withdrawals'); ?> </span>
                        <?php if(0 < $pendingWithdrawCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.withdraw*', 2)); ?> ">
                        <ul>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.withdraw.method.*')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.withdraw.method.index')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Withdrawal Methods'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.withdraw.pending')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.withdraw.pending')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Pending Withdrawals'); ?></span>

                                    <?php if($pendingWithdrawCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($pendingWithdrawCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.withdraw.approved')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.withdraw.approved')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Approved Withdrawals'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.withdraw.rejected')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.withdraw.rejected')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Rejected Withdrawals'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.withdraw.log')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.withdraw.log')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Withdrawals'); ?></span>
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>

                <!-- 77777777777 -->
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.dashboard')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.dashboard')); ?>">
                        <i class="menu-icon las la-home"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Cars'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.carlocation*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-globe"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Locations'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.carlocation*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carlocation.countr.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carlocation.countr.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Countries'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carlocation.cit.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carlocation.cit.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Cities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carlocation.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carlocation.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Locations'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.carads.all')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.carads.all')); ?>">
                        <i class="menu-icon las la-ad"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Ads'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.hotel*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-tools"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Hotel Attributes'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.hotel*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.amenity.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.amenity.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Amenities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.facility.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.facility.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Facilities'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.bed.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.bed.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Bed Types'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
               

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.hotel*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-tools"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Car Attributes'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.hotel*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.amenity.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.amenity.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car1'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.facility.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.facility.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car2'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.hotel.bed.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.hotel.bed.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Car3'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.users*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-users"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Registered Users'); ?></span>
                        <?php if($bannedUsersCount > 0 || $emailUnverifiedUsersCount > 0 || $mobileUnverifiedUsersCount > 0): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="sidebar-submenu <?php echo e(menuActive('admin.users*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.active')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.active')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Active Users'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.banned')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.banned')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Banned Users'); ?></span>
                                    <?php if($bannedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($bannedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.email.unverified')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.email.unverified')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Email Unverified'); ?></span>

                                    <?php if($emailUnverifiedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($emailUnverifiedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.mobile.unverified')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.mobile.unverified')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Mobile Unverified'); ?></span>
                                    <?php if($mobileUnverifiedUsersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($mobileUnverifiedUsersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Users'); ?></span>
                                </a>
                            </li>
                            
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.deleted')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.deleted')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Deleted Users'); ?></span>
                                </a>
                            </li>

                            <hr class="my-0">
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.users.notification.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.users.notification.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Send Notification to All'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive(['admin.carvendor.request', 'admin.carvendor.request.detail'])); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.carvendor.request')); ?>">
                        <i class="menu-icon las la-hand-point-right"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Car Vendor Requests'); ?></span>
                        <?php if($ownerRequestCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto"><?php echo e($ownerRequestCount); ?></span>
                        <?php endif; ?>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.carowner*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-hotel"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Cars'); ?></span>
                        <?php if($bannedOwnersCount > 0): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="sidebar-submenu <?php echo e(menuActive('admin.carowner*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carowner.active')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carowner.active')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Active Cars'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carowner.banned')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carowner.banned')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Banned Cars'); ?></span>
                                    <?php if($bannedOwnersCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($bannedOwnersCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.carowner.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.carowner.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Cars'); ?></span>
                                </a>
                            </li>

                            <hr class="my-0">
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.owners.notification.all')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.owners.notification.all')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Send Notification to All'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.cardeposi*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-file-invoice-dollar"></i>
                        <span class="menu-title"><?php echo app('translator')->get('CarPayments'); ?></span>
                        <?php if(0 < $pendingDepositsCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.cardeposi*', 2)); ?> ">
                        <ul>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.pending')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.pending')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Pending Payments'); ?></span>
                                    <?php if($pendingDepositsCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($pendingDepositsCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.approved')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.approved')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Approved Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.successful')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.successful')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Successful Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.rejected')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.rejected')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Rejected Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.initiated')); ?> ">

                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.initiated')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Initiated Payments'); ?></span>
                                </a>
                            </li>

                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.cardeposi.list')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.cardeposi.list')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Payments'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

              
                <!-- 7777777777777 -->

                <li class="sidebar__menu-header"><?php echo app('translator')->get('Support & Report'); ?></li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.ticket*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-ticket"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Support Tickets'); ?> </span>
                        <?php if(0 < $pendingTicketCount): ?>
                            <span class="menu-badge pill bg--danger ms-auto">
                                <i class="fa fa-exclamation"></i>
                            </span>
                        <?php endif; ?>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.ticket*', 2)); ?> ">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.ticket.pending')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.ticket.pending')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Pending Ticket'); ?></span>
                                    <?php if($pendingTicketCount): ?>
                                        <span class="menu-badge pill bg--danger ms-auto"><?php echo e($pendingTicketCount); ?></span>
                                    <?php endif; ?>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.ticket.closed')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.ticket.closed')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Closed Ticket'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.ticket.answered')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.ticket.answered')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Answered Ticket'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.ticket.index')); ?> ">
                                <a class="nav-link" href="<?php echo e(route('admin.ticket.index')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('All Ticket'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.report*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Reports'); ?> </span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.report*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive(['admin.report.transaction', 'admin.report.transaction.search'])); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.report.transaction')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Transaction Log'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.report.notification.history')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.report.notification.history')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Notification History'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive(['admin.report.owner.login.history', 'admin.report.owner.login.ipHistory'])); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.report.owner.login.history')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Vendors Login History'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive(['admin.report.user.login.history', 'admin.report.user.login.ipHistory'])); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.report.user.login.history')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Users Login History'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header"><?php echo app('translator')->get('System Settings'); ?></li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.index')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.setting.index')); ?>">
                        <i class="menu-icon las la-life-ring"></i>
                        <span class="menu-title"><?php echo app('translator')->get('General Setting'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.cron*')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.cron.index')); ?>">
                        <i class="menu-icon las la-clock"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Cron Job Setting'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.system.configuration')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.setting.system.configuration')); ?>">
                        <i class="menu-icon las la-cog"></i>
                        <span class="menu-title"><?php echo app('translator')->get('System Configuration'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.gateway*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-credit-card"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Payment Gateways'); ?></span>

                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.gateway*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.gateway.automatic.index')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.gateway.automatic.index')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Automatic Gateways'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.gateway.manual.index')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.gateway.manual.index')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Manual Gateways'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.logo.icon')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.setting.logo.icon')); ?>">
                        <i class="menu-icon las la-images"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Logo & Favicon'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.extensions.index')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.extensions.index')); ?>">
                        <i class="menu-icon las la-cogs"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Extensions'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive(['admin.language.manage', 'admin.language.key'])); ?>">
                    <a class="nav-link" data-default-url="<?php echo e(route('admin.language.manage')); ?>" href="<?php echo e(route('admin.language.manage')); ?>">
                        <i class="menu-icon las la-language"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Language'); ?> </span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.seo')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.seo')); ?>">
                        <i class="menu-icon las la-globe"></i>
                        <span class="menu-title"><?php echo app('translator')->get('SEO Manager'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item <?php echo e(menuActive('admin.owner.form.setting')); ?>">
                    <a href="<?php echo e(route('admin.owner.form.setting')); ?>" class="nav-link">
                        <i class="menu-icon las la-user-check"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Vendor Form'); ?></span>
                    </a>
                </li>

                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.setting.notification*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon las la-bell"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Notification Setting'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.setting.notification*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.global')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.setting.notification.global')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Global Template'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.email')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.setting.notification.email')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Email Setting'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.sms')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.setting.notification.sms')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('SMS Setting'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.push')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.setting.notification.push')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Push Notification Setting'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.notification.templates')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.setting.notification.templates')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Notification Templates'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar__menu-header"><?php echo app('translator')->get('Frontend Manager'); ?></li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.frontend.manage.pages')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.frontend.manage.pages')); ?>">
                        <i class="menu-icon la la-list"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Pages'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.frontend.sections*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-puzzle-piece"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Manage Section'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.frontend.sections*', 2)); ?>">
                        <ul>
                            <?php
                                $lastSegment = collect(request()->segments())->last();
                            ?>
                            <?php $__currentLoopData = getPageSections(true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $secs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($secs['builder']): ?>
                                    <li class="sidebar-menu-item <?php if($lastSegment == $k): ?> active <?php endif; ?>">
                                        <a class="nav-link" href="<?php echo e(route('admin.frontend.sections', $k)); ?>">
                                            <i class="menu-icon las la-dot-circle"></i>
                                            <span class="menu-title"><?php echo e(__($secs['name'])); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                </li>
                <li class="sidebar__menu-header"><?php echo app('translator')->get('Extra'); ?></li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.maintenance.mode')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.maintenance.mode')); ?>">
                        <i class="menu-icon las la-robot"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Maintenance Mode'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.cookie')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.setting.cookie')); ?>">
                        <i class="menu-icon las la-cookie-bite"></i>
                        <span class="menu-title"><?php echo app('translator')->get('GDPR Cookie'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item sidebar-dropdown">
                    <a class="<?php echo e(menuActive('admin.system*', 3)); ?>" href="javascript:void(0)">
                        <i class="menu-icon la la-server"></i>
                        <span class="menu-title"><?php echo app('translator')->get('System'); ?></span>
                    </a>
                    <div class="sidebar-submenu <?php echo e(menuActive('admin.system*', 2)); ?>">
                        <ul>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.info')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.system.info')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Application'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.server.info')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.system.server.info')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Server'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.optimize')); ?>">
                                <a class="nav-link" href="<?php echo e(route('admin.system.optimize')); ?>">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Cache'); ?></span>
                                </a>
                            </li>
                            <li class="sidebar-menu-item <?php echo e(menuActive('admin.system.update')); ?> ">
                                <a href="<?php echo e(route('admin.system.update')); ?>" class="nav-link">
                                    <i class="menu-icon las la-dot-circle"></i>
                                    <span class="menu-title"><?php echo app('translator')->get('Update'); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.setting.custom.css')); ?>">
                    <a class="nav-link" href="<?php echo e(route('admin.setting.custom.css')); ?>">
                        <i class="menu-icon lab la-css3-alt"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Custom CSS'); ?></span>
                    </a>
                </li>
                <li class="sidebar-menu-item <?php echo e(menuActive('admin.request.report')); ?>">
                    <a class="nav-link" data-default-url="<?php echo e(route('admin.request.report')); ?>" href="<?php echo e(route('admin.request.report')); ?>">
                        <i class="menu-icon las la-bug"></i>
                        <span class="menu-title"><?php echo app('translator')->get('Report & Request'); ?> </span>
                    </a>
                </li>
            </ul>
            <div class="text-uppercase mb-3 text-center">
                <span class="text--primary"><?php echo e(__(systemDetails()['name'])); ?></span>
                <span class="text--success"><?php echo app('translator')->get('V'); ?><?php echo e(systemDetails()['version']); ?> </span>
            </div>
        </div>
    </div>
</div>
<!-- sidebar end -->

<?php $__env->startPush('style'); ?>
    <style>
        .transform-rotate-180 {
            transform: rotate(180deg)
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
    <script>
        if ($('li').hasClass('active')) {
            $('#sidebar__menuWrapper').animate({
                scrollTop: eval($(".active").offset().top - 320)
            }, 500);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\xampp\htdocs\car_book\core\resources\views/admin/partials/sidenav.blade.php ENDPATH**/ ?>