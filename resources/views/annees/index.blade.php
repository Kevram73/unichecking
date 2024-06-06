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
                                                        <th class="text-center">N°</th>
                                                        <th class="text-center">Année</th>
                                                        <th class="text-center">Etat</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($annees as $annee)
                                                        <tr>
                                                            <td class="text-center">{{ $annee->id }}</td>
                                                            <td class="text-center">{{ $annee->libelle }}</td>
                                                            <td class="text-center">En cours</td>
                                                            <td class="text-center">
                                                                <button type="button" class="btn btn-primary"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#staticBackdrop"><i
                                                                        class="fa fa-edit"></i></button>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-danger delete-btn"
                                                                    data-toggle="modal"
                                                                    data-target="#deleteModal-{{ $annee->id }}"><i
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
