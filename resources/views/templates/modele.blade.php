<!DOCTYPE html>
<html lang="en">
	<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UNI-CHECK</title>

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
	integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
	<link href="https://cdn.jsdelivr.net/npm/tailwindcss@^2.0/dist/tailwind.min.css" rel="stylesheet">

		<link rel="stylesheet" href="{{ asset('css/modele_css.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
		<link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" rel="stylesheet" />
	<!--	<script src="https://cdn.tailwindcss.com"></script> -->
    </head>
	<body id="body-pd">
		@extends('templates.plus.annee_choose')

		@section('sidebar')



            <div class="l-navbar overflow-y-auto" id="nav-bar">
                <nav class="nav">
                    <div>
                        <div style="min-height: 5em; padding: 0 1em 1em 1em;">

                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('img/icones/admin.png') }}" width="80px" height="80px"/>
                            </div>
                            <h3 style="padding: 1em 0.5em 1em 0.5em; color:white; text-align:center; ">
                            {{ session('user')->nom . " " . session('user')->prenoms}}
                            </h3>
                            <div style="padding: 0.2em 0.5em 1em 0.5em;">

                                <h1 id="uni_name" style="color:white; font-size:1em; text-align:center">{{session('universite')->nom}}</h1>
                                <div class="input-group mb-3 gap-3 d-flex justify-content-center" >
                                    <h2 id="an_lib" style="color:white; font-size:0.8em">{{session('annee')->libelle}}

                                        <a style="height: 50%;"
                                        data-bs-toggle='modal'
                                        data-bs-target='#modalChooseAnUnv'>
                                            <i class="fas fa-edit" style="font-size: 18px;"></i>
                                        </a>



                                </div>
                            </div>

                        </div>
                        <!-- <a href="#" class="nav_logo"> <i class='bx bx-layer nav_logo-icon'></i> <span class="nav_logo-name">MENU</span> </a> -->
                        <style>
                            .nav_link img{
                                width: 24px;
                                height: 24px;
                            }

                            .nav_link{
                                margin-bottom:0.2rem; padding-left: .5em;
                            }

                            li a span:hover{
                                color:black
                            }

                        </style>
                        <hr style="color: white; height: 5px; width: 100%"/>
                        <div class="nav_list" style="margin-top:1em; padding-left: 5px;">

                            <li style="padding-top: 5px;">
                                <a href="{{ route('annee.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-calendar" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">ANNEES ACADEMIQUES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('universite.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-building-columns" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">UNIVERSITES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('enseignant.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-chalkboard-user" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">ENSEIGNANTS</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('faculte.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <img class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" src="{{ asset('img/icones/faculte.png') }}" alt="FACULTES"/>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">FACULTES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('seance.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <img class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" src="{{ asset('img/icones/faculte.png') }}" alt="FACULTES"/>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">SEANCES DE COURS</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('deplacement.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-car" style="color: white"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white">PROGRAMME D'INDISPONIBILITES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('ue.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <img class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" src="{{ asset('img/icones/unite d enseignement.png') }}" alt="UNITES D'ENSEIGNEMENT"/>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">UNITES D'ENSEIGNEMENT</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('poste.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-briefcase" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">POSTES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('grade.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-square-check" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">FONCTIONS</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('specialite.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-user-tie" style="color: white"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">SPECIALITES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('type_piece.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-address-card" style="color: white"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">TYPE DE PIECE D'ID</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('type_deplacement.show') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fa-solid fa-person-walking" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white;">INDISPONIBILITES</span>
                                </a>
                            </li>

                            <div > &nbsp;</div>
                            <div > &nbsp;</div>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('rapport.scan') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class="fas fa-file nav_icon" style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white">CONTRÔLES BIOMETRIQUES</span>
                                </a>
                            </li>
                            <li style="padding-top: 5px;">
                                <a href="{{ route('user.logout') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-700 dark:hover:bg-gray-700 group" style="position: relative;">
                                    <i class='bx bx-log-out nav_icon' style="color: white;"></i>
                                    <span class="flex-1 ms-3 whitespace-nowrap" style="font-size: 14px; color: white">SE DECONNECTER</span>
                                </a>
                            </li>
                        </div>
                    </div>
                </nav>
            </div>


            <div style="padding-top:1em;">
                <header class="header" id="header" style="background-color: #4e6a52; color : white; text-transform: uppercase; text-align:center; margin-left: -35px;">
                    <div style="font-size:18px; margin-left: -15px;">
                    Système intégré d'administration des UE et Présences Universitaires
                    </div>
                </header>
                <div>

                    <h1 style="font-size:1.5em; font-weight:bold; padding-bottom: 20px;"> @yield('title') </h1>

                    <div class="container">
                        @section('modal_div')
                            @parent
                        @endsection

                        @yield('content')
                    </div>
                </div>
            </div>

		@show

		<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3-beta1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<!-- <script src="https://code.jquery.com/jquery-3.7.1.js" type="text/javascript"></script> -->
		<script src="{{ asset('js/dataTables.min.js') }}"></script>
		<!-- <script src="{{ asset('js/modele_js.js') }}"></script> -->
		<!--
		<script src="https://cdn.jsdelivr.net/npm/date-time-format-timezone@1.0.22/build/browserified/date-time-format-timezone-all-zones-no-locale-min.min.js></script>
		-->
		
		@yield('js')

		@section('modal_js')
			@parent
		@endsection

	</body>
</html>
