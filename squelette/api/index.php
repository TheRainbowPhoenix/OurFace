<!doctype html>
<html>  
<head>
    <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>OurFace API</title>
  <meta name="author" content="Pho3">
  <meta name="description" content="Arch API pages">
  <meta name="keywords" content="API,Arch">
  <meta property="og:title" content="Ourface">
  <meta property="og:type" content="image/png">
  <meta property="og:url" content="https://pedago02a.univ-avignon.fr/~uapv1701795/squelette/">
  <meta property="og:image" content="../images/favicon/of-192.png">
  <meta property="og:site_name" content="OurFace">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="white">
  <meta name="apple-mobile-web-app-title" content="OurFace">
  <link rel="apple-touch-icon" href="../images/favicon/of-192.png">
  <meta name="msapplication-TileImage" content="../images/favicon/of-144.png">
  <meta name="msapplication-TileColor" content="#FBF9FB">

  <link rel="mask-icon" sizes="any" href="../images/favicon/of.svg" color="#FBF9FB">
  <link id="favicon" rel="shortcut icon" href="../images/favicon/of-16.png" type="image/x-icon">
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Raleway:200,300,400,500,700" type="text/css">
  <link href="../bad/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/icons.css" rel="stylesheet">
  <link href="../bad/css/bad.css" rel="stylesheet">
  <?php if(isset($_COOKIE['night_mode']) && $_COOKIE['night_mode']==1) echo '<link id="night_mode_css" href="../bad/css/bad_night.css" rel="stylesheet">' ?>
  </head>
  <body>

  <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../bad/js/jquery.lazy.min.js"></script>
    <script type="text/javascript" src="../bad/js/jquery-ui.min.js"></script>
    <script src="../bad/js/ekko-lightbox.js"></script>
    <script src="../bad/js/cheap.js" type='text/javascript'></script>
    <script src="../bad/js/js.cookie-2.2.0.min.js" type='text/javascript'></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/push.js/0.0.11/push.min.js"></script>
<script>
if (navigator.userAgent.indexOf("Chrome") == -1){ // Fuck you IE I hate you
	document.write("\<script src='bad/js/stickyfill.js' type='text/javascript'>\<\/script>");
	$(function() {
		Stickyfill.add($('.sticky'));
		Stickyfill.add($('.affix-top'));
      });
    }
	var night_mode = (Cookies.get('night_mode') == 1)?1:0;
    </script>

	<!-- nav -->
	<nav class="navbar navbar-light fixed-top bg-light flex-md-nowrap p-0 shadow">
      <a class="navbar-brand col-sm-3 col-md-4 mr-0 text-center" href="?">Arch API</a>
	</nav>

	<div class="container-fluid">
      	  <div class="row flax-xl-nowrap" id="root-row">
	    <div class="col-12 col-md-3 col-xl-3 BProfile APIBar">
		<nav>
		  <ul class="list-group">
			<li class="list-group-item"><a href="#gs">Getting started</a></li>
			<li class="list-group-item"><a href="#lk">Links</a></li>
			<li class="list-group-item"><a href="#fs">First Steps</a></li>
			<li class="list-group-item"><a href="#gu">Get users</a></li>
			<li class="list-group-item"><a href="#gm">Get messages</a></li>
			<li class="list-group-item"><a href="#ge">Emojis <span class="badge badge-warning">NEW !</span></a></li>
		  </ul>
		</nav>		
	    </div>

	<?php 
	$url = 'https://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']).'/api/';
