<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;

$this->layout = 'error';
$this->assign('title', 'Internal Server Error');
?>
<p class="text-base font-semibold text-red-600">500</p>
<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl">Server Error</h1>
<p class="mt-6 text-base leading-7 text-gray-600">Something went wrong on our end. Please try again later.</p>

<?php if (Configure::read('debug')) : ?>
    <div class="mt-10 text-left bg-gray-50 p-4 rounded-lg overflow-auto max-w-2xl mx-auto">
        <p class="text-xs font-mono text-gray-500 mb-2">Debug Info:</p>
        <p class="text-sm font-mono"><strong>Message:</strong> <?= h($message) ?></p>
        <p class="text-sm font-mono"><strong>URL:</strong> <?= h($url) ?></p>
        <?php if ($error instanceof Error) : ?>
            <p class="text-sm font-mono mt-2"><strong>File:</strong> <?= h($error->getFile()) ?>:<?= $error->getLine() ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
