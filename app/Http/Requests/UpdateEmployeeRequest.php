<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'numeric', 'min:10'],
            'dob' => [
                'required',
                function ($attribute, $value, $fail) {
                    $dob = Carbon::parse($value);

                    // Calculate the minimum age requirement (18 years)
                    $minAge = Carbon::now()->subYears(18);

                    // Check if the date of birth is at least 18 years before the current date
                    if ($dob->gt($minAge)) {
                        $fail('Employee / Customer should be above 18+');
                    }
                }
            ],
            'gender' => 'required|string|in:' . GENDER_MALE . ',' . GENDER_FEMALE,
            'address' => 'nullable',
            'status' => 'required|string|in:' . STATUS_ACTIVE . ',' . STATUS_INACTIVE,
        ];
    }
}
