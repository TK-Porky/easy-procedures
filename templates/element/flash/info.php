<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div x-data="{ show: true }" x-show="show"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-y-2"
     x-transition:enter-end="opacity-100 translate-y-0"
     class="alert-info mb-4">
    <i class="fa-solid fa-circle-info text-blue-400 flex-shrink-0 mt-0.5"></i>
    <p class="flex-1 text-sm font-medium"><?= $message ?></p>
    <button @click="show = false" type="button" class="flex-shrink-0 text-blue-400 hover:text-blue-600 transition-colors">
        <i class="fa-solid fa-xmark"></i>
    </button>
</div>
