<?php

function parent_name($parents,$parent){
	foreach ($parents as $value) {
		if($value['id']==$parent)
			return $value['name'];
	}
	return;
}

?>