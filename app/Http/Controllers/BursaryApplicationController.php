<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\EducationalBursary;
use App\Models\FamilyMember;
use App\Models\SiblingDependent;
use App\Models\VulnerabilityAssessment;
use App\Models\HousingAssessment;
use App\Models\AssetOwnership;
use App\Models\EconomicProfile;
use App\Models\Ward;
use App\Models\Document;
use App\Services\SmsService;
use App\Services\VulnerabilityScoreCalculator;

class BursaryApplicationController extends Controller
{
    protected $smsService;
    protected $vulnerabilityCalculator;

    public function __construct(SmsService $smsService, VulnerabilityScoreCalculator $vulnerabilityCalculator)
    {
        $this->smsService = $smsService;
        $this->vulnerabilityCalculator = $vulnerabilityCalculator;
    }

    /**
     * Show Skills Development Bursary Application Form
     */
    public function showSkillsForm()
    {
        $wards = Ward::orderBy('name')->get();

        return view('public.bursary.skills-application', compact('wards'));
    }

    /**
     * Show Secondary Boarding School Bursary Application Form
     */
    public function showSecondaryForm()
    {
        $wards = Ward::orderBy('name')->get();

        return view('public.bursary.secondary-application', compact('wards'));
    }

    /**
     * Submit Skills Development Bursary Application
     */
    public function submitSkillsApplication(Request $request)
    {
        // Comprehensive validation
        $validator = $this->validateSkillsApplication($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        DB::beginTransaction();

        try {
            // Generate unique bursary code
            $bursaryCode = EducationalBursary::generateBursaryCode('skills_development');

            // Create main bursary application
            $bursary = EducationalBursary::create([
                'bursary_code' => $bursaryCode,
                'bursary_type' => 'skills_development',
                'status' => 'submitted',
                'applicant_surname' => $request->applicant_surname,
                'applicant_other_names' => $request->applicant_other_names,
                'gender' => $request->gender,
                'nationality' => $request->nationality ?? 'Zambian',
                'nrc_number' => $request->nrc_number,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'ward_id' => $request->ward_id,
                'district' => $request->district,
                'constituency' => $request->constituency,
                'zone' => $request->zone,
                'postal_address' => $request->postal_address,
                'mobile_phone' => $request->mobile_phone,
                'email' => $request->email,
                'orphan_status' => $request->orphan_status,
                'is_disabled' => $request->boolean('is_disabled'),
                'disability_nature' => $request->disability_nature,
                'financial_challenges' => $request->financial_challenges,
                'is_school_leaver' => $request->boolean('is_school_leaver'),
                'last_grade_attended' => $request->last_grade_attended,
                'last_school_attended' => $request->last_school_attended,
                'last_school_district' => $request->last_school_district,
                'school_from_date' => $request->school_from_date,
                'school_to_date' => $request->school_to_date,
                'highest_certificate' => $request->highest_certificate,
                'has_acceptance_letter' => $request->boolean('has_acceptance_letter'),
                'institution_name' => $request->institution_name,
                'programme_of_study' => $request->programme_of_study,
                'programme_duration' => $request->programme_duration,
                'received_previous_scholarship' => $request->boolean('received_previous_scholarship'),
                'previous_scholarship_details' => $request->previous_scholarship_details,
                'received_previous_cdf_bursary' => $request->boolean('received_previous_cdf_bursary'),
                'previous_cdf_details' => $request->previous_cdf_details,
                'submission_date' => now(),
            ]);

            // Process family members
            $this->processFamilyMembers($request, $bursary->id);

            // Process siblings/dependents
            $this->processSiblingDependents($request, $bursary->id);

            // Create vulnerability assessment
            $vulnerabilityAssessment = $this->createVulnerabilityAssessment($request, $bursary);

            // Calculate vulnerability score
            $this->vulnerabilityCalculator->calculateTotalScore($vulnerabilityAssessment);

            // Process document uploads
            $this->processDocumentUploads($request, $bursary);

            // Send SMS confirmation
            $this->sendApplicationConfirmationSMS(
                $request->mobile_phone,
                $bursaryCode,
                'Skills Development Bursary',
                $vulnerabilityAssessment->vulnerability_level
            );

            DB::commit();

            return redirect()->route('bursary.success')
                ->with('success', "Your Skills Development Bursary application has been submitted successfully!")
                ->with('bursary_code', $bursaryCode)
                ->with('vulnerability_level', $vulnerabilityAssessment->vulnerability_level);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Skills Bursary Application Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error submitting your application. Please try again.');
        }
    }

    /**
     * Submit Secondary Boarding School Bursary Application
     */
    public function submitSecondaryApplication(Request $request)
    {
        // Comprehensive validation for secondary bursary
        $validator = $this->validateSecondaryApplication($request);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        DB::beginTransaction();

        try {
            // Generate unique bursary code
            $bursaryCode = EducationalBursary::generateBursaryCode('secondary_boarding');

            // Create main bursary application
            $bursary = EducationalBursary::create([
                'bursary_code' => $bursaryCode,
                'bursary_type' => 'secondary_boarding',
                'status' => 'submitted',
                'applicant_surname' => $request->applicant_surname,
                'applicant_other_names' => $request->applicant_other_names,
                'gender' => $request->gender,
                'nationality' => $request->nationality ?? 'Zambian',
                'nrc_number' => $request->nrc_number,
                'date_of_birth' => $request->date_of_birth,
                'place_of_birth' => $request->place_of_birth,
                'ward_id' => $request->ward_id,
                'district' => $request->district,
                'constituency' => $request->constituency,
                'zone' => $request->zone,
                'postal_address' => $request->postal_address,
                'mobile_phone' => $request->mobile_phone,
                'email' => $request->email,
                'orphan_status' => $request->orphan_status,
                'is_disabled' => $request->boolean('is_disabled'),
                'disability_nature' => $request->disability_nature,
                'financial_challenges' => $request->financial_challenges,
                'last_grade_attended' => $request->last_grade_attended,
                'last_school_attended' => $request->last_school_attended,
                'last_school_district' => $request->last_school_district,
                'has_acceptance_letter' => $request->boolean('has_acceptance_letter'),
                'institution_name' => $request->institution_name,
                'received_previous_scholarship' => $request->boolean('received_previous_scholarship'),
                'previous_scholarship_details' => $request->previous_scholarship_details,
                'submission_date' => now(),
            ]);

            // Process comprehensive family information
            $this->processComprehensiveFamilyData($request, $bursary->id);

            // Process detailed siblings/dependents information
            $this->processDetailedSiblingData($request, $bursary->id);

            // Create comprehensive vulnerability assessment
            $vulnerabilityAssessment = $this->createComprehensiveVulnerabilityAssessment($request, $bursary);

            // Calculate comprehensive vulnerability score
            $this->vulnerabilityCalculator->calculateComprehensiveScore($vulnerabilityAssessment);

            // Process comprehensive document uploads
            $this->processComprehensiveDocuments($request, $bursary);

            // Send SMS confirmation
            $this->sendApplicationConfirmationSMS(
                $request->mobile_phone,
                $bursaryCode,
                'Secondary Boarding School Bursary',
                $vulnerabilityAssessment->vulnerability_level
            );

            DB::commit();

            return redirect()->route('bursary.success')
                ->with('success', "Your Secondary Boarding School Bursary application has been submitted successfully!")
                ->with('bursary_code', $bursaryCode)
                ->with('vulnerability_level', $vulnerabilityAssessment->vulnerability_level);

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Secondary Bursary Application Error: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Sorry, there was an error submitting your application. Please try again.');
        }
    }

    /**
     * Check Bursary Application Status
     */
    public function checkApplicationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'search_term' => 'required|string',
            'search_type' => 'required|in:bursary_code,phone',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->with('error', 'Please provide valid search information.');
        }

