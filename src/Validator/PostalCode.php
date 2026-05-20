<?php

namespace OHMedia\UtilityBundle\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

#[\Attribute]
class PostalCode extends Regex
{
    #[HasNamedArguments]
    public function __construct(
        string|array|null $pattern = null,
        ?string $message = null,
    ) {
        parent::__construct(
            pattern: '/^[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d$/',
            message: $message,
        );
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}
