<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procedure $procedure
 */
$this->assign('title', 'Détails de la procédure');
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
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Procédures</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900"><?= h($procedure->name) ?></span>
            </div>
        </li>
    </ol>
</nav>

<div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
    <div class="px-4 py-6 sm:px-6 flex flex-col sm:flex-row justify-between sm:items-center gap-4 border-b border-gray-200">
        <div>
            <h3 class="text-base font-semibold leading-7 text-gray-900">Détails de la procédure</h3>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-500">Informations détaillées et actions administratives.</p>
        </div>
        <div class="flex gap-3">
            <a href="<?= $this->Url->build(['action' => 'edit', $procedure->id]) ?>" class="inline-flex justify-center items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                <i class="fa-solid fa-pen-to-square mr-2 text-indigo-600"></i> Modifier
            </a>
            <?= $this->Form->postLink(
                '<i class="fa-solid fa-trash mr-2"></i> Supprimer',
                ['action' => 'delete', $procedure->id],
                ['confirm' => __('Êtes-vous sûr de vouloir supprimer # {0} ?', $procedure->id), 'class' => 'inline-flex justify-center items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500', 'escape' => false]
            ) ?>
        </div>
    </div>
    <div class="border-t border-gray-100">
        <dl class="divide-y divide-gray-100">
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900">Nom</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= h($procedure->name) ?></dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900">Type</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0">
                    <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                        <?= h($procedure->type) ?>
                    </span>
                </dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900">Description</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 whitespace-pre-line"><?= h($procedure->description) ?></dd>
            </div>
            <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-900">Créé le</dt>
                <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"><?= h($procedure->created) ?></dd>
            </div>
        </dl>
    </div>
</div>