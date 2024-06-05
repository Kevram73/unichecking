@extends('templates.modele')
@section('title', $id > 0 ? "Modifier informations séance de cours" : "Enregistrer informations séance de cours")
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

						
								<div id="modal_ue" class="modal" tabindex="-1">
								  <div class="modal-dialog">
									<div class="modal-content">
									  <div class="modal-header">
										<h5 class="modal-title">Modal title</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									  </div>
									<!-- <form action="#" method="get"> -->
										<div class="modal-body">
											<div>
												<input id="edit_ue_num" type="hidden" />
												<label class="text-black dark:text-gray-200" for="edit_ue_fac_id">Faculté</label>
												<select id="edit_ue_fac_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
												@foreach ($facultes as $fac)
													<option value="{{ $fac->id }}" >{{ $fac->code }}</option>
												@endforeach 
												</select>
											</div>				
											<div>
												<label class="text-black dark:text-gray-200" for="edit_ue_fil_id">Filière</label>
												<select id="edit_ue_fil_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">

												</select>
											</div>			
											<div>
												<label class="text-black dark:text-gray-200" for="edit_ue_semestre">Semestre</label>
												<input id="edit_ue_semestre" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
											</div>
										</div>
									<!-- </form> -->	
										<div class="modal-footer">
											<a class="btn btn-secondary" data-bs-dismiss="modal">ANNULER</a>
											<button type="button" id="modal_ue_save" class="btn btn-success">ENREGISTRER</button>
										</div>	
									</div>
								  </div>
								</div>		
		
		
		
            <form action="{{ route('seance.save') }}" method="POST">				
			@csrf
				<input type="hidden" value="{{$id}}" name="id">
				<input type="hidden" value="{{$ens_ue_id}}" name="enseignant_ue_id">
				<input type="hidden" value="{{$ens_ue->ue_id}}" name="ue_id">
                <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">				
				
                    <div>
                        <label class="text-white dark:text-gray-200" >Enseignant</label>
                        <span>
						
							<input type="hidden" value="{{ isset($ens_ue['enseignant_id'])?$ens_ue['enseignant_id'] : 0 }}" id="enseignant_id" name="enseignant_id"/>
							<input id="sce_name" type="text" readonly
							value="{{ isset($ens_ue['enseignant'])? $ens_ue['enseignant']['nom'] . ' ' . $ens_ue['enseignant']['prenoms'] : '' }}" 
							class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						</span>						
					</div>
 				
                    <div>
                        <label class="text-white dark:text-gray-200" >Unité d'Enseignement</label>
                        <span>						
							<input type="hidden" 
									value="{{
										isset($ens_ue) 
										? $ens_ue['ue']['id'] 
										: 0 }}"	/>			
							<input type="text"  readonly
									value="{{
										isset($ens_ue) 
										? $ens_ue['ue']['code'] . ' ' . $ens_ue['ue']['intitule'] 
										: '' }}"	
									class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"	
										/>

						</span>						
					</div>
					<div>
                        <label class="text-white dark:text-gray-200" for="jour_semaine">Jour de la semaine</label>
                        <select id="jour_semaine" name="jour_semaine" required="required" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
						@foreach ($jours as $j_ndx=>$j)
							<option 
								value="{{ $j_ndx }}" 
								{{ (isset($data['jour_semaine'])? ($data['jour_semaine'] == $j_ndx ? "selected" : "") : "") }} 
							>
							{{ $j }}
							</option>
						@endforeach
                        </select>
                    </div>
					<div>
						&nbsp;
					</div> 
                    <div>
                        <label class="text-white dark:text-gray-200" for="heure_debut">Heure Début</label>
                        <input id="heure_debut" name="heure_debut" type="time" value="{{ isset($data['heure_debut'])?$data['heure_debut'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>    					
                    <div>
                        <label class="text-white dark:text-gray-200" for="heure_fin">Heure_fin</label>
                        <input id="heure_fin" name="heure_fin" type="time" value="{{ isset($data['heure_fin'])?$data['heure_fin'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>    					
                    <div>
                        <label class="text-white dark:text-gray-200" for="date_debut">Date début</label>
                        <input id="date_debut" name="date_debut" type="date" value="{{ isset($data['date_debut'])?$data['date_debut'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>    					
                    <div>
                        <label class="text-white dark:text-gray-200" for="libelle">Date fin</label>
                        <input id="date_fin" name="date_fin" type="date" value="{{ isset($data['date_fin'])?$data['date_fin'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>     

					<div>
						<label class="text-white dark:text-gray-200">&nbsp;</label>
					</div> 
				</div>				
				<div class="relative overflow-x-auto shadow-md sm:rounded-lg pt-4">
					<p>
						<a  data-bs-toggle='modal'
							data-bs-target='#modal_ue'	
							data-type='add'				
							style="font-size:2em; color:white; font-weight:bold;">
							<i class="fa fa-add"></i>
						</a>
					</p>
					<table id="ue_liste" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
						<thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
							<tr>
								<th scope="col" class="px-3 py-3">
									Faculté
								</th>
								<th scope="col" class="px-3 py-3">
									Filière
								</th>
								<th scope="col" class="px-2 py-3">
									Semestre
								</th>
								<th scope="col" class="px-2 py-3">

								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($affectations as $cpt=>$aff)
							<tr id="sce_ue_row_{{$cpt}}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
								<td class="px-6 py-4">
									<input type="hidden" name="sce_ue_del[{{$cpt}}]" value="0"/>
									<input type="hidden" name="sce_ue_id[{{$cpt}}]" value="{{ $aff->id }}"/>
									<input type="hidden" name="faculte_id[{{$cpt}}]" value="{{ $aff->faculte_id }}"/>
									<input type="hidden" name="filiere_id[{{$cpt}}]" value="{{ $aff->filiere_id }}"/>
									<span id='sce_ue_fac_intitule_{{$cpt}}' > {{ $aff->faculte->code }} </span>								
								</td>
								<td class="px-6 py-4">
									<span id='sce_ue_fil_intitule_{{$cpt}}' > {{ $aff->filiere->nom }} </span>								
								</td>
								<td class="px-6 py-4">
									<input type="hidden" name="semestre[{{$cpt}}]" value="{{ $aff->semestre }}"/>	
									<span id='sce_ue_semestre_{{$cpt}}' > {{ $aff->semestre }} </span>									
								</td>
								<td class="px-2 py-4">
									<a data-num="{{ $cpt }}" 
										data-bs-toggle='modal'
										data-bs-target='#modal_ue'		
										data-type='edit'									
									style="font-size:18px">
										<i class="fa fa-edit"></i>
									</a>
									&nbsp;
									&nbsp;
									<a data-num="{{ $cpt }}"
										data-type="del"
										onclick="remove_ue_num({{ $cpt }})"
										style="font-size:18px; color:red" >
											<i class="fa fa-trash"></i>
									</a>
								</td>
								
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
                <div class="flex justify-end mt-6">
                    <a  href="{{ route('seance.show') }}" class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">
					ANNULER
					</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
			
			
			
        </section> 


