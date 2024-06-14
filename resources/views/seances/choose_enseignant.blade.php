@extends('layouts.index')

@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Enseignants</h1>
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
                                                <th class="text-left">Nom</th>
                                                <th class="text-left">Prénoms</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($enseignants as $enseignant)
                                                <tr>
                                                    <td class="text-left">{{ $enseignant->nom }}</td>
                                                    <td class="text-left">{{ $enseignant->prenoms }}</td>
                                                    <td class="text-left">
                                                        <a href="{{ route('seance.choice', $enseignant->id) }}" class="btn btn-sm btn-success"><i
                                                                class="fa fa-check"></i> Choisir</a>

                                                    </td>
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
@endsection
