<?php
# @Author: uapv1701795
# @Date:   2018-11-19T00:53:49+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-20T15:25:50+01:00

function is_logged($S) {
	if(array_key_exists('user_var', $S)) return $S['user_var']['id'];
	else return -1;
}

function has_key($key, $array) {
	if (!isset($key) || !isset($array) || !is_array($array)) return false;
	return (array_key_exists($key, $array) && isset($array[$key]));
}

function raiseError($err) {
	$trace = array();
	$trace['errors'] = (is_array($err) && has_key(0,$err))?$err:array("0"=>$err);
	return json_encode($trace);
}

function genError($code, $text) {
	$err = array();
	$err['code'] = (is_numeric($code))?$code:0;
	$err['message'] = escape($text);
	return $err;
}

/*function genPP($text, $id) {
  if(isset($text) && !is_null($text) && file_exists('profile-image/'.$text)) return 'profile-image/'.$text;
  $f = 'profile-image/'.$id.'_400x400.jpg';
  if(file_exists($f)) return $f;
  else return "images/ico/def48.png";
}*/
/*function genPP($text, $id) {
  if(isset($text) && !is_null($text)) {
    if(file_exists('profile-image/'.$text)) return 'profile-image/'.$text;
    if (filter_var($text, FILTER_VALIDATE_URL) !== false) return $text;
  } elseif (isset($id)) {
    $f = 'profile-image/'.$id.'_400x400.jpg';
    if(file_exists($f)) return $f;
  }
  return "images/ico/def.svg";
}*/

function is_user($id) {
	return (is_numeric($id) && $id>=0 && utilisateurTable::getUserById($id) != false);
}

function is_post($id) {
	return (is_numeric($id) && $id>=0 && postTable::getPostById($id) != false);
}

function has_media($id, $text) {
    if(isset($id) && isset($text) && !is_null($text)) {
      if (file_exists('media/'.$id.'_'.$text)) return true;
      else {
        $imgExt = ['jpg', 'gif', 'png'];
	foreach ($imgExt as $k => $ext) {
          if (file_exists('media/'.$id.'_'.$text.'.'.$ext)) return true;
        }
      }
    }
    return false;
}

class parser
{

	public static function post($params) {
		//INSERT INTO fredouil.message (id, emetteur, destinataire, parent, post, aime) VALUES (13, 2, 1, 2, 13, 1);
		//INSERT INTO fredouil.post (id, texte, date, image) VALUES (13, '', '2018-11-18 09:25:24.742112', 'dd48d9347cc6');
		$id = is_logged($_SESSION);
		if($id >=0) {
			$post = array();
			//$post['id'] = 456;
			$r = postTable::getLastPostId();
			if($r!=false)$post['id'] = $r[0]['max']+1;
			$post['emetteur']=$id;
			$post['destinataire']=(has_key('refer',$params) && is_user($params['refer']))?$params['refer']:1; //1 public ?
			$post['parent']=(has_key('reply',$params) && is_post($params['reply']))?$params['reply']:1;
			//post = generated id, aime = 0
			if (has_key('status',$params)) {
				$status = $params['status'];
				if(strlen($status)>254) return raiseError(genError(186,'Message is too long'));
				//if(strlen($status)>254) $status = substr($status, 0, 250).'...';
				$post['status'] = trim(escape(urldecode($status)));
			  $date = date("Y-m-d h:i:s.u");
				$post['date'] = $date;
				$media_id= '';
				$post['image'] = '';
				if (has_key('media_id',$params)) {
					$media_id = $params['media_id'];
					if(has_media($id, $media_id)) $post['image'] = $media_id;
				}
				$pst = array('' => 'id' ,$post['status']  => 'texte' ,$post['date']  => 'date' ,$post['image']  => 'image' );
				$_P = new post($pst);
				$postid = $_P->save();
				//$lid = postTable::getLastCreatedPostId();
				//if($lid!=false)$post['id'] = $lid[0]['last_value'];
				$post['message_id'] = 0;
				$lmid = messageTable::getLastCreatedMessagesId();
				if($lmid!=false)$post['message_id'] = $lmid[0]['last_value'];
				//var_dump($_P);
				//var_dump($lid);
				//var_dump($lmid);
				//echo $post['id'];
				//var_dump($post['destinataire']);
				$post['id'] = $postid;
				$mssg = array($post['emetteur'] => 'emetteur',$post['destinataire'] => 'destinataire',$post['parent'] => 'parent',$postid => 'post',0 => 'aime');
				$_M = new message($mssg);
				$_M->emetteur = $post['emetteur'];
				$_M->destinataire = $post['destinataire'];
				//var_dump($_M);
				$_M->save();
				//var_dump($_P);
				//echo $_P->id;
			} else {
				if (!has_key('media_id',$params)) return raiseError(genError(325,'A media id was not found'));
				$media_id = $params['media_id'];
				if(!has_media($id, $media_id)) return raiseError(genError(324,'The validation of media ids failed'));
				$post['media_id'] = $media_id;
				// media_id = 98a665.... => image name
			}
			return json_encode($post);
		}
		else return raiseError(genError(215,'Bad Authentication data.'));
		//post code
	}

