<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  </head>
  <body>
    <form action="/login/autenticacion.php" method="post" class="login-form">
      <p class="login-text">
        <span class="fa-stack fa-lg">
          <i class="fa fa-circle fa-stack-2x"></i>
          <i class="fa fa-lock fa-stack-1x"></i>
        </span>
      </p>
      <input
        type="text"
        name="username"
        id="username"
        class="login-username"
        autofocus="true"
        required="true"
        placeholder="Usuario"
      />
      <input
        type="password"
        name="password"
        id="password"
        class="login-password"
        required="true"
        placeholder="Contraseña"
      />
      <input
        type="submit"
        name="Login"
        value="INICIAR SESION"
        class="login-submit"
      />
      <a href="#" class="login-forgot-pass" data-toggle="modal" data-target="#forgotPasswordModal">¿Olvidaste tu contraseña?</a>
    </form>
    <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="forgotPasswordModalLabel">Olvidaste tu Contraseña</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
              <span class="sr-only">Close</span>
            </button>
          </div>
          <div class="modal-body">
            Para cambiar su contraseña, debe contactar a soporte.
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  </body>
</html>
