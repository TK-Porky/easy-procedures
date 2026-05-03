<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<style>
    .profile-card { max-width: 560px; margin: 0 auto; }
    .profile-header { background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%); border-radius: 16px 16px 0 0; padding: 40px 32px 56px; text-align: center; position: relative; }
    .profile-avatar-wrap { position: relative; display: inline-block; margin-bottom: 14px; }
    .profile-avatar-img { width: 88px; height: 88px; border-radius: 50%; object-fit: cover; border: 3px solid rgba(255,255,255,.35); display: block; }
    .profile-avatar-fallback { width: 88px; height: 88px; border-radius: 50%; background: rgba(255,255,255,.2); border: 3px solid rgba(255,255,255,.35); display: flex; align-items: center; justify-content: center; font-size: 30px; font-weight: 600; color: #fff; letter-spacing: 1px; }
    .profile-name { font-size: 20px; font-weight: 700; color: #fff; margin: 0 0 4px; }
    .profile-role-badge { display: inline-flex; align-items: center; gap: 5px; background: rgba(255,255,255,.18); color: rgba(255,255,255,.9); font-size: 11.5px; font-weight: 600; letter-spacing: .05em; padding: 3px 12px; border-radius: 99px; border: 0.5px solid rgba(255,255,255,.25); }
    .profile-body { background: #fff; border: 0.5px solid #e5e7eb; border-top: none; border-radius: 0 0 16px 16px; padding: 0 28px 28px; box-shadow: 0 4px 20px rgba(0,0,0,.07); }
    .profile-info-card { background: #f9fafb; border: 0.5px solid #e5e7eb; border-radius: 12px; overflow: hidden; margin-top: -24px; position: relative; z-index: 1; }
    .profile-info-row { display: flex; align-items: center; padding: 14px 18px; gap: 14px; }
    .profile-info-row + .profile-info-row { border-top: 0.5px solid #e5e7eb; }
    .profile-info-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; font-size: 13px; }
    .profile-info-icon.email { background: #eef2ff; color: #4f46e5; }
    .profile-info-icon.phone { background: #f0fdf4; color: #16a34a; }
    .profile-info-label { font-size: 11px; font-weight: 600; letter-spacing: .05em; text-transform: uppercase; color: #9ca3af; margin-bottom: 1px; }
    .profile-info-value { font-size: 13.5px; font-weight: 500; color: #111827; }
    .profile-actions { display: flex; gap: 10px; margin-top: 20px; }
    .profile-action-btn { flex: 1; display: inline-flex; align-items: center; justify-content: center; gap: 8px; padding: 10px 16px; border-radius: 9px; font-size: 13px; font-weight: 600; text-decoration: none; transition: all .15s; border: none; cursor: pointer; }
    .profile-action-btn.primary { background: #4f46e5; color: #fff; }
    .profile-action-btn.primary:hover { background: #4338ca; }
    .profile-action-btn.secondary { background: #f3f4f6; color: #374151; border: 0.5px solid #e5e7eb; }
    .profile-action-btn.secondary:hover { background: #e5e7eb; }
    .profile-section-label { font-size: 11px; font-weight: 700; letter-spacing: .07em; text-transform: uppercase; color: #9ca3af; margin: 22px 0 10px; }

    /* Password modal */
    .pw-modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.45); z-index: 50; display: flex; align-items: center; justify-content: center; padding: 16px; }
    .pw-modal-box { background: #fff; border-radius: 14px; padding: 28px; width: 100%; max-width: 400px; position: relative; box-shadow: 0 20px 60px rgba(0,0,0,.15); }
    .pw-modal-close { position: absolute; top: 14px; right: 14px; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; border-radius: 6px; background: #f3f4f6; border: none; cursor: pointer; color: #6b7280; }
    .pw-modal-close:hover { background: #e5e7eb; }
    .pw-form-group { margin-bottom: 14px; }
    .pw-form-group label { display: block; font-size: 11.5px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; color: #6b7280; margin-bottom: 6px; }
    .pw-form-group input { width: 100%; height: 38px; padding: 0 12px; border: 0.5px solid #d1d5db; border-radius: 8px; font-size: 13.5px; color: #111827; outline: none; box-sizing: border-box; transition: border .15s, box-shadow .15s; }
    .pw-form-group input:focus { border-color: #6366f1; box-shadow: 0 0 0 3px rgba(99,102,241,.1); }
    .pw-strength { height: 3px; border-radius: 99px; background: #e5e7eb; margin-top: 6px; overflow: hidden; }
    .pw-strength-fill { height: 100%; border-radius: 99px; width: 0; transition: width .3s, background .3s; }
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
                <span class="ml-4 text-sm font-medium text-gray-500">My Account</span>
            </div>
        </li>
    </ol>
</nav>

<?php
    $initials = strtoupper(substr($user->name ?? '', 0, 1) . substr($user->surname ?? '', 0, 1));
    $roleLabel = match((int)$user->id_role) {
        1 => 'Administrator',
        2 => 'Agent',
        3 => 'Supervisor',
        default => 'User',
    };
    $roleIcon = match((int)$user->id_role) {
        1 => 'fa-solid fa-shield-halved',
        3 => 'fa-solid fa-user-tie',
        default => 'fa-solid fa-user',
    };
?>

<div
    class="profile-card"
    x-data="{ openPw: false, pw: '', pwStrength: 0, pwColor: '#e5e7eb',
        calcStrength(v) {
            let s = 0;
            if (v.length >= 8) s++;
            if (/[A-Z]/.test(v)) s++;
            if (/[0-9]/.test(v)) s++;
            if (/[^A-Za-z0-9]/.test(v)) s++;
            this.pwStrength = s * 25;
            this.pwColor = ['#e5e7eb','#ef4444','#f59e0b','#22c55e','#16a34a'][s];
        }
    }"
>
    <!-- Card header with gradient -->
    <div class="profile-header">
        <div class="profile-avatar-wrap">
            <?php if (!empty($user->avatar)) : ?>
                <img src="<?= h($user->avatar) ?>" alt="Profile photo" class="profile-avatar-img" />
            <?php else : ?>
                <div class="profile-avatar-fallback"><?= h($initials ?: '?') ?></div>
            <?php endif; ?>
        </div>
        <div class="profile-name"><?= h($user->name) ?> <?= h($user->surname) ?></div>
        <div style="margin-top: 8px;">
            <span class="profile-role-badge">
                <i class="<?= $roleIcon ?>"></i>
                <?= $roleLabel ?>
            </span>
        </div>
    </div>

    <!-- Card body -->
    <div class="profile-body">

        <!-- Info rows -->
        <div class="profile-info-card">
            <div class="profile-info-row">
                <div class="profile-info-icon email">
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div>
                    <div class="profile-info-label">Email</div>
                    <div class="profile-info-value">
                        <a href="mailto:<?= h($user->email) ?>" style="color:#4f46e5; text-decoration: none;">
                            <?= h($user->email) ?>
                        </a>
                    </div>
                </div>
            </div>
            <div class="profile-info-row">
                <div class="profile-info-icon phone">
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div>
                    <div class="profile-info-label">Phone</div>
                    <div class="profile-info-value"><?= h($user->phonenumber) ?: '—' ?></div>
                </div>
            </div>
        </div>

        <!-- Actions (only for roles 1 & 3) -->
        <?php if ($user->id_role == 1 || $user->id_role == 3) : ?>
            <div class="profile-section-label">Account settings</div>
            <div class="profile-actions">
                <button
                    type="button"
                    class="profile-action-btn primary"
                    @click="openPw = true"
                >
                    <i class="fa-solid fa-key" style="font-size:12px;"></i>
                    Change Password
                </button>
                <a
                    href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]) ?>"
                    class="profile-action-btn secondary"
                >
                    <i class="fa-solid fa-pen-to-square" style="font-size:12px;"></i>
                    Edit Profile
                </a>
            </div>
        <?php endif; ?>
    </div>


    <!-- Change Password Modal -->
    <?php if ($user->id_role == 1 || $user->id_role == 3) : ?>
    <template x-teleport="body">
        <div
            x-show="openPw"
            class="pw-modal-overlay"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @keydown.escape.window="openPw = false"
            style="display:none;"
        >
            <div
                class="pw-modal-box"
                @click.away="openPw = false"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
            >
                <button class="pw-modal-close" @click="openPw = false" type="button">
                    <i class="fa-solid fa-xmark" style="font-size:13px;"></i>
                </button>

                <div class="flex items-center gap-3 mb-5">
                    <div style="width:36px;height:36px;border-radius:9px;background:#eef2ff;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-lock" style="color:#4f46e5;font-size:14px;"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-gray-900">Change Password</h3>
                        <p class="text-xs text-gray-400 mt-0.5">Choose a strong, unique password.</p>
                    </div>
                </div>

                <?= $this->Form->create(null, ['url' => ['controller' => 'Users', 'action' => 'changePassword', $user->id]]) ?>
                    <div class="pw-form-group">
                        <label>Current Password</label>
                        <input type="password" name="current_password" placeholder="••••••••" required />
                    </div>
                    <div class="pw-form-group">
                        <label>New Password</label>
                        <input
                            type="password"
                            name="new_password"
                            placeholder="••••••••"
                            x-model="pw"
                            @input="calcStrength(pw)"
                            required
                        />
                        <div class="pw-strength">
                            <div class="pw-strength-fill" :style="{ width: pwStrength + '%', background: pwColor }"></div>
                        </div>
                        <p class="text-xs mt-1" :style="{ color: pwColor }" x-text="['', 'Weak', 'Fair', 'Good', 'Strong'][Math.round(pwStrength / 25)]"></p>
                    </div>
                    <div class="pw-form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="confirm_password" placeholder="••••••••" required />
                    </div>
                    <div class="flex gap-3 mt-5">
                        <button type="button" @click="openPw = false" class="flex-1 rounded-lg border border-gray-200 bg-white py-2.5 text-sm font-medium text-gray-600 hover:bg-gray-50 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 rounded-lg bg-indigo-600 py-2.5 text-sm font-semibold text-white hover:bg-indigo-500 transition-colors">
                            Update Password
                        </button>
                    </div>
                <?= $this->Form->end() ?>
            </div>
        </div>
    </template>
    <?php endif; ?>

</div>