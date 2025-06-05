<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SkillsBursaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Personal Information
            'applicant_surname' => 'required|string|max:255',
            'applicant_other_names' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'nationality' => 'nullable|string|max:100',
            'nrc_number' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date|before:today|after:1950-01-01',
            'place_of_birth' => 'nullable|string|max:255',

            // Location Information
            'ward_id' => 'required|exists:wards,id',
            'district' => 'required|string|max:255',
            'constituency' => 'required|string|max:255',
            'zone' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'mobile_phone' => 'required|string|max:20|regex:/^[0-9+\-\s()]+$/',
            'email' => 'nullable|email|max:255',

            // Vulnerability Status
            'orphan_status' => 'nullable|in:single_orphan,double_orphan,not_orphan,other',
            'is_disabled' => 'boolean',
            'disability_nature' => 'required_if:is_disabled,true|nullable|string|max:500',
            'financial_challenges' => 'nullable|string|max:1000',

            // Educational Background
            'is_school_leaver' => 'boolean',
            'last_grade_attended' => 'required_if:is_school_leaver,true|nullable|string|max:50',
            'last_school_attended' => 'required_if:is_school_leaver,true|nullable|string|max:255',
            'last_school_district' => 'nullable|string|max:255',
            'school_from_date' => 'nullable|date',
            'school_to_date' => 'nullable|date|after_or_equal:school_from_date',
            'highest_certificate' => 'nullable|string|max:255',

            // Institution Details
            'has_acceptance_letter' => 'required|boolean',
            'institution_name' => 'required|string|max:255',
            'programme_of_study' => 'required|string|max:255',
            'programme_duration' => 'required|string|max:100',

            // Previous Support
            'received_previous_scholarship' => 'boolean',
            'previous_scholarship_details' => 'required_if:received_previous_scholarship,true|nullable|string|max:1000',
            'received_previous_cdf_bursary' => 'boolean',
            'previous_cdf_details' => 'required_if:received_previous_cdf_bursary,true|nullable|string|max:1000',

            // Family Members
            'family_members' => 'required|array|min:1|max:5',
            'family_members.*.relationship' => 'required|in:father,mother,guardian',
            'family_members.*.vital_status' => 'required|in:alive,deceased',
            'family_members.*.surname' => 'required|string|max:255',
            'family_members.*.first_name' => 'required|string|max:255',
            'family_members.*.other_names' => 'nullable|string|max:255',
            'family_members.*.gender' => 'nullable|in:male,female',
            'family_members.*.occupation' => 'nullable|string|max:255',
            'family_members.*.employer_name' => 'nullable|string|max:255',
            'family_members.*.mobile_phone' => 'nullable|string|max:20',
            'family_members.*.has_disability' => 'boolean',
            'family_members.*.disability_nature' => 'nullable|string|max:500',

            // Siblings/Dependents
            'siblings' => 'nullable|array|max:10',
            'siblings.*.name' => 'required|string|max:255',
            'siblings.*.sex' => 'required|in:male,female',
            'siblings.*.age' => 'required|integer|min:0|max:100',
            'siblings.*.is_in_school' => 'boolean',
            'siblings.*.education_supporter' => 'nullable|string|max:255',

            // Housing Information
            'housing.ownership_type' => 'nullable|in:owned,rented,inherited,sublet,other',
            'housing.roof_material' => 'nullable|string',
            'housing.floor_material' => 'nullable|string',
            'housing.wall_material' => 'nullable|string',
            'housing.toilet_location' => 'nullable|in:inside_house,outside_house',
            'housing.water_source' => 'nullable|string',
            'housing.has_electricity' => 'boolean',
            'housing.meals_per_day' => 'nullable|integer|min:1|max:5',

            // Assets
            'assets.cattle_count' => 'nullable|integer|min:0|max:1000',
            'assets.goats_count' => 'nullable|integer|min:0|max:1000',
            'assets.poultry_count' => 'nullable|integer|min:0|max:1000',
            'assets.has_tractor' => 'boolean',
            'assets.has_car_truck' => 'boolean',

            // Economic Profile
            'economic.household_size' => 'nullable|integer|min:1|max:50',
            'economic.estimated_monthly_income' => 'nullable|numeric|min:0|max:100000',
            'economic.has_savings' => 'boolean',
            'economic.has_debt' => 'boolean',

            // Documents
            'documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'applicant_surname.required' => 'Surname is required.',
            'applicant_other_names.required' => 'Other names are required.',
            'date_of_birth.before' => 'Date of birth must be before today.',
            'date_of_birth.after' => 'Date of birth must be after 1950.',
            'ward_id.required' => 'Please select your ward.',
            'ward_id.exists' => 'Selected ward is invalid.',
            'mobile_phone.required' => 'Phone number is required for SMS updates.',
            'mobile_phone.regex' => 'Please enter a valid phone number.',
            'institution_name.required' => 'Institution name is required.',
            'programme_of_study.required' => 'Programme of study is required.',
            'family_members.required' => 'At least one family member is required.',
            'family_members.min' => 'At least one family member must be provided.',
            'family_members.*.relationship.required' => 'Family member relationship is required.',
            'family_members.*.relationship.in' => 'Family member relationship must be father, mother, or guardian.',
            'documents.*.mimes' => 'Documents must be PDF, JPG, JPEG, or PNG files.',
            'documents.*.max' => 'Each document must not exceed 5MB.',
        ];
    }

    public function attributes(): array
    {
        return [
            'applicant_surname' => 'surname',
            'applicant_other_names' => 'other names',
            'date_of_birth' => 'date of birth',
            'ward_id' => 'ward',
            'mobile_phone' => 'phone number',
            'institution_name' => 'institution name',
            'programme_of_study' => 'programme of study',
            'family_members' => 'family members',
        ];
    }
}
