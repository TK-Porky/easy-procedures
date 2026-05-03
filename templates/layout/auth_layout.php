<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-50">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?= $this->Html->css(['app']) ?>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="h-full font-sans antialiased text-gray-900">
    <div class="flex flex-col justify-center min-h-full py-12 sm:px-6 lg:px-8">
        <div class="sm:mx-auto sm:w-full sm:max-w-md">
            <div class="flex justify-center">
                <a href="<?= $this->Url->build('/') ?>">
                    <img class="w-auto h-12" src="<?= $this->Url->build('/template/images/icon/logo.png') ?>" alt="Easy Procedures">
                </a>
            </div>
            <h2 class="mt-6 text-3xl font-bold tracking-tight text-center text-gray-900">
                <?= $this->fetch('title') ?>
            </h2>
        </div>

        <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
            <div class="px-4 py-8 bg-white shadow sm:rounded-lg sm:px-10">
                <div class="mb-6">
                    <?= $this->Flash->render() ?>
                </div>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </div>

    <?= $this->fetch('script') ?>
</body>
</html>
