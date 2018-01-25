<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Verbose Date Picker</title>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="datepicker.js"></script>
</head>

<body>
<?php
date_default_timezone_set("Europe/London");
//include language file.
require_once('languages/en-gb.php');
// require_once('languages/de-de.php');
// require_once('languages/fr-fr.php');
// require_once('languages/es-es.php');

$today_day = Date('l');
$numeric_today = Date('N');

$today = Date('Y-m-d');

if(isset($_POST["datepicker"]))
{
	$date = $_POST["datepicker"];	
  $date_array = explode(' ', $date);
  if(strtolower($date_array[0]) == 'next')
  {
    $next_day = $date_array[1];
  }
  else
  {
    $next_day = $date_array[0];
  }

    if((strtolower($date_array[0]) == 'next') && ($days_of_week[$next_day] >= $numeric_today))
    {        
        $days_to_add = 7 + ($days_of_week[$next_day] - $numeric_today);    
    }
    else if((strtolower($date_array[0]) != 'next') && ($days_of_week[$next_day] >= $numeric_today))
    {    
        $days_to_add = $days_of_week[$next_day] - $numeric_today;
    }
    else if(strtolower($date_array[0]) == 'tomorrow')
    {
        $days_to_add = 1;
    }
    else if(strtolower($date_array[0]) == 'today')
    {
        $days_to_add = 0;
    }
    else
    {
        $days_to_add = (7 - $numeric_today)+($days_of_week[$next_day]);   
    }  

    if($days_to_add > 0)
    {
        $new_date = date('Y-m-d', strtotime($today. " + $days_to_add days"));
    }
    else
    {
      $new_date = date('Y-m-d');
    }
    
    echo $new_date;
}

?>
<div class="container">
<div class="row">
<p>Enter a date to search and our verbose date picker will make suggestions.</p>
eg
<ul>
  <li>Today</li>
  <li>Tomorrow</li>
  <li>Sunday</li>
  <li>Next Friday</li>
  <li>Sat 17th June</li>
</ul>
<p>Alternatively click on 'Calendar' for a date picker.</p>
</div>
<div class="row">
<form action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method="post" id="form-datepicker">
<div class="row">  
  <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
    <div class="input-group">    	
	      <input type="text" class="form-control" name="datepicker" id="datepicker" placeholder="Search for day of week">
	      <span class="input-group-btn">
	        <button class="btn btn-default" id="calendar" type="button">Calendar</button>
	      </span>	   
    </div>
  </div>
  </div>
  </form>
</div>
</div>
<script type="text/javascript">
  jQuery(document).ready(function($){
var cache={}, prevReq;
$('#datepicker').autocomplete({
  minLength: 3,delay: 500,
source: function(request, response){
var term=request.term;
if (term in cache){
response(cache[term]);
return;
}
prevReq=$.getJSON('values.php', request, function(data, status,
req){
cache[term]=data;
if (req===prevReq){
response(data);
}
});
}
});
});
</script>
</body>
</html>