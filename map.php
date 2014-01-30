<?php
/*** 
 * map.php
 *
 * this file returns the map. if a location point is specified in POST,
 * write that location to the map file.
 * 
***/

$FNAME = 'places.json';
$map_file = file_get_contents($FNAME);


if( isset($_POST['start']) && isset($_POST['end']) && isset($_POST['name']) 
    && isset($_POST['type'])  && isset($_POST['lat']) && isset($_POST['long']) ){

        $start_age = $_POST['start'];
        $end_age = $_POST['end'];
        $name = $_POST['name'];
        $type = $_POST['type'];
        $lat = $_POST['lat'];
        $long = $_POST['long'];
        if ( $start_age != '' && $end_age != '' && $name != '' 
            && $type != '' && $lat != '' && $long != '' ){
                // if all properties are set, add the point to the json file
                $map_json = json_decode($map_file, true);
                $new_location = new_location_array($start_age, $end_age, $name,
                    $type, $lat, $long);
                array_push($map_json['features'], $new_location);
                $map_file = json_encode($map_json);

                file_put_contents($FNAME, $map_file);
            }

    }

echo $map_file;

function new_location_array($start_age, $end_age, $name, $type, $lat, $long){
    $new_location = array(
        "geometry" => array(
            "type" => "Point", 
            "coordinates" => array(floatval($long), floatval($lat))
        ), 
        "type" => "Feature", 
        "properties" => array(
            "start" => intval($start_age), 
            "end" => intval($end_age), 
            "type" => $type, 
            "name" => $name
        )
    ); 
    return $new_location;
}
?>
