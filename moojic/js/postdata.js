$(document).ready(function(){

           $('.req').click(function(){
            var id = $(this).attr('id');	
              
//            alert(id);
            
            
            function sendrequest(){
              
            	$.ajax({
                 
            	   type : "GET",
            	   url : "checkstatus.php?jukeboxid="+contactid+"&trackid="+id ,
            	   async : true,
            	   timeout: 35000,
            	   cache :false,

            	   success: function(data){
            	   	var json = eval('('+data+')');
            	   	if(json['msg']!=""){
//            	   		alert(json['msg']);
                                 $('#alert_placeholder').html('<div class="alert"><a class="close" data-dismiss="alert">×</a><span>'+json['msg']+'</span></div>');
            	   	}
            	   
            	   //	setTimeout('sendrequest',1000);
            	   //  alert(data);
                      },
            	   error: function(XMLHttpRequest,textStatus,errorThrown){
            	   	alert("error: "+textStatus+'('+errorThrown+')');
            	   	setTimeout('sendrequest',15000);
           	   }
           	   });


            }          
           
             sendrequest();
        



       


              });


             });
            

          














