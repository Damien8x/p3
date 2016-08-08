<?php
/**
 * index.php along with feed-view.php creates an list/view application
 * 
 * @package SurveySez
 * @author Damien, Tracy, Daniel
 * @version 1 2016/08/07
 * @link http://www.damiendev.net/
 * @license http://www.apache.org/licenses/LICENSE-2.0
 * @see feed-view.php
 * @see Pager.php 
 * @todo none
 */

# '../' works for a sub-folder.  use './' for the root  
require '../inc_0700/config_inc.php'; #provides configuration, pathing, error handling, db credentials 
 
# SQL statement
$sql = "select * from sm16_feed_categories";

#Fills <title> tag. If left empty will default to $PageTitle in config_inc.php  
$config->titleTag = 'Feeds made with love & PHP in Seattle';

#Fills <meta> tags.  Currently we're adding to the existing meta tags in config_inc.php
$config->metaDescription = 'Seattle Central\'s ITC250 Class Feeds are made with pure PHP! ' . $config->metaDescription;
$config->metaKeywords = 'Feeds,PHP,Fun,Bran,Regular,Regular Expressions,'. $config->metaKeywords;




# END CONFIG AREA ---------------------------------------------------------- 

get_header(); #defaults to theme header or header_inc.php
?>
<h3 align="center">Feeds</h3>

<?php
#reference images for pager
$prev = '<img src="' . VIRTUAL_PATH . 'images/arrow_prev.gif" border="0" />';
$next = '<img src="' . VIRTUAL_PATH . 'images/arrow_next.gif" border="0" />';



# Create instance of new 'pager' class
$myPager = new Pager(5,'',$prev,$next,'');
$sql = $myPager->loadSQL($sql);  #load SQL, add offset



# connection comes first in mysqli (improved) function
$result = mysqli_query(IDB::conn(),$sql) or die(trigger_error(mysqli_error(IDB::conn()), E_USER_ERROR));



if(mysqli_num_rows($result) > 0)
{#records exist - process
	if($myPager->showTotal()==1){$itemz = "feed";}else{$itemz = "feeds";}  //deal with plural
    echo '<div align="center">We have ' . $myPager->showTotal() . ' ' . $itemz . '!</div>';
	while($row = mysqli_fetch_assoc($result))
	{# process each row
         echo '<div align="center"><a href="' . VIRTUAL_PATH . 'p3/feed-view.php?id=' . (int)$row['FCID'] . '">' . dbOut($row['Title']) . '</a>';
         echo '</div>';
	}
    
    
	echo $myPager->showNAV(); # show paging nav, only if enough records	 
}else{#no records
    echo "<div align=center>What! No Feeds?  There must be a mistake!!</div>";	
}


@mysqli_free_result($result);

get_footer(); #defaults to theme footer or footer_inc.php
?>
