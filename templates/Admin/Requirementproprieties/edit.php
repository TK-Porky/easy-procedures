<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Requirementpropriety $requirementpropriety
 */
$this->assign('title', 'Modifier le champ');
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
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Requirements', 'action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Requirements</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Requirementproprieties', 'action' => 'index', $requirementpropriety->requirement_id]) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Champs</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Modifier : <?= h($requirementpropriety->label) ?></span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-2xl mx-auto">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl overflow-hidden">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-5 sm:px-6">
            <h2 class="text-xl font-semibold leading-7 text-gray-900">Modifier le champ</h2>
            <p class="mt-1 text-sm leading-6 text-gray-500">Mettez à jour les propriétés de ce champ de formulaire.</p>
        </div>

        <div class="px-4 py-6 sm:p-8">
            <?= $this->Form->create($requirementpropriety, ['class' => 'space-y-6']) ?>
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Nom interne (identifiant) <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <?= $this->Form->control('name', [
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Identifiant technique, sans espaces (ex: date_naissance).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Label affiché <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <?= $this->Form->control('label', [
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Texte visible par le client (ex: Date de naissance).</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Type de champ <span class="text-red-500">*</span></label>
                        <div class="mt-2">
                            <?= $this->Form->control('type', [
                                'options' => $options,
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Description / Aide</label>
                        <div class="mt-2">
                            <?= $this->Form->control('description', [
                                'type' => 'textarea',
                                'label' => false,
                                'rows' => 2,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Texte d'aide affiché sous le champ.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium leading-6 text-gray-900">Valeur par défaut</label>
                        <div class="mt-2">
                            <?= $this->Form->control('default_value', [
                                'label' => false,
                                'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
                            ]) ?>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end gap-x-4 border-t border-gray-900/10 pt-6 mt-8">
                    <a href="<?= $this->Url->build(['action' => 'index', $requirementpropriety->requirement_id]) ?>" class="text-sm font-semibold leading-6 text-gray-900 hover:text-gray-700">
                        Annuler
                    </a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500">
                        <i class="fa-solid fa-save mr-2"></i> Enregistrer
                    </button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
