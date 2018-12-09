<?php
# @Author: uapv1701795
# @Date:   2018-11-19T00:53:49+01:00
# @Last modified by:   uapv1701795
# @Last modified time: 2018-11-26T16:12:13+01:00

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
				$imgMimes = ['image/gif', 'image/png', 'image/jpeg', 'image/bmp'];
				if(file_exists('media/'.$text)) {
					$mime = mime_content_type('media/'.$text);
					foreach ($imgMimes as $k => $ext) {
	          if ($ext == $mime) return true;
	        }
				}
				if (filter_var($text, FILTER_VALIDATE_URL) !== false) return true;
      }
    }
    return false;
}

class parser
{

	public static function chat($params) {
		$id = is_logged($_SESSION);
		$new = (has_key('new_items', $params) && $params['new_items']==true)?true:false;
		$html = (has_key('html', $params))?1:0; //generate html
		if($id >=0) {
			$chat = array();
			//id post emetteur
			$post['emetteur']=$id;

			if(has_key('gen',$params)) {
				echo maker::chat($params);
				return;
			}
			if(has_key('from', $params)) {
				if($html) {
					if(is_numeric($params['from'])) {
						$_chats = chatTable::getNewChatMessage($params['from']);
						$cstack = array();
						foreach (array_reverse($_chats) as $chat) {
							$_pst = postTable::getPostById($chat->post);
				      $_emtr = utilisateurTable::getUserById($chat->emetteur);
							if(isset($_pst) && isset($_emtr)) {
				        $pid = $chat->id;
				        $id = $chat->emetteur;
				        if($_pst[0]->image != null) {
				          $img = genImage($chat->emetteur, $_pst[0]->image);
				          $thumb = genThumb($id, $_pst[0]->image);
				        } else {
				          $img = null;
				          $thumb = null;
				        }
				        $msg = (isset($_pst[0]))?escape($_pst[0]->texte):'';
				        $usr = $_emtr[0];
				        getChat($pid, $img, $thumb, $id, $usr, $msg);
				        /*$tmp = new Compose($chat, $_pst, $_emtr);
				        array_push($cstack, $tmp);*/
				      }
						}
						return;
					} else {
						return '';
					}
				} else {
					if(is_numeric($params['from'])) {
						$_chats = chatTable::getNewChatMessage($params['from']);
						$cstack = array();
						foreach (array_reverse($_chats) as $chat) {
							$_pst = postTable::getPostById($chat->post);
				      $_emtr = utilisateurTable::getUserById($chat->emetteur);
							if(isset($_pst) && isset($_emtr)) {
				        $pid = $chat->id;
				        $id = $chat->emetteur;
				        if($_pst[0]->image != null) {
				          $img = genImage($chat->emetteur, $_pst[0]->image);
				          $thumb = genThumb($id, $_pst[0]->image);
				        } else {
				          $img = null;
				          $thumb = null;
				        }
				        $msg = (isset($_pst[0]))?escape($_pst[0]->texte):'';
				        $usr = $_emtr[0];
				        //getChat($pid, $img, $thumb, $id, $usr, $msg);
				        $tmp = new Compose($chat, $_pst, $_emtr);
				        array_push($cstack, $tmp);
				      }
						}
						return json_encode($cstack);
					} else return raiseError(genError(400,'Invalid id'));
				}
			}
			if (has_key('status',$params)) {
				$status = $params['status'];
				if(strlen($status)>254) return raiseError(genError(186,'Message is too long'));
				$post['status'] = trim(escape(urldecode($status)));
				$media_id= '';
				$post['image'] = '';
			} else {
				if (!has_key('media_id',$params)) return raiseError(genError(325,'A media id was not found'));
				$media_id = $params['media_id'];
				if(!has_media($id, $media_id)) return raiseError(genError(324,'The validation of media ids failed'));
				$post['media_id'] = $media_id;
				$post['status'] = '';
				// media_id = 98a665.... => image name
			}
			if (has_key('media_id',$params)) {
				$media_id = $params['media_id'];
				if(has_media($id, $media_id)) $post['image'] = $media_id;
			}
			$date = date("Y-m-d H:i:s");
			$post['date'] = $date;
			$pst = array($post['status']  => 'texte' ,$post['date']  => 'date' ,$post['image']  => 'image' );
			$_P = new post($pst);
			$postid = $_P->save();
			$mssg = array($postid => 'post',$id => 'emetteur');
			$_C = new chat($mssg);
			if(is_null($_C->emetteur)) $_C->emetteur = $id;
			$pid = $_C->save();
			if($html) {
				if($post['image'] != '') {
					$img = genImage($id, $_P->image);
					$thumb = genThumb($id, $_P->image);
				} else {
					$img= null;
					$thumb = null;
				}
				$usr = utilisateurTable::getUserById($_C->emetteur)[0];
				$msg = $post['status'];
				getChat($pid, $img, $thumb, $_C->emetteur, $usr, $msg);
			} else {
				return json_encode($_C);
			}
				//var_dump($_C);
			} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

	public static function post($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			$post = array();
			$r = postTable::getLastPostId();
			if($r!=false)$post['id'] = $r[0]['max']+1;
			$post['emetteur']=$id;
			$post['destinataire']=(has_key('refer',$params) && is_user($params['refer']))?$params['refer']:1; //1 public ?
			$post['parent']=(has_key('reply',$params) && is_post($params['reply']))?$params['reply']:-1;
			if (has_key('status',$params)) {
				$status = $params['status'];
				if(strlen($status)>254) return raiseError(genError(186,'Message is too long'));
				//if(strlen($status)>254) $status = substr($status, 0, 250).'...';
				$post['status'] = trim(escape(urldecode($status)));
			} else {
				if (!has_key('media_id',$params)) return raiseError(genError(325,'A media id was not found'));
				$media_id = $params['media_id'];
				if(!has_media($id, $media_id)) return raiseError(genError(324,'The validation of media ids failed'));
				$post['media_id'] = $media_id;
				$post['status'] = '';
				// media_id = 98a665.... => image name
			}
			  $date = date("Y-m-d H:i:s");
				$post['date'] = $date;
				$media_id= '';
				$post['image'] = '';
				if (has_key('media_id',$params)) {
					$media_id = $params['media_id'];
					if(has_media($id, $media_id)) $post['image'] = $media_id;
				}
				$pst = array($post['status']  => 'texte' ,$post['date']  => 'date' ,$post['image']  => 'image' );
				$_P = new post($pst);
				$postid = $_P->save();
				$post['message_id'] = 0;
				$lmid = messageTable::getLastCreatedMessagesId();
				if($lmid!=false)$post['message_id'] = $lmid[0]['last_value'];
				$post['id'] = $postid;
				$mssg = array($post['emetteur'] => 'emetteur',$post['destinataire'] => 'destinataire',$post['parent'] => 'parent',$postid => 'post',0 => 'aime');
				$_M = new message($mssg);
				$_M->emetteur = $post['emetteur'];
				$_M->destinataire = $post['destinataire'];
				$_M->save();
				return json_encode($_M);
			return json_encode($post);
		}
		else return raiseError(genError(215,'Bad Authentication data.'));
		//post code
	}

