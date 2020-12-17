<?php
   
        $headers = "From: ".$_POST["from"];

        $result = array();
        
        $result["success"] = mail($_POST["to"], $_POST["subject"], $_POST["message"], $headers);

        if(array_key_exists("callback", $_GET)){
            
            $callback = $_GET['callback'];
            echo $callback.'('.json_encode($result).');';
            
        }

?>