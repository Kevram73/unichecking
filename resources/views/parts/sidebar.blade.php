<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand text-center">
            <h2 class="align-middle text-white" style="font-weight: 700; font-size: 26px">UNI-CHECK </h2>
            <p style="font-size: 12px; color: grey;">{{ session()->get('on_year'); }}</p>
        </a>

        <h4 class="text-center" style="color: darkgrey; font-size: 14px; margin-top: -15px; margin-bottom: 10px;">{{ session()->get('uni_name'); }}</h4>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Sections
            </li>

            <li class="sidebar-item @if(Request::is('dashboard.index')) active @endif">
                <a class="sidebar-link" href="{{ route('dashboard.index') }}">
                    <i class="align-middle fa fa-sliders"></i> <span
                        class="align-middle">Tableau de bord</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'enseignants.index') active @endif">
                <a class="sidebar-link" href="{{ route('enseignants.index') }}">
                    <i class="align-middle fa fa-users"></i> <span class="align-middle">Enseignants</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'facultes.index') active @endif">
                <a class="sidebar-link" href="{{ route('facultes.index') }}">
                    <i class="align-middle fa fa-home"></i> <span class="align-middle">Facultés</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'seances.index') active @endif">
                <a class="sidebar-link" href="{{ route('seances.index') }}">
                    <i class="align-middle fa fa-clock"></i> <span class="align-middle">Séances de cours</span>
                </a>
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{ route('deplacements.index') }}">
                    <i class="align-middle fa fa-table"></i> <span class="align-middle">Prog d'indisponibilité</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'ues.index') active @endif">
                <a class="sidebar-link" href="{{ route('ues.index') }}">
                    <i class="align-middle fa fa-book"></i> <span class="align-middle">Unités d'enseignements</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'postes.index') active @endif">
                <a class="sidebar-link" href="{{ route('postes.index') }}">
                    <i class="align-middle fa fa-briefcase"></i> <span class="align-middle">Postes</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'grades.index') active @endif">
                <a class="sidebar-link" href="{{ route('grades.index') }}">
                    <i class="align-middle fa fa-briefcase"></i> <span class="align-middle">Fonctions</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'specialites.index') active @endif">
                <a class="sidebar-link" href="{{ route('specialites.index') }}">
                    <i class="align-middle fa fa-hand-pointer"></i> <span class="align-middle">Spécialités</span>
                </a>
            </li>

            <li class="sidebar-header">
                Configuration
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'universites.index') active @endif">
                <a class="sidebar-link" href="{{ route('universites.index') }}">
                    <i class="align-middle" data-feather="square"></i> <span class="align-middle">Universités</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'annees.index') active @endif">
                <a class="sidebar-link" href="{{ route('annees.index') }}">
                    <i class="align-middle" data-feather="check-square"></i> <span
                        class="align-middle">Années académiques</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'type_pieces.index') active @endif">
                <a class="sidebar-link" href="{{ route('type_pieces.index') }}">
                    <i class="align-middle fa fa-id-card"></i> <span class="align-middle">Type de pièces d'ID</span>
                </a>
            </li>

            <li class="sidebar-item @if(Request::route()->getName() == 'type_deplacements.index') active @endif">
                <a class="sidebar-link" href="{{ route('type_deplacements.index') }}">
                    <i class="align-middle" data-feather="align-left"></i> <span
                        class="align-middle">Indisponibilités</span>
                </a>
            </li>


        </ul>


    </div>
</nav>