        try {
            $query = EducationalBursary::query();

            if ($request->search_type === 'bursary_code') {
                $query->where('bursary_code', $request->search_term);
            } else {
                $query->where('mobile_phone', $request->search_term);
            }

            $applications = $query->with(['ward', 'familyMembers', 'vulnerabilityAssessment'])->get();

            if ($applications->isEmpty()) {
                return back()->with('error', 'No bursary applications found with the provided information.');
            }

            return view('public.bursary.status', compact('applications'));

        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error searching for your application. Please try again.');
        }
    }

    /**
     * Show Application Success Page
     */
    public function showSuccessPage()
    {
        return view('public.bursary.application-success');
    }

    /**
     * Download Application Documents
     */
    public function downloadDocument($bursaryId, $documentId)
    {
        try {
            $bursary = EducationalBursary::findOrFail($bursaryId);
            $document = $bursary->documents()->findOrFail($documentId);

            if (!file_exists(storage_path('app/' . $document->file_path))) {
                return back()->with('error', 'Document file not found.');
            }

            return response()->download(
                storage_path('app/' . $document->file_path),
                $document->title
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Error downloading document.');
        }
    }

    /**
     * Validate Skills Development Bursary Application
     */
    private function validateSkillsApplication(Request $request)
    {
        return Validator::make($request->all(), [
            // Personal Information
            'applicant_surname' => 'required|string|max:255',
            'applicant_other_names' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'nationality' => 'nullable|string|max:100',
            'nrc_number' => 'nullable|string|max:50',
            'date_of_birth' => 'required|date|before:today',
            'place_of_birth' => 'nullable|string|max:255',

            // Location Information
            'ward_id' => 'required|exists:wards,id',
            'district' => 'required|string|max:255',
            'constituency' => 'required|string|max:255',
            'zone' => 'nullable|string|max:255',
            'postal_address' => 'nullable|string|max:500',
            'mobile_phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',

            // Vulnerability Status
            'orphan_status' => 'nullable|in:single_orphan,double_orphan,not_orphan,other',
            'is_disabled' => 'boolean',
            'disability_nature' => 'nullable|string|max:500',
            'financial_challenges' => 'nullable|string|max:1000',

            // Educational Background
            'is_school_leaver' => 'boolean',
            'last_grade_attended' => 'nullable|string|max:50',
            'last_school_attended' => 'nullable|string|max:255',
            'last_school_district' => 'nullable|string|max:255',
            'school_from_date' => 'nullable|date',
            'school_to_date' => 'nullable|date|after_or_equal:school_from_date',
            'highest_certificate' => 'nullable|string|max:255',

            // Institution Details
            'has_acceptance_letter' => 'required|boolean',
            'institution_name' => 'required_if:has_acceptance_letter,true|string|max:255',
            'programme_of_study' => 'required|string|max:255',
            'programme_duration' => 'required|string|max:100',

            // Previous Support
            'received_previous_scholarship' => 'boolean',
            'previous_scholarship_details' => 'nullable|string|max:1000',
            'received_previous_cdf_bursary' => 'boolean',
            'previous_cdf_details' => 'nullable|string|max:1000',

            // Family Members (dynamic validation)
            'family_members' => 'required|array|min:1',
            'family_members.*.relationship' => 'required|in:father,mother,guardian',
            'family_members.*.vital_status' => 'required|in:alive,deceased',
            'family_members.*.surname' => 'required|string|max:255',
            'family_members.*.first_name' => 'required|string|max:255',

            // Document uploads
            'documents.*' => 'file|mimes:pdf,jpg,jpeg,png|max:5120', // 5MB max
        ]);
    }

    /**
     * Validate Secondary Boarding School Bursary Application
     */
    private function validateSecondaryApplication(Request $request)
    {
        return Validator::make($request->all(), [
            // All skills validation rules plus additional secondary-specific rules
            'applicant_surname' => 'required|string|max:255',
            'applicant_other_names' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'date_of_birth' => 'required|date|before:today',
            'ward_id' => 'required|exists:wards,id',
            'mobile_phone' => 'required|string|max:20',
            'programme_of_study' => 'required|string|max:255',

            // Secondary-specific validations
            'current_grade' => 'required|in:8,9,10,11,12',
            'is_boarder' => 'required|boolean',
            'boarding_fees_payer' => 'nullable|string|max:255',
            'previous_support_organization' => 'nullable|string|max:255',

            // Comprehensive family information
            'family_members' => 'required|array|min:1',
            'family_members.*.relationship' => 'required|in:father,mother,guardian',
            'family_members.*.vital_status' => 'required|in:alive,deceased',
            'family_members.*.occupation' => 'nullable|string|max:255',
            'family_members.*.employer_name' => 'nullable|string|max:255',
            'family_members.*.has_disability' => 'boolean',
            'family_members.*.has_medical_condition' => 'boolean',

            // Detailed siblings/dependents
            'siblings' => 'nullable|array',
            'siblings.*.name' => 'required|string|max:255',
            'siblings.*.age' => 'required|integer|min:0|max:100',
            'siblings.*.is_in_school' => 'boolean',
            'siblings.*.education_supporter' => 'nullable|string|max:255',

            // Socio-economic assessment
            'housing.ownership_type' => 'required|in:owned,rented,inherited,sublet,other',
            'housing.roof_material' => 'required|string',
            'housing.floor_material' => 'required|string',
            'housing.wall_material' => 'required|string',
            'housing.toilet_location' => 'required|in:inside_house,outside_house',
            'housing.water_source' => 'required|string',
            'housing.has_electricity' => 'boolean',
            'housing.meals_per_day' => 'required|integer|min:1|max:5',

            // Asset ownership
            'assets.cattle_count' => 'nullable|integer|min:0',
            'assets.goats_count' => 'nullable|integer|min:0',
            'assets.poultry_count' => 'nullable|integer|min:0',
            'assets.has_tractor' => 'boolean',
            'assets.has_car_truck' => 'boolean',

            // Economic profile
            'economic.household_size' => 'required|integer|min:1',
            'economic.estimated_monthly_income' => 'nullable|numeric|min:0',
            'economic.main_income_source' => 'nullable|string|max:255',
            'economic.has_savings' => 'boolean',
            'economic.has_debt' => 'boolean',
        ]);
    }

    /**
     * Process Family Members
     */
    private function processFamilyMembers(Request $request, int $bursaryId)
    {
        if ($request->has('family_members')) {
            foreach ($request->family_members as $memberData) {
                FamilyMember::create([
                    'educational_bursary_id' => $bursaryId,
                    'relationship' => $memberData['relationship'],
                    'vital_status' => $memberData['vital_status'],
                    'surname' => $memberData['surname'],
                    'first_name' => $memberData['first_name'],
                    'other_names' => $memberData['other_names'] ?? null,
                    'gender' => $memberData['gender'] ?? null,
                    'date_of_birth' => $memberData['date_of_birth'] ?? null,
                    'nrc_number' => $memberData['nrc_number'] ?? null,
                    'occupation' => $memberData['occupation'] ?? null,
                    'employer_name' => $memberData['employer_name'] ?? null,
                    'mobile_phone' => $memberData['mobile_phone'] ?? null,
                    'has_disability' => $memberData['has_disability'] ?? false,
                    'disability_nature' => $memberData['disability_nature'] ?? null,
                    'has_medical_condition' => $memberData['has_medical_condition'] ?? false,
                    'medical_condition_details' => $memberData['medical_condition_details'] ?? null,
                ]);
            }
        }
    }

    /**
     * Process Comprehensive Family Data (Secondary Bursary)
     */
    private function processComprehensiveFamilyData(Request $request, int $bursaryId)
    {
        if ($request->has('family_members')) {
            foreach ($request->family_members as $memberData) {
                FamilyMember::create([
                    'educational_bursary_id' => $bursaryId,
                    'relationship' => $memberData['relationship'],
                    'vital_status' => $memberData['vital_status'],
                    'surname' => $memberData['surname'],
                    'first_name' => $memberData['first_name'],
                    'other_names' => $memberData['other_names'] ?? null,
                    'gender' => $memberData['gender'] ?? null,
                    'date_of_birth' => $memberData['date_of_birth'] ?? null,
                    'nationality' => $memberData['nationality'] ?? 'Zambian',
                    'nrc_number' => $memberData['nrc_number'] ?? null,
                    'village' => $memberData['village'] ?? null,
                    'chief' => $memberData['chief'] ?? null,
                    'district' => $memberData['district'] ?? null,
                    'residential_address' => $memberData['residential_address'] ?? null,
                    'mobile_phone' => $memberData['mobile_phone'] ?? null,
                    'email' => $memberData['email'] ?? null,
                    'occupation' => $memberData['occupation'] ?? null,
                    'employer_name' => $memberData['employer_name'] ?? null,
                    'position_rank' => $memberData['position_rank'] ?? null,
                    'employer_address' => $memberData['employer_address'] ?? null,
                    'has_disability' => $memberData['has_disability'] ?? false,
                    'disability_nature' => $memberData['disability_nature'] ?? null,
                    'has_medical_condition' => $memberData['has_medical_condition'] ?? false,
                    'medical_condition_details' => $memberData['medical_condition_details'] ?? null,
                ]);
            }
        }
    }

    /**
     * Process Sibling/Dependent Information
     */
    private function processSiblingDependents(Request $request, int $bursaryId)
    {
        if ($request->has('siblings')) {
            foreach ($request->siblings as $siblingData) {
                SiblingDependent::create([
                    'educational_bursary_id' => $bursaryId,
                    'type' => 'sibling',
                    'name' => $siblingData['name'],
                    'sex' => $siblingData['sex'] ?? 'male',
                    'age' => $siblingData['age'],
                    'occupation' => $siblingData['occupation'] ?? null,
                    'vital_status' => $siblingData['vital_status'] ?? 'alive',
                    'is_in_school' => $siblingData['is_in_school'] ?? false,
                    'school_name' => $siblingData['school_name'] ?? null,
                    'grade_level' => $siblingData['grade_level'] ?? null,
                    'education_supporter' => $siblingData['education_supporter'] ?? null,
                ]);
            }
        }

        if ($request->has('dependents')) {
            foreach ($request->dependents as $dependentData) {
                SiblingDependent::create([
                    'educational_bursary_id' => $bursaryId,
                    'type' => 'dependent',
                    'name' => $dependentData['name'],
                    'sex' => $dependentData['sex'] ?? 'male',
                    'age' => $dependentData['age'],
                    'occupation' => $dependentData['occupation'] ?? null,
                    'vital_status' => $dependentData['vital_status'] ?? 'alive',
                    'is_dependent' => true,
                    'dependency_notes' => $dependentData['dependency_notes'] ?? null,
                ]);
            }
        }
    }

    /**
     * Process Detailed Sibling Data (Secondary Bursary)
     */
    private function processDetailedSiblingData(Request $request, int $bursaryId)
    {
        // Process siblings with comprehensive information
        if ($request->has('siblings')) {
            foreach ($request->siblings as $siblingData) {
                SiblingDependent::create([
                    'educational_bursary_id' => $bursaryId,
                    'type' => 'sibling',
                    'name' => $siblingData['name'],
                    'sex' => $siblingData['sex'],
                    'age' => $siblingData['age'],
                    'occupation' => $siblingData['occupation'] ?? null,
                    'vital_status' => $siblingData['vital_status'] ?? 'alive',
                    'is_in_school' => $siblingData['is_in_school'] ?? false,
                    'school_name' => $siblingData['school_name'] ?? null,
                    'grade_level' => $siblingData['grade_level'] ?? null,
                    'education_supporter' => $siblingData['education_supporter'] ?? null,
                ]);
            }
        }

        // Process dependents
        if ($request->has('dependents')) {
            foreach ($request->dependents as $dependentData) {
                SiblingDependent::create([
                    'educational_bursary_id' => $bursaryId,
                    'type' => 'dependent',
                    'name' => $dependentData['name'],
                    'sex' => $dependentData['sex'],
                    'age' => $dependentData['age'],
                    'occupation' => $dependentData['occupation'] ?? null,
                    'vital_status' => $dependentData['vital_status'] ?? 'alive',
                    'is_dependent' => true,
                    'dependency_notes' => $dependentData['dependency_notes'] ?? null,
                ]);
            }
        }
    }

    /**
     * Create Basic Vulnerability Assessment
     */
    private function createVulnerabilityAssessment(Request $request, EducationalBursary $bursary)
    {
        // Create the main vulnerability assessment
        $assessment = VulnerabilityAssessment::create([
            'assessable_type' => EducationalBursary::class,
            'assessable_id' => $bursary->id,
            'assessment_date' => now(),
            'assessed_by_id' => null, // Self-assessment
            'requires_verification' => true,
        ]);

        // Create housing assessment if housing data provided
        if ($request->has('housing')) {
            $housingData = $request->housing;

            HousingAssessment::create([
                'vulnerability_assessment_id' => $assessment->id,
                'ownership_type' => $housingData['ownership_type'] ?? 'rented',
                'roof_material' => $housingData['roof_material'] ?? 'iron_sheets',
                'floor_material' => $housingData['floor_material'] ?? 'earth_sand',
                'wall_material' => $housingData['wall_material'] ?? 'natural_walls_mud_cane',
                'toilet_location' => $housingData['toilet_location'] ?? 'outside_house',
                'water_source' => $housingData['water_source'] ?? 'well',
                'has_electricity' => $housingData['has_electricity'] ?? false,
                'meals_per_day' => $housingData['meals_per_day'] ?? 2,
                'main_income_source' => $housingData['main_income_source'] ?? null,
            ]);
        }

        // Create asset ownership if asset data provided
        if ($request->has('assets')) {
            $assetsData = $request->assets;

            AssetOwnership::create([
                'vulnerability_assessment_id' => $assessment->id,
                'cattle_count' => $assetsData['cattle_count'] ?? 0,
                'goats_count' => $assetsData['goats_count'] ?? 0,
                'sheep_count' => $assetsData['sheep_count'] ?? 0,
                'pigs_count' => $assetsData['pigs_count'] ?? 0,
                'poultry_count' => $assetsData['poultry_count'] ?? 0,
                'has_tractor' => $assetsData['has_tractor'] ?? false,
                'has_plough' => $assetsData['has_plough'] ?? false,
                'has_car_truck' => $assetsData['has_car_truck'] ?? false,
                'has_radio' => $assetsData['has_radio'] ?? false,
                'has_television' => $assetsData['has_television'] ?? false,
                'has_mobile_phone' => $assetsData['has_mobile_phone'] ?? true,
            ]);
        }

        // Create economic profile if economic data provided
        if ($request->has('economic')) {
            $economicData = $request->economic;

            EconomicProfile::create([
                'vulnerability_assessment_id' => $assessment->id,
                'household_size' => $economicData['household_size'] ?? 1,
                'estimated_monthly_income' => $economicData['estimated_monthly_income'] ?? 0,
                'primary_income_source' => $economicData['main_income_source'] ?? null,
                'has_savings' => $economicData['has_savings'] ?? false,
                'has_debt' => $economicData['has_debt'] ?? false,
                'receives_social_support' => $economicData['receives_social_support'] ?? false,
                'receives_remittances' => $economicData['receives_remittances'] ?? false,
            ]);
        }

        return $assessment;
    }

    /**
     * Create Comprehensive Vulnerability Assessment (Secondary Bursary)
     */
    private function createComprehensiveVulnerabilityAssessment(Request $request, EducationalBursary $bursary)
    {
        // Create the main vulnerability assessment
        $assessment = VulnerabilityAssessment::create([
            'assessable_type' => EducationalBursary::class,
            'assessable_id' => $bursary->id,
            'assessment_date' => now(),
            'assessed_by_id' => null, // Self-assessment
            'requires_verification' => true,
        ]);

        // Create comprehensive housing assessment
        if ($request->has('housing')) {
            $housingData = $request->housing;

            HousingAssessment::create([
                'vulnerability_assessment_id' => $assessment->id,
                'ownership_type' => $housingData['ownership_type'],
                'roof_material' => $housingData['roof_material'],
                'floor_material' => $housingData['floor_material'],
                'wall_material' => $housingData['wall_material'],
                'toilet_location' => $housingData['toilet_location'],
                'water_source' => $housingData['water_source'],
                'has_electricity' => $housingData['has_electricity'] ?? false,
                'meals_per_day' => $housingData['meals_per_day'] ?? 2,
                'main_income_source' => $housingData['main_income_source'] ?? null,
                'housing_condition' => $housingData['housing_condition'] ?? 'good',
                'has_garden' => $housingData['has_garden'] ?? false,
                'garden_size' => $housingData['garden_size'] ?? null,
            ]);
        }
        // Create comprehensive asset ownership
        if ($request->has('assets')) {
            $assetsData = $request->assets;
            AssetOwnership::create([
                'vulnerability_assessment_id' => $assessment->id,
                'cattle_count' => $assetsData['cattle_count'] ?? 0,
                'goats_count' => $assetsData['goats_count'] ?? 0,
                'sheep_count' => $assetsData['sheep_count'] ?? 0,
                'pigs_count' => $assetsData['pigs_count'] ?? 0,
                'poultry_count' => $assetsData['poultry_count'] ?? 0,
                'has_tractor' => $assetsData['has_tractor'] ?? false,
                'has_plough' => $assetsData['has_plough'] ?? false,
                'has_car_truck' => $assetsData['has_car_truck'] ?? false,
                'has_radio' => $assetsData['has_radio'] ?? false,
                'has_television' => $assetsData['has_television'] ?? false,
                'has_mobile_phone' => $assetsData['has_mobile_phone'] ?? true,
            ]);
        }
        // Create comprehensive economic profile
        if ($request->has('economic')) {
            $economicData = $request->economic;
            EconomicProfile::create([
                'vulnerability_assessment_id' => $assessment->id,
                'household_size' => $economicData['household_size'] ?? 1,
                'estimated_monthly_income' => $economicData['estimated_monthly_income'] ?? 0,
                'primary_income_source' => $economicData['main_income_source'] ?? null,
                'has_savings' => $economicData['has_savings'] ?? false,
                'has_debt' => $economicData['has_debt'] ?? false,
                'receives_social_support' => $economicData['receives_social_support'] ?? false,
                'receives_remittances' => $economicData['receives_remittances'] ?? false,
            ]);
        }
        // Create comprehensive vulnerability assessment details
        if ($request->has('vulnerability_details')) {
            $detailsData = $request->vulnerability_details;
            VulnerabilityAssessmentDetail::create([
                'vulnerability_assessment_id' => $assessment->id,
                'detail_type' => $detailsData['detail_type'] ?? 'general',
                'detail_description' => $detailsData['detail_description'] ?? null,
                'detail_value' => $detailsData['detail_value'] ?? null,
            ]);
        }
        return $assessment;
    }
    /**
     * Process Document Uploads
     */
    private function processDocumentUploads(Request $request, EducationalBursary $bursary)
    {
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                $filePath = $document->store('bursary_documents', 'public');
                // Save document path to the database or perform any other necessary actions
            }
        }
        // Example of saving document metadata
        $bursary->documents()->create([
            'file_path' => $filePath,
            'uploaded_by' => auth()->id(),
        ]);
    }
}
