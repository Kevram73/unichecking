@extends('templates.modele')
@section('title', 'Séances de cours')
@section('sidebar')
    @parent

@endsection
 
@section('content')
			<div id="modalDelete" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					<p id="modal_body_p">Modal body text goes here.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
					<a id="modalUrl" class="btn btn-success" href=''>Supprimer</a>
				  </div>
				</div>
			  </div>
			</div>

						
			<div id="modal_ue" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <form action="{{route('ens_ue.save')}}" method="post">
					@csrf
					<input type="hidden" name="enseignant_id" />
					<input type="hidden" name="id" />
					<div class="modal-body">							
						<div>
							<input id="edit_ue_num" type="hidden" />
							<label class="text-black dark:text-gray-200" for="edit_ue_ue_id">Unité d'Enseignement</label>
							<select id="edit_ue_ue_id" name="ue_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($ues as $ue)
								<option value="{{ $ue->id }}" >{{ $ue->code . " " . $ue->intitule }}</option>
							@endforeach 
							</select>
						</div>
						<div>
							<label class="text-black dark:text-gray-200" for="edit_ue_date">Date d'affectation</label>
							<input id="edit_ue_date" name="date_affectation" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						</div>
					</div>
					<div class="modal-footer">
						<a class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</a>
						<button type="submit" id="modal_ue_save" class="btn btn-success">ENREGISTRER</button>
					</div>	
				  </form>	
				</div>
			  </div>
			</div>
	
					@if (session("status") && count(session("status")) > 0)
				<div class="card mb-8">
					<div class="card-header">
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
					</div>
				</div>
					@endif
					
				<div class="grid grid-cols-1 gap-6 mt-4">
					<div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
						<div class="card mb-5 overflow-x-scroll">
							<div class="card-header">
								<h2 id="ens_titre">ENSEIGNANTS</h2>
							</div>
							<div class="card-body">
								<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
									<table id="myTable" class="row-border">
									</table>
								</div>
							</div>
						</div>
						<!-- table Détails en Liste des UE enseignées par l'enseignant -->
						<div class="card mb-5 overflow-x-scroll">
							<div class="card-header">
								<h2 id="ens_ue_titre"></h2>
							</div>
							<div class="card-body">
								<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
									<table id="ueTable" class="row-border">
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- table Détails en Liste des UE effectués dans une faculté -->
					<div class="card mb-5 overflow-x-scroll">
						<div class="card-header">
							<h2 id="sce_titre"></h2>
						</div>
						<div class="card-body">
							<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
								<table id="sceTable" class="row-border">
								</table>
							</div>
						</div>
					</div>
				</div>
				
@endsection

@section('js')
<!-- Script for delete modal -->
<script>
var theModal = document.getElementById('modalDelete')
theModal.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theUrl = trigger_source.getAttribute('data-bs-url')
  var theName = trigger_source.getAttribute('data-bs-name')

  var modalUrl = $("#modalUrl");
  var modalTitle = theModal.querySelector('.modal-title')
  var modalBody = theModal.querySelector('#modal_body_p')

  modalTitle.textContent = "Supprimer la séance";
  modalBody.innerHTML = "Voulez-vous vraiment supprimer cette séance ? <br/> Ceci est définitif."
  modalUrl.attr("href", theUrl);
})
</script>



<!-- Script for edit UE modal -->
<script>

var all_ues = {!! json_encode($ues, true); !!}
var theModalUE = document.getElementById('modal_ue')
theModalUE.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var modalTitle = theModalUE.querySelector('.modal-title')

  var modalUE = theModalUE.querySelector('#edit_ue_ue_id')
  var modalDate = theModalUE.querySelector('#edit_ue_date')
  var modalEnsId = theModalUE.querySelector('[name="enseignant_id"]')
  var modalId = theModalUE.querySelector('[name="id"]')
  modalEnsId.value = enseignant_id;
	if (parseInt(trigger_source.getAttribute('data-id')) > 0){
	  modalTitle.textContent = "Modifier l'affectation d'UE";
	  let val = trigger_source.getAttribute('data-id')
	  modalId.value = val;
	  val = trigger_source.getAttribute('data-ue');
	  modalUE.selectedIndex = all_ues.findIndex(obj => {return obj.id == val})

	  let la_dt = trigger_source.getAttribute('data-dt');
	  la_dt = la_dt.substring(0, 10)
	  modalDate.value = la_dt
	  
	} else {
	  modalTitle.textContent = "Ajouter une affectation d'UE";
	  modalUE.value = 0
	  modalId.value = 0
	  modalDate.value = new Date()
  }

})

</script>

<!-- Script for datatable -->
<script>

