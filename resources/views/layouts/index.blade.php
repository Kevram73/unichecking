<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('assets/img/icons/icon-48x48.png') }}" />

    <link rel="canonical" href="https://demo-basic.adminkit.io/" />

    <title>UNI-CHECK</title>


    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.min.css">
</head>

<body>
    <div class="wrapper">
        @include("parts.sidebar")

        <div class="main">
            @include("parts.navbar")

            @yield('content')

            @include('parts.footer')
        </div>
    </div>


    <script src="{{ asset('assets/js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.js" integrity="sha512-+k1pnlgt4F1H8L7t3z95o3/KO+o78INEcXTbnoJQ/F2VqDVhWoaiVml/OEHv9HsVgxUaVW+IbiZPUJQfF/YxZw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
    <script>
        let table = new DataTable('#myTable', {
            columnDefs: [{
                    "defaultContent": "-",
                    "targets": "_all"
                  }],
            language: {
                url: "{{ asset('assets/FR-fr.json') }}",
            },
        });
    </script>
    <script>
        function closeEditModalById(id) {
            const dialog = document.querySelector(`#edit-modal-${id}`);
            if (dialog) {
                dialog.close();
            } else {
                console.error('Edit modal not found for ID:', id);
            }
        }

        // Function to close a delete modal by ID
        function closeDeleteModalById(id) {
            const dialog = document.querySelector(`#delete-modal-${id}`);
            if (dialog) {
                dialog.close();
            } else {
                console.error('Delete modal not found for ID:', id);
            }
        }
    </script>
    <script>
        const dialog = document.querySelector("#add-modal");
        const showButton = document.querySelector("#show-add-modal");
        const closeButton = document.querySelector("#close-add-modal");

        // "Show the dialog" button opens the dialog modally
        showButton.addEventListener("click", () => {
            dialog.showModal();
        });

        // "Close" button closes the dialog
        closeButton.addEventListener("click", () => {
            dialog.close();
        });
    </script>
    <script>
        document.getElementById('date_debut_add').addEventListener('input', function() {
            let debut = parseInt(this.value);
            document.getElementById('date_fin_add').value = debut+1;
        });
        document.getElementById('date_debut_edit').addEventListener('input', function() {
            let debut = parseInt(this.value);
            document.getElementById('date_fin_edit').value = debut+1;
        });
    </script>
</body>

</html>
