<?php
/**
 * @var \App\View\AppView $this
 * @var \Cake\Database\StatementInterface $error
 * @var string $message
 * @var string $url
 */
use Cake\Core\Configure;

$this->layout = 'error';
$this->assign('title', $message);
?>
<p class="text-base font-semibold text-indigo-600">404</p>
<h1 class="mt-4 text-3xl font-bold tracking-tight text-gray-900 sm:text-5xl"><?= h($message) ?></h1>
<p class="mt-6 text-base leading-7 text-gray-600">Sorry, we couldn’t find the page you’re looking for.</p>

<?php if (Configure::read('debug')) : ?>
    <div class="mt-10 text-left bg-gray-50 p-4 rounded-lg overflow-auto max-w-2xl mx-auto">
        <p class="text-xs font-mono text-gray-500 mb-2">Debug Info:</p>
        <p class="text-sm font-mono"><strong>URL:</strong> <?= h($url) ?></p>
        <?php if (!empty($error->queryString)) : ?>
            <p class="text-sm font-mono mt-2"><strong>SQL:</strong> <?= h($error->queryString) ?></p>
        <?php endif; ?>
    </div>
<?php endif; ?>
