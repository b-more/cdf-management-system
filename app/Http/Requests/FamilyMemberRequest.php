<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FamilyMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'educational_bursary_id' => 'required|exists:educational_bursaries,id',
            'relationship' => 'required|in:father,mother,guardian',
            'vital_status' => 'required|in:alive,deceased',
            'surname' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'other_names' => 'nullable|string|max:255',
            'gender' => 'nullable|in:male,female',
            'date_of_birth' => 'nullable|date|before:today',
            'nationality' => 'nullable|string|max:100',
            'nrc_number' => 'nullable|string|max:50',
            'relationship_to_applicant' => 'nullable|string|max:255',

            // Location Information
            'village' => 'nullable|string|max:255',
            'chief' => 'nullable|string|max:255',
            'district' => 'nullable|string|max:255',
            'residential_address' => 'nullable|string|max:500',
            'constituency' => 'nullable|string|max:255',
            'province' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'mobile_phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',

            // Employment Details
            'occupation' => 'nullable|string|max:255',
            'employer_name' => 'nullable|string|max:255',
            'position_rank' => 'nullable|string|max:255',
            'employer_address' => 'nullable|string|max:500',

            // Health Information
            'has_disability' => 'boolean',
            'disability_nature' => 'required_if:has_disability,true|nullable|string|max:500',
            'has_medical_condition' => 'boolean',
            'medical_condition_details' => 'required_if:has_medical_condition,true|nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'educational_bursary_id.required' => 'Bursary application ID is required.',
            'educational_bursary_id.exists' => 'Invalid bursary application.',
            'relationship.required' => 'Relationship to applicant is required.',
            'relationship.in' => 'Relationship must be father, mother, or guardian.',
            'vital_status.required' => 'Vital status is required.',
            'vital_status.in' => 'Vital status must be alive or deceased.',
            'surname.required' => 'Surname is required.',
            'first_name.required' => 'First name is required.',
            'disability_nature.required_if' => 'Please describe the nature of disability.',
            'medical_condition_details.required_if' => 'Please provide medical condition details.',
        ];
    }
}
