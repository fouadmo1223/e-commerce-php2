<?php
    function createOtp(){
        $OTP="";
        for($i=0;$i< 6;$i++){
            $OTP .= rand(0, 9);
        }
        return $OTP;
    }
?>