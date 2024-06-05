@extends('templates.modele')
@section('title', $id > 0 ? "Modifier les informations de la faculté" : "Enregistrer les informations d'une faculté")
@section('sidebar')
    @parent
@endsection
 
@section('content')

        <section class="max-w-4xl p-6 mx-auto bg-indigo-400 rounded-md shadow-md dark:bg-gray-800 mt-2">

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

		
            <form action="{{ route('faculte.save') }}" method="POST">				
			@csrf
				<input type="hidden" value="{{$id}}" name="id">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">								
                    <div>
                        <label class="text-white dark:text-gray-200" for="code">Code</label>
                        <input id="code" name="code" type="text"  value="{{ isset($data['code'])?$data['code'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="libelle">Désignation</label>
                        <input id="libelle" name="libelle" type="text" value="{{ isset($data['libelle'])?$data['libelle'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>     
				<div>
					<label class="text-white dark:text-gray-200">&nbsp;</label>
				</div> 
				</div>
                <div class="flex justify-end mt-6">
                    <a class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600" href="{{ route('faculte.show') }}">ANNULER</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')

@endsection
