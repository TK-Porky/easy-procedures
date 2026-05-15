<!DOCTYPE html>
<html lang="fr" class="h-full bg-gray-50">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?> — Easy Procedures</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?= $this->Html->css(['app']) ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="h-full font-sans antialiased text-gray-900" x-data="{ sidebarOpen: false }">

<?php
    $roleId = isset($user) ? (int)$user->id_role : 1;
    $roleName  = match($roleId) { 3 => 'Administrateur', 2 => 'Agent', default => 'Client' };
    $roleColor = match($roleId) { 3 => 'red', 2 => 'amber', default => 'indigo' };
    $roleIcon  = match($roleId) { 3 => 'fa-shield-halved', 2 => 'fa-user-tie', default => 'fa-user' };
    $currentPrefix = match($roleId) { 3 => 'Admin', 2 => 'Agent', default => 'Client' };
?>

<div class="min-h-full">

    <!-- ── Mobile overlay ────────────────────────────────────── -->
    <div x-show="sidebarOpen" x-cloak class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
        <div x-show="sidebarOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm"></div>

        <div class="fixed inset-0 flex">
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-in-out duration-300 transform"
                 x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in-out duration-300 transform"
                 x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
                 class="relative flex flex-col flex-1 w-full max-w-xs mr-16 bg-white shadow-2xl"
                 @click.away="sidebarOpen = false">

                <div class="absolute top-0 left-full flex justify-center w-16 pt-5">
                    <button type="button" class="-m-2.5 p-2.5 text-white/80 hover:text-white" @click="sidebarOpen = false">
                        <span class="sr-only">Fermer</span>
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Mobile sidebar content -->
                <?= $this->element('sidebar_content') ?>
            </div>
        </div>
    </div>

    <!-- ── Desktop sidebar ───────────────────────────────────── -->
    <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-64 xl:w-72 lg:flex-col">
        <div class="flex flex-col h-full bg-white border-r border-gray-200 shadow-sm">
            <?= $this->element('sidebar_content') ?>
        </div>
    </div>

    <!-- ── Main area ─────────────────────────────────────────── -->
    <div class="lg:pl-64 xl:pl-72 flex flex-col min-h-screen">

        <!-- Top header -->
        <header class="sticky top-0 z-40 flex items-center h-16 px-4 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm shrink-0 gap-x-4 sm:gap-x-6 sm:px-6 lg:px-8">

            <!-- Mobile burger -->
            <button type="button" class="-m-2.5 p-2.5 text-gray-500 hover:text-gray-700 lg:hidden" @click="sidebarOpen = true">
                <span class="sr-only">Ouvrir le menu</span>
                <i class="fa-solid fa-bars text-lg"></i>
            </button>

            <div class="hidden lg:block w-px h-6 bg-gray-200" aria-hidden="true"></div>

            <div class="flex flex-1 items-center justify-between gap-x-4">
                <!-- Page context label -->
                <div class="flex items-center gap-2 min-w-0">
                    <span class="text-sm text-gray-400 hidden sm:inline">Easy Procedures</span>
                    <i class="fa-solid fa-chevron-right text-gray-300 text-xs hidden sm:inline"></i>
                    <span class="text-sm font-medium text-gray-700 truncate"><?= h($this->fetch('title') ?: 'Dashboard') ?></span>
                </div>

                <!-- Right controls -->
                <div class="flex items-center gap-x-3">

                    <!-- Role badge -->
                    <span class="hidden sm:inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                        <?= $roleColor === 'red' ? 'bg-red-50 text-red-700 ring-1 ring-red-200' : ($roleColor === 'amber' ? 'bg-amber-50 text-amber-700 ring-1 ring-amber-200' : 'bg-indigo-50 text-indigo-700 ring-1 ring-indigo-200') ?>">
                        <i class="fa-solid <?= $roleIcon ?> text-xs"></i>
                        <?= $roleName ?>
                    </span>

                    <!-- Separator -->
                    <div class="h-5 w-px bg-gray-200 hidden sm:block"></div>

                    <!-- User dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button type="button"
                                class="flex items-center gap-2.5 rounded-full pl-1 pr-3 py-1 hover:bg-gray-100 transition-colors -mr-1"
                                @click="open = !open" @click.away="open = false">
                            <img class="w-8 h-8 rounded-full ring-2 ring-gray-200 object-cover"
                                 src="<?= $this->Url->build('/template/images/icon/avatar-01.png') ?>" alt="">
                            <span class="hidden lg:block text-sm font-semibold text-gray-800">
                                <?= isset($user) ? h($user->name) : 'Invité' ?>
                            </span>
                            <i class="fa-solid fa-chevron-down text-gray-400 text-xs transition-transform duration-200" :class="open && 'rotate-180'"></i>
                        </button>

                        <div x-show="open" x-cloak
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-52 origin-top-right rounded-xl bg-white shadow-lg ring-1 ring-gray-200 divide-y divide-gray-100 focus:outline-none z-50">

                            <div class="px-4 py-3">
                                <p class="text-xs text-gray-500">Connecté en tant que</p>
                                <p class="text-sm font-semibold text-gray-900 truncate"><?= isset($user) ? h($user->email) : '' ?></p>
                            </div>

                            <div class="py-1">
                                <a href="<?= $this->Url->build(['prefix' => $currentPrefix, 'controller' => 'Dashboard', 'action' => 'index']) ?>"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 transition-colors">
                                    <i class="fa-solid fa-gauge-high w-4 text-gray-400"></i>
                                    Tableau de bord
                                </a>
                            </div>

                            <div class="py-1">
                                <a href="<?= $this->Url->build(['prefix' => $currentPrefix, 'controller' => 'Auth', 'action' => 'logout']) ?>"
                                   class="flex items-center gap-2.5 px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                    <i class="fa-solid fa-arrow-right-from-bracket w-4"></i>
                                    Déconnexion
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Page content -->
        <main class="flex-1 py-8">
            <div class="px-4 sm:px-6 lg:px-8 max-w-7xl">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </main>

        <!-- Footer -->
        <footer class="px-8 py-4 border-t border-gray-100 bg-white">
            <p class="text-xs text-gray-400 text-center">© 2026 Easy Procedures · Tous droits réservés</p>
        </footer>
    </div>
</div>

<?= $this->fetch('script') ?>
</body>
</html>
