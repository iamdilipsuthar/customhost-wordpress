jQuery(document).ready(function($){

  function load_events(){
    const CustomPosts = wp.api.collections.Posts.extend( {
      url: customhost.event_route,
    } );
    const eventPost = new CustomPosts();
    var event_temp = '';
    var filterPost = {
      data:{
        'filter':{
          'orderby':'title',
          'order':'asc'
        },
        'per_page':2
      }
    };
    eventPost.fetch(filterPost).then( ( events ) => {
      $.each(events,function(index,value){
        event_temp += "<h4>"+value.title.rendered+"</h4>";
      });
      $('#event_list').html(event_temp);
    });
  }
  load_events();
});
