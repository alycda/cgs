<?php
header('Content-Type: application/json');

//load file
// $handle = fopen("capabilities.csv", "r");
$handle = fopen("https://docs.google.com/spreadsheet/pub?key=0AgKEn_l5IMQTdE96QUV1aXA0TzBWR2ktYmRIdFZMbEE&output=csv", "r");

//set vars
$section = '';
$capabilities = [];
$row = 1;
$nomenclature = '';
$manufacturer = '';
$sect = [];
$names = [];
$mfgs = [];
$parts = [];

//read file
while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

	// echo "row is ".$row;
	$curr_section = $data[3];
	$cur_name = $data[1];
	$cur_mfg = $data[2];
	$part = $data[0];


if(!empty($section)) { //make sure we don't store an empty array

	if ($curr_section == $section) { //does current section match the last one?

		if ($cur_name == $nomenclature) { //does current part name match the last one?
			if ($cur_mfg == $manufacturer) { //does current mfg match the last one?
				array_push($parts, $part); //store the part number
			} else { //new mfg
				$mfgs[$manufacturer] = $parts; //save all parts to last manufacturer
				$parts = []; //reset parts
				$sect[$nomenclature] = $mfgs; //save last manufacturer to last 'name'
				array_push($parts, $part); //store the part number
			}

		} else { //new part name
			$mfgs[$manufacturer] = $parts; //save all parts to last manufacturer
			$parts = []; //reset parts
			$sect[$nomenclature] = $mfgs; //save last manufacturer to last 'name'
			$mfgs = []; // reset

			array_push($parts, $part); //store the part number
		}

	} else {
		// $capabilities['part'] = $part;
		$capabilities[$section] = $sect; //store everything
		$sect = []; // reset
	}

}

	$section = $curr_section; //update
	$nomenclature = $cur_name; //update
	$manufacturer = $cur_mfg; //update
	$row++; //increment
}

// add last array, above doesn't know when it's reached the last row
$capabilities[$section] = $sect; //store everything
$sect = []; // reset

echo json_encode($capabilities); ?>