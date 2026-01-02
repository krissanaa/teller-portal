@auth
<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="tellerToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body d-flex align-items-center gap-2">
                <i class="bi bi-bell-fill fs-5"></i>
                <span id="tellerToastMessage">Notification received!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
    <script type="module">
        document.addEventListener('DOMContentLoaded', function() {
            console.log('Teller notification component loaded');
            console.log('Echo available:', typeof Echo !== 'undefined');

            // Badge management
            let unreadCount = 0;
            const notificationBtn = document.querySelector('.notification-btn');
            let badge = notificationBtn ? notificationBtn.querySelector('.notification-badge') : null;

            // Clear badge when dropdown is opened
            const notifDropdown = document.getElementById('notifDropdown');
            if (notifDropdown) {
                notifDropdown.addEventListener('click', function() {
                    unreadCount = 0;
                    if (badge) {
                        badge.remove();
                        badge = null;
                    }
                    console.log('Badge cleared');
                });
            }

            if (typeof Echo !== 'undefined') {
                const userId = "{{ auth()->id() }}";
                console.log('Subscribing to teller.' + userId);

                Echo.private(`teller.${userId}`)
                    .subscribed(() => {
                        console.log('✅ Successfully subscribed to teller.' + userId);
                    })
                    .error((error) => {
                        console.error('❌ Failed to subscribe to teller channel:', error);
                    })
                    .listen('.RequestStatusUpdated', (e) => {
                        console.log('🔔 Status update received!', e);

                        // Increment unread count
                        unreadCount++;
                        console.log('Unread count:', unreadCount);

                        // Update or create badge
                        if (notificationBtn) {
                            if (!badge) {
                                badge = document.createElement('span');
                                badge.className = 'notification-badge';
                                notificationBtn.appendChild(badge);
                            }
                            badge.innerText = unreadCount;
                        }

                        // Show toast
                        const toastElement = document.getElementById('tellerToast');
                        const toastMessage = document.getElementById('tellerToastMessage');

                        if (toastElement && toastMessage) {
                            toastMessage.innerText = e.message;

                            // Change color based on status
                            if (e.status === 'rejected') {
                                toastElement.classList.remove('text-bg-success');
                                toastElement.classList.add('text-bg-danger');
                            } else {
                                toastElement.classList.remove('text-bg-danger');
                                toastElement.classList.add('text-bg-success');
                            }

                            const toast = new bootstrap.Toast(toastElement);
                            toast.show();
                        }
                    });
            } else {
                console.error('Echo is not defined!');
            }
        });
    </script>
    @endauth