@extends('layouts.index')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Déplacements</h1>
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
                                                    <th class="text-center">N°</th>
                                                    <th class="text-center">Type de déplacement</th>
                                                    <th class="text-center">Enseignant</th>
                                                    <th class="text-center">Du</th>
                                                    <th class="text-center">Au</th>
                                                    <th class="text-center">Description du poste</th>
                                                    <th class="text-center">Créé le</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if(count($deplacements) < 1)
                                                <tr>
                                                    <td colspan="8" class="text-center">Aucun déplacement enregistré pour le moment</td>
                                                </tr>
                                                @endif
                                                @foreach ($deplacements as $deplacement)
                                                    <tr>
                                                        <td class="text-center">{{ $deplacement->id }}</td>
                                                        <td class="text-center">{{ $deplacement->type()->designation }}</td>
                                                        <td class="text-center">{{ $deplacement->enseignant()->fullname() }}</td>
                                                        <td class="text-center">{{ $deplacement->date_debut }}</td>
                                                        <td class="text-center">{{ $deplacement->date_fin }}</td>
                                                        <td class="text-center">{{ $deplacement->details }}</td>
                                                        <td class="text-center">{{ $deplacement->created_at }}</td>
                                                        <td class="text-center">
                                                            <button type="button" class="btn btn-primary"
                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editModal-{{ $deplacement->id }}"><i
                                                                    class="fa fa-edit"></i></button>
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger delete-btn"
                                                                data-toggle="modal"
                                                                data-target="#deleteModal-{{ $deplacement->id }}"><i
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
