<?php

namespace OHMedia\UtilityBundle\Validator;

use Symfony\Component\Validator\Attribute\HasNamedArguments;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\RegexValidator;

#[\Attribute]
class Phone extends Regex
{
    #[HasNamedArguments]
    public function __construct(
        string|array|null $pattern = null,
        ?string $message = null,
    ) {
        parent::__construct(
            pattern: '/^\d{3}-?\d{3}-?\d{4}$/',
            message: $message,
        );
    }

    public function validatedBy(): string
    {
        return RegexValidator::class;
    }
}
