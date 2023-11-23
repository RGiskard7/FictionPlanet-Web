<?php

class Fault extends Controller {
    
    public function error_404() {
        $this->view->render($this, "404");
    }
    
}