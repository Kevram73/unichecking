@extends('layouts.index')

@section('content')
    <style>
        ::backdrop {
            background-image: linear-gradient(45deg,
            rgb(65, 65, 65),
            rgb(87, 85, 89),
            rgb(30, 43, 56),
            rgb(34, 54, 34));
            opacity: 0.75;
        }
    </style>
        <main class="content">
        <div class="container-fluid p-0">

            <div class="mb-3">
                <h4 class="h4 d-inline align-middle">Enseignant: {{ $enseignant->nom }} {{ $enseignant->prenoms }}</h4>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="show-add-modal">
                        <i class="fa fa-plus"></i> Ajouter
                    </button>

                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                            <h4 class="h4" style="padding-top: 8px;">Ajouter une fonction</h4>
                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                        </div>

                        <hr />
                        <form action="{{ route('enseignants.ues.store') }}" method="POST">
                            @csrf

                            <div class="mt-4">
                                <label for="libelle">Unité Enseignement</label>
                                <select name="ue" id="ue" class="form-control">
                                    @foreach ($ues as $ue)
                                        <option value="{{ $ue->id }}">{{ $ue->code }} {{ $ue->intitule }}</option>
                                    @endforeach
                                </select>
                                <input type="hidden" name="ens_id" value="{{ $id }}">
                            </div>
                            <div class="mt-4">
                                <button class="btn btn-success" type="submit">Enregistrer</button>
                            </div>
                        </form>

                    </dialog>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <table class="table mb-0" id="myTable">
                            <thead>
                                <tr>
                                    <th class="text-left">N°</th>
                                    <th class="text-left">Code</th>
                                    <th class="text-left">Intitulé</th>
                                    <th class="text-left">Volume horaire</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($ues_liste as $ue)
                                <tr>
                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                    <td class="text-left">{{ $ue->ue()->code }}</td>
                                    <td class="text-left">{{ $ue->ue()->intitule }}</td>
                                    <td class="text-left">{{ $ue->ue()->volume_horaire }}</td>
                                    <td class="text-left">
                                        <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $ue->id }}"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $ue->id }}"><i class="fa fa-trash"></i></button>
                                    </td>
                                    <!-- Edit Faculty Dialog -->
                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $ue->id }}">
                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                            <h4 class="h4" style="padding-top: 8px;">Editer une unité d'enseignement</h4>
                                            <button class="btn btn-danger" onclick="closeEditModalById({{ $ue->id }})"><i class="fa fa-close" ></i></button>
                                        </div>
                                        <hr/>
                                        <form action="{{ route('enseignants.ues.ue_update', $ue->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="col col-md-6">
                                                    <div class="mt-4">
                                                        <label for="volume_horaire">Unité d'enseignement</label>
                                                        <select name="ue" id="ue" class="form-control">
                                                            <option>Choisissez votre UE</option>
                                                            @foreach ($ues as $ue)
                                                                <option value="{{ $ue->id }}">{{ $ue->code }} {{ $ue->intitule }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-success" type="submit">Modifier</button>
                                            </div>
                                        </form>
                                    </dialog>

                                    <!-- Delete Faculty Dialog -->
                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $ue->id }}">
                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                            <h4 class="h4" style="padding-top: 8px;">Supprimer une ue</h4>
                                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close" ></i></button>
                                        </div>
                                        <hr/>
                                        <form action="{{ route('enseignants.ues.ue_delete', $ue->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <div class="mt-4 text-center">
                                                <h5>Voulez-vous vraiment supprimer l'UE : {{ $ue->intitule }}</h5>
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
