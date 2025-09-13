<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
         <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.store') }}">
                    @csrf

                    <!-- Title -->
                    <div class="mb-6">
                        {{-- <x-form-label for="title">Title</x-form-label> --}}
                        <x-form-input id="title" name="title" type="text" placeholder="Enter post title" value="{{ old('title') }}" />
                        <x-form-error name="title" />
                    </div>

                    <!-- Buttons -->
                    <div class="mt-6 flex items-center justify-end gap-x-4">
                        <x-form-button>
                            Save
                        </x-form-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
