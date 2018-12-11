/**
 * @Author: uapv1701795
 * @Date:   2018-11-19T11:52:10+01:00
 * @Last modified by:   uapv1701795
 * @Last modified time: 2018-11-26T16:21:42+01:00
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

function updatePP(data) {
  $("#profile-picture").find(".avatar-image").attr('src','media/'+data);
  $('.SProfileCover').css('background-image','url(media/'+data+')');
}

function setPP(data) {
  if(data.name != undefined) {
    var src = data.src;
    var media_id = data.media_id;

    $.ajax({
      method: "GET",
      url: "api.php/setProfile",
      data: {avatar: media_id},
      dataType: "html"
    }).done(function(data) {
      notify("Succes !");
      updatePP(data);
    });
  }
}

function addThumbnail(data){
    $(".upload-area").removeClass('dragover');
    var len = $("#uploadfile div.thumbnail").length;
    var num = Number(len);
    num = num + 1;
    if(data.name != undefined) {
      $("#dragText").remove();
      var name = data.name;
      var src = data.src;
      var media_id = data.media_id;

      $("#uploadfile").append('<div id="thumbnail_'+num+'" class="thumbnail"></div>');
      $("#thumbnail_"+num).append('<img class="thumb-media" src="'+src+'" data-media="'+media_id+'" width="100%">');
      $("#thumbnail_"+num).append('<span class="thumb-remove">×<span>');
      thmb();
    }
}

function uploadMedia(formdata){
  if($("#thumbnail_1").length == 0) {
    $.ajax({
      url: 'api/upload.php',
      type: 'post',
      data: formdata,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response){
        addThumbnail(response);
      }
    });
  } else {
    notify("Media already added !");
  }
}

function newChatNotif(data) {
  console.log(data);
  if($("#chat-toggle").find(".new-chat").length == 0) {
    var ml = $.parseHTML(data);
    var text = $('.card-subtitle', ml).first().text();
    var user = $('.card-title a', ml).first().text();
    var pp = $('.avatar-image', ml).attr('src');

    $(".chat-posts").append(data);
    $("#chat-toggle").append('<span class="new-chat"></span>')
    $("#chat-toggle").prepend("<span class='ripple'></span>");
    $("#favicon").attr("href","images/favicon/of-n-16.png");
    Push.create(''+user, {
        body: ''+text,
        icon: pp, //'images/favicon/of-48.png',
        timeout: 8000,
        vibrate: [100, 100, 100],
        onClick: function() {
            //console.log(this);
        }
    });
  }
  $("#chat").addClass("unread");
  $(".ripple").addClass("rippleEffect");
  //console.log(newhtml);
}

function newNotif() {
  if($("#posts").find("#new-post").length == 0) {
    var html = '<div class="card" data-count="1" id="new-post"><h5 class="new-posts">View new posts</h5></div>';
    $("#posts").prepend(html);
  }
  $("#home").addClass("unread");
  //console.log(newhtml);
}

var html;
var newhtml;
function loadChat(fr) {
  $.ajax({
    method: "GET",
    async: false,
    url: "api.php/chat",
    data: {from: fr, html: '1', new_items: true},
    dataType: "html"
  }).done(function(data) {
    if(data != '') {
      newChatNotif(data);
      chatStuff();
      //console.log(data);

    }
    //console.log("EMPTYYY");
    //$("#posts").append( data );
  });
}
function loadNew(fr, id) {
  if(id<0) {
    $.ajax({
      method: "GET",
      async: false,
      url: "api.php/messages",
      data: {from: fr, html: '1', new_items: true},
      dataType: "html"
    }).done(function(data) {
      if(data != '') {
        newhtml = data;
        newNotif();
        //console.log(data);
      }
      //$("#posts").append( data );
    });
  } else {
    $.ajax({
      method: "GET",
      async: false,
      url: "api.php/messages",
      data: {from: fr, user_id: id, html: '1', new_items: true},
      dataType: "html"
    }).done(function(data) {
      if(data != '') {
        newhtml = data;
        newNotif();
        //console.log(data);

      }
      //console.log("EMPTYYY");
      //$("#posts").append( data );
    });
  }
  a();
  genThumbs();
}

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
  genThumbs();
}

var selected;
var winsz = $(window).width();

var chkpst;

$( document ).ready(function () {
  a();
  var refer = Get('id');
  //make chat
  if($("#_genchat").length != 0) {
    $.ajax({
      type: "GET",
      url: "api.php/chat",
      data: {
        gen: true
      },
      dataType: "html",
      success: function(result) {
        $("#_genchat").html(result);
        chatStuff();
      },
      error: function(result) {
        alert('error');
      }
    });
  }

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
          //console.log(result);
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
  //window refresh
    $(window).resize(function () {
      winsz = $(window).width();
    });
  //rt click
  $(".action-rt").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var r_id = $(e).parents('.post').attr('data-id');
         i.preventDefault();
         $.ajax({
           type: "GET",
           url: "api.php/repost",
           data: {
             id: r_id
           },
           success: function(result) {
             notify('Reposted !');
           },
           error: function(result) {
             notify('Error');
           }
         });
       });
     }
   });
  //rt click
  $(".action-reply").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var id = $(e).parents('.post').attr('data-id');
         //console.log(id);
       });
     }
   });
  //rt click
  $(".action-like").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var r_id = $(e).parents('.post').attr('data-id');
         i.preventDefault();
         $.ajax({
           type: "GET",
           url: "api.php/like",
           data: {
             id: r_id
           },
           success: function(result) {
             notify('Liked!');
           },
           error: function(result) {
             notify('Error');
           }
         });
         console.log(r_id);
       });
     }
   });
  //chats click
  $("#chat").click(function(e) {
    if (winsz < 1100 && selected != $("#chat") && ($("#chats").length > 0) && 0) { //DISABLED ATM
      $("#chats").toggleClass("visible");
      $(".posts-main").toggleClass("nope");
      selected.toggleClass("selected");
      $("#chat").toggleClass("selected");
    } else {
      document.location = "?action=messages";
    }

    //$(".navbar-right").find(".selected");
  });
  //Drag and drop stuff
  $("#mediaAdd").click(function(e) {
    //console.log("upload");
    $('#uploadModal').modal('toggle');
  });
  $("html").on("dragover", function(e) {
      e.preventDefault();
      e.stopPropagation();
      $("#dragText").text("Drag here");
  });
  $("html").on("drop", function(e) { e.preventDefault(); e.stopPropagation(); });
  $('.upload-area').on('dragenter', function (e) {
      e.stopPropagation();
      e.preventDefault();
      $(".upload-area").addClass('dragover');
      $("#dragText").text("Drop");
  });
  $('.upload-area').on('dragover', function (e) {
      e.stopPropagation();
      e.preventDefault();
      $("#dragText").text("Drop");
  });
  $('.upload-area').on('drop', function (e) {
      e.stopPropagation();
      e.preventDefault();
      $("#dragText").text("Upload");
      var file = e.originalEvent.dataTransfer.files;
      var fd = new FormData();
      fd.append('img', file[0]);
      uploadMedia(fd);
      $(".upload-area").removeClass('dragover');
  });
  thmb();
  $("#img").change(function(){
      var fd = new FormData();
      var files = $('#img')[0].files[0];
      fd.append('img',files);
      uploadMedia(fd);
      $(".upload-area").removeClass('dragover');
  });
  // auto file upload
  $('#mediaPP').change(function(){
    //on change event
    var fd = new FormData();
    var files = $('#mediaPP')[0].files[0];
    fd.append('img',files);
    $.ajax({
      url: 'api/upload.php',
      type: 'post',
      data: fd,
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(response){
        //console.log(response);
        setPP(response);
        //addThumbnail(response);
      }
    });
  });
  $('form').on('submit', function(i, e) {
    //console.log("FILE"+e);
  });

  //upload post
  $("#usendm").click(function(e) {
    var chld = $("#uploadModal").find("#thumbnail_1").length;
    if($('#uploadM').val() != '' || chld !=0 ) {
      e.preventDefault();
      if(chld != 0) {
        //has media
        var mediaID = $("#thumbnail_1").children(".thumb-media").data("media");
        if(mediaID != undefined) {
          $.ajax({
            type: "GET",
            url: "api.php/post",
            data: {
              status: $('#uploadM').val(),
              refer: refer,
              media_id: mediaID,
              access_token: $("#access_token").val()
            },
            success: function(result) {
              //console.log(result);
              $('#uploadM').val('');
              $('#uploadModal').modal('hide');
              notify('Posted !');
            },
            error: function(result) {
              alert('error');
            }
          });
        }
      } else {
        $.ajax({
          type: "GET",
          url: "api.php/post",
          data: {
            status: $('#uploadM').val(),
            refer: refer,
            access_token: $("#access_token").val()
          },
          success: function(result) {
            //console.log(result);
            $('#uploadM').val('');
            $('#uploadModal').modal('hide');
            notify('Posted !');
          },
          error: function(result) {
            alert('error');
          }
        });
      }
    }else {
      notify('No text profided');
    }
  });
  // post for mobile
  $("#sendm").click(function(e) {
    if($('#commentm').val() != '') {
      e.preventDefault();
      $.ajax({
        type: "GET",
        url: "api.php/post",
        data: {
          status: $('#commentm').val(),
          refer: refer,
          access_token: $("#access_token").val()
        },
        success: function(result) {
          //console.log(result);
          $('#commentm').val('');
          $('#composeModal').modal('hide');
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

  //profile edit
  desclck();
  ppclck();


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
  // thumbs
  Push.Permission.request();
  genThumbs();
});

var timeoutId;
var hoverFetchDelay= 500;
var elem;
var html;

var min;
var max;

function fmin() {
  var min = $(".post").data("id");
  $(".post").each(function (i, e) {
    var id = parseInt($(e).data("id"), 10);
    if(min>id) min=id;
  });
  return min;
}

function fmax() {
  var max = $(".post").data("id");
  $(".post").each(function (i, e) {
    var id = parseInt($(e).data("id"), 10);
    if(max<id) max=id;
  });
  return max;
}

function cmax() {
  var max = $(".chat").data("id");
  $(".chat").each(function (i, e) {
    var id = parseInt($(e).data("id"), 10);
    if(max<id) max=id;
  });
  return max;
}

function descnrml(text) {
  $("#profile-desc").html('<p class="card-text" id="profile-desc-text">'+text+'</p>');
  desclck();
}

function ppclck() {
  $("#profile-picture").click(function(e) {
    //$("#profile-picture").append('<div>edit</div>');
  });
}

/*
<div class="dropdown-menu"><div class="js-first-tabstop" tabindex="0"></div>
  <div class="dropdown-caret">
    <span class="caret-outer"></span>
    <span class="caret-inner"></span>
  </div>
  <ul tabindex="-1" role="menu" aria-hidden="false">
    <li id="photo-choose-existing" class="photo-choose-existing upload-photo" role="presentation">
      <button type="button" class="dropdown-link" role="menuitem">Envoyer une photo</button>
      <div class="photo-selector">
  <button class="btn" type="button">
      Changer la photo
    </button>
  <span class="photo-file-name">Aucun fichier sélectionné</span>
  <div class="image-selector">
    <input type="hidden" name="media_file_name" class="file-name">
    <input type="hidden" name="media_data_empty" class="file-data">
    <label class="t1-label">
      <span class="u-hiddenVisually">Ajouter une photo</span>
      <input type="file" name="media[]" class="file-input js-tooltip" tabindex="-1" accept="image/gif,image/jpeg,image/jpg,image/png" data-original-title="Ajouter une photo">
    </label>
  </div>
</div>

    </li>
      <li id="photo-choose-webcam" class="u-hidden" role="presentation">
        <button type="button" class="dropdown-link">Prendre une photo</button>
      </li>
    <li id="photo-delete-image" class="" role="presentation">
      <button type="button" class="dropdown-link" role="menuitem">Supprimer</button>
    </li>
      <li class="dropdown-divider" role="presentation"></li>
      <li class="cancel-options" role="presentation">
        <button type="button" class="dropdown-link" role="menuitem">Annuler</button>
      </li>
  </ul>
<div class="js-last-tabstop" tabindex="0"></div></div>

 */

