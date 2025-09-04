<nav class="bg-white shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Left side - Logo and Main Links -->
            <div class="flex items-center">
                <!-- Logo -->
                <a href="{{ route('dashboard') }}" class="flex items-center">
                    
                    <img src="/assets/image/joinus.png" alt="Join Us" class="w-5 h-5" />
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                    
                    <x-nav-link :href="route('admin.schools.index')" :active="request()->routeIs('admin.schools.*')">
                        Schools
                    </x-nav-link>
                    
                </div>
            </div>

            <!-- Right side - User Controls -->
            <div class="flex items-center">
                <!-- Add User Button (Admin Only) -->
                
                <a href="{{ route('admin.users.create') }}" 
                   class="btn btn-alert text-sm font-medium rounded-md hover:bg-grey-700 transition">
                    Add User
                </a>
                
                <!-- User Dropdown -->
                <div class="relative ml-3">
                    <x-dropdown align="right">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm rounded-full focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <span class="mr-2 text-gray-900">{{ Auth::user()->username }}</span>
                                <img class="h-8 w-8 rounded-full" 
                                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->username) }}&background=random" 
                                     alt="User avatar">
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')" 
                                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Mobile menu button -->
                <button @click="open = !open" class="sm:hidden p-2 rounded-md text-gray-500 hover:text-gray-600 hover:bg-gray-100 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              :d="open ? 'M6 18L18 6M6 6l12 12' : 'M4 6h16M4 12h16M4 18h16'" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="open" class="sm:hidden" x-transition>
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                Dashboard
            </x-responsive-nav-link>
            @can('admin')
            <x-responsive-nav-link :href="route('admin.schools.index')" :active="request()->routeIs('admin.schools.*')">
                Schools
            </x-responsive-nav-link>
            <x-responsive-nav-link :href="route('admin.users.create')">
                Add User
            </x-responsive-nav-link>
            @endcan
        </div>

        <div class="pt-4 pb-3 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <img class="h-10 w-10 rounded-full" 
                         src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random" 
                         alt="User avatar">
                </div>
                <div class="ml-3">
                    <div class="text-base font-medium text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-sm font-medium text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="mt-3 space-y-1">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')" 
                                         onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>