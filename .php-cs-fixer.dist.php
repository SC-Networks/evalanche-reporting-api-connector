<?php

declare(strict_types=1);

$config = (new PhpCsFixer\Config())
    ->setUnsupportedPhpVersionAllowed(true)
    ->setRules(
        [
            '@PSR12' => true,
            'array_syntax' => ['syntax' => 'short'],
            'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline', 'keep_multiple_spaces_after_comma' => false],
        ]
    )->setFinder(
        PhpCsFixer\Finder::create()
            ->in(['src', 'tests'])
    )
;

return $config;
