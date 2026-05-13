<?php

/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Request $request
 * @var \App\Enum\RequirementTypes REQUIREMENT_TYPES
 */
?>
<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <div>
                <a href="<?= $this->Url->build(['controller' => 'Test', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                    <i class="fa-solid fa-house"></i>
                    <span class="sr-only">Home</span>
                </a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Procedure</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'requirementlist', $request->id]) ?>" class="ml-4 text-sm font-medium text-gray-500 hover:text-gray-700">Requirements</a>
            </div>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-900">Fill requirement</span>
            </div>
        </li>
    </ol>
</nav>

<div class="max-w-3xl mx-auto">
    <div class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <div class="px-4 py-6 sm:p-8">
            <h2 class="text-base font-semibold leading-7 text-gray-900"><?= h($requirement->name) ?></h2>
            
            <div class="mt-6">
                <?= $this->Form->create(null, ['enctype' => 'multipart/form-data', 'class' => 'space-y-6']) ?>
                
                <?php if ($requirement->requirementtype->type == 'formulaire') : ?>
                    <?php foreach ($requirementproprieties as $requirementpropriety) : ?>
                        <div>
                            <?= $this->Form->label($requirementpropriety->name, $requirementpropriety->label, ['class' => 'block text-sm font-medium leading-6 text-gray-900']) ?>
                            <div class="mt-2">
                                <?= $this->Form->control($requirementpropriety->name, [
                                    'type' => $requirementpropriety->type, 
                                    'label' => false,
                                    'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6', 
                                    'required' => true, 
                                    'value' => !empty($requestRequirement) 
                                        ? $this->Requests->getPropertyValue($requirementpropriety->id, $requestRequirement->requestrequirementproprieties) 
                                        : ''  
                                ]); ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                <?php elseif ($requirement->requirementtype->type == 'file') : ?>
                    <div>
                        <?= $this->Form->label('file', 'Document requis', ['class' => 'block text-sm font-medium leading-6 text-gray-900']) ?>
                        <div class="mt-2">
                            <?= $this->Form->control('file', [
                                'type' => 'file', 
                                'label' => false,
                                'class' => 'block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100', 
                                'required' => true
                            ]); ?>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 pt-6 mt-8">
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Soumettre
                    </button>
                </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>