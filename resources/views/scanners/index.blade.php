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
                    <h1 class="h3 mb-3">Scanners</h1>
                </div>
                <div class="col d-flex justify-content-end">
                    <button type="button" class="btn btn-primary" id="show-add-modal">
                        <i class="fa fa-plus"></i> Ajouter
                    </button>

                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                            <h4 class="h4" style="padding-top: 8px;">Ajouter un scanner</h4>
                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                        </div>

                        <hr />
                        <form action="{{ route('scanners.store') }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <label for="nom">Numero de série</label>
                                <input type="text" class="form-control" name="num_serie" placeholder="Numero de série"
                                       required>
                            </div>
                            <div class="mt-4">
                                <label for="universite">Université</label>
                                <select name="universite_id" id="universite_id" class="form-control">
                                    <option>Choisir une université</option>
                                    @foreach ($universites as $universite)
                                        <option value="{{ $universite->id }}" >{{ $universite->nom }}</option>
                                    @endforeach
                                </select>
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
                                                <th class="text-center">N°</th>
                                                <th class="text-center">Numero de série</th>
                                                <th class="text-center">Université</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($scanners) < 1)
                                                <tr>
                                                    <td colspan="8" class="text-center">Aucun scanner enregistré
                                                        pour le moment</td>
                                                </tr>
                                            @endif
                                            @foreach ($scanners as $scanner)
                                                <tr>
                                                    <td class="text-center">{{ $loop->index + 1 }}</td>
                                                    <td class="text-center">{{ $scanner->num_serie }}</td>
                                                    <td class="text-center">{{ $scanner->universite()->nom }}</td>
                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $scanner->id }}"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $scanner->id }}"><i class="fa fa-trash"></i></button>
                                                    </td>

                                                    <!-- Edit Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="edit-modal-{{ $scanner->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Editer un scanner</h4>
                                                            <button class="btn btn-danger" onclick="closeEditModalById({{ $scanner->id }})"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('scanners.update', $scanner->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="mt-4">
                                                                <label for="code">Numero de série</label>
                                                                <input type="text" class="form-control" name="num_serie" placeholder="" value="{{ $scanner->num_serie }}" required>
                                                            </div>
                                                            <div class="mt-4">
                                                                <label for="nom">Université</label>
                                                                <select name="universite_id" class="form-control">
                                                                    <option>Choisir une université</option>
                                                                    @foreach($universites as $universite)
                                                                        <option value="{{ $universite->id }}" @if($universite->id == $scanner->universite_id) selected @endif>{{ $universite->nom }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mt-4">
                                                                <button class="btn btn-success" type="submit">Modifier</button>
                                                            </div>
                                                        </form>
                                                    </dialog>

                                                    <!-- Delete Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $scanner->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Supprimer un scanner</h4>
                                                            <button class="btn btn-danger" onclick="closeDeleteModalById({{ $scanner->id }})"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="{{ route('scanners.destroy', $scanner->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="mt-4 text-center">
                                                                <h5>Voulez-vous vraiment supprimer le scanner de numero  : {{ $scanner->num_serie }}</h5>
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
