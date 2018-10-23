<?php

class message extends basemodel
{

  public function getPost($id)
  {
    return (isset($id) && $this->id==$id)?postTable::getPostById($id):false;
  }

  public function getParent()
  {
    return $this->parent;
  }

  public function getLikes()
  {
    return $this->aime;
  }

  public function getEmetteur()
  {
    return $this->emetteur;
  }

  public function getDestinataire()
  {
    return $this->destinataire;
  }

}
