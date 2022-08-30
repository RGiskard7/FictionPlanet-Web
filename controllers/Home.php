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
        session_start();
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
        
    }
    
    public function login() {
        
    }
    
}
