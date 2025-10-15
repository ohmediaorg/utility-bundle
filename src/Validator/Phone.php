<?php

namespace OHMedia\UtilityBundle\Validator;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

#[\Attribute]
class Phone extends Regex
{
    public function __construct(
        string|array|null $pattern = null,
        ?string $message = null,
        ?string $htmlPattern = null,
        ?bool $match = null,
        ?callable $normalizer = null,
        ?array $groups = null,
        mixed $payload = null,
        array $options = []
    ) {
        $options['pattern'] = $options['value'] = '/^\d{3}-?\d{3}-?\d{4}$/';

        parent::__construct($pattern, $message, $htmlPattern, $match, $normalizer, $groups, $payload, $options);
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}