?>
	    <div class="col-12 col-md-9 col-xl-8 py-md-3 pl-md-5 bd-content">
		<h1 class="title" id="gs">Getting started</h1>
		<p>OurFace is another social network. Want to use one ouf our services ? Arch's API here to help ! Start right now using our JSON-powered API.</p>
		<h2 id="lk">Links</h2>
		<p>All the api calls are made from the following URL:</p>
		<code class="markup"><?php echo $url; ?></code>
		<br>
		<h2 id="fs">First Steps</h2>
		<p>Arch API offers many services, such as link preview or emoji conversion. All the following examples are teste with JQuery framework, which is recommaned.</p>	
		<h3 id="gu">Get users <span class="badge badge-warning">Require login</span></h3>
		<p>Returns a JSON list of details about a given user, or all available</p>
		<!-- Block -->
		<h4>Get a given user by ID <span class="badge badge-secondary">JSON</span></h4>
		<p>Retruns a JSON array in which the first index is the matching user, or error if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>users?id=1</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">[{"id":1,"identifiant":"fredouille","nom":"Fredouille","prenom":"Corinne","date_de_naissance":"1973-03-23 00:00:00","statut":null,"avatar":null}]</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">50</span> User not found<br>
		<span class="badge badge-secondary">215</span> Bad Authentication data. </p>
		<br>
		<!-- Block -->
		<h4>Get all users <span class="badge badge-secondary">JSON</span></h4>
		<p>Retruns a JSON array in which every index is a registered user, or error if empty</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>users?all=1</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">[{"id":114,"identifiant":"NyahBot","nom":"Nyah","prenom":"Nyah","date_de_naissance":"1987-01-01 00:00:00","statut":"catgirls! nyaa~! also maybe a few foxgirls and wolfgirls or w\/e","avatar":"https:\/\/pbs.twimg.com\/profile_images\/660713043861483521\/4s-nKyXD_400x400.jpg"},{"id":1,"identifiant":"fredouille","nom":"Fredouille","prenom":"Corinne","date_de_naissance":"1973-03-23 00:00:00","statut":null,"avatar":null}]</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">50</span> User not found<br>
		<span class="badge badge-secondary">215</span> Bad Authentication data. </p>
		<br>
		<!-- Block -->
		<h4>Get users from index <span class="badge badge-secondary">JSON</span></h4>
		<p>Retruns a JSON array in which the first index is the matching user and the 17 followings in the register, or error if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>users?all=1&from=20</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">[{"id":20,"identifiant":"uapv1705404","nom":"CAPPA","prenom":"Florian","date_de_naissance":"1998-02-28 00:00:00","statut":"FI-NI","avatar":null},{"id":21,"identifiant":"uapv1703219","nom":"GERARD","prenom":"Florian","date_de_naissance":"1998-04-03 00:00:00","statut":null,"avatar":"https:\/\/media.tenor.com\/images\/86eb7c00905ba5fa58b0e0bc7c7c7486\/tenor.gif"},{"id":22,"identifiant":"HollowsG","nom":"Hollows","prenom":"Gael","date_de_naissance":"1997-05-23 00:00:00","statut":null,"avatar":null},{"id":23,"identifiant":"uapv1900285","nom":"LO","prenom":"Ahmadou ","date_de_naissance":"1993-02-18 00:00:00","statut":null,"avatar":null},{"id":24,"identifiant":"uapv1900405","nom":"NZIHOU NZIENGUI","prenom":"Flanord","date_de_naissance":"1992-02-17 00:00:00","statut":null,"avatar":null},{"id":25,"identifiant":"YuPanda","nom":"Lamoureux","prenom":"Kevin","date_de_naissance":"1995-02-06 00:00:00","statut":null,"avatar":null},{"id":26,"identifiant":"Bastieng","nom":"gautier","prenom":"Bastien","date_de_naissance":"1997-09-06 00:00:00","statut":"New statut","avatar":"https:\/\/pedago02a.univ-avignon.fr\/~uapv1602627\/Facetock\/images\/Capture_du_2017-02-28_14:57:38.png"},{"id":27,"identifiant":"Boarf","nom":"FERRER","prenom":"Gregory","date_de_naissance":"1997-07-21 00:00:00","statut":"Vive php","avatar":null},{"id":28,"identifiant":"uapv1701834","nom":"LAPERRIERE","prenom":"Ga\u00eblle","date_de_naissance":"1997-11-05 00:00:00","statut":"Pouet.","avatar":"https:\/\/i.pinimg.com\/originals\/eb\/55\/54\/eb5554f40537d92761af51c167956c66.gif"},{"id":29,"identifiant":"uapv1900482","nom":"derbene","prenom":"kahina","date_de_naissance":"1995-07-02 00:00:00","statut":"hello","avatar":null},{"id":30,"identifiant":"uapv1900168","nom":"LAACHIRI","prenom":"Hafsa","date_de_naissance":"1998-08-29 00:00:00","statut":null,"avatar":"http:\/\/www.joomlack.fr\/images\/stories\/images\/on-top-of-earth.jpg"},{"id":31,"identifiant":"uapv1900482","nom":"derbene","prenom":"kahina","date_de_naissance":"1995-07-02 00:00:00","statut":"bonjour","avatar":null},{"id":32,"identifiant":"uapv1900482","nom":"derbene","prenom":"kahina","date_de_naissance":"1995-07-02 00:00:00","statut":"bonjour","avatar":null},{"id":33,"identifiant":"uapv1900102","nom":"HEMAIZI","prenom":"CAMILIA","date_de_naissance":"1997-10-28 00:00:00","statut":null,"avatar":null},{"id":34,"identifiant":"uapv1702383","nom":"Robine","prenom":"Thomas","date_de_naissance":"1997-01-16 00:00:00","statut":null,"avatar":null},{"id":35,"identifiant":"patatra","nom":"delarue","prenom":"bernard","date_de_naissance":"1789-01-01 00:00:00","statut":null,"avatar":null},{"id":36,"identifiant":"adel.chabli","nom":"Chabli","prenom":"Adel","date_de_naissance":"1994-10-05 00:00:00","statut":"Le php c'est la vie ! ... Ou pas 2","avatar":"http:\/\/66.media.tumblr.com\/b94a5219ab3d82af1f3ef6ebc53250d1\/tumblr_msu2nqlA6p1scncwdo1_500.gif"},{"id":37,"identifiant":"flow","nom":"RIBOU","prenom":"Florian","date_de_naissance":"1994-01-31 00:00:00","statut":"mon nouveau statut","avatar":null},{"id":38,"identifiant":"zineddinelakhdari","nom":"Lakhdari","prenom":"Zine Eddine","date_de_naissance":"1997-11-05 00:00:00","statut":null,"avatar":null}]</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">50</span> User not found<br>
		<span class="badge badge-secondary">215</span> Bad Authentication data. </p>
		<br>

		<h3 id="gm">Get messages <span class="badge badge-warning">Require login</span></h3>
                <p>Returns a JSON list of details about a given user, or all available</p>

		
		<!-- Block -->
		<h4>Get messages from <span class="badge badge-secondary">JSON</span> <span class="badge badge-secondary">HTML</span></h4>
		<p>Retruns a JSON array of the messages from the matching user, or error if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>messages?from=55&html=1</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">&lt;div class="card post" data-id="54"&gt;&lt;div class="card-body"&gt;
        &lt;div class="d-flex account-small" data-user-id="55"&gt;
          &lt;div class="avatar-container"&gt;
      &lt;img class="avatar-image" src="profile-image/55_400x400.jpg" alt=""&gt;
        &lt;/div&gt;
        &lt;div class="name-container flex-grow-1"&gt;
          &lt;h5 class="card-title"&gt;&lt;a href="?action=profile&amp;id=55"&gt;root root&lt;/a&gt;&lt;/h5&gt;
          &lt;h6 class="card-subtitle mb-2 text-muted"&gt;@root&lt;/h6&gt;
        &lt;/div&gt;
        &lt;div class="floating-card" style="width: 18rem;"&gt;&lt;/div&gt;
      &lt;/div&gt;
      &lt;p class="card-text"&gt;TODO: Clean all this mess&lt;/p&gt;
    &lt;/div&gt;
    &lt;div class="card-footer"&gt;&lt;div class="post-actions row"&gt;
      &lt;div class="post-action action-like"&gt;
        &lt;span class="icon icon-like"&gt;
        &lt;/span&gt;
  &lt;span class="count"&gt;0&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="post-action action-reply"&gt;
        &lt;span class="icon icon-com"&gt;
        &lt;/span&gt;
        &lt;span class="count"&gt;0&lt;/span&gt;
      &lt;/div&gt;
      &lt;div class="post-action action-rt"&gt;
        &lt;span class="icon icon-rt"&gt;
        &lt;/span&gt;
        &lt;span class="count"&gt;0&lt;/span&gt;
      &lt;/div&gt; &lt;div class="post-action"&gt;
      &lt;a class="share-link" href="?action=share&amp;id=54"&gt;
        &lt;span class="icon icon-share"&gt;
        &lt;/span&gt;
        &lt;span class="share-text count"&gt;share&lt;/span&gt;&lt;/a&gt;
      &lt;/div&gt;&lt;div class="card-link flex-grow-1 post-date"&gt;
        &lt;small class="text-muted float-right"&gt; 25 days ago&lt;/small&gt;
      &lt;/div&gt;
    &lt;/div&gt;&lt;/div&gt;&lt;/div&gt;
