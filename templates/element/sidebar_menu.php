<li <?= $this->request->getParam('controller') == 'Test' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
    <a href="<?= $this->Url->build(['controller' => 'Test', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
        <i class="fa-solid fa-gauge-high w-6 text-center leading-6"></i>
        <?= __('Dashboard') ?>
    </a>
</li>

<?php if ($user->id_role == 2 || $user->id_role == 3) : ?>
    <li x-data="{ open: <?= $this->request->getParam('controller') == 'Requests' ? 'true' : 'false' ?> }">
        <button type="button" @click="open = !open" class="flex items-center w-full text-left rounded-md p-2 gap-x-3 text-sm leading-6 font-semibold text-gray-700 hover:text-indigo-600 hover:bg-gray-50" aria-controls="sub-menu-requests" :aria-expanded="open">
            <i class="fa-solid fa-folder w-6 text-center leading-6"></i>
            <?= __('Requests') ?>
            <i class="ml-auto fa-solid fa-chevron-right text-xs transition-transform duration-200" :class="open ? 'rotate-90' : ''"></i>
        </button>
        <ul x-show="open" class="mt-1 px-2 space-y-1" id="sub-menu-requests">
            <li>
                <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'request']) ?>" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700 hover:text-indigo-600 hover:bg-gray-50">All Requests</a>
            </li>
            <li>
                <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'pending']) ?>" class="block rounded-md py-2 pr-2 pl-9 text-sm leading-6 text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Pending</a>
            </li>
        </ul>
    </li>
<?php endif; ?>

<?php if ($user->id_role == 3) : ?>
    <li <?= $this->request->getParam('controller') == 'Requirements' || $this->request->getParam('controller') == 'Requirementproprieties' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
        <a href="<?= $this->Url->build(['controller' => 'Requirements', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class="fa-solid fa-list-check w-6 text-center leading-6"></i>
            <?= __('Requirements') ?>
        </a>
    </li>
    <li <?= $this->request->getParam('controller') == 'Procedures' || $this->request->getParam('controller') == 'Procedurerequirements' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
        <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class="fa-solid fa-diagram-project w-6 text-center leading-6"></i>
            <?= __('Procedures') ?>
        </a>
    </li>
    <li <?= $this->request->getParam('controller') == 'Users' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class="fa-solid fa-users w-6 text-center leading-6"></i>
            <?= __('Users') ?>
        </a>
    </li>
<?php endif; ?>

<?php if ($user->id_role == 1) : ?>
    <li <?= $this->request->getParam('controller') == 'Procedures' || $this->request->getParam('controller') == 'Procedurerequirements' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
        <a href="<?= $this->Url->build(['controller' => 'Procedures', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class="fa-solid fa-diagram-project w-6 text-center leading-6"></i>
            <?= __('Procedures') ?>
        </a>
    </li>
    <li <?= $this->request->getParam('controller') == 'Requests' && $this->request->getParam('action') == 'index' ? 'class="bg-gray-50 text-indigo-600"' : 'text-gray-700 hover:text-indigo-600 hover:bg-gray-50' ?> rounded-md>
        <a href="<?= $this->Url->build(['controller' => 'Requests', 'action' => 'index']) ?>" class="group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold">
            <i class="fa-solid fa-folder-open w-6 text-center leading-6"></i>
            <?= __('My Procedures') ?>
        </a>
    </li>
<?php endif; ?>
