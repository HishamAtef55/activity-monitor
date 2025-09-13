<div id="inactivity-modal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
        <h2 class="text-xl font-bold text-gray-800 mb-4">Inactivity Warning</h2>
        <p class="text-gray-600 mb-6"></p>
    </div>
</div>

<script>

    (function () {
        let idleTime = 0;
        let inactivityCount = parseInt(sessionStorage.getItem('inactivityCount')) || 0;
        const idleTimeoutSeconds = {{ \App\Models\Setting::getIdleTimeout() }};
        const enableIdleMonitoring = @json((bool) optional(Auth::user()->roles[0])->idle_monitoring);
        const idleThreshold = idleTimeoutSeconds * 1000;
        const logoutEndpoint = '/logout-inactive';
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const modal = document.getElementById('inactivity-modal');
        const modalMessage = document.querySelector('#inactivity-modal p');


        function showModal() {
            modal.classList.remove('hidden');
        }

        function hideModal() {
            modal.classList.add('hidden');
        }

        function resetIdleTimer() {
            idleTime = 0;
            if (!modal.classList.contains('hidden')) {
                hideModal();
            }
        }

        function checkIdleTime() {
            if(!enableIdleMonitoring) return;
            idleTime += 1000;
            if (idleTime >= idleThreshold) {
                inactivityCount++;
                sessionStorage.setItem('inactivityCount', inactivityCount);
                handleInactivity();
            }
        }

        function handleInactivity() {
            if (inactivityCount  === 1) {
                modalMessage.textContent = `You have been inactive for ${idleTimeoutSeconds} seconds. Please click OK to continue your session.`;
                showModal();
                idleTime = 0;
            } else if (inactivityCount  === 2) {
                modalMessage.textContent = `This is your ${inactivityCount } warning. Continued inactivity will log you out.`;
                showModal();
                idleTime = 0;
            } else if (inactivityCount >= 3) {
                fetch(logoutEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    }
                })
                .then(response => {
                    if (response.ok) {
                        hideModal();
                        sessionStorage.removeItem('inactivityCount');
                        window.location.href = '/login';
                    }
                })
                .then(data => console.log(data.message))
                .catch(error => console.error('Logout failed:', error));
            }
        }

        window.addEventListener('mousemove', resetIdleTimer);
        window.addEventListener('keydown', resetIdleTimer);

        setInterval(checkIdleTime, 1000);
    })();
</script>