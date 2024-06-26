<?php
// Seguridad de sesiones
session_start();
error_reporting(0);
$varsesion = $_SESSION['nombre'];

if ($varsesion == null || $varsesion = '') {

    header("Location: ../includes/_sesion/index.html");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <script src="../js/jquery.min.js"></script>

</head>
<?php include "../includes/header.php"; ?>



<body id="page-top">

    <!-- Begin Page Content -->
    <div class="container-fluid">



        <div class="card-body">
            <div class="table-responsive">


                <h1>Sistema Administrativo para Citas en Talleres mecanicos "MOTOFTWARE" Version 1.0</h1>
                <br>

                <p> MOTOFTWARE es un sistema administrativo de citas para motos <b>basico</b> su funcion principal
                    es llevar una mejor gestion sobre las operaciones administrativas que se tiene en un taller 
                    mecanico, de esta manera se lleva un mejor control de las citas mecanicas atravez de este sistema .
                </p>
                <br>

                <h2>Sobre el Desarrollador</h2>
                <br>
                <p>Desarrollado y Mantenido por <a href="https://softcodepm.com/"> Programadores ADSO </a>.
                    Este sistema es opensource asi que puedes modificarlo segun a tus necesidades.

                    ¿Quieres conocer la version mas actualizada de este sistema con mayores funcionalidades? <a href="https://youtu.be/62YKHF_VPDA?si=8TRjdB05FQ7hvOrf" target="_blank">Click Aqui</a>.
                </p>

                <br>

                <p><b>NOTA:</b> Si tienes alguna duda del funcionamiento del sistema solo respondemos por <b>email</b> o <b>comentarios</b> de Youtube. Si mandas mensaje
                    a nuestro numero de <b>contacto</b> no respondemos dudas de instalacion, configuracion, etc, a menos que sean <b>propuestas de trabajo y cotizaciones.</b>
                </p>
            </div>
        </div>
    </div>


</body>
<?php include "../includes/footer.php"; ?>

</html>