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
                <h1 class="h3 d-inline align-middle">Enregistrement d'un enseignant</h1>

            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <form action="{{ route('enseignants.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Nom</label>
                                    <input type="text" class="form-control" name="nom" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Prénoms</label>
                                    <input type="text" class="form-control" name="prenoms" required>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: -10px;">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Email</label>
                                    <input type="email" class="form-control" name="email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Fonction</label>
                                    <select name="fonction" id="fonction" class="form-control" required>
                                        @foreach($grades as $grade)
                                            <option value="{{ $grade->id }}">{{ $grade->intitule }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="poste">Poste</label>
                                    <select name="poste" id="poste" class="form-control" required>
                                        @foreach($postes as $poste)
                                            <option>Choisissez le poste</option>
                                            <option value="{{ $poste->id }}">{{ $poste->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="details_poste">Détails poste</label>
                                    <input type="text" class="form-control" name="details_poste" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    {{-- <select name="specialite[]" id="specialite" class="form-control" multiple required>
                                        <option>Choisissez la spécialité</option>
                                        @foreach($specialites as $spec)
                                            <option value="{{ $spec->id }}">{{ $spec->code }} - {{ $spec->intitule }}</option>
                                        @endforeach
                                    </select> --}}

                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <td>Num.</td>
                                                <td>Désignation</td>
                                                <td>
                                                <a href=""><div class="col d-flex justify-content-end">
                                                    <button type="button" class="btn btn-primary" id="show-add-modal">
                                                        <i class="fa fa-plus"></i>
                                                    </button>

                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Ajouter une filière</h4>
                                                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                                                        </div>

                                                        <hr />
                                                        <form method="POST">
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
                                            </a>
                                        </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>M056</td>
                                                <td>Médicine Générale</td>
                                                <td><a href="" class="fa fa-trash" style="color: red;"></a></td>
                                            </tr>
                                            <tr>
                                                <td>M056</td>
                                                <td>Médicine Générale</td>
                                                <td><a href="" class="fa fa-trash" style="color: red;"></a></td>
                                            </tr>
                                            <tr>
                                                <td>M056</td>
                                                <td>Médicine Générale</td>
                                                <td><a href="" class="fa fa-trash" style="color: red;"></a></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="piece_identite">Type pièce d'identité</label>
                                    <select name="type_piece" id="type_piece" class="form-control" required>
                                        <option>Choisissez la pièce</option>
                                        @foreach($type_pieces as $type)
                                            <option value="{{ $type->id }}">{{ $type->libelle }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="piece_identite">Pièce d'identité</label>
                                    <input type="file" class="form-control" name="piece_identite" accept="image/jpeg,image/gif,image/png,application/pdf,image/x-eps" required>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                                </div>

                            </div>

                        </div>
                    </div>
                    </form>
                </div>
            </div>

        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
        window.addEventListener('beforeunload', function () {
            sessionStorage.clear(); // Vide la session storage
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addModal = document.getElementById('add-modal');
            const showAddModal = document.getElementById('show-add-modal');
            const closeAddModal = document.getElementById('close-add-modal');

            showAddModal.onclick = () => addModal.showModal(); // Affiche le modal
            closeAddModal.onclick = () => addModal.close(); // Ferme le modal

            const form = document.querySelector('form');
            form.onsubmit = function (event) {
                event.preventDefault(); // Empêche la soumission réelle du formulaire
                const faculteId = document.getElementById('faculte').value;
                const filiereId = document.getElementById('filiere').value;
                const faculte = document.getElementById('faculte').selectedOptions[0].textContent;
                const filiere = document.getElementById('filiere').selectedOptions[0].textContent;
                const semester = document.querySelector('[name="semester"]').value;
                const newData = { faculteId, filiereId, faculte, filiere, semester };
                let dataList = JSON.parse(sessionStorage.getItem('formDataList')) || [];
                dataList.push(newData);
                sessionStorage.setItem('formDataList', JSON.stringify(dataList));
                updateTable();
            };

            function updateTable() {
                const dataList = JSON.parse(sessionStorage.getItem('formDataList')) || [];
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';
                dataList.forEach((data, index) => {
                    const newRow = `<tr>
                                <td class="text-left">${data.faculte}</td>
                                <td class="text-center">${data.filiere}</td>
                                <td class="text-center">${data.semester}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" onclick="showEditModal(${data.faculte_id})"><i class="fa fa-edit"></i></button>
                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="modal-${data.faculte_id}">
                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                            <h4 class="h4" style="padding-top: 8px;">Editer votre choix</h4>
                                            <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                                        </div>
                                        <hr/>
                                        <form method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="mt-4">
                                                <label for="code">Code</label>
                                                <input type="text" class="form-control" name="code" placeholder="Code" value="${data.faculte}" readonly required>
                                            </div>
                                            <div class="mt-4">
                                                <label for="code">Intitulé</label>
                                                <input type="number" class="form-control" name="semester" placeholder="" value="${data.semester}" required>
                                            </div>
                                            <div class="mt-4">
                                                <button class="btn btn-success" type="submit">Modifier</button>
                                            </div>
                                        </form>
                                    </dialog>
                                    <button class="btn btn-sm btn-danger" data-index="${index}" onclick="deleteEntry(this)"><i class="fa fa-trash"></i></button>
                                </td>
                            </tr>`;
                    tbody.innerHTML += newRow;
                });
            }

            window.deleteEntry = function(button) {
                const index = button.getAttribute('data-index');
                let dataList = JSON.parse(sessionStorage.getItem('formDataList'));
                dataList.splice(index, 1); // Supprime l'entrée
                sessionStorage.setItem('formDataList', JSON.stringify(dataList));
                updateTable(); // Met à jour le tableau
            };

            updateTable(); // Mettre à jour le tableau au chargement initial
        });
    </script>


    <script>
        $(document).ready(function(){
            $('#faculte').change(function() {
                var faculteId = $(this).val(); // Récupère l'ID de la faculté sélectionnée
                if(faculteId) {
                    $.ajax({
                        url: '/filieres/get/' + faculteId,
                        type: "GET",
                        success: function(data) {
                            $('#filiere').empty();
                            console.log(data);
                            var parsedData = JSON.parse(data);
                            $.each(parsedData, function(key, value) {
                                $('#filiere').append('<option value="'+ key +'">'+ value +'</option>');
                            });
                        }
                    });
                } else {
                    $('#filiere').empty(); // Vide la liste si aucune faculté n'est sélectionnée
                }
            });
        });
    </script>
    <script>

        function closeEditModal(id){
            const dialog = document.querySelector(`#modal-${id}`);
            dialog.close();
        }

        function showEditModal(id){
            const dialog = document.querySelector(`#modal-${id}`);
            dialog.showModal();
        }

    </script>

@endsection
