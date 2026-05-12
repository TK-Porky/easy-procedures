<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
$this->assign('title', 'Détails de la demande');
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
                <span class="ml-4 text-sm font-medium text-gray-900">Vue d'ensemble</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8 flex items-center justify-between gap-x-4">
    <div>
        <h1 class="text-2xl font-semibold leading-6 text-gray-900">
            Détails de la demande : <?= h($request->procedure->name) ?>
        </h1>
        <p class="mt-2 text-sm text-gray-700">Consultez l'état de vos pièces justificatives.</p>
    </div>
    <div>
        <?php 
            $statusClasses = [
                'Draft' => 'bg-yellow-50 text-yellow-800 ring-yellow-600/20',
                'pending' => 'bg-blue-50 text-blue-800 ring-blue-600/20',
                'rejected' => 'bg-red-50 text-red-800 ring-red-600/20',
                'success' => 'bg-green-50 text-green-800 ring-green-600/20',
            ];
            $badgeClass = $statusClasses[$request->status] ?? 'bg-gray-50 text-gray-600 ring-gray-500/10';
        ?>
        <span class="inline-flex items-center rounded-md px-3 py-1.5 text-sm font-medium ring-1 ring-inset <?= $badgeClass ?>">
            Statut global : <?= h($request->status) ?>
        </span>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Colonne Principale : Requis -->
    <div class="lg:col-span-2 space-y-6">
        <?php if (!empty($request->requestrequirements)) : ?>
            <?php foreach ($request->requestrequirements as $req) : ?>
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            <?= h($req->procedurerequirement->requirement->name) ?>
                        </h3>
                        <?php 
                            $reqBadgeClass = 'bg-gray-50 text-gray-600 ring-gray-500/10';
                            if ($req->status === 'pending') $reqBadgeClass = 'bg-blue-50 text-blue-700 ring-blue-700/10';
                            if ($req->status === 'rejected') $reqBadgeClass = 'bg-red-50 text-red-700 ring-red-700/10';
                            if ($req->status === 'success') $reqBadgeClass = 'bg-green-50 text-green-700 ring-green-700/10';
                        ?>
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $reqBadgeClass ?>">
                            <?= h($req->status) ?>
                        </span>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <p class="text-sm text-gray-500 mb-4">
                            <?= h($req->procedurerequirement->requirement->description) ?>
                        </p>

                        <?php if ($req->status === 'rejected' && !empty($req->raison)) : ?>
                            <div class="rounded-md bg-red-50 p-4 mb-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <i class="fa-solid fa-circle-xmark text-red-400"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-red-800">Raison du rejet</h3>
                                        <div class="mt-2 text-sm text-red-700">
                                            <p><?= h($req->raison) ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <div class="mt-4 flex justify-end gap-x-3">
                            <?php if ($req->value == null) : ?>
                                <!-- Form data view link if needed -->
                            <?php else : ?>
                                <a href="<?= $this->Url->build('/template/images/' . $req->value, ['_full' => true]) ?>" target="_blank" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                    <i class="fa-solid fa-eye mr-2"></i> Voir le document
                                </a>
                            <?php endif; ?>
                            
                            <?php if (in_array($req->status, ['pending', 'rejected'])) : ?>
                                <a href="<?= $this->Url->build(['action' => 'fill', $req->procedurerequirement_id, $request->id]) ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                                    <i class="fa-solid fa-pen mr-2"></i> Modifier
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="rounded-xl border border-dashed border-gray-300 p-12 text-center">
                <i class="fa-solid fa-folder-open text-4xl text-gray-400 mb-4"></i>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucun pré-requis rempli</h3>
                <p class="mt-1 text-sm text-gray-500">Commencez à remplir les informations requises.</p>
                <div class="mt-6">
                    <a href="<?= $this->Url->build(['action' => 'requirementlist', $request->id]) ?>" class="inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <i class="fa-solid fa-list-check mr-2"></i> Voir la liste des tâches
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Colonne Latérale : Informations -->
    <div class="space-y-6">
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Résumé</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <dl class="space-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Procédure</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= h($request->procedure->name) ?></dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Création</dt>
                        <dd class="mt-1 text-sm text-gray-900"><?= h($request->procedure->created) ?></dd>
                    </div>
                </dl>
            </div>
            <?php if (in_array($request->status, ['Draft', 'rejected'])) : ?>
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <?= $this->Form->postLink(
                        '<i class="fa-solid fa-paper-plane mr-2"></i> Soumettre pour validation',
                        ['action' => 'requestapprobation', $request->id],
                        ['class' => 'flex w-full justify-center rounded-md bg-green-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-green-500', 'escape' => false, 'confirm' => 'Êtes-vous sûr de vouloir soumettre cette demande pour approbation globale ?']
                    ) ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>