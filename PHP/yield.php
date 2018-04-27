<?php
function get_one_to_three()
{
	for ($i=0; $i < 8; $i++) { 
		yield $i;
	}
}

foreach (get_one_to_three() as $key => $value) {
	echo $value . PHP_EOL;
}