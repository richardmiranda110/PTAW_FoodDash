<div class="d-flex flex-column" style="background-color: #202020;">
  <div class=" my-auto">
    <h1 style="text-align: left; font-weight: bolder; color: white;">FoodDash</h1>
    <footer class="row row-cols-1 row-cols-sm-2 row-cols-md-5 py-5 my-2 mx-0 border-top border-bottom" style="color: white;">
      <div class="col ">
        <a href="/business/dashboard_home_page.php"><img id="logo_fooddash" src="../assets/imgs/fd_logo_blackWhite.png" alt="reduced_logo_fd" width="190" height="110"></a>
      </div>
      <div class="col"></div>
      <div class="col"></div>
      <div class="col">
        <h4 style="color: #FEBB41;">Conta Empresarial</h4>
        <ul class="nav flex-column">
          <li class="nav-item" id="btn_login_footer"><a href="#" class="nav-link p-0" style="color: white;">Login</a></li>
          <li class="nav-item" id="btn_register_footer"><a href="#" class="nav-link p-0" style="color: white;">Registar</a></li>
        </ul>
      </div>
      <div class="col">
        <h4 style="color: #FEBB41;">Sobre</h4>
        <ul class="nav flex-column">
          <li class="nav-item" id="btn_our_story_footer"><a href="#" class="nav-link p-0" style="color: white;">História</a></li>
          <li class="nav-item" id="btn_team_footer"><a href="#" class="nav-link p-0" style="color: white;">Equipa</a></li>
        </ul>
      </div>
    </footer>
    <p class="text-end m-0" style="color: white;">Todos os direitos reservados © FoodDash, 2024</p>
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
  window.location.href = './../our_story.php';
});
document.getElementById('btn_team_footer').addEventListener('click', function() {
  window.location.href = './../team.php';
});
</script>
