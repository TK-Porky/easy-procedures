<?php
return [
    'inputContainer' => '<div class="mb-4">{{content}}</div>',
    'inputContainerError' => '<div class="mb-4">{{content}}{{error}}</div>',
    'label' => '<label class="block text-sm font-medium leading-6 text-gray-900 mb-1" {{attrs}}>{{text}}</label>',
    'input' => '<input type="{{type}}" name="{{name}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" {{attrs}}/>',
    'textarea' => '<textarea name="{{name}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" {{attrs}}>{{value}}</textarea>',
    'select' => '<select name="{{name}}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" {{attrs}}>{{content}}</select>',
    'error' => '<div class="mt-1 text-sm text-red-600">{{content}}</div>',
    'submitContainer' => '<div class="mt-6">{{content}}</div>',
];
