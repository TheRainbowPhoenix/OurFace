<?php

class scraper
{
  public static function preview($params) {
    if(array_key_exists('q', $params) && $params['q'] != '') {
      $received_url = urldecode($params['q']);
      header("Content-type: application/json; charset=utf-8");
      $url = htmlspecialchars(trim($received_url), ENT_QUOTES, 'ISO-8859-1', TRUE);
      $host = '';
      if (!empty($url)) {
        $url_data = parse_url($url);
        $host = $url_data['host'];
        if(($file = @fopen($url, 'r')) != false) {
          if (!$file) {
            exit();
          } else {
            $content = '';
            while (!feof($file)) {
              $content .= fgets($file, 1024);
            }
          }
          $meta_tags = get_meta_tags($url);

          $title = '';
          if (array_key_exists('og:title', $meta_tags)) {
            $title = $meta_tags['og:title'];
          } else if (array_key_exists('twitter:title', $meta_tags)) {
            $title = $meta_tags['twitter:title'];
          } else {
            $title_pattern = '/<title>(.+)<\/title>/i';
            preg_match_all($title_pattern, $content, $title, PREG_PATTERN_ORDER);
            $title = (!is_array($title[1]))?$title[1]:(count($title[1]) > 0)?$title[1][0]:'';
          }
          $title = ($title == '')?$host:ucfirst($title);
          $title = html_entity_decode($title, ENT_NOQUOTES, 'UTF-8' );

          $desc = '';
          if (array_key_exists('description', $meta_tags)) {
            $desc = $meta_tags['description'];
          } else if (array_key_exists('og:description', $meta_tags)) {
            $desc = $meta_tags['og:description'];
          } else if (array_key_exists('twitter:description', $meta_tags)) {
            $desc = $meta_tags['twitter:description'];
          } else {
            $desc = '';
          }
          $desc = ucfirst($desc);
          $desc = html_entity_decode($desc, ENT_NOQUOTES, 'UTF-8' );

          $img_url = '';
          if (array_key_exists('og:image', $meta_tags)) {
            $img_url = $meta_tags['og:image'];
          } else if (array_key_exists('og:image:src', $meta_tags)) {
            $img_url = $meta_tags['og:image:src'];
          } else if (array_key_exists('twitter:image', $meta_tags)) {
            $img_url = $meta_tags['twitter:image'];
          } else if (array_key_exists('twitter:image:src', $meta_tags)) {
            $img_url = $meta_tags['twitter:image:src'];
          } else {
            $img_pattern = '/<img[^>]*'.
            'src=[\"|\'](.*)[\"|\']/Ui';
            $images = '';
            preg_match_all($img_pattern, $content, $images, PREG_PATTERN_ORDER);
            $total_images = count($images[1]);
            if ($total_images > 0) $images = $images[1];
            for ($i = 0; $i < $total_images; $i++) {
              $url_img = (strpos($images[$i], "/") == 0)?$received_url.$images[$i]:$images[$i];
              if (getimagesize("$url_img")) {
                list($width, $height, $type, $attr) = getimagesize("$url_img");
                if ($width > 256) {
                  $img_url = $url_img;
                  break;
                }
              }
            }
            if($img_url == '') {
              $t = @exif_imagetype($received_url);
              if($t != false && $t>=1 && $t<=3) $img_url = $received_url;
            }
          }
          $json = array('title' => $title, 'description' => $desc, 'image' => $img_url, 'url' => $url);
          return json_encode($json);
        }
      } else {
        $json = array('title' => '', 'description' => 'Invalid response status code (0)', 'image' => '', 'url' => '', 'error' => 403);
        return json_encode($json);
      }
    }
    $json = array('title' => '', 'description' => 'Service denied - invalid input.', 'image' => '', 'url' => '', 'error' => 403);
    return json_encode($json);
  }

}
