<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifyRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'otp_code' => $this->convertNumbersToEnglish($this->otp_code),
        ]);
    }

    protected function convertNumbersToEnglish($string)
    {
        $newNumbers = range(0, 9);
        $persianNumbers = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabicNumbers = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $string = str_replace($persianNumbers, $newNumbers, $string);
        $string = str_replace($arabicNumbers, $newNumbers, $string);

        return $string;
    }

    public function rules()
    {
        return [
            'identity' => ['required', 'string'],
            'otp_code' => ['required', 'string', 'numeric'],
        ];
    }
}
