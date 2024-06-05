@extends('templates.modele')
@section('title', $id > 0 ? "Modifier les informations de l'enseignant" : "Enregistrer les informations d'un enseignant")
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
						
								<div id="modal_spec" class="modal" tabindex="-1">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title">Modal title</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									  </div>
									<!-- <form action="#" method="get"> -->
										<div class="modal-body">
											<div>
												<input id="edit_spec_num" type="hidden" />
												<label class="text-white dark:text-gray-200" for="edit_spec_id">Spécialité</label>
												<select id="edit_spec_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
												@foreach ($specs as $spec)
													<option value="{{ $spec->id }}" >{{ $spec->intitule }}</option>
												@endforeach 
												</select>
											</div>
										</div>
									<!-- </form> -->	
										<div class="modal-footer">
											<a class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</a>
											<button type="button" id="modal_spec_save" class="btn btn-success">ENREGISTRER</button>
										</div>	
									</div>
								  </div>
								</div>
		
            <form action="{{ route('enseignant.save') }}" method="POST"  enctype="multipart/form-data" >				
			@csrf
				<input type="hidden" value="{{$id}}" name="id">
				<input type="hidden" value="{{ isset($data['user_id'])?$data['user_id'] : 0 }}" name="user_id">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">				
				
				
                    <div>
                        <label class="text-white dark:text-gray-200" for="nom">Nom</label>
                        <input id="nom" name="nom" type="text"  value="{{ isset($data['nom'])?$data['nom'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="prenoms">Prénoms</label>
                        <input id="prenoms" name="prenoms" type="text" value="{{ isset($data['prenoms'])?$data['prenoms'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>     
					
                    <div>
                        <label class="text-white dark:text-gray-200" for="email">email</label>
                        <input id="email" name="email" type="email" 
						value="{{ isset($data['email'])? $data['email'] : '' }}" 
						class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    <div>
						<input type="hidden" value="{{$ens_grade_id}}" name="ens_grade_id">
                        <label class="text-white dark:text-gray-200" for="grade_id">Fonction</label>
                        <select id="grade_id" name="grade_id" required="required" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						@foreach ($grades as $grade)
							<option 
								value="{{ $grade->id }}" 
								{{ (isset($data['grade_id'])? ($data['grade_id'] == $grade->id ? "selected" : "") : "") }} 
							>
							{{ $grade->intitule }}
							</option>
						@endforeach       
                        </select>
                    </div>
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="poste_id">Poste</label>
                        <select id="poste_id" name="poste_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							<option value="0" ></option>
						@foreach ($postes as $poste)
							<option 
								value="{{ $poste->id }}" 
								{{ (isset($data['poste_id'])? ($data['poste_id'] == $poste->id ? "selected" : "") : "") }} 
							>
							{{ $poste->libelle }}
							</option>
						@endforeach 
                        </select>
                    </div>
        
                    <div>
                        <label class="text-white dark:text-gray-200" for="detail_poste">Détails poste</label>
                        <input type="text" id="detail_poste" name="detail_poste" value="{{ isset($data['detail_poste'])?$data['detail_poste'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>
                    <div>
					
					
                        <label class="text-white dark:text-gray-200" for="spec_liste">
							Spécialité
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
							<a  data-bs-toggle='modal'
								data-bs-target='#modal_spec'	
								data-type='add'				
								style="font-size:2em; color:white; font-weight:bold;">
								<i class="fa fa-add"></i>
							</a>
						</label>
						<div class="relative overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg">
							<table id="spec_liste" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
								<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
									<tr>
										<th scope="col" class="px-3 py-3">
											Code
										</th>
										<th scope="col" class="px-6 py-3">
											Spécialité
										</th>
										<th scope="col" class="px-3 py-3">
											
										</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($specialites as $cpt=>$spec)
									<tr id="spec_row_{{$cpt}}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
										<td class="px-3 py-4">
											<input type="hidden" name="ens_spec_del[{{$cpt}}]" value="0"/>
											<input type="hidden" name="ens_spec_id[{{$cpt}}]" value="{{ $spec->id }}"/>
											<input type="hidden" name="spec_id[{{$cpt}}]" value="{{ $spec->specialite_id }}"/>
											<span id="spec_code_{{$cpt}}" > {{ $spec->specialite->code }} </span>
										</td>
										<td class='px-6 py-4'> 
											<span id="spec_intitule_{{$cpt}}" > {{ $spec->specialite->intitule }} </span>
										</td>
										<td class="px-3 py-4">
											<a data-num="{{ $cpt }}" 
												data-bs-toggle='modal'
												data-bs-target='#modal_spec'		
												data-type='edit'									
											style="font-size:18px; color:blue">
												<i class="fa fa-edit"></i>
											</a>
											&nbsp;
											&nbsp;
											<a data-num="{{ $cpt }}"
												data-type="del"
												onclick="remove_spec_num({{ $cpt }})"
												style="font-size:18px; color:red" >
													<i class="fa fa-trash"></i>
											</a>
										</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>

                    </div>

                    <div>
						<div style="margin-bottom: 1em;">
							<label class="text-white dark:text-gray-200" for="type_piece_id">Pièce d'identité</label>
							<select id="type_piece_id" name="type_piece_id" required="required" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
							@foreach ($types as $type)
								<option 
									value="{{ $type->id }}" 
									{{ (isset($data['type_piece_id'])? ($data['type_piece_id'] == $type->id ? "selected" : "") : "") }} 
								>
								{{ $type->libelle }}
								</option>
							@endforeach
							</select>
						</div>

                        <label class="block text-sm font-medium text-white" for="file-upload-div">
                        Pièce d'identité jointe
                      </label>
                      <div id="file-upload-div" class="grid grid-cols-1 gap-6 mt-4 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
						<div class="flex justify-center">
							<img id="img_piece" src="{{ $piece }}" />
						</div>
                        <div class="space-y-1 text-center">
                          <svg class="mx-auto h-12 w-12 text-white" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                          <div class="flex  justify-center text-sm text-gray-600">
                            <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                              <span class="">Charger l'image de la pièce</span>
                              <input id="file-upload" name="file-upload" type="file" class="sr-only" accept=".jpg, .jpeg, .png">
                            </label>
                          </div>
                          <p class="text-xs text-white">
                            PNG, JPG jusqu'à 10MB
                          </p>
                        </div>
                      </div>
                    </div>
                </div>
        
                <div class="flex justify-end mt-6">
                    <a class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600" href="{{ route('enseignant.show') }}">ANNULER</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')

