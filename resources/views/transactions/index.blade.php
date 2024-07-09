@extends('layouts.index')

@section('content')
    <style>
        ::backdrop {
            background-image: linear-gradient(45deg,
            rgb(65, 65, 65),
            rgb(87, 85, 89),
            rgb(30, 43, 56),
            rgb(34, 54, 34));
            opacity: 0.75;
        }
    </style>

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row justify-space-between pb-4">
                <div class="col">
                    <h1 class="h3 mb-3">Transactions</h1>
                </div>

            </div>
            <div class="text-center">
                <span class="badge">
                    @if (Session::has('error'))
                        @if (session('error') == true)
                            <p>{{ session('msg') }}</p>
                        @endif
                    @endif
                    @if (Session::has('error'))
                        @if (session('error') == false)
                            <p>{{ session('msg') }}</p>
                        @endif
                    @endif
                </span>
            </div>

            <div class="row">
                <div class="col-xl-12 col-xxl-12 d-flex">
                    <div class="w-100">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <table class="table mb-0" id="myTable">
                                            <thead>
                                            <tr>
                                                <th class="text-left">N°</th>
                                                <th class="text-left">emp_code</th>
                                                <th class="text-left">punch_time</th>
                                                <th class="text-left">punch_state</th>
                                                <th class="text-left">terminal_sn</th>
                                                <th class="text-left">terminal_alias</th>
                                                <th class="text-left">area_alias</th>
                                                <th class="text-left">longitude</th>
                                                <th class="text-left">latitude</th>
                                                <th class="text-left">gps_location</th>
                                                <th class="text-left">mobile</th>
                                                <th class="text-left">source</th>
                                                <th class="text-left">purpose</th>
                                                <th class="text-left">reserved</th>
                                                <th class="text-left">upload_time</th>
                                                <th class="text-left">sync_status</th>
                                                <th class="text-left">sync_time</th>
                                                <th class="text-left">company</th>
                                                <th class="text-left">emp</th>
                                                <th class="text-left">terminal</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @if (count($transactions) < 1)
                                                <tr>
                                                    <td colspan="8" class="text-center">Aucune transaction enregistrée
                                                        pour le moment</td>
                                                </tr>
                                            @endif
                                            @foreach ($transactions as $transaction)
                                                <tr>
                                                    <td class="text-left">{{ $loop->index + 1 }}</td>
                                                    <td class="text-left">{{ $transaction->emp_code }}</td>
                                                    <td class="text-left">{{ $transaction->punch_time }}</td>
                                                    <td class="text-left">{{ $transaction->punch_state }}</td>
                                                    <td class="text-left">{{ $transaction->terminal_sn }}</td>
                                                    <td class="text-left">{{ $transaction->terminal_alias }}</td>
                                                    <td class="text-left">{{ $transaction->area_alias }}</td>
                                                    <td class="text-left">{{ $transaction->longitude }}</td>
                                                    <td class="text-left">{{ $transaction->latitude }}</td>
                                                    <td class="text-left">{{ $transaction->gps_location }}</td>
                                                    <td class="text-left">{{ $transaction->mobile }}</td>
                                                    <td class="text-left">{{ $transaction->source }}</td>
                                                    <td class="text-left">{{ $transaction->purpose }}</td>
                                                    <td class="text-left">{{ $transaction->reserved }}</td>
                                                    <td class="text-left">{{ $transaction->upload_time }}</td>
                                                    <td class="text-left">{{ $transaction->sync_status }}</td>
                                                    <td class="text-left">{{ $transaction->sync_time }}</td>
                                                    <td class="text-left">{{ $transaction->company }}</td>
                                                    <td class="text-left">{{ $transaction->emp }}</td>
                                                    <td class="text-left">{{ $transaction->terminal }}</td>
                                                    <td class="text-left">
                                                        <button type="button" class="btn btn-sm btn-primary" id="editButton-{{ $transaction->id }}"><i class="fa fa-edit"></i></button>
                                                        <button type="button" class="btn btn-sm btn-danger" id="deleteButton-{{ $transaction->id }}"><i class="fa fa-trash"></i></button>
                                                    </td>
                                                    <!-- Delete Faculty Dialog -->
                                                    <dialog style="border: 2px solid white; border-radius: 4px; width: 520px" id="delete-modal-{{ $transaction->id }}">
                                                        <div style="display: flex; flex-direction: row; justify-content: space-between;">
                                                            <h4 class="h4" style="padding-top: 8px;">Supprimer un type de piece</h4>
                                                            <button class="btn btn-danger" onclick="closeDeleteModalById({{ $transaction->id }})"><i class="fa fa-close" ></i></button>
                                                        </div>
                                                        <hr/>
                                                        <form action="" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <div class="mt-4 text-center">
                                                                <h5>Voulez-vous vraiment supprimer la spécialité de code : {{ $transaction->code }}</h5>
                                                            </div>
                                                            <div class="mt-4" style="display: flex; flex-direction: inverse-row; align-items: right;">
                                                                <button class="btn btn-danger" type="submit">Supprimer</button>
                                                            </div>
                                                        </form>
                                                    </dialog>


                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[id^="editButton-"], [id^="deleteButton-"]').forEach(button => {
                button.addEventListener('click', () => {
                    const facultyId = button.id.split('-')[1];
                    const dialogType = button.classList.contains('btn-primary') ? 'edit' : 'delete';
                    const dialog = document.querySelector(`#${dialogType}-modal-${facultyId}`);
                    dialog.showModal();
                });
            });

            document.querySelectorAll('[id^="close-edit-modal-"], [id^="close-delete-modal-"]').forEach(button => {
                button.addEventListener('click', () => {
                    const facultyId = button.id.split('-')[2];
                    const dialogType = button.id.includes('edit') ? 'edit' : 'delete';
                    const dialog = document.querySelector(`#${dialogType}-modal-${facultyId}`);
                    dialog.close();
                });
            });
        });
    </script>
@endsection
