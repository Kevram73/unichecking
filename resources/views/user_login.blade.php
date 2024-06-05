@extends('templates.avant_connexion')
@section('title', "")
 
@section('content')

        <section class="max-w-lg px-4 mx-auto bg-slate-500 rounded-md shadow-md dark:bg-gray-800">

	@if (session("status") && count(session("status")) > 0)
		@foreach (session("status")["succes"] as $msg)
		<div class="alert alert-success alert-dismissible">
			{{ $msg }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endforeach
		@foreach (session("status")["erreur"] as $msg)
		<div class="alert alert-danger alert-dismissible">
			{{ $msg }}
			<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		</div>
		@endforeach
	@endif
				
		<!--
            <h1 class="text-xl font-bold text-white capitalize dark:text-white py-4">1- Enseignants</h1>
		-->						
		
            <form action="{{ route('user.login') }}" method="POST">				
			@csrf
                <div class="grid grid-cols-1 gap-6">					
				
                    <div class="px-4">
						<!-- <div style="background-color: #1A9100;" class="btn"><label class="text-white dark:text-gray-200 text-bold" style="font-size: 24px; font-weight: bold;" for="email">ADRESSE E-MAIL</label></div>
                        -->
						<input style="font-size:1.3em;" id="email" name="email" type="email" placeholder="Entrez votre adresse email"  value="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
        
                    <div class="px-4">
					<!--
						<div style="background-color: #1A9100;" class="btn"><label class="text-white dark:text-gray-200 text-bold" style="font-size: 24px; font-weight: bold;" for="password">MOT DE PASSE</label></div>
                        -->
                        <input style="font-size:1.3em;" id="password" name="password" placeholder="Entrez votre mot de passe" type="password" value="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
					
				</div>

        
                <div class="flex justify-center mt-6">
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-blue-600" style="background-color: #1A9100; font-size:20px; font-weight: bold;">CONNEXION</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')

@endsection
