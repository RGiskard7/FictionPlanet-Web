<?php
require_once MODELS_PATH . 'UserModel.php';
require_once MODELS_PATH . 'PostModel.php';

require_once DAO_PATH . 'UserDAO.php';
require_once DAO_PATH . 'PostDAO.php';

require_once LIBS_PATH . 'validators/NewPostsValidator.php';
require_once LIBS_PATH . 'validators/UpdatedPostsValidator.php';

class Posts extends Controller {
    private $tempDirectory = ROOT_DIRECTORY . UPLOAD_POSTS_DIR . 'temp-';
    private $attachedFileDirectory = ROOT_DIRECTORY . UPLOAD_POSTS_DIR;
    
    public function posts() {        
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['r']) {
            Redirection::redirect(BASE_URL);
        }

        $data['pageTitle'] = 'Publicaciones | Fiction Planet';
        $this->view->render($this, 'posts', $data);
    }
    
    public function get($postURL) {
        Connection::open_connection();
        $post = PostDAO::get_post_by_url(Connection::get_connection(), $postURL);

        if ($post != null) {
            $author = UserDAO::get_user_by_id(Connection::get_connection(), $post->get_author_id());
            
            if (!$post->is_visible()) {
                // Si el post no es visible y no se ha iniciado sesion o no se tienen
                // los permisos para ver post no visibles, se devuelve a la pag principal
                if (Session::is_started() && $author->get_id() != $_SESSION['idUser'] 
                        && !$_SESSION['permissions'][MDL_POSTS]['r'] || !Session::is_started()) {
                    Redirection::redirect(BASE_URL);
                } 
                $postStatus = 'Publicación no visible';
            } else {
                $postStatus = '';
            }
             
            $data['pageTitle'] = 'Publicación | Fiction Planet';
            $data['post'] = $post;
            $data['postStatus'] = $postStatus;
            $data['author'] = $author;
            $data['attachedFiles'] = Utilities::get_all_contents_of_directory($this->attachedFileDirectory . $post->get_id());
            
            $this->view->render($this, 'post', $data);
            
        } else {
            error_log('Error: get_post_by_url()" - create post');
            Redirection::redirect(BASE_URL);
        }
        
        Connection::close_connection();  
    }
    
    public function create($validator = '') {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['w']) {
            Redirection::redirect(BASE_URL);
        }
        
        $data['pageTitle'] = 'Crear publicación | Fiction Planet';
        //Cuando se tiene una publicacion en creacion y no ha pasado el validador
        if (!empty($validator)) { 
            $data['validator'] = $validator;
        //Cuando se crea una nueva publicacion de 0
        } else { 
            //Se elimina la carpeta temporal del usuario por si la ultima operacion se quedo a medias
            Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']);
        }
        
        $this->view->render($this, 'create_post', $data);
    }
    
    public function submit_new_post() {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['w']) {
            Redirection::redirect(BASE_URL);
        }
        
        if (isset($_POST['submitNewPost'])) {
            //Para evitar inyection SQL
            $postTitle = trim(htmlentities($_POST['postTitle'], ENT_QUOTES)); 
            $postIntroduction = trim($_POST['postIntroduction']);
            $postContent = trim($_POST['postContent']);
            
            isset($_POST['postCheckbox']) ? $activePost = true : $activePost = false;

            Connection::open_connection();
            $validator = new NewPostsValidator($postTitle, $postIntroduction, $postContent, $activePost, Connection::get_connection());
            if ($validator->valid_form()) { 
                $url = Utilities::friendly_url_generator($validator->get_title());

                $newPost = new PostModel(0, $url, $_SESSION['idUser'], $validator->get_title(), $validator->get_introduction(), 
                        $validator->get_content(), 0, 0, $activePost);
                $result = PostDAO::insert_post(Connection::get_connection(), $newPost);
                // Posible error 
                $savePost = PostDAO::get_post_by_title(Connection::get_connection(), $validator->get_title()); //Obtener id de insert

                if ($result) {         
                    Utilities::copy_all_contents_of_directory($this->tempDirectory . $_SESSION['idUser'], $this->attachedFileDirectory . $savePost->get_id()); 
                } else {
                    error_log('Error: insert_post()" - create post');
                } 
                //Elimina carpeta temporal con archivos adjuntos
                Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']); 
                Redirection::redirect($this->get_source_URL());
            }
            Connection::close_connection();
            $this->create($validator); 

        } else if (isset($_POST['submitCancelNewPost'])) {
            Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']);
            Redirection::redirect($this->get_source_URL());
        } else {
            error_log('Error: "submit new post" - create post');
            Redirection::redirect(BASE_URL);
        }
    }
    
    public function update($postURL, $validator = '') {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['u'] 
                || !isset($postURL)) {
            Redirection::redirect(BASE_URL);
        }
        
        Connection::open_connection();
        $post = PostDAO::get_post_by_url(Connection::get_connection(), $postURL);
        
        if ($post != null) {
            $attachedFiles = Utilities::get_all_contents_of_directory($this->attachedFileDirectory . $post->get_id());
        } else {
            error_log('Error: "get_post_by_url()" - update post');
            Redirection::redirect(BASE_URL . 'fault/error_404'); // Revisar 
        }
        Connection::close_connection();        
        
        $data['pageTitle'] = 'Editar publicación | Fiction Planet';
        $data['post'] = $post;
        $data['attachedFiles'] = $attachedFiles;
        $data['url'] = $postURL;
        //Cuando se tiene una publicacion en actualizacion y no ha pasado el validador
        if (!empty($validator)) {
            $data['validator'] = $validator;
        //Cuando se edita una publicacion de 0
        } else {
            // Se elimina la carpeta temporal del usuario, si la hubiera, por si la ultima operacion se quedo a medias
            // Se copian todos los archivos de la carpeta real asociada al post (si la hubiera) a la carpeta temporal 
            // nueva para trabajar sobre ella. Todo esto tiene que ir despues del submit, para no 
            // borrar la carpeta temporal cuando se ha activado el formulario.
            Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']);
            Utilities::copy_all_contents_of_directory($this->attachedFileDirectory . $post->get_id(), $this->tempDirectory . $_SESSION['idUser']);
        }
        
        $this->view->render($this, 'update_post', $data);
    }
    
    public function submit_post_update() {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_POSTS]['u']) {
            Redirection::redirect(BASE_URL);
        }
        
        if (isset($_POST['submitPostUpdate'])) {
            $postID = trim(htmlentities($_POST['postID'], ENT_QUOTES));
            $postURL = trim(htmlentities($_POST['postURL'], ENT_QUOTES));
            $oldPostTitle = trim(htmlentities($_POST['oldPostTitle'], ENT_QUOTES));
            $postTitle = trim(htmlentities($_POST['postTitle'], ENT_QUOTES)); //Para evitar inyection SQL
            $postIntroduction = $_POST['postIntroduction'];
            $postContent = $_POST['postContent'];
            
            isset($_POST['postCheckbox']) ? $activePost = true : $activePost = false;
            
            Connection::open_connection();
            $validator = new UpdatedPostsValidator($oldPostTitle, $postTitle, $postIntroduction, $postContent, $activePost, Connection::get_connection());
            if ($validator->valid_form()) {
                $updateUrl = Utilities::friendly_url_generator($validator->get_title());

                $updatedPost = new PostModel($postID, $updateUrl, $_SESSION['idUser'], $validator->get_title(), 
                        $validator->get_introduction(), $validator->get_content(), 0, 0, $activePost);

                $result = PostDAO::update_post(Connection::get_connection(), $updatedPost);

                if ($result) {
                    // Se elimina la carpeta de archivos real asociada al post
                    // se crea de nuevo la carpeta real y se copian todos los cambios realizados 
                    // hechos sobre la carpeta temporal de actualizaciones
                    // finalmente se elimina la carpeta temporal
                    Utilities::delete_directory($this->attachedFileDirectory . $postID);
                    Utilities::copy_all_contents_of_directory($this->tempDirectory . $_SESSION['idUser'], $this->attachedFileDirectory . $postID);
                    Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']);

                    // Si la carpeta de archivos del post se ha quedado vacia
                    // despues de los cambios, se elimina
                    if (Utilities::directory_is_empty($this->attachedFileDirectory . $postID)) {
                        Utilities::delete_directory($this->attachedFileDirectory . $postID);
                    }
                } else {
                    error_log('Error: "update_post()" - update post');
                }

                Redirection::redirect($this->get_source_URL());
            }
            Connection::close_connection();
            $this->update($postURL, $validator); 
            
        } else if (isset($_POST['submitCancelPostUpdate'])) {
            Utilities::delete_directory($this->tempDirectory . $_SESSION['idUser']);
            Redirection::redirect($this->get_source_URL());
        } else {
            error_log('Error: "submit post updated" - update post');
            Redirection::redirect(BASE_URL);
        }
    }
    
    public function delete() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_POSTS]['d']*/) {
            if (isset($_POST['action']) && $_POST['action'] === 'deletePost') {
                Connection::open_connection();
                $result = PostDAO::delete_post(Connection::get_connection(), trim($_POST['idPost']));
                Connection::close_connection();

                if ($result) {
                    Utilities::delete_directory($this->attachedFileDirectory . trim($_POST['idPost']));
                }

                echo $result;  
            }   
        }
        exit;
    }
    
    public function refresh_attached_files() {
        if (Session::is_started()) {
            if (isset($_POST['action']) /*&& $_POST['action'] === 'refreshAttachedFiles'*/) {
                $attachedFiles = Utilities::get_all_contents_of_directory($this->tempDirectory . $_SESSION['idUser']);
    
                ob_start(); // Abrir buffer
                include TEMPLATES_PATH . 'update_attached_files.inc.php';
                $output = ob_get_contents();
                ob_end_clean(); // Carrar buffer

                echo $output;
            }  
        }
        exit;
    }
    
    public function remove_attached_file() {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_POSTS]['w'] 
                && $_SESSION['permissions'][MDL_POSTS]['u']*/) {
            
            if (isset($_POST['action']) && $_POST['action'] === 'removeAttachedFile' && isset($_POST['nameFile'])) {
                if (Utilities::delete_file_of_directory($this->tempDirectory . $_SESSION['idUser'], trim($_POST['nameFile']))) {
                    $attachedFiles = Utilities::get_all_contents_of_directory($this->tempDirectory . $_SESSION['idUser']);
                    
                    ob_start(); // Abrir buffer
                    include TEMPLATES_PATH . 'update_attached_files.inc.php';
                    $output = ob_get_contents();
                    ob_end_clean(); // Carrar buffer
                    
                    $result = ['output' => $output, 'success' => true];
                } else {
                    $result = ['output' => null, 'success' => false];
                }

                $response = json_encode($result);

                echo $response; 
            }   
        }
        exit;
    }

    public function posts_data_table_load($isProfile = false) {
        if (Session::is_started() /*&& $_SESSION['permissions'][MDL_POSTS]['r']*/) {
            
            if (isset($_POST['action']) && $_POST['action'] === 'postsDataTableLoad') {
                $postsDataTable = array();

                $viewBtn = '';
                $editBtn = '';
                $removeBtn = '';

                $postArray = '';

                Connection::open_connection();
                
                if (!$isProfile) {
                    $postArray = PostDAO::get_all_posts_by_last_update_date_desc(Connection::get_connection());
                } else if ($isProfile) {
                    $postArray = PostDAO::get_posts_by_author_id_last_update_date_desc(Connection::get_connection(), $_SESSION['idUser']);
                } else {
                    $postArray = array();
                }
                

                if (!is_null($postArray)) {
                    for ($i = 0; $i < count($postArray); $i++) {
                        if ($_SESSION['permissions'][MDL_POSTS]['r']) {
                            $viewBtn = '<a href="' . POST_SEO_URL . '/' . $postArray[$i]->get_url() .'"><button type="button" class="btn btn-info btn-sm gmd-1" '
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

                        $postsDataTable[$i]['actions'] = $viewBtn . $editBtn . $removeBtn;
                        $postsDataTable[$i]['index'] = $i + 1;
                        $postsDataTable[$i]['id'] = $postArray[$i]->get_id();
                        $postsDataTable[$i]['title'] = mb_substr($postArray[$i]->get_title(), 0, 40, 'UTF-8') . '...';
                        $postsDataTable[$i]['creation_date'] = $postArray[$i]->get_date_creation();
                        $postsDataTable[$i]['date_last_update'] = $postArray[$i]->get_date_last_update();
                        if (!$isProfile) {
                            $postsDataTable[$i]['author'] = $author->get_user_name();
                        }
                        $postsDataTable[$i]['status'] = $status;
                    }
                }
                Connection::close_connection();

                $response = json_encode($postsDataTable, JSON_UNESCAPED_UNICODE);

                echo $response;  
            }
            
        }
        exit;
    }
    
    private function get_source_URL() {
        if(empty($_COOKIE['sourceURL'])) {
            $sourceURL = BASE_URL;
        } else {
            $sourceURL = $_COOKIE['sourceURL'];
            setcookie('sourceURL', '', time() - 100);
        }
        return $sourceURL;
    }
    
}