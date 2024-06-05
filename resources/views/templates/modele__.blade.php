<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<title>M-Tracking</title>
		<link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
		<link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
		<link href="{{ asset('css/dataTables.dataTables.min.css') }}" rel="stylesheet" />
		<script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
	</head>
		<body class="sb-nav-fixed">
			@section('sidebar')
			<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
				<!-- Navbar Brand-->
				<a class="navbar-brand ps-3" href="index.html">M-Tracking</a>
				<!-- Sidebar Toggle-->
				<button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
				<!-- Navbar Search-->
				<form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
					<div class="input-group">
						<input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
						<button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
					</div>
				</form>
				<!-- Navbar-->
				<ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
						<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
							<li><a class="dropdown-item" href="#!">Paramètres</a></li>
							<li><hr class="dropdown-divider" /></li>
							<li><a class="dropdown-item" href="#!">Déconnexion</a></li>
						</ul>
					</li>
				</ul>
			</nav>
			<div id="layoutSidenav">
				<div id="layoutSidenav_nav">
					<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
						<div class="sb-sidenav-menu">
							<div class="nav flex-column pt-3 pt-md-0">
								<a href="/live-global" class="nav-link">
									<div class="sb-nav-link-icon">
									<i class="fas fa-satellite-dish" style="width: 20px"></i>
									</div>
									<div class="sidebar-text">Scans (Global)</div>
								</a>
								<a href="/live" class="nav-link">
									<div class="sb-nav-link-icon">
									<i class="fas fa-satellite-dish" style="width: 20px"></i>
									</div>
									<div class="sidebar-text">Suivi en Temps réel</div>
								</a>
								
								<a href="/declarations" class="nav-link">
									<div class="sb-nav-link-icon">
									<i class="fas fa-shipping-fast" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Déclarations</div>
								</a>
								<a href="/declarations/flagged" class="nav-link">
									<div class="sb-nav-link-icon">
									<i class="fas fa-exclamation-triangle" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Suspicions</div>
								</a>
								<a href="/reports" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fas fa-file-alt" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Rapports</div>
								</a>
								<a href="{{ route('maison.show') }}" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fas fa-home" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Maisons de Transit</div>
								</a>
								<a href="{{ route('bureau.show') }}" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fas fa-home" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Bureaux</div>
								</a>
								<a href="/points" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fa fa-thumb-tack" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Points</div>
								</a>
								<a href="/axes" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fa fa-road" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Axes</div>
								</a>
								<a href="/merch" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fa fa-box" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Types de Marchandises</div>
								</a>
								<a href="/users" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fas fa-users" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Utilisateurs [Web]</div>
								</a>
								<a href="/agents" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fas fa-mobile" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Agents</div>
								</a>
								<a href="/monitoring" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fa-brands fa-watchman-monitoring" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Surveillance</div>
								</a>
								<a href="/notifications" class="nav-link">
									<div class="sb-nav-link-icon">
										<i class="fa fa-message" style="width: 20px;"></i>
									</div>
									<div class="sidebar-text">Notifications</div>
								</a>			
					
						<!--
								<div class="sb-sidenav-menu-heading">Interface</div>
								<a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
										<div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
										Layouts
										<div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
								</a>
								<div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
										<nav class="sb-sidenav-menu-nested nav">
												<a class="nav-link" href="layout-static.html">Static Navigation</a>
												<a class="nav-link" href="layout-sidenav-light.html">Light Sidenav</a>
										</nav>
								</div>
						-->
							</div>
						</div>
						<div class="sb-sidenav-footer">
								<div class="small">Logged in as:</div>
								Start Bootstrap
						</div>
					</nav>
				</div>
				<div id="layoutSidenav_content">
					<main>
						<div class="container-fluid px-4">
							<h3 class="mt-4">@yield('title')</h3>
							<!--
							<ol class="breadcrumb mb-4">
									<li class="breadcrumb-item active">Dashboard</li>
							</ol>
							-->
							<div class="container">
								@yield('content')
							</div>
						</div>
					</main>
					<footer class="py-4 bg-light mt-auto">
						<div class="container-fluid px-4">
							<div class="d-flex align-items-center justify-content-between small">
								<div class="text-muted">Copyright &copy; Your Website 2023</div>
								<!--
								<div>
									<a href="#">Privacy Policy</a>
									&middot;
									<a href="#">Terms &amp; Conditions</a>
								</div>
								-->
							</div>
						</div>
					</footer>
				</div>
			</div>
			@show

		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
				<script src="{{ asset('js//sb_admin/scripts.js') }}"></script>
				<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.7.1.js" type="text/javascript"></script>
				<script src="{{ asset('js/sb_admin/datatables-simple-demo.js') }}"></script>
				<script src="{{ asset('js/dataTables.min.js') }}"></script>
		
		@yield('js')
		
		</body>
</html>
