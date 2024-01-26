<header>
	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	      </button>
	      <a class="navbar-brand" href="Home.php"><div class="ws">Peix&atilde;o</div></a>
	    </div>
	    <div class="collapse navbar-collapse" id="myNavbar">
	      <ul class="nav navbar-nav">
	        <li><a href="Home.php"><div class="ws"><i class="fa fa-home"></i>Inicio</div></a></li>
	        <li><a href="Clientes.php"><div class="ws"><i class="fa fa-users"></i>Clientes</div></a></li>
	        <li><a href="Produtos.php"><div class="ws"><i class="fa fa-archive"></i>Produtos</div></a></li>
	        <li><a href="Lancamento.php"><div class="ws"><i class="fa fa-calculator"></i>Lan&ccedil;amento</div></a></li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><div class="ws"><i class="fa fa-bar-chart"></i>Conferencia<span class="caret"></div></span></a>
	        	<ul class="dropdown-menu">
		            <li><a href="Conferencia.php"><div class="wsSubi"><i class="fa fa-user"></i>Cliente individual</div></a></li>
		            <!-- <li><a href="ConferenciaGeral.php"><div class="wsSubi"><i class="fa fa-users"></i>Todos os clientes</div></a></li> -->
		        </ul>
	        </li>
			<li class="dropdown"><a href="#" class="dropdown-toggle" data-toggle="dropdown"><div class="ws"><i class="fa fa-balance-scale"></i>Estoque<span class="caret"></span></div></a>
	        	<ul class="dropdown-menu">
		          <li><a href="EstoqueCientes.php"><div class="wsSubi"><i class="fa fa-balance-scale"></i>Estoque Clientes</div></a></li>
		          <li><a href="TotalEstoque.php"><div class="wsSubi"><i class="fa fa-balance-scale"></i>Total Estoque</div></a></li>
		        </ul>
	        </li>
	        <?php 
                    if(@$_SESSION['usuarioNivel'] != 3 ){
	        ?>
                    <li><a href="Usuarios.php"><div class="ws"><i class="fa fa-user-secret"></i>Usuarios</div></a></li>
                <?php 
                    }
	        ?>		        
	      </ul>
	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="exit.php"><div class="ws"><i class="fa fa-sign-out"></i>Logout</div></a></li>
	      </ul>
	    </div>
	  </div>
	</nav>
</header>