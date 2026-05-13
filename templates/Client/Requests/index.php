<?php $this->assign('title', 'My Procedures'); ?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-500">My Procedures</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8">
    <h1 class="text-2xl font-semibold leading-6 text-gray-900"><?= __('Procedures in progress') ?></h1>
    <p class="mt-2 text-sm text-gray-700">Track and manage your ongoing bank procedures.</p>
</div>

<div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
    <?php foreach ($requests as $request) : ?>
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition-shadow hover:shadow-md">
            <div class="aspect-video w-full overflow-hidden bg-gray-100">
                <img src="<?= $this->Path->template_path() ?>images/<?= h($request->procedure->image ?? 'procedure_default.jpg') ?>" alt="<?= h($request->procedure->name) ?>" class="h-full w-full object-cover">
            </div>
            <div class="p-6">
                <div class="flex items-center justify-between gap-x-4">
                    <h3 class="text-lg font-semibold leading-6 text-gray-900"><?= h($request->procedure->name) ?></h3>
                    <?php 
                        $statusClasses = [
                            'Draft' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                            'pending' => 'bg-blue-50 text-blue-800 ring-blue-600/20',
                            'rejected' => 'bg-red-50 text-red-800 ring-red-600/20',
                            'success' => 'bg-green-50 text-green-800 ring-green-600/20',
                        ];
                        $badgeClass = $statusClasses[$request->status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
                    ?>
                    <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $badgeClass ?>">
                        <?= h($request->status) ?>
                    </span>
                </div>
                <p class="mt-2 text-sm text-gray-500">Created: <?= h($request->procedure->created) ?></p>
                
                <div class="mt-6 flex flex-wrap gap-2">
                    <?php if (in_array($request->status, ['Draft', 'pending', 'rejected'])) : ?>
                        <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'requirementlist', $request->id]); ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500">
                            <i class="fa-solid fa-pen-to-square mr-1.5"></i> Edit
                        </a>
                        <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'firstview', $request->id]); ?>" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-xs font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            <i class="fa-solid fa-eye mr-1.5"></i> View
                        </a>
                        <?= $this->Form->postLink(
                            '<i class="fa-solid fa-trash mr-1.5"></i> Cancel', 
                            ['action' => 'delete', $request->id], 
                            ['confirm' => __('Are you sure you want to cancel this request?'), 'class' => 'inline-flex items-center rounded-md bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100', 'escape' => false]
                        ) ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
