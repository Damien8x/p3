<?php
/**
 * index.php is a model for largely static PHP pages 
 *
 * @package nmCommon
 * @author Bill Newman <williamnewman@gmail.com>
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



/*
$config->metaDescription = 'Web Database ITC281 class website.'; #Fills <meta> tags.
$config->metaKeywords = 'SCCC,Seattle Central,ITC281,database,mysql,php';
$config->metaRobots = 'no index, no follow';
$config->loadhead = ''; #load page specific JS
$config->banner = ''; #goes inside header
$config->copyright = ''; #goes inside footer
$config->sidebar1 = ''; #goes inside left side of page
$config->sidebar2 = ''; #goes inside right side of page
$config->nav1["page.php"] = "New Page!"; #add a new page to end of nav1 (viewable this page only)!!
$config->nav1 = array("page.php"=>"New Page!") + $config->nav1; #add a new page to beginning of nav1 (viewable this page only)!!
*/

# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php


     $sql = "SELECT FeedURL FROM sm16_feeds WHERE FeedID = " . $id;
          

        
        $result = mysqli_query(IDB::conn(),$sql) or
            die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
            {#records exist - process
           // $this->SurveyID = $id;
	       // $this->isValid = true;	
	           while ($row = mysqli_fetch_assoc($result))
               {
                   //$this->Title = dbOut($row['Title']); 
                   //$this->Description = dbOut($row['Description']);
                   //$this->Feeds[] = new
                   $URL = dbOut($row['FeedURL']);
                      
	           }
             
            }






//read-feed-simpleXML.php
//our simplest example of consuming an RSS feed

  $request = $URL;
  $response = file_get_contents($request);
  $xml = simplexml_load_string($response);
  print '<h1>' . $xml->channel->title . '</h1>';
  foreach($xml->channel->item as $story)
  {
    echo '<a href="' . $story->link . '">' . $story->title . '</a><br />'; 
    echo '<p>' . $story->description . '</p><br /><br />';
  }

get_footer(); #defaults to theme header or footer_inc.php
?>
