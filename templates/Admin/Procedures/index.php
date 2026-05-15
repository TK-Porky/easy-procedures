<?php $this->assign('title', 'Procédures'); ?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Accueil</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-500">Procédures</span>
            </div>
        </li>
    </ol>
</nav>

<div class="sm:flex sm:items-center" x-data="{ openModal: false }">
    <div class="sm:flex-auto">
        <h1 class="text-2xl font-semibold leading-6 text-gray-900"><?= __('Gestion des procédures') ?></h1>
        <p class="mt-2 text-sm text-gray-700">Gérez toutes les procédures bancaires disponibles.</p>
    </div>
    <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
        <button type="button" @click="openModal = true" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <i class="fa-solid fa-plus mr-2"></i> Ajouter
        </button>
    </div>

    <!-- Alpine.js Modal -->
    <template x-teleport="body">
        <div x-show="openModal" class="relative z-50" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
            <div class="fixed inset-0 z-10 overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <div x-show="openModal" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6" @click.away="openModal = false">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left w-full">
                                <h3 class="text-base font-semibold leading-6 text-gray-900" id="modal-title">Ajouter une procédure</h3>
                                <div class="mt-4">
                                    <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
                                        <div class="space-y-4">
                                            <?= $this->Form->control('name', ['label' => 'Nom*']) ?>
                                            <?= $this->Form->control('type', ['label' => 'Type*']) ?>
                                            <?= $this->Form->control('description', ['type' => 'textarea', 'label' => 'Description*']) ?>
                                        </div>
                                        <div class="mt-5 sm:mt-6">
                                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Enregistrer</button>
                                        </div>
                                    <?= $this->Form->end() ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<div class="mt-8 flow-root">
    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"><?= __('Nom') ?></th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= __('Type') ?></th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= __('Image') ?></th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"><?= __('Créé le') ?></th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php foreach ($procedures as $procedure) : ?>
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"><?= h($procedure->name) ?></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= h($procedure->type) ?></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= h($procedure->image) ?></td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?= h($procedure->created) ?></td>
                                <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                    <div class="flex justify-end gap-x-3">
                                        <?= $this->Html->link('<i class="fa-solid fa-eye text-blue-600"></i>', ['action' => 'view', $procedure->id], ['escape' => false, 'title' => 'Voir']) ?>
                                        <?= $this->Html->link('<i class="fa-solid fa-pen-to-square text-indigo-600"></i>', ['action' => 'edit', $procedure->id], ['escape' => false, 'title' => 'Modifier']) ?>
                                        <?= $this->Form->postLink('<i class="fa-solid fa-trash text-red-600"></i>', ['action' => 'delete', $procedure->id], ['confirm' => __('Êtes-vous sûr ?'), 'escape' => false, 'title' => 'Supprimer']) ?>
                                        <?= $this->Html->link('<i class="fa-solid fa-list-ul text-gray-600"></i>', ['controller' => 'Procedurerequirements', 'action' => 'index', $procedure->id], ['escape' => false, 'title' => 'Pré-requis']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
