<?php $this->assign('title', 'Client Portal - Mot de passe oublié'); ?>

<div class="mb-8 text-center">
    <span class="inline-flex items-center rounded-md bg-indigo-50 px-2 py-1 text-xs font-medium text-indigo-700 ring-1 ring-inset ring-indigo-600/10 mb-4">Client</span>
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Mot de passe oublié</h2>
    <p class="mt-2 text-sm text-gray-500">Entrez votre adresse email et nous vous enverrons un lien de réinitialisation.</p>
</div>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('email', [
        'type' => 'email',
        'label' => ['text' => 'Adresse email', 'class' => 'block text-sm font-medium leading-6 text-gray-900'],
        'required' => true,
        'placeholder' => 'votre@email.com',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 transition-colors">
            <i class="fa-solid fa-paper-plane mr-2"></i> Envoyer le lien de réinitialisation
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Vous vous souvenez de votre mot de passe ?
    <a href="<?= $this->Url->build(['prefix' => 'Client', 'controller' => 'Auth', 'action' => 'login']) ?>" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Se connecter</a>
</p>

<div class="mt-6 text-center">
    <a href="<?= $this->Url->build('/') ?>" class="text-sm font-medium text-gray-600 hover:text-gray-500">
        &larr; Retour à l'accueil
    </a>
</div>
