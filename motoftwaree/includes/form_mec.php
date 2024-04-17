<?php


session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion = '') {
    header("Location: _sesion/login.php");
}
?>

<div class="modal fade" id="mecanico" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h3 class="modal-title" id="exampleModalLabel">Agregar un nuevo Mecanico <?php echo $fila['nombre']; ?>
                </h3>
                <button type="button" class="btn btn-black" data-dismiss="modal">
                    <i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="modal-body">

                <form action="../includes/functions.php" method="POST">
                    <div class="form-group">
                        <label for="folio" class="form-label">Documento</label>
                        <input type="number" id="cedula" name="cedula" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Nombres</label>
                        <input type="text" id="nombres" name="nombres" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="nombre" class="form-label">Apellido</label>
                        <input type="text" id="apellido" name="apellido" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="sexo" class="form-label">Sexo:</label>
                        <select name="sexo" id="sexo" class="form-control" required>
                            <option value="">--Selecciona una opcion--</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Femenino">Femenino</option>
                        </select>
                    </div>


                    <div class="form-group">
                        <label for="telefono">Telefono:</label><br>
                        <input type="number" name="telefono" id="telefono" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha de nacimiento:</label><br>
                        <input type="date" name="fecha" id="fecha" class="form-control" required>
                    </div>



                    <div class="form-group">
                        <label for="username">Correo:</label><br>
                        <input type="email" name="correo" id="correo" class="form-control" placeholder="No se puede repetir con alguno de la lista...">
                    </div>

                    <input type="hidden" name="accion" value="insert_mec">

                    <br>

                    <div class="mb-3">

                        <input type="submit" value="Guardar" id="register" class="btn btn-success" name="registrar">
                        <a href="mecanicos.php" class="btn btn-danger">Cancelar</a>

                    </div>
            </div>
        </div>

        </form>
    </div>
</div>