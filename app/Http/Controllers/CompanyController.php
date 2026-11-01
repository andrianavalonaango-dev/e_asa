<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
{
    public function create()
    {
        if (Auth::user()->role !== 'recruiter') {
            return abort(403);
        }
        return view('company.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Auth::user()->companies()->create($request->only('name', 'description'));

        return redirect('dashboard')->with('success', 'Entreprise ajoutée avec succès.');
    }

    public function edit(Company $company)
    {
        if (Auth::user()->role !== 'recruiter' || $company->user_id !== Auth::id()) {
            return abort(403);
        }

        return view('company.edit', compact('company'));
    }

    public function update(Request $request, Company $company)
    {
        if ($company->user_id !== Auth::id()) {
            return abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $company->update($request->only('name', 'description'));

        return redirect('dashboard')->with('success', 'Entreprise mise à jour.');
    }
}
