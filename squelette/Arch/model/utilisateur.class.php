<?php
class utilisateur extends basemodel implements JsonSerializable {

  public function jsonSerialize() {
    //id"]=> int(1) ["emetteur"]=> int(2) ["destinataire"]=> int(1) ["parent"]=> int(2) ["post"]=> int(1) ["aime"]=> int(5)
        return [
            'id' => $this->id,
            'identifiant' => $this->identifiant,
            'nom' => $this->nom,
            'prenom' => $this->prenom,
            'date_de_naissance' => $this->date_de_naissance,
            'statut' => $this->statut,
            'avatar' => $this->avatar
        ];
    }


}
