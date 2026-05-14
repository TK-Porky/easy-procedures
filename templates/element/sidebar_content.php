<?php
    $roleId    = isset($user) ? (int)$user->id_role : 1;
    $roleName  = match($roleId) { 3 => 'Administrateur', 2 => 'Agent', default => 'Client' };
    $roleColor = match($roleId) { 3 => 'red', 2 => 'amber', default => 'indigo' };
    $roleIcon  = match($roleId) { 3 => 'fa-shield-halved', 2 => 'fa-user-tie', default => 'fa-user' };
    $currentPrefix = match($roleId) { 3 => 'Admin', 2 => 'Agent', default => 'Client' };

    $accentBg   = match($roleColor) { 'red' => 'bg-red-600', 'amber' => 'bg-amber-500', default => 'bg-indigo-600' };
    $accentText = match($roleColor) { 'red' => 'text-red-600', 'amber' => 'text-amber-600', default => 'text-indigo-600' };
    $accentBadge = match($roleColor) {
        'red'   => 'bg-red-100 text-red-700',
        'amber' => 'bg-amber-100 text-amber-700',
        default => 'bg-indigo-100 text-indigo-700',
    };
?>

<div class="flex flex-col h-full overflow-y-auto scrollbar-hide">

    <!-- Brand header -->
    <div class="flex items-center gap-3 px-5 py-5 border-b border-gray-100">
        <div class="flex-shrink-0 w-9 h-9 rounded-xl <?= $accentBg ?> flex items-center justify-center shadow-sm">
            <i class="fa-solid fa-building-columns text-white text-sm"></i>
        </div>
        <div class="min-w-0">
            <p class="text-sm font-bold text-gray-900 truncate">Easy Procedures</p>
            <span class="inline-flex items-center gap-1 text-xs font-medium px-1.5 py-0.5 rounded-full <?= $accentBadge ?>">
                <i class="fa-solid <?= $roleIcon ?> text-[10px]"></i>
                <?= $roleName ?>
            </span>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 px-3 py-4 space-y-0.5">
        <?= $this->element('sidebar_menu') ?>
    </nav>

    <!-- User section at bottom -->
    <div class="px-3 py-4 border-t border-gray-100">
        <div class="flex items-center gap-3 px-3 py-2.5 rounded-xl hover:bg-gray-50 transition-colors group cursor-pointer">
            <img class="w-8 h-8 rounded-full ring-2 ring-gray-200 flex-shrink-0 object-cover"
                 src="<?= $this->Url->build('/template/images/icon/avatar-01.png') ?>" alt="">
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-800 truncate"><?= isset($user) ? h($user->name) : 'Invité' ?></p>
                <p class="text-xs text-gray-400 truncate"><?= isset($user) ? h($user->email ?? '') : '' ?></p>
            </div>
            <a href="<?= $this->Url->build(['prefix' => $currentPrefix, 'controller' => 'Auth', 'action' => 'logout']) ?>"
               class="flex-shrink-0 w-7 h-7 rounded-lg flex items-center justify-center text-gray-400 hover:bg-red-50 hover:text-red-500 transition-colors"
               title="Déconnexion">
                <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
            </a>
        </div>
    </div>
</div>
