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
                <h1 class="h3 d-inline align-middle">Modification d'un enseignant</h1>

            </div>
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <form action="{{ route('enseignants.update', $enseignant->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card-body">
                                        <label for="matricule">Matricule</label>
                                        <input type="text" class="form-control" name="matricule" value="{{ $enseignant->matricule }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="nom">Nom</label>
                                        <input type="text" class="form-control" name="nom" value="{{ $enseignant->nom }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="prenoms">Prénoms</label>
                                        <input type="text" class="form-control" name="prenoms" value="{{ $enseignant->prenoms }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email"  value="{{ $enseignant->email }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="fonction">Fonction</label>
                                        <select name="fonction" id="fonction" class="form-control" required>
                                            <option>Choisissez la fonction</option>
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}" @if($grade->id == $enseignant->grade_id) selected @endif>{{ $grade->intitule }}</option>
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
                                            <option>Choisissez le poste</option>
                                            @foreach ($postes as $poste)
                                                <option value="{{ $poste->id }}" @if($poste->id == $enseignant->poste_id) selected @endif>{{ $poste->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="detail_poste">Détails du poste</label>
                                        <input type="text" class="form-control" name="detail_poste" value="{{ $enseignant->details_poste }}" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="type_piece">Type Pièce d'identité</label>
                                        <select name="type_piece" id="" class="form-control" required>
                                            <option>Choisissez le type pièce</option>
                                            @foreach ($type_pieces as $type_piece)
                                                <option value="{{ $type_piece->id }}" @if($grade->id == $enseignant->type_piece_id) selected @endif>{{ $type_piece->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <label for="piece_identite">Pièce d'identité</label>
                                        <input type="file" cl ass="file-input" name="piece" accept=".jfif,.jpg,.jpeg,.png,.gif">
                                        <div id="divImageMediaPreview">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body">
                                        <table class="table mb-0">
                                            <thead>
                                                <tr>
                                                    <td class="text-left">Spécialité</td>
                                                    <td class="text-center"><a class="btn btn-success" id="show-add-modal">Ajouter</a></td>
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="add-modal">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Ajouter une filière</h4>
                                                            <a class="btn btn-danger" id="close-add-modal"><i class="fa fa-close"></i></a>
                                                        </div>

                                                        <hr />
                                                        <form>
                                                            @csrf
                                                            <div class="mt-4">
                                                                <label for="code">Spécialité</label>
                                                                <select name="specialite" id="specialite" class="form-control">
                                                                    @foreach($specialites as $specialite)
                                                                        <option value="{{ $specialite->id }}">{{ $specialite->code }} {{ $specialite->intitule }}</option>
                                                                    @endforeach
                                                                </select>

                                                            </div>

                                                            <input type="hidden" name="specialite" id="spec_liste">

                                                            <div class="mt-4">
                                                                <a class="btn btn-success" id="spec-form">Enregistrer</a>
                                                            </div>
                                                        </form>

                                                    </dialog>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="text-center" colspan="4">
                                                        Aucune spécialité sélectionnée
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
                        </form>
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

      </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const addModal = document.getElementById('add-modal');
            const showAddModal = document.getElementById('show-add-modal');
            const closeAddModal = document.getElementById('close-add-modal');

            showAddModal.onclick = () => addModal.showModal(); // Affiche le modal
            closeAddModal.onclick = () => addModal.close(); // Ferme le modal

            const form = document.getElementById('spec-form');
            form.onclick = function (event) {
                event.preventDefault(); // Empêche la soumission réelle du formulaire
                const specialiteId = document.getElementById('specialite').value;
                const specialite = document.getElementById('specialite').selectedOptions[0].textContent;
                const newData = { specialiteId, specialite };
                let dataList = JSON.parse(sessionStorage.getItem('formDataList')) || [];
                dataList.push(newData);
                sessionStorage.setItem('formDataList', JSON.stringify(dataList));
                document.getElementById('spec_liste').value = sessionStorage.getItem('formDataList');
                updateTable();
            };

            function updateTable() {
                const dataList = JSON.parse(sessionStorage.getItem('formDataList')) || [];
                const tbody = document.querySelector('table tbody');
                tbody.innerHTML = '';
                dataList.forEach((data, index) => {
                    const newRow = `<tr>
                                <td class="text-left">${data.specialite}</td>
                                <td class="text-center">
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
                document.getElementById('spec_liste').value = sessionStorage.getItem('formDataList');
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
    <script>
        $(document).on('change', '.file-input', function() {
        var filesCount = $(this)[0].files.length;

        var textbox = $(this).prev();

        if (filesCount === 1) {
        var fileName = $(this).val().split('\\').pop();
        textbox.text(fileName);
        } else {
        textbox.text(filesCount + ' files selected');
        }



        if (typeof (FileReader) != "undefined") {
        var dvPreview = $("#divImageMediaPreview");
        dvPreview.html("");
        $($(this)[0].files).each(function () {
        var file = $(this);
            var reader = new FileReader();
            reader.onload = function (e) {
                var img = $("<img />");
                img.attr("style", "width: 150px; height:100px; padding: 10px");
                img.attr("src", e.target.result);
                dvPreview.append(img);
            }
            reader.readAsDataURL(file[0]);
        });
        } else {
        alert("This browser does not support HTML5 FileReader.");
        }


        });
    </script>

@endsection
