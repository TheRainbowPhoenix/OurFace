function GetAction() {
  var gets = window.location.search.substring(1);
  var actions = gets.split('&');
  for (var i =0; i< actions.length; i++) {
    var param=actions[i].split('=');
    console.log(actions[i]);
    if (param[0]=='action') return param[1];
  }
  return false;
}

$( document ).ready(function() {
  var timeoutId;
  var hoverFetchDelay= 500;
  var elem;
  // IF ON PC
  if ($(window).width() > 1100) {
    $('.account-small').hover(function() {
      if(this != elem) {
        $(elem).find(".floating-card").empty();
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
          }, hoverFetchDelay);
        }
      }
    }, function () {
      if (timeoutId) {
        $(elem).find(".floating-card").empty();
        window.clearTimeout(timeoutId);
        timeoutId = null;
      }
    });
  } else if ($(window).width() > 576) {
    //ON TABLET
  } else {
    $('.account-small').click(function() {
      if(this != elem) $(elem).find(".floating-card").empty();
      elem = this;
      var id = $(elem).data("user-id");
      $(location).attr('href','?action=BProfile&id='+id);
    });
    // ON PHONE
  }
  // Tabs icon
  var a = GetAction();
  console.log(a);
  switch (a) {
    case "listMessages":
      $('#home').addClass("selected");
      break;
    case "listUsers":
      $('#friends').addClass("selected");
      break;
    default:
  }


});
