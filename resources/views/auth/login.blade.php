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


    <link rel="canonical" href="https://demo-basic.adminkit.io/pages-sign-in.html" />

    <title>UNI-CHECK</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body style="background-image: url({{ asset('img/universites-du-togo1.jpg')}})">
    <main class="d-flex w-100">
        <div class="container d-flex flex-column">
            <div class="row vh-100">
                <div class="col-sm-10 col-md-8 col-lg-6 mx-auto d-table h-100">
                    <div class="d-table-cell align-middle">

                        <div class="text-center mt-4">
                            <p class="lead" style="color: white;">
                                Connectez vous pour continuer.
                            </p>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="m-sm-4">
                                    <div class="text-center">
                                        <h2 style="color: green; font-size: 24px;">UNI-CHECK</h2>
                                    </div>
                                    <div class="text-center">
                                        <p style="color: red;">@if(Session::has('error'))
                                            {{session('error')}}
                                        @endif</p>
                                        <p style="color: green;">@if(Session::has('success'))
                                            {{session('success')}}
                                        @endif</p>
                                    </div>
                                    <form action="{{ route('auth.login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Adresse email</label>
                                            <input class="form-control form-control-lg" type="email" name="email"
                                                placeholder="Entrez votre email" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Mot de passe</label>
                                            <input class="form-control form-control-lg" type="password" name="password"
                                                placeholder="Entrez votre mot de passe" />

                                        </div>
                                        <div class="text-center mt-3">
                                            <button type="submit" class="btn btn-lg" style="background-color: green; color: white;">Se connecter</button>
                                        </div>
                                        <div class="text-center mt-3">
                                            <a href="{{ route('forgot_password') }}" style="color: black;">Mot de passe oublié ?</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="{{ asset('assets/js/app.js') }}"></script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':

                    toastr.options.timeOut = 3000;
                    toastr.info("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();
                    break;
                case 'success':

                    toastr.options.timeOut = 3000;
                    toastr.success("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'warning':

                    toastr.options.timeOut = 3000;
                    toastr.warning("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
                case 'error':

                    toastr.options.timeOut = 3000;
                    toastr.error("{{ Session::get('message') }}");
                    var audio = new Audio('audio.mp3');
                    audio.play();

                    break;
            }
        @endif
    </script>

</body>

</html>
