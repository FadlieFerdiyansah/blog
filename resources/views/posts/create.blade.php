<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('posts.store') }}" method="post" enctype="multipart/form-data" class="w-5/12">
                        @csrf

                        <div class="mb-5">
                            <x-label for="image" class="block mt-1 w-full" :value="__('Image')" />

                            <input type="file" name="image" id="image" class="mt-3">
                            @error('image')
                                <div class="text-sm text-red-700 mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <x-label for="title" :value="__('Title')" />
            
                            <x-input id="title" class="block mt-1 w-full" type="text" name="title" :value="old('title')" autofocus />
                            @error('title')
                                <div class="text-sm text-red-700 mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-5">
                            <x-label for="body" :value="__('Body')" />
            
                            <x-textarea id="body" class="block mt-1 w-full" name="body"> {{ old('body') }} </x-textarea>
                            @error('body')
                                <div class="text-sm text-red-700 mt-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-5">
                            <x-button> Simpan </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>