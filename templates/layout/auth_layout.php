<!DOCTYPE html>
<html lang="fr" class="h-full">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?= $this->fetch('title') ?> — Easy Procedures</title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <?= $this->Html->css(['app']) ?>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
</head>
<body class="h-full font-sans antialiased bg-gray-50">

<div class="min-h-screen flex">

    <!-- ── Left branding panel (hidden on mobile) ───────────── -->
    <div class="hidden lg:flex lg:w-[45%] xl:w-[40%] flex-col justify-between relative overflow-hidden bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900">

        <!-- Background decorations -->
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 right-0 w-96 h-96 rounded-full bg-indigo-500 blur-3xl -translate-y-1/2 translate-x-1/2"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 rounded-full bg-violet-500 blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        </div>

        <div class="relative z-10 p-10 flex flex-col h-full">
            <!-- Logo -->
            <a href="<?= $this->Url->build('/') ?>" class="flex items-center gap-3 mb-auto">
                <img class="h-9 w-auto" src="<?= $this->Url->build('/template/images/icon/logo.png') ?>" alt="Easy Procedures">
                <span class="text-white font-semibold text-lg">Easy Procedures</span>
            </a>

            <!-- Main content -->
            <div class="my-auto">
                <div class="inline-flex items-center gap-2 rounded-full bg-white/10 px-3 py-1.5 mb-6 text-xs font-medium text-indigo-200">
                    <i class="fa-solid fa-shield-halved"></i>
                    Plateforme sécurisée
                </div>
                <h2 class="text-3xl xl:text-4xl font-bold text-white leading-tight mb-4">
                    Gérez vos procédures<br>
                    <span class="text-indigo-300">bancaires simplement.</span>
                </h2>
                <p class="text-slate-400 text-sm leading-relaxed mb-10">
                    Un espace unifié pour soumettre, suivre et valider toutes vos démarches administratives.
                </p>

                <!-- Features -->
                <ul class="space-y-4">
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-500/30 flex items-center justify-center">
                            <i class="fa-solid fa-check text-indigo-300 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Suivi en temps réel</p>
                            <p class="text-xs text-slate-400 mt-0.5">Consultez l'état de vos demandes à tout moment</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-500/30 flex items-center justify-center">
                            <i class="fa-solid fa-check text-indigo-300 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Documents sécurisés</p>
                            <p class="text-xs text-slate-400 mt-0.5">Vos fichiers sont chiffrés et protégés</p>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <div class="mt-0.5 flex-shrink-0 w-6 h-6 rounded-full bg-indigo-500/30 flex items-center justify-center">
                            <i class="fa-solid fa-check text-indigo-300 text-xs"></i>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-white">Traitement rapide</p>
                            <p class="text-xs text-slate-400 mt-0.5">Nos agents traitent vos dossiers en priorité</p>
                        </div>
                    </li>
                </ul>
            </div>

            <!-- Footer -->
            <p class="text-xs text-slate-600 mt-10">© 2026 Easy Procedures · Tous droits réservés</p>
        </div>
    </div>

    <!-- ── Right form panel ──────────────────────────────────── -->
    <div class="flex-1 flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16 xl:px-24">

        <!-- Mobile logo -->
        <div class="lg:hidden mb-8 flex items-center gap-3">
            <a href="<?= $this->Url->build('/') ?>">
                <img class="h-8 w-auto" src="<?= $this->Url->build('/template/images/icon/logo.png') ?>" alt="Easy Procedures">
            </a>
        </div>

        <div class="w-full max-w-sm mx-auto lg:mx-0">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>

</div>

<?= $this->fetch('script') ?>
</body>
</html>
