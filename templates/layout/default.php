<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?> - Easy Procedures</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?= $this->Html->css(['app']) ?>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="h-full font-sans antialiased text-gray-900" x-data="{ sidebarOpen: false }">
    <div>
        <!-- Off-canvas menu for mobile, show/hide based on off-canvas menu state. -->
        <div x-show="sidebarOpen" class="relative z-50 lg:hidden" role="dialog" aria-modal="true">
            <div x-show="sidebarOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-900/80"></div>

            <div class="fixed inset-0 flex">
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative flex flex-col flex-1 w-full max-w-xs mr-16 bg-white"
                     @click.away="sidebarOpen = false">
                    
                    <div class="absolute top-0 flex justify-center w-16 pt-5 left-full">
                        <button type="button" class="-m-2.5 p-2.5 text-white" @click="sidebarOpen = false">
                            <span class="sr-only">Close sidebar</span>
                            <i class="fa-solid fa-xmark text-xl"></i>
                        </button>
                    </div>

                    <!-- Mobile Sidebar Content -->
                    <div class="flex flex-col px-6 pb-4 overflow-y-auto grow gap-y-5">
                        <div class="flex items-center h-16 shrink-0">
                            <img class="w-auto h-8" src="<?= $this->Url->build('/template/images/icon/logo.png') ?>" alt="Easy Procedures">
                        </div>
                        <nav class="flex flex-col flex-1">
                            <ul role="list" class="flex flex-col flex-1 gap-y-7">
                                <li>
                                    <ul role="list" class="-mx-2 space-y-1">
                                        <?= $this->element('sidebar_menu') ?>
                                    </ul>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Static sidebar for desktop -->
        <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
            <div class="flex flex-col px-6 pb-4 overflow-y-auto bg-white border-r border-gray-200 grow gap-y-5">
                <div class="flex items-center h-16 shrink-0">
                    <img class="w-auto h-8" src="<?= $this->Url->build('/template/images/icon/logo.png') ?>" alt="Easy Procedures">
                </div>
                <nav class="flex flex-col flex-1">
                    <ul role="list" class="flex flex-col flex-1 gap-y-7">
                        <li>
                            <ul role="list" class="-mx-2 space-y-1">
                                <?= $this->element('sidebar_menu') ?>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="lg:pl-72">
            <div class="sticky top-0 z-40 flex items-center h-16 px-4 bg-white border-b border-gray-200 shadow-sm shrink-0 gap-x-4 sm:gap-x-6 sm:px-6 lg:px-8">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden" @click="sidebarOpen = true">
                    <span class="sr-only">Open sidebar</span>
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- Separator -->
                <div class="w-px h-6 bg-gray-200 lg:hidden" aria-hidden="true"></div>

                <div class="flex self-stretch flex-1 gap-x-4 lg:gap-x-6">
                    <div class="relative flex flex-1">
                        <!-- Header Search could go here if needed -->
                    </div>
                    <div class="flex items-center gap-x-4 lg:gap-x-6">
                        <!-- Profile dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button type="button" class="flex items-center p-1.5 -m-1.5" @click="open = !open" @click.away="open = false">
                                <span class="sr-only">Open user menu</span>
                                <img class="w-8 h-8 rounded-full bg-gray-50" src="<?= $this->Url->build('/template/images/icon/avatar-01.png') ?>" alt="">
                                <span class="hidden lg:flex lg:items-center">
                                    <span class="ml-4 text-sm font-semibold leading-6 text-gray-900" aria-hidden="true"><?= $user->name ?></span>
                                    <i class="ml-2 text-gray-400 fa-solid fa-chevron-down text-xs"></i>
                                </span>
                            </button>

                            <div x-show="open"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 z-10 mt-2.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                <a href="<?= $this->Url->build(['controller' => 'Test', 'action' => 'account']) ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Account</a>
                                <a href="<?= $this->Url->build(['controller' => 'Requirements', 'action' => 'index']) ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Settings</a>
                                <div class="h-px my-1 bg-gray-200"></div>
                                <a href="<?= $this->Url->build(['controller' => 'Auth', 'action' => 'logout']) ?>" class="block px-3 py-1 text-sm leading-6 text-gray-900 hover:bg-gray-50">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <main class="py-10">
                <div class="px-4 sm:px-6 lg:px-8">
                    <?= $this->Flash->render() ?>
                    <?= $this->fetch('content') ?>
                </div>
            </main>
        </div>
    </div>

    <?= $this->fetch('script') ?>
</body>
</html>
