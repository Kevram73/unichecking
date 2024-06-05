@extends('templates.modele')
@section('title', 'Postes administratifs et catégories')
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



			<div id="modalEditPst" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				   <form action="{{ route('poste.save') }}" method="POST">
					<div class="modal-body">
					@csrf
						<input type="hidden" id="id" name="id" />
						<input type="hidden" id="categorie_poste_id" name="categorie_poste_id" />
						<div class="grid grid-cols-1 gap-6 mt-4">
							<div>
								<label class="text-black dark:text-gray-200" for="libelle">Désignation</label>
								<input id="libelle" name="libelle" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" />
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


			<div id="modalEditCat" class="modal" tabindex="6">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				   <form action="{{ route('poste.save_cat') }}" method="POST">
					<div class="modal-body">
					@csrf
						<input type="hidden" id="id_cat" name="id" />
						<div class="grid grid-cols-1 gap-6 mt-4">
							<div>
								<label class="text-black dark:text-gray-200" for="libelle_cat">Catégorie</label>
								<input id="libelle_cat" name="libelle" type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" />
							</div>
							<div>
								<label class="text-black dark:text-gray-200" for="libelle_cat">Exonération horaire</label>
								<input id="exoneration_horaire" name="exoneration_horaire" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring" />
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
						<div class="card-header">
							<h2 style="font-weight:bold">CATEGORIES</h2>
						</div>
						<div class="">
							<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
								<table id="myTable" class="row-border">
								</table>
							</div>
						</div>
					</div>
					<!-- table Détails en Liste des UE effectués dans une faculté -->
					<div class="card mb-5 overflow-x-scroll">
						<div class="card-header">
							<h2 id="fac_ue_titre" style="font-weight:bold">VEUILLEZ CHOISIR LA CATEGORIE</h2>
						</div>
						<div class="">
							<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
								<table id="myTableDtl" class="row-border">
								</table>
							</div>
						</div>
					</div>
				</div>

@endsection


@section('js')

<!-- Script for edit modal -->
<script>
var theModalEdtCat = document.getElementById('modalEditCat')
theModalEdtCat.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theId = trigger_source.getAttribute('data-bs-id')
  var theName = trigger_source.getAttribute('data-bs-name')
  var rows = null
  var row_data = null


  if (theId > 0)
	rows = dataTable.rows( function ( idx, data, node ) {
        return data.id == theId ?
            true : false;
    } ).data();
  if (rows && rows.length > 0) {
	row_data = rows[0]
  } else {
	theId = 0;
  }

	  var modalTitle = theModalEdtCat.querySelector('.modal-title')
	  var modalLibelle = theModalEdtCat.querySelector('#libelle_cat')
	  var modalId = theModalEdtCat.querySelector('#id_cat')
	  var modalExo = theModalEdtCat.querySelector('#exoneration_horaire')

	  modalTitle.textContent = (theId == 0) ? "Nouveau Catégorie": "Modifier la Catégorie" ;
	  modalLibelle.value = (theId > 0) ? row_data.libelle : '';
	  modalId.value = (theId > 0) ? row_data.id : 0;
	  modalExo.value = (theId > 0) ? row_data.exoneration_horaire : 0;

})
</script>

