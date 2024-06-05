@extends('layouts.index')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Années académiques</h1>
                </div>
                <div class="col d-flex justify-content-end"><button type="button" class="btn btn-primary" data-toggle="modal"
                        data-target="#addModal"> <i class="fa fa-plus"></i> Ajouter</button></div>
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
                                                            <a href="#" class="btn btn-sm btn-primary"><i
                                                                    class="fa fa-edit"></i></a>
                                                            <a href="#" class="btn btn-sm btn-danger"><i
                                                                    class="fa fa-trash"></i></a>
                                                        </td>
                                                        <td>
                                                            <div class="modal fade" id="deleteModal" tabindex="-1"
                                                                role="dialog" aria-labelledby="deleteModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="POST" id="deleteForm">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Supprimer l'année
                                                                                    académique</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                Êtes-vous sûr de vouloir supprimer cette
                                                                                année académique ?
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-danger">Delete</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </td>
                                                        <td>
                                                            <div class="modal fade" id="editModal" tabindex="-1"
                                                                role="dialog" aria-labelledby="editModalLabel"
                                                                aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <form action="" method="POST" id="editForm">
                                                                            <!-- Dynamic action will be set via JS -->
                                                                            @csrf
                                                                            @method('PUT') <!-- Specify method as PUT -->
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="exampleModalLabel">Modifier l'année
                                                                                    académique</h5>
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span>
                                                                                </button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <div>
                                                                                    <label class="text-black"
                                                                                        for="editVal">Année</label>
                                                                                    <input id="editVal" name="year"
                                                                                        type="number" class="form-control">
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button"
                                                                                    class="btn btn-secondary"
                                                                                    data-dismiss="modal">Close</button>
                                                                                <button type="submit"
                                                                                    class="btn btn-primary">Save
                                                                                    changes</button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>

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

    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="{{ route('annees.store') }}" method="POST">
                    @csrf <!-- CSRF token for security -->
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nouvelle année académique</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <label class="text-black" for="val">Année</label>
                            <input id="val" name="year" type="number" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            $('.edit-btn').on('click', function() {
                var anneeId = $(this).data('id');
                var anneeYear = $(this).data('year');
                $('#editForm').attr('action', '/annees/' + anneeId);
                $('#editVal').val(anneeYear);
                $('#editModal').modal('show');
            });

            $('.delete-btn').on('click', function() {
                var anneeId = $(this).data('id');
                $('#deleteForm').attr('action', '/annees/' + anneeId);
                $('#deleteModal').modal('show');
            });
        });
    </script>
@endsection
