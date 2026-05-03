<?php $this->assign('title', 'Verify your account'); ?>

<p class="mb-6 text-sm text-gray-600">
    Please enter the verification code sent to your email address.
</p>

<?= $this->Form->create(null, ['class' => 'space-y-6']); ?>
    <?= $this->Form->control('verification', [
        'type' => 'number', 
        'label' => 'Verification Code',
        'required' => true,
        'placeholder' => '123456',
        'class' => 'block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6'
    ]) ?>

    <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            Verify account
        </button>
    </div>
<?= $this->Form->end(); ?>

<p class="mt-10 text-center text-sm text-gray-500">
    Didn't receive a code?
    <a href="#" class="font-semibold leading-6 text-indigo-600 hover:text-indigo-500">Resend code</a>
</p>
