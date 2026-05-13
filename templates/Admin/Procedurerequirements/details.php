<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Procedure $procedure
 * @var \Cake\ORM\ResultSet $procedurerequirements
 */
$this->assign('title', 'Détail des requis de la procédure');
?>

<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Dashboard', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Procedures', 'action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Procédures</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Requis : <?= h($procedure->name) ?></span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
    <div>
        <h1 class="text-2xl font-semibold leading-6 text-gray-900">
            Requis de la procédure : <?= h($procedure->name) ?>
        </h1>
        <p class="mt-2 text-sm text-gray-700">Liste des documents et formulaires requis pour cette procédure.</p>
    </div>
    <div class="flex gap-3">
        <?= $this->Html->link(
            '<i class="fa-solid fa-pen-to-square mr-2"></i> Gérer les requis',
            ['action' => 'index', $procedure->id],
            ['escape' => false, 'class' => 'inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500']
        ) ?>
        <?= $this->Html->link(
            '<i class="fa-solid fa-arrow-left mr-2"></i> Retour aux procédures',
            ['prefix' => 'Admin', 'controller' => 'Procedures', 'action' => 'index'],
            ['escape' => false, 'class' => 'inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50']
        ) ?>
    </div>
</div>

<!-- Résumé de la procédure -->
<div class="mb-6 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-900/5">
    <div class="border-b border-gray-200 bg-gray-50 px-4 py-4 sm:px-6">
        <h3 class="text-base font-semibold leading-6 text-gray-900">Informations de la procédure</h3>
    </div>
    <dl class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-gray-100">
        <div class="px-4 py-4 sm:px-6">
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nom</dt>
            <dd class="mt-1 text-sm font-semibold text-gray-900"><?= h($procedure->name) ?></dd>
        </div>
        <div class="px-4 py-4 sm:px-6">
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Type</dt>
            <dd class="mt-1 text-sm text-gray-900"><?= h($procedure->type) ?></dd>
        </div>
        <div class="px-4 py-4 sm:px-6">
            <dt class="text-xs font-medium text-gray-500 uppercase tracking-wide">Nombre de requis</dt>
            <dd class="mt-1">
                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-sm font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                    <?= count($procedurerequirements) ?> requis
                </span>
            </dd>
        </div>
    </dl>
</div>

<!-- Liste des requis -->
<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Nom du requis</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Type</th>
                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
            <?php $i = 1; foreach ($procedurerequirements as $pr) : ?>
                <tr>
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-500 sm:pl-6"><?= $i++ ?></td>
                    <td class="py-4 px-3 text-sm">
                        <div class="font-medium text-gray-900"><?= h($pr->requirement->name) ?></div>
                        <?php if ($pr->requirement->example) : ?>
                            <div class="text-xs text-gray-400 italic mt-1">Ex: <?= h($pr->requirement->example) ?></div>
                        <?php endif; ?>
                    </td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm">
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            <?= h($pr->requirement->requirementtype->name ?? '-') ?>
                        </span>
                    </td>
                    <td class="px-3 py-4 text-sm text-gray-500 max-w-xs">
                        <?= h($pr->requirement->description) ?>
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
