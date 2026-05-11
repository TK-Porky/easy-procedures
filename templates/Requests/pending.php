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
                <span class="ml-4 text-sm font-medium text-gray-500">Demandes en attente</span>
            </div>
        </li>
    </ol>
</nav>

<div class="mx-auto max-w-7xl">
    <div class="sm:flex sm:items-center mb-8">
        <div class="sm:flex-auto">
            <h1 class="text-2xl font-semibold leading-6 text-gray-900">Demandes en attente</h1>
            <p class="mt-2 text-sm text-gray-700">Liste des demandes nécessitant une action ou une validation de votre part.</p>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white px-4 py-4 sm:px-6 mb-6 shadow-sm ring-1 ring-gray-900/5 sm:rounded-lg">
        <?= $this->Form->create(null, ['url' => ['controller' => 'Requests', 'action' => 'pending'], 'type' => 'get', 'class' => 'grid grid-cols-1 gap-y-4 sm:grid-cols-6 sm:gap-x-4']) ?>
            <div class="sm:col-span-5">
                <label for="search" class="sr-only">Rechercher</label>
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                    <input type="text" name="search" id="search" value="<?= $this->request->getQuery('search') ?>" class="block w-full rounded-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" placeholder="Rechercher par nom d'utilisateur">
                </div>
            </div>

            <div class="sm:col-span-1">
                <button type="submit" class="flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Rechercher
                </button>
            </div>
        <?= $this->Form->end() ?>
    </div>

    <!-- Data Grid -->
    <div class="overflow-hidden bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl">
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Demandeur</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Procédure</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Dernière MàJ</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                        <span class="sr-only">Actions</span>
                    </th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                <?php foreach ($requests as $request) : ?>
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                            <?= h($request->user->name ?? 'Inconnu') ?> <?= h($request->user->surname ?? '') ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            <?= h($request->procedure->name ?? 'Inconnue') ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            <?= $request->modified ? $request->modified->format('d/m/Y H:i') : '-' ?>
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                            <span class="inline-flex items-center rounded-full bg-orange-100 px-3 py-1 text-xs font-medium text-orange-800 ring-1 ring-inset ring-orange-600/20">
                                En attente
                            </span>
                        </td>
                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <?= $this->Html->link(__('Traiter <span class="sr-only">, demande ' . $request->id . '</span>'), ['action' => 'firstview', $request->id], ['class' => 'text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-2 rounded-lg transition-colors', 'escape' => false]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if ($requests->isEmpty()) : ?>
                    <tr>
                        <td colspan="5" class="py-10 text-center text-sm text-gray-500 italic">Aucune demande en attente.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-6 flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg shadow-sm ring-1 ring-gray-900/5">
        <div class="flex flex-1 justify-between sm:hidden">
            <?= $this->Paginator->prev('Précédent', ['class' => 'relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50']) ?>
            <?= $this->Paginator->next('Suivant', ['class' => 'relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50']) ?>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 italic">
                    <?= $this->Paginator->counter(__('Page {{page}} sur {{pages}}, affichage de {{current}} demande(s) sur {{count}}')) ?>
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <?= $this->Paginator->numbers(['first' => 1, 'last' => 1, 'class' => 'relative inline-flex items-center px-4 py-2 text-sm font-semibold text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:z-20 focus:outline-offset-0']) ?>
                </nav>
            </div>
        </div>
    </div>
</div>