<!DOCTYPE html>
<html>
  <head>
    <title>LeeMail</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, minimal-ui">
    <link rel="stylesheet" href="app.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">    
      
  </head>

  <body>
    <div class="app-page" data-page="home">
      <div class="app-topbar">
        <div class="app-title" id="homeTitle">Contacts</div>
      </div>
      <div class="app-content" style="margin-bottom: 0;">
        <div class="app-section" id="contactList">
            
            <ul id="contacts">
              
            </ul>
            
        </div>
        <div class="app-section" style="background-color: transparent; border: none; margin-top: 0;">
            <div class="app-button" data-target="page2" id="newEmail"><p>Email New Contact</p></div>
            <div class="app-button" id="optionsButton"><p>Settings</p></div>

        </div>
        <div class="app-section" id="options">
            
            <p id="close">X</p>
            
            <div id="colorPickerContainer">
                <h2>Colour scheme:</h2>
                <ul id="colorPicker">
                    <li><div class="color" style="background-color: #109534;"></div></li>
                    <li><div class="color" style="background-color: #285ad7;"></div></li>
                    <li><div class="color" style="background-color: #d83d27;"></div></li>
                    <li><div class="color" style="background-color: black;"></div></li>
                    <li><div class="color" style="background-color: #f4960b;"></div></li>
                    <li><div class="color" style="background-color: #7a21de;"></div></li>
                    <li><div class="color" style="background-color: #c93686;"></div></li>

                </ul>
                <form method = "post" id="colorForm"><input type="hidden" name="color" id="colorInput"></form>   
                <div class="app-button" id="apply"><p>Apply</p></div>

            </div>
                
            <div class="app-button" id="clear"><p>Reset App</p></div>
            
        </div>
          
           <div id="clearConfirm" class="app-section">
                
                <p>Are you sure you want to reset your saved data and settings? This cannot be undone.</p>
                
                <div class="app-button" id="yes"><p>Yes</p></div>
                <div class="app-button" id="no"><p>No</p></div>

            </div>
          
          
      </div>
    </div>

    <div class="app-page" data-page="page2">
      <div class="app-topbar">
        <div class="app-button left" id="back" data-back data-autotitle></div>
        <div class="app-title" id="emailTitle">Send Email</div>
      </div>
      <div class="app-content">
            <div class="app-section">
                <form method="post" class="app-section" style="border: none !important;">
                    <input class="app-input" placeholder="To: " name="to" id="toEmail">        
                    <input class="app-input" placeholder="From: " name="from" id="fromEmail">
                    <input class="app-input" placeholder="Subject: " name="subject" id="subject">          
                    <textarea class="app-input" placeholder="Message:" name="message" style="border: none !important;" id="message"></textarea>     
                    <div class="app-button go green app-submit" id="send">Send</div>
                </form>

            </div>
            
          <div class="app-section" id="error"><p id="errorText"></p><div class='app-button' id='ok'>Okay</div></div>

          
      </div>
    </div>
      
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
      <script src="zepto.js"></script>
      <script src="app.min.js"></script>
    
        <script type="text/javascript">
        
        $emailArray = [];
        $retrievedArray = JSON.parse(localStorage.getItem("storedArray"));
        $fromArray = [];
        $savedFrom = JSON.parse(localStorage.getItem("savedFrom"));        
        $beforeLength = 0;
        $colorArray = [];
        $savedColor = JSON.parse(localStorage.getItem("savedColor"));
        $oldColor = $(".app-title").css("background-color");    

            
            
                    
        $isEmail = function(email) {
            $regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            return $regex.test(email);
        }

        $populateContacts = function(){ //shows and fills in the contact list with email addresses from emailArray

            if ($emailArray.length > 0){

                $("#contactList").css("display", "block");


                for ($i = 0; $i < $emailArray.length; $i++){

                    $("#contacts").append("<li><a>" + $emailArray[$i] + "</a></li>");

                }
            }
        }
        
        $refreshContacts = function(){ //if an additional email addess has been added to emailArray refreshes the page to show the updated list
            
            if ($emailArray.length > $beforeLength) {
                
                location.reload();
            }                
        }
        
        $onSuccess = function(){//function called in the event of a successful sending of an email. Fades out the success message, resets the form and repopulates the from with the last from address used, reactivates the send button
            
            $("#error").fadeOut();
            $("form").trigger("reset");
            if($savedFrom != null){
                        $("#fromEmail").val($savedFrom[0]);            
            };
            $("#send").addClass("go");
        }
        
        $applyColor = function($color){
           
                $(".app-topbar").css("background-color", $color);
                $(".app-title").css("background-color", $color);
                $(".app-button").css("background-color", $color);
                $(".app-section").css("border-color", $color);
                $("#contactList a").css({"color": $color, "border-color": $color});
                $(".app-input").css("border-bottom-color", $color);
                $("#send").css("background-color", $color);
                $("#error").css("border", $color + "5px solid");
                $("#ok").css("background-color", $color);
        }
        
        if ($retrievedArray != null){
        
            $emailArray = $retrievedArray;
        
        }
            
        if($savedColor != null){
             $applyColor($savedColor[0]);
         }
            
        $populateContacts();
            
        
              
        
          App.controller('home', function (page) {
             $(document).ready(function(e) {                    
                 
                 if($savedColor != null){
                     $applyColor($savedColor[0]);
                 }
                 
                $oldColor = $(".app-topbar").css("background-color");
                    
                $(".app-button").hover(
                
                function(){

                    $(this).css("opacity", "0.75");
                
                }, function(){
                    
                    $(this).css("opacity", "1");
                    
                });
                
                $("#newEmail").click(function(){
                    
                    if($savedFrom != null){
                        $("#fromEmail").val($savedFrom[0]);            
                    };
                    $beforeLength = $emailArray.length;
                    $("#error").hide();        


                });
                 
                 $("#optionsButton").click(function(){
                     
                     $("#options").css("display", "block");
                     
                 });
                 
                 $("#close").click(function(){
                     
                    $applyColor($oldColor);
                     $("#options").css("display", "none");
                     $("#clearConfirm").css("display", "none");
                     $("#apply").css("display", "none");
                     
                     
                 });
                 
                $(".color").hover(function(){
                     
                     $(this).css("border", "2.5px black solid");
                     
                 }, function(){
                     
                    $(this).css("border", "2.5px solid transparent");
                     
                 });
                 
                 $(".color").click(function(){                     
                     
                    $("#colorInput").val($(this).css("background-color"));
                    
                     $applyColor($(this).css("background-color"));
                     
                     if ($(this).css("background-color") != $oldColor){
                         
                            $("#apply").show();
                         
                         }else {
                             
                             $("#apply").hide();
                             
                         }
                     
                 })
                 
                 $("#apply").click(function(){
                     
                    if ($colorArray.length > 0){
                        
                        $colorArray.length = 0;
                    }
                     
                     $colorArray.push($("#colorInput").val());
                     
                     if(typeof(Storage) != undefined){
                            
                         localStorage.setItem("savedColor", JSON.stringify($colorArray));
                     }
                     
                     $oldColor = $(".app-title").css("background-color");
                    
                     location.reload();
                 })
                
                 $("#clear").click(function(){

                     $("#clearConfirm").css("display", "block");
                     
                 });
                 
                 $("#yes").click(function(){
                     
                     localStorage.clear();
                     location.reload();
                     
                 });
                 
                 $("#no").click(function(){

                    $("#clearConfirm").css("display", "none");
                 
                 }); 
                 
                 $("#contacts a").click(function(){
                     
                     App.load('page2');
                     if($savedFrom != null){
                        $("#fromEmail").val($savedFrom[0]);            
                    };
                     $("#error").hide();
                     $("#toEmail").val($(this).text());

                 });
                 
                
                             
             });
          
          });

          App.controller('page2', function (page) {
            $(document).ready(function(e) {   
              if($savedColor != null){
                     $applyColor($savedColor[0]);
                 }
                
                if($savedFrom != null){
                        $("#fromEmail").val($savedFrom[0]);            
                    };
                
                $(".app-button").hover(
                
                    function(){

                        $(this).css("opacity", "0.5");

                    }, function(){

                        $(this).css("opacity", "1");
                    
                });
                
                
                $("#send").click(function(){
                    
                                            
                        if($(this).hasClass("go")){

                        $message = "";

                        if($("#toEmail").val() == ""){

                            $message += "<p class='errorMessage'>Please enter an email address you would like to send a message to.</p><br>";

                        }
                    
                        if($("#toEmail").val() != "" && $isEmail($("#toEmail").val()) == false){
                            
                            $message += "<p class='errorMessage'>Please enter a valid email address to send a message to.</p><br>";
                            
                        }

                        if ($("#fromEmail").val() == ""){

                            $message += "<p class='errorMessage'>Please enter the email address you would like the message to be from.</p><br>";
                        }
                    
                        if($("#fromEmail").val() != "" && $isEmail($("#fromEmail").val()) == false){
                            
                            $message += "<p class='errorMessage'>Please enter a valid email address to send a message from.</p><br>";
                            
                        }

                        if ($("#subject").val() == ""){

                            $message += "<p class='errorMessage'>Please enter a subject for your message.</p><br>";
                        }

                        if ($("#message").val() == ""){

                            $message += "<p class='errorMessage'>Messages cannot be empty.</p>";

                        }

                        if ($message == ""){

                            $message = "<p class='errorMessage'>Message sent successfully!</p></div>";
                            $(this).removeClass("go"); //to prevent multiples of the same email being sent
                            setTimeout($onSuccess, 1500);


                        } else{
                            
                            $("#ok").show();
                            
                        }

                        $("#errorText").html($message);
                        $("#ok").css("background-color", $(".app-title").css("background-color"));
                        $("#error").show();


                        if($("#fromEmail").val() != "" && $isEmail($("#fromEmail").val()) == true){
                            
                            if ($fromArray.length > 0){
                                
                                $fromArray.length = 0;                            
                            }
                            
                            $fromArray.push($("#fromEmail").val());
                            
                            if(typeof(Storage) != "undefined"){
                                
                                localStorage.setItem("savedFrom", JSON.stringify($fromArray));
                                
                            }
                            
                        };


                        if($("#toEmail").val() != "" && $isEmail($("#toEmail").val()) == true && $.inArray($("#toEmail").val(), $emailArray) == -1){
                           
                            $emailArray.push($("#toEmail").val());

                            if(typeof(Storage) != "undefined"){

                                localStorage.setItem("storedArray", JSON.stringify($emailArray));

                            }
                        };
                    
                        
                    

                        $emailObject = {
                            to: $("#toEmail").val(), 
                            from: $("#fromEmail").val(),
                            subject: $("#subject").val(),
                            message: $("#message").val(),
                        };

                        $.ajax({
                                url: 'http://leemander-com.stackstaging.com/content/9-mobile-apps/emailClient/send.php',
                                method: 'post',
                                data: $emailObject,
                                success: function(){},
                                error: function(){alert("Error")}     
                            });
                        
                        
                           
                            
                        }

                    });
                
                    $("#ok").click(function(){
                        
                        $("#error").hide();
                        
                    });
                    

                    $("#back").click(function(){

                        $("#error").hide();
                        setTimeout($refreshContacts, 300); 

                    });
                
                });
            
            });
          
            

          try {
            App.restore();
          } catch (err) {
            App.load('home');
          }
        </script>
  </body>
</html>
