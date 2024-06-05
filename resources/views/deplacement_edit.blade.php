@extends('templates.modele')
@section('title', $id > 0 ? "Modifier information de l'indisponibilité" : "Enregistrer informations d'une indisponibilité")
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
		
            <form action="{{ route('deplacement.save') }}" method="POST">				
			@csrf
			
						<!-- DEBUT MODALES -->
								<style>
									.modal-dialog{
										  overflow-y: hidden !important
									}
								
									.modal-body .card-body{
									  height: 50vh;
									  overflow-y: auto;
									}								
								</style>
								<div id="modalLoadEns" class="modal" tabindex="-1" role="dialog">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title">Modal title</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									  </div>
									<!-- <form action="#" method="get"> -->
										<div class="modal-body">	
											<div class="card mb-5 overflow-x-auto">
												<div class="card-body">
													<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
														<table id="myEns">
														</table>
													</div>
												</div>
											</div>
										</div>
									<!-- </form> -->	
										<div class="modal-footer">
											<a class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</a>
										</div>	
									</div>
								  </div>
								</div>	
								
			
						<!-- FIN MODALES -->
			
				<input type="hidden" value="{{$id}}" name="id">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">					
				
                    <div>
                        <label class="text-white dark:text-gray-200" >Enseignant</label>
                        <div class="grid grid-cols-12 gap-6 mt-4 content-center">
						
							<input type="hidden" value="{{ isset($data['enseignant_id'])?$data['enseignant_id'] : 0 }}" id="ens_id" name="enseignant_id"/>
							<input id="ens_name" type="text" readonly
							value="{{ isset($data['enseignant'])? $data['enseignant']['nom'] . ' ' . $data['enseignant']['prenoms'] : '' }}" 
							class="block col-span-10 w-full px-10 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							<button type="button" class="py-2" class="block col-span-2 bg-gray-700 border border-gray-300"
							data-bs-toggle="modal"
							data-bs-target="#modalLoadEns">
								<i class="fa fa-search"></i>
							</button>
						</div>						
					</div>		
        
                    <div>
						&nbsp;
					</div> 
                    <div>
                        <label class="text-white dark:text-gray-200" for="type_deplacement_id">Type de déplacement</label>
                        <select id="type_deplacement_id" name="type_deplacement_id" required="required" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						@foreach ($types as $type)
							<option 
								value="{{ $type->id }}" 
								{{ (isset($data['type_deplacement_id'])? ($data['type_deplacement_id'] == $type->id ? "selected" : "") : "") }} 
							>
							{{ $type->designation }}
							</option>
						@endforeach
                        </select>
                    </div>		
				
                    <div>
                        <label class="text-white dark:text-gray-200" for="nom">Détails de déplacement</label>
                        <textarea id="description" name="description" col=6
						class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						{{ isset($data['description'])?$data['description'] : '' }} 
						</textarea>
                    </div>
        
					
                    <div>
                        <label class="text-white dark:text-gray-200" for="date_debut">Date début</label>
                        <input id="date_debut" name="date_debut" type="date" value="{{ isset($data['date_debut'])?$data['date_debut'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>    					
                    <div>
                        <label class="text-white dark:text-gray-200" for="libelle">Date fin</label>
                        <input id="date_fin" name="date_fin" type="date" value="{{ isset($data['date_fin'])?$data['date_fin'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>                    
					<!--
                    <div>
                        <label class="text-white dark:text-gray-200" for="nb_jours_ouvres">Nombre de jours ouvrés</label>
                        <input readonly type="text" id="nb_jours_ouvres" name="nb_jours_ouvres" value="{{ isset($data['nb_jours_ouvres'])?$data['nb_jours_ouvres'] : '' }}" 
						class="block w-full px-4 py-2 mt-2 text-gray-700 bg-gray-300 border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
					-->
					
                </div>

        
                <div class="flex justify-end mt-6">
                    <a class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600" href="{{ route('deplacement.show') }}">ANNULER</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')

<!-- Script for delete modal -->
<script>
var theModal = document.getElementById('modalLoadEns')
theModal.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var modalUrl = $("#modalUrl");
  var modalTitle = theModal.querySelector('.modal-title')
  modalTitle.textContent = "Choix de l'enseignant";
})
</script>
<script>

const dataTable = new DataTable("#myEns", {	
	data: {!! json_encode($enseignants, true); !!} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "id", title: "Enseignant",
			render:function (data, td, row, meta){
				return row.nom + ' ' + row.prenoms;
			}	
		},

		{
			data: "id",
			title: "",
			sorting: false,
            render: function(data, td, row, meta) {
				let func_call = `chooseEns(${data}, '${row.nom + ' ' + row.prenoms}')`
                return "<button type=\"button\" onclick=\"" + func_call + "\" class=\"btn btn-success\" >Choisir</button>";
				 
            }
		},
    ]
});

var chooseEns = function(id, fullname){
	$('#ens_id').val(id);
	$('#ens_name').val(fullname);
}
</script>

@endsection
