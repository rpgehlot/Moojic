    $(document).ready(function(){
		
                
                 
           $(document).on("click", "td", function(){ 
              var url = $(this).parent().attr("url");
    //          alert(url);    
              window.location.href = url;   
             });   
        
      
        $('#result').html('<p style="padding:5px;color:black;">Enter a search term to start filtering.</p>');
        
        $('#searchData').keyup(function() {
             
            var searchVal = $(this).val();
            if(searchVal !== '') {
               
                $.get('search-data.php?searchData='+searchVal, function(returnData) {
                   
                    if (!returnData) {
                        $('#results').html('<tr><td><p style="padding:5px;color:black;">Search term entered does not return any data.</p></td></tr>'); 
                        $('#result').html('');
                        

                    } else {
                    

                        $('#results').html(returnData);
                         $('#result').html('');
                       

                    }
                });
          
            } else {

                $('#result').html('<p style="padding:5px;color:black">Enter a search term to start filtering.</p>');
            }

        });

    });




     

