<?php $this->assign('title', 'Sign in to your account'); ?>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => 'Email address',
        'required' => true,
        'placeholder' => 'you@example.com'
    ]) ?>

    <?= $this->Form->control('password', [
        'type' => 'password',
        'label' => 'Password',
        'required' => true,
        'placeholder' => '••••••••'
    ]) ?>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <?= $this->Form->checkbox('remember_me', ['id' => 'remember-me', 'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600']) ?>
            <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Remember me</label>
        </div>

        <div class="text-sm leading-6">
            <a href="<?= $this->Url->build('/forgetpassword') ?>" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
        </div>
    </div>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Sign in
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Don't have an account?
    <a href="<?= $this->Url->build('/register') ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign up here</a>
</p>
