<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 */
$this->assign('title', 'Liste des requis');
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
                <span class="ml-4 text-sm font-medium text-gray-900">Liste des requis</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold leading-6 text-gray-900">
            Requis de la demande : <?= h($request->procedure->name) ?>
        </h1>
        <p class="mt-2 text-sm text-gray-700">Vérifiez l'état de chaque requis pour cette demande.</p>
    </div>
    <div class="flex gap-3">
        <?php if ($request->status === 'Draft') : ?>
            <?= $this->Form->postLink(
                '<i class="fa-solid fa-paper-plane mr-2"></i> Soumettre pour approbation',
                ['action' => 'requestapprobation', $request->id],
                ['escape' => false, 'confirm' => 'Soumettre cette demande pour approbation ?', 'class' => 'inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500']
            ) ?>
        <?php elseif ($request->status === 'pending') : ?>
            <?= $this->Form->postLink(
                '<i class="fa-solid fa-rotate-left mr-2"></i> Annuler l\'approbation',
                ['action' => 'cancelapprobation', $request->id],
                ['escape' => false, 'confirm' => 'Annuler l\'approbation de cette demande ?', 'class' => 'inline-flex items-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500']
            ) ?>
        <?php endif; ?>
        <a href="<?= $this->Url->build(['action' => 'firstview', $request->id]) ?>" class="inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
            <i class="fa-solid fa-eye mr-2 text-indigo-600"></i> Voir les pièces
        </a>
    </div>
</div>

<!-- Statut global de la demande -->
<div class="mb-6 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
    <div class="border-b border-gray-200 bg-gray-50 px-4 py-4 sm:px-6 flex items-center justify-between">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Statut de la demande</h3>
        <?php
            $badgeClass = 'bg-gray-50 text-gray-600 ring-gray-500/10';
            if ($request->status === 'pending') $badgeClass = 'bg-blue-50 text-blue-700 ring-blue-700/10';
            if ($request->status === 'rejected') $badgeClass = 'bg-red-50 text-red-700 ring-red-700/10';
            if ($request->status === 'success') $badgeClass = 'bg-green-50 text-green-700 ring-green-700/10';
            if ($request->status === 'Draft') $badgeClass = 'bg-yellow-50 text-yellow-700 ring-yellow-700/10';
        ?>
        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $badgeClass ?>">
            <?= h($request->status) ?>
        </span>
    </div>
</div>

<!-- Tableau des requis -->
<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Requis</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">Actions</span>
                </th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php foreach ($procedurerequirements as $procedurerequirement) : ?>
                <?php
                    // Trouver le requestrequirement correspondant
                    $matchingReqReq = null;
                    foreach ($request->requestrequirements as $rr) {
                        if ($rr->procedurerequirement_id === $procedurerequirement->id) {
                            $matchingReqReq = $rr;
                            break;
                        }
                    }
                    $status = $matchingReqReq ? $matchingReqReq->status : 'non soumis';
                    $reqBadgeClass = 'bg-gray-50 text-gray-600 ring-gray-500/10';
                    if ($status === 'pending') $reqBadgeClass = 'bg-blue-50 text-blue-700 ring-blue-700/10';
                    if ($status === 'rejected') $reqBadgeClass = 'bg-red-50 text-red-700 ring-red-700/10';
                    if ($status === 'success') $reqBadgeClass = 'bg-green-50 text-green-700 ring-green-700/10';
                ?>
                <tr>
                    <td class="py-4 pl-4 pr-3 text-sm sm:pl-6">
                        <div class="font-medium text-gray-900"><?= h($procedurerequirement->requirement->name) ?></div>
                        <div class="text-xs text-gray-500 mt-1"><?= h($procedurerequirement->requirement->description) ?></div>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            <?= h($procedurerequirement->requirement->requirementtype->name ?? '-') ?>
                        </span>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        <span class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset <?= $reqBadgeClass ?>">
                            <?= h($status) ?>
                        </span>
                    </td>
                    <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                        <?php if ($matchingReqReq) : ?>
                            <a href="<?= $this->Url->build(['action' => 'firstview', $request->id]) ?>#req-<?= $matchingReqReq->id ?>" class="text-indigo-600 hover:text-indigo-900">
                                <i class="fa-solid fa-eye"></i> Voir
                            </a>
                        <?php else : ?>
                            <span class="text-gray-400 text-xs italic">Non soumis</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($procedurerequirements) || count($procedurerequirements) === 0) : ?>
                <tr>
                    <td colspan="4" class="py-10 text-center text-sm text-gray-500 italic">Aucun requis défini pour cette procédure.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
