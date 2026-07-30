<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<script>
    document.getElementById("aboutUsLink").classList.add("active-nav");
</script>

<div id="main">
    <div class="container">
        <div class="card mb-4">
            <div class="card-body text-center py-5">
                <img src="<?= IMAGES_URL . "logo_gpt_2.png"; ?>" width="80" alt="Logo" class="mb-3">
                <h2 class="font-weight-bold">Fiction Planet</h2>
                <p class="text-muted lead">Red social didactica de ciencia ficcion y tecnologia</p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-body p-4">
                        <h4 class="mb-3">Sobre este proyecto</h4>
                        <p>Esta pagina web es solo para fines didacticos, no esta siendo utilizada para ningun objetivo comercial, y surge unicamente como proyecto personal y como ejemplo de las capacidades adquiridas. Tanto el nombre como el logo son provisionales, asi como algunos ejemplos para rellenar texto o diversas imagenes.</p>
                        
                        <h5 class="mt-4 mb-3">Aspectos tecnicos</h5>
                        <ul>
                            <li class="mb-2">El area logica esta desarrollada integramente en <strong>PHP</strong>, siguiendo el patron de arquitectura <strong>MVC</strong> (Modelo-Vista-Controlador) para separar la logica de negocio de su visualizacion.</li>
                            <li class="mb-2">La persistencia de datos esta a cargo de una base de datos <strong>MySQL/MariaDB</strong>, utilizando el patron <strong>DAO</strong> (Data Access Object) para separar la logica de negocio del acceso a datos.</li>
                            <li class="mb-2">Para el diseno se usa <strong>Bootstrap 4</strong> junto con <strong>JavaScript</strong> y la libreria <strong>jQuery</strong>.</li>
                        </ul>
                        
                        <p class="mt-3">A grandes rasgos, Fiction Planet intenta imitar lo que seria una pequena red social en la que se puede tener un perfil para crear publicaciones, subir fotos y hablar con otros contactos a traves de un chat en vivo.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-body text-center py-4">
                        <img src="<?= IMAGES_URL . "avatar_2x.png"; ?>" class="rounded-circle mb-3" width="100" height="100" alt="" style="border:3px solid #E4E6EB;padding:3px;">
                        <h6 class="font-weight-bold mb-1">Nombre Apellidos</h6>
                        <small class="text-muted">Desarrollador</small>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h6 class="font-weight-bold mb-3"><i class="fa fa-address-card mr-2"></i>Contacto</h6>
                        <div class="mb-2 small"><i class="fa fa-map-marker fa-fw mr-2 text-muted"></i>Madrid, Espana</div>
                        <div class="mb-2 small"><i class="fa fa-envelope fa-fw mr-2 text-muted"></i>info@correo.com</div>
                        <div class="small"><i class="fa fa-phone fa-fw mr-2 text-muted"></i>+34 000 000 000</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include TEMPLATES_PATH . 'scripts.inc.php';
include TEMPLATES_PATH . "footer.inc.php";
?>
