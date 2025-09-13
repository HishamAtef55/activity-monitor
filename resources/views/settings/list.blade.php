<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <!-- Roles Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-700">Role Idle Monitoring</h3>
                </div>
                <table class="w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                            <th class="px-4 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Idle Monitoring</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($roles as $role)
                            <tr>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                    {{ $role->display_name }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('roles.toggle-idle-monitoring', $role) }}" method="POST">
                                        @csrf
                                        @method('PUT')

                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="idle_monitoring" value="1" 
                                                class="sr-only peer"
                                                onchange="this.form.submit()"
                                                {{ $role->idle_monitoring ? 'checked' : '' }}>

                                            <div class="relative w-11 h-6 bg-gray-200 rounded-full 
                                                        peer-focus:ring-4 peer-focus:ring-blue-300 
                                                        dark:peer-focus:ring-blue-800 dark:bg-gray-700 
                                                        peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600
                                                        peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full
                                                        after:content-[''] after:absolute after:top-0.5 after:start-[2px]
                                                        after:bg-white after:border-gray-300 after:border after:rounded-full
                                                        after:h-5 after:w-5 after:transition-all dark:border-gray-600">
                                            </div>

                                            <!-- Label -->
                                            <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $role->idle_monitoring ? 'On' : 'Off' }}
                                            </span>
                                        </label>
                                    </form>


                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="py-12">
                <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white shadow sm:rounded-lg p-6">
                        <form method="POST" action="{{ route('settings.update') }}">
                            @csrf
                            @method('PUT')

                            <!-- Title -->
                            <div class="mb-6">
                                <x-form-label>
                                    Idle Time (seconds)
                                </x-form-label>    
                                <x-form-input 
                                    id="idle_time" 
                                    name="idle_time" 
                                    type="number"  
                                    value="{{ old('idle_time', $idleTime) }}" />
                                <x-form-error name="idle_time" />
                            </div>

                            <!-- Buttons -->
                            <div class="mt-6 flex items-center justify-end gap-x-4">

                                <x-form-button>
                                    Update
                                </x-form-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