const dataTable = new DataTable("#myTable", {	
	data: {!! $data !!} ,
	language: {
			"url": "{{ asset('js/i18n/French.json') }}"
		},
    columns: [
		{data: "nom", title: "Nom"},
		{data: "prenoms", title: "Prénoms"},
		{data: "ens_grade.vol_hor_tot", title: "Vol. H"},
        { 
			data: "ues", 
			title: "Nb. UE",
			render:function (data){
				return data.length;
			}		
		}
    ]
});

var add_url = "{{ route('seance.new', ['ens_ue_id' => -1] ); }}"
var enseignant_id = 0;

$('#myTable').on('click', 'td', function () {
	  var table = $('#myTable').DataTable();
	  var cell = table.cell( this ).data(); 
	  // console.log(cell);
	  var tr = $(this).closest('tr');
	  var row = table.row( tr ).data();
	 $("#ens_ue_titre").text("Liste des UE de \"" + row.nom + " " + row.prenoms + "\"");
	 $("#add_ens_ue").show();
	  
    // Toggle highlight class
    $('#myTable td').removeClass('highlighted-cell'); // Remove from all cells
    tr.children('td').addClass('highlighted-cell'); // Add to clicked cell
	  
    ueTable.clear();
    ueTable.rows.add(row.ues);
    ueTable.draw();
	
	enseignant_id = row.id;
	});

const ueTable = new DataTable("#ueTable", {	
	data: {} ,
	language: {
			"url": "{{ asset('js/i18n/French.json') }}"
		},
    columns: [
		{
			data: "date_affectation", 
			title: "Date Aff.",
			render: function (data){
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR');
			}
		},
		{data: "ue.code", title: "Code UE"},
		{data: "ue.intitule", title: "Désignation"},
		{
			data: "id",
			title: "<a id='add_ens_ue' style='display:none' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modal_ue' " +
				"data-id='0' " + 
				"data-dt='' " + 
				"class='btn btn-success'><i class='fas fa-add'></i>Nouveau</a>",
			sorting: false,
            render: function(data, td, row, meta) {
				let url_sup = "{{ route('ens_ue.delete', ['id' => ":id"]); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-3'>" + 
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modal_ue' " +
				"data-id='" + data + "' " + 
				"data-ue='" + row.ue_id + "' " + 
				"data-dt='" + row.date_affectation + "' >" + 
				"<i style='color:blue' class='fas fa-edit'></i></a>" +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-name='" + row.ue.code + " " + row.ue.intitule + "' >" +
				"<i style='color:red' class='fas fa-trash'></i></a> </div>";
            }
		},
    ]
});


$('#ueTable').on('click', 'td', function () {
	  var table = $('#ueTable').DataTable();
	  var cell = table.cell( this ).data(); 
	  // console.log(cell);
	  var tr = $(this).closest('tr');
	  var row = table.row( tr ).data();
	  console.log(row)
	 $("#sce_titre").text("Séances de cours de \"" + row.ue.code + "-" + row.ue.intitule + "\"");
	  
    // Toggle highlight class
    $('#ueTable td').removeClass('highlighted-cell'); // Remove from all cells
    tr.children('td').addClass('highlighted-cell'); // Add to clicked cell
	
	 $("#add_seance").show();
	  
    seanceTable.clear();
    seanceTable.rows.add(row.seances);
    seanceTable.draw();
	$("#add_seance").attr("href", add_url.replace("-1", row.id));
	});

</script>


<!-- Script for datatable -->
<script>
var jours = {!! json_encode(DAYS_OF_WEEK, true); !!}

const seanceTable = new DataTable("#sceTable", {	
	data: {} ,
	language: {
			"url": "{{ asset('js/i18n/French.json') }}"
		},
    columns: [
        { 
			data: "jour_semaine", 
			title: "Jour de semaine",
			render:function (data){
				return jours[data];
			}		
		},
        { 
			data: "date_debut", 
			title: "Débute le",
			render:function (data){
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR');
			}		
		},
        { 
			data: "date_fin", 
			title: "Prends fin le",
			render:function (data){
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR');
			}		
		},
        { 
			data: "heure_debut", 
			title: "de"	
		},
        { 
			data: "heure_fin", 
			title: "à"	
		},
		
		{
			data: "id",
			title: "<a id='add_seance' style='display:none;' class='btn btn-success'><i class='fas fa-add'></i>Nouveau</a>",
			sorting: false,
            render: function(data, td, row, meta) {
				let url_mod = "{{ route('seance.edit', ['id' => ":id"]); }}";
				url_mod = url_mod.replace(":id", data);
				let url_sup = "{{ route('seance.delete', ['id' => ":id"]); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-3'><a href='" + url_mod + "'><i style='color:blue' class='fas fa-edit'></i></a>" +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-name='" + row.libelle + "'> " +
				"<i style='color:red' class='fas fa-trash'></i></a> </div>";
				 
            }
		},
    ]
});

</script>


@endsection