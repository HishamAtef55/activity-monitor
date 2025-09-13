<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Employees') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
            
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-white-700">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-bold tracking-wider">
                                    {{ __('Employee') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold tracking-wider">
                                    {{ __('Actions') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold tracking-wider">
                                    {{ __('Idle Counts') }}
                                </th>
                                <th scope="col" class="px-6 py-3 font-bold tracking-wider">
                                    {{ __('Penalties') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($reports as $report)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $report['name'] }}
                                    </td>
                                    <td class="px-6 py-4 font-semibold text-blue-600 whitespace-nowrap">
                                        {{ $report['actions'] }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 whitespace-nowrap">
                                        {{ $report['idle_count'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            {{ $report['penalties'] > 0 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $report['penalties'] }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center">
                                        <div class="text-gray-500">
                                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 3h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-sm font-medium">{{ __('No reports available.') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>