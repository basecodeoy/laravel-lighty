<?php

declare(strict_types=1);

namespace BaseCodeOy\Lighty\Annotation;

use BaseCodeOy\Lighty\Model\Line;

final class LinkifyAnnotation extends AbstractAnnotation
{
    public function shouldAct(string $annotation): bool
    {
        return $annotation === 'linkify';
    }

    public function parse(Line $line, string $annotation, ?string $arguments): void
    {
        foreach ($this->parseRange($line->getOriginalNumber(), $arguments) as $lineNumber) {
            $this->findByNumber($lineNumber)->addModifier('linkify');
        }
    }
}