<script>
$('document').ready(function () {
    $("#file-upload").change(function () {
        if (this.files && this.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#img_piece').attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
        }
    });
});
</script>

<!-- Script for edit spec modal -->
<script>

var all_specs = {!! json_encode($specs, true); !!}
var theModal = document.getElementById('modal_spec')
theModal.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var modalTitle = theModal.querySelector('.modal-title')
  var type = trigger_source.getAttribute('data-type');

  var modalSpec = theModal.querySelector('#edit_spec_id')
  var modalRowNum = theModal.querySelector('#edit_spec_num')
	if (type == 'edit'){
	  modalTitle.textContent = "Choisir la spécialité";
	  let le_num = trigger_source.getAttribute('data-num')
	  let val = document.querySelector("[name='spec_id[" + le_num + "]']").value
	  modalSpec.selectedIndex = all_specs.findIndex(obj => {return obj.id == val})
	  modalRowNum.value = le_num;
	} else {
	  modalTitle.textContent = "Ajouter une spécialité";
	  modalSpec.value = 0
	  modalRowNum.value = -1
  }

})

var btnSave = document.getElementById('modal_spec_save')
var modalForm = document.getElementById('modal_spec_form')
btnSave.addEventListener('click', function (event) {
  var tbody = document.querySelector('#spec_liste tbody')

  new bootstrap.Modal(theModal).hide()
  var modalSpec = theModal.querySelector('#edit_spec_id')
  var chosenSpec = modalSpec.options[modalSpec.selectedIndex].value
  var modalRowNum = theModal.querySelector('#edit_spec_num')
  var la_spec = all_specs.filter(obj => {return obj.id == chosenSpec})

  if (la_spec.length > 0)
	if (modalRowNum.value == -1){
		let cpt = tbody.rows.length + 1;
            var dynamicRowHTML = ""
			dynamicRowHTML += "		<tr id='spec_row_" + cpt + "' class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'> ";
			dynamicRowHTML += "		<td class='px-3 py-4'> ";
			dynamicRowHTML += "			<input type='hidden' name='ens_spec_del[" + cpt + "]' value='0'/> ";
			dynamicRowHTML += "			<input type='hidden' name='ens_spec_id[" + cpt + "]' value='0'/> "
			dynamicRowHTML += "			<input type='hidden' name='spec_id[" + cpt + "]' value='" + la_spec[0].id + "'/>";
			dynamicRowHTML += "			<span id='spec_code_" + cpt + "' > " + la_spec[0].code + " </span> ";
			dynamicRowHTML += "		</td> ";
			dynamicRowHTML += "		<td class='px-6 py-4'> ";
			dynamicRowHTML += "			<span id='spec_intitule_" + cpt + "' > " + la_spec[0].intitule + " </span> ";
			dynamicRowHTML += "		</td> ";
			dynamicRowHTML += "		<td class='px-3 py-4'> ";
			dynamicRowHTML += "			<a data-num='" + cpt + "' "; 
			dynamicRowHTML += "				data-bs-toggle='modal' ";
			dynamicRowHTML += "				data-bs-target='#modal_spec' ";		
			dynamicRowHTML += "				data-type='edit'	";					
			dynamicRowHTML += "			style='font-size:18px; color:blue'>";
			dynamicRowHTML += "				<i class='fa fa-edit' ></i>";
			dynamicRowHTML += "			</a>";
			dynamicRowHTML += "			&nbsp;";
			dynamicRowHTML += "			&nbsp;";
			dynamicRowHTML += "			<a data-num='" + cpt + "'";
			dynamicRowHTML += "				data-type='del' ";
			dynamicRowHTML += "				onclick=\"remove_spec_num(" + cpt + ")\" ";
			dynamicRowHTML += "			  style='font-size:18px; color:red'>";
			dynamicRowHTML += "					<i class='fa fa-trash'></i>";
			dynamicRowHTML += "			</a> ";
			dynamicRowHTML += "		</td> ";
			dynamicRowHTML += "		</tr> ";
			
			try{
				document.querySelector('#spec_liste tbody').innerHTML += dynamicRowHTML;
				
			} catch (e){
				console.log(e)
			}
	} else {
		let cpt = modalRowNum.value;
		tbody.querySelector("[name='spec_id[" + cpt + "]']").value = la_spec[0].id;
		tbody.querySelector("#spec_code_" + cpt ).innerHTML = la_spec[0].code;
		tbody.querySelector("#spec_intitule_" + cpt ).innerHTML = la_spec[0].intitule;		
	}
	
})

//Remove a spec row
var remove_spec = function (event){
	var cpt = event.target.getAttribute("data-num");
	document.querySelector("#spec_row_" + cpt).style.display = 'none';
}
var remove_spec_num = function (num){
	document.querySelector("#spec_row_" + num).style.display = 'none';
	document.querySelector("[name=\"ens_spec_del[" + num + "]\"]").value = 1;
}
//document.querySelectorAll("#spec_liste [data-type='del']").addEventListener('click', remove_spec)

</script>



@endsection
