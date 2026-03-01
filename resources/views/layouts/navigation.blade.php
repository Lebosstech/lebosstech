<nav x-data="{ open: false, dashboardOpen: false, productsOpen: false }" class="bg-gradient-to-r from-orange-600 to-red-600 shadow-xl border-b-4 border-orange-700">
    <!-- Primary Navigation Menu Enhanced -->
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-10">
        <div class="flex justify-between h-20">
            <div class="flex items-center space-x-8">
                <!-- Logo Enhanced -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center group">
                        <div class="w-12 h-12 bg-white rounded-xl flex items-center justify-center shadow-lg group-hover:shadow-xl transition-all">
                            <i class="fas fa-crown text-orange-600 text-xl"></i>
                        </div>
                        <div class="ml-3 text-white">
                            <div class="text-xl font-black">LEBOSS TECH</div>
                            <div class="text-xs font-semibold text-orange-200">PANEL ADMIN</div>
                        </div>
                    </a>
                </div>

                <!-- Enhanced Navigation Links -->
                <div class="hidden lg:flex items-center space-x-1">
                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        <span>Dashboard</span>
                    </a>

                    <!-- Products Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }} flex items-center">
                            <i class="fas fa-box-open mr-2"></i>
                            <span>Produits</span>
                            <i class="fas fa-chevron-down ml-2 text-xs" :class="{'rotate-180': open}"></i>
                        </button>
                        <div x-show="open" @click.away="open = false" x-transition class="absolute top-full left-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-100 z-50">
                            <div class="py-2">
                                <a href="{{ route('admin.products.index') }}" class="dropdown-item">
                                    <i class="fas fa-list mr-3"></i>
                                    <span>Tous les produits</span>
                                </a>
                                <a href="{{ route('admin.products.create') }}" class="dropdown-item">
                                    <i class="fas fa-plus-circle mr-3"></i>
                                    <span>Ajouter un produit</span>
                                </a>
                                <div class="border-t border-gray-100 my-2"></div>
                                <a href="{{ route('admin.categories.index') }}" class="dropdown-item">
                                    <i class="fas fa-tags mr-3"></i>
                                    <span>Catégories</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Analytics -->
                    <a href="{{ route('admin.analytics.dashboard') }}" class="nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                        <i class="fas fa-chart-line mr-2"></i>
                        <span>Analytics</span>
                    </a>

                    <!-- Sliders -->
                    <a href="{{ route('admin.sliders.index') }}" class="nav-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                        <i class="fas fa-images mr-2"></i>
                        <span>Sliders</span>
                    </a>
                </div>
            </div>

            <!-- Right Side Enhanced -->
            <div class="hidden lg:flex items-center space-x-4">
                <!-- Quick Actions -->
                <div class="flex items-center space-x-2">
                    <!-- Site View -->
                    <a href="{{ route('home') }}" target="_blank" class="quick-action" title="Voir le site">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    
                    <!-- Notifications -->
                    <button class="quick-action relative" title="Notifications">
                        <i class="fas fa-bell"></i>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- Quick Add Product -->
                    <a href="{{ route('admin.products.create') }}" class="quick-action" title="Ajouter un produit">
                        <i class="fas fa-plus"></i>
                    </a>
                </div>

                <!-- User Dropdown Enhanced -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="flex items-center bg-white bg-opacity-20 hover:bg-opacity-30 rounded-xl px-4 py-2 transition-all group">
                        <div class="w-10 h-10 bg-orange-300 rounded-lg flex items-center justify-center mr-3">
                            <i class="fas fa-user text-orange-800"></i>
                        </div>
                        <div class="text-left text-white">
                            <div class="text-sm font-semibold">{{ Auth::user()->name }}</div>
                            <div class="text-xs text-orange-200">Administrateur</div>
                        </div>
                        <i class="fas fa-chevron-down ml-3 text-white text-xs group-hover:rotate-180 transition-transform"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="absolute right-0 top-full mt-2 w-64 bg-white rounded-xl shadow-2xl border border-gray-100 z-50">
                        <div class="p-4 border-b border-gray-100">
                            <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
                            <div class="text-xs text-green-600 font-semibold mt-1">
                                <i class="fas fa-circle text-green-500 mr-1"></i>En ligne
                            </div>
                        </div>
                        <div class="py-2">
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i class="fas fa-user-cog mr-3"></i>
                                <span>Mon profil</span>
                            </a>
                            <a href="{{ route('admin.analytics.dashboard') }}" class="dropdown-item">
                                <i class="fas fa-chart-bar mr-3"></i>
                                <span>Statistiques</span>
                            </a>
                            <div class="border-t border-gray-100 my-2"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item text-red-600 hover:bg-red-50 w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-3"></i>
                                    <span>Déconnexion</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile menu button enhanced -->
            <div class="lg:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-white hover:bg-white hover:bg-opacity-20 focus:outline-none transition-all">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Enhanced -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden lg:hidden bg-white shadow-xl">
        <div class="px-6 py-4 space-y-3">
            <!-- Mobile User Info -->
            <div class="flex items-center bg-gray-50 rounded-xl p-4">
                <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center mr-4">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <div class="font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-sm text-gray-500">Administrateur</div>
                </div>
            </div>

            <!-- Mobile Navigation Links -->
            <div class="space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3"></i>
                    <span>Dashboard</span>
                </a>
                
                <div class="mobile-section">
                    <div class="mobile-section-title">Gestion des produits</div>
                    <a href="{{ route('admin.products.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                        <i class="fas fa-list mr-3"></i>
                        <span>Tous les produits</span>
                    </a>
                    <a href="{{ route('admin.products.create') }}" class="mobile-nav-item {{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                        <i class="fas fa-plus-circle mr-3"></i>
                        <span>Ajouter un produit</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <i class="fas fa-tags mr-3"></i>
                        <span>Catégories</span>
                    </a>
                </div>

                <a href="{{ route('admin.analytics.dashboard') }}" class="mobile-nav-item {{ request()->routeIs('admin.analytics.*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line mr-3"></i>
                    <span>Analytics</span>
                </a>

                <a href="{{ route('admin.sliders.index') }}" class="mobile-nav-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
                    <i class="fas fa-images mr-3"></i>
                    <span>Sliders</span>
                </a>

                <div class="border-t border-gray-200 my-4"></div>

                <a href="{{ route('home') }}" target="_blank" class="mobile-nav-item">
                    <i class="fas fa-external-link-alt mr-3"></i>
                    <span>Voir le site</span>
                </a>

                <a href="{{ route('profile.edit') }}" class="mobile-nav-item">
                    <i class="fas fa-user-cog mr-3"></i>
                    <span>Mon profil</span>
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-item text-red-600 w-full text-left">
                        <i class="fas fa-sign-out-alt mr-3"></i>
                        <span>Déconnexion</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

<style>
/* Navigation Styles */
.nav-item {
    @apply text-white bg-white bg-opacity-0 hover:bg-opacity-20 px-4 py-2.5 rounded-xl text-sm font-semibold transition-all flex items-center;
}

.nav-item.active {
    @apply bg-white bg-opacity-30 shadow-lg;
}

.quick-action {
    @apply w-10 h-10 bg-white bg-opacity-20 hover:bg-opacity-30 text-white rounded-lg flex items-center justify-center transition-all hover:shadow-lg;
}

.dropdown-item {
    @apply block px-4 py-3 text-sm text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center;
}

.mobile-nav-item {
    @apply block px-4 py-3 rounded-lg text-base font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors flex items-center;
}

.mobile-nav-item.active {
    @apply bg-orange-100 text-orange-700;
}

.mobile-section {
    @apply space-y-1;
}

.mobile-section-title {
    @apply text-xs font-bold text-gray-500 uppercase tracking-wider px-4 py-2;
}
</style>
