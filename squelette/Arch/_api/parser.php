<?php

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

function escape($text) {
  $text = trim($text);
  //$text = strip_tags($text);
  $text = stripslashes($text);
  $text = htmlspecialchars($text, ENT_QUOTES);
  return $text;
}

class parser
{
	
	public static function post($params) {
		$id = is_logged($_SESSION);
		if($id >=0) {
			$post = array();
			$post['id'] = 456;
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
				return json_encode(utilisateurTable::getUsersV2());
			} else return raiseError(genError(50,'User not found'));
		} else {
			return raiseError(genError(215,'Bad Authentication data.'));
		}
	}

  public static function messages($params)
	{
			$stack = array();
			$_msgs = messageTable::getMessages();
			foreach ($_msgs as $msg) {
				$_pst = postTable::getPostById($msg->id);
				$_emtr = utilisateurTable::getUserById($msg->emetteur);
				if(isset($_pst) && isset($_emtr)) {
					$tmp = new Compose($msg, $_pst, $_emtr);
					array_push($stack, $tmp);
				}
			}
		return json_encode($stack);
	}
}

 ?>
