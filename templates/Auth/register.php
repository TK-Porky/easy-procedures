<?php $this->assign('title', 'Create your account'); ?>

<?= $this->Form->create($user, ['class' => 'space-y-6', 'url' => ['controller' => 'Auth', 'action' => 'register']]); ?>
    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
        <?= $this->Form->control('name', [
            'type' => 'text', 
            'label' => 'Name*', 
            'placeholder' => 'First name',
            'required' => true
        ]) ?>
        
        <?= $this->Form->control('surname', [
            'type' => 'text', 
            'label' => 'Surname*', 
            'placeholder' => 'Last name',
            'required' => true
        ]) ?>
    </div>

    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => 'Email address*', 
        'placeholder' => 'you@example.com',
        'required' => true
    ]) ?>

    <?= $this->Form->control('phonenumber', [
        'type' => 'text', 
        'label' => 'Phone number*', 
        'placeholder' => '+1 (555) 000-0000',
        'required' => true
    ]) ?>

    <div class="grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-2">
        <?= $this->Form->control('password', [
            'type' => 'password', 
            'label' => 'Password*', 
            'placeholder' => '••••••••',
            'required' => true
        ]) ?>

        <?= $this->Form->control('confirm-password', [
            'type' => 'password', 
            'label' => 'Confirm password*', 
            'placeholder' => '••••••••',
            'required' => true
        ]) ?>
    </div>

    <div class="flex items-center">
        <?= $this->Form->checkbox('agree_terms', ['id' => 'agree-terms', 'class' => 'h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600', 'required' => true]) ?>
        <label for="agree-terms" class="ml-3 block text-sm leading-6 text-gray-700">
            I agree to the <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">terms and policy</a>
        </label>
    </div>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Create account
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Already have an account?
    <a href="<?= $this->Url->build('/login') ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Sign in</a>
</p>
