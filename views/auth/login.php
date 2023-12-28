<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia Sesión con tus datos</p>

<?php 
    include_once __DIR__ . "/../templates/alertas.php";
?>

<form class="formulario" method="POST" action="/">

    <div class="campo">
        <label for="email">Correo: </label>
        <input type="email"
                name="email"
                id="email"
                placeholder="Correo Electronico"
        />
    </div>

    <div class="campo">
        <label for="password">Password: </label>
        <input type="password"
                name="password"
                id="password"
                placeholder="Password"
        />
    </div>

    <input type="submit" class="boton" value="Iniciar Sesión">
</form>
<div class="acciones">
    <a href="/crear-cuenta">¿Aún no tienes una cuenta? Crea una</a>
    <a href="/olvide">¿Olvidaste tú password? Recuperala aquí</a>
</div>