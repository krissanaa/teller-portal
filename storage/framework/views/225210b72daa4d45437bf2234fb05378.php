<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill fs-5"></i>
                <span id="toastMessage">New onboarding request received!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script type="module">
    // Wait for both DOM and Livewire to be ready
    function initAdminNotifications() {
        console.log('Admin notification component loaded');
        console.log('Echo available:', typeof Echo !== 'undefined');

        if (typeof Echo !== 'undefined') {
            Echo.private('admin-channel')
                .subscribed(() => {
                    console.log('✅ Successfully subscribed to admin-channel');
                })
                .error((error) => {
                    console.error('❌ Failed to subscribe to admin-channel:', error);
                })
                .listen('.NewOnboardingRequest', (e) => {
                    console.log('🔔 Event received!', e);
                    const toastElement = document.getElementById('liveToast');
                    const toastMessage = document.getElementById('toastMessage');

                    // Update menu badge and count text
                    const menuBadge = document.getElementById('menu-pending-badge');
                    const countText = document.getElementById('pending-count-text');
                    const nextCount = Number(e.pendingCount ?? 0);

                    console.log('Updating menu badge to:', nextCount);
                    console.log('Menu badge element:', menuBadge);
                    console.log('Count text element:', countText);

                    if (nextCount > 0) {
                        // Update or create badge
                        if (menuBadge) {
                            menuBadge.innerText = nextCount;
                            console.log('✅ Badge updated');
                        } else {
                            // Create badge if it doesn't exist
                            const actionCard = document.querySelector('a[href*="admin.onboarding.index"]');
                            console.log('Action card found:', actionCard);
                            if (actionCard) {
                                const badge = document.createElement('span');
                                badge.className = 'menu-badge';
                                badge.id = 'menu-pending-badge';
                                badge.innerText = nextCount;
                                actionCard.appendChild(badge);
                                console.log('✅ Badge created');
                            } else {
                                console.error('❌ Could not find action card');
                            }
                        }

                        // Update count text
                        if (countText) {
                            countText.innerText = `${nextCount} ລາຍການ`;
                            console.log('✅ Count text updated');
                        }
                    }

                    // Show toast notification
                    if (toastElement && toastMessage) {
                        const storeName = e.onboardingRequest?.store_name ?? 'New onboarding request';
                        toastMessage.innerText = `New Request: ${storeName} has applied!`;
                        const toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    }
                })
                .listen('.NewUserRegistered', (e) => {
                    console.log('👤 New User Registered!', e);

                    // Update pending users badge
                    const usersBadge = document.getElementById('menu-pending-users-badge');
                    const usersCard = document.querySelector('a[href*="admin.users.index"]');
                    const nextCount = Number(e.pendingUsersCount ?? 0);

                    console.log('Updating pending users badge to:', nextCount);

                    if (nextCount > 0) {
                        if (usersBadge) {
                            usersBadge.innerText = nextCount;
                            console.log('✅ Users badge updated');
                        } else if (usersCard) {
                            // Create badge if it doesn't exist
                            const badge = document.createElement('span');
                            badge.className = 'menu-badge';
                            badge.id = 'menu-pending-users-badge';
                            badge.innerText = nextCount;
                            usersCard.appendChild(badge);
                            console.log('✅ Users badge created');

                            // Also add subtitle if it doesn't exist
                            const actionInfo = usersCard.querySelector('.action-info');
                            if (actionInfo && !actionInfo.querySelector('.action-subtitle')) {
                                const subtitle = document.createElement('p');
                                subtitle.className = 'action-subtitle';
                                subtitle.innerText = `${nextCount} ລໍຖ້າອະນຸມັດ`;
                                actionInfo.appendChild(subtitle);
                            }
                        }
                    }

                    // Show toast notification
                    const toastElement = document.getElementById('liveToast');
                    const toastMessage = document.getElementById('toastMessage');
                    if (toastElement && toastMessage) {
                        const userName = e.user?.name ?? 'New user';
                        toastMessage.innerText = `New User: ${userName} registered!`;
                        const toast = new bootstrap.Toast(toastElement);
                        toast.show();
                    }
                });
        } else {
            console.error('Echo is not defined!');
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAdminNotifications);
    } else {
        // DOM already loaded, wait a bit for Livewire
        setTimeout(initAdminNotifications, 500);
    }
</script><?php /**PATH /var/www/html/resources/views/components/admin-notification.blade.php ENDPATH**/ ?>