<?php
/**
 * index.php is a model for largely static PHP pages 
 *
 * @package nmCommon
 * @author Damien, Tracy, Daniel
 * @version 2.091 2011/06/17
 * @link http://www.newmanix.com/
 * @license http://opensource.org/licenses/osl-3.0.php Open Software License ("OSL") v. 3.0
 * @see config_inc.php 
 * @todo none
 */
require 'feed.php';
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
$config->titleTag = THIS_PAGE; #Fills <title> tag. If left empty will fallback to $config->titleTag in config_inc.php  
$config->nav1 = array("aboutus.php"=>"About Us") + $config->nav1; 
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $id = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}
# END CONFIG AREA ---------------------------------------------------------- 
if(!isset($_SESSION))
{
    session_start();
    $_SESSION['feed_exp'] = $now + (60 * 10);
}
 
$now = time();

if(isset($_SESSION['feed_exp']) && $now > $_SESSION['feed_exp'])
{
    unset($_SESSION['feed_exp']);
    $_SESSION['feed_exp'] = $now + (60 * 15);
}

get_header(); #defaults to theme header or header_inc.php
     $sql = "SELECT FeedURL FROM sm16_feeds WHERE FeedID = " . $id;
          
        
        $result = mysqli_query(IDB::conn(),$sql) or
            die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));
        if(mysqli_num_rows($result) > 0)
            {#records exist - process
      
	           while ($row = mysqli_fetch_assoc($result))
               {
                  
                   $URL = dbOut($row['FeedURL']);
                      
	           }
             
            }
  $request = $URL;
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }

if(!isset($_SESSION['feed']) || isset($_GET['forcerefresh']))
{
    $_SESSION['feed'] = file_get_contents($request);
    $_SESSION['feedrefreshed'] = time();
}


echo "<h4>The Feed was last refreshed " . date('l, F jS Y h:i:s A', $_SESSION['feedrefreshed']) . ' - <a href="' .$_SERVER['REQUEST_URI']. '&forcerefresh=1" style="color: blue">Refresh Now?</a></h4>';

get_footer(); #defaults to theme header or footer_inc.php
?>