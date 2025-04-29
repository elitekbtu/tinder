<nav x-data="{ open: false }" class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-8 w-auto fill-current text-red-500" />
                    </a>
                </div>

                <div class="hidden space-x-6 sm:-my-px sm:ml-8 sm:flex">
                    <x-nav-link :href="route('stats.index')" :active="request()->routeIs('stats.index')" class="hover:text-red-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V16a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-5.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                            </svg>
                            {{ __('Главная') }}
                        </div>
                    </x-nav-link>
                    <x-nav-link :href="route('swipe.index')" :active="request()->routeIs('swipe.index')" class="hover:text-red-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Свайп') }}
                        </div>
                    </x-nav-link>
                    <x-nav-link :href="route('memes.index')" :active="request()->routeIs('memes.index')" class="hover:text-red-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 24 24" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm16 12H4l4-8 3 6 2-4 3 6 3-6 2 4 3-6 4 8z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Все мемы') }}
                        </div>
                    </x-nav-link>
                    <x-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')" class="hover:text-red-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Избранное') }}
                        </div>
                    </x-nav-link>
                    <x-nav-link :href="route('matches.index')" :active="request()->routeIs('matches.index')" class="hover:text-red-500">
                        <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                            {{ __('Совпадения') }}
                        </div>
                    </x-nav-link>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-700 hover:text-red-500 focus:outline-none transition duration-150 ease-in-out">
                            <div class="flex items-center">
                                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-2">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                {{ Auth::user()->name }}
                            </div>
                            <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')" class="hover:bg-red-50 hover:text-red-600">
                            {{ __('Профиль') }}
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="hover:bg-red-50 hover:text-red-600"
                                             onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Выйти') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 hover:text-red-500 hover:bg-gray-100 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white shadow-lg">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('stats.index')" :active="request()->routeIs('stats.index')" class="hover:bg-red-50 hover:text-red-600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V16a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-5.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                    </svg>
                    {{ __('Главная') }}
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('swipe.index')" :active="request()->routeIs('swipe.index')" class="hover:bg-red-50 hover:text-red-600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M11.3 1.046A1 1 0 0112 2v5h4a1 1 0 01.82 1.573l-7 10A1 1 0 018 18v-5H4a1 1 0 01-.82-1.573l7-10a1 1 0 011.12-.38z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Свайп') }}
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('memes.index')" :active="request()->routeIs('memes.index')" class="hover:bg-red-50 hover:text-red-600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h16a2 2 0 002-2V5a2 2 0 00-2-2H4zm16 12H4l4-8 3 6 2-4 3 6 3-6 2 4 3-6 4 8z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Все мемы') }}
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('favorites.index')" :active="request()->routeIs('favorites.index')" class="hover:bg-red-50 hover:text-red-600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Избранное') }}
                </div>
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('matches.index')" :active="request()->routeIs('matches.index')" class="hover:bg-red-50 hover:text-red-600">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Совпадения') }}
                </div>
            </x-responsive-nav-link>
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center">
                <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center text-red-600 font-bold mr-3">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')" class="hover:bg-red-50 hover:text-red-600">
                    {{ __('Профиль') }}
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" class="hover:bg-red-50 hover:text-red-600"
                                           onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Выйти') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