@endsection


@section('js')


<!-- Script for edit UE modal -->
<script>

var all_facs = {!! json_encode($facultes, true); !!}

var theModalUE = document.getElementById('modal_ue')
theModalUE.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var modalTitle = theModalUE.querySelector('.modal-title')
  var type = trigger_source.getAttribute('data-type');

  var modalFac = theModalUE.querySelector('#edit_ue_fac_id')
  var modalFil = theModalUE.querySelector('#edit_ue_fil_id')
  var modalSem = theModalUE.querySelector('#edit_ue_semestre')
  var modalRowNum = theModalUE.querySelector('#edit_ue_num')
	if (type == 'edit'){
	  modalTitle.textContent = "Modifier l'affectation d'UE";
	  let le_num = trigger_source.getAttribute('data-num')
	  let val = 0
	  
	  val = document.querySelector("[name='faculte_id[" + le_num + "]']").value
	  let fac_ndx = all_facs.findIndex(obj => {return obj.id == val})
	  modalFac.selectedIndex = fac_ndx
	  let all_fils = []
	  if (fac_ndx > -1)
		  all_fils = all_facs[fac_ndx].filieres
	  
	  val = document.querySelector("[name='filiere_id[" + le_num + "]']").value
	  fillFilLst()
	  modalFil.selectedIndex = all_fils.findIndex(obj => {return obj.id == val})
	  
	  modalSem.value = document.querySelector("[name='semestre[" + le_num + "]']").value
	  
	  modalRowNum.value = le_num;
	} else {
	  modalTitle.textContent = "Ajouter une affectation d'UE";
	  modalFac.value = 0
	  fillFilLst()
	  modalFil.value = 0
	  modalSem.value = 1
	  modalRowNum.value = -1
  }

})

var edtFacLst = theModalUE.querySelector('#edit_ue_fac_id');
var edtFilLst = theModalUE.querySelector('#edit_ue_fil_id');
var fillFilLst = function () {
  var chosenFac = (edtFacLst.selectedIndex > -1) ? edtFacLst.options[edtFacLst.selectedIndex].value : 0
  var la_fac = all_facs.filter(obj => {return obj.id == chosenFac})
  if (la_fac.length > 0){
	  $('#edit_ue_fil_id').empty()
	  la_fac[0].filieres.forEach((fil) => {
		var option = document.createElement("option");
		option.text = fil.nom;
		option.value = fil.id;
		edtFilLst.appendChild(option);
	  });
  }
	
}
edtFacLst.addEventListener('change', fillFilLst)