	public static function repost($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			if(has_key('id', $params)){
				if(is_numeric($params['id'])) {
					$post = messageTable::getMessagesByID($params['id']);
					//var_dump($post);
					if($post != null && !empty($post)) {
						$mssg = array($id => 'emetteur',$post[0]->destinataire => 'destinataire',$post[0]->post => 'parent',$post[0]->post => 'post',0 => 'aime');
						$_M = new message($mssg);
						if(is_null($_M->parent) || $_M->parent == "") $_M->parent = $post[0]->post;
						$_M->destinataire = (has_key('refer',$params) && is_user($params['refer']))?$params['refer']:(is_null($post[0]->destinataire))?0:$post[0]->destinataire;
						$_M->emetteur = ($id==0)?1:$id;
						//$_M->destinataire = $post[0]->destinataire;
						//var_dump($_M);
						$_M->save();
						return json_encode($_M);
					}
				}
				return raiseError(genError(50,'post not found'));
			} else return raiseError(genError(50,'Post not found'));
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

	public static function like($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			if(has_key('id', $params)){
				if(is_numeric($params['id'])) {
					$post = messageTable::getMessagesByID($params['id']);
					//var_dump($post);
					if($post != null && !empty($post) && array_key_exists('0', $post)) {
						$likes = $post[0]->aime + 1;
						$r = messageTable::likeMessage($params['id'], $likes);
						$rtrn = array('likes' => $likes);
						return json_encode($rtrn);
					}
				}
				return raiseError(genError(50,'post not found'));
			} else return raiseError(genError(50,'Post not found'));
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
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
 //https://twitter.com/i/timeline?composed_count=0
 // &include_available_features=1
 // &include_entities=1
 // &include_new_items_bar=true
 // &interval=10000
 // &latent_count=3
 // &min_position=1071072220498280448
	public static function timeline($params) {
		$id = is_logged($_SESSION);
		$html = (has_key('html', $params))?1:0;
		if($id >=0) {
			if(has_key('min_position', $params)){ //id
				if(is_numeric($params['min_position']) && $params['min_position']>=0) {
					$rtrn = messageTable::getNewMessagesFrom($params['min_position']);
					if(has_key(0, $rtrn)) return json_encode($rtrn);
				}
			}
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

	public static function hasNew($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			if(has_key('id', $params)){
				if(is_numeric($params['id']) && $params['id']>=0) {
					$rtrn = messageTable::getNewMessagesFrom($params['id']);
					if(has_key(0, $rtrn)) return json_encode($rtrn);
				}
			}
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

  public static function messages($params)
	{
			$html = (has_key('html', $params))?1:0; //generate html
			$new = (has_key('new_items', $params) && $params['new_items']==true)?true:false;
			$stack = array();
			if(has_key('from', $params)){
				if(is_numeric($params['from'])) {
					if(has_key('user_id', $params) && is_numeric($params['user_id'])){
						$_msgs = messageTable::getMessagesOnProfileSinceId($params['from'], $params['user_id'], $new);
					} else {
						$_msgs = messageTable::getMessagesSinceId($params['from'], -1, $new);
					}
				} else {
					if($new){ //id
						$_msgs = null;
					} else {
						$_msgs = messageTable::getMessages();
					}
				}
			} else {
				if(has_key('min_position', $params)){ //id
					if($new && is_numeric($params['min_position']) && $params['min_position']>=0) {
						$_msgs = messageTable::getNewMessagesFrom($params['min_position']);
					} else {
						$_msgs = null;
					}
				} elseif (has_key('tag', $params)) {
					$p = postTable::getHashTag($params['tag']);
					$_msgs = array();
					foreach ($p as $key => $post) {
						$m = messageTable::getMessageWherePostID($post->id);
						foreach ($m as $key => $msg) {
							array_push($_msgs, $msg);
						}
					}
				} else {
					$_msgs = messageTable::getMessages();
				}
			}
			foreach ($_msgs as $msg) {
				//var_dump($msg);
				if(!is_null($msg->post)) {
					$_pst = postTable::getPostById($msg->post);
					$_emtr = utilisateurTable::getUserById($msg->emetteur);
					$_more = array('Reply' => messageTable::getMessagesReply($msg->post), 'Repost' => messageTable::getMessagesRepost($msg->post));
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
							$com = count(messageTable::getMessagesReply($msg->post));
							$rt = count(messageTable::getMessagesRepost($msg->post));
							$likes = (isset($msg) && $msg->aime != NULL && is_numeric($msg->aime))?$msg->aime:0;
							$mesg = (isset($_pst[0]))?escape($_pst[0]->texte):'';
							$date = (isset($_pst[0]))?genTimeDiff($_pst[0]->date):'times ago';
							$usr = $_emtr[0];
							//var_dump($_emtr);
							echo getPost($pid, $img, $likes, $com, $rt, $thumb, $id, $usr, $mesg, $date);
							//echo '<!-- id='.$msg->id.'-->';
							//var_dump($msg);
							//var_dump($_pst);
							//var_dump($_emtr);
							//$tmp = getPost();
							//$img, $likes, $com, $thumb, $id, $usr, $msg, $date)
							//array_push($stack, $tmp);
						} else {
							$tmp = new Compose($msg, $_pst, $_emtr, $_more);
							array_push($stack, $tmp);
						}
					}
				}
			}
		return ($html)?'':json_encode($stack);
	}

	public static function setProfile($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			if(has_key('statut', $params)) {
				$rtrn = utilisateurTable::alter('statut', $id, urldecode($params['statut']));
				if(has_key(0, $rtrn)) return urldecode($params['statut']);
			}
			if(has_key('avatar', $params)){
				$rtrn = utilisateurTable::alter('avatar', $id, $params['avatar']);
				if(has_key(0, $rtrn)) return urldecode($params['avatar']);
			} else {
				return raiseError(genError(400,'Invalid avatar'));
			}
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
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

	public static function emojis($params) {
		$id = is_logged($_SESSION);
		$html = (has_key('html', $params))?1:0; //generate html
		if($id >=0) {
			if(has_key('id', $params)) {
				$pid = $params['id'];
				if($html)	$emoji = emojiTable::getEmoji($pid, true);
				else $emoji = emojiTable::getEmoji($pid);
				if($emoji != false) return $emoji;
			}
			if(has_key('all', $params)){
				if(!$html) header('Content-Type: application/json');
				$providers = emojiTable::getProviders();
				$result = array();
				//var_dump($providers);
				foreach ($providers as $key => $provider) {
					$dir = $provider["dir"];
					$name = $provider["name"];
					$cdir = scandir($dir);
					if($html) echo '<div class="row emoji-list">';
					if($html) echo '<div class="emojis-provider text-muted">'.$name.'</div>';
					foreach ($cdir as $key => $file) {
					  if (!in_array($file,array(".",".."))) {
					    if (is_dir($dir . DIRECTORY_SEPARATOR . $file)) {
					      $result[$file] = dirToArray($dir . DIRECTORY_SEPARATOR . $file);
					    } else {
					      $p = explode('.', $file);
					      if(!$html) $result[$p[0]] = $dir.'/'.$file;
								else {
									echo '<div class="col emoji emojisel" data-emoji='.$p[0].'><div class="emoji-image" style="background-image: url('.$dir.'/'.$file.');"></div></div>';
								}
					    }
					  }
					}
					if(!$html) return json_encode($result);
					else {
						echo '</div>';
					}
					//var_dump($provider);
				}
			} else {
				return raiseError(genError(400,'Invalid avatar'));
			}
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
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
