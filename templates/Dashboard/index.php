<div class="p-6 sm:p-10 space-y-6">
    <div class="flex flex-col space-y-6 md:space-y-0 md:flex-row justify-between">
        <div class="mr-6">
            <h1 class="text-4xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-600">Tableau de Bord</h1>
            <p class="text-gray-500 mt-2 text-lg">Bienvenue sur votre espace d'administration Easy Procedures.</p>
        </div>
        <div class="flex flex-wrap items-start justify-end -mb-3">
            <a href="/procedures" class="inline-flex px-5 py-3 text-white bg-indigo-600 hover:bg-indigo-700 focus:bg-indigo-700 rounded-lg ml-6 mb-3 shadow-lg shadow-indigo-200 transition-transform transform hover:-translate-y-1">
                <svg aria-hidden="true" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="flex-shrink-0 h-5 w-5 -ml-1 mt-0.5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Nouvelle Procédure
            </a>
        </div>
    </div>

    <!-- Stat Cards -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
        <!-- Total Requests -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-blue-50 to-blue-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-blue-100 text-blue-600 relative z-10">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="mx-5 relative z-10">
                    <h4 class="text-2xl font-bold text-gray-800"><?= number_format($totalRequests) ?></h4>
                    <div class="text-gray-500 text-sm font-medium">Demandes totales</div>
                </div>
            </div>
        </div>

        <!-- Pending -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-orange-50 to-orange-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-orange-100 text-orange-600 relative z-10">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mx-5 relative z-10">
                    <h4 class="text-2xl font-bold text-gray-800"><?= number_format($pendingRequests) ?></h4>
                    <div class="text-gray-500 text-sm font-medium">En attente</div>
                </div>
            </div>
        </div>

        <!-- Approved -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-green-50 to-green-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-green-100 text-green-600 relative z-10">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="mx-5 relative z-10">
                    <h4 class="text-2xl font-bold text-gray-800"><?= number_format($approvedRequests) ?></h4>
                    <div class="text-gray-500 text-sm font-medium">Approuvées</div>
                </div>
            </div>
        </div>

        <!-- Users -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-gradient-to-br from-purple-50 to-purple-100 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="flex items-center">
                <div class="p-3 rounded-xl bg-purple-100 text-purple-600 relative z-10">
                    <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div class="mx-5 relative z-10">
                    <h4 class="text-2xl font-bold text-gray-800"><?= number_format($totalUsers) ?></h4>
                    <div class="text-gray-500 text-sm font-medium">Inscrits</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Requests Table -->
    <div class="flex flex-col mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Demandes récentes</h2>
        <div class="overflow-x-auto bg-white rounded-2xl shadow-sm border border-gray-100">
            <div class="inline-block min-w-full align-middle">
                <div class="overflow-hidden border-b border-gray-200 rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Demandeur</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Procédure</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Statut</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            <?php if (empty($recentRequests->toArray())): ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-500">Aucune demande pour le moment.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($recentRequests as $request): ?>
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10">
                                                    <div class="h-10 w-10 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center text-white font-bold text-sm shadow-inner">
                                                        <?= strtoupper(substr($request->user->name ?? '?', 0, 1)) ?>
                                                    </div>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="text-sm font-medium text-gray-900"><?= h($request->user->name ?? 'Inconnu') ?> <?= h($request->user->surname ?? '') ?></div>
                                                    <div class="text-sm text-gray-500"><?= h($request->user->email ?? '') ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900 font-medium"><?= h($request->procedure->name ?? 'Procédure inconnue') ?></div>
                                            <div class="text-sm text-gray-500">Réf: #<?= $request->id ?></div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <?php 
                                            $status = strtolower($request->status ?? '');
                                            $badgeClass = 'bg-gray-100 text-gray-800';
                                            if (in_array($status, ['pending', 'en attente', 'attente'])) $badgeClass = 'bg-orange-100 text-orange-800 border border-orange-200';
                                            elseif (in_array($status, ['approved', 'approuvée', 'validee', 'acceptee'])) $badgeClass = 'bg-green-100 text-green-800 border border-green-200';
                                            elseif (in_array($status, ['rejected', 'rejetée', 'refusee'])) $badgeClass = 'bg-red-100 text-red-800 border border-red-200';
                                            ?>
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full shadow-sm <?= $badgeClass ?>">
                                                <?= h(ucfirst($request->status ?? 'Inconnu')) ?>
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            <?= $request->created ? $request->created->format('d/m/Y H:i') : 'N/A' ?>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="/requests/view/<?= $request->id ?>" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition-colors">Traiter</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
