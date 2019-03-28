<?php

$arr = [
	['name', 'age'],
	['tom', 11],
	['jack', 14],
	['rose', 9],
];

print_r($arr);

$out = [];

for ($i=0;$i<count($arr);$i++) {
	for ($j=0;$j<count($arr[$i]);$j++) {
		$out[$j][$i] = $arr[$i][$j];
	}
}

print_r($out);