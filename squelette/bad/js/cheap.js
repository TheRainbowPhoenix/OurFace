/**
 * @Author: uapv1701795
 * @Date:   2018-11-19T11:52:10+01:00
 * @Last modified by:   uapv1701795
 * @Last modified time: 2018-11-19T14:13:55+01:00
 */



function GetAction() {
  var gets = window.location.search.substring(1);
  var actions = gets.split('&');
  for (var i =0; i< actions.length; i++) {
    var param=actions[i].split('=');
    if (param[0]=='action') return param[1];
  }
  return false;
}

$( document ).ready(function() {
  var timeoutId;
  var hoverFetchDelay= 500;
  var elem;
  var html;
  // IF ON PC
  if ($(window).width() > 1100) {
    $('.account-small').hover(function() {
      if (!timeoutId) {
        if(this != elem) {
          $(elem).find(".floating-card").empty();
          elem = this;
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
              html = data;
              $(elem).find(".floating-card").html(html);
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
        } else {
          timeoutId = window.setTimeout(function() {
            $(elem).find(".floating-card").html(html);
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