	public static function users($params)
	{
		$id = is_logged($_SESSION);
		if($id >=0) {
     		if(has_key('id', $params)){
       		if(is_numeric($params['id'])) {
					$rtrn = utilisateurTable::getUserById($params['id']);
					if(has_key(0, $rtrn)) return json_encode($rtrn);
				}
				return raiseError(genError(50,'User not found'));
			} elseif(has_key('all', $params) && $params['all'] == '1') {
				if(has_key('from', $params)) {
					if(is_numeric($params['from'])) {
						$rtrn = utilisateurTable::getUsersFrom($params['from']);
						if(has_key(0, $rtrn)) return json_encode($rtrn);
					} else return raiseError(genError(50,'User not found'));
				}
				return json_encode(utilisateurTable::getUsersV2());
			} else return raiseError(genError(50,'User not found'));
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

  public static function messages($params)
	{
			$html = (has_key('html', $params))?1:0; //generate html
			$stack = array();
			if(has_key('from', $params)){
				if(is_numeric($params['from'])) {
					if(has_key('user_id', $params) && is_numeric($params['user_id'])){
						$_msgs = messageTable::getMessagesSinceId($params['from'], $params['user_id']);
					} else {
						$_msgs = messageTable::getMessagesSinceId($params['from'], -1);
					}
				} else {
					$_msgs = messageTable::getMessages();
				}
			} else {
				$_msgs = messageTable::getMessages();
			}
			foreach ($_msgs as $msg) {
				$_pst = postTable::getPostById($msg->id);
				$_emtr = utilisateurTable::getUserById($msg->emetteur);
				if(isset($_pst) && isset($_emtr)) {
					if($html) {
						$pid = $msg->id;
						$id = $msg->emetteur;
						if(isset($_pst[0]) && isset($msg) && $_pst[0]->image != null) {
							$img = genImage($id, $_pst[0]->image);
							$thumb = genThumb($id,$_pst[0]->image);
						} else {
							$img = null;
							$thumb = null;
						}
						$com = 0;
						$likes = (isset($msg) && $msg->aime != NULL && is_numeric($msg->aime))?$msg->aime:0;
						$mesg = (isset($_pst[0]))?escape($_pst[0]->texte):'';
						$date = (isset($_pst[0]))?genTimeDiff($_pst[0]->date):'times ago';
						$usr = $_emtr[0];
						//var_dump($_emtr);
						echo getPost($pid, $img, $likes, $com, $thumb, $id, $usr, $mesg, $date);
						//echo '<!-- id='.$msg->id.'-->';
						//var_dump($msg);
						//var_dump($_pst);
						//var_dump($_emtr);
						//$tmp = getPost();
						//$img, $likes, $com, $thumb, $id, $usr, $msg, $date)
						//array_push($stack, $tmp);
					} else {
						$tmp = new Compose($msg, $_pst, $_emtr);
						array_push($stack, $tmp);
					}
				}
			}
		return ($html)?'':json_encode($stack);
	}

	public static function popup($params)
	{
 		if(has_key('user_id', $params)){
   		if(is_numeric($params['user_id'])) {
				$rtrn = utilisateurTable::getUserById($params['user_id']);
				if(has_key(0, $rtrn)) {
					$html = '<div class="card"> <div class="SProfileCover card-img-top" style="background-image: url('.genPP($rtrn[0]->avatar,$rtrn[0]->id).')"></div> <div class="card-body"> <p class="card-text">'.$rtrn[0]->statut.'</p> <a href="?action=profile&id='.$params['user_id'].'" class="btn btn-primary">View profile</a> </div> </div>'; //TODO: add link to profile
					return $html;
				}
			}
			return raiseError(genError(50,'User not found'));
		} elseif(has_key('all', $params) && $params['all'] == '1') {
			return json_encode(utilisateurTable::getUsersV2());
		} else return raiseError(genError(50,'User not found'));
	}

	public static function suggestions($params) {
		$html = '<li class="list-group-item card-body">
  <div class="d-flex account-small" data-user-id="55">
    <div class="avatar-container">
      <img class="avatar-image" src="profile-image/55_400x400.jpg" alt="">
    </div>
    <div class="name-container flex-grow-1">
      <h5 class="card-title">root root</h5>
      <h6 class="card-subtitle mb-2 text-muted">@root</h6>
    </div>
    <div class="floating-card" style="width: 18rem;"></div>
  </div>
</li>';
		return $html;
	}
}

 ?>
