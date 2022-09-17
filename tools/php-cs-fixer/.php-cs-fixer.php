<?php

$header = file_get_contents(__DIR__ . '/../headers.txt');
$header = str_replace("%year%", date('Y'), $header);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/../../src/',
        __DIR__ . '/../../tests/',
    ])
;

$config = new PhpCsFixer\Config();

return $config->setRules([
    '@Symfony' => true,
    'header_comment' => [
        'header' => $header,
        'comment_type' => 'PHPDoc'
    ]])
    ->setFinder($finder)
;