</code>
		<br>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>messages?from=55</code>
		<br>
		<h6>Example Response</h6>
		<code class="markup">[{"Reply":[],"Repost":[],"id":55,"emetteur":55,"destinataire":1,"parent":1,"post":54,"aime":0,"texte":"TODO: Clean all this mess","date":"2018-11-22 02:28:49","image":"","identifiant":"root","nom":"root","prenom":"root","date_de_naissance":"1970-01-01 00:00:00","statut":"\/ is my home","avatar":null}</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">[]</span> Empty<br>

		<!-- Block -->
		<h4>Get new messages <span class="badge badge-secondary">JSON</span> <span class="badge badge-secondary">HTML</span></h4>
		<p>Retruns a JSON array containing new messages, or empty if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>messages?from=866&new_items=true</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">{"Reply":[],"Repost":[],"id":28,"emetteur":28,"destinataire":34,"parent":28,"post":2377,"aime":0,"texte":"test","date":"2018-12-16 17:16:15","image":null,"identifiant":"uapv1701834","nom":"LAPERRIERE","prenom":"Ga\u00eblle","date_de_naissance":"1997-11-05 00:00:00","statut":"Pouet.","avatar":"https:\/\/i.pinimg.com\/originals\/eb\/55\/54\/eb5554f40537d92761af51c167956c66.gif"}</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">[]</span> Empty</p>
		<br>
		<h3 id="ge">Emojis</h3>
                <p>Returns a JSON list of emojis, an HTML pre-classed code, or a display-ready url</p>
		<!-- Block -->
		<h4>Get an emoji code by ID <span class="badge badge-secondary">JSON</span> <span class="badge badge-secondary">HTML</span> <span class="badge badge-secondary">URL</span></h4>
		<p>Retruns a JSON array in which the first index is the matching user, or error if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>emojis?id=230137129659924480</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">{"id":"230137129659924480","src":"images\/emojis\/230137129659924480.png"}</code>
		<br>
		<h6>Example Request</h6>
                <code class="markup">GET <?php echo $url; ?>emojis?id=230137129659924480&html=1</code>
                <br>
                <h6>Example Response</h6>
                <code class="markup">&lt;img class="emoji inline" src="images/emojis/230137129659924480.png" alt="230137129659924480" draggable="false"&gt;</code>
		<br>
		<h6>Example Request</h6>
                <code class="markup">GET <?php echo $url; ?>emojis?id=230137129659924480&full=1</code>
                <br>
                <h6>Example Response</h6>
                <code class="markup">https://pedago02a.univ-avignon.fr/~uapv1701795/squelette/images/emojis/230137129659924480.png</code>
                <br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">400</span> Invalid avatar</p>
		<br>
		
		<!-- Block -->
		<h4>Code integration <span class="badge badge-secondary">PHP</span> <span class="badge badge-secondary">CSS</span></h4>		
		<p>The following lines will help you finding emojis in posts and chat</p>
		<h6>PHP Regex</h6>
		<code class="markup">preg_match_all($emoji_re, $text, $matches, PREG_SET_ORDER, 0);
  $rep = array();
  foreach ($matches as $value=&gt;$key) {
    $emoji = emojiTable::getEmoji($key[1], true);
    //var_dump($key);
    if($emoji != false) {
      $rep[$value] = $emoji;
    }
    $matches[$value] = $key[0];
  }
  $text = str_replace($matches, $rep, $text);</code>
		<br>
		<h6>CSS Styles</h6>
		<code class="markup">.emoji,.emoji-list .emoji{margin:0;user-select:none}.emoji-block{max-height:256px;overflow-y:auto;min-width:258px;width:100%;padding-top:0!important;padding-bottom:0!important}.emoji-list{flex-wrap:inherit;display:block}.emoji,.emoji-image,.emoji-list .emoji{display:inline-block}.emoji{width:28px;height:28px}.emoji-list .emoji{width:32px;height:32px;padding:2px}.emojis-provider{padding-left:4px}.emoji:hover{background:rgba(0,0,0,.125);border-radius:.125rem}.emoji-image{background-position:50%;background-repeat:no-repeat;background-size:contain;cursor:pointer;height:28px;line-height:28px;text-align:center;width:28px;overflow:hidden}</code>
		<br>
		<h6>PHP Class</h6>
		<code class="markup">class emojiTable extends basemodel {
  public function getProviders()
  {
    $list = array();
    $provider = array('dir' =&gt; 'images/emojis','name' =&gt; 'Arch' );
    array_push($list, $provider);
    $provider = array('dir' =&gt; 'images/default','name' =&gt; 'Default' );
    array_push($list, $provider);
    return $list;
  }

  public function getEmoji($pid, $html=false)
  {
    if(isset($pid)) {
      $providers = emojiTable::getProviders();
      foreach ($providers as $key =&gt; $provider) {
        $dir = $provider["dir"];
        $imgExt = ['jpg', 'gif', 'png'];
        foreach ($imgExt as $k =&gt; $ext) {
          if (file_exists($dir.'/'.$pid.'.'.$ext)) {
            if($html) {
              return '&lt;img class="emoji inline" src="'.$dir.'/'.$pid.'.'.$ext.'" alt="'.$pid.'" draggable="false"&gt;';
            } else {
              $rtrn = array('id' =&gt; $pid, 'src' =&gt; $dir.'/'.$pid.'.'.$ext);
              return json_encode($rtrn);
            }
          }
        }
      }
    }
    return false;
  }
}</code>
		<br>
		<!-- Block -->
		<h4>Get a given user by ID <span class="badge badge-secondary">JSON</span></h4>
		<p>Retruns a JSON array in which the first index is the matching user, or error if none</p>
		<h6>Example Request</h6>
		<code class="markup">GET <?php echo $url; ?>users?id=1</code>		
		<br>
		<h6>Example Response</h6>
		<code class="markup">[{"id":1,"identifiant":"fredouille","nom":"Fredouille","prenom":"Corinne","date_de_naissance":"1973-03-23 00:00:00","statut":null,"avatar":null}]</code>
		<br>
		<h6>Raised Errors</h6>
		<p><span class="badge badge-secondary">50</span> User not found<br>
		<span class="badge badge-secondary">215</span> Bad Authentication data. </p>
		<br>



			</div>
          </div>
	 </div>


  </body>
</html>  
