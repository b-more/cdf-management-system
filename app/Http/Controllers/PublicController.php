<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Models\Ward;
use App\Models\CommunityProject;
use App\Models\DisasterProject;

class PublicController extends Controller
{
    /**
     * Display the home page
     */
    public function index()
    {
        // Get recent project statistics - handle different column names
        $stats = [
            'total_projects' => CommunityProject::count() + DisasterProject::count(),
            'completed_projects' => CommunityProject::where('status', 'Completed')->count() +
                                  DisasterProject::where('status', 'Completed')->count(),
            'total_wards' => Ward::count(),
            // Handle different column names between models
            'total_beneficiaries' => $this->calculateTotalBeneficiaries(),
        ];

        // Get recent successful projects for showcase
        $recent_projects = CommunityProject::where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->take(6)
            ->get();

        return view('public.index', compact('stats', 'recent_projects'));
    }

    /**
     * Display the about us page
     */
    public function about()
    {
        $stats = [
            'years_active' => 10,
            'constituencies_served' => Ward::count(),
            'total_projects' => CommunityProject::count() + DisasterProject::count(),
            'amount_allocated' => $this->calculateTotalAllocatedAmount(),
        ];

        return view('public.about', compact('stats'));
    }

    /**
     * Display the application form
     */
    public function apply()
    {
        $wards = Ward::orderBy('name')->get();

        return view('public.apply', compact('wards'));
    }

    /**
     * Display the contact page
     */
    public function contact()
    {
        return view('public.contact');
    }

    /**
     * Display the project gallery
     */
    public function gallery()
    {
        $projects = CommunityProject::where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(12);

        $categories = [
            'Infrastructure',
            'Education',
            'Health',
            'Water & Sanitation',
            'Agriculture',
            'Youth Development'
        ];

        return view('public.gallery', compact('projects', 'categories'));
    }

    /**
     * Display infrastructure projects
     */
    public function infrastructure()
    {
        $projects = CommunityProject::where('category', 'Infrastructure')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.infrastructure', compact('projects'));
    }

    /**
     * Display education projects
     */
    public function education()
    {
        $projects = CommunityProject::where('category', 'Education')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.education', compact('projects'));
    }

    /**
     * Display health projects
     */
    public function health()
    {
        $projects = CommunityProject::where('category', 'Health')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.health', compact('projects'));
    }

    /**
     * Display water & sanitation projects
     */
    public function water()
    {
        $projects = CommunityProject::where('category', 'Water & Sanitation')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.water', compact('projects'));
    }

    /**
     * Display agriculture projects
     */
    public function agriculture()
    {
        $projects = CommunityProject::where('category', 'Agriculture')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.agriculture', compact('projects'));
    }

    /**
     * Display youth development projects
     */
    public function youth()
    {
        $projects = CommunityProject::where('category', 'Youth Development')
            ->where('status', 'Completed')
            ->with('ward')
            ->latest()
            ->paginate(9);

        return view('public.projects.youth', compact('projects'));
    }

    /**
     * Handle contact form submission
     */
    public function submitContact(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            // Here you would typically send an email or save to database
            // For now, we'll just return a success message

            // Optional: Send email notification
            // Mail::to('info@cdfportal.gov.zm')->send(new ContactFormMail($request->all()));

            return back()->with('success', 'Thank you for your message! We will get back to you within 24 hours.');

        } catch (\Exception $e) {
            return back()->with('error', 'Sorry, there was an error sending your message. Please try again or call us directly.');
        }
    }

    /**
     * Handle newsletter subscription
     */
    public function newsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please enter a valid email address.'
            ]);
        }

        try {
            // Here you would typically save to database or send to mailing service
            // For now, we'll just return success

            return response()->json([
                'success' => true,
                'message' => 'Thank you for subscribing! You will receive updates about CDF projects and opportunities.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, there was an error processing your subscription. Please try again.'
            ]);
        }
    }

    /**
     * Display privacy policy
     */
    public function privacy()
    {
        return view('public.legal.privacy');
    }

    /**
     * Display terms of service
     */
    public function terms()
    {
        return view('public.legal.terms');
    }

    /**
     * Display accessibility statement
     */
    public function accessibility()
    {
        return view('public.legal.accessibility');
    }

    /**
     * Display sitemap
     */
    public function sitemap()
    {
        $routes = [
            'Home' => route('home'),
            'About Us' => route('about'),
            'Apply Now' => route('apply'),
            'Project Gallery' => route('gallery'),
            'Contact Us' => route('contact'),
            'Infrastructure Projects' => route('projects.infrastructure'),
            'Education Projects' => route('projects.education'),
            'Health Projects' => route('projects.health'),
            'Water & Sanitation Projects' => route('projects.water'),
            'Agriculture Projects' => route('projects.agriculture'),
            'Youth Development Projects' => route('projects.youth'),
        ];

        return view('public.legal.sitemap', compact('routes'));
    }

    /**
     * Calculate total beneficiaries handling different column names
     */
    private function calculateTotalBeneficiaries()
    {
        try {
            $communityBeneficiaries = 0;
            $disasterBeneficiaries = 0;

            // Check if beneficiaries_count column exists in community_projects
            if (\Schema::hasColumn('community_projects', 'beneficiaries_count')) {
                $communityBeneficiaries = CommunityProject::sum('beneficiaries_count') ?? 0;
            }

            // Check if beneficiaries_count column exists in disaster_projects
            if (\Schema::hasColumn('disaster_projects', 'beneficiaries_count')) {
                $disasterBeneficiaries = DisasterProject::sum('beneficiaries_count') ?? 0;
            }
            // If not, check for alternative column names
            elseif (\Schema::hasColumn('disaster_projects', 'affected_people')) {
                $disasterBeneficiaries = DisasterProject::sum('affected_people') ?? 0;
            }
            elseif (\Schema::hasColumn('disaster_projects', 'people_affected')) {
                $disasterBeneficiaries = DisasterProject::sum('people_affected') ?? 0;
            }

            return $communityBeneficiaries + $disasterBeneficiaries;

        } catch (\Exception $e) {
            \Log::error('Error calculating total beneficiaries: ' . $e->getMessage());
            return 0; // Return 0 if there's an error
        }
    }

    /**
     * Calculate total allocated amount handling different column names
     */
    private function calculateTotalAllocatedAmount()
    {
        try {
            $communityAmount = 0;
            $disasterAmount = 0;

            // Check for different possible column names for amounts
            $communityAmountColumns = ['approved_amount', 'allocated_amount', 'budget_allocated', 'amount'];
            $disasterAmountColumns = ['approved_amount', 'allocated_amount', 'emergency_fund', 'amount'];

            // Get community projects amount
            foreach ($communityAmountColumns as $column) {
                if (\Schema::hasColumn('community_projects', $column)) {
                    $communityAmount = CommunityProject::sum($column) ?? 0;
                    break;
                }
            }

            // Get disaster projects amount
            foreach ($disasterAmountColumns as $column) {
                if (\Schema::hasColumn('disaster_projects', $column)) {
                    $disasterAmount = DisasterProject::sum($column) ?? 0;
                    break;
                }
            }

            return $communityAmount + $disasterAmount;

        } catch (\Exception $e) {
            \Log::error('Error calculating total allocated amount: ' . $e->getMessage());
            return 0; // Return 0 if there's an error
        }
    }
}
