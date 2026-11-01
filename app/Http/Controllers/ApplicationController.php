<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    public function store(Request $request, Job $job)
    {
        if (Auth::user()->role !== 'candidate') {
            return abort(403);
        }

        if ($job->applications()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous avez déjà postulé à cette offre.');
        }

        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'lm' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $cvPath = $request->file('cv')->store('applications/cv', 'public');
        $lmPath = $request->hasFile('lm') ? $request->file('lm')->store('applications/lm', 'public') : null;

        $job->applications()->create([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'cv_path' => $cvPath,
            'lm_path' => $lmPath,
        ]);

        return back()->with('success', 'Candidature envoyée avec succès.');
    }

    public function updateStatus(Request $request, Application $application)
    {
        if (Auth::user()->role !== 'recruiter' || $application->job->company->user_id !== Auth::id()) {
            return abort(403);
        }

        $request->validate(['status' => 'required|in:pending,accepted,rejected']);
        $application->update(['status' => $request->status]);

        if (in_array($request->status, ['accepted', 'rejected'])) {
            $application->user->notify(new \App\Notifications\ApplicationStatusUpdated($application));
        }

        return back()->with('success', 'Statut mis à jour.');
    }

    public function viewFile(Application $application, $type)
    {
        if (Auth::user()->role !== 'recruiter' || $application->job->company->user_id !== Auth::id()) {
            return abort(403);
        }

        $path = $type === 'cv' ? $application->cv_path : $application->lm_path;

        if (!$path || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return abort(404);
        }

        return response()->file(storage_path('app/public/' . $path), [
            'Content-Disposition' => 'inline'
        ]);
    }
}
