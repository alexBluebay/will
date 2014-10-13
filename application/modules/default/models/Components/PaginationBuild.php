<?php

class Default_Model_Components_PaginationBuild {
    
    public function doMath($nrLinks, $maxPePag = '10')
    {
        
        $currPage = (isset($_GET['pag']) && is_numeric($_GET['pag'])) ? $_GET['pag'] : 1;
        
        $nrPagini = ceil($nrLinks/$maxPePag);
       
        $offsetStart = ($currPage-1) * $maxPePag;
        
        return $offsetStart;
    }
    
    public function listPagination(){
        $rOffset = 4; 
        $i = $currPage-$rOffset;

        if($i<=0) {
            $i = 1;
            $rOffset = ($rOffset*2 - $_GET['pag']) + 1;
        }

        if( $_GET['pag'] > $nrPagini-$rOffset) {
            $i = $i - $rOffset + ($nrPagini - $_GET['pag']);
        }

        for($i; $i <= $currPage+$rOffset && $i<= $nrPagini; $i++){

        if($_GET['pag'] == $i) {
            $isSelected = 'border: solid 1px red;';
        } else {
            $isSelected = '';
        }
        $out .= '<a href="?pag='.$i.'"
           style="border-radius: 3px; border: solid 1px black; display: inline-block; padding: 5px; '.$isSelected.'">
            '.$i.'
        </a>';


        }
    }
    
}




