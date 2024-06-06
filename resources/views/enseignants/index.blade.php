@extends('layouts.index')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Années académiques</h1>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
                        <i class="fa fa-plus"></i> Ajouter
                    </button>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">ID</th>
                                                    <th class="text-center">Nom</th>
                                                    <th class="text-center">Prénoms</th>
                                                    <th class="text-center">Fonction</th>
                                                    <th class="text-center">Poste</th>
                                                    <th class="text-center">Détails</th>
                                                    <th class="text-center">Adresse Email</th>
                                                    <th class="text-center">Créé le</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($enseignants as $enseignant)
                                                    <tr>
                                                        <td class="text-center">{{ $enseignant->id }}</td>
                                                        <td class="text-center">{{ $enseignant->nom }}</td>
                                                        <td class="text-center">{{ $enseignant->prenoms }}</td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center">{{ $enseignant->email }}</td>
                                                        <td class="text-center">{{ $enseignant->created_at }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal-{{ $enseignant->id }}"><i
                                                                    class="fa fa-edit"></i></button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-btn"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal-{{ $enseignant->id }}"><i
                                                                    class="fa fa-trash"></i></button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
