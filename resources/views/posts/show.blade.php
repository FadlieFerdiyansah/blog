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
                    <img class="w-full object-cover object-center" src="{{ $post->thumbnail }}" style="height: 450px">
                    <div class="px-6 py-4">
                        <div class="flex justify-between">
                            <div>
                                <div class="font-bold text-3xl mb-2">{{ $post->title }}</div>
                                <p class="text-gray-700 text-base w-full">
                                    {{ $post->body }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="px-6 pt-4 pb-2">
                        <div class="flex space-x-2 w-full md:w-2/5">
                            <div class="flex h-20">
                                <div class="relative w-1/4 h-12">
                                    <img class="rounded-full border border-gray-100 shadow-sm"
                                        src="https://randomuser.me/api/portraits/women/81.jpg" alt="user image" />
                                </div>
                                <small class="leading-9 ml-3">
                                    <span class="text-gray-400">Writen By</span> <b>{{ $post->user->name }}</b> <br>
                                    <span class="text-gray-400">Posted {{ $post->created_at->diffForHumans() }}</span>
                                </small>
                            </div>
                        </div>

                        <div class="flex mt-20 md:mt-10">
                            @if (!Auth::check())
                            <a href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer float-left"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </a>
                            @else
                            <form action="{{ route('like', $post) }}" method="post">
                                @csrf
                                <button type="submit">
                                    @if ($userLikedPost)
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 float-left"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @else
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 cursor-pointer float-left"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                    </svg>
                                    @endif
                                </button>
                            </form>
                            @endif
                            <span class="text-gray-500 ml-2">{{ $post->likes_count }}</span>


                            @if (!Auth::check())
                            <a href="{{ route('login') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-5 cursor-pointer" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </a>
                            @else
                            <button id="comment">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-5 cursor-pointer" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                </svg>
                            </button>
                            @endif

                            <span class="text-gray-500 ml-2">{{ $post->comments_count }}</span>
                        </div>
                        <form action="{{ route('posts.store_comment', $post) }}" method="post" id="form-comment">
                            @csrf
                            <x-textarea id="body" class="block mt-1 w-full" name="body"> {{ old('body') }} </x-textarea>
                            <x-button class="mt-3">Kirim</x-button>
                        </form>
                    </div>
                    <hr class="py-3">
                    <div class="px-5">
                        <h3 class="text-2xl text-gray-500 uppercase"><span class="underline">Komentar</span></h3>
                        @forelse ($post->comments as $comment)
                        <div class="mt-4 border-2 p-3">
                            <small class="text-gray-400">{{ $comment->user->name }} - {{ $comment->created_at->diffForHumans() }}</small>
                            <p>{{ $comment->body }}</p>
                        </div>
                        @empty

                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"
            integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        <script>
            $(document).ready(function(){
                $("#form-comment").hide();
                $("#comment").click(function(){
                    $("#form-comment").fadeToggle();
                });
            });
        </script>
        @endpush
</x-app-layout>