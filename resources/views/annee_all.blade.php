@extends('templates.modele')
@section('title', "Années Académiques")
@section('sidebar')
    @parent

@endsection
 
@section('content')

			<div id="modalOnOff" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				  <div class="modal-body">
					<p id="modal_body_onoff">Modal body text goes here.</p>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">NON</button>
					<a id="modalUrlOnOff" class="btn btn-success" href=''>OK</a>
				  </div>
				</div>
			  </div>
			</div>

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
			
			<div id="modalEdit" class="modal" tabindex="-1">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title">Modal title</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				  </div>
				   <form action="{{ route('annee.save') }}" method="POST">	
					<div class="modal-body">			
					@csrf
						<input type="hidden" id="id" name="id">
						<div class="grid grid-cols-2 gap-6 mt-4">	
							<div>
								<label class="text-black dark:text-gray-200" for="val">Année</label>
								<input id="val" name="val" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							</div>
				
							<div>
								<label class="text-black dark:text-gray-200" for="intitule">&nbsp;</label>
								<input id="valNxt" readonly type="text" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
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
			
<div class="card mb-4">
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
	<div class="card-body">
		<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
			<table id="myTable" class="row-border">
			</table>
		</div>
	</div>
</div>
@endsection


@section('js')
<!-- Script for onoff modal -->
<script>
var theModalOnOff = document.getElementById('modalOnOff')
theModalOnOff.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theUrl = trigger_source.getAttribute('data-bs-url')
  var theName = trigger_source.getAttribute('data-bs-name')

  var modalUrl = $("#modalUrlOnOff");
  var modalTitle = theModalOnOff.querySelector('.modal-title')
  var modalBody = theModalOnOff.querySelector('#modal_body_onoff')

  modalTitle.textContent = "";
  modalBody.innerHTML = "Confirmez-vous " + theName + " ?"
  modalUrl.attr("href", theUrl);
})
</script>
<!-- Script for delete modal -->
<script>
var theModalDel = document.getElementById('modalDelete')
theModalDel.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var theUrl = trigger_source.getAttribute('data-bs-url')
  var theName = trigger_source.getAttribute('data-bs-name')

  var modalUrl = $("#modalUrl");
  var modalTitle = theModalDel.querySelector('.modal-title')
  var modalBody = theModalDel.querySelector('#modal_body_p')

  modalTitle.textContent = "Supprimer l'Année Académique";
  modalBody.innerHTML = "Voulez-vous vraiment supprimer " + theName + " ? <br/> Ceci est définitif."
  modalUrl.attr("href", theUrl);
})
</script>

<!-- Script for edit modal -->
<script>
var theModalEdt = document.getElementById('modalEdit')
theModalEdt.addEventListener('show.bs.modal', function (event) {
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
	console.log(row_data)
  } else {
	theId = 0;
  }
  
  var modalTitle = theModalEdt.querySelector('.modal-title')
  var modalAnnee = theModalEdt.querySelector('#val')
  var modalAnneePlus = theModalEdt.querySelector('#valNxt')
  var modalId = theModalEdt.querySelector('#id')

  modalTitle.textContent = (theId == 0) ? "Nouvelle Année" : "Modifier l'année";
  if(theId > 0){
	  let parts = row_data.libelle.split(' - ');
	  modalAnnee.value = parts[0];
	  modalAnneePlus.value = parts[1];
  } else {
	  let x = new Date().getUTCFullYear();
	  modalAnnee.value = x;
	  modalAnneePlus.value = x + 1;
  }
  modalId.value = (theId > 0) ? row_data.id : 0;

})



valChange = function(event){
	let theVal = theModalEdt.querySelector('#val');
	let theValNxt = theModalEdt.querySelector('#valNxt');
	if (theVal.value == ""){
	  let x = new Date().getUTCFullYear();
	  theVal.value = x;
	}
	theValNxt.value = parseInt(theVal.value, 10) + 1
}
theModalEdt.querySelector('#val').addEventListener('input', valChange)
theModalEdt.querySelector('#val').addEventListener('change', valChange)
</script>
<!-- Script for datatable -->
<script>

const dataTable = new DataTable("#myTable", {	
	data: {!! $data !!} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{
			data: "libelle", 
			title: "Année"
		},
		{
			data: "open", title: "Etat",
            render: function(data, td, row, meta) {
				return data ? "En cours" : "Clôturée"
			}
		},
		{
			data: "id",
			title: "<a class='btn btn-success' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEdit' " +
				"data-bs-id='0' " +
				" ><i class='fas fa-add'></i></a>",
			sorting: false,
            render: function(data, td, row, meta) {
				let icone_onoff = (row.open) ? "fas fa-lock" : "fas fa-unlock-alt"
				let link_onoff = "<a  class='p-2' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalOnOff' " +
				"data-bs-name='" + ((row.open) ? "la clôture de " : "la réouverture de ") + row.libelle + "' " +
				"data-bs-url='{{ route('annee.on_off', ['id' => -1]); }}' " +
				"data-bs-id='" + row.id + "' >" +
				"<i class='" + icone_onoff + "'></i>" +
				"</a>";
				let link_mod = "<a  class='p-2' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalEdit' " +
				"data-bs-id='" + row.id + "' " +
				" ><i class='fas fa-edit'></i></a>";
				let url_sup = "{{ route('annee.delete', ['id' => -1]); }}";
				url_sup = url_sup.replace("-1", data);
				let link_sup = "<a class='p-2' href='#' " +
				"data-bs-toggle='modal' " +
				"data-bs-target='#modalDelete' " +
				"data-bs-url='" + url_sup + "' " +
				"data-bs-name='" + row.libelle + "' >" +
				"<i class='fas fa-trash'></i></a>"
				link_onoff = link_onoff.replace("-1", data);
				if (row.open == 0){
					link_mod = ""
					link_sup = ""
				}
                return "<div class='gap-3'>" +
				link_onoff +
				link_mod +
				link_sup +
				" </div>";
				 
            }
		},
    ]
});
</script>

@endsection