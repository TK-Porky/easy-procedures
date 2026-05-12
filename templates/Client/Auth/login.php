<?php $this->assign('title', 'Client Portal - Sign In'); ?>

<div class="mb-8 text-center">
    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/10 mb-4">Client</span>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Espace Client</h2>
</div>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => ['text' => 'Email address', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'placeholder' => 'client@example.com',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <?= $this->Form->control('password', [
        'type' => 'password',
        'label' => ['text' => 'Password', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'placeholder' => '••••••••',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600">
            <label for="remember-me" class="ml-3 block text-sm leading-6 text-gray-700">Se souvenir de moi</label>
        </div>

        <div class="text-sm leading-6">
            <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'forgetpassword']) ?>" class="font-semibold text-indigo-600 hover:text-indigo-500">Mot de passe oublié ?</a>
        </div>
    </div>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
            Se connecter
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Pas encore de compte ?
    <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'register']) ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Créer un compte</a>
</p>

<div class="mt-6 text-center">
    <a href="<?= $this->Url->build('/') ?>" class="text-sm font-medium text-gray-600 hover:text-gray-500">
        &larr; Retour à l'accueil
    </a>
</div>
