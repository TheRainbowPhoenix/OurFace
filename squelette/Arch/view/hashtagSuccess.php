<?php
  if (!$context->logged) {
    die('Invalid');
  }
?>
<div class="tag-banner">
  <div class="tag-wrapper">
    <h1 class="tag-title" dir="ltr">
      <?php echo '#'.$context->tag; ?>
    </h1>
  </div>
</div>
<div class="news-feed row">
  <div class="col col-lg-3">
    <div class="BSug">
      <div class="card d-flex col-centered">
        <div class="card-header">
          Suggestions
        </div>
        <ul class="list-group list-group-flush">

          <?php echo genSuggestions($context->sug);?>

        </ul>
        <div class="card-body suggestions">
          <a href="?action=users" class="card-link">View more</a>
        </div>
      </div>
    </div>
  </div>
  <div class="col posts-main">
    <div id="posts">
      <h5 class="" style="text-align: center;padding: 32px;">
        Loading tags . . .
      </h5>
      <script type="text/javascript">
        $( document ).ready(function () {
          $.ajax({
            type: "GET",
            url: "api.php/messages",
            data: {
              html: true,
              tag : <?php echo '"'.$context->tag.'"';  ?>
            },
            dataType: "html",
            success: function(result) {
              if(result == '') {
                $("#posts").html('<h5 class="" style="text-align: center;padding: 32px;">Nothing here.</h5>');
              } else {
                $("#posts").html(result);
              }
            },
            error: function(result) {
              notify('Nothing yet !');
            }
          });
        });
      </script>
    </div>
  </div>
  <div class="col col-lg-3 draggable" id="chats">
  </div>
</div>
