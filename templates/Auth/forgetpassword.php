<?php $this->assign('title', 'Reset your password'); ?>

<p class="mb-6 text-sm text-gray-600">
    Enter your email address and we'll send you a link to reset your password.
</p>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => 'Email address',
        'required' => true,
        'placeholder' => 'you@example.com'
    ]) ?>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Send reset link
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Remember your password?
    <a href="<?= $this->Url->build('/login') ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Back to sign in</a>
</p>
