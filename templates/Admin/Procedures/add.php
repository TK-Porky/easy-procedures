<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procedure $procedure
 */
$this->assign('title', 'Ajouter une procédure');
?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Procedures</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Nouvelle procédure</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">Créer une procédure</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Ajoutez une nouvelle procédure bancaire au système.</p>
        </div>
        
        <div class="px-4 py-6 sm:p-8">
            <?= $this->Form->create($procedure, ['class' => 'space-y-6']) ?>
                
                <div class="grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6">
                    <div class="sm:col-span-3">
                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Nom de la procédure *</label>
                        <div class="mt-2">
                            <?= $this->Form->control('name', [
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                    </div>

                    <div class="sm:col-span-3">
                        <label for="type" class="block text-sm font-medium leading-6 text-gray-900">Type *</label>
                        <div class="mt-2">
                            <?= $this->Form->control('type', [
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                    </div>

                    <div class="sm:col-span-6">
                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description *</label>
                        <div class="mt-2">
                            <?= $this->Form->control('description', [
                                'type' => 'textarea',
                                'label' => false,
                                'rows' => 4,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-x-4 border-t border-gray-900/10 pt-6 mt-8">
                    <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <i class="fa-solid fa-plus mr-2"></i> Ajouter
                    </button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>