function make_grid_color(){

}

function next_page(page_no,url){

    // alert(url+(page_no+1));
 
     var req2 = $.ajax({
         type: "POST",
         url: url+(page_no+1),
         });
         
         req2.done(function (msg){
                     
 
             $("#grid").html(msg);
           //  make_grid_color(); 

         
         });
 
    
 }
 
 function previos_page(page_no,url){
 
     //alert(url+(page_no-1));
 
     var req2 = $.ajax({
         type: "POST",
         url: url+(page_no-1),
         });
         
         req2.done(function (msg){
                     
 
             $("#grid").html(msg);
             make_grid_color();
  
         
         });
 
 }
 $(document).ready(function (){
 
    
     if (document.getElementById('search_grid')) {
 
     let input = document.getElementById('search_grid');
 
     // Init a timeout variable to be used below
     let timeout = null;
     
     // Listen for keystroke events
     input.addEventListener('keyup', function (e) {
         // Clear the timeout if it has already been set.
         // This will prevent the previous task from executing
         // if it has been less than <MILLISECONDS>
         clearTimeout(timeout);
     
         // Make a new timeout set to go off in 1000ms (1 second)
         timeout = setTimeout(function () {
             console.log('Input Value:', input.value);
     
             //console.log(input.value );
 
 
             var url = $(input).attr('url');
             console.log(url);
             if(input.value == '' || input.value == ' ') url = url ;
             else {
                 url = removeURLParameter(url, 'pageno');
         
                 url = url + '&search=1&search_txt='+input.value;
             }
         debugger;;
             var req2 = $.ajax({
                 type: "GET",
                 url: url,
                 });
                 
                 req2.done(function (msg){
                             
         
                     $("#grid").html(msg);
                     make_grid_color();
  
                         console.log('data from db');
                 
                 });
             
         }, 1000);
     });
     }
 
  });
  
 function search_grid(ele,url){
 
     console.log(ele.value );
 
     if(ele.value == '' || ele.value == ' ') url = url +1 ;
     else {
         url = removeURLParameter(url, 'pageno');
 
         url = url + '&search=1&search_txt='+ele.value;
     }
 
    // if((ele.value).length > 2){
         // url = removeURLParameter(url, 'pageno');
 
         // url = url + '&search=1&search_txt='+ele.value;
       //  alert(url);
         
         var req2 = $.ajax({
             type: "GET",
             url: url,
             });
             
             req2.done(function (msg){
                         
     
                 $("#grid").html(msg);
                 make_grid_color();
 
             
             });
    // }else{
         // var req2 = $.ajax({
         //     type: "POST",
         //     url: url+1,
         //     });
             
         //     req2.done(function (msg){
                         
     
         //         $("#grid").html(msg);
                     
             
         //     });
    // }
  
 
 }
 
 
 
 function removeURLParameter(url, parameter) {
     //prefer to use l.search if you have a location/link object
     var urlparts = url.split('?');   
     if (urlparts.length >= 2) {
 
         var prefix = encodeURIComponent(parameter) + '=';
         var pars = urlparts[1].split(/[&;]/g);
 
         //reverse iteration as may be destructive
         for (var i = pars.length; i-- > 0;) {    
             //idiom for string.startsWith
             if (pars[i].lastIndexOf(prefix, 0) !== -1) {  
                 pars.splice(i, 1);
             }
         }
 
         return urlparts[0] + (pars.length > 0 ? '?' + pars.join('&') : '');
     }
     return url;
 }
 