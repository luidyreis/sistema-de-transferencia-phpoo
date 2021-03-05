<main>
  <section>
    <div class="card-header rounded-top bg-light text-dark mt-3">
      <h4>Saldo da conta</h4>
    </div>
    <div class="card-body bg-secondary rounded-bottom">
      <h5 id="saldo">R$: <?= number_format($saldo->saldo, 2, ',', '.') ?></h5>
    </div>
  </section>
  <section>
    <div class="card-header bg-light text-dark rounded-top mt-3">
      <h5>Transferencia</h5>
    </div>
    <div class="card-body bg-secondary rounded-bottom mb-5">
      <div id="aviso"></div>
      <form id="form_tranferer">
      <label for="conta">Conta:</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="conta-tranfer"><i class="fas fa-user-circle"></i></span>
          </div>
          <input name="conta" type="text" class="form-control" aria-label="Username" aria-describedby="conta-tranfer">
        </div>
        <label for="valor">Valor:</label>
        <div class="input-group mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text" id="valor-tranfer"><i class="fas fa-dollar-sign"></i></span>
          </div>
          <input id="valor" name="valor" type="text" class="form-control" aria-label="Username" aria-describedby="valor-tranfer">
        </div>
        <div class="from-group">
          <button type="submit" class="btn btn-success">Transferir</button>
        </div>
      </form>
    </div>
  </section>
  <section>
  </section>
</main>
<!-- . container -->
</div>
<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha512-bnIvzh6FU75ZKxp0GXLH9bewza/OIw6dLVh9ICg0gogclmYGguQJWl8U30WpbsGTqbIiAwxTsbe76DErLq5EDQ==" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="assets/js/mask.min.js"></script>
<script>
  $('#valor').keyup(function() {
    $("#valor").mask("999.999.999.999.999,00", {
      reverse: true
    });
  });
  //fazer a transferencia sem refresh
  $(document).ready(function() {
    $('#form_tranferer').submit(function() {
      var dados = $(this).serialize();
      $.ajax({
        type: "POST",
        dataType: "JSON",
        url: "api/transferencia.php",
        data: dados,
        success: function(resposta) {
          $("#saldo").html('R$: ' + resposta["Saldo"]);
          if (resposta["Status"] == "Transferido!") {
            $("#aviso").html('<div class="alert alert-success text-center">' + resposta["Status"] + '</div>');
          } else {
            $("#aviso").html('<div class="alert alert-danger text-center">' + resposta["Status"] + '</div>');
          }

        }
      });
      return false;
    });
  });
</script>
</body>

</html>