<?php

class message extends basemodel
{

  /**
   * get Post By ID
   * @param  id $id id
   * @return post     post
   */
  public function getPost($id)
  {
    return (isset($id) && $this->id==$id)?postTable::getPostById($id):false;
  }

  /**
   * get Parent (except for Batman)
   * @return int parent
   */
  public function getParent()
  {
    return $this->parent;
  }

  /**
   * get Likes (but no one like you)
   * @return int likes
   */
  public function getLikes()
  {
    return $this->aime;
  }

  /**
   * get Emetteur
   * @return int emetteur
   */
  public function getEmetteur()
  {
    return $this->emetteur;
  }

  /**
   * get Destinataire
   * @return int destinataire
   */
  public function getDestinataire()
  {
    return $this->destinataire;
  }

}
