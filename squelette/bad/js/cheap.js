$( document ).ready(function() {
  var timeoutId;
  var hoverFetchDelay= 500;
  var elem;
  $('.account-small').hover(function() {
    if(this != elem) $(elem).find(".floating-card").empty();
    elem = this;
    if (!timeoutId) {
        timeoutId = window.setTimeout(function() {
            timeoutId = null;
            $(elem).find(".floating-card").empty();
            var id = $(elem).data("user-id");
            $.ajax({
              method: "GET",
              url: "api.php/popup",
              data: {user_id: id},
              dataType: "html"
            }).done(function(data) {
              $(elem).find(".floating-card").html(data);
            });
            /*$.ajax({
              method: "GET",
              url: "api.php/users",
              data: {id: 2}
            }).done(function(data) {
              html = data;
                console.log(data);
            });*/
            //console.log(html);
       }, hoverFetchDelay);
    }
  }, function () {
    if (timeoutId) {
      $(elem).find(".floating-card").empty();
      window.clearTimeout(timeoutId);
      timeoutId = null;
    }
  });
});
/*
$('<div/>', {
    html: $('<h1/>', {
        html: title
    }).after(
        $('<div/>', {
            'text': content,
            'class': 'content'
        })
    )
}).appendTo('body');

<div><h1>some title</h1><div class="content">some content</div></div>

 */
