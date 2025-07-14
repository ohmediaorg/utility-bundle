<?php

namespace OHMedia\UtilityBundle\Validator;

use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

#[\Attribute]
class PostalCode extends Regex
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
        $options['pattern'] = $options['value'] = '/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/';

        parent::__construct($options, $groups, $payload);
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}
