<?php
require_once MODELS_PATH . "UserModel.php";
require_once MODELS_PATH . "PostModel.php";

require_once DAO_PATH . "UserDAO.php";
require_once DAO_PATH . "PostDAO.php";

require_once LIBS_PATH . "Pager.php";

class Home extends Controller {
    private $pageTitle = 'Fiction Planet';
    private $postsPerPage = 5;
    private $maxLinksPager = 7;
    
    /*public function __construct() {
        parent::__construct();
        session_start(); // Siempre se tiene que llamar a session_start para poder usar variables de sesion
    }*/
    
    public function home() {  
        $currentPage = 1;
        $firstPost = ($currentPage - 1) * $this->postsPerPage;

        Connection::open_connection();
        $numVisiblePosts = PostDAO::get_number_of_all_visible_posts(Connection::get_connection());
        $postArray = PostDAO::get_all_visible_posts_by_last_update_date_desc(Connection::get_connection(), $firstPost, $this->postsPerPage); // TABLA DE POSTS
        Connection::close_connection();
        
        if ($postArray === null) {
            $postArray = array();
        }
        
        $data['pageTitle'] = $this->pageTitle;
        $data['currentPage'] = $currentPage;
        $data['postsPerPage'] = $this->postsPerPage;
        $data['maxLinksPager'] = $this->maxLinksPager;
        $data['numVisiblePosts'] = $numVisiblePosts;
        //$data['numVisiblePosts'] = count($postArray);
        $data['postArray'] = $postArray;
        
        $this->view->render($this, "home", $data);
    }
    
    public function page($number) {
        Connection::open_connection();
        $numVisiblePosts = PostDAO::get_number_of_all_visible_posts(Connection::get_connection());
        $totalPages = ceil($numVisiblePosts / $this->postsPerPage);

        if ($number > 0 && $number <= $totalPages) {
            $currentPage = $number;
        } else {
            $currentPage = 1;
        }

        $firstPost = ($currentPage - 1) * $this->postsPerPage;
        $postArray = PostDAO::get_all_visible_posts_by_last_update_date_desc(Connection::get_connection(), $firstPost, $this->postsPerPage); // TABLA DE POSTS
        Connection::close_connection();

        if ($postArray === null) {
            $postArray = array();
        }
        
        $data['pageTitle'] = $this->pageTitle;
        $data['currentPage'] = $currentPage;
        $data['postsPerPage'] = $this->postsPerPage;
        $data['maxLinksPager'] = $this->maxLinksPager;
        $data['numVisiblePosts'] = $numVisiblePosts;
        $data['postArray'] = $postArray;
        
        $this->view->render($this, "home", $data);
    }
    
    public function search() {
        $postArray = null;
        $currentPage = 1;
        $firstPost = ($currentPage - 1) * $this->postsPerPage;
        
        Connection::open_connection();
        $numVisiblePosts = PostDAO::get_number_of_all_visible_posts(Connection::get_connection());

        if (isset($_GET['search'])) {
            $search = trim(htmlentities(addslashes($_GET['search']), ENT_QUOTES));
            
            //$postArray = PostDAO::search_post(Connection::get_connection(), $search, $firstPost, $this->postsPerPage);
            if (isset($_GET['searchBySelect'])) {
                switch($_GET['searchBySelect']) {
                    case "all":
                        //$postArray = PostDAO::advanced_search_post(Connection::get_connection(), $search, $search, $search, $search, $search, $firstPost, $this->postsPerPage);
                        $postArray = PostDAO::search_post(Connection::get_connection(), $search, $firstPost, $this->postsPerPage);
                        break;
                    case "title":
                        $postArray = PostDAO::advanced_search_post(Connection::get_connection(), $search, '', '', '', '', $firstPost, $this->postsPerPage);
                        break;
                    case "author":
                        $postArray = PostDAO::advanced_search_post(Connection::get_connection(), '', $search, '', '', '', $firstPost, $this->postsPerPage);
                        break;
                    case "introduction":
                        $postArray = PostDAO::advanced_search_post(Connection::get_connection(), '', '', $search, '', '', $firstPost, $this->postsPerPage);
                        break;
                    case "content":
                        $postArray = PostDAO::advanced_search_post(Connection::get_connection(), '', '', '', $search, '', $firstPost, $this->postsPerPage);
                        break;
                    case "date":
                        $postArray = PostDAO::advanced_search_post(Connection::get_connection(), '', '', '', '', $search, $firstPost, $this->postsPerPage);
                        break;
                    default:
                        //$postArray = PostDAO::advanced_search_post(Connection::get_connection(), $search, $search, $search, $search, $search, $firstPost, $this->postsPerPage);
                        $postArray = PostDAO::search_post(Connection::get_connection(), $search, $firstPost, $this->postsPerPage);
                }
            }  
        }
        Connection::close_connection();
        
        if ($postArray === null) {
            $postArray = array();
        }
        
        $data['pageTitle'] = $this->pageTitle;
        $data['currentPage'] = $currentPage;
        $data['postsPerPage'] = $this->postsPerPage;
        $data['maxLinksPager'] = $this->maxLinksPager;
        $data['numVisiblePosts'] = $numVisiblePosts;
        //$data['numVisiblePosts'] = count($postArray);
        $data['postArray'] = $postArray;
        
        $this->view->render($this, "home", $data);
    }
    
    public function login() {
        
    }
    
}