<?php

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