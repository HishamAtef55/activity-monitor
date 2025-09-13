<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
            @permission('posts-create')
                <a href="{{ route('posts.create') }}">
                    <x-form-button>
                        + Create Post
                    </x-form-button>
                </a>
            @endpermission
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="table-fixed w-auto mx-auto divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="w-16 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                            <th class="w-80 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="w-40 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Author</th>
                            <th class="w-28 px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="w-44 px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($posts as $post)
                            <tr>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $post->id }}</td>
                                <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ $post->title }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $post->user->name ?? 'Unknown' }}</td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($post->status === 'pending')
                                        <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @elseif ($post->status === 'approved')
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Approved</span>
                                    @elseif ($post->status === 'rejected')
                                        <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Rejected</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-sm text-center flex justify-center gap-2">
                                    <!-- Edit -->

                                    @if($post->user_id == auth()->id() || auth()->user()->hasRole('administrator'))
                                        <a href="{{ route('posts.edit', $post) }}" 
                                        title="Edit"
                                        class="inline-flex items-center px-4 py-2 border border-blue-600 text-blue-600 text-sm font-medium rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition">
                                        Edit
                                        </a>

                                        <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            @csrf @method('DELETE')
                                                <x-danger-button style="padding:12px;">
                                                    Delete
                                                </x-danger-button>
                                        </form>
                                    @endif


                                    @if(
                                    $post->status === 'pending'
                                    &&
                                    ($post->user_id == auth()->id() || auth()->user()->hasRole('administrator'))
                                    
                                    )
                                        <!-- Approve -->
                                        <form action="{{ route('posts.update', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to approve this post?');">
                                            <input type="hidden" name="title" value="{{ $post->title }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" title="Approve"
                                                class="p-2 bg-green-100 text-green-600 rounded-full hover:bg-green-200 text-lg">
                                                ✔
                                            </button>
                                        </form>
                                        <!-- Reject -->
                                        <form action="{{ route('posts.update', $post) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this post?');"">
                                            <input type="hidden" name="title" value="{{ $post->title }}">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" title="Reject"
                                                class="p-2 bg-red-100 text-red-600 rounded-full hover:bg-red-200 text-lg">
                                                ✖
                                            </button>
                                        </form>

                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">
                                    No posts available.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>


    @if (auth()->check())
    <script>
        const idleTimeout = {{ \App\Models\Setting::getIdleTimeout() }} * 1000; // ms
        let inactivityCount = parseInt(sessionStorage.getItem('inactivityCount')) || 0;
        let idleTimer;
        let firstAlertAcknowledged = false;
        console.log('Idle timeout set to', idleTimeout / 1000, 'seconds');
        console.log('Inactivity count from session:', inactivityCount);         
        console.log('First alert acknowledged:', firstAlertAcknowledged);
        function resetIdleTimer() {
            clearTimeout(idleTimer);
            idleTimer = setTimeout(handleIdle, idleTimeout);
        }

        function handleIdle() {
            inactivityCount++;
            sessionStorage.setItem('inactivityCount', inactivityCount);

            // Log idle to backend each time
            // fetch('/log-idle', {
            //     method: 'POST',
            //     headers: {
            //         'Content-Type': 'application/json',
            //         'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //     },
            //     body: JSON.stringify({ action: 'idle' })
            // });

            if (inactivityCount === 1 && !firstAlertAcknowledged) {
                // First: Alert
                firstAlertAcknowledged = true;
                alert('You have been inactive. Please interact to continue.');
            } else if (inactivityCount === 2 && firstAlertAcknowledged) {
                // Second: Warning
                alert('Warning: Continued inactivity will lead to logout.');
            } else if (inactivityCount === 3) {
                // Third: Logout + Penalty
                fetch('/logout-with-penalty', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(() => {
                    window.location.href = '/login'; // Redirect to login
                });
            }

            resetIdleTimer(); // Continue monitoring
        }

        // Event listeners
        window.addEventListener('mousemove', resetIdleTimer);
        window.addEventListener('keydown', resetIdleTimer);
        window.addEventListener('scroll', resetIdleTimer); // Creative: Add scroll for touch devices
        window.addEventListener('load', resetIdleTimer); // Creative: Add scroll for touch devices

        // Start timer
        resetIdleTimer();
    </script>
@endif
</x-app-layout>
