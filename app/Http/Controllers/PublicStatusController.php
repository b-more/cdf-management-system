<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityProject;
use App\Models\DisasterProject;

class PublicStatusController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');

        if (!$query) {
            return response()->json(['results' => []]);
        }

        // Search in both community and disaster projects
        $communityProjects = CommunityProject::where(function($q) use ($query) {
            $q->where('project_code', 'LIKE', "%{$query}%")
              ->orWhere('applicant_phone', 'LIKE', "%{$query}%")
              ->orWhere('applicant_name', 'LIKE', "%{$query}%");
        })->get();

        $disasterProjects = DisasterProject::where(function($q) use ($query) {
            $q->where('project_code', 'LIKE', "%{$query}%")
              ->orWhere('applicant_phone', 'LIKE', "%{$query}%")
              ->orWhere('applicant_name', 'LIKE', "%{$query}%");
        })->get();

        $results = [];

        foreach ($communityProjects as $project) {
            $results[] = [
                'id' => $project->project_code,
                'title' => $project->title,
                'status' => $project->status,
                'date' => $project->created_at->format('M j, Y'),
                'amount' => $project->requested_amount,
                'type' => 'Community Project'
            ];
        }

        foreach ($disasterProjects as $project) {
            $results[] = [
                'id' => $project->project_code,
                'title' => $project->title,
                'status' => $project->status,
                'date' => $project->created_at->format('M j, Y'),
                'amount' => $project->requested_amount,
                'type' => 'Disaster Project'
            ];
        }

        return response()->json(['results' => $results]);
    }
}
