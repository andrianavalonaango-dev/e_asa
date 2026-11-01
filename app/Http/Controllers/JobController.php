<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('jobs')->orderBy('name')->get();

        if (!$request->filled('domain')) {
            $jobs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 9);
        } else {
            $query = Job::with(['company', 'category'])->latest();

            $query->where('category_id', $request->domain);

            if ($request->filled('search')) {
                $query->where(function ($q) use ($request) {
                    $q->where('title', 'like', '%' . $request->search . '%')
                      ->orWhere('description', 'like', '%' . $request->search . '%');
                });
            }

            $jobs = $query->paginate(9)->withQueryString();
        }

        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function show(Job $job)
    {
        $job->load(['company', 'category']);
        return view('jobs.show', compact('job'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'recruiter' || !Auth::user()->companies()->exists()) {
            return redirect('dashboard')->with('error', 'Vous devez configurer le profil de votre entreprise avant de publier.');
        }

        $categories = Category::orderBy('name')->get();
        $companies = Auth::user()->companies;
        return view('jobs.create', compact('categories', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
            'description' => 'required|string',
            'salary' => 'nullable|numeric',
            'deadline' => 'nullable|date'
        ]);

        $company = Auth::user()->companies()->findOrFail($request->company_id);

        $company->jobs()->create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'salary' => $request->salary,
            'deadline' => $request->deadline,
        ]);

        return redirect('dashboard')->with('success', 'Offre d\'emploi publiée avec succès !');
    }

    public function edit(Job $job)
    {
        if (Auth::user()->role !== 'recruiter' || $job->company->user_id !== Auth::id()) {
            return abort(403);
        }

        $categories = Category::orderBy('name')->get();
        $companies = Auth::user()->companies;
        return view('jobs.edit', compact('job', 'categories', 'companies'));
    }

    public function update(Request $request, Job $job)
    {
        if (Auth::user()->role !== 'recruiter' || $job->company->user_id !== Auth::id()) {
            return abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
            'description' => 'required|string',
            'salary' => 'nullable|numeric',
            'deadline' => 'nullable|date'
        ]);

        // Verify that the new company belongs to the user
        Auth::user()->companies()->findOrFail($request->company_id);

        $job->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'description' => $request->description,
            'salary' => $request->salary,
            'deadline' => $request->deadline,
        ]);

        return redirect('dashboard')->with('success', 'Offre d\'emploi mise à jour avec succès !');
    }

    public function destroy(Job $job)
    {
        if (Auth::user()->role === 'recruiter' && $job->company->user_id === Auth::id()) {
            $job->delete();
            return redirect('dashboard')->with('success', 'Offre supprimée.');
        }

        return abort(403);
    }
}
