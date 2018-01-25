<?php
// JSON header...
header('Content-Type: application/json');

//include language file.
require_once('languages/en-gb.php');
// require_once('languages/de-de.php');
// require_once('languages/fr-fr.php');
// require_once('languages/es-es.php');

date_default_timezone_set("Europe/London");
//Constants
//set the number of search suggestions to show
define("SUGGESTIONS", "4");

$y = (int)SUGGESTIONS;

$term_found = false;
$today = Date('Y-m-d');
$term = strtolower(substr($_GET['term'], 0, 3));
$numeric_today = Date('N');

$values = array();

if (in_array($term, $days_array))
{
	$term_found = true;
	$full_day = $full_day_name[$term];	
	
	$numeric_today = Date('N');

	$day_to_suggest = strtoupper(substr($full_day, 0, 1)).substr($full_day, 1-strlen($full_day));

	if($days_of_week[$full_day]>=$numeric_today)
	{
		$days_to_add = $days_of_week[$full_day]-$numeric_today;
	}
	else
	{
		$days_to_add = 7 - ($numeric_today - $days_of_week[$full_day]);
	}
}
else if(strtolower(substr($_GET['term'], 0, 3)) == 'nex')
{
	$term_found = true;
	$y = 1;
	$day_to_suggest = 'Next';
}
else if(strtolower(substr($_GET['term'], 0, 3)) == 'tod')
{
	$y = 1;
	$term_found = true;
	$days_to_add = 0;
	$day_to_suggest = 'Today';
}
else if(strtolower(substr($_GET['term'], 0, 3)) == $tom)
{	
	$term_found = true;
	$days_to_add = 1;
	$y = 1;
	$day_to_suggest = $tomorrow;
}
	
if($term_found)
{	
	if($days_to_add > 0)
    {
        $new_date = date('d-m-Y', strtotime($today. " + {$days_to_add} days"));
    }
    else
    {
      $new_date = date('d-m-Y');
    }

    $values[] = $day_to_suggest.' '.$new_date;

 for($x=1; $x<$y; $x++)
 {
 	$days_to_add += 7;
 	$new_date = date('d-m-Y', strtotime($today. " + {$days_to_add} days"));
	$values[] = $day_to_suggest.' '.$new_date;
 }
}

echo json_encode($values);
?>