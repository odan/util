<?php

return PhpCsFixer\Config::create()
    ->setUsingCache(false)
    ->setRiskyAllowed(true)
    //->setCacheFile(__DIR__ . '/.php_cs.cache')
    ->setRules([
        '@PSR1' => true,
        '@PSR2' => true,
        '@Symfony' => true,
        'psr4' => true,
        // custom rules
        'align_multiline_comment' => true, // psr-5
        'array_indentation' => true,
        'array_syntax' => ['syntax' => 'short'],
        'cast_spaces' => ['space' => 'none'],
        'concat_space' => ['spacing' => 'one'],
        'compact_nullable_typehint' => true,
        'declare_equal_normalize' => ['space' => 'single'],
        'general_phpdoc_annotation_remove' => [
            'annotations' => [
                'author',
                'package',
            ],
        ],
        'increment_style' => ['style' => 'post'],
        'list_syntax' => ['syntax' => 'long'],
        'no_short_echo_tag' => true,
        'phpdoc_add_missing_param_annotation' => ['only_untyped' => false],
        'phpdoc_align' => false,
        'phpdoc_no_empty_return' => false,
        'phpdoc_order' => true, // psr-5
        'phpdoc_no_useless_inheritdoc' => false,
        'protected_to_private' => false,
        'yoda_style' => false,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'ordered_imports' => [
            'sort_algorithm' => 'alpha',
            'imports_order' => ['class', 'const', 'function']
        ],
    ])
    ->setFinder(PhpCsFixer\Finder::create()
        ->in(__DIR__ . '/src')
        ->in(__DIR__ . '/tests')
        ->name('*.php')
        ->ignoreDotFiles(true)
        ->ignoreVCS(true));
