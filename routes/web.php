<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicApplicationController;
use App\Http\Controllers\PublicStatusController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BursaryApplicationController;
use App\Http\Controllers\Api\BursaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/apply', [PublicApplicationController::class, 'showForm'])->name('public.apply');
Route::post('/api/applications', [PublicApplicationController::class, 'submit'])->name('api.applications.submit');
Route::post('/api/status/search', [PublicStatusController::class, 'search'])->name('api.status.search');

// Public Pages Routes
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/about', [PublicController::class, 'about'])->name('about');
Route::get('/apply', [PublicController::class, 'apply'])->name('apply');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery');

// Project Category Pages
Route::get('/projects/infrastructure', [PublicController::class, 'infrastructure'])->name('projects.infrastructure');
Route::get('/projects/education', [PublicController::class, 'education'])->name('projects.education');
Route::get('/projects/health', [PublicController::class, 'health'])->name('projects.health');
Route::get('/projects/water', [PublicController::class, 'water'])->name('projects.water');
Route::get('/projects/agriculture', [PublicController::class, 'agriculture'])->name('projects.agriculture');
Route::get('/projects/youth', [PublicController::class, 'youth'])->name('projects.youth');

// Application Related Routes
Route::post('/apply', [ApplicationController::class, 'submit'])->name('application.submit');
Route::get('/status', [ApplicationController::class, 'checkStatus'])->name('status.check');
Route::post('/status', [ApplicationController::class, 'searchStatus'])->name('status.search');

// API Routes for AJAX calls
Route::prefix('api')->group(function () {
    Route::get('/wards', [ApplicationController::class, 'getWards'])->name('api.wards');
    Route::post('/send-sms', [ApplicationController::class, 'sendSMS'])->name('api.sms');
});

// Contact Form
Route::post('/contact', [PublicController::class, 'submitContact'])->name('contact.submit');

// Legal Pages
Route::get('/privacy', [PublicController::class, 'privacy'])->name('privacy');
Route::get('/terms', [PublicController::class, 'terms'])->name('terms');
Route::get('/accessibility', [PublicController::class, 'accessibility'])->name('accessibility');
Route::get('/sitemap', [PublicController::class, 'sitemap'])->name('sitemap');

// Newsletter Subscription
Route::post('/newsletter', [PublicController::class, 'newsletter'])->name('newsletter.subscribe');

// Redirect old URLs (if needed)
Route::redirect('/home', '/', 301);
Route::redirect('/index', '/', 301);
// Alternative route definition
Route::get('privacy', [PublicController::class, 'privacy'])->name('privacy');

// New routes to add to web.php
// Route::prefix('bursary')->group(function () {
//     Route::get('/skills', [BursaryApplicationController::class, 'showSkillsForm']);
//     Route::post('/skills', [BursaryApplicationController::class, 'submitSkills']);
//     Route::get('/secondary', [BursaryApplicationController::class, 'showSecondaryForm']);
//     Route::post('/secondary', [BursaryApplicationController::class, 'submitSecondary']);
//     Route::get('/status/{code}', [BursaryApplicationController::class, 'checkStatus']);
// });

// // API routes for AJAX functionality
// Route::prefix('api/bursary')->group(function () {
//     Route::post('/calculate-vulnerability', [Api\BursaryController::class, 'calculateVulnerability']);
//     Route::post('/family-member', [Api\BursaryController::class, 'addFamilyMember']);
//     Route::post('/upload-document', [Api\BursaryController::class, 'uploadDocument']);
// });

// Educational Bursary Routes
Route::prefix('bursary')->name('bursary.')->group(function () {
    // Application Forms
    Route::get('/skills', [BursaryApplicationController::class, 'showSkillsForm'])->name('skills.form');
    Route::post('/skills', [BursaryApplicationController::class, 'submitSkillsApplication'])->name('skills.submit');
    Route::get('/secondary', [BursaryApplicationController::class, 'showSecondaryForm'])->name('secondary.form');
    Route::post('/secondary', [BursaryApplicationController::class, 'submitSecondaryApplication'])->name('secondary.submit');

    // Status and Success
    Route::get('/status', [BursaryApplicationController::class, 'checkApplicationStatus'])->name('status');
    Route::post('/status', [BursaryApplicationController::class, 'checkApplicationStatus'])->name('status.search');
    Route::get('/success', [BursaryApplicationController::class, 'showSuccessPage'])->name('success');

    // Document Download
    Route::get('/{bursary}/document/{document}/download', [BursaryApplicationController::class, 'downloadDocument'])->name('document.download');
});

// API Routes for AJAX functionality
Route::prefix('api')->name('api.')->group(function () {
    // Vulnerability Assessment
    Route::post('/vulnerability/calculate', [VulnerabilityAssessmentController::class, 'calculateScore'])->name('vulnerability.calculate');

    // Family Members
    Route::post('/family-member/add', [FamilyMemberController::class, 'addFamilyMember'])->name('family.add');
    Route::put('/family-member/{familyMember}', [FamilyMemberController::class, 'updateFamilyMember'])->name('family.update');
    Route::delete('/family-member/{familyMember}', [FamilyMemberController::class, 'deleteFamilyMember'])->name('family.delete');
    Route::get('/family-members/{bursary}', [FamilyMemberController::class, 'getFamilyMembers'])->name('family.list');
    Route::post('/family-member/validate-employment', [FamilyMemberController::class, 'validateEmployment'])->name('family.validate.employment');
});
