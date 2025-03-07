<?php
$pageTitle = $data['pageTitle'];
$numVisiblePosts = $data['numVisiblePosts'];
$postsPerPage = $data['postsPerPage'];
$maxLinksPager = $data['maxLinksPager'];
$currentPage = $data['currentPage'];
$postArray = $data['postArray'];

include TEMPLATES_PATH . 'head.inc.php';

include TEMPLATES_PATH . 'modals/calendar_modal.inc.php';
/*Para poder crear nuevos eventos en el calendario*/
if (Session::is_started() && $_SESSION['permissions'][MDL_PUBLIC_CALENDAR]['w']) {
    include TEMPLATES_PATH . 'modals/new_event_calendar_modal.inc.php';
}
?>

<script>
    document.getElementById("homeLink").style.color="#1e90ff"; 
    document.getElementById("homeLink").style.borderBottom="0.219em solid dodgerblue"; 
    /*document.getElementById("homeLink").style.fontWeight="700";*/
</script>

<div id="main">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-sm-12 col-md-12">
                <div id="carouselIndicators" class="carousel slide gmd-0" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators" style="z-index:1;">
                        <li data-target="#carouselIndicators" data-slide-to="0"></li>
                        <li data-target="#carouselIndicators" data-slide-to="1"></li>
                        <li data-target="#carouselIndicators" data-slide-to="2"></li>
                        <li data-target="#carouselIndicators" data-slide-to="3" class="active"></li>
                        <li data-target="#carouselIndicators" data-slide-to="4"></li>
                        <li data-target="#carouselIndicators" data-slide-to="5"></li>
                    </ol>
                    <!-- Wrapper for slides -->
                    <div id="photoCarousel" class="carousel-inner shadow-lg">
                        <div class="carousel-item active">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_14.jpg"; ?>" alt="First slide">
                              <div class="carousel-caption d-none d-md-block">
                                <h5>Esto es una prueba</h5>
                                <p>Esto es otra prueba</p>
                              </div>
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_15.jpg"; ?>" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_16.jpg"; ?>" alt="Third slide">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_17.jpg"; ?>" alt="Four slide">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_18.jpg"; ?>" alt="five slide">
                        </div>
                        <div class="carousel-item">
                            <img class="w-100 img-fluid d-block" src="<?= IMAGES_URL . "image_carousel_19.jpeg"; ?>" alt="six slide">
                        </div>
                    </div>
                    <!-- Left and right controls -->
                    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="row row-cols-2 justify-content-center">
            <div class="col-12 col-sm-12 col-md-8">
                <?php //if ($numVisiblePosts > $maxLinksPager): ?>
                <div class ="row">
                    <div class="col-md-12">
                        <div id="searchBarHome" class="card gmd-0 p-2 mb-2">
                            <form id="formSearchPost" role="form" method="get" action="<?= SEARCH_POST_SEO_URL ?>" name="formSearchPost">
                                <div class="input-group">
                                    <input type="search" id="search" name="search" class="form-control" placeholder="Búsqueda..." />
                                    <div class="input-group-append">
                                        <select class="custom-select input-group-text" id="searchBySelect" name="searchBySelect" style="text-align: left;">
                                            <optgroup label="Buscar por:">
                                                <option value="all" selected>Todo</option>
                                                <option value="title">Titulo</option>
                                                <option value="author">Autor</option>
                                                <option value="introduction">Introducción</option>
                                                <option value="content">Contenido</option>
                                                <option value="date">Fecha</option>
                                            </optgroup>
                                        </select>
                                        <!--<button type="submit" name="submitSearchPost" class="btn btn-primary">-->
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- comment -->
                </div>
                <?php //endif; ?>     
                <div class="row">
                    <div class="col-md-12">
                        <div id="postListHomeCard" class="card gmd-0 bg-white">
                            <div class="card-header">
                                <strong class="ml-2 mr-2">Publicaciones</strong>
                            </div>
                            <div class='card-body mr-2 ml-2'>
                                <?php
                                $urlPager = "/home/";
                                $pager = new Pager($urlPager, $numVisiblePosts, $postsPerPage, $maxLinksPager, $currentPage); // PAGINATOR
                                $htmlPager = $pager->get_data_pager();

                                include_once TEMPLATES_PATH . "post_list.inc.php";
                                ?>
                            </div>
                            <div class='card-footer text-muted border-top pt-4'>
                                <?php if ($htmlPager != ""): ?>
                                    <?php echo $htmlPager; ?>
                                <?php else: ?>
                                    </br>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="col-12 col-sm-12 col-md-4">
                 <div class="row">
                    <div class="col-md-12">
                        <div id="calendarHomeCard" class="card gmd-0 bg-white">
                            <div class="card-header">
                                <strong>Calendario</strong>
                            </div>
                            <div class="card-body">
                                <div id="calendarMini" class="col-centered"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div id="weekListHomeCard" class="card gmd-0 bg-white">
                            <div class="card-header">
                                <strong>Próximos eventos</strong>
                            </div>
                            <div class="card-body">
                                <div id="calendarDiary" class="col-centered"></div>
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

