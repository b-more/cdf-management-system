<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SecondaryBursaryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // All skills bursary rules plus secondary-specific
            'applicant_surname' => 'required|string|max:255',
            'applicant_other_names' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today|after:2000-01-01', // More recent for secondary students
            'ward_id' => 'required|exists:wards,id',
            'mobile_phone' => 'required|string|max:20',

            // Secondary-specific fields
            'current_grade' => 'required|in:8,9,10,11,12',
            'current_school' => 'required|string|max:255',
            'is_boarder' => 'required|boolean',
            'boarding_fees_payer' => 'nullable|string|max:255',
            'previous_support_organization' => 'nullable|string|max:255',

            // More comprehensive family information required
            'family_members' => 'required|array|min:1|max:10',
            'family_members.*.relationship' => 'required|in:father,mother,guardian',
            'family_members.*.vital_status' => 'required|in:alive,deceased',
            'family_members.*.surname' => 'required|string|max:255',
            'family_members.*.first_name' => 'required|string|max:255',
            'family_members.*.occupation' => 'nullable|string|max:255',
            'family_members.*.employer_name' => 'nullable|string|max:255',
            'family_members.*.position_rank' => 'nullable|string|max:255',
            'family_members.*.employer_address' => 'nullable|string|max:500',
            'family_members.*.has_disability' => 'boolean',
            'family_members.*.has_medical_condition' => 'boolean',
            'family_members.*.village' => 'nullable|string|max:255',
            'family_members.*.chief' => 'nullable|string|max:255',
            'family_members.*.district' => 'nullable|string|max:255',

            // Detailed siblings information
            'siblings' => 'nullable|array|max:15',
            'siblings.*.name' => 'required|string|max:255',
            'siblings.*.sex' => 'required|in:male,female',
            'siblings.*.age' => 'required|integer|min:0|max:100',
            'siblings.*.occupation' => 'nullable|string|max:255',
            'siblings.*.vital_status' => 'required|in:alive,deceased',
            'siblings.*.is_in_school' => 'boolean',
            'siblings.*.school_name' => 'nullable|string|max:255',
            'siblings.*.grade_level' => 'nullable|string|max:50',
            'siblings.*.education_supporter' => 'nullable|string|max:255',

            // Comprehensive housing assessment
            'housing.ownership_type' => 'required|in:owned,rented,inherited,sublet,other',
            'housing.roof_material' => 'required|in:asbestos_sheets,asbestos_tiles,other_non_asbestos_tile,iron_sheets,grass_wood_thatch,concrete',
            'housing.floor_material' => 'required|in:earth_sand,wood_planks,palm_bamboo,finished_floor_wood_tiles,concrete,vinyl',
            'housing.wall_material' => 'required|in:natural_walls_mud_cane,rudimentary_walls_stone_bamboo,finished_walls_bricks_cement',
            'housing.toilet_location' => 'required|in:inside_house,outside_house',
            'housing.water_source' => 'required|in:piped,well,shallow_well,other',
            'housing.water_availability' => 'required|in:communal,own_premises',
            'housing.has_electricity' => 'required|boolean',
            'housing.meals_per_day' => 'required|integer|min:1|max:5',
            'housing.main_income_source' => 'nullable|string|max:255',

            // Comprehensive asset ownership
            'assets.has_tractor' => 'required|boolean',
            'assets.has_plough' => 'required|boolean',
            'assets.has_hammer_mill' => 'required|boolean',
            'assets.has_car_truck' => 'required|boolean',
            'assets.cattle_count' => 'required|integer|min:0',
            'assets.goats_count' => 'required|integer|min:0',
            'assets.sheep_count' => 'required|integer|min:0',
            'assets.pigs_count' => 'required|integer|min:0',
            'assets.poultry_count' => 'required|integer|min:0',
            'assets.has_radio' => 'required|boolean',
            'assets.has_television' => 'required|boolean',
            'assets.has_mobile_phone' => 'required|boolean',
            'assets.has_computer' => 'required|boolean',
            'assets.has_refrigerator' => 'required|boolean',

            // Comprehensive economic profile
            'economic.household_size' => 'required|integer|min:1',
            'economic.adults_count' => 'required|integer|min:1',
            'economic.children_count' => 'required|integer|min:0',
            'economic.elderly_count' => 'required|integer|min:0',
            'economic.disabled_members_count' => 'required|integer|min:0',
            'economic.primary_income_source' => 'nullable|string|max:255',
            'economic.estimated_monthly_income' => 'nullable|numeric|min:0',
            'economic.income_is_regular' => 'required|boolean',
            'economic.income_reliability' => 'required|in:very_reliable,reliable,unreliable,very_unreliable',
            'economic.has_savings' => 'required|boolean',
            'economic.has_debt' => 'required|boolean',
            'economic.can_afford_emergency_expense' => 'required|boolean',
            'economic.receives_social_support' => 'required|boolean',
            'economic.receives_remittances' => 'required|boolean',

            // Document requirements (more comprehensive)
            'birth_certificate' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'death_certificates.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'pay_slips.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'medical_records.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'disability_cards.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'recommendation_letters.*' => 'required|array|min:2',
            'recommendation_letters.*.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120',
            'school_acceptance' => 'required|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'educational_certificates.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'current_grade.required' => 'Current grade level is required.',
            'current_grade.in' => 'Grade must be between 8 and 12.',
            'current_school.required' => 'Current school name is required.',
            'is_boarder.required' => 'Please specify if you are a boarder.',
            'housing.ownership_type.required' => 'House ownership type is required.',
            'housing.roof_material.required' => 'Roof material information is required.',
            'housing.floor_material.required' => 'Floor material information is required.',
            'housing.wall_material.required' => 'Wall material information is required.',
            'housing.toilet_location.required' => 'Toilet location information is required.',
            'housing.water_source.required' => 'Water source information is required.',
            'housing.has_electricity.required' => 'Electricity availability information is required.',
            'housing.meals_per_day.required' => 'Meals per day information is required.',
            'assets.*.required' => 'Asset ownership information is required.',
            'economic.household_size.required' => 'Household size is required.',
            'economic.income_reliability.required' => 'Income reliability information is required.',
            'birth_certificate.required' => 'Birth certificate is required.',
            'recommendation_letters.required' => 'At least 2 recommendation letters are required.',
            'recommendation_letters.min' => 'At least 2 recommendation letters must be provided.',
            'school_acceptance.required' => 'School acceptance letter is required.',
        ];
    }
}
