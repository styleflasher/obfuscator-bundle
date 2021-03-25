<?php

namespace Styleflasher\ObfuscatorBundle\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class ObfuscatorExtension extends AbstractExtension
{
    /**
     * Returns a list of filters to add to the existing list.
     *
     * @return array An array of filters
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('obfuscateEmail', [EmailObfuscator::class, 'obfuscateEmail']),
        ];
    }
}
