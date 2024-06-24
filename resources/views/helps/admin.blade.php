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
                    <h1 class="h3 mb-3">Centre d'aide</h1>
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
                                                <th class="text-left">N°</th>
                                                <th class="text-left">Code</th>
                                                <th class="text-left">Libellé</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($facultes) < 1)
                                                <tr>
                                                    <td colspan="8" class="text-center">Aucune faculté enregistrée
                                                        pour le moment</td>
                                                </tr>
                                            @endif
                                            @foreach ($facultes as $faculte)
                                                <tr>
                                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                                    <td class="text-left">{{ $faculte->code }}</td>
                                                    <td class="text-left">{{ $faculte->libelle }}</td>
                                                    <td class="text-left">
                                                        <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $faculte->id }}"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $faculte->id }}"><i class="fa fa-trash"></i></button>
                                                    </td>

                                                    <!-- Edit Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $faculte->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Editer une faculté</h4>
                                                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('facultes.update', $faculte->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mt-4">
                                                                <label for="code">Code</label>
                                                                <input type="text" class="form-control" name="code" placeholder="Code de la faculté" value="{{ $faculte->code }}" required>
                                                            </div>
                                                            <div class="mt-4">
                                                                <label for="libelle">Libellé</label>
                                                                <input type="text" class="form-control" name="libelle" placeholder="Libellé de la faculté" value="{{ $faculte->libelle }}" required>
                                                            </div>
                                                            <div class="mt-4">
                                                                <button class="btn btn-success" type="submit">Modifier</button>
                                                            </div>
                                                        </form>
                                                    </dialog>

                                                    <!-- Delete Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $faculte->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Supprimer une faculté</h4>
                                                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('facultes.destroy', $faculte->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="mt-4 text-center">
                                                                <h5>Voulez-vous vraiment supprimer la faculté de code : {{ $faculte->code }}</h5>
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
        let table = new DataTable('#myTable', {
            responsive: true
        });
    </script>
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
