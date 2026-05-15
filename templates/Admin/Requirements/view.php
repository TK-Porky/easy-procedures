<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirement $requirement
 */
$this->assign('title', 'Détails du pré-requis');
?>

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
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Requirements', 'action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Pré-requis</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900"><?= h($requirement->name) ?></span>
            </div>
        </li>
    </ol>
</nav>

<div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl font-semibold leading-6 text-gray-900"><?= h($requirement->name) ?></h1>
    <div class="flex gap-3">
        <?= $this->Html->link(
            '<i class="fa-solid fa-pen-to-square mr-2"></i> Modifier',
            ['action' => 'edit', $requirement->id],
            ['escape' => false, 'class' => 'inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500']
        ) ?>
        <?php if ($requirement->requirementtype->name === 'formulaire') : ?>
            <?= $this->Html->link(
                '<i class="fa-solid fa-list-ul mr-2"></i> Gérer les champs',
                ['controller' => 'Requirementproprieties', 'action' => 'index', $requirement->id],
                ['escape' => false, 'class' => 'inline-flex items-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50']
            ) ?>
        <?php endif; ?>
    </div>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    <!-- Informations principales -->
    <div class="lg:col-span-2 space-y-6">
        <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Informations générales</h3>
            </div>
            <dl class="divide-y divide-gray-100">
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nom</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= h($requirement->name) ?></dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Description</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= h($requirement->description) ?></dd>
                </div>
                <?php if ($requirement->example) : ?>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Exemple</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0 italic text-gray-600"><?= h($requirement->example) ?></dd>
                </div>
                <?php endif; ?>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                    <dd class="mt-1 sm:col-span-2 sm:mt-0">
                        <span class="inline-flex items-center rounded-md bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600 ring-1 ring-inset ring-gray-500/10">
                            <?= h($requirement->requirementtype->name) ?>
                        </span>
                    </dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Créé le</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= h($requirement->created->format('d/m/Y H:i')) ?></dd>
                </div>
                <div class="px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Modifié le</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0"><?= h($requirement->modified->format('d/m/Y H:i')) ?></dd>
                </div>
            </dl>
        </div>

        <!-- Champs du formulaire (si type formulaire) -->
        <?php if (!empty($requirement->requirementproprieties)) : ?>
        <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6 flex items-center justify-between">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Champs du formulaire</h3>
                <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-700/10">
                    <?= count($requirement->requirementproprieties) ?> champ(s)
                </span>
            </div>
            <ul role="list" class="divide-y divide-gray-100">
                <?php foreach ($requirement->requirementproprieties as $prop) : ?>
                    <li class="flex items-center justify-between gap-x-6 px-4 py-4 sm:px-6">
                        <div>
                            <p class="text-sm font-semibold text-gray-900"><?= h($prop->label) ?></p>
                            <p class="text-xs text-gray-500 italic"><?= h($prop->name) ?></p>
                        </div>
                        <span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">
                            <?= h($prop->type) ?>
                        </span>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <?php endif; ?>
    </div>

    <!-- Colonne latérale : procédures liées -->
    <div class="space-y-6">
        <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
            <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
                <h3 class="text-base font-semibold leading-6 text-gray-900">Procédures liées</h3>
            </div>
            <ul role="list" class="divide-y divide-gray-100">
                <?php if (!empty($requirement->procedurerequirements)) : ?>
                    <?php foreach ($requirement->procedurerequirements as $pr) : ?>
                        <li class="px-4 py-3 sm:px-6 text-sm text-gray-700">
                            <i class="fa-solid fa-file-lines text-indigo-400 mr-2"></i>
                            <?= h($pr->procedure->name ?? 'Procédure #' . $pr->procedure_id) ?>
                        </li>
                    <?php endforeach; ?>
                <?php else : ?>
                    <li class="px-4 py-6 text-center text-sm text-gray-500 italic">Aucune procédure liée.</li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</div>
