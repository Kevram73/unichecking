@extends('layouts.index')

@section("content")
<main class="content">
    <div class="container-fluid p-0">

        <h1 class="h3 mb-3">Tableau de bord <strong>analytique</strong> </h1>

        <div class="row">
            <div class="col-xl-6 col-xxl-5 d-flex">
                <div class="w-100">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Modules actifs</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="tool"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">28</h1>
                                    <div class="mb-0">
                                        <span class="text-danger"> <i
                                                class="mdi mdi-arrow-bottom-right"></i> -20% </span>
                                        <span class="text-muted">en rapport avec la semaine passée</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Séances</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle fa fa-clock"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">14.212</h1>
                                    <div class="mb-0">
                                        <span class="text-success"> <i
                                                class="mdi mdi-arrow-bottom-right"></i> 5.25% </span>
                                                <span class="text-muted">en rapport avec la semaine passée</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Enseignants</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle" data-feather="users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">152</h1>
                                    <div class="mb-0">
                                        <span class="text-success"> <i
                                                class="mdi mdi-arrow-bottom-right"></i> 0% </span>
                                        <span class="text-muted">en rapport avec la semaine passée</span>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col mt-0">
                                            <h5 class="card-title">Nbr d'indisponibilités</h5>
                                        </div>

                                        <div class="col-auto">
                                            <div class="stat text-primary">
                                                <i class="align-middle fa fa-users"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <h1 class="mt-1 mb-3">64</h1>
                                    <div class="mb-0">
                                        <span class="text-danger"> <i
                                                class="mdi mdi-arrow-bottom-right"></i> -2.25% </span>
                                                <span class="text-muted">en rapport avec la semaine passée</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-6 col-xxl-7">
                <div class="card flex-fill w-100">
                    <div class="card-header">

                        <h5 class="card-title mb-0">Fréquence des scans</h5>
                    </div>
                    <div class="card-body py-3">
                        <div class="chart chart-sm">
                            <canvas id="chartjs-dashboard-line"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</main>
@endsection
