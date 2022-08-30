<?php
$pageTitle = $data['pageTitle'];

include TEMPLATES_PATH . 'head.inc.php';
?>

<script>
    document.getElementById("aboutUsLink").style.color="#1e90ff"; 
    document.getElementById("aboutUsLink").style.borderBottom="0.219em solid dodgerblue"; 
    document.getElementById("aboutUsLink").style.fontWeight="700";
</script>

<div id="main">
    <div class="container">
        <div id="contactPageCard" class="card gmd-0 bg-white">
            <div class="row p-4">
                <div class="col-md-12">
                    <div id="jumbo" class="jumbotron border shadow">
                        <h1 class="text-center">Información</h1>
                        <hr class="my-2 featurette-divider w-50">
                        <h3 class="text-center">¿En que consiste esta página web?</h3>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 d-flex justify-content-center">
                    <img src="<?php echo IMAGES_URL . "logo10.jpeg"; ?>" width="250" alt="" class="thumbnail"/>
                </div>
            </div>

            <div class="card-body">

                <hr class="my-2 featurette-divider">
                                
                <!--<hr class="my-2 featurette-divider">-->
                
                <!--<p>&nbsp;</p>
                               
                <p style="text-align:center"><strong><span style="font-size:14.0pt">EQUIPO CUALIFICADO</span></strong></p>

                </br>

                <p style="text-align:center"><img class="gmd-5 img-fluid" alt="" height="338" src="<?php echo IMAGES_URL . 'nosotros-imagen1.png'; ?>" width="507" style="border-radius: 7px;" /></p>-->
                <div class="pl-4 pr-4">
                
                </br>
                <p>Esta p&aacute;gina web es solo para fines did&aacute;cticos, no est&aacute; siendo utilizada para ning&uacute;n objetivo comercial, y de momento surge &uacute;nicamente como 
                    proyecto personal y como ejemplo de las capacidades adquiridas. Tanto el nombre como el logo son cosas provisionales, as&iacute; como algunos ejemplos para rellenar texto o diversas im&aacute;genes.</p>
                <p>Respecto a los aspectos t&eacute;cnicos:&nbsp;</p>
                <ul style= "list-style-type: square;">
                    <li>El &aacute;rea l&oacute;gica de esta p&aacute;gina web est&aacute; desarrollada &iacute;ntegramente en PHP, siguiendo, en la medida de los posible, el patr&oacute;n de 
                        arquitectura MVC (Modelo-Vista-Controlador) para poder separar la l&oacute;gica de negocio y su visualizaci&oacute;n. La persistencia de datos est&aacute; a cargo de 
                        una base de datos implementada en MySQL, y con la intenci&oacute;n de separar la l&oacute;gica de negocio de la l&oacute;gica de acceso a datos, se ha utilizado tambi&eacute;n el 
                        patr&oacute;n DAO (Data Access Object).&nbsp;</li></br>
                    <li>En lo que compete al dise&ntilde;o, se hace uso de la biblioteca Bootstrap de HTML y CSS, as&iacute; como del lenguaje JavaScript junto con la librer&iacute;a JQuery.</li>
                </ul>
                <p>A grandes rasgos la p&aacute;gina web Fiction Planet intenta imitar lo que ser&iacute;a una peque&ntilde;a red social en la que se puede tener un perfil para crear publicaciones, subir fotos y hablar con otros contactos a trav&eacute;s de un chat en vivo.</p>

                </br>
                </div>


                <p style="text-align:center"><strong><span style="font-size:14.0pt">PERSONA CLAVE</span></strong></p>
                
                </br>

                <div class="row justify-content-center">
                    <div class="p-4 col-lg-12 align-self-center">
                        <div class="text-center">
                            <img class="img-fluid gmd-5" src="<?php echo IMAGES_URL . "avatar_2x.png"; ?>" width="200" height="200" alt="" title="" media-simple="true" style="border-radius:150px;">
                        </div>
                        <div class="card-box">
                            <h6 class="card-title py-3 mbr-fonts-style text-center">
                                <strong>Nombre Apellidos</strong>
                            </h6>
                        </div>
                    </div>
                </div>
                
                <p>&nbsp;</p>
                
                <hr class="my-2 featurette-divider">

                <div class="row bg-grey">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="text-center my-4">DATOS DE CONTACTO</h2>
                            </div>
                        </div>
                        <div class="row d-flex justify-content-center mb-4">
                            <div class="col-md-6">
                                <div class="card bg-white gmd-2" style="border-radius: 17px;">
                                    <div class="card-body align-items-center">
                                        <div>
                                            <!--<p><strong>Datos de contacto</strong></p>-->                                           
                                            <p><i class="icon fa fa-home fa-fw mr-2"></i>USS Enterprise, Espacio exterior</p>
                                            <p><i class="icon fa fa-envelope fa-fw mr-2"></i>info@correo.com</p>
                                            <p><i class="icon fa fa-phone fa-fw mr-2"></i>+34 000 000 000</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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