<!--Variables globales de php a js-->
<script>
    const BASE_URL = "<?= BASE_URL; ?>";
</script>

<!-- jquery -->
<script type="text/javascript" src="<?= STATIC_URL . "js/jquery-3.5.1.js"; ?>"></script>

<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/jquery-ui.js"; ?>"></script>

<script type="text/javascript" src="<?= STATIC_URL . "js/bootstrap.bundle.min.js"; ?>"></script>

<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/js.cookie.min.js"; ?>"></script>

<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/emojionearea.min.js"; ?>"></script>
<!--Datatables-->
<!--<script type="text/javascript" src="<?php //echo STATIC_URL . "js/plugins/datatables.min.js"; ?>"></script>-->
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.bootstrap4.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.print.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.7.0/js/buttons.colVis.min.js" type="text/javascript"></script>


<!--Bootstrap-fileinput-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.4/js/plugins/piexif.min.js" type="text/javascript"></script>
<!-- sortable.min.js is only needed if you wish to sort / rearrange files in initial preview. 
    This must be loaded before fileinput.min.js -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.4/js/plugins/sortable.min.js" type="text/javascript"></script>
<!-- popper.min.js below is needed if you use bootstrap 4.x. You can also use the bootstrap js 
   3.3.x versions without popper.min.js. -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<!-- bootstrap.min.js below is needed if you wish to zoom and preview file content in a detail modal
    dialog. bootstrap 4.x is supported. You can also use the bootstrap js 3.3.x versions. -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" type="text/javascript"></script>
<!-- the main fileinput plugin file -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.4/js/fileinput.min.js"></script>
<!-- optionally if you need a theme like font awesome theme you can include it as mentioned below -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.4/themes/fa/theme.js"></script>
<!-- optionally if you need translation for your language then include  locale file as mentioned below -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-fileinput/5.1.4/js/locales/es.js"></script>

<!--Fullcalendar-->
<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/moment.min.js"; ?>"></script> 
<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/fullcalendar.min.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/fullcalendar-es.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/plugins/sweetalert.min.js"; ?>"></script>

<!--CKEditor-->
<script type="text/javascript" src="<?= PLUGINS_URL . 'ckeditor/ckeditor.js'; ?>"></script>

<!-- Gallery -->
<script type="text/javascript" src="<?= STATIC_URL . 'js/plugins/baguetteBox.js'; ?>"></script>


<script type="text/javascript" src="<?= STATIC_URL . "js/main.js"; ?>"></script>
<?php if (Session::is_started() && $_SESSION['permissions'][MDL_CHAT]['r'] 
        && $_SESSION['permissions'][MDL_CHAT]['w'] && $_SESSION['permissions'][MDL_CHAT]['u'] 
        && $_SESSION['permissions'][MDL_CHAT]['d']): ?>
<script type="text/javascript" src="<?= STATIC_URL . "js/chatFunctions.js"; ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?= STATIC_URL . "js/fileInput.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/userFunctions.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/postFunctions.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/roleFunctions.js"; ?>"></script>
<script type="text/javascript" src="<?= STATIC_URL . "js/imageGalleryFunctions.js"; ?>"></script>