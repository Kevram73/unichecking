@extends('templates.modele')
@section('title', $id > 0 ? "Modifier les informations de la filière" : "Enregistrer les informations d'une filière")
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
												<label class="text-black dark:text-gray-200" for="edit_ue_ue_id">Unité d'Enseignement</label>
												<select id="edit_ue_ue_id" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
												@foreach ($ues as $ue)
													<option value="{{ $ue->id }}" >{{ $ue->intitule }}</option>
												@endforeach 
												</select>
											</div>
											<div>
												<label class="text-black dark:text-gray-200" for="edit_ue_semestre">Semestre</label>
												<input id="edit_ue_semestre" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
											</div>
											<div>
												<label class="text-black dark:text-gray-200" for="edit_ue_volh">Volume horaire</label>
												<input id="edit_ue_volh" type="number" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
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
		
            <form action="{{ route('filiere.save') }}" method="POST">				
			@csrf
				<input type="hidden" value="{{$id}}" name="id">
				<input type="hidden" value="{{$faculte->id}}" name="faculte_id">
                <div class="grid grid-cols-1 gap-6 mt-4">				
				
				
                    <div>
                        <label class="text-white dark:text-gray-200" for="faculte">Faculté</label>
                        <input readonly type="text"  value="{{ $faculte->code }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
                    </div>			
                    <div>
                        <label class="text-white dark:text-gray-200" for="nom">Filière</label>
                        <input id="nom" name="nom" type="text"  value="{{ isset($data['nom']) ? $data['nom'] : '' }}" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
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
									Nom UE
								</th>
								<th scope="col" class="px-2 py-3">
									Semestre
								</th>
								<th scope="col" class="px-2 py-3">
									Vol. Horaire
								</th>
								<th scope="col" class="px-2 py-3">

								</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($affectations as $cpt=>$aff)
							<tr id="fac_ue_row_{{$cpt}}" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
								<td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
									<input type="hidden" name="fac_ue_del[{{$cpt}}]" value="0"/>
									<input type="hidden" name="fac_ue_id[{{$cpt}}]" value="{{ $aff->id }}"/>
									<input type="hidden" name="ue_id[{{$cpt}}]" value="{{ $aff->ue_id }}"/>
									<span id='fac_ue_intitule_{{$cpt}}' > {{ $aff->ue->intitule }} </span>
								</td>
								<td class="px-6 py-4">
									<input type="hidden" name="semestre[{{$cpt}}]" value="{{ $aff->semestre }}"/>	
									<span id='fac_ue_semestre_{{$cpt}}' > {{ $aff->semestre }} </span>									
								</td>
								<td class="px-6 py-4">
									<input type="hidden" name="volume_horaire[{{$cpt}}]" value="{{ $aff->volume_horaire }}"/>	
									<span id='fac_ue_volh_{{$cpt}}' > {{ $aff->volume_horaire }} </span>
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
				<div>
					<label class="text-white dark:text-gray-200">&nbsp;</label>
				</div> 
				</div>
                <div class="flex justify-end mt-6">
                    <a class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-900 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600" href="{{ route('filiere.show', ["fac_id" => $faculte->id]) }}">ANNULER</a>
                    <span class="px-6">&nbsp;</span>
					<button class="px-6 py-2 leading-5 text-white transition-colors duration-200 transform bg-pink-500 rounded-md hover:bg-pink-700 focus:outline-none focus:bg-gray-600">ENREGISTRER</button>
                </div>
            </form>
        </section> 


@endsection


@section('js')


<!-- Script for edit FaculteUE modal -->
<script>

