    $(document).ready(function(){
    $('td').live('click', function() {
          
          var url = $(this).parent().attr("url");
          alert(url);    
         // $(location).attr('href',url);
           window.location.href = url;    
                 });

       
        /*
         Set the inner html of the table, tell the user to enter a search term to get started.
         We could place this anywhere in the document. I chose to place its
         in the table.
        */
        $('#result').html('<p style="padding:5px;color:black;">Enter a search term to start filtering.</p>');
        
        /* When the user enters a value such as "j" in the search box
         * we want to run the .get() function. */
        $('#searchData').keyup(function() {
             
            /* Get the value of the search input each time the keyup() method fires so we
             * can pass the value to our .get() method to retrieve the data from the database */
            var searchVal = $(this).val();

            /* If the searchVal var is NOT empty then check the database for possible results
             * else display message to user */
            if(searchVal !== '') {

                /* Fire the .get() method for and pass the searchVal data to the
                 * search-data.php file for retrieval */
                $.get('search-data.php?searchData='+searchVal, function(returnData) {
                    /* If the returnData is empty then display message to user
                     * else our returned data results in the table.  */
                    if (!returnData) {
                        $('#result').html('<p style="padding:5px;color:black;">Search term entered does not return any data.</p>');
                        $('#results').html(returnData);

                    } else {
                    

                        $('#results').html(returnData);
                        $('#results').css({"color":"black"});

                    }
                });
$('input.text').focus(function() {
    $('input.text').removeClass('onFocus'); /* remove focus state from all input elements */
    $(this).addClass('onFocus'); /* add focus state to currently clicked element */
    var currentId = $(this).attr('id');
    alert(currentId);
  });
               


           
            } else {

                $('#result').html('<p style="padding:5px;color:black">Enter a search term to start filtering.</p>');
            }

        });

    });
