<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\RequestRequirement $requestrequirement
 */
$this->assign('title', 'Raison du rejet');
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
                <a href="<?= $this->Url->build(['action' => 'pending']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Demandes en attente</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['action' => 'firstview', $requestrequirement->request_id]) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Traitement</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Raison du rejet</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-2xl mx-auto mt-8">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">Motif de rejet de la pièce</h2>
            <p class="mt-2 text-sm leading-6 text-gray-500">
                Veuillez expliquer au demandeur pourquoi cette pièce justificative a été rejetée afin qu'il puisse la corriger.
            </p>
        </div>
        <div class="px-4 py-6 sm:p-8">
            <?= $this->Form->create(null, ['class' => 'space-y-6']) ?>
                <div>
                    <label for="raison" class="block text-sm font-medium leading-6 text-gray-900">Raison détaillée du rejet *</label>
                    <div class="mt-2">
                        <?= $this->Form->control('raison', [
                            'type' => 'textarea',
                            'label' => false,
                            'required' => true,
                            'rows' => 4,
                            'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6',
                            'placeholder' => 'Ex: Le document fourni est illisible ou ne correspond pas au pré-requis demandé...'
                        ]) ?>
                    </div>
                </div>
                
                <div class="flex items-center justify-end gap-x-4 border-t border-gray-900/10 pt-6 mt-8">
                    <a href="<?= $this->Url->build(['action' => 'firstview', $requestrequirement->request_id]) ?>" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-red-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-red-600">
                        <i class="fa-solid fa-paper-plane mr-2"></i> Envoyer le motif
                    </button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>