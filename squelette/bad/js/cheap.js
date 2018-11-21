/**
 * @Author: uapv1701795
 * @Date:   2018-11-19T11:52:10+01:00
 * @Last modified by:   uapv1701795
 * @Last modified time: 2018-11-19T14:22:59+01:00
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

function loadMoar(fr, id) {
  var html;
  if(id<0) {
    $.ajax({
      method: "GET",
      async: false,
      url: "api.php/messages",
      data: {from: fr, html: '1'},
      dataType: "html"
    }).done(function(data) {
      html = data;
      $("#posts").append( data );
    });
  } else {
    $.ajax({
      method: "GET",
      url: "api.php/messages",
      data: {from: fr, user_id: id, html: '1'},
      dataType: "html"
    }).done(function(data) {
      html = data;
      $("#posts").append( data );
    });
  }
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
        html = null;
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
      $(location).attr('href','?action=profile&id='+id);
    });
    // ON PHONE
  }
  //Lazy load
  $('.lazy').Lazy({
        // your configuration goes here
        placeholder: 'images/gif/load.gif',
        scrollDirection: 'vertical',
        effect: 'fadeIn',
        visibleOnly: true,
        onError: function(element) {
            console.log('error loading ' + element.data('src'));
        }
    });
  //Lightbox
  $(document).on("click", '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
  });
  // Tabs icon
  var a = GetAction();
  switch (a) {
    case "home":
      $('#home').addClass("selected");
      break;
    case "listUsers":
      $('#friends').addClass("selected");
      break;
    default:
  }
  //If scrolled to bottom
  $(window).scroll(function() {
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(10, -1);
    }
  });

});
