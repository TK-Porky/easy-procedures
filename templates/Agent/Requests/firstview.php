<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
$this->assign('title', 'Traitement de la demande');
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
                <span class="ml-4 text-sm font-medium text-gray-900">Traitement</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold leading-6 text-gray-900">
            Détails de la demande : <?= h($request->procedure->name) ?>
        </h1>
        <p class="mt-2 text-sm text-gray-700">Vérifiez les pièces justificatives et validez la demande.</p>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Colonne Latérale : Informations de l'utilisateur -->
    <div class="space-y-6 order-last lg:order-first">
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Informations du demandeur</h3>
            </div>
            <div class="px-4 py-5 sm:p-6 text-center">
                <div class="mx-auto flex h-24 w-24 items-center justify-center rounded-full bg-indigo-100 mb-4">
                    <i class="fa-solid fa-user text-3xl text-indigo-600"></i>
                </div>
                <h4 class="text-lg font-medium text-gray-900"><?= h($request->user->name) ?> <?= h($request->user->surname) ?></h4>
                
                <div class="mt-4 space-y-3">
                    <div class="flex items-center justify-center text-sm text-gray-500">
                        <i class="fa-solid fa-envelope w-5 text-gray-400"></i>
                        <span class="ml-2 truncate"><?= h($request->user->email) ?></span>
                    </div>
                    <div class="flex items-center justify-center text-sm text-gray-500">
                        <i class="fa-solid fa-phone w-5 text-gray-400"></i>
                        <span class="ml-2"><?= h($request->user->phonenumber) ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Globales de la demande -->
        <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Actions</h3>
            </div>
            <div class="px-4 py-5 sm:p-6 space-y-4">
                <?php if ($request->status === 'Draft') : ?>
                    <p class="text-sm text-gray-500">Une fois toutes les pièces validées, soumettez la demande pour approbation finale par l'administration.</p>
                    <?= $this->Form->postLink(
                        '<i class="fa-solid fa-paper-plane mr-2"></i> Soumettre pour approbation',
                        ['action' => 'requestapprobation', $request->id],
                        ['class' => 'flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500', 'escape' => false, 'confirm' => 'Soumettre cette demande pour approbation finale ?']
                    ) ?>
                <?php elseif ($request->status === 'pending') : ?>
                    <div class="rounded-md bg-blue-50 p-4">
                        <div class="flex">
                            <i class="fa-solid fa-clock text-blue-400 mt-0.5"></i>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-blue-800">En attente de validation admin</p>
                                <p class="mt-1 text-xs text-blue-700">Cette demande a été soumise et attend la décision finale de l'administration.</p>
                            </div>
                        </div>
                    </div>
                    <?= $this->Form->postLink(
                        '<i class="fa-solid fa-rotate-left mr-2"></i> Annuler la soumission',
                        ['action' => 'cancelapprobation', $request->id],
                        ['class' => 'flex w-full justify-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 mt-3', 'escape' => false, 'confirm' => 'Annuler la soumission de cette demande ?']
                    ) ?>
                <?php elseif ($request->status === 'success') : ?>
                    <div class="rounded-md bg-green-50 p-4">
                        <div class="flex">
                            <i class="fa-solid fa-circle-check text-green-400 mt-0.5"></i>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">Demande approuvée</p>
                                <p class="mt-1 text-xs text-green-700">Cette demande a été approuvée par l'administration.</p>
                            </div>
                        </div>
                    </div>
                <?php elseif ($request->status === 'rejected') : ?>
                    <div class="rounded-md bg-red-50 p-4">
                        <div class="flex">
                            <i class="fa-solid fa-circle-xmark text-red-400 mt-0.5"></i>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">Demande rejetée</p>
                                <p class="mt-1 text-xs text-red-700">Cette demande a été rejetée par l'administration.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Colonne Principale : Requis -->
    <div class="lg:col-span-2 space-y-6">
        <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Pièces fournies</h3>
        
        <?php if (!empty($request->requestrequirements)) : ?>
            <?php foreach ($request->requestrequirements as $req) : ?>
                <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
                    <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6 flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4">
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
                        <p class="text-sm text-gray-500 mb-6">
                            <?= h($req->procedurerequirement->requirement->description) ?>
                        </p>

                        <?php if ($req->status === 'rejected' && !empty($req->raison)) : ?>
                            <div class="rounded-md bg-red-50 p-4 mb-6">
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

                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mt-4 pt-4 border-t border-gray-100">
                            <div>
                                <?php if ($req->value == null) : ?>
                                    <span class="text-sm text-gray-500 italic">Aucun document joint.</span>
                                <?php else : ?>
                                    <a href="<?= $this->Url->build('/template/images/' . $req->value, ['_full' => true]) ?>" target="_blank" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                                        <i class="fa-solid fa-eye mr-2 text-indigo-600"></i> Consulter la pièce jointe
                                    </a>
                                <?php endif; ?>
                            </div>
                            
                            <div class="flex gap-2">
                                <?= $this->Form->postLink(
                                    '<i class="fa-solid fa-check"></i> Valider',
                                    ['action' => 'approuverequirement', $req->id],
                                    ['escape' => false, 'confirm' => 'Confirmer la validation de cette pièce ?', 'class' => 'inline-flex items-center rounded-md bg-green-50 px-3 py-2 text-sm font-semibold text-green-700 shadow-sm ring-1 ring-inset ring-green-600/20 hover:bg-green-100']
                                ) ?>
                                
                                <?= $this->Form->postLink(
                                    '<i class="fa-solid fa-xmark"></i> Rejeter',
                                    ['action' => 'rejectrequirement', $req->id],
                                    ['escape' => false, 'confirm' => 'Confirmer le rejet de cette pièce ?', 'class' => 'inline-flex items-center rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 shadow-sm ring-1 ring-inset ring-red-600/20 hover:bg-red-100']
                                ) ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="rounded-xl border border-dashed border-gray-300 p-12 text-center bg-gray-50">
                <i class="fa-solid fa-folder-open text-4xl text-gray-400 mb-4"></i>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">Aucune pièce fournie</h3>
                <p class="mt-1 text-sm text-gray-500">Le demandeur n'a encore soumis aucune information.</p>
            </div>
        <?php endif; ?>
    </div>
</div>