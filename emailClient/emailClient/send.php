<?php
   
    
    if($_POST){
        
        $headers = "From: ".$_POST["from"];

        mail($_POST["to"], $_POST["subject"], $_POST["message"], $headers);
    }
?>