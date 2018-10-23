<?php

class message extends basemodel
{

  protected $parent;
  protected $like;
  protected $emet;
  protected $dest;

  public function getPost($id)
  {
    return postTable::getPostById($id);
  }

  public function getParent()
  {
    return $this->parent;
  }

  public function getLikes()
  {
    return $this->like;
  }

  public function getEmetteur()
  {
    return $this->emet;
  }

  public function getDestinataire()
  {
    return $this->dest;
  }


}
