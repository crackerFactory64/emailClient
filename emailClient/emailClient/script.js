
$emailArray = [];
    $retrievedArray = JSON.parse(localStorage.getItem("storedArray"));
    $beforeLength = 0;



    if ($retrievedArray != null){

        $emailArray = $retrievedArray;


    }

    $populateContacts = function(){

        if ($emailArray.length >= 0){

            $("#contactList").css("display", "block");


            for ($i = 0; $i < $emailArray.length; $i++){

                $("#contacts").append("<li><a>" + $emailArray[$i] + "</a></li>");

            }
        }
    } 

    $populateContacts();

    $refreshContacts = function(){

        if ($emailArray.length > $beforeLength) {

            location.reload();
        }


    }


      App.controller('home', function (page) {
         $(document).ready(function(e) {                    

            $("#newEmail").hover(

            function(){

                $(this).css("box-shadow", "0px 0px 5px 3px white");

            }, function(){

                $(this).css("box-shadow", "none");

            });

            $("#newEmail").click(function(){
                $beforeLength = $emailArray.length;
                $("#error").hide();
            }); 

             $("#clear").click(function(){

                 localStorage.clear();
                 location.reload();

             });

             $("#contacts a").click(function(){

                 App.load('page2');
                 $("#error").hide();
                 $("#toEmail").val($(this).text());

             });






         });
      });

      App.controller('page2', function (page) {
        $(document).ready(function(e) {   


            $("#send").hover(

            function(){

                $(this).css("background-color", "#15C343");

            }, function(){

                $(this).css("background-color", "#109534");

            });

            $("#send").click(function(){

                $("form").submit(function(e){

                    e.preventDefault();

                });

                $("#error").show();


                if($("#toEmail").val() != ""){
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
