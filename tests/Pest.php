<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

use BaseCodeOy\Lighty\Lighty;
use BaseCodeOy\Lighty\Parser\DocumentParser;

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

uses(
    Tests\TestCase::class,
    Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

uses(
    Tests\TestCase::class,
)->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

function fixture(string $file): string
{
    return \file_get_contents("tests/Fixtures/{$file}");
}

function fixtureArray(string $file): array
{
    return \json_decode(\file_get_contents("tests/Fixtures/{$file}"), true, 512, \JSON_THROW_ON_ERROR);
}

function assertMatchesDocumentSnapshot(string $code): void
{
    expect((new DocumentParser())->parse($code)->toArray())->toMatchSnapshot();
}

function assertMatchesShikiSnapshot(string $code): void
{
    $document = (new DocumentParser())->parse($code);
    $document->setLanguage('php');
    $document->setTheme('nord');

    expect(Lighty::highlight($document))->toMatchSnapshot();
}
