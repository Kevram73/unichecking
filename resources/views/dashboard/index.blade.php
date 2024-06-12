@extends('layouts.index')

@section("content")
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Tableau de bord <strong>analytique</strong> </h1>

        <div class="row">
            <div class="col-xl-12 col-xxl-12 d-flex">
                <div class="w-100 row">

                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Enseignants</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="align-middle fa fa-user"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $enseignants }}</h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Facultés</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-warning">
                                        <i class="align-middle fa fa-home"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-3">{{ $facultes }}</h1>

                        </div>
                    </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Universités</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-danger">
                                            <i class="align-middle fa fa-university"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $universites }}</h1>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Séances</h5>
                                    </div>

                                    <div class="col-auto">
                                        <div class="stat text-success">
                                            <i class="align-middle fa fa-clock"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-3">{{ $seances }}</h1>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <h1 class="h3 mb-3"><strong>Séances de la journée</strong></h1>

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
                                            <th class="text-left">Université</th>
                                            <th class="text-left">Enseignant</th>
                                            <th class="text-left">Unité E.</th>
                                            <th class="text-left">Date</th>
                                            <th class="text-left">Période</th>
                                            <th class="text-left">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

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
