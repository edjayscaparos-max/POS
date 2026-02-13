<footer class="py-5">
  <div class="container">
    <div class="row align-items-center justify-content-xl-between">
      <div class="col-xl-6">
        <div class="copyright text-center text-xl-left text-muted">
        &copy; 2024 - <?php echo date('Y'); ?> - Developed By Edjay Caparos
        </div>
        <script>
 
  var timeoutDuration = 15000;


  var timeoutTimer;

  function resetTimer() {
    clearTimeout(timeoutTimer);
    timeoutTimer = setTimeout(logout, timeoutDuration);
  }


  function logout() {
    window.location.href = 'logout.php';
  }


  document.addEventListener('mousemove', resetTimer);
  document.addEventListener('keydown', resetTimer);


  resetTimer();
</script>
      </div>
      <div class="col-xl-6">
        <ul class="nav nav-footer justify-content-center justify-content-xl-end">
          <li class="nav-item">
            <a href="" class="nav-link" target="_blank">Restaurant POS</a>
          </li>
        </ul>
      </div>
    </div>
  </div>
</footer>