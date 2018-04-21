<nav class="navbar navbar-toggleable-md navbar-inverse bg-inverse bg-faded">
  <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
 
  <a class="navbar-brand" href="menu.php"><i class="fa fa-home"></i> Inicio</a>
  
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
      <li class="nav-item active">
        <a class="nav-link text-primary sessiones" title="webmail/rainloop" href="#">WebMail</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="secciones_drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fa fa-filter" aria-hidden="true"></i> Secciones
        </a>
        <div class="dropdown-menu w3-card-4" aria-labelledby="secciones_drop" style="width: 300px;height: 400px;overflow-y: auto">
          	<!-- <div class="btn-group-vertical"> -->
          	<h6 class="dropdown-header">Nómina</h6>
				<a class="dropdown-item sessiones" href="#" title="operaciones_parametros_nomina/index.php">	
					<div class="row">
						<div class="col-3"><i class="fa fa-id-card fa-3x"></i></div>
						<div class="col">
							<span >Crear nueva nómina
							</span>
						</div>
					</div>
				</a>
				<a class="dropdown-item sessiones" href="#" title="operaciones_parametros_nomina/select_nomina.php">
					<div class="row">
						<div class="col-3"><i class="fa fa-mouse-pointer fa-3x"></i></div>
						<div class="col">
							<span>Seleccionar nómina
							</span>
						</div>
					</div>
				</a>
			<h6 class="dropdown-header">Personal</h6>
				<a class="dropdown-item sessiones" href="#" title="ficha_personal/index.php">	
					<div class="row">
						<div class="col-3"><i class="fa fa-search fa-3x"></i></div>
						<div class="col">
							<span >Buscar personal
							</span>
						</div>
					</div>
				</a>
				<a class="dropdown-item sessiones" href="#" title="ficha_personal/incluir_personal.php">
					<div class="row">
						<div class="col-3"><i class="fa fa-user-plus fa-3x"></i></div>
						<div class="col">
							<span>Incluir nuevo personal
							</span>
						</div>
					</div>
				</a>
			<h6 class="dropdown-header">Prestaciones sociales</h6>
				<a class="dropdown-item sessiones" href="#" title="prestaciones_sociales/">
					<div class="row">
						<div class="col-3"><i class="fa fa-calculator fa-3x"></i></div>
						<div class="col">
							<span>Prestaciones sociales
							</span>
						</div>
					</div>
				</a>
			<h6 class="dropdown-header">Partidas presupuestarias</h6>
				<a class="dropdown-item sessiones" href="#" title="partida_presupuestaria/">
					<div class="row">
						<div class="col-3"><i class="fa fa-calendar fa-3x"></i></div>
						<div class="col">
							<span>Creador de partidas
							</span>
						</div>
					</div>
				</a>

			<h6 class="dropdown-header">Herramientas</h6>
				<a class="dropdown-item sessiones" href="#" title="constancia/index.php">	
					<div class="row">
						<div class="col-3"><i class="fa fa-clipboard fa-3x"></i></div>
						<div class="col">
							<span >Motor de documentos
							</span>
						</div>
					</div>
				</a>
			<h6 class="dropdown-header">Fórmulas de pago</h6>
				<a class="dropdown-item sessiones" href="#" title="formulas_pago/index.php">
					<div class="row">
						<div class="col-3"><i class="fa fa-wpforms fa-3x"></i></div>
						<div class="col">
							<span>Creador de fórmulas
							</span>
						</div>
					</div>
				</a>	
			<h6 class="dropdown-header">Globales</h6>
				<a class="dropdown-item sessiones" href="#" title="parametros_globales/">	
					<div class="row">
						<div class="col-3"><i class="fa fa-cogs fa-3x"></i></div>
						<div class="col">
							<span >Parámetros globales
							</span>
						</div>
					</div>
				</a>
				<a class="dropdown-item sessiones" href="#" title="usuarios_autenticar/">
					<div class="row">
						<div class="col-3"><i class="fa fa-cog fa-3x"></i></div>
						<div class="col">
							<span>Administrar usuarios
							</span>
						</div>
					</div>
				</a>	
            </a>
        </div>
      </li>
    </ul>
	<ul class="form-inline my-2 my-lg-0">
		<h2><span id="name_vista" class="text-primary"></span></h2>
	</ul>
  </div>
  <a class="navbar-brand" href="log_out.php"><i class="fa fa-close"></i> Cerrar sesión</a>
</nav>