<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $this->identity = $this->convertNumbersToEnglish($this->identity);

        return [
            'identity' => [
                'required',
                function ($attribute, $value, $fail) {
                    $value = $this->convertNumbersToEnglish($value);
                    if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        return;
                    }
                    $phonePattern = '/^\+?[1-9]\d{1,14}$/';
                    if (preg_match($phonePattern, $value)) {
                        $numericValue = preg_replace('/\D/', '', $value);
                        $minLength = 10;
                        $maxLength = 15;
                        if (strlen($numericValue) < $minLength || strlen($numericValue) > $maxLength) {
                            $fail("The {$attribute} must be a valid mobile number with length between {$minLength} and {$maxLength} digits.");
                            return;
                        }
                        $uniqueDigits = count(array_unique(str_split($numericValue)));
                        if ($uniqueDigits <= 1) {
                            $fail("The {$attribute} cannot consist of the same digit repeated.");
                            return;
                        }
                    } else {
                        $fail("The {$attribute} must start with a '+' followed by the country code and be a valid mobile number.");
                        return;
                    }
                    $telegramPattern = '/^[a-zA-Z0-9_]{5,}$/';
                    if (preg_match($telegramPattern, $value)) {
                        return;
                    }
                }
            ],
        ];
    }


    function convertNumbersToEnglish($string)
    {
        $newNumbers = range(0, 9);
        $persianDecimal = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabicDecimal = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        $string = str_replace($persianDecimal, $newNumbers, $string);
        $string = str_replace($arabicDecimal, $newNumbers, $string);
        return $string;
    }

}
