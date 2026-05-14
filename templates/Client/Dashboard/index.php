<?php
$this->assign('title', 'Dashboard');

$requestsTable   = \Cake\ORM\TableRegistry::getTableLocator()->get('Requests');
$proceduresTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Procedures');

$userId = $this->request->getAttribute('authentication')->getResult()->getData()->id ?? null;

$myRequests   = $userId ? $requestsTable->find()->where(['user_id' => $userId, 'Requests.deleted' => 0])->count() : 0;
$myPending    = $userId ? $requestsTable->find()->where(['user_id' => $userId, 'Requests.deleted' => 0, 'status' => 'Pending Verification'])->count() : 0;
$myApproved   = $userId ? $requestsTable->find()->where(['user_id' => $userId, 'Requests.deleted' => 0, 'status' => 'Approved'])->count() : 0;
$myDraft      = $userId ? $requestsTable->find()->where(['user_id' => $userId, 'Requests.deleted' => 0, 'status' => 'Draft'])->count() : 0;

$recentRequests = $userId ? $requestsTable->find()
    ->contain(['Procedures'])
    ->where(['user_id' => $userId, 'Requests.deleted' => 0])
    ->order(['Requests.modified' => 'DESC'])
    ->limit(4)
    ->all() : [];

$procedures = $proceduresTable->find()->where(['deleted' => 0])->limit(3)->all();
?>

<!-- Welcome header -->
<div class="page-header">
    <div>
        <h1 class="page-title">Bonjour, <?= isset($user) ? h($user->name) : 'Client' ?> 👋</h1>
        <p class="page-subtitle">Bienvenue dans votre espace personnel Easy Procedures</p>
    </div>
    <a href="/client/procedures" class="btn-primary btn-sm">
        <i class="fa-solid fa-plus"></i> Nouvelle demande
    </a>
</div>

<!-- Stats -->
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <?php
    $stats = [
        ['fa-folder-open', 'bg-indigo-100','text-indigo-600', $myRequests, 'Mes demandes',  '/client/requests'],
        ['fa-clock',       'bg-amber-100', 'text-amber-600',  $myPending,  'En traitement', '/client/requests'],
        ['fa-circle-check','bg-emerald-100','text-emerald-600',$myApproved,'Approuvées',    '/client/requests'],
        ['fa-file-pen',    'bg-gray-100',  'text-gray-600',   $myDraft,    'Brouillons',    '/client/requests'],
    ];
    foreach ($stats as [$icon, $bg, $text, $val, $label, $link]) :
    ?>
    <a href="<?= $link ?>" class="card card-body hover:shadow-md transition-all hover:-translate-y-0.5 block">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-xs font-medium text-gray-500 mb-1"><?= $label ?></p>
                <p class="text-3xl font-bold text-gray-900"><?= $val ?></p>
            </div>
            <div class="w-10 h-10 rounded-xl <?= $bg ?> flex items-center justify-center flex-shrink-0">
                <i class="fa-solid <?= $icon ?> <?= $text ?>"></i>
            </div>
        </div>
    </a>
    <?php endforeach; ?>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    <!-- Recent requests -->
    <div class="lg:col-span-2 card">
        <div class="card-header">
            <div>
                <h2 class="text-sm font-semibold text-gray-900">Mes demandes récentes</h2>
                <p class="text-xs text-gray-500 mt-0.5">Dernières activités</p>
            </div>
            <a href="/client/requests" class="text-xs font-medium text-indigo-600 hover:text-indigo-500">Tout voir →</a>
        </div>

        <?php if (count($recentRequests) > 0) : ?>
        <div class="divide-y divide-gray-100">
            <?php foreach ($recentRequests as $req) :
                $statusClass = match($req->status) {
                    'Approved'             => 'badge-green',
                    'Rejected'             => 'badge-red',
                    'Pending Verification' => 'badge-amber',
                    default                => 'badge-gray',
                };
                $statusLabel = match($req->status) {
                    'Approved'             => 'Approuvée',
                    'Rejected'             => 'Rejetée',
                    'Pending Verification' => 'En cours',
                    default                => 'Brouillon',
                };
                $procIcon = match($req->procedure->type ?? '') {
                    'Transport'   => 'fa-car',
                    'Immigration' => 'fa-passport',
                    default       => 'fa-file-lines',
                };
            ?>
            <a href="/client/requests/firstview/<?= $req->id ?>"
               class="flex items-center gap-4 px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="w-10 h-10 rounded-xl bg-indigo-50 flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid <?= $procIcon ?> text-indigo-500"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate"><?= h($req->procedure->name ?? 'Procédure inconnue') ?></p>
                    <p class="text-xs text-gray-400"><?= $req->modified ? $req->modified->format('d/m/Y à H:i') : '' ?></p>
                </div>
                <span class="<?= $statusClass ?> flex-shrink-0"><?= $statusLabel ?></span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="empty-state">
            <div class="empty-state-icon"><i class="fa-solid fa-folder-open"></i></div>
            <p class="empty-state-title">Aucune demande</p>
            <p class="empty-state-desc">Commencez par choisir une procédure ci-dessous.</p>
            <div class="mt-4">
                <a href="/client/procedures" class="btn-primary btn-sm">Voir les procédures</a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Available procedures -->
    <div class="card card-body">
        <h2 class="text-sm font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fa-solid fa-diagram-project text-indigo-400"></i>
            Procédures disponibles
        </h2>
        <div class="space-y-3">
            <?php foreach ($procedures as $proc) :
                $procIcon  = match($proc->type ?? '') { 'Transport' => 'fa-car', 'Immigration' => 'fa-passport', default => 'fa-file-lines' };
                $procColor = match($proc->type ?? '') { 'Transport' => 'bg-blue-100 text-blue-600', 'Immigration' => 'bg-violet-100 text-violet-600', default => 'bg-indigo-100 text-indigo-600' };
            ?>
            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50/30 transition-colors">
                <div class="w-9 h-9 rounded-xl <?= $procColor ?> flex items-center justify-center flex-shrink-0">
                    <i class="fa-solid <?= $procIcon ?> text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate"><?= h($proc->name) ?></p>
                    <p class="text-xs text-gray-400"><?= h($proc->type ?? '') ?></p>
                </div>
                <a href="/client/requests/add/<?= $proc->id ?>"
                   class="flex-shrink-0 w-7 h-7 rounded-lg bg-indigo-100 flex items-center justify-center text-indigo-600 hover:bg-indigo-200 transition-colors"
                   title="Déposer une demande">
                    <i class="fa-solid fa-plus text-xs"></i>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="mt-4 pt-4 border-t border-gray-100">
            <a href="/client/procedures" class="btn-secondary w-full justify-center btn-sm">
                Toutes les procédures
            </a>
        </div>
    </div>

</div>
