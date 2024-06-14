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
                <h1 class="h3 d-inline align-middle">Enregistrement d'une séance</h1>

            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Nom et prénoms</label>
                                    <input type="text" class="form-control" value="{{ $enseignant->nom }} {{ $enseignant->prenoms }}" name="nom" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="prenoms">Unité d'enseignement</label>
                                    <select name="ue" id="ue" class="form-control">
                                        <option value="MTH-300">Statistiques et probabilités</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: -10px;">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="nom">Jour de semaine</label>
                                    <select name="jour_semaine" id="jour_semaine" class="form-control">
                                        <option>Sélectionnez un jour de la semaine</option>
                                        <option value="1">Lundi</option>
                                        <option value="2">Mardi</option>
                                        <option value="3">Mercredi</option>
                                        <option value="4">Jeudi</option>
                                        <option value="5">Vendredi</option>
                                        <option value="6">Samedi</option>
                                        <option value="7">Dimanche</option>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="heure_debut">Heure de début</label>
                                    <input type="time" class="form-control" name="heure_debut">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="heure_fin">Heure de fin</label>
                                    <input type="time" class="form-control" name="heure_fin">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="date_debut">Date de début</label>
                                    <input type="date" class="form-control" name="heure_debut">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <label for="date_fin">Date de fin</label>
                                    <input type="date" class="form-control" name="heure_fin">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="card-body">
                                    <table class="table mb-0">
                                        <thead>
                                            <tr>
                                                <td class="text-left">Faculté</td>
                                                <td class="text-center">Filière</td>
                                                <td class="text-center">Semestre</td>
                                                <td class="text-center"><button class="btn btn-success" id="show-add-modal">Ajouter</button></td>
                                                <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                                                    <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                        <h4 class="h4" style="padding-top: 8px;">Ajouter une filière</h4>
                                                        <button class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></button>
                                                    </div>

                                                    <hr />
                                                    <form action="{{ route('filieres.store') }}" method="POST">
                                                        @csrf
                                                        <div class="mt-4">
                                                            <label for="code">Faculté</label>
                                                            <select name="faculte" id="faculte" class="form-control">
                                                                @foreach($facultes as $faculte)
                                                                    <option value="{{ $faculte->id }}">{{ $faculte->libelle  }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="mt-4">
                                                            <label for="code">Filière</label>
                                                            <select name="filiere" id="filiere" class="form-control">

                                                            </select>
                                                        </div>
                                                        <div class="mt-4">
                                                            <label for="code">Semestre</label>
                                                            <input type="number" class="form-control" name="semester" placeholder="Semestre" min="1" max="10"
                                                                   required>
                                                        </div>
                                                        <div class="mt-4">
                                                            <button class="btn btn-success" type="submit">Enregistrer</button>
                                                        </div>
                                                    </form>

                                                </dialog>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="text-center" colspan="4">
                                                    Aucune filière sélectionnée
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
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
                </div>
            </div>

        </div>
    </main>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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