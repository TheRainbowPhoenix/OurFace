/**
 * @Author: uapv1701795
 * @Date:   2018-11-19T11:52:10+01:00
 * @Last modified by:   uapv1701795
 * @Last modified time: 2018-11-21T13:47:14+01:00
 */

(function() {
 'use strict';
 if ('serviceWorker' in navigator) {
   navigator.serviceWorker.register('./service-worker.js').then(function() { console.log('Service Worker Registered'); });
 }
})();

function notify(text) {
  $("#notify").html('<div class="alert alert-dark" role="alert"><span>'+text+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
  window.setTimeout(function () {
      $("#notify>.alert").fadeTo(2000, 500).slideUp(1000, function () {
          $("#notify>.alert").slideUp(500);
      });
  }, 5000);
  //$("#notify").html('');
}

function doPost() {
  $("#notify").html('<div class="alert alert-dark" role="alert"><span>Succes  !</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
}

function GetAction() {
  var gets = window.location.search.substring(1);
  var actions = gets.split('&');
  for (var i =0; i< actions.length; i++) {
    var param=actions[i].split('=');
    if (param[0]=='action') return param[1];
  }
  return false;
}
function Get(val) {
  var gets = window.location.search.substring(1);
  var actions = gets.split('&');
  for (var i =0; i< actions.length; i++) {
    var param=actions[i].split('=');
    if (param[0]==val) return param[1];
  }
  return false;
}

var html;
function loadMoar(fr, id) {
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
      async: false,
      url: "api.php/messages",
      data: {from: fr, user_id: id, html: '1'},
      dataType: "html"
    }).done(function(data) {
      html = data;
      $("#posts").append( data );
    });
  }
  a();
}

$( document ).ready(function () {
  a();
  var refer = Get('id');
  //Post Action
  $("#postBtn").click(function(e) {
    if($('.form-control').val() != '') {
      e.preventDefault();
      $.ajax({
        type: "GET",
        url: "api.php/post",
        data: {
          status: $('.form-control').val(),
          refer: refer,
          access_token: $("#access_token").val()
        },
        success: function(result) {
          console.log(result);
          $('.form-control').val('');
          notify('Posted !');
        },
        error: function(result) {
          alert('error');
        }
      });
    } else {
      notify('No text profided');
    }
  });
  /*$("#postBtn").click( function() {
      doPost();
    }
  );*/
  //Lightbox
  $(document).on("click", '[data-toggle="lightbox"]', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
  });
  //draggable
  $("#root-row").sortable({
   handle: ".ui-resizable-handle",
   helper: 'clone',
  appendTo: document.body,
   cursor: "move",
   opacity: 0.5,
   start: function(event, ui) {
		$(this).css('height', '100vh');
		$(this).css('position', 'fixed');
	},
	stop: function(event, ui) {
    $(this).css('height', 'auto');
		$(this).css('position', 'inherit');
	}
});
});

var timeoutId;
var hoverFetchDelay= 500;
var elem;
var html;

var min;

function fmin() {
  var min = $(".post").data("id");
  $(".post").each(function (i, e) {
    var id = parseInt($(e).data("id"), 10);
    if(min>id) min=id;
  });
  return min;
}

function a() {
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
  /*$(window).scroll(function() {
    //console.log(fmin());
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(fmin(), -1);
    }
  });*/

}