var all_ues = {!! json_encode($ues, true); !!}
var theModalUE = document.getElementById('modal_ue')
theModalUE.addEventListener('show.bs.modal', function (event) {
  var trigger_source = event.relatedTarget
  var modalTitle = theModalUE.querySelector('.modal-title')
  var type = trigger_source.getAttribute('data-type');

  var modalUE = theModalUE.querySelector('#edit_ue_ue_id')
  var modalSem = theModalUE.querySelector('#edit_ue_semestre')
  var modalVolh = theModalUE.querySelector('#edit_ue_volh')
  var modalRowNum = theModalUE.querySelector('#edit_ue_num')
	if (type == 'edit'){
	  modalTitle.textContent = "Modifier l'affectation d'UE";
	  let le_num = trigger_source.getAttribute('data-num')
	  let val = document.querySelector("[name='ue_id[" + le_num + "]']").value
	  modalUE.selectedIndex = all_ues.findIndex(obj => {return obj.id == val})

	  modalSem.value = document.querySelector("[name='semestre[" + le_num + "]']").value
	  modalVolh.value = document.querySelector("[name='volume_horaire[" + le_num + "]']").value
	  
	  modalRowNum.value = le_num;
	} else {
	  modalTitle.textContent = "Ajouter une affectation d'UE";
	  modalUE.value = 0
	  modalSem.value = 1
	  modalVolh.value = 0
	  modalRowNum.value = -1
  }
})

var btnSaveUE = document.getElementById('modal_ue_save')
btnSaveUE.addEventListener('click', function (event) {
  var tbody = document.querySelector('#ue_liste tbody')

  var modalUE = theModalUE.querySelector('#edit_ue_ue_id')
  var chosenUE = modalUE.options[modalUE.selectedIndex].value
  var modalRowNum = theModalUE.querySelector('#edit_ue_num')
  var la_ue = all_ues.filter(obj => {return obj.id == chosenUE})
  var le_sem = theModalUE.querySelector('#edit_ue_semestre').value
  var le_volh = theModalUE.querySelector('#edit_ue_volh').value

  if (la_ue.length > 0)
	if (modalRowNum.value == -1){
		let cpt = tbody.rows.length;
            var dynamicRowHTML = ""
			dynamicRowHTML += "		<tr id='fac_ue_row_" + cpt + "' class='bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600'> ";

			dynamicRowHTML += "		<td class='px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white'> ";
			dynamicRowHTML += "			<input type='hidden' name='fac_ue_del[" + cpt + "]' value='0'/> ";
			dynamicRowHTML += "			<input type='hidden' name='fac_ue_id[" + cpt + "]' value='0'/> ";
			dynamicRowHTML += "			<input type='hidden' name='ue_id[" + cpt + "]' value='" + la_ue[0].id + "'/> ";
			dynamicRowHTML += "			<span id='fac_ue_intitule_" + cpt + "' > " + la_ue[0].intitule + " </span> ";
			dynamicRowHTML += "		</td>  ";
			dynamicRowHTML += "		<td class='px-6 py-4'> ";
			dynamicRowHTML += "			<input type='hidden' name='semestre[" + cpt + "]' value=' " + le_sem + " '/> ";	
			dynamicRowHTML += "			<span id='fac_ue_semestre_" + cpt + "' >  " + le_sem + "  </span> ";									
			dynamicRowHTML += "		</td>  ";
			dynamicRowHTML += "		<td class='px-6 py-4'> ";
			dynamicRowHTML += "			<input type='hidden' name='volume_horaire[" + cpt + "]' value='" + le_volh + "'/> ";
			dynamicRowHTML += "			<span id='fac_ue_volh_" + cpt + "' > " + le_volh + " </span> ";
			dynamicRowHTML += "		</td> ";

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

		tbody.querySelector("[name='ue_id[" + cpt + "]']").value = la_ue[0].id;
		tbody.querySelector("[name='volume_horaire[" + cpt + "]']").value = le_volh;
		tbody.querySelector("#fac_ue_volh_" + cpt ).innerHTML = le_volh;
		tbody.querySelector("#fac_ue_semestre_" + cpt ).innerHTML = le_sem;
		tbody.querySelector("[name='semestre[" + cpt + "]']").value = le_sem;
		tbody.querySelector("#fac_ue_intitule_" + cpt ).innerHTML = la_ue[0].intitule;			
	}

	theModalUE.hide()
})

//Remove a ens_ue row
var remove_ue_num = function (num){
	document.querySelector("#fac_ue_row_" + num).style.display = 'none';
	document.querySelector("[name=\"fac_ue_del[" + num + "]\"]").value = 1;
}

</script>

@endsection
