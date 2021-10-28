<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Posts') }}
            </h2>
            @auth
            <a href="{{ route('posts.create') }}"
                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create
            </a>
            @endauth
        </div>
    </x-slot>

    @if (session('success'))
    <div class="bg-green-400 rounded-md p-5 text-white mb-4">{{ session('success') }}</div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid gap-6 mb-8 md:grid-cols-2 lg:grid-cols-3">
                        @forelse ($posts as $post)
                        <div class="max-w-sm rounded overflow-hidden shadow-lg">
                            <img class="w-full h-3/6 object-cover object-center" src="{{ $post->thumbnail }}"
                                alt="{{ $post->title }}">
                            <div class="px-6 py-4">
                                <div class="font-bold text-xl mb-2"><a href="{{ route('posts.show', $post->slug) }}">{{
                                        $post->title }}</a></div>
                                <p class="text-gray-700 text-base">
                                    {{ Str::limit($post->body, 200) }}
                                </p>
                            </div>
                            <div class="px-6 pt-4 pb-2 mb-8 md:mb-0">
                                <div class="flex space-x-2 w-full">
                                    <div class="flex h-20">
                                        <div class="relative">
                                            <img class="rounded-full border border-gray-100 shadow-sm w-2/5"
                                                src="https://randomuser.me/api/portraits/women/81.jpg" alt="user image" />
                                        </div>
                                        <small class="leading-9 -ml-12 w-full">
                                            <span class="text-gray-400">Writen By</span> <b>{{ $post->user->name }}</b> <br>
                                            {{-- <span class="text-gray-400">Posted {{ $post->created_at->diffForHumans() }}</span> --}}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                    </div>
                    <div class="bg-red-600 rounded-md p-5 text-white w-5/12">There is no posts</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>