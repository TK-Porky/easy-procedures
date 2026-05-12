<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procedure $procedure
 * @var \App\View\Helper\RequestsHelper $Requests
 */
$this->assign('title', 'Pré-requis de la demande');
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
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">My Procedures</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Pré-requis</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold leading-6 text-gray-900">
            Tâches requises : <?= h($request->procedure->name) ?>
        </h1>
        <p class="mt-2 text-sm text-gray-700">Veuillez remplir l'ensemble des pré-requis pour soumettre votre demande.</p>
    </div>
    
    <div class="flex gap-3">
        <?php if ($request->status === 'Draft' || $request->status === 'rejected') : ?>
            <?= $this->Form->postLink(
                '<i class="fa-solid fa-paper-plane mr-2"></i> Soumettre la demande',
                ['action' => 'requestapprobation', $request->id],
                ['escape' => false, 'confirm' => __('Êtes-vous sûr de vouloir soumettre la demande pour validation ?'), 'class' => 'inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500']
            ) ?>
        <?php elseif ($request->status === 'pending') : ?>
            <?= $this->Form->postLink(
                '<i class="fa-solid fa-xmark mr-2"></i> Annuler la soumission',
                ['action' => 'cancelapprobation', $request->id],
                ['escape' => false, 'confirm' => __('Êtes-vous sûr de vouloir annuler la demande en cours ?'), 'class' => 'inline-flex items-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500']
            ) ?>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
    <?php foreach ($procedurerequirements as $procedurerequirement) : ?>
        <div class="flex flex-col overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900 line-clamp-1" title="<?= h($procedurerequirement->requirement->name) ?>">
                    <?= h($procedurerequirement->requirement->name) ?>
                </h3>
            </div>
            <div class="flex-1 px-4 py-5 sm:p-6">
                <p class="text-sm text-gray-500 line-clamp-3">
                    <?= h($procedurerequirement->requirement->description) ?>
                </p>
            </div>
            
            <?php
            $requestRequirement = $this->Requests->getRequestRequirement(
                $procedurerequirement->id,
                $request->requestrequirements
            );
            ?>
            <div class="border-t border-gray-100 px-4 py-4 sm:px-6 bg-gray-50 flex items-center justify-between">
                <?php if (is_null($requestRequirement)) : ?>
                    <span class="inline-flex items-center rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                        Non rempli
                    </span>
                    <a href="<?= $this->Url->build(['action' => 'fill', $procedurerequirement->id, $request->id]); ?>" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                        <i class="fa-solid fa-pen-to-square mr-1.5 text-gray-400"></i> Compléter
                    </a>
                <?php else : ?>
                    <?php if ($requestRequirement->status == 'pending') : ?>
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            En attente
                        </span>
                        <a href="<?= $this->Url->build(['action' => 'fill', $procedurerequirement->id, $request->id]); ?>" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            <i class="fa-solid fa-pen-to-square mr-1.5 text-gray-400"></i> Modifier
                        </a>
                    <?php elseif ($requestRequirement->status == 'rejected') : ?>
                        <div class="flex flex-col gap-2">
                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 self-start">
                                Rejeté
                            </span>
                            <span class="text-xs text-red-600 line-clamp-1" title="<?= h($requestRequirement->raison) ?>">
                                Raison : <?= h($requestRequirement->raison) ?>
                            </span>
                        </div>
                        <a href="<?= $this->Url->build(['action' => 'fill', $procedurerequirement->id, $request->id]); ?>" class="inline-flex items-center rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 shrink-0">
                            <i class="fa-solid fa-pen-to-square mr-1.5 text-gray-400"></i> Corriger
                        </a>
                    <?php elseif ($requestRequirement->status == 'success') : ?>
                        <span class="inline-flex items-center rounded-md bg-green-50 px-2 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20">
                            Validé
                        </span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
