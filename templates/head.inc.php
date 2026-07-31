<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= $pageTitle; ?></title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        
        <meta name="title" content="Fiction Planet">
        <meta name="keywords" content="Ciencia ficción, tecnología, programación">
        <meta name="description" content="Descubre lo último en tecnología y ciencia ficción.">
        <meta name="owner" content="Fiction Planet">
        <meta name="author" content="Eduardo Diaz">
        <meta name="robots" content="index, follow">
        <?= Session::csrf_meta(); ?>
        
        <!--<link rel="icon" type="image/png" href="<?= IMAGES_URL . "logo8.png"; ?>">-->
        <link rel="icon" type="image/png" href="<?= IMAGES_URL . "logo_gpt_3.png"; ?>">
        <!--<link rel="shortcut icon" type="image/png" href="<?= IMAGES_URL . "logo8.png"; ?>">-->
        <link rel="shortcut icon" type="image/png" href="<?= IMAGES_URL . "logo_gpt_3.png"; ?>">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="<?= STATIC_URL . "css/bootstrap.min.css"; ?>">
        <!-- Tablas bootstrap -->
        <link rel="stylesheet" href="<?= STATIC_URL . "css/dataTables.bootstrap4.min.css"; ?>">
        <link rel="stylesheet" href="<?= STATIC_URL . "css/buttons.bootstrap4.min.css"; ?>">
        
        <link rel="stylesheet" href="<?= STATIC_URL . "css/style.css"; ?>">
        
        <link rel="stylesheet" href="<?= STATIC_URL . "css/jquery-ui.css"; ?>">
        
        <link rel="stylesheet" href="<?= STATIC_URL . "css/emojionearea.min.css"; ?>">
        
        <link rel="stylesheet" href="<?= STATIC_URL . "css/fileinput.min.css"; ?>">
        <!--Fullcalendar-->
        <link rel="stylesheet" href="<?= STATIC_URL . "css/fullcalendar.min.css"; ?>">  
        <!-- Iconos fa fa -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Gallery -->
        <link rel="stylesheet" href="<?= STATIC_URL . "css/baguetteBox.css"; ?>">
        <link rel="stylesheet" href="<?= STATIC_URL . "css/design.css"; ?>">
    </head>
    <body>
        
        <?php
        include TEMPLATES_PATH . 'modals/data_confirm_modal.inc.php';

        include TEMPLATES_PATH . 'nav/top_navbar.inc.php';
        include TEMPLATES_PATH . 'nav/chat_sidebar.inc.php';        
        ?>
        
        <a href="javascript:void(0);" id="scroll" class="gmd-5" title="Volver arriba">Top<span></span></a>