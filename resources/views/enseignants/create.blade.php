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
                    <div class="card">
                        <form action="{{ route('enseignants.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="specialiteData" id="specialiteData">
                            <input type="hidden" name="ueData" id="ueData">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="nom">Nom</label>
                                        <input type="text" class="form-control" name="nom" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="prenoms">Prénoms</label>
                                        <input type="text" class="form-control" name="prenoms" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="matricule">Matricule</label>
                                        <input type="text" class="form-control" name="matricule" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="poste">Poste</label>
                                        <select name="poste" id="poste" class="form-control">
                                            <option value="0">Aucun poste</option>
                                            @foreach ($postes as $poste)
                                                <option value="{{ $poste->id }}">{{ $poste->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="fonction">Fonction</label>
                                        <select name="fonction" id="fonction" class="form-control">
                                            @foreach ($grades as $grade)
                                                <option value="{{ $grade->id }}">{{ $grade->intitule }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="type_piece">Type Pièce d'identité</label>
                                        <select name="type_piece" id="type_piece" class="form-control">
                                            @foreach ($type_pieces as $type_piece)
                                                <option value="{{ $type_piece->id }}">{{ $type_piece->libelle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="piece_identite">Pièce d'identité</label>
                                        <input type="file" name="piece_identite" id="piece_identite" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="specialite">Spécialité</label>
                                        <div class="input-group">
                                            <input list="specialite-list" id="specialite" class="form-control">
                                            <datalist id="specialite-list">
                                                @foreach ($specialites as $specialite)
                                                    <option value="{{ $specialite->code }} - {{ $specialite->intitule }}">{{ $specialite->code }} - {{ $specialite->intitule }}</option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="add-specialite">Ajouter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="card-body">
                                        <label for="ue">Unité E.</label>
                                        <div class="input-group">
                                            <input list="ue-list" id="ue" class="form-control">
                                            <datalist id="ue-list">
                                                @foreach ($ues as $ue)
                                                    <option value="{{ $ue->code }} - {{ $ue->intitule }}">{{ $ue->code }} - {{ $ue->intitule }}</option>
                                                @endforeach
                                            </datalist>
                                            <div class="input-group-append">
                                                <button type="button" class="btn btn-primary" id="add-ue">Ajouter</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Spécialité</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="specialite-table-body">
                                                <!-- Dynamic rows will be added here -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card">
                                        <div class="card-body">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <th>Unité E.</th>
                                                    <th>Action</th>
                                                </tr>
                                                </thead>
                                                <tbody id="ue-table-body">
                                                <!-- Dynamic rows will be added here -->
                                                </tbody>
                                            </table>
                                        </div>
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
            sessionStorage.clear();
        });

        document.addEventListener('DOMContentLoaded', function () {
            function updateTable(tableId, dataKey, displayKey) {
                const dataList = JSON.parse(sessionStorage.getItem(dataKey)) || [];
                const tbody = document.getElementById(tableId);
                tbody.innerHTML = '';
                dataList.forEach((data, index) => {
                    const newRow = `<tr>
                        <td class="text-left">${data[displayKey]}</td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-danger" data-index="${index}" onclick="deleteEntry('${dataKey}', '${tableId}', this)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>`;
                    tbody.innerHTML += newRow;
                });
            }

            window.deleteEntry = function(dataKey, tableId, button) {
                const index = button.getAttribute('data-index');
                let dataList = JSON.parse(sessionStorage.getItem(dataKey));
                dataList.splice(index, 1);
                sessionStorage.setItem(dataKey, JSON.stringify(dataList));
                updateTable(tableId, dataKey, tableId === 'specialite-table-body' ? 'specialite' : 'ue');
            };

            $('#add-specialite').click(function () {
                const specialiteId = $('#specialite').val();
                const specialite = $('#specialite-list option[value="' + specialiteId + '"]').text();
                const newData = { specialiteId, specialite };
                let dataList = JSON.parse(sessionStorage.getItem('specialiteDataList')) || [];
                dataList.push(newData);
                sessionStorage.setItem('specialiteDataList', JSON.stringify(dataList));
                updateTable('specialite-table-body', 'specialiteDataList', 'specialite');
            });

            $('#add-ue').click(function () {
                const ueId = $('#ue').val();
                const ue = $('#ue-list option[value="' + ueId + '"]').text();
                const newData = { ueId, ue };
                let dataList = JSON.parse(sessionStorage.getItem('ueDataList')) || [];
                dataList.push(newData);
                sessionStorage.setItem('ueDataList', JSON.stringify(dataList));
                updateTable('ue-table-body', 'ueDataList', 'ue');
            });

            $('form').submit(function () {
                $('#specialiteData').val(sessionStorage.getItem('specialiteDataList'));
                $('#ueData').val(sessionStorage.getItem('ueDataList'));
            });

            updateTable('specialite-table-body', 'specialiteDataList', 'specialite');
            updateTable('ue-table-body', 'ueDataList', 'ue');
        });
    </script>
@endsection
