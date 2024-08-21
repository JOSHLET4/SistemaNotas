<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css" />
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
    </form>
    <a href="#" class="login-forgot-pass">¿Olvidaste tu contraseña?</a>
    <div class="underlay-photo"></div>
    <div class="underlay-black"></div>
  </body>
</html>
