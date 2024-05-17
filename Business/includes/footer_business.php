<div class="d-flex" style="background-color: #202020;">
    <div class="container">
      <h1 style="text-align: left; font-weight: bolder; color: white;">FoodDash</h1>
      <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-2 border-top border-bottom">
        <div class="col mb-3">
          <a href="#"><img id="logo_fooddash" src="./imagens/fd_logo_blackWhite.png" alt="Bootstrap" width="190" height="110"></a>
        </div>
        <div class="col mb-3"></div>
        <div class="col mb-3">
          <h4 style="color: #FEBB41;">Conta Empresarial</h4>
          <ul class="nav flex-column">
            <li class="nav-item mb-2" id="btn_login_footer"><a href="#" class="nav-link p-0" style="color: white;">Login</a></li>
            <li class="nav-item mb-2" id="btn_register_footer"><a href="#" class="nav-link p-0" style="color: white;">Registar</a></li>
          </ul>
        </div>
        <div class="col mb-3">
          <h4 style="color: #FEBB41;">Sobre</h4>
          <ul class="nav flex-column">
            <li class="nav-item mb-2" id="btn_our_story_footer"><a href="#" class="nav-link p-0" style="color: white;">História</a></li>
            <li class="nav-item mb-2" id="btn_team_footer"><a href="#" class="nav-link p-0" style="color: white;">Equipa</a></li>
          </ul>
        </div>
        <div class="col mb-3">
          <h4 style="color: #FEBB41;">Contatos</h4>
          <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0" style="color: white;">Apoio ao cliente</a></li>
            <li class="nav-item mb-2"><a href="#" class="nav-link p-0" style="color: white;">Contato empresarial</a>
            </li>
          </ul>
        </div>
      </footer>
      <p class="text-end" style="color: white; margin: 0;">Todos os direitos reservados © FoodDash, 2024</p>
    </div>
  </div>

  <script>
  document.getElementById('logo_fooddash').addEventListener('click', function() {
    window.location.href = 'home_page.php';
  });
  document.getElementById('btn_login_footer').addEventListener('click', function() {
    window.location.href = 'login_register/login_business.php';
  });
  document.getElementById('btn_register_footer').addEventListener('click', function() {
    window.location.href = 'login_register/register_business.php';
  });
  document.getElementById('btn_our_story_footer').addEventListener('click', function() {
    window.location.href = 'our_story.php';
  });
  document.getElementById('btn_team_footer').addEventListener('click', function() {
    window.location.href = 'team.php';
  });
  
</script>