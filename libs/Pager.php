<?php
class Pager {
    
    private $url;
    private $currentPage; // Pagina actual en la paginacion    
    private $numItems; // Numero total de itemas a paginar
    private $itemsPerPages; // items o elementos por pagina
    private $maxLinks; // Maximo de links o paginas a mostrar en la paginacion
    private $totalPages; // Paginas totales
    private $firstItem; // Primer item de la pagina
    private $output;

    public function __construct($url, $num_items, $items_per_pages, $max_links, $current_page) {        
        $this->currentPage = $current_page; // Pagina actual en la paginacion
        $this->numItems = $num_items; // Numero total de itemas a paginar
        $this->itemsPerPages = $items_per_pages; // items o elementos por pagina
        $this->maxLinks = $max_links; // Maximo de links o paginas a mostrar en la paginacion
        $this->totalPages = ceil($num_items / $items_per_pages); // Paginas totales
        $this->firstItem = ($current_page - 1) * $items_per_pages; // Primer item de la pagina
        $this->url = $url;
            
        ob_start();
        ?>
        <?php if ($this->totalPages > 1): ?>
            <nav aria-label='paginacion'>
                <ul class='pagination paginationCustom justify-content-center rounded-lg'>
                    <li class='page-item <?php echo (($this->currentPage > 1) ? "gmd-1" : "gmd-0 disabled"); ?>'>
                        <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/1"; ?>' title='firstPage'>
                            <i class='fa fa-backward' aria-hidden='true'></i>
                        </a>
                    </li>
                    <li class='page-item <?php echo (($this->currentPage > 1) ? "gmd-1" : "gmd-0 disabled"); ?>'>
                        <?php $decrementPage = ((($this->currentPage - 1)) < 1 ? 1 : ($this->currentPage - 1)); ?>
                        <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/" . $decrementPage; ?>' tabindex='-1'>
                            <i class='fa fa-caret-left' aria-hidden='true'></i>
                        </a>
                    </li>
                    
                    <?php
                    $min = max(1, min($this->currentPage - floor($this->maxLinks / 2), $this->totalPages - $this->maxLinks)); // Desde
                    $max = max($this->maxLinks, min($this->currentPage + floor($this->maxLinks / 2), $this->totalPages)); // Hasta
                    ?>
                    
                    <?php if ($min != 1): ?>
                        <a class='page-link'><strong>...</strong></i></a>
                    <?php endif; ?> 
                        
                    <?php if($this->totalPages < $this->maxLinks): ?>
                        <?php for($i = 1; $i <= $this->totalPages; $i++): ?>
                            <li class='page-item gmd-1 <?php echo ($this->currentPage == $i ? "active" : ""); ?>'>
                                <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/" . $i; ?>'><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    <?php else: ?>
                        <?php for($i = $min; $i <= $max; $i++): ?>
                            <li class='page-item gmd-1 <?php echo ($this->currentPage == $i ? "active" : ""); ?>'>
                                <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/" . $i; ?>'><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    <?php endif; ?>
                                
                    <?php if ($max < $this->totalPages): ?>
                        <a class='page-link'><strong>...</strong></a>
                    <?php endif; ?>
                        
                    <li class='page-item <?php echo (($this->currentPage < $this->totalPages) ? "gmd-1" : "gmd-0 disabled"); ?>'>
                    <?php $increasePage = ((($this->currentPage + 1) <= $this->totalPages) ? ($this->currentPage + 1) : $this->totalPages); ?>
                        <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/" . $increasePage; ?>'>
                            <i class='fa fa-caret-right' aria-hidden='true'></i>
                        </a>
                    </li> 
                    <li class='page-item <?php echo (($this->currentPage < $this->totalPages) ? "gmd-1" : "gmd-0 disabled"); ?>'>
                        <a class='page-link page-link-ajax' href='<?php echo $this->url . "page/" . $this->totalPages; ?>' title='LastPage'>
                            <i class='fa fa-forward' aria-hidden='true'></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php 
            $this->output = ob_get_contents(); 
            ob_end_clean();
            ?>
        <?php else: ?>
        <?php $this->output = ""; ?>
        <?php endif; ?>
        <?php     
    }

    public function get_data_pager() {
        return $this->output;
    }
}
?>