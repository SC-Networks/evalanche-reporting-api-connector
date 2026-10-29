<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\AssertSameTrueFalseToAssertTrueFalseRector;
use Rector\PHPUnit\CodeQuality\Rector\MethodCall\UseSpecificWillMethodRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnCastRector;

return RectorConfig::configure()
    ->withPhpSets(php83: true)
    ->withPreparedSets(deadCode: true, codeQuality: true)
    ->withIndent(indentChar: "\t", indentSize:  1)
    ->withImportNames()
    ->withPaths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->withSets([
        PHPUnitSetList::COMPOSER_BASED,
    ])
    ->withRules([
        AssertSameTrueFalseToAssertTrueFalseRector::class,
        UseSpecificWillMethodRector::class,
        ReturnTypeFromReturnCastRector::class,
    ]);
