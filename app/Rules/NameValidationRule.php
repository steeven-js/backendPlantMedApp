<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NameValidationRule implements ValidationRule {

  public function validate(string $attribute, mixed $value, Closure $fail): void {

    if (empty($value)) {
      $fail("The $attribute field is required.");
    }

    if (!is_string($value)) {
      $fail("The $attribute must be a string.");
    }

    $length = mb_strlen($value);
    if ($length < 3 || $length > 255) {
      $fail("The $attribute must be between 3 and 255 characters.");
    }

    if (!preg_match('/^[\pL\s\-%#!\d()&]+$/u', $value)) {
      $fail("The $attribute may only contain letters, spaces, hyphens, percentage signs, digits, exclamation marks, hash signs, parentheses, and ampersand.");
    }
  }
}