var btnSaveUE = document.getElementById('modal_ue_save')
btnSaveUE.addEventListener('click', function (event) {
  var tbody = document.querySelector('#ue_liste tbody')

  var modalFac = theModalUE.querySelector('#edit_ue_fac_id')
  var modalFil = theModalUE.querySelector('#edit_ue_fil_id')
  var chosenFac = (modalFac.selectedIndex > -1) ? modalFac.options[modalFac.selectedIndex].value : 0
  var chosenFil = (modalFil.selectedIndex > -1) ? modalFil.options[modalFil.selectedIndex].value : 0
  var modalRowNum = theModalUE.querySelector('#edit_ue_num')
  var la_fac = all_facs.filter(obj => {return obj.id == chosenFac})
  var le_sem = theModalUE.querySelector('#edit_ue_semestre').value

  if (la_fac.length > 0){	  
	var la_fil = la_fac[0].filieres.filter(obj => {return obj.id == chosenFil})
	if (la_fil.length > 0){
		if (modalRowNum.value == -1){
			let cpt = tbody.rows.length + 1;
				var dynamicRowHTML = ""
				dynamicRowHTML += "		<tr id='sce_ue_row_" + cpt + "' class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'> ";

				dynamicRowHTML += "		<td class='px-6 py-4'> ";
				dynamicRowHTML += "			<input type='hidden' name='sce_ue_del[" + cpt + "]' value='0'/> ";
				dynamicRowHTML += "			<input type='hidden' name='sce_ue_id[" + cpt + "]' value='0'/> ";
				dynamicRowHTML += "			<input type='hidden' name='faculte_id[" + cpt + "]' value='" + la_fac[0].id + "'/> ";
				dynamicRowHTML += "			<input type='hidden' name='filiere_id[" + cpt + "]' value='" + la_fil[0].id + "'/> ";
				dynamicRowHTML += "			<span id='sce_ue_fac_intitule_" + cpt + "' > " + la_fac[0].code + " </span>	 ";							
				dynamicRowHTML += "		</td> ";
				dynamicRowHTML += "		<td class='px-6 py-4'> ";
				dynamicRowHTML += "			<span id='sce_ue_fil_intitule_" + cpt + "' > " + la_fil[0].nom + " </span>	 ";							
				dynamicRowHTML += "		</td> ";
				dynamicRowHTML += "		<td class='px-6 py-4'> ";
				dynamicRowHTML += "			<input type='hidden' name='semestre[" + cpt + "]' value=' " + le_sem + " '/> ";	
				dynamicRowHTML += "			<span id='sce_ue_semestre_" + cpt + "' >  " + le_sem + "  </span> ";									
				dynamicRowHTML += "		</td>  ";

				dynamicRowHTML += "		<td class='px-2 py-4'> ";
				dynamicRowHTML += "			<a data-num='" + cpt + "' "; 
				dynamicRowHTML += "				data-bs-toggle='modal' ";
				dynamicRowHTML += "				data-bs-target='#modal_ue' ";		
				dynamicRowHTML += "				data-type='edit'	";					
				dynamicRowHTML += "			style='font-size:18px'>";
				dynamicRowHTML += "				<i class='fa fa-edit'></i>";
				dynamicRowHTML += "			</a>";
				dynamicRowHTML += "			&nbsp;";
				dynamicRowHTML += "			&nbsp;";
				dynamicRowHTML += "			<a data-num='" + cpt + "'";
				dynamicRowHTML += "				data-type='del' ";
				dynamicRowHTML += "				onclick=\"remove_ue_num(" + cpt + ")\" ";
				dynamicRowHTML += "			  style='font-size:18px; color:red'>";
				dynamicRowHTML += "					<i class='fa fa-trash'></i>";
				dynamicRowHTML += "			</a> ";
				dynamicRowHTML += "		</td> ";
				dynamicRowHTML += "		</tr> ";
				
				try{
					document.querySelector('#ue_liste tbody').innerHTML += dynamicRowHTML;
					
				} catch (e){
					console.log(e)
				}
		} else {
			let cpt = modalRowNum.value;

			tbody.querySelector("[name='faculte_id[" + cpt + "]']").value = la_fac[0].id;
			tbody.querySelector("[name='filiere_id[" + cpt + "]']").value = la_fil[0].id;
			tbody.querySelector("#sce_ue_semestre_" + cpt ).innerHTML = le_sem;
			tbody.querySelector("[name='semestre[" + cpt + "]']").value = le_sem;	
			tbody.querySelector("#sce_ue_fac_intitule_" + cpt ).innerHTML = la_fac[0].code;		
			tbody.querySelector("#sce_ue_fil_intitule_" + cpt ).innerHTML = la_fil[0].nom;		
		}
		
	}
  }
})

//Remove a sce_ue row
var remove_ue_num = function (num){
	document.querySelector("#sce_ue_row_" + num).style.display = 'none';
	document.querySelector("[name=\"sce_ue_del[" + num + "]\"]").value = 1;
}

</script>

@endsection
