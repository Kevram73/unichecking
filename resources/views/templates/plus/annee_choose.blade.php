@php
	$universites = App\Models\Universite::get();
	$annees = App\Models\Annee::get();
@endphp

@section('modal_div')

			<div id="modalChooseAnUnv" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">CHOIX DE L'ANN&Eacute;E ET DE L'UNIVERSIT&Eacute;</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				   <form action="{{ route('annee.choose') }}" method="POST">	
					<div class="modal-body">			
					@csrf
						<div class="grid grid-cols-1 gap-6 mt-4">	
						<div>
							<label class="text-black dark:text-gray-200" for="unv_id">Université</label>
							<select id="unv_id" name="unv_id" required="required" 
							class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($universites as $unv)
								<option 
									value="{{ $unv->id }}" 
									{{ (session('universite_id')) ? ((session('universite_id') == $unv->id) ? "selected" : "") : "" }} >
								{{ $unv->nom }}
								</option>
							@endforeach
							</select>
						</div>
				
						<div>
							<label class="text-black dark:text-gray-200" for="an_id">Année</label>
							<select id="an_id" name="an_id" required="required" 
							class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($annees as $an)
								<option 
									value="{{ $an->id }}" 
									{{(session('annee_id'))? (session('annee_id') == $an->id ? "selected" : "") : "" }} >
								{{ $an->libelle }}
								</option>
							@endforeach
							</select>
						</div>
				
  
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</button>
						<button type="submit" class="btn btn-success">CHOISIR</button>
					  </div>
					</form>
				</div>
			  </div>
			</div>
			
@show
