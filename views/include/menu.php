
<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark primary-color fixed-top">
  <!-- Navbar brand -->
  <a class="navbar-brand" href="#">Top Livraison</a>
  <!-- Collapse button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#basicExampleNav"
    aria-controls="basicExampleNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="basicExampleNav">
    <!-- Links -->
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">Home
          <span class="sr-only">(current)</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal" id="creationCompt" >Ajouter un client</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal1" id="comptBoullangerie">Nouvelle Boulangerie</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="client.php">Client</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tesVente.php">test vente</a>
      </li>
      <!-- Dropdown -->
      <li class="nav-item">
        <a class="nav-link" href="ventePrise.php">Vente et Prise</a>
      </li>
    <!-- Links -->
    <form class="form-inline">
      <div class="md-form my-0">
        <input class="form-control mr-sm-2" type="text" placeholder="rechrecher un client " aria-label="Search">
      </div>
    </form>
		<a class="btn-floating btn-primary" id="showHideEntete"><i class="fas fa-leaf"></i></a>
  </div>
  <!-- Collapsible content -->
</nav>
<!--/.Navbar-->