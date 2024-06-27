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
                    <h1 class="h3 mb-3">Fonction</h1>
                </div>
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
                        <form action="{{ route('grades.store') }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <label for="code">Intitulé</label>
                                <input type="text" class="form-control" name="intitule" placeholder="Intitulé"
                                    required>
                            </div>
                            <div class="mt-4">
                                <label for="libelle">Volume horaire</label>
                                <input type="number" class="form-control" name="volume_horaire"
                                    placeholder="Volume horaire" required>
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
                                                    <th class="text-left">Intitulé</th>
                                                    <th class="text-left">Volume horaire</th>
                                                    <th class="text-left">Créé le</th>
                                                    <th class="text-left">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @if (count($grades) < 1)
                                                    <tr>
                                                        <td colspan="8" class="text-center">Aucun grade enregistré
                                                            pour le moment</td>
                                                    </tr>
                                                @endif
                                                @foreach ($grades as $grade)
                                                    <tr>
                                                        <td class="text-left">{{ $loop->index + 1 }}</td>
                                                        <td class="text-left">{{ $grade->intitule }}</td>
                                                        <td class="text-left">{{ $grade->volume_horaire }}</td>
                                                        <td class="text-left">{{ $grade->created_at }}</td>
                                                        <td class="text-left">
                                                            <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $grade->id }}"><i class="fa fa-edit"></i></button>
                                                            <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $grade->id }}"><i class="fa fa-trash"></i></button>
                                                        </td>

                                                        <!-- Edit Faculty Dialog -->
                                                        <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $grade->id }}">
                                                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                                <h4 class="h4" style="padding-top: 8px;">Editer une grade</h4>
                                                                <button class="btn btn-danger" onclick="closeEditModalById({{ $grade->id }})"><i class="fa fa-close" ></i></button>
                                                            </div>
                                                            <hr/>
                                                            <form action="{{ route('grades.update', $grade->id) }}" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mt-4">
                                                                    <label for="code">Intitulé</label>
                                                                    <input type="text" class="form-control" name="intitule" placeholder="Code de la grade" value="{{ $grade->intitule }}" required>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <label for="libelle">Volume horaire</label>
                                                                    <input type="number" class="form-control" name="volume_horaire" placeholder="Libellé de la grade" value="{{ $grade->volume_horaire }}" required>
                                                                </div>
                                                                <div class="mt-4">
                                                                    <button class="btn btn-success" type="submit">Modifier</button>
                                                                </div>
                                                            </form>
                                                        </dialog>

                                                        <!-- Delete Faculty Dialog -->
                                                        <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $grade->id }}">
                                                            <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                                <h4 class="h4" style="padding-top: 8px;">Supprimer une grade</h4>
                                                                <button class="btn btn-danger" onclick="closeDeleteModalById({{ $grade->id }})"><i class="fa fa-close" ></i></button>
                                                            </div>
                                                            <hr/>
                                                            <form action="{{ route('grades.destroy', $grade->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <div class="mt-4 text-center">
                                                                    <h5>Voulez-vous vraiment supprimer la grade d'intitulé : {{ $grade->intitule }}</h5>
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