@extends('templates.modele')
@section('title', "CHANGER SON MOT DE PASSE")
 
@section('content')

        <section class="max-w-4xl p-6 mx-auto bg-indigo-400 rounded-md shadow-md dark:bg-gray-800 mt-20">

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
		
            <form action="{{ route('user.password') }}" method="POST">				
			@csrf
				<input name="id" type="hidden" value="{{ session('user', new App\Models\User())->id }}"/>
                <div class="grid grid-cols-1 gap-6 mt-4 ">	        
                    <div>
                        <label class="text-white dark:text-gray-200" for="old_password">MOT DE PASSE</label>
                        <input id="old_password" name="old_password" type="password" value="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>     
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="password">NOUVEAU MOT DE PASSE</label>
                        <input id="new_password" name="new_password" type="password" value="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>   
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="conf_password">CONFIRMEZ LE NOUVEAU MOT DE PASSE</label>
                        <input id="conf_password" name="conf_password" type="password" value="" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>     
					
 
				</div>
                <div class="flex justify-end mt-6">
                    <a class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600" href="#">ANNULER</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')

@endsection
