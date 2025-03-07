<?php
require_once MODELS_PATH . "ImageGalleryModel.php";
require_once DAO_PATH . "ImageGalleryDAO.php";

require_once LIBS_PATH . "Pager.php";

class Image_gallery extends Controller {
    private $pageTitle = 'Galería | Fiction Planet';
    private $imagesPerPage = 12;
    private $maxLinksPager = 7;
    
    /*public function __construct() {
        parent::__construct();
        session_start();
    }*/
    
    public function image_gallery() {
        $currentPage = 1;
        $firstImage = ($currentPage - 1) * $this->imagesPerPage;

        Connection::open_connection();
        $numVisibleImages = ImageGalleryDAO::get_number_of_all_visible_images(Connection::get_connection());
        $imageArray = ImageGalleryDAO::get_all_visible_images_by_last_update_date_desc(Connection::get_connection(), $firstImage, $this->imagesPerPage); // TABLA DE IMAGENES
        Connection::close_connection();

        if ($imageArray === null) {
            $imageArray = array();
        }
        
        $data['pageTitle'] = $this->pageTitle;
        $data['currentPage'] = $currentPage;
        $data['imagesPerPage'] = $this->imagesPerPage;
        $data['maxLinksPager'] = $this->maxLinksPager;
        $data['numVisibleImages'] = $numVisibleImages;
        $data['imageArray'] = $imageArray;
        
        $this->view->render($this, "gallery", $data);
    }
    
    public function page($number) {
        Connection::open_connection();
        $numVisibleImages = ImageGalleryDAO::get_number_of_all_visible_images(Connection::get_connection());
        $totalPages = ceil($numVisibleImages / $this->imagesPerPage);

        if ($number > 0 && $number <= $totalPages) {
            $currentPage = $number;
        } else {
            $currentPage = 1;
        }

        $firstImage = ($currentPage - 1) * $this->imagesPerPage;
        $imageArray = ImageGalleryDAO::get_all_visible_images_by_last_update_date_desc(Connection::get_connection(), $firstImage, $this->imagesPerPage); // TABLA DE IMAGENES
        Connection::close_connection();

        if ($imageArray === null) {
            $imageArray = array();
        }
        
        $data['pageTitle'] = $this->pageTitle;
        $data['currentPage'] = $currentPage;
        $data['imagesPerPage'] = $this->imagesPerPage;
        $data['maxLinksPager'] = $this->maxLinksPager;
        $data['numVisibleImages'] = $numVisibleImages;
        $data['imageArray'] = $imageArray;

        $this->view->render($this, "gallery", $data);
    }
    
    public function images_data_table_load() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_USERS]['r']*/) {
            
            if (isset($_POST['action']) && $_POST['action'] === 'imagesDataTableLoad') {
                $imagesDataTable = array();

                $imageArray = '';
                
                Connection::open_connection();
                $imageArray = ImageGalleryDAO::get_images_by_author_id(Connection::get_connection(), $_SESSION['idUser']);

                if (!is_null($imageArray)) {
                    for ($i = 0; $i < count($imageArray); $i++) {

                        $viewBtn = '';
                        $editBtn = '';
                        $removeBtn = '';

                        if ($_SESSION['permissions'][MDL_IMAGES]['r']) {
                            $viewBtn = '<a href="' . IMAGE_SEO_URL . '/' . $imageArray[$i]->get_url() .'"><button type="button" class="btn btn-info btn-sm gmd-1" '
                                . 'name="viewPostBtn" id="viewPostBtn" title="Ver"><i class="fa fa-eye fa-lg" style="color:white" aria-hidden="true"></i></button></a>&nbsp;&nbsp;';
                        } else {
                            $viewBtn = '<button type="button" class="btn btn-info btn-sm" disabled title="Ver">'
                                . '<i class="fa fa-eye fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_POSTS]['u']) {
                            $editBtn = '<a href="' . UPDATE_POST_SEO_URL . '/' . $postArray[$i]->get_url() . '"><button type="button" class="btn btn-warning btn-sm gmd-1" '
                                . 'name="updatePostBtn" id="updatePostBtn" title="Editar"><i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button></a>&nbsp;&nbsp;';
                        } else {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm" disabled title="Editar">'
                                    . '<i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_POSTS]['d']) {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm gmd-1" name="removePostBtn" id="removePostBtn" data-idpost="' . $postArray[$i]->get_id() . '" title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        } else {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm" disabled title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        }

                        $author = UserDAO::get_user_by_id(Connection::get_connection(), $postArray[$i]->get_author_id());

                        if ($postArray[$i]->is_visible() == 1) {
                            $status = '<span class="badge badge-pill badge-success">Visible</span>';
                        } else {
                            $status = '<span class="badge badge-pill badge-danger">No visible</span>';
                        }

                        $imagesDataTable[$i]['actions'] = $viewBtn . $editBtn . $removeBtn;
                        $imagesDataTable[$i]['index'] = $i + 1;
                        $imagesDataTable[$i]['id'] = $postArray[$i]->get_id();
                        $imagesDataTable[$i]['title'] = mb_substr($postArray[$i]->get_title(), 0, 40, 'UTF-8') . '...';
                        $imagesDataTable[$i]['creation_date'] = $postArray[$i]->get_date_creation();
                        $imagesDataTable[$i]['date_last_update'] = $postArray[$i]->get_date_last_update();
                        if (!$isProfile) {
                            $postDataTable[$i]['author'] = $author->get_user_name();
                        }
                        $postDataTable[$i]['status'] = $status;
                    }
                }
                Connection::close_connection();

                $response = json_encode($userDataTable, JSON_UNESCAPED_UNICODE);

                echo $response;
            }
        }
        exit;
    }
}