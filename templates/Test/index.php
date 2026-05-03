<?php $this->assign('title', 'Dashboard'); ?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Test', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-500">Dashboard</span>
            </div>
        </li>
    </ol>
</nav>

<?php if ($user->id_role == 2 || $user->id_role == 3) : ?>
    <div class="max-w-7xl mx-auto">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Administrator Dashboard</h1>
        
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-3">
            <!-- Pending Procedures Card -->
            <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-indigo-500 p-3">
                        <i class="fa-solid fa-calendar-check text-white text-xl"></i>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Pending Procedures</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">??</p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'pending']) ?>" class="font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
                </dd>
            </div>

            <!-- Total Users Card (Placeholder) -->
            <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-green-500 p-3">
                        <i class="fa-solid fa-users text-white text-xl"></i>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Total Users</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">??</p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
                </dd>
            </div>

            <!-- Active Procedures Card (Placeholder) -->
            <div class="relative overflow-hidden rounded-lg bg-white px-4 pb-12 pt-5 shadow sm:px-6 sm:pt-6">
                <dt>
                    <div class="absolute rounded-md bg-orange-500 p-3">
                        <i class="fa-solid fa-diagram-project text-white text-xl"></i>
                    </div>
                    <p class="ml-16 truncate text-sm font-medium text-gray-500">Procedures</p>
                </dt>
                <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                    <p class="text-2xl font-semibold text-gray-900">??</p>
                    <div class="absolute inset-x-0 bottom-0 bg-gray-50 px-4 py-4 sm:px-6">
                        <div class="text-sm">
                            <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="font-medium text-indigo-600 hover:text-indigo-500">View all</a>
                        </div>
                    </div>
                </dd>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($user->id_role == 1) : ?>
    <div class="max-w-7xl mx-auto">
        <div class="md:flex md:items-center md:justify-between mb-8">
            <div class="min-w-0 flex-1">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                    Welcome back, <?= h($user->name) ?>!
                </h2>
                <p class="mt-1 text-sm text-gray-500">Track your bank procedure requests and manage your applications.</p>
            </div>
            <div class="mt-4 flex md:ml-4 md:mt-0">
                <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <i class="fa-solid fa-plus mr-2"></i> New Procedure
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3 mb-10">
            <!-- Total Requests -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                <dt class="truncate text-sm font-medium text-gray-500 flex items-center">
                    <div class="bg-blue-50 p-2 rounded-md mr-3 text-blue-600">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    Total Requests
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $totalRequests ?></dd>
            </div>

            <!-- Pending -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                <dt class="truncate text-sm font-medium text-gray-500 flex items-center">
                    <div class="bg-yellow-50 p-2 rounded-md mr-3 text-yellow-600">
                        <i class="fa-solid fa-clock"></i>
                    </div>
                    Pending
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $pendingRequests ?></dd>
            </div>

            <!-- Approved -->
            <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6 ring-1 ring-gray-900/5">
                <dt class="truncate text-sm font-medium text-gray-500 flex items-center">
                    <div class="bg-green-50 p-2 rounded-md mr-3 text-green-600">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                    Approved
                </dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $approvedRequests ?></dd>
            </div>
        </div>

        <!-- Recent Requests Section -->
        <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="px-4 py-6 sm:px-6 flex justify-between items-center border-b border-gray-100">
                <h3 class="text-base font-semibold leading-7 text-gray-900">Recent Requests</h3>
                <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'index']) ?>" class="text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                    View all
                </a>
            </div>
            <div class="flow-root">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Procedure</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Last Updated</th>
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">View</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <?php foreach ($recentRequests as $request) : ?>
                                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-gray-900"><?= h($request->procedure->name) ?></div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            <?php if ($request->status === 'success') : ?>
                                                <span class="inline-flex items-center rounded-full bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                                                    Approved
                                                </span>
                                            <?php elseif ($request->status === 'pending') : ?>
                                                <span class="inline-flex items-center rounded-full bg-yellow-50 px-2 py-1 text-xs font-medium text-yellow-800 ring-1 ring-inset ring-yellow-600/20">
                                                    Pending
                                                </span>
                                            <?php else : ?>
                                                <span class="inline-flex items-center rounded-full bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10">
                                                    <?= h(ucfirst($request->status)) ?>
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-500">
                                            <?= $request->modified->format('M d, Y') ?>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'requirementlist', $request->id]) ?>" class="text-indigo-600 hover:text-indigo-900 flex items-center justify-end">
                                                Manage <i class="fa-solid fa-chevron-right ml-2 text-xs"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php if ($recentRequests->isEmpty()) : ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-10 text-center text-sm text-gray-500">
                                            You haven't started any procedures yet.
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
