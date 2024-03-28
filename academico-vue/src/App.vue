<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">GESTION ACADEMICA</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <router-link class="nav-link active" to="/Inicio">Inicio</router-link>
            </li>
            
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Estudiantes
              </a>
              <ul class="dropdown-menu">
                <li>
                  <router-link class ="dropdown-item" to="/">Listar estudiantes</router-link>
                 
                </li>

                <li>
                  <router-link class ="dropdown-item" to="/createE">Registrar estudiantes</router-link>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <div class="container-fluid"><router-view/></div>
  
  <footer class="footer mt-auto py-3 bg-success text-white fixed-bottom">
    <div class="container text-center">
      <span class="text-muted">© 2024 GESTION ACADEMICA</span>
    </div>
  </footer>

</template>


