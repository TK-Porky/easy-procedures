<?php $this->assign('title', 'Client Portal - Sign Up'); ?>

<div class="mb-8 text-center">
    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/10 mb-4">Client</span>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Créer votre compte</h2>
</div>

<?= $this->Form->create($user, ['class' => 'space-y-4']); ?>
    <?= $this->Form->control('surname', [
        'label' => ['text' => 'Nom', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <?= $this->Form->control('name', [
        'label' => ['text' => 'Prénom', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <?= $this->Form->control('email', [
        'type' => 'email', 
        'label' => ['text' => 'Email address', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <?= $this->Form->control('password', [
        'type' => 'password',
        'label' => ['text' => 'Password', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <?= $this->Form->control('confirm-password', [
        'type' => 'password',
        'label' => ['text' => 'Confirm Password', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <div class="pt-2">
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
            S'inscrire
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Déjà un compte ?
    <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'login']) ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Se connecter</a>
</p>

<div class="mt-6 text-center">
    <a href="<?= $this->Url->build('/') ?>" class="text-sm font-medium text-gray-600 hover:text-gray-500">
        &larr; Retour à l'accueil
    </a>
</div>
