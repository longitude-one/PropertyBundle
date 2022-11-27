<?php

$header = file_get_contents(__DIR__ . '/../headers.txt');
$header = str_replace("%year%", date('Y'), $header);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/../../PropertyBundle/',
    ])
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'header_comment' => [
        'header' => $header,
        'comment_type' => 'PHPDoc'
    ],
    'ordered_class_elements' => [
        'order' => [
            'use_trait',
            'constant_public', 'constant_protected', 'constant_private', 'constant',
            'property_public_static', 'property_protected_static', 'property_private_static', 'property_static',
            'property_public', 'property_protected', 'property_private', 'property',
            'construct', 'destruct',
            'phpunit',
            'method_public_static', 'method_protected_static', 'method_private_static', 'method_static',
            'method_public', 'method_protected', 'method_private', 'method', 'magic',
        ],
        'sort_algorithm' => 'alpha',
    ],
    ])
    ->setFinder($finder)
;
