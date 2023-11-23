<?php

class About_us extends Controller {
    private $pageTitle = 'Acerca de nosotros | Fiction Planet';
    
    public function about_us() {
        $data['pageTitle'] = $this->pageTitle;
        
        $this->view->render($this, "about_us", $data);
    }
    
}