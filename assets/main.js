jQuery(document).ready(function($){


  $.ajax({
    url:customhost.ajaxurl,
    method:'POST',
    data:{
      action:'my_ajax_action'
    },
    success:function(data){
      console.log(data);
    }
  });
});