<!-- Script for edit modal Poste -->
<script>
var theModalEdtPst = document.getElementById('modalEditPst')
theModalEdtPst.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theId = trigger_source.getAttribute('data-bs-id')
  var theCatId = trigger_source.getAttribute('data-bs-catid')
  var theName = trigger_source.getAttribute('data-bs-name')
  var rows = null
  var row_data = null
  if (theCatId == 0) theCatId = cat_id;
  if (theId > 0)
	rows = detailTable.rows( function ( idx, data, node ) {
        return data.id == theId ?
            true : false;
    } ).data();
  if (rows && rows.length > 0) {
	row_data = rows[0]
  } else {
	theId = 0;
  }

  var rows_cat = null
  var row_data_cat = null
  if (theCatId > 0)
	rows_cat = dataTable.rows( function ( idx, data, node ) {
        return data.id == theCatId ?
            true : false;
    } ).data();
  if (rows_cat && rows_cat.length > 0) {
	row_data_cat = rows_cat[0]
  } else {
	theCatId = 0;
  }

  console.log(theCatId)
  if (theCatId > 0){
	  var modalTitle = theModalEdtPst.querySelector('.modal-title')
	  var modalLibelle = theModalEdtPst.querySelector('#libelle')
	  var modalId = theModalEdtPst.querySelector('#id')
	  var modalCatId = theModalEdtPst.querySelector('#categorie_poste_id')

	  modalTitle.textContent = "Catégorie \"" + row_data_cat.libelle + "\"  - " + ( (theId == 0) ? "Nouveau Poste": "Modifier la Poste" );
	  modalLibelle.value = (theId > 0) ? row_data.libelle : '';
	  modalId.value = (theId > 0) ? row_data.id : 0;
	  modalCatId.value = theCatId;

  } else
	  $('#modalEditPst').modal('hide');

})
</script>
<!-- Script for delete modal -->
<script>
var theModal = document.getElementById('modalDelete')
theModal.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theUrl = trigger_source.getAttribute('data-bs-url')
  var theTitle = trigger_source.getAttribute('data-bs-title')
  var theName = trigger_source.getAttribute('data-bs-name')

  var modalUrl = $("#modalUrl");
  var modalTitle = theModal.querySelector('.modal-title')
  var modalBody = theModal.querySelector('#modal_body_p')

  modalTitle.textContent = theTitle;
  modalBody.innerHTML = "Voulez-vous vraiment supprimer " + theName + " <br/> Ceci est définitif."
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
		{data: "libelle", title: "Désignation"},
		{data: "exoneration_horaire", title: "Exonérat°. Horaire"},
		{
			data: "id",
			title: "<a class='btn btn-success' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEditCat' " +
				"data-bs-id='0' " +
				" ><i class='fas fa-add'></i></a>",
			sorting: false,
            render: function(data, td, row, meta) {

				let link_mod = "<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEditCat' " +
				"data-bs-id='" + row.id + "' " +
				" ><i class='fas fa-edit' style='color: blue;'></i></a>";
				let url_sup = "{{ route('poste.delete_cat', ['id' => ":id"]); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-3'>" + link_mod +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-title='Supprimer la catégorie' " +
				"data-bs-name='la catégorie \"" + row.libelle + "\"' " +
				" + ><i style='color:red' class='fas fa-trash'></i></a> </div>";
            }
		},
    ]
});

var cat_id = 0;
$('#myTable').on('click', 'td', function () {
	  var table = $('#myTable').DataTable();
	  var cell = table.cell( this ).data();
	  // console.log(cell);
	  var tr = $(this).closest('tr');
	  var row = table.row( tr ).data();

      $('#myTable td').removeClass('highlighted-cell'); // Remove from all cells
    tr.children('td').addClass('highlighted-cell');

	 $("#fac_ue_titre").text("POSTE DE LA CATEGORIE \"" + row.libelle + "\"");

	cat_id = row.id


	$('#poste_new').show();
    detailTable.clear();
    detailTable.rows.add(row.postes);
    detailTable.draw();
	});

const detailTable = new DataTable("#myTableDtl", {
	data: {} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "libelle", title: "libelle"},
		{
			data: "id",
			title: "<a id='poste_new' style='display:none;' class='btn btn-success' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEditPst' " +
				"data-bs-id='0' " +
				"data-bs-catid='0' " +
				" ><i class='fas fa-add'></i></a>",
			sorting: false,
            render: function(data, td, row, meta) {

				let link_mod = "<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEditPst' " +
				"data-bs-id='" + row.id + "' " +
				"data-bs-catid='" + row.categorie_poste_id + "' " +
				" ><i class='fas fa-edit' style='color: blue;'></i></a>";
				let url_sup = "{{ route('poste.delete', ['id' => ":id"]); }}";
				url_sup = url_sup.replace(":id", data);
                return "<div class='gap-3'>" + link_mod +
                "&nbsp;&nbsp;&nbsp;" +
				"<a href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-title='Supprimer le poste' " +
				"data-bs-name=' le poste \"" + row.libelle + "\"' " +
				" + ><i style='color:red' class='fas fa-trash'></i></a> </div>";
            }
		},
    ]
});

</script>

@endsection
