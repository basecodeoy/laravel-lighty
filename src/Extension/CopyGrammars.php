<?php declare(strict_types=1);

/**
 * Copyright (C) BaseCode Oy - All Rights Reserved
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

namespace BaseCodeOy\Lighty\Extension;

use Illuminate\Support\Facades\File;

final class CopyGrammars
{
    /**
     * @param array<Grammar> $grammars
     */
    public static function execute(Extension $extension, array $grammars): void
    {
        foreach ($grammars as $grammar) {
            File::ensureDirectoryExists(\pathinfo(Path::grammar($extension, $grammar), \PATHINFO_DIRNAME));

            File::put(
                Path::grammar($extension, $grammar),
                \json_encode([
                    'id' => $grammar->getLanguage(),
                    'scopeName' => 'source.'.$grammar->getLanguage(),
                    'grammar' => \json_decode(\file_get_contents($grammar->getPath()), true, 512, \JSON_THROW_ON_ERROR),
                    'aliases' => [$grammar->getLanguage()],
                ], \JSON_THROW_ON_ERROR | \JSON_PRETTY_PRINT),
            );
        }
    }
}