function desclck() {
  $("#profile-desc-text").click(function(e) {
    var text = $("#profile-desc-text").html();
    $("#profile-desc").html('');

    $("#profile-desc").append('<textarea class="profile-desc-edit" placeholder="Profile description . . .">'+text+'</textarea>');
    $("#profile-desc").append('<button type="button" id="saveBtn" class="btn btn-primary float-right">Save</button>');
    $("#profile-desc").append('<button type="button" id="cancelBtn" class="btn btn-secondary float-left" data-text="'+text+'">Cancel</button>');
    edtrfs();
    //$("#profile-desc").append('<p class="card-text">'+text+'</p>');
  });
}

function edtrfs() {
  $("#cancelBtn").each(function (i, e) {
    if($._data($(e)[0], 'events')==null) {
      $(e).click(function(i) {
        descnrml($(e).data('text'));
      });
    }
  });

  $("#saveBtn").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var text = $(".profile-desc-edit").val();
         if(text != '') {
           $.ajax({
             method: "GET",
             url: "api.php/setProfile",
             data: {statut: text},
             dataType: "html"
           }).done(function(data) {
             html = data;
             descnrml(html);
           });
         }
         //console.log(text);
       });
     }
   });
}

function drgopn() {
  $("#dragText").each(function (i, e) {
     //console.log($._data($(e)[0], 'events'));
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         if($("#thumbnail_1").length == 0) {
           $("#img").click();
         }
         //console.log("add");
       });
     }
   });
}

