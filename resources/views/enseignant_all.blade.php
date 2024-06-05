@extends('templates.modele')
@section('title', 'Listing du corps professoral')
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


<div>
	@if (session("status") && count(session("status")) > 0)
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
	@endif
	<div class="overflow-x-auto">
		<div class="relative overflow-x-auto shadow-md sm:rounded-lg" >
			<table id="myTable" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
			</table>
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

  modalTitle.textContent = "Supprimer l'enseignant";
  modalBody.innerHTML = "Voulez-vous vraiment supprimer l'enseignant \"" + theName + "\" <br/> Ceci est définitif."
  modalUrl.attr("href", theUrl);
})
</script>
<!-- Script for datatable -->
<script>

const dataTable = new DataTable("#myTable", {
	data: {!! $data !!} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "id", title: "Identifiant",
			render: function(data, td, row, meta) {
                return (data)? "<b style='font-size: 1.5em'>" + data + "</b>" : "";
            }
		
		},
		{data: "nom", title: "Nom"},
		{data: "prenoms", title: "Prénoms"},
		{data: "grade.intitule", title: "Fonction"},
		{
			data: "poste",
			title: "Poste",
			render: function(data, td, row, meta) {
                return (data)? data.libelle : "";
            }
		},
		{data: "detail_poste", title: "détails poste"},
		{
			data: "email",
			title: "Adr. e-mail"
		},
        {
			data: "created_at",
			title: "Créé le",
			render:function (data){
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR') + ' ' + dt.toLocaleTimeString('fr-FR');
			}
		},
		{
			data: "id",
			title: "<a class='btn btn-success' href='{{ route('enseignant.new'); }}'><i class='fas fa-add'></i></a>",
			sorting: false,
            render: function(data, td, row, meta) {
				let url_mod = "{{ route('enseignant.edit', ['id' => ":id"]); }}";
				url_mod = url_mod.replace(":id", data);
				let url_sup = "{{ route('enseignant.delete', ['id' => ":id"]); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-3'><a href='" + url_mod + "'><i class='fas fa-edit' style='color: blue;'></i></a>" +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-name='" + row.nom + " " + row.prenoms + "' " +
				" + ><i class='fas fa-trash' style='color: red;'></i></a> </div>";

            }
		},
    ]
});

/*
const convertedData = simpleDatatables.convertJSON({
  data: '{!! $data !!}'
})

dataTable.insert(convertedData);
*/
</script>

@endsection
