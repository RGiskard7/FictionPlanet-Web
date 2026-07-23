<?php
require_once MODELS_PATH . "UserModel.php";
require_once MODELS_PATH . "RoleModel.php";
require_once MODELS_PATH . "PostModel.php";
require_once MODELS_PATH . "ContactModel.php";
require_once MODELS_PATH . "FriendRequestsModel.php";
require_once MODELS_PATH . "ImageGalleryModel.php";

require_once DAO_PATH . "UserDAO.php";
require_once DAO_PATH . "RoleDAO.php";
require_once DAO_PATH . "PostDAO.php";
require_once DAO_PATH . "ContactDAO.php";
require_once DAO_PATH . "FriendRequestsDAO.php";
require_once DAO_PATH . "ImageGalleryDAO.php";

require_once LIBS_PATH . "validators/NewUserValidator.php";
require_once LIBS_PATH . "Pager.php";

class Users extends Controller {
    private $postsPerPage = 5;
    private $maxLinksPager = 7;
    private $imagesPerPage = 12; 
    
    public function users() {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_USERS]['r']) {
            Redirection::redirect(BASE_URL);
        }
        
        Connection::open_connection();
        $roleArray = RoleDAO::get_all_roles(Connection::get_connection());
        Connection::close_connection();
        
        $data['pageTitle'] = 'Registrar usuario | Fiction Planet';
        $data['roleArray'] = $roleArray;
        
        $this->view->render($this, 'users', $data);
    }
        
    public function create() {
        if (!Session::is_started() || !$_SESSION['permissions'][MDL_USERS]['w']) {
            Redirection::redirect(BASE_URL);
        }
        
        Connection::open_connection();
        $roleArray = RoleDAO::get_all_roles(Connection::get_connection());
        Connection::close_connection();
        
        if (isset($_POST['submitNewUser'])) {
            if (!Session::verify_csrf()) {
                echo json_encode(['error' => 'Token de seguridad invalido']);
                exit;
            }
            $userName = trim(htmlentities($_POST['userNameNewUser'], ENT_QUOTES)); //Para evitar inyection SQL
            $firstName = trim((htmlentities($_POST['firstNameNewUser'], ENT_QUOTES)));
            $lastName = trim(htmlentities($_POST['lastNameNewUser'], ENT_QUOTES));
            $email = trim(htmlentities($_POST['emailNewUser'], ENT_QUOTES));
            $password1 = trim(htmlentities($_POST['password1NewUser'], ENT_QUOTES));
            $password2 = trim(htmlentities($_POST['password2NewUser'], ENT_QUOTES));
            $address = trim(htmlentities($_POST['addressNewUser'], ENT_QUOTES));
            $country = trim(htmlentities($_POST['countryNewUser'], ENT_QUOTES));
            $phoneNumber = trim(htmlentities($_POST['telephonNewUser'], ENT_QUOTES));
            $role = trim(htmlentities($_POST['roleNewUser'], ENT_QUOTES));

            if (isset($_POST['checkboxNewUser'])) { // No se valida con el validador
                $active = true;
            } else {
                $active = false;
            }

            Connection::open_connection();
            $validator = new NewUserValidator($userName, $firstName, $lastName, $email, $password1, $password2, 
                    $address, $country, $phoneNumber, $role, Connection::get_connection());
            
            if ($validator->valid_form()) {
                $objectUser = new UserModel(0, $validator->get_user_name(), $validator->get_first_name(), $validator->get_last_name(), 
                        $validator->get_email(), password_hash($validator->get_password(), PASSWORD_DEFAULT), $validator->get_address(), 
                        $validator->get_country(), $validator->get_phone_number(), $validator->get_role(), $active, 0, 0, 0);

                $result = UserDAO::insert_user(Connection::get_connection(), $objectUser);

                if ($result) {
                    Redirection::redirect(USERS_SEO_URL);          
                } else {
                    ?>
                    <script>
                        alert('Se ha producido un error al intentar crear el usuario.');                
                        window.location.href='<?php echo USERS_SEO_URL; ?>';
                    </script>
                    <?php
                }
            }
            // Aunq no se llegue aquí por el header, cuando se 
            // redirige a otra pagina distinta, php cierra todas las conexiones
            Connection::close_connection();
        }
        
        $data['pageTitle'] = 'Registrar usuario | Fiction Planet';
        $data['roleArray'] = $roleArray;
        
        if (!empty($validator)) {
            $data['validator'] = $validator;
        }
        
        $this->view->render($this, 'create_user', $data);
    }
    
    public function update() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['u']) {
            if (isset($_POST['action']) && $_POST['action'] === 'submitEditUser') {
                if (isset($_POST['idUser']) && isset($_POST['userNameEditProfile']) && isset($_POST['firstNameEditProfile']) && 
                    isset($_POST['lastNameEditProfile']) && isset($_POST['emailEditProfile']) && isset($_POST['addressEditProfile']) && 
                    isset($_POST['countryEditProfile']) && isset($_POST['newPassword'])) {

                    $idEditUser = trim(htmlentities($_POST['idUser'], ENT_QUOTES));
                    $userName = trim(htmlentities($_POST['userNameEditProfile'], ENT_QUOTES));
                    $firstName = trim(htmlentities($_POST['firstNameEditProfile'], ENT_QUOTES));
                    $lastName = trim(htmlentities($_POST['lastNameEditProfile'], ENT_QUOTES));
                    $email = trim(htmlentities($_POST['emailEditProfile'], ENT_QUOTES));
                    $address = trim(htmlentities($_POST['addressEditProfile'], ENT_QUOTES));
                    $country = trim(htmlentities($_POST['countryEditProfile'], ENT_QUOTES));
                    $newPassword = trim(htmlentities($_POST['newPassword'], ENT_QUOTES));
                    $role = trim(htmlentities($_POST['roleIdEditUser'], ENT_QUOTES));
                    $status = trim(htmlentities($_POST['statusEditUser'], ENT_QUOTES));

                    Connection::open_connection();    
                    $user = UserDAO::get_user_by_id(Connection::get_connection(), $idEditUser);

                    if ($user && $user->get_role() == ROOT && $_SESSION['role']->get_id() != ROOT) {
                        Connection::close_connection();
                        echo json_encode(['error' => 'No autorizado']);
                        exit;
                    }

                    if ($role == ROOT && $_SESSION['role']->get_id() != ROOT) {
                        Connection::close_connection();
                        echo json_encode(['error' => 'No puedes asignar el rol Root']);
                        exit;
                    }

                    $oldUserName = $user->get_user_name();

                    $user->set_user_name($userName);
                    $user->set_first_name($firstName);
                    $user->set_last_name($lastName);
                    $user->set_email($email);
                    $user->set_address($address);
                    $user->set_country($country);
                    $user->set_role($role);
                    $user->set_active($status);

                    if ($_POST['newPassword'] != '') {
                        $user->set_password(password_hash($newPassword, PASSWORD_DEFAULT));
                    }

                    if (isset($_POST['telephonEditProfile']) && $_POST['telephonEditProfile'] != '') {
                        $user->set_phone_number(trim(htmlentities($_POST['telephonEditProfile'], ENT_QUOTES)));
                    } 

                    if ($userName != $oldUserName && UserDAO::is_user_name_exist(Connection::get_connection(), $userName)) {
                        $result = ['userName_ok' => false, 'success' => false];
                    } else {
                        $resultSql = UserDAO::update_user(Connection::get_connection(), $user);
                        if ($resultSql == true) {
                            if ($_SESSION['idUser'] == $user->get_id()) { // Si se edita el usuario logeado
                                Session::change_session_data($user, $_SESSION['idUser'], $user->get_user_name(), 
                                        $_SESSION['role'], $_SESSION['permissions']);
                            }
                            $result = ['userName_ok' => true, 'success' => true];
                        } else {
                            $result = ['userName_ok' => true, 'success' => false];
                        }
                    }
                    Connection::close_connection();

                    $response = json_encode($result);

                    echo $response;
                }
            }   
        }
        exit;  
    }
    
    public function delete() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['d']) {
            if (isset($_POST['action']) && $_POST['action'] === 'deleteUser' && isset($_POST['idUser'])) {
                Connection::open_connection();
                $idUser = trim(htmlentities($_POST['idUser'], ENT_QUOTES));
                $user = UserDAO::get_user_by_id(Connection::get_connection(), $idUser);

                if ($user && $user->get_role() == ROOT) {
                    Connection::close_connection();
                    echo 0;
                    exit;
                }

                $response = UserDAO::delete_user(Connection::get_connection(), $user);
                Connection::close_connection();

                echo $response;     
            }
        }
        exit;
    }
    
    public function profile($params) {
        if (empty($params)) {
            Redirection::redirect(BASE_URL);
        }
        
        $arrParams = explode(",", $params);
        $currentPageImage = 1;
        $currentPagePost = 1;
        
        Connection::open_connection();
        $user = UserDAO::get_user_by_user_name(Connection::get_connection(), $arrParams[0]); //arrParams[0] -> username
           
        if ($user != null) {
            $data['pageTitle'] = $user->get_user_name() . " | Fiction Planet";
            $data['user'] = $user;
            
            if (!$user->is_active()) { // Si el usuario esta inactivo
                $this->view->render($this, "profile_inactive", $data);
            } else { // Si el usuario esta activo
                $userRole = RoleDAO::get_role_by_id(Connection::get_connection(), $user->get_role());
                $numPosts = PostDAO::get_number_of_posts_by_author_id(Connection::get_connection(), $user->get_id());
                $numVisiblePosts = PostDAO::get_number_of_visible_posts_by_author_id(Connection::get_connection(), $user->get_id());
                $numNotVisiblePosts = PostDAO::get_number_of_not_visible_posts_by_author_id(Connection::get_connection(), $user->get_id());
                $numVisibleImages = ImageGalleryDAO::get_number_of_visible_images_by_author_id(Connection::get_connection(), $user->get_id());
                
                $data['userRole'] = $userRole;
                $data['numPosts'] = $numPosts;
                $data['numVisiblePosts'] = $numVisiblePosts;
                $data['numNotVisiblePosts'] = $numNotVisiblePosts;
                
                $data['imagesPerPage'] = $this->imagesPerPage;
                $data['maxLinksPager'] = $this->maxLinksPager;
                $data['numVisibleImages'] = $numVisibleImages;
                
                if (!empty($arrParams[1])) { // arrParams[1] -> modulo (posts, gallery...)
                    if ($arrParams[1] === GALLERY) {
                        if (!empty($arrParams[2]) && $arrParams[2] === 'page') {
                            if (!empty($arrParams[3])) {
                                $totalPages = ceil($numVisibleImages / $this->imagesPerPage);

                                if ($arrParams[3] > 0 && $arrParams[3] <= $totalPages) {
                                     $currentPageImage = $arrParams[3];
                                } else {
                                     $currentPageImage = 1;
                                }
                            }
                        }
                    }
                }
                
                $firstImage = ($currentPageImage - 1) * $this->imagesPerPage;
                $imageArray = ImageGalleryDAO::get_visible_images_by_author_id(Connection::get_connection(), $user->get_id(), $firstImage, $this->imagesPerPage);
                if (is_null($imageArray)) $imageArray = array();
                
                $data['currentPageImage'] = $currentPageImage;
                $data['imageArray'] = $imageArray;
                
                //$currentPagePost = 1;
                    
                if (!empty($arrParams[1])) { // arrParams[1] -> modulo (posts, gallery...)
                    if ($arrParams[1] === POSTS) {
                        if (!empty($arrParams[2]) && $arrParams[2] === 'page') { // arrParm[2] -> accion
                            if (!empty($arrParams[3])) { // arrParams[3] -> numero de pagina
                                $totalPages = ceil($numVisiblePosts / $this->postsPerPage);

                                if ($arrParams[3] > 0 && $arrParams[3] <= $totalPages) {
                                     $currentPagePost = $arrParams[3];
                                } else {
                                     $currentPagePost = 1;
                                }
                            }
                        }
                    } 
                }    

                $firstPost = ($currentPagePost - 1) * $this->postsPerPage;
                $postArray = PostDAO::get_visible_posts_by_author_id(Connection::get_connection(), $user->get_id(), $firstPost, $this->postsPerPage);
                if (is_null($postArray)) $postArray = array();

                $data['postsPerPage'] = $this->postsPerPage;
                $data['maxLinksPager'] = $this->maxLinksPager;
                $data['currentPagePost'] = $currentPagePost;
                $data['postArray'] = $postArray;
                
                // Si el perfil es del usuario logeado
                if (Session::is_started() && $_SESSION['idUser'] === $user->get_id()) {
                    $this->view->render($this, "profile", $data); 
                } else { // Si el usuario esta logeado pero no es su perfil, o no esta logeado
                    $this->view->render($this, "profile_not_logged_in", $data);
                }
            }
        } else {
            error_log('Error DAO-Database: get_user_by_user_name" - profile');
            Redirection::redirect(BASE_URL);
        }
        Connection::close_connection();
    }
        
    public function get_data() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['r']) {
            
            if (isset($_POST['action']) && $_POST['action'] === 'getUserData' && isset($_POST['idUser'])) {
                Connection::open_connection();
                $user = UserDAO::get_user_by_id(Connection::get_connection(), $_POST['idUser']);

                if ($user !== null) {
                    if ($user->is_active() == 1) {
                        $active = 'Usuario activo';
                    } else {
                        $active = 'Usuario no activo';  
                    }

                    $role = RoleDAO::get_role_by_id(Connection::get_connection(), $user->get_role());

                    $result = ['succes' => true, 'userData' => 
                        ['active' => html_entity_decode($user->is_active(), ENT_QUOTES, 'UTF-8'),
                        'idUser' => $user->get_id(),
                        'userName' => html_entity_decode($user->get_user_name(), ENT_QUOTES, 'UTF-8'),
                        'firstName' => html_entity_decode($user->get_first_name(), ENT_QUOTES, 'UTF-8'),
                        'lastName' => html_entity_decode($user->get_last_name(), ENT_QUOTES, 'UTF-8'),
                        'email' => html_entity_decode($user->get_email(), ENT_QUOTES, 'UTF-8'),
                        'role' => html_entity_decode($role->get_sp_name(), ENT_QUOTES, 'UTF-8'),
                        'role_id' => html_entity_decode($role->get_id(), ENT_QUOTES, 'UTF-8'),
                        'address' => html_entity_decode($user->get_address(), ENT_QUOTES, 'UTF-8'),
                        'country' => html_entity_decode($user->get_country(), ENT_QUOTES, 'UTF-8'),
                        'phoneNumber' => $user->get_phone_number()]];
                } else {
                    $result = ['succes' => false, 'userData' => null];
                }

                Connection::close_connection();

                $response = json_encode($result);

                echo $response;
            }
        }
        exit;
    }
    
    public function users_data_table_load() {
        if (Session::is_started() && $_SESSION['permissions'][MDL_USERS]['r']) {
            
            if (isset($_POST['action']) && $_POST['action'] === 'userDataTableLoad') {
                $usersDataTable = array();

                Connection::open_connection();
                $userArray = UserDAO::get_all_user(Connection::get_connection());

                if (!is_null($userArray)) {
                    $canManageUsers = $_SESSION['permissions'][MDL_USERS]['u'] 
                        || $_SESSION['permissions'][MDL_USERS]['d'];
                    
                    for ($i = 0; $i < count($userArray); $i++) {
                        $role = RoleDAO::get_role_by_id(Connection::get_connection(), $userArray[$i]->get_role());

                        $viewBtn = '';
                        $editBtn = '';
                        $removeBtn = '';

                        if ($_SESSION['permissions'][MDL_USERS]['r']) {
                            $viewBtn = '<button type="button" class="btn btn-info btn-sm gmd-1" name="viewUserBtn" id="viewUserBtn" data-iduser="' . 
                                $userArray[$i]->get_id() . '" title="Ver"><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;';
                        } else {
                            $viewBtn = '<button type="button" class="btn btn-info btn-sm" disabled><i class="fa fa-eye fa-lg" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_USERS]['u'] && $_SESSION['idUser'] != $userArray[$i]->get_id() && $role->get_id() != ROOT) {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm gmd-1" name="updateUserBtn" id="updateUserBtn" data-iduser="' . 
                                $userArray[$i]->get_id() . '" title="Editar"><i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;';
                        } else {
                            $editBtn = '<button type="button" class="btn btn-warning btn-sm" disabled><i class="fa fa-pencil fa-lg" style="color:white" aria-hidden="true"></i></button>&nbsp;&nbsp;&nbsp;';
                        }

                        if ($_SESSION['permissions'][MDL_USERS]['d'] && $_SESSION['idUser'] != $userArray[$i]->get_id() && $role->get_id() != ROOT) {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm gmd-1" name="removeUserBtn" id="removeUserBtn" data-iduser="' . 
                                $userArray[$i]->get_id() . '" data-username="' . $userArray[$i]->get_user_name() . '" title="Eliminar">'
                                . '<i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        } else {
                            $removeBtn = '<button type="button" class="btn btn-danger btn-sm" disabled><i class="fa fa-trash fa-lg" style="color:white" aria-hidden="true"></i></button>';
                        }

                        if ($userArray[$i]->is_active() == 1) {
                            $status = '<td><span class="badge badge-pill badge-success">Activo</span></td>';
                        } else {
                            $status = '<td><span class="badge badge-pill badge-danger">Inactivo</span></td>';
                        }

                        $usersDataTable[$i]['actions'] = $viewBtn . $editBtn . $removeBtn;
                        $usersDataTable[$i]['index'] = $i + 1;
                        $usersDataTable[$i]['id'] = $userArray[$i]->get_id();
                        $usersDataTable[$i]['user_name'] = $userArray[$i]->get_user_name();
                        $usersDataTable[$i]['first_name'] = $userArray[$i]->get_first_name();
                        $usersDataTable[$i]['last_name'] = $userArray[$i]->get_last_name();
                        $usersDataTable[$i]['email'] = $canManageUsers ? $userArray[$i]->get_email() : '-';
                        $usersDataTable[$i]['password'] = '*****';
                        $usersDataTable[$i]['address'] = $canManageUsers ? $userArray[$i]->get_address() : '-';
                        $usersDataTable[$i]['country'] = $canManageUsers ? $userArray[$i]->get_country() : '-';
                        $usersDataTable[$i]['phone_number'] = $canManageUsers ? $userArray[$i]->get_phone_number() : '-';
                        $usersDataTable[$i]['role'] = $role->get_sp_name();
                        $usersDataTable[$i]['reg_date'] = $userArray[$i]->get_reg_date();
                        $usersDataTable[$i]['last_update_date'] = $userArray[$i]->get_last_update_date();
                        $usersDataTable[$i]['last_access_date'] = $userArray[$i]->get_last_access_date();
                        $usersDataTable[$i]['status'] = $status;
                    }
                }
                Connection::close_connection();

                $response = json_encode($usersDataTable, JSON_UNESCAPED_UNICODE);

                echo $response;
            }
        }
        exit;
    }
                
    public function check_current_password() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'checkCurrentPassword') {
                $currentPassword = trim(htmlentities($_POST['currentPassword'], ENT_QUOTES));

                Connection::open_connection();
                $user = UserDAO::get_user_by_id(Connection::get_connection(), $_SESSION['idUser']);
                Connection::close_connection();

                $response = password_verify($currentPassword, $user->get_password());

                echo $response; 
            }
        }
        exit;
    }
    
    public function submit_change_password() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'submitChangePassword') {
                if (isset($_POST['newPassword']) && isset($_POST['currentPassword'])) {
                    $currentPassword = trim(htmlentities($_POST['currentPassword'], ENT_QUOTES));
                    $newPassword = trim(htmlentities($_POST['newPassword'], ENT_QUOTES));

                    Connection::open_connection();
                    $user = UserDAO::get_user_by_id(Connection::get_connection(), $_SESSION['idUser']);

                    if (password_verify($currentPassword, $user->get_password())) {
                        $user->set_password(password_hash($newPassword, PASSWORD_DEFAULT));
                        $resultSql = UserDAO::change_password(Connection::get_connection(), $user);
                        if ($resultSql == true) {
                            $result = ['password_ok' => true, 'success' => true];
                        } else {
                            $result = ['password_ok' => true, 'success' => false];
                        }
                    } else {
                        $result = ['password_ok' => false, 'success' => false];
                    }
                    Connection::close_connection();

                    $response = json_encode($result);

                    echo $response;
                    exit;
                }
            }
        }
        exit;
    }
    
    public function get_logged_in_user_data() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'getLoggedInUserData') {
                Connection::open_connection();
                $user = UserDAO::get_user_by_id(Connection::get_connection(), $_SESSION['idUser']);
                Connection::close_connection();

                if ($user !== null) {
                    $result = ['succes' => true, 'userData' => 
                        ['userName' => html_entity_decode($user->get_user_name(), ENT_QUOTES, 'UTF-8'),
                        'firstName' => html_entity_decode($user->get_first_name(), ENT_QUOTES, 'UTF-8'),
                        'lastName' => html_entity_decode($user->get_last_name(), ENT_QUOTES, 'UTF-8'),
                        'email' => html_entity_decode($user->get_email(), ENT_QUOTES, 'UTF-8'),
                        'address' => html_entity_decode($user->get_address(), ENT_QUOTES, 'UTF-8'),
                        'country' => html_entity_decode($user->get_country(), ENT_QUOTES, 'UTF-8'),
                        'phoneNumber' => $user->get_phone_number()]];
                } else {
                    $result = ['succes' => false, 'userData' => null];
                }

                $response = json_encode($result);

                echo $response; 
            }
        }
        exit;
    }
    
    public function check_user_name() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'checkUserName') {
                $userName = trim(htmlentities($_POST['userName'], ENT_QUOTES));

                Connection::open_connection();
                $response = UserDAO::is_user_name_exist(Connection::get_connection(), $userName);
                Connection::close_connection();

                echo $response;  
            }
        }
        exit;
    }
    
    public function check_email() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'checkEmail') {
                $email = trim(htmlentities($_POST['email'], ENT_QUOTES));

                Connection::open_connection();
                $response = UserDAO::is_email_exist(Connection::get_connection(), $email);
                Connection::close_connection();

                echo $response;  
            }
        }
        exit;
    }
    
    public function submit_edit_profile() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'submitEditProfile') {
                if (isset($_POST['userNameEditProfile']) && isset($_POST['firstNameEditProfile']) && isset($_POST['lastNameEditProfile']) && isset($_POST['emailEditProfile']) 
                        && isset($_POST['addressEditProfile']) && isset($_POST['countryEditProfile'])) {
                    
                    $userName = trim(htmlentities($_POST['userNameEditProfile'], ENT_QUOTES));
                    $firstName = trim(htmlentities($_POST['firstNameEditProfile'], ENT_QUOTES));
                    $lastName = trim(htmlentities($_POST['lastNameEditProfile'], ENT_QUOTES));
                    $email = trim(htmlentities($_POST['emailEditProfile'], ENT_QUOTES));
                    $address = trim(htmlentities($_POST['addressEditProfile'], ENT_QUOTES));
                    $country = trim(htmlentities($_POST['countryEditProfile'], ENT_QUOTES));

                    Connection::open_connection();    
                    $user = UserDAO::get_user_by_id(Connection::get_connection(), $_SESSION['idUser']);

                    $oldUserName = $user->get_user_name();

                    $user->set_user_name($userName);
                    $user->set_first_name($firstName);
                    $user->set_last_name($lastName);
                    $user->set_email($email);
                    $user->set_address($address);
                    $user->set_country($country);

                    if (isset($_POST['telephonEditProfile']) && $_POST['telephonEditProfile'] != '') {
                        $user->set_phone_number(trim(htmlentities($_POST['telephonEditProfile'], ENT_QUOTES)));
                    } 

                    if ($userName != $oldUserName && UserDAO::is_user_name_exist(Connection::get_connection(), $userName)) {
                        $result = ['userName_ok' => false, 'success' => false];
                    } else {
                        $resultSql = UserDAO::update_user(Connection::get_connection(), $user);
                        if ($resultSql == true) {
                            Session::change_session_data($user, $_SESSION['idUser'], $user->get_user_name(), 
                                    $_SESSION['role'], $_SESSION['permissions']);
                            $result = ['userName_ok' => true, 'success' => true];
                        } else {
                            $result = ['userName_ok' => true, 'success' => false];
                        }
                    }
                    Connection::close_connection();

                    $response = json_encode($result);

                    echo $response;
                }
            }
        }
        exit;
    }
    
    public function user_contacts_table_load() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'userContactsLoad') {
                $userContactsTable = array();
                
                Connection::open_connection();
                $contactObjectsArray = ContactDAO::get_all_contact_by_user_id(Connection::get_connection(), $_SESSION['idUser']);
                
                for ($i = 0; $i < count($contactObjectsArray); $i++) {
                    $user = UserDAO::get_user_by_id(Connection::get_connection(), $contactObjectsArray[$i]->get_contact_id());
                    $userName = $user->get_user_name();
                    
                    $userContactsTable[$i]['user_name'] = '<img src="' . IMAGES_URL . 'f2.png" class="avatar img-circle img-thumbnail '
                        . 'mr-2" alt="avatar" style="border:0;"><a href="/users/profile/"' . $userName . '>' . $userName . '</a>';
                    $userContactsTable[$i]['actions'] = '<a href="/users/profile/' . $userName . '"><button type="button" class="btn btn-secondary btn-sm gmd-1">'
                        . 'Ver perfil&nbsp; <i class="fa fa-chevron-right" aria-hidden="true"></i></button></a>';
                }

                Connection::close_connection();

                $response = json_encode($userContactsTable, JSON_UNESCAPED_UNICODE);

                echo $response;
            }
        }
        exit;
    }
    
    public function all_users_table_load() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'allUsersTableLoad') {
                $allUserTable = array();
                
                Connection::open_connection();
                $allUsers = UserDAO::get_all_active_user_other_than(Connection::get_connection(), $_SESSION['idUser']); // Tienen que ser los activos
                
                if (!is_null($allUsers)) {
                    for ($i = 0; $i < count($allUsers); $i++) {
                        $allUserTable[$i]['user_name'] = '<img src="' . IMAGES_URL . 'f2.png" class="avatar img-circle img-thumbnail '
                            . 'mr-2" alt="avatar" style="border:0;"><a href="/users/profile/"' . $allUsers[$i]->get_user_name() . '>' . $allUsers[$i]->get_user_name() . '</a>';
                        if (!ContactDAO::is_contact_exist(Connection::get_connection(), $_SESSION['idUser'], $allUsers[$i]->get_id())) {
                            if (FriendRequestsDAO::is_friend_request_send(Connection::get_connection(), $allUsers[$i]->get_id(), $_SESSION['idUser']) 
                                    || FriendRequestsDAO::is_friend_request_send(Connection::get_connection(), $_SESSION['idUser'], $allUsers[$i]->get_id())) {
                                $allUserTable[$i]['actions'] = '<span class="badge badge-pill badge-secondary mb-1">Solicitud en espera</span>&nbsp;<a href="/users/profile/' 
                                    . $allUsers[$i]->get_user_name() . '"><button type="button" class="btn btn-secondary btn-sm gmd-1">'
                                    . 'Ver perfil&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button></a>';
                            } else {
                                $allUserTable[$i]['actions'] = '<button type="button" class="addContactBtn btn btn-primary btn-sm gmd-1" id="addContactBtn_' . $allUsers[$i]->get_id() 
                                    . '" data-touserid="' . $allUsers[$i]->get_id() . '">Añadir</button>&nbsp;<a href="/users/profile/' 
                                    . $allUsers[$i]->get_user_name() . '"><button type="button" class="btn btn-secondary btn-sm gmd-1">'
                                    . 'Ver perfil&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button></a>';
                            }
                        } else {
                            $allUserTable[$i]['actions'] = '<a href="/users/profile/' . $allUsers[$i]->get_user_name() . '"><button type="button" class="btn btn-secondary btn-sm gmd-1">'
                                . 'Ver perfil&nbsp;<i class="fa fa-chevron-right" aria-hidden="true"></i></button></a>';
                        }
                    } 
                }
                
                Connection::close_connection();

                $response = json_encode($allUserTable, JSON_UNESCAPED_UNICODE);

                echo $response;
            }
        }
    }
    
    public function friend_requests_table_load() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'friendRequestsTableLoad') {
                $friendRequestTable = array(); 
                
                Connection::open_connection();
                $frndRequestObjectsArray = FriendRequestsDAO::get_friend_request_not_answered_by_to_user_id(Connection::get_connection(), $_SESSION['idUser']);
                               
                for ($i = 0; $i < count($frndRequestObjectsArray); $i++) {
                    $user = UserDAO::get_user_by_id(Connection::get_connection(), $frndRequestObjectsArray[$i]->get_from_user_id()); 
                    $request = $frndRequestObjectsArray[$i];
                    
                    $friendRequestTable[$i]['user_name'] = '<img src="' . IMAGES_URL . 'f2.png" class="avatar img-circle img-thumbnail '
                            . 'mr-2" alt="avatar" style="border:0;"><a href="/users/profile/"' . $user->get_user_name() . '>' . $user->get_user_name() . '</a>';
                    $friendRequestTable[$i]['actions'] = '<button type="button" class="rejectRequestBtn btn btn-danger btn-sm gmd-1" id="rejectRequestBtn_' . $request->get_id() . '" '
                            . 'data-fromuserid="' . $user->get_id() . '" data-frndRequestid ="' . $request->get_id() . '">Eliminar</button>&nbsp;'
                            . '<button type="button" class="acceptRequestBtn btn btn-success btn-sm gmd-1" id="acceptRequestBtn_' . $request->get_id() . '" '
                            . 'data-fromuserid="' . $user->get_id() . '" data-frndRequestid ="' . $request->get_id() . '">Aceptar</button>';
                }

                Connection::close_connection();

                $response = json_encode($friendRequestTable, JSON_UNESCAPED_UNICODE);

                echo $response;
            }
        }
        exit;
    }
    
    public function accept_friend_request() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'acceptFriendRequest') {
                $frndRequestId = trim(htmlentities($_POST['frndRequestId'], ENT_QUOTES));
                $fromUserId = trim(htmlentities($_POST['fromUserId'], ENT_QUOTES));
                
                Connection::open_connection();
                $result = FriendRequestsDAO::answer_friend_request(Connection::get_connection(), $frndRequestId, 1);
                if ($result) {
                    $contactObject1 = new ContactModel(null, $_SESSION['idUser'], $fromUserId, null);
                    $contactObject2 = new ContactModel(null, $fromUserId, $_SESSION['idUser'], null);
                    /*if (ContactDAO::insert_contact(Connection::get_connection(), $contactObject1)) {
                        if (ContactDAO::insert_contact(Connection::get_connection(), $contactObject2)) {
                            $result = true;
                        } else {
                            $result = false;
                            //--ContactDAO::detele(contactObject1);
                            //ContactDAO::delete_contact(Connection::get_connection(), $id)
                        }
                    }*/
                    ContactDAO::insert_contact(Connection::get_connection(), $contactObject1);
                    ContactDAO::insert_contact(Connection::get_connection(), $contactObject2);
                    $result = true;
                } else {
                    $result = false;
                }
                Connection::close_connection();
            }

            echo $result;
        }
        exit;
    }
    
        public function reject_friend_request() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'rejectFriendRequest') {
                $frndRequestId = trim(htmlentities($_POST['frndRequestId'], ENT_QUOTES));
                $fromUserId = trim(htmlentities($_POST['fromUserId'], ENT_QUOTES));
                
                Connection::open_connection();
                $result = FriendRequestsDAO::answer_friend_request(Connection::get_connection(), $frndRequestId, 0);
                Connection::close_connection();
            }

            echo $result;
        }
        exit;
    }
    
    public function request_friendship() {
        if (Session::is_started()) {
            if (isset($_POST['action']) && $_POST['action'] === 'requestFriendship') {
                $toUserId = trim(htmlentities($_POST['toUserId'], ENT_QUOTES));
                $FriendRequestObject = new FriendRequestsModel(null, $_SESSION['idUser'], $toUserId, null, null, null, null);
                
                Connection::open_connection();
                $response = FriendRequestsDAO::insert_friend_request(Connection::get_connection(), $FriendRequestObject);
                Connection::close_connection();
                
                echo $response; 
            }
        }
        exit;
    }
    
}