function thmb() {
  $(".thumb-remove").each(function (i, e) {
     //console.log($._data($(e)[0], 'events'));
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         if($("#thumbnail_1").length != 0) {
           $("#thumbnail_1").remove();
           $("#uploadfile").append('<h5 id="dragText">Drop your medias here</h5>');
           drgopn();
           //console.log("remove");
         }
       });
     }
   });
}

function updateChat(data) {
  $(".chat-posts").append( data );
  chatStuff();
}

function chatMedia(data) {
  if(data.name != undefined) {
    var src = data.src;
    var mediaID = data.media_id;

    $.ajax({
      method: "GET",
      url: "api.php/chat",
      data: {media_id: mediaID, html: true, access_token: $("#access_token").val()},
      dataType: "html"
    }).done(function(data) {
      notify("Succes !");
      updateChat(data);
    });
  }
}

function addEmojis(data) {
  $(".emoji-block").html(data);
  $(".emojisel").each(function (i, e) {
     //console.log($._data($(e)[0], 'events'));
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var id = $(e).attr('data-emoji');
         $('#chat_in').val($('#chat_in').val()+" :"+id+": ");
       });
     }
   });
}

function chatStuff() {
  //Chat hide and show
  if($(".emoji-block").find(".emoji-list").length ==0) {
    $.ajax({
      method: "GET",
      url: "api.php/emojis",
      data: {all: 1, html: true},
      dataType: "html"
    }).done(function(data) {
      addEmojis(data);
    });
  }
  $(".chat-container").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         $(".ripple").removeClass("rippleEffect");
         $("#favicon").attr("href","images/favicon/of-16.png");
         $("#chat").removeClass("unread");
         $(".new-chat").remove();
       });
     }
   });
  $("#linkChatAdd").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         $(".media-chat-link").toggleClass("hidden");
       });
     }
   });
  $("#chat-toggle").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         $(".chat-container").toggleClass("hidden");
         $(".ripple").removeClass("rippleEffect");
         $("#favicon").attr("href","images/favicon/of-16.png");
         $("#chat").removeClass("unread");
         $(".new-chat").remove();
       });
     }
   });
  // chat bottom
  if ($( 'body' ).has( '.chat-posts' ).length) {
    $('.chat-posts').animate({
      scrollTop: $('.chat-posts')[0].scrollHeight*2
    }, 1000);
  }
  //chat upload
  $("#mediaChat").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).change(function(){
         var fd = new FormData();
         var files = $('#mediaChat')[0].files[0];
         fd.append('img',files);
         $.ajax({
           url: 'api/upload.php',
           type: 'post',
           data: fd,
           contentType: false,
           processData: false,
           dataType: 'json',
           success: function(response){
             //console.log(response);
             chatMedia(response);
             //setPP(response);
             //addThumbnail(response);
           }
         });
       });
     }
   });
    //Chat action
    $('#chat_in').each(function (i, e) {
      if($._data($(e)[0], 'events')==null) {
        $(e).keypress(function(i) {
          if (i.which == '13') {
            if($('#chat_in').val() != '') {
              $.ajax({
                type: "GET",
                url: "api.php/chat",
                data: {
                  status: $('#chat_in').val(),
                  html: true,
                  access_token: $("#access_token").val()
                },
                dataType: "html",
                success: function(result) {
                  //console.log(result);
                  $('#chat_in').val('');
                  updateChat(result);
                  //notify('Posted !');
                },
                error: function(result) {
                  alert('error');
                }
              });
            } else {
              notify('No text profided');
            }
            }
          });
        }
      });
    $("#chatm").each(function (i, e) {
       //console.log($._data($(e)[0], 'events'));
       if($._data($(e)[0], 'events')==null) {
         $(e).click(function(i) {
           if($('#chat_in').val() != '') {
             if($("#media_chat_link").val() != '') {
               var mediaID = $("#media_chat_link").val();
               $.ajax({
                 type: "GET",
                 url: "api.php/chat",
                 data: {
                   status: $('#chat_in').val(),
                   media_id: mediaID,
                   html: true,
                   access_token: $("#access_token").val()
                 },
                 dataType: "html",
                 success: function(result) {
                   $('#chat_in').val('');
                   $("#media_chat_link").val('');
                   $(".media-chat-link").addClass('hidden');
                   updateChat(result);
                 },
                 error: function(result) {
                   alert('error');
                 }
               });
             } else {
               $.ajax({
                 type: "GET",
                 url: "api.php/chat",
                 data: {
                   status: $('#chat_in').val(),
                   html: true,
                   access_token: $("#access_token").val()
                 },
                 dataType: "html",
                 success: function(result) {
                   //console.log(result);
                   $('#chat_in').val('');
                   updateChat(result);
                   //notify('Posted !');
                 },
                 error: function(result) {
                   alert('error');
                 }
               });
             }
           } else {
             if($("#media_chat_link").val() != '') {
               var mediaID = $("#media_chat_link").val();
               $.ajax({
                 type: "GET",
                 url: "api.php/chat",
                 data: {
                   media_id: mediaID,
                   html: true,
                   access_token: $("#access_token").val()
                 },
                 dataType: "html",
                 success: function(result) {
                   $('#chat_in').val('');
                   $("#media_chat_link").val('');
                   $(".media-chat-link").addClass('hidden');
                   updateChat(result);
                 },
                 error: function(result) {
                   alert('error');
                 }
               });
             } else {
               notify('No text profided');
             }
           }
         });
       }
     });
}

function refreshPosts() {
  a();
  genThumbs();
}

function genThumbs() {
  $('.link-preview').each(function(i, e) {
    if($(e).parents('.card-text').has('.embed-card').length ==0) {
      var target = $(e).text();
        $(e).parents('.card-text').append('<div class="embed-card card"><div class="card-body"><p class="card-text">Loading link . . .</p></div></div>');
      $.ajax({
        type: "GET",
        url: "api.php/preview",
        dataType: 'json',
        data: {q: target, key: 'myKey'},
        success: function (data) {
          if(data.error == null) {
            console.log(data);
            $(e).parents('.card-text').find('.embed-card').html(((data.image!='')?'<img class="card-img-top" src="'+data.image+'" alt="Card image cap">':'')+'<div class="card-body">'+'<h5 class="card-title"><a href="'+data.url+'">'+data.title+'</a></h5>'+((data.description!='')?'<p class="card-text">'+data.description+'</p>':'')+'</div>');
          } else {
          }
        }
      });
    }
  });
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
      selected = $("#home");
      break;
    case "users":
      $('#friends').addClass("selected");
      selected = $("#friends");
      break;
    case "messages":
      $('#chat').addClass("selected");
      selected = $("#chat");
      break;
    default:
  }
  //rt click
  $(".action-rt").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var r_id = $(e).parents('.post').attr('data-id');
         i.preventDefault();
         $.ajax({
           type: "GET",
           url: "api.php/repost",
           data: {
             id: r_id
           },
           success: function(result) {
             $(e).find(".count").html(parseInt($(e).find(".count").html())+1);
             notify('Reposted !');
           },
           error: function(result) {
             notify('Error');
           }
         });
       });
     }
   });
   //reply
  $(".action-reply").each(function (i, e) {
     //console.log($._data($(e)[0], 'events'));
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var id = $(e).parents('.post').attr('data-id');
         //console.log(id);
       });
     }
   });
  ///*
  //if($._data($(this)[0], 'events')==null) {
    /*$(".action-reply").click(function(e) {
      var id = $(this).parents('.post').attr('data-id');
      console.log(id);
    });*/
  //}
  //rt click
  $(".action-like").each(function (i, e) {
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         var r_id = $(e).parents('.post').attr('data-id');
         i.preventDefault();
         $.ajax({
           type: "GET",
           url: "api.php/like",
           data: {
             id: r_id
           },
           success: function(result) {
             var likes = result.likes;
             $(e).find(".count").html(likes);
             notify('Liked!');
           },
           error: function(result) {
             notify('Error');
           }
         });
         console.log(r_id);
       });
     }
   });
   // New post click
  $("#new-post").each(function (i, e) {
     //console.log($._data($(e)[0], 'events'));
     if($._data($(e)[0], 'events')==null) {
       $(e).click(function(i) {
         $("#new-post").remove();
         $("#home").removeClass("unread");
         $("#posts").prepend(newhtml);
         refreshPosts();
       });
     }
   });
  //If scrolled to bottom
  /*$(window).scroll(function() {
    //console.log(fmin());
    if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
       loadMoar(fmin(), -1);
    }
  });*/
}
