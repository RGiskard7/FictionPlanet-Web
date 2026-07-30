<?php
require_once MODELS_PATH . "ImageGalleryModel.php";
require_once DAO_PATH . "ImageGalleryDAO.php";

require_once CORE_PATH . "Utilities.php";
require_once LIBS_PATH . "Pager.php";

class Image_gallery extends Controller {
    private $pageTitle = 'Galería | Fiction Planet';
    private $imagesPerPage = 12;
    private $maxLinksPager = 7;
    
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
        if (Session::is_started() && ($_SESSION['permissions'][MDL_IMAGES]['r'] ?? 0)) {
            if (isset($_POST['action']) && $_POST['action'] === 'imagesDataTableLoad') {
                $imagesDataTable = array();

                Connection::open_connection();
                $imageArray = ImageGalleryDAO::get_images_by_author_id(Connection::get_connection(), $_SESSION['idUser']);

                if (!is_null($imageArray)) {
                    for ($i = 0; $i < count($imageArray); $i++) {
                        $viewBtn = '';
                        $editBtn = '';
                        $removeBtn = '';

                        if ($_SESSION['permissions'][MDL_IMAGES]['r']) {
                            $viewBtn = '<a href="' . IMAGE_SEO_URL . '/' . $imageArray[$i]->get_url() . '"><button type="button" class="btn btn-info btn-sm gmd-1" '
                                . 'name="viewImageBtn" id="viewImageBtn" title="Ver"><i class="fa fa-eye fa-lg" style="color:white" aria-hidden="true"></i></button></a>&nbsp;&nbsp;';
                        } else {
                            $viewBtn = '<button type="button" class="btn btn-info btn-sm" disabled title="Ver">'
                                . '<i class="fa fa-eye fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_IMAGES]['u']) {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm gmd-1" '
                                . 'name="updateImageBtn" id="updateImageBtn" title="Editar"><i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        } else {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm" disabled title="Editar">'
                                    . '<i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_IMAGES]['d']) {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm gmd-1" name="removeImageBtn" id="removeImageBtn" data-idimage="' . $imageArray[$i]->get_id() . '" title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        } else {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm" disabled title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        }

                        if ($imageArray[$i]->is_visible() == 1) {
                            $status = '<span class="badge badge-pill badge-success">Visible</span>';
                        } else {
                            $status = '<span class="badge badge-pill badge-danger">No visible</span>';
                        }

                        $imagesDataTable[$i]['actions'] = $viewBtn . $editBtn . $removeBtn;
                        $imagesDataTable[$i]['index'] = $i + 1;
                        $imagesDataTable[$i]['id'] = $imageArray[$i]->get_id();
                        $imagesDataTable[$i]['title'] = mb_substr($imageArray[$i]->get_title(), 0, 40, 'UTF-8') . '...';
                        $imagesDataTable[$i]['creation_date'] = $imageArray[$i]->get_date_creation();
                        $imagesDataTable[$i]['date_last_update'] = $imageArray[$i]->get_date_last_update();
                        $imagesDataTable[$i]['status'] = $status;
                    }
                }
                Connection::close_connection();

                $response = json_encode($imagesDataTable, JSON_UNESCAPED_UNICODE);
                echo $response;
            }
        }
        exit;
    }

    public function update() {
        if (Session::is_started() && ($_SESSION['permissions'][MDL_IMAGES]['u'] ?? 0)) {
            if (isset($_POST['action']) && $_POST['action'] === 'updateImage') {
                if (!Session::verify_csrf()) {
                    echo json_encode(['error' => 'Token invalido']);
                    exit;
                }

                Connection::open_connection();
                $image = ImageGalleryDAO::get_image_by_id(Connection::get_connection(), $_POST['idImage']);
                if ($image && $image->get_author_id() == $_SESSION['idUser']) {
                    $image->set_title($_POST['title']);
                    $image->set_description($_POST['description'] ?? '');
                    $image->set_visible((int) ($_POST['visible'] ?? 1));
                    $result = ImageGalleryDAO::update_image(Connection::get_connection(), $image);
                    echo json_encode(['success' => (bool) $result]);
                } else {
                    echo json_encode(['error' => 'No autorizado']);
                }
                Connection::close_connection();
            }
        }
        exit;
    }

    public function delete() {
        if (Session::is_started() && ($_SESSION['permissions'][MDL_IMAGES]['d'] ?? 0)) {
            if (isset($_POST['action']) && $_POST['action'] === 'deleteImage') {
                if (!Session::verify_csrf()) {
                    echo json_encode(['error' => 'Token invalido']);
                    exit;
                }

                Connection::open_connection();
                $image = ImageGalleryDAO::get_image_by_id(Connection::get_connection(), $_POST['idImage']);
                if ($image && $image->get_author_id() == $_SESSION['idUser']) {
                    $result = ImageGalleryDAO::delete_image(Connection::get_connection(), $_POST['idImage']);
                    echo json_encode(['success' => (bool) $result]);
                } else {
                    echo json_encode(['error' => 'No autorizado']);
                }
                Connection::close_connection();
            }
        }
        exit;
    }

    public function upload() {
        if (!Session::is_started() || !($_SESSION['permissions'][MDL_IMAGES]['w'] ?? 0)) {
            http_response_code(403);
            exit;
        }

        if (!Session::verify_csrf()) {
            http_response_code(403);
            exit;
        }

        if (isset($_POST["submitUploadNewImage"]) && $_POST["imageTitle"] !== "") {
            if ($_FILES['imageFile']['name'] != "") {
                $infoExt = getimagesize($_FILES['imageFile']['tmp_name']);
                if (strtolower($infoExt['mime']) == 'image/jpeg' || strtolower($infoExt['mime']) == 'image/jpg'
                        || strtolower($infoExt['mime']) == 'image/png') {

                    define('DIR_GALERIA_IMG', ROOT_DIRECTORY . UPLOAD_IMG_GALLERY_DIR);
                    define('DIR_DESCARGAS', DIR_GALERIA_IMG . $_SESSION["idUser"]);

                    if (!file_exists(DIR_DESCARGAS)) @mkdir(DIR_DESCARGAS);

                    list($base, $extension) = explode('.', basename($_FILES['imageFile']['name']));
                    $newName = implode('_', ["image", $base, $_SESSION["idUser"], time()]);

                    $path = DIR_DESCARGAS . DIRECTORY_SEPARATOR . utf8_decode($newName) . '.' . $extension;
                    $url = UPLOAD_IMG_GALLERY_URL . $_SESSION["idUser"] . DIRECTORY_SEPARATOR . utf8_decode($newName) . '.' . $extension;

                    if (move_uploaded_file($_FILES['imageFile']['tmp_name'], $path)) {
                        Connection::open_connection();
                        $imageObject = new ImageGalleryModel(0, $_SESSION["idUser"], $_POST["imageTitle"], null, $url, $path, 0, 0, 1);
                        $insert = ImageGalleryDAO::insert_image(Connection::get_connection(), $imageObject);
                        Connection::close_connection();

                        if ($insert) {
                            echo 1;
                            exit;
                        }
                    }
                    echo 0;
                } else {
                    echo 2;
                }
            } else {
                echo 3;
            }
        } else {
            echo 4;
        }
        exit;
    }
}