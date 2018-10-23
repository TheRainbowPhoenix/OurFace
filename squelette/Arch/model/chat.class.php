<?php

class chat extends basemodel {
  /**
   * get Post
   * @param  id $id id
   * @return post     post
   */
  public function getPost($id)
  {
    return (isset($id) && $this->id==$id)?postTable::getPostById($id):false;
  }

/**
 * get Emetteur
 * @return int emetteur
 */
  public function getEmetteur()
  {
    return $this->emetteur;
  }
}
