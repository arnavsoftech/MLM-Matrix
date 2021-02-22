<?php
include("../includes/config.php"); 
//my database connection is set in my config, otherwise, just create your own db connect
$defaultmcode = 'yourdefaultidhere';
if($_GET['topmcode']){
$topmcode = trim($_GET['topmcode']);
}else{
$topmcode = $defaultmcode;
}
$topmcode = ltrim($topmcode);
$topmcode = rtrim($topmcode);
$topmcode = strtoupper($topmcode);
//my memberid are alphanumerics and all caps so I had to conver all to upper case, else, comment the above strtoupper call

//get Downline of a Member, this function is needed so that you can simply call left or right of the memberid you are looking for
		function GetDownline($member_id,$direction) 
		{ 
				$getdownlinesql = @mysql_fetch_assoc(@mysql_query('select memid,placementid,position from `yourtablehere` where placementid="'.$member_id.'" and  position="'.$direction.'"'));
				$getdownline = $getdownlinesql['memid'];
				return $getdownline; 
		}

//get the child of the member, this section will look for left or right of a member, once found, it will call GetNextDownlines() function to assign new memberid variables for left or right
    function GetChildDownline($member_id) 
    { 
				$getchilddownlinesql = @mysql_query('select memid,placementid,position from `yourtablehere` where placementid="'.$member_id.'" ORDER BY position');
				while($childdownline = mysql_fetch_array($getchilddownlinesql)){
						$childdownlinecode = $childdownline['memid'];
						$direction = $childdownline['position'];
						if($direction=='L'){
							if($childdownlinecode){
								//this is where you play with your html layout
								echo $childdownlinecode.'<br>';
								GetNextDownlines($childdownlinecode,'L');
							}
						}
						
							if($direction=='R'){
								if($childdownlinecode){
									//this is where you play with your html layout
									echo $childdownlinecode.'<br>';
									GetNextDownlines($childdownlinecode,'R');
							}
						}
				 }
    }

//recursive function to call the functions and start all over again, this is where you can get the newly assigned memberid, call the GetChildDownline() that gets the left or right, then recycle all codes
    function GetNextDownlines($member_id,$direction) 
    {
			if($direction=='L'){
					$topleft = GetDownline($member_id,'L');
						if($topleft){
								//this is where you play with your html layout
						echo $topleft.'<br>';
						}
							$getleftdownlinesql = @mysql_query('select memid,placementid,position from `yourtablehere` where placementid="'.$topleft.'" ORDER BY position');
							while($getleftdownline = mysql_fetch_array($getleftdownlinesql)){
							$leftdownline = $getleftdownline['memid'];
							$leftdirection = $getleftdownline['position'];
							
							if($leftdirection=='L'){
									if($leftdownline){
								//this is where you play with your html layout
										echo $leftdownline.'<br>';
										GetChildDownline($leftdownline);
									}
							  }
							
							if($leftdirection=='R'){
									if($leftdownline){
								//this is where you play with your html layout
									echo $leftdownline.'<br>';
									 GetChildDownline($leftdownline);
									 }
							   }
							 }
			}
			
			
			if($direction=='R'){
						$topright = GetDownline($member_id,'R');
						if($topright){
						echo $topright.'<br>';
						}
						$getrightdownlinesql = @mysql_query('select memid,placementid,position from `yourtablehere` where placementid="'.$topright.'" ORDER BY position');
						while($getrightdownline = @mysql_fetch_array($getrightdownlinesql)){
									$rightdownline = $getrightdownline['memid'];
									$rightdirection = $getrightdownline['position'];
									
									if($rightdirection=='L'){
											if($rightdownline){
								//this is where you play with your html layout
											echo $rightdownline.'<br>';
											GetChildDownline($rightdownline);
											}
									}
									
									if($rightdirection=='R'){
											if($rightdownline){
								//this is where you play with your html layout
											echo $rightdownline.'<br>';
											GetChildDownline($rightdownline);
											}
									}
						
							}
				}
}

?>
<html>
	<head>
	<title>Genealogy</title>
	<meta http-equiv=Content-Type content="text/html; charset=utf-8">
	<meta http-equiv=content-language content=en>
	<link href="styles.css" type=text/css rel=stylesheet>
	</head>
<body>
<table cellpadding="0" cellspacing="0" width="100%" border="0" class="noborder">
 <tr>
	<td>
<?php
echo $topmcode.'<br>';
GetNextDownlines($topmcode,'L');
GetNextDownlines($topmcode,'R');
?>

	</td>
 </tr>
</table>
</body>
</html>