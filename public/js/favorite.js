$(document).on('click','.favorite_btn',function(e){
  e.stopPropagation();
  c_id = $(e.currentTarget).data('c_id');
  post_id = $(e.currentTarget).data('post_id');

    $.ajax({
        type: 'POST',
        url: '/Favorite/favorite.php',
        dataType: 'json',
        data: { c_id: c_id,
                post_id: post_id}
    }).done(function(data){
        location.reload();
    }).fail(function() {
      location.reload();
    });
});