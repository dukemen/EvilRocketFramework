<?php
/**
 * @desc class which working for lastfm api
 * @author makinder
 * @version 0.0.1
 * @example $apiKey= 'c04029734cac3ccf1dccfdf7e45168a3';
 */

class Evil_Parser_MusicLastFm implements  Evil_Parser_Interface
{
    protected $_apiKey = 'c04029734cac3ccf1dccfdf7e45168a3';
	public function parse($what = null)
    {
        switch($what)
        {
            case 'top': return $this->getTopTracks();break;
            case 'new': return $this->getLoveTracks();break;
            case null :
                $array = $this->getLoveTracks();
                $array1 =  $this->getTopTracks();
                return array_merge($array,$array1);
            break;
            default:
                throw new Exception('undefined category '. $what);
        }
    }
	/**
	 * @desc 
	 * @author makinder
	 * @param string $apiKey
	 * @return array
	 * @example return array:
	 
	 ["track"] => array(50)
	 				 {
      					[0] => array(9) 
      							{
        							["name"] 	   => "Rolling In The Deep"
        							["duration"]   => "230"
							        ["playcount"]  => "119251"
							        ["listeners"]  => "46283"
        							["mbid"] 	   => array(0) 
        												{
        												}
        							["url"] 	   =>"http://www.last.fm/music/Adele/_/Rolling+In+The+Deep"
        							["streamable"] => "0"
        							["artist"] 	   => array(3) 
        											{
          												["name"] => "Adele"
          												["mbid"] => "b0335a95-8a12-4c71-8149-5054ec847d04"
          												["url"]  =>  "http://www.last.fm/music/Adele"
        											}
        							["image"] 	   => array(4) 
        											{
												          [0] 	 =>  "http://userserve-ak.last.fm/serve/34s/55125087.png"
												          [1] 	 =>  "http://userserve-ak.last.fm/serve/64s/55125087.png"
												          [2] 	 =>  "http://userserve-ak.last.fm/serve/126/55125087.png"
												          [3] 	 =>  "http://userserve-ak.last.fm/serve/300x300/55125087.png"
        											}
        							}				
	 	...........................................................................
	 * @version 0.0.1
	 */
	public function getTopTracks()
	{
		
		$url = 'http://ws.audioscrobbler.com/2.0/?method=chart.gettoptracks&api_key='.$this->_apiKey;
		$request = file_get_contents($url);
		$xmlobj  = simplexml_load_string($request);
		$json = json_encode($xmlobj);
		$response = json_decode($json,TRUE);
        foreach($response as $index=>$value)
            $result[] = $value['track'];
		unset($result[0]);
        return $result;
	}
	
	
	/**
	 * @desc 
	 * @author makinder
	 * @param string $apikey
	 * @return Array
	 * @example return array
	 
	 ["track"] => array(50) 
	 					{
      						[0] => array(7) 
      									{
        									["name"]       => "Drop the World"
									        ["duration"]   =>  "230"
									        ["loves"]      =>  "1941"
									        ["mbid"]       => array(0) 
									        					{
        														}
        									["url"]        => "http://www.last.fm/music/+noredirect/Lil%27+Wayne/_/Drop+the+World"
        									["streamable"] =>  "0"
        									["artist"]     => array(3) 
        													{
          														["name"] =>  "Lil' Wayne"
          														["mbid"] =>  "ac9a487a-d9d2-4f27-bb23-0f4686488345"
          														["url"]  =>  "http://www.last.fm/music/+noredirect/Lil%27+Wayne"
        													}
      									}
	 .................................................................................................
	 * @version 0.0.1
	 */
	public function getLoveTracks()
	{
		$url = 'http://ws.audioscrobbler.com/2.0/?method=chart.getlovedtracks&api_key='. $this->_apiKey;
		$request = file_get_contents($url);
		$xmlobj  = simplexml_load_string($request);
		$json = json_encode($xmlobj);
		$response = json_decode($json,TRUE);
		return $response;
	}
}