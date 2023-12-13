<?php
    
    class Filter{
        public function getNumber($num){
            $num =  htmlspecialchars($num) ;
            $num = trim($num);
            $num = (float)$num;
            if(is_numeric($num)){
                return $num;
            }
            else{
                return 0;
            }
        }

        public function getString($string){
            $string =  htmlspecialchars($string) ;
            $string = trim($string);
           return $string;
        }
    }

?>