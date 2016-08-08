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

class Feed
{
    public $FeedID = 0;
    public $FeedURL = '';
    public $FeedTitle = '';
   
  public  function __construct($FeedID, $FeedURL, $FeedTitle)
  {
      $this->FeedID = $FeedID;
      $this->FeedURL = $FeedURL;
      $this->FeedTitle = $FeedTitle;
  }#end Feed constructor

}#end  Feed class