@extends('templates.modele')
@section('title', 'Contrôles biométriques')
@section('sidebar')
    @parent

@endsection
 
@section('content')
			
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
	<div class="card-body overflow-x-auto">
		<div class="datatable-wrapper datatable-loading no-footer sortable searchable" >
			<table id="myTable" class="row-border">
			</table>
		</div>
	</div>
</div>
@endsection


@section('js')
<!-- Script for datatable -->
<script>
var row_id = 0;
const dataTable = new DataTable("#myTable", {	
	data: {!! $data !!} ,
	language: {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/French.json"
		},
    columns: [
		{data: "enseignant", title: "Enseignant"},
		{data: "faculte", title: "Faculté"},
		{data: "filiere", title: "Filière"},
		{data: "semestre", title: "Sem."},
		{data: "ue_name", title: "UE"},
		{
			data: "heure_debut", 
			title: "Heure Début prévue"
		},
		{
			data: "heure_fin", 
			title: "Heure Fin prévue"
		},
        { 
			data: "heure_scan_deb", 
			title: "Heure rentrée réelle",
			render:function (data){
				if (isNaN(Date.parse(data))) return "";
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR') + ' ' + dt.toLocaleTimeString('fr-FR');
			}		
		},
        { 
			data: "heure_scan_fin", 
			title: "Heure sortie réelle",
			render:function (data){
				if (isNaN(Date.parse(data))) return "";
				dt = new Date(data);
				return dt.toLocaleDateString('fr-FR') + ' ' + dt.toLocaleTimeString('fr-FR');
			}		
		},
        { 
			data: "nb_hr_cpt", 
			title: "NB Hr Comptées (en h)",		
		},
		{
			data: "id",
			title: "",
			sorting: false,
            render: function(data, td, row, meta) {
				let url_sup = "{{ route('rapport.delete', ['id' => -1]); }}";
				url_sup = url_sup.replace("-1", data);
                return "<div> " +
				"<a href='" + url_sup + "' > " +
				" <i style='color:red' class='fas fa-trash'></i></a> </div>";
            }
		},
    ]
});

</script>

@endsection