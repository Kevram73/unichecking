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
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Années</h1>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="show-add-modal">
                        <i class="fa fa-plus"></i> Ajouter
                    </button>

                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                            <h4 class="h4" style="padding-top: 8px;">Ajouter une année académique</h4>
                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                        </div>

                        <hr />
                        <form action="{{ route('annees.store') }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col col-md-6">
                                        <label for="code">Début</label>
                                        <input type="number" class="form-control" name="date_debut" placeholder="Date de début" id="date_debut_add" required>
                                    </div>
                                    <div class="col col-md-6">
                                        <label for="code">Fin</label>
                                        <input type="number" class="form-control" name="date_fin" placeholder="Date de fin" id="date_fin_add" required readonly>
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
            <div class="text-center">
                <span class="badge">
                    @if (Session::has('error'))
                        @if (session('error') == true)
                            <p>{{ session('msg') }}</p>
                        @endif
                    @endif
                    @if (Session::has('error'))
                        @if (session('error') == false)
                            <p>{{ session('msg') }}</p>
                        @endif
                    @endif
                </span>
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
                                                <th class="text-left">N°</th>
                                                <th class="text-left">Année</th>
                                                <th class="text-left">Etat</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($annees) < 1)
                                                <tr>
                                                    <td colspan="8" class="text-center">Aucune année académique enregistrée
                                                        pour le moment</td>
                                                </tr>
                                            @endif
                                            @foreach ($annees as $annee)
                                                <tr>
                                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                                    <td class="text-left">{{ $annee->libelle }}</td>

                                                    <td class="text-left">{{ $annee->open() }}</td>
                                                    <td class="text-left">
                                                        @if(!$annee->open && !$annee->openable)
                                                        <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $annee->id }}"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $annee->id }}"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </td>


                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $annee->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Editer un type de déplacement</h4>
                                                            <button class="btn btn-danger" onclick="closeEditModalById({{ $annee->id }})"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('annees.update', $annee->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mt-4">
                                                                <label for="code">Désignation</label>
                                                                <input type="text" class="form-control" name="designation" placeholder="Désignation" value="{{ $annee->libelle }}" required>
                                                            </div>
                                                            <div class="mt-4">
                                                                <button class="btn btn-success" type="submit">Modifier</button>
                                                            </div>
                                                        </form>
                                                    </dialog>

                                                    <!-- Delete Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $annee->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Supprimer un type de déplacement</h4>
                                                            <button class="btn btn-danger" onclick="closeDeleteModalById({{ $annee->id }})"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('annees.destroy', $annee->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="mt-4 text-center">
                                                                <h5>Voulez-vous vraiment supprimer le type de pièce de désignation : <b>{{ $annee->libelle }}</b> ?</h5>
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
