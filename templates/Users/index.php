<?php $this->assign('title', 'Users Agents'); ?>

<?php
// Pagination config (set in controller, mirrored here for reference)
// $this->Paginator->options(['url' => $this->request->getQueryParams()]);
?>

<style>
    .ua-table-wrapper { border-radius: 12px; border: 0.5px solid #e5e7eb; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0,0,0,.06); }
    .ua-table thead { background: #f9fafb; }
    .ua-table thead th { font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #6b7280; padding: 12px 16px; border-bottom: 0.5px solid #e5e7eb; white-space: nowrap; }
    .ua-table tbody tr { transition: background .12s; }
    .ua-table tbody tr:hover { background: #f9fafb; }
    .ua-table tbody td { padding: 14px 16px; font-size: 13.5px; color: #374151; border-bottom: 0.5px solid #f3f4f6; vertical-align: middle; }
    .ua-table tbody tr:last-child td { border-bottom: none; }
    .ua-avatar { width: 32px; height: 32px; border-radius: 50%; background: #e0e7ff; color: #4338ca; font-size: 12px; font-weight: 600; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .ua-badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 10px; border-radius: 99px; font-size: 11.5px; font-weight: 500; }
    .ua-badge-indigo { background: #eef2ff; color: #4338ca; }
    .ua-btn-icon { width: 30px; height: 30px; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; border: none; background: transparent; cursor: pointer; transition: background .12s, color .12s; font-size: 13px; }
    .ua-btn-icon:hover { background: #f3f4f6; }
    .ua-btn-icon.danger:hover { background: #fef2f2; color: #dc2626; }
    .ua-btn-icon.edit:hover { background: #eef2ff; color: #4338ca; }
    .ua-search { display: flex; align-items: center; gap: 8px; background: #fff; border: 0.5px solid #d1d5db; border-radius: 8px; padding: 0 12px; height: 38px; transition: border .15s, box-shadow .15s; }
    .ua-search:focus-within { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
    .ua-search input { border: none; outline: none; font-size: 13.5px; color: #111827; background: transparent; flex: 1; min-width: 0; }
    .ua-search input::placeholder { color: #9ca3af; }
    .ua-search i { color: #9ca3af; font-size: 13px; }
    .ua-select { height: 38px; padding: 0 10px; border: 0.5px solid #d1d5db; border-radius: 8px; font-size: 13.5px; color: #374151; background: #fff; outline: none; cursor: pointer; }
    .ua-select:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
    .ua-page-btn { width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center; border-radius: 7px; border: 0.5px solid #e5e7eb; background: #fff; font-size: 13px; cursor: pointer; color: #374151; text-decoration: none; transition: all .12s; }
    .ua-page-btn:hover { background: #f3f4f6; border-color: #d1d5db; }
    .ua-page-btn.active { background: #4f46e5; border-color: #4f46e5; color: #fff; font-weight: 600; }
    .ua-page-btn.disabled { opacity: .4; pointer-events: none; }
    .modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 50; display: flex; align-items: center; justify-content: center; padding: 16px; }
    .modal-box { background: #fff; border-radius: 14px; padding: 28px; width: 100%; max-width: 480px; position: relative; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
    .modal-close { position: absolute; top: 16px; right: 16px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; background: #f3f4f6; border: none; cursor: pointer; color: #6b7280; transition: background .12s; }
    .modal-close:hover { background: #e5e7eb; }
    .form-group { margin-bottom: 16px; }
    .form-group label { display: block; font-size: 12px; font-weight: 600; letter-spacing: .04em; color: #6b7280; text-transform: uppercase; margin-bottom: 6px; }
    .form-group input { width: 100%; height: 38px; padding: 0 12px; border: 0.5px solid #d1d5db; border-radius: 8px; font-size: 13.5px; color: #111827; outline: none; transition: border .15s, box-shadow .15s; box-sizing: border-box; }
    .form-group input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .ua-empty { text-align: center; padding: 48px 0; color: #9ca3af; }
    .ua-empty i { font-size: 32px; display: block; margin-bottom: 12px; opacity: .4; }
    .ua-count-badge { background: #eef2ff; color: #4338ca; font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 99px; }
</style>

<!-- Breadcrumb -->
<nav class="flex mb-8" aria-label="Breadcrumb">
    <ol role="list" class="flex items-center space-x-4">
        <li>
            <a href="<?= $this->Url->build(['controller' => 'Test', 'action' => 'index']) ?>" class="text-gray-400 hover:text-gray-500">
                <i class="fa-solid fa-house"></i>
                <span class="sr-only">Home</span>
            </a>
        </li>
        <li>
            <div class="flex items-center">
                <i class="fa-solid fa-chevron-right text-gray-400 text-xs"></i>
                <span class="ml-4 text-sm font-medium text-gray-500">Users Agents</span>
            </div>
        </li>
    </ol>
</nav>

<div
    x-data="{
        openAdd: false,
        openEdit: false,
        editUser: {},
        search: '',
        sortField: '',
        sortDir: 'asc',
        setEdit(user) {
            this.editUser = { ...user };
            this.openEdit = true;
        }
    }"
>

    <!-- Header -->
    <div class="sm:flex sm:items-center mb-6">
        <div class="sm:flex-auto">
            <div class="flex items-center gap-3">
                <h1 class="text-2xl font-semibold leading-6 text-gray-900"><?= __('Users Agents') ?></h1>
                <span class="ua-count-badge"><?= count($users) ?> agents</span>
            </div>
            <p class="mt-1.5 text-sm text-gray-500">Manage and monitor all agents registered in the system.</p>
        </div>
        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
            <button
                type="button"
                @click="openAdd = true"
                class="inline-flex items-center gap-2 rounded-lg bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors"
            >
                <i class="fa-solid fa-plus text-xs"></i>
                Add New Agent
            </button>
        </div>
    </div>

    <!-- Filters bar -->
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'contents']) ?>
            <div class="ua-search" style="flex: 1; min-width: 200px; max-width: 360px;">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input
                    type="text"
                    name="q"
                    placeholder="Search by name, email, phone…"
                    value="<?= h($this->request->getQuery('q')) ?>"
                />
            </div>
            <select name="sort" class="ua-select">
                <option value="">Sort by…</option>
                <option value="name" <?= $this->request->getQuery('sort') === 'name' ? 'selected' : '' ?>>Name A–Z</option>
                <option value="created" <?= $this->request->getQuery('sort') === 'created' ? 'selected' : '' ?>>Newest first</option>
                <option value="email" <?= $this->request->getQuery('sort') === 'email' ? 'selected' : '' ?>>Email A–Z</option>
            </select>
            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3.5 py-2 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                <i class="fa-solid fa-filter text-xs"></i> Apply
            </button>
            <?php if ($this->request->getQuery('q') || $this->request->getQuery('sort')) : ?>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="text-sm text-indigo-600 hover:underline">Clear</a>
            <?php endif; ?>
        <?= $this->Form->end() ?>
    </div>

    <!-- Table -->
    <div class="ua-table-wrapper">
        <table class="ua-table min-w-full">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('name', __('Agent')) ?></th>
                    <th><?= $this->Paginator->sort('email', __('Email')) ?></th>
                    <th><?= $this->Paginator->sort('phonenumber', __('Phone')) ?></th>
                    <th><?= $this->Paginator->sort('created', __('Created')) ?></th>
                    <th style="width: 80px; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php if (empty($users)) : ?>
                    <tr>
                        <td colspan="5" class="ua-empty">
                            <i class="fa-regular fa-user"></i>
                            No agents found. Try adjusting your search.
                        </td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($users as $user) : ?>
                        <?php
                            $initials = strtoupper(
                                substr($user->name ?? '', 0, 1) .
                                substr($user->surname ?? '', 0, 1)
                            );
                        ?>
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="ua-avatar"><?= h($initials ?: '?') ?></div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm"><?= h($user->name) ?> <?= h($user->surname) ?></div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="mailto:<?= h($user->email) ?>" class="text-indigo-600 hover:underline">
                                    <?= h($user->email) ?>
                                </a>
                            </td>
                            <td class="text-gray-500"><?= h($user->phonenumber) ?></td>
                            <td>
                                <span class="ua-badge ua-badge-indigo">
                                    <i class="fa-regular fa-clock" style="font-size:10px;"></i>
                                    <?= h($user->created->format('M d, Y')) ?>
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center justify-end gap-1">
                                    <!-- Edit button -->
                                    <button
                                        type="button"
                                        class="ua-btn-icon edit"
                                        title="Edit"
                                        @click="setEdit({
                                            id: <?= $user->id ?>,
                                            name: '<?= addslashes(h($user->name)) ?>',
                                            surname: '<?= addslashes(h($user->surname)) ?>',
                                            email: '<?= addslashes(h($user->email)) ?>',
                                            phonenumber: '<?= addslashes(h($user->phonenumber)) ?>'
                                        })"
                                    >
                                        <i class="fa-solid fa-pen-to-square text-gray-400"></i>
                                    </button>
                                    <!-- Delete button -->
                                    <?= $this->Form->postLink(
                                        '<i class="fa-solid fa-trash"></i>',
                                        ['action' => 'delete', $user->id],
                                        [
                                            'confirm' => __('Delete {0} {1}? This action cannot be undone.', $user->name, $user->surname),
                                            'escape' => false,
                                            'title' => 'Delete',
                                            'class' => 'ua-btn-icon danger',
                                            'style' => 'color:#9ca3af;',
                                        ]
                                    ) ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if ($this->Paginator->hasPage(2)) : ?>
    <div class="flex items-center justify-between mt-5">
        <p class="text-sm text-gray-500">
            <?= $this->Paginator->counter(__('Showing {{start}}–{{end}} of {{count}} agents')) ?>
        </p>
        <div class="flex items-center gap-1.5">
            <?php if ($this->Paginator->hasPrev()) : ?>
                <a href="<?= $this->Paginator->generateUrl(['page' => $this->Paginator->current() - 1]) ?>" class="ua-page-btn" title="Previous">
                    <i class="fa-solid fa-chevron-left" style="font-size:11px;"></i>
                </a>
            <?php else : ?>
                <span class="ua-page-btn disabled"><i class="fa-solid fa-chevron-left" style="font-size:11px;"></i></span>
            <?php endif; ?>

            <?php
                $currentPage = $this->Paginator->current();
                $totalPages  = $this->Paginator->total();
                $range = range(max(1, $currentPage - 2), min($totalPages, $currentPage + 2));
                foreach ($range as $p) :
            ?>
                <?php if ($p === $currentPage) : ?>
                    <span class="ua-page-btn active"><?= $p ?></span>
                <?php else : ?>
                    <a href="<?= $this->Paginator->generateUrl(['page' => $p]) ?>" class="ua-page-btn"><?= $p ?></a>
                <?php endif; ?>
            <?php endforeach; ?>

            <?php if ($this->Paginator->hasNext()) : ?>
                <a href="<?= $this->Paginator->generateUrl(['page' => $currentPage + 1]) ?>" class="ua-page-btn" title="Next">
                    <i class="fa-solid fa-chevron-right" style="font-size:11px;"></i>
                </a>
            <?php else : ?>
                <span class="ua-page-btn disabled"><i class="fa-solid fa-chevron-right" style="font-size:11px;"></i></span>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>


    <!-- ======================== ADD MODAL ======================== -->
    <template x-teleport="body">
        <div x-show="openAdd" class="modal-overlay" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @keydown.escape.window="openAdd = false" style="display:none;">
            <div class="modal-box" @click.away="openAdd = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <button class="modal-close" @click="openAdd = false" type="button">
                    <i class="fa-solid fa-xmark" style="font-size:13px;"></i>
                </button>

                <div class="flex items-center gap-3 mb-6">
                    <div style="width:38px;height:38px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-user-plus" style="color:#4f46e5;font-size:15px;"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Add New Agent</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Fill in the details to register a new agent.</p>
                    </div>
                </div>

                <?= $this->Form->create(null, ['url' => ['action' => 'add']]) ?>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="name" placeholder="John" required />
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" placeholder="Doe" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" placeholder="john.doe@example.com" required />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phonenumber" placeholder="+1 555 000 0000" />
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" placeholder="••••••••" required />
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="openAdd = false" class="flex-1 rounded-lg border border-gray-200 bg-white py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                            Create Agent
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </template>


    <!-- ======================== EDIT MODAL ======================== -->
    <template x-teleport="body">
        <div x-show="openEdit" class="modal-overlay" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @keydown.escape.window="openEdit = false" style="display:none;">
            <div class="modal-box" @click.away="openEdit = false" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <button class="modal-close" @click="openEdit = false" type="button">
                    <i class="fa-solid fa-xmark" style="font-size:13px;"></i>
                </button>

                <div class="flex items-center gap-3 mb-6">
                    <div style="width:38px;height:38px;border-radius:10px;background:#ede9fe;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-pen-to-square" style="color:#7c3aed;font-size:15px;"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Edit Agent</h3>
                        <p class="text-xs text-gray-400 mt-0.5" x-text="'Editing: ' + editUser.name + ' ' + editUser.surname"></p>
                    </div>
                </div>

                <form :action="'/users-agents/edit/' + editUser.id" method="POST">
                    <?= $this->Form->hidden('_method', ['value' => 'PUT']) ?>
                    <?php echo $this->Form->hidden('_Token[fields]', ['id' => 'edit-token-fields']) ?>
                    <?php echo $this->Form->hidden('_Token[unlocked]', ['id' => 'edit-token-unlocked']) ?>

                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="name" x-model="editUser.name" placeholder="John" required />
                        </div>
                        <div class="form-group">
                            <label>Surname</label>
                            <input type="text" name="surname" x-model="editUser.surname" placeholder="Doe" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" x-model="editUser.email" placeholder="john.doe@example.com" required />
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="tel" name="phonenumber" x-model="editUser.phonenumber" placeholder="+1 555 000 0000" />
                    </div>
                    <div class="form-group">
                        <label>New Password <span class="text-gray-400 font-normal normal-case">(leave blank to keep current)</span></label>
                        <input type="password" name="password" placeholder="••••••••" />
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="openEdit = false" class="flex-1 rounded-lg border border-gray-200 bg-white py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-violet-600 py-2.5 text-sm font-semibold text-white hover:bg-violet-500 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </template>

</div>