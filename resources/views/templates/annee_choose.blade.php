@section('modal_div')

			<div id="modalEdit" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				   <form action="{{ route('annee.choose') }}" method="POST">	
					<div class="modal-body">			
					@csrf
						<input type="hidden" id="id" name="id">
						<div class="grid grid-cols-1 gap-6 mt-4">	
						<div>
							<label class="text-black dark:text-gray-200" for="universite_id">Université</label>
							<select id="universite_id" name="universite_id" required="required" 
							class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($universites as $unv)
								<option 
									value="{{ $unv->id }}" 
									{{ $s = session('universite_id');
									($s) ? (($s == $unv->id) ? "selected" : "") : "" }} >
								{{ $unv->nom }}
								</option>
							@endforeach
							</select>
						</div>
				
						<div>
							<label class="text-black dark:text-gray-200" for="annee_id">Année</label>
							<select id="annee_id" name="annee_id" required="required" 
							class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($annees as $an)
								<option 
									value="{{ $an->id }}" 
									{{ $s = session('annee_id');
									($s)? ($s == $an->id ? "selected" : "") : "" }} >
								{{ $an->libelle }}
								</option>
							@endforeach
							</select>
						</div>
				
  
						</div>
					  </div>
					  <div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
						<button type="submit" class="btn btn-success">Enregistrer</button>
					  </div>
					</form>
				</div>
			  </div>
			</div>
			
@show