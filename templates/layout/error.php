<!DOCTYPE html>
<html lang="en" class="h-full bg-white">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?= $this->Html->css(['app']) ?>
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <main class="grid min-h-full place-items-center bg-white px-6 py-24 sm:py-32 lg:px-8">
        <div class="text-center">
            <?= $this->fetch('content') ?>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="<?= $this->Url->build('/') ?>" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go back home</a>
                <a href="javascript:history.back()" class="text-sm font-semibold text-gray-900">Go back <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </main>
</body>
</html>
