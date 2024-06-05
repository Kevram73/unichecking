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

    <link rel="stylesheet" href="{{ asset('css/bfr_login_css.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
		<link href="https://cdn.datatables.net/2.0.7/css/dataTables.dataTables.css" rel="stylesheet" />
	</head>
	<body id="body-pd" style="background-image: url('{{ asset('img/universites-du-togo1.jpg') }}'); background-repeat: no-repeat; background-size: cover; width: 100%; height: 100%">
		{{-- <header id="header" style="background-color: #04a61e; color : white; font-weight:bold; text-transform: uppercase; text-align:center;">
			<div style="font-size:2em;">
			Système intégré d'administration des UE et Présences Universitaires
			</div>
		</header> --}}
		
			<div class="container-fluid px-4 col-md-12 col-xd-12" style="padding: 0; padding-top:2em; margin : 0 auto;">
				
				<h2 class="text-bold" style="text-align:center; font-size:2.0em; font-weight:bold; margin:0.25em; text-transform: uppercase; padding-top: 15%; color: #1A9100;"> @yield('title') </h2>
				{{-- <p style="text-align:center; font-size:1em; font-weight:bold; margin:0.25em; color: rgb(124, 118, 118); padding-top: 5px;"> Veuillez entrer vos informations de connexion </p> --}}
				
				<div class="container md:container md:mx-auto">
					@yield('content')
				</div>
			</div>
		
		<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
		<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script> -->
		<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
		integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.js" type="text/javascript"></script>
		<script src="{{ asset('js/dataTables.min.js') }}"></script>
		<script src="{{ asset('js/modele_js.js') }}"></script>
		
		@yield('js')	
	
	</body>
</html>