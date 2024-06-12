@extends('layouts.index')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Universités</h1>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="show-add-modal">
                        <i class="fa fa-plus"></i> Ajouter
                    </button>

                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                            <h4 class="h4" style="padding-top: 8px;">Ajouter une université</h4>
                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                        </div>

                        <hr />
                        <form action="{{ route('universites.store') }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col col-md-12">
                                        <label for="nom">Nom</label>
                                        <input type="text" class="form-control" name="nom" placeholder="Nom" required>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success" type="submit">Enregistrer</button>
                            </div>
                        </form>

                    </dialog>
                </div>

            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table mb-0" id="myTable">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">N°</th>
                                                    <th class="text-left">Nom</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($universites as $universite)
                                                    <tr>
                                                        <td class="text-center">{{ $universite->id }}</td>
                                                        <td class="text-left">{{ $universite->nom }}</td>
                                                        <td class="text-left">
                                                            @if(!$universite->open && !$universite->openable)
                                                                <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $universite->id }}"><i class="fa fa-edit"></i></button>
                                                                <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $universite->id }}"><i class="fa fa-trash"></i></button>
                                                            @endif
                                                        </td>


                                                        <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $universite->id }}">
                                                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                                <h4 class="h4" style="padding-top: 8px;">Editer une université</h4>
                                                                <button class="btn btn-danger" onclick="closeEditModalById({{ $universite->id }})"><i class="fa fa-close" ></i></button>
                                                            </div>
                                                            <hr/>
                                                            <form action="{{ route('universites.update', $universite->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mt-4">
                                                                    <label for="code">Désignation</label>
                                                                    <input type="text" class="form-control" name="nom" placeholder="Désignation" value="{{ $universite->nom }}" required>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <button class="btn btn-success" type="submit">Modifier</button>
                                                                </div>
                                                            </form>
                                                        </dialog>

                                                        <!-- Delete Faculty Dialog -->
                                                        <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $universite->id }}">
                                                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                                <h4 class="h4" style="padding-top: 8px;">Supprimer une université</h4>
                                                                <button class="btn btn-danger" onclick="closeDeleteModalById({{ $universite->id }})"><i class="fa fa-close" ></i></button>
                                                            </div>
                                                            <hr/>
                                                            <form action="{{ route('universites.destroy', $universite->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="mt-4 text-center">
                                                                    <h5>Voulez-vous vraiment supprimer l'université : <b>{{ $universite->nom }}</b> ?</h5>
                                                                </div>
                                                                <div class="mt-4" style="display: flex; flex-direction: inverse-row; align-items: right;">
                                                                    <button class="btn btn-danger" type="submit">Supprimer</button>
                                                                </div>
                                                            </form>
                                                        </dialog>


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

    <script>
        const dialog = document.querySelector("#add-modal");
        const showButton = document.querySelector("#show-add-modal");
        const closeButton = document.querySelector("#close-add-modal");

        // "Show the dialog" button opens the dialog modally
        showButton.addEventListener("click", () => {
            dialog.showModal();
        });

        // "Close" button closes the dialog
        closeButton.addEventListener("click", () => {
            dialog.close();
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[id^="editButton-"], [id^="deleteButton-"]').forEach(button => {
                button.addEventListener('click', () => {
                    const facultyId = button.id.split('-')[1];
                    const dialogType = button.classList.contains('btn-primary') ? 'edit' : 'delete';
                    const dialog = document.querySelector(`#${dialogType}-modal-${facultyId}`);
                    dialog.showModal();
                });
            });

            document.querySelectorAll('[id^="close-edit-modal-"], [id^="close-delete-modal-"]').forEach(button => {
                button.addEventListener('click', () => {
                    const facultyId = button.id.split('-')[2];
                    const dialogType = button.id.includes('edit') ? 'edit' : 'delete';
                    const dialog = document.querySelector(`#${dialogType}-modal-${facultyId}`);
                    dialog.close();
                });
            });
        });
    </script>
@endsection
