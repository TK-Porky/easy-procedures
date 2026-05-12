<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 * @var \App\Model\Entity\Procedure $procedure
 */
$this->assign('title', 'Démarrer la procédure');
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
                <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Procedures</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Nouvelle demande</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="px-4 py-6 sm:p-8">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">Démarrer une nouvelle demande</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Vous êtes sur le point de démarrer la procédure : <strong class="text-gray-900"><?= h($procedure->name) ?></strong>.
            </p>
            <p class="mt-1 text-sm leading-6 text-gray-500">
                Une fois démarrée, vous devrez fournir un ensemble de pièces justificatives et remplir les formulaires requis par cette procédure.
            </p>
            
            <div class="mt-8">
                <?= $this->Form->create($request, ['class' => 'space-y-6']) ?>
                    <!-- Hidden fields to avoid baked validation errors, though controller overrides them -->
                    <?= $this->Form->hidden('status', ['value' => 'Draft']) ?>
                    
                    <div class="flex items-center justify-end gap-x-4 border-t border-gray-900/10 pt-6 mt-8">
                        <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'details', $procedure->id]) ?>" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                            Annuler
                        </a>
                        <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Confirmer et Démarrer <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
