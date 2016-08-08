<?php
/**
 * survey-view.php along with index.php creates an list/view application
 * 
 * @package SurveySez
 * @author Damien Sudol <damien.sudol@gmail.com>
 * @version 1 2016/07/25
 * @link http://www.damiendev.net/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see index.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials
 require 'feed.php';
 
# check variable of item passed in - if invalid data, forcibly redirect back to ice-cream-list.php page
if(isset($_GET['id']) && (int)$_GET['id'] > 0){#proper data must be on querystring
	 $myID = (int)$_GET['id']; #Convert to integer, will equate to zero if fails
}else{
	myRedirect(VIRTUAL_PATH . "p3/index.php");
}

//---end config area --------------------------------------------------


$myFeed = new FeedCategory($myID);
if($myFeed->isValid)
{//load Feed title in title tag
    $config->titleTag= $myFeed->Title;
}else{//sorry no feed? put that in title tag!
    $config->titleTag='Sorry, no such feed!';
}



get_header(); #defaults to theme header or header_inc.php


get_footer(); #defaults to theme footer or footer_inc.php

class FeedCategory
{
    
    public $Title = '';
    public $Description = '';
    public $FCID =0;
    public $isValid = false;
    public $Feeds = array();
    
    
    
    
    public function __construct($id)
    {
        //forcibly cast to an integer
        $id = (int)$id;
       $sql = "select * from sm16_feed_categories where FCID = " . $id; 
        
        
        $result = mysqli_query(IDB::conn(),$sql) or
            die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));

        if(mysqli_num_rows($result) > 0)
            {#records exist - process
            $this->FeedID = $id;
	        $this->isValid = true;	
	           while ($row = mysqli_fetch_assoc($result))
               {
                   $this->Title = dbOut($row['Title']); 
                   $this->Description = dbOut($row['Description']);
	           }
            }

        @mysqli_free_result($result); # We're done with the data! 
        
        //start of question work
        /*
    
select q.QuestionID, q.Question from sm16_questions q inner join sm16_surveys s on s.SurveyID = q.SurveyID where s.SurveyID = 1
        */
        
        
         //$sql = "select * from sm16_surveys where SurveyID = " . $id; 
           $sql = "SELECT * FROM sm16_feeds WHERE FCID = " . $id;
          

        
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
                   $Feeds[] = new Feed($row['FeedID'],dbOut($row['FeedURL']),dbOut($row['FeedTitle'])); 
	           }
             
            }
    ?><h1 align="center">Choose Your Feed!!</h1><?php
         $max =  sizeof($Feeds);
            for($i=0; $i<$max;$i++){
                
  //echo '<div align="center> <a href=""feed.php""> <h3>' . $Feeds[$i]->FeedTitle . '</h3></a>';

                echo '<div align="center"><a href="' . VIRTUAL_PATH. 'p3/feed-display.php?id=' .
                    $Feeds[$i]->FeedID . '">' . $Feeds[$i]->FeedTitle . '</a>';
                echo '</div>';
                
               
               
            }
          
        @mysqli_free_result($result); # We're done with the data!   
        
        
        //end of feed work
    }#end Feed constructor
}#end Feed class




