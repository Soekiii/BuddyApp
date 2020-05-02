$(document).ready(function() {
    $('#email').blur(function(e) {
        var value = $(this).val();
        liveEmailSearch(value);
             
    });
    });
    
    function liveEmailSearch(val){
     $.post('register.php',{'email': val}, function(data){
        window.alert(data);
      if(data == 'bestaat')
         $('#emailGebruik').html("<span style='color:green;'>Email is nog niet gebruikt</span>");
      else
         $('#emailGebruik').html("<span style='color:red;'>Email is niet beschikbaar</span>");
      
     }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?     
            alert(thrownError); //alert with HTTP error         
     });
    }