@extends('templates.modele')
@section('title', "Liste des filières DE {$faculte->code} et leur ue")
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
				
				<div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
					<div class="card mb-7 overflow-x-scroll">
						<div class="card-body">
							<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
								<table id="myTable" class="row-border">
								</table>
							</div>
						</div>
					</div>
					<!-- table Détails en Liste des UE effectués dans une faculté -->
					<div class="card mb-5 overflow-x-scroll">
						<div class="card-header">
							<h2 id="fac_ue_titre"></h2>
						</div>
						<div class="card-body">
							<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
								<table id="myTableDtl" class="row-border">
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

  modalTitle.textContent = "Supprimer la filière";
  modalBody.innerHTML = "Voulez-vous vraiment supprimer la filière \"" + theName + "\" <br/> Ceci est définitif."
  modalUrl.attr("href", theUrl);
})
</script>
<!-- Script for datatable -->
<script>

add_fil = "{{ route('filiere.new', ['fac_id' => $fac_id]); }}";
const dataTable = new DataTable("#myTable", {	
	data: {!! $data !!} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "nom", title: "Nom"},
        { 
			data: "ues", 
			title: "Nb. UE",
			render:function (data){
				return data.length;
			}		
		},
		{
			data: "id",
			title: "<a class='btn btn-success' href='" + add_fil + "'><i class='fas fa-add'></i></a>",
			sorting: false,
            render: function(data, td, row, meta) {
				let url_mod = "{{ route('filiere.edit', ['id' => ':id']); }}";
				url_mod = url_mod.replace(":id", data);
				let url_sup = "{{ route('filiere.delete', ['id' => ':id']); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-1'><a href='" + url_mod + "'><i style='color:blue' class='fas fa-edit'></i></a>" +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-name='" + row.libelle + "' " +
				" + ><i style='color:red' class='fas fa-trash'></i></a> </div>";
				 
            }
		},
    ]
});


$('#myTable').on('click', 'td', function () {
	  var table = $('#myTable').DataTable();
	  var cell = table.cell( this ).data(); 
	  // console.log(cell);
	  var tr = $(this).closest('tr');
	  var row = table.row( tr ).data();
	 $("#fac_ue_titre").text("Liste des UE de \"" + row.nom + "\"");
	  
	  
    detailTable.clear();
    detailTable.rows.add(row.ues);
    detailTable.draw();
	});

const detailTable = new DataTable("#myTableDtl", {	
	data: {} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "semestre", title: "Sem."},
		{data: "ue.code", title: "Code UE"},
		{data: "ue.intitule", title: "Désignation"},
		{data: "volume_horaire", title: "Vol.H"},
		{
			data: "id",
			title: "",
			sorting: false,
            render: function(data, td, row, meta) {
				let url = "{{ route('seance.show', ['fac_ue_id' => ':id']); }}";
				url = url.replace(":id", data);
                return "<a href='" + url + "'> <i class='fa fa-cogs'></i> </a>";
				 
            }
		},
    ]
});

</script>

@endsection