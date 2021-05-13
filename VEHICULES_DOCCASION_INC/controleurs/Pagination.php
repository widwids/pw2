<?php

class Pagination{

    public static function afficherPages($nElements)
    {
        $html = "<div class='yu-pagination'>";
        $nPages = floor($nElements / 10) + 1;
        
        $html .= "<button> &#10094;&#10094; </button>";
        for($i = 0; $i < $nPages; $i++)
        {
            $html .= "<button>". ($i+1) ."</button>";
        }
        $html .= "<button> &#10095;&#10095; </button></div>";


        echo $html;

    }


}



?>