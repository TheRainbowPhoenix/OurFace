<?php

class parser
{

	public static function getusers($params)
	{
		return json_encode(utilisateurTable::getUsersV2());
	}
}

 ?>
