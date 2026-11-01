@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Profil de l'entreprise</div>
            <div class="card-body">
                <form method="POST" action="{{ route('company.update', $company->id) }}">
                    @csrf
                    @method('PUT')
                    
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label>Nom de l'entreprise</label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $company->name ?? '') }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="description" class="form-control" rows="5">{{ old('description', $company->description ?? '') }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Enregistrer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
