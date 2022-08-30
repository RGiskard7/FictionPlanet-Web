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
}
?>
