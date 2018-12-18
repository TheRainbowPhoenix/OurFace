<?php
class post extends basemodel implements JsonSerializable {
  public function jsonSerialize() {
    //["id"]=> int(1) ["texte"]=> string(9) "lol first" ["date"]=> string(26) "2018-10-23 17:22:52.697557" ["image"]=> string(9) "une image"
        return [
            'id' => $this->id,
            'texte' => $this->texte,
            'date' => $this->date,
            'image' => $this->image,
            'reported' => $this->reported
        ];
    }

}
