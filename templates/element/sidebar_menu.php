<?php
    $ctrl   = $this->request->getParam('controller');
    $action = $this->request->getParam('action');
    $roleId = isset($user) ? (int)$user->id_role : 1;
    $prefix = match($roleId) { 3 => 'Admin', 2 => 'Agent', default => 'Client' };

    $accentActive = match($roleId) {
        3       => 'bg-red-50 text-red-700 font-semibold',
        2       => 'bg-amber-50 text-amber-700 font-semibold',
        default => 'bg-indigo-50 text-indigo-700 font-semibold',
    };
    $accentIcon = match($roleId) {
        3       => 'text-red-500',
        2       => 'text-amber-500',
        default => 'text-indigo-500',
    };

    $navItem = function($active, $accentActive, $accentIcon, $href, $icon, $label) {
        $baseClass = $active
            ? "group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition-all $accentActive"
            : 'group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all';
        $iconClass = $active ? "w-4 h-4 $accentIcon" : 'w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors';
        return "<a href=\"$href\" class=\"$baseClass\"><i class=\"fa-solid $icon $iconClass\"></i>$label</a>";
    };
?>

<!-- Dashboard -->
<div>
    <?= $navItem(
        $ctrl === 'Dashboard',
        $accentActive, $accentIcon,
        $this->Url->build(['controller' => 'Dashboard', 'action' => 'index']),
        'fa-gauge-high', 'Dashboard'
    ) ?>
</div>

<?php if ($roleId === 2 || $roleId === 3) : ?>
<!-- Requests (submenu for Agent & Admin) -->
<div class="pt-1" x-data="{ open: <?= $ctrl === 'Requests' ? 'true' : 'false' ?> }">
    <p class="px-3 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-400">Demandes</p>
    <button type="button"
            @click="open = !open"
            class="w-full group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition-all <?= $ctrl === 'Requests' ? $accentActive : '' ?>"
            aria-controls="sub-requests">
        <i class="fa-solid fa-folder-open w-4 h-4 <?= $ctrl === 'Requests' ? $accentIcon : 'text-gray-400 group-hover:text-gray-600' ?> transition-colors"></i>
        <span class="flex-1 text-left">Demandes</span>
        <i class="fa-solid fa-chevron-right text-xs text-gray-300 transition-transform duration-200" :class="open && 'rotate-90'"></i>
    </button>
    <div x-show="open" x-cloak class="mt-0.5 ml-4 pl-3 border-l border-gray-100 space-y-0.5" id="sub-requests">
        <?php if ($roleId === 3) : ?>
        <a href="<?= $this->Url->build(['prefix' => 'Admin', 'controller' => 'Requests', 'action' => 'request']) ?>"
           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?= $ctrl === 'Requests' && $action === 'request' ? $accentActive : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' ?> transition-colors">
            <i class="fa-solid fa-list text-xs w-3 text-gray-400"></i> Toutes les demandes
        </a>
        <?php endif; ?>
        <a href="<?= $this->Url->build(['prefix' => $prefix, 'controller' => 'Requests', 'action' => 'pending']) ?>"
           class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm <?= $ctrl === 'Requests' && $action === 'pending' ? $accentActive : 'text-gray-500 hover:text-gray-800 hover:bg-gray-50' ?> transition-colors">
            <i class="fa-solid fa-clock text-xs w-3 text-gray-400"></i> En attente
        </a>
    </div>
</div>
<?php endif; ?>

<?php if ($roleId === 3) : ?>
<!-- Admin-only sections -->
<div class="pt-2">
    <p class="px-3 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-400">Configuration</p>

    <?= $navItem(
        $ctrl === 'Requirements' || $ctrl === 'Requirementproprieties',
        $accentActive, $accentIcon,
        $this->Url->build(['prefix' => 'Admin', 'controller' => 'Requirements', 'action' => 'index']),
        'fa-list-check', 'Requirements'
    ) ?>

    <?= $navItem(
        $ctrl === 'Procedures' || $ctrl === 'Procedurerequirements',
        $accentActive, $accentIcon,
        $this->Url->build(['prefix' => 'Admin', 'controller' => 'Procedures', 'action' => 'index']),
        'fa-diagram-project', 'Procédures'
    ) ?>

    <?= $navItem(
        $ctrl === 'Users',
        $accentActive, $accentIcon,
        $this->Url->build(['prefix' => 'Admin', 'controller' => 'Users', 'action' => 'index']),
        'fa-users', 'Utilisateurs'
    ) ?>
</div>
<?php endif; ?>

<?php if ($roleId === 1) : ?>
<!-- Client sections -->
<div class="pt-2">
    <p class="px-3 mb-1 text-[10px] font-semibold uppercase tracking-widest text-gray-400">Mes services</p>

    <?= $navItem(
        $ctrl === 'Procedures',
        $accentActive, $accentIcon,
        $this->Url->build(['prefix' => 'Client', 'controller' => 'Procedures', 'action' => 'index']),
        'fa-diagram-project', 'Procédures'
    ) ?>

    <?= $navItem(
        $ctrl === 'Requests' && $action === 'index',
        $accentActive, $accentIcon,
        $this->Url->build(['prefix' => 'Client', 'controller' => 'Requests', 'action' => 'index']),
        'fa-folder-open', 'Mes Demandes'
    ) ?>
</div>
<?php endif; ?>
