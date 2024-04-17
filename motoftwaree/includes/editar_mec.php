<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion = '') {
    header("Location: _sesion/login.php");
}

////////////////// CONEXION A LA BASE DE DATOS ////////////////////////////////////
$id = $_GET['id'];
include "db.php";
$consulta = "SELECT * FROM mecanico WHERE id = $id";
$resultado = mysqli_query($conexion, $consulta);
$usuario = mysqli_fetch_assoc($resultado);
?>
<?php include_once "header.php"; ?>




<form action="functions.php" id="form" method="POST">

    <div class="container">
        <div id="login-row" class="row justify-content-center align-items-center">
            <div id="login-column" class="col-md-6">
                <div id="login-box" class="col-md-12">

                    <h3 class="text-center">Editar registro del Mecanico <?php echo $usuario['nombres']; ?></h3>
                    <br>
                    <div class="form-group">
                        <label for="folio" class="form-label">Cedula</label>
                        <input type="number" id="cedula" name="cedula" class="form-control" value="<?php echo $usuario['cedula']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" id="nombres" name="nombres" class="form-control" value="<?php echo $usuario['nombres']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" value="<?php echo $usuario['apellido']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <select name="sexo" id="sexo" class="form-control" value="<?php echo $usuario['sexo']; ?>" required>
                            <option <?php echo $usuario['sexo'] === 'Masculino' ? "selected='selected' " : "" ?> value="Masculino">Masculino</option>
                            <option <?php echo $usuario['sexo'] === 'Femenino' ? "selected='selected' " : "" ?> value="Femenino">Femenino</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="telefono">Telefono:</label><br>
                        <input type="number" name="telefono" id="telefono" class="form-control" value="<?php echo $usuario['telefono']; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha de nacimiento:</label><br>
                        <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo $usuario['fecha']; ?>" required>
                    </div>



                    <div class="form-group">
                        <label for="username">Correo:</label><br>
                        <input type="email" name="correo" id="correo" class="form-control" value="<?php echo $usuario['correo']; ?>" placeholder="No se puede repetir con alguno de la lista...">
                    </div>



                    <input type="hidden" name="accion" value="editar_mec">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                    <br>
                    <div class="mb-3">

                        <button type="submit" id="form" name="form" class="btn btn-success">Editar</button>
                        <a href="../views/mecanicos.php" class="btn btn-danger">Cancelar</a>

                    </div>
                </div>
            </div>

</form>
</div>
</div>

<?php include_once "footer.php"; ?>