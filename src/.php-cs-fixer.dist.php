
<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'bootstrap/cache',
        'storage',
        'vendor',
    ])
    ->name('*.php');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,

        // Posicionamento das chaves
        'braces_position' => [
            'classes_opening_brace' => 'same_line',
            'functions_opening_brace' => 'same_line',
            'control_structures_opening_brace' => 'same_line',
        ],

        // Espaçamento entre argumentos e parâmetros
        'method_argument_space' => [
            'on_multiline' => 'ensure_fully_multiline',
        ],

        // Arrays com sintaxe curta
        'array_syntax' => [
            'syntax' => 'short',
        ],

        // Vírgula no último elemento de arrays multilinha
        'trailing_comma_in_multiline' => [
            'elements' => ['arrays'],
        ],

        // Remove use's de classe não utilizadas
        'no_unused_imports' => true,
    ])
    ->setFinder($finder)
    ->setCacheFile(__DIR__ . '/.php-cs-fixer.cache');
