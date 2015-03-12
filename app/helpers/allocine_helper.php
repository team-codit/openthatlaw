<?php

class Allocine
{
    private $_api_url 		= 'http://api.allocine.fr/rest/v3';
    private $_partner_key;
    private $_secret_key;
    private $_user_agent 	= 'Dalvik/1.6.0 (Linux; U; Android 4.2.2; Nexus 4 Build/JDQ39E)';

    public function __construct($partner_key, $secret_key)
    {
        $this->_partner_key = $partner_key;
        $this->_secret_key 	= $secret_key;
    }

    private function _do_request($method, $params)
    {
        // build the URL
        $query_url 			= $this->_api_url.'/'.$method;

        // new algo to build the query
        $sed 				= date('Ymd');
        $sig 				= urlencode(base64_encode(sha1($this->_secret_key.http_build_query($params).'&sed='.$sed, true)));
        $query_url 			.= '?'.http_build_query($params).'&sed='.$sed.'&sig='.$sig;

        // do the request
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $query_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->_user_agent);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function search($query, $limit = 5)
    {
        // build the params
        $params = array(
            'partner'		=> $this->_partner_key,
            'q' 			=> $query,
            'format' 		=> 'json',
            'filter' 		=> 'movie,tvseries',
            'count'			=> $limit
        );

        // do the request
        $response 	= $this->_do_request('search', $params);

        return $response;
    }

    public function getMovie($id)
    {
        $params = array(
            'partner' 		=> $this->_partner_key,
            'code' 			=> $id,
            'profile' 		=> 'large',
            'filter' 		=> 'movie',
            'striptags' 	=> 'synopsis,synopsisshort',
            'format' 		=> 'json',
        );

        $response = $this->_do_request('movie', $params);

        return $response;
    }

    public function getSeries($id)
    {
        $params = array(
            'partner' 		=> $this->_partner_key,
            'code' 			=> $id,
            'profile' 		=> 'large',
            'filter' 		=> 'tvseries',
            'striptags' 	=> 'synopsis,synopsisshort',
            'count' 		=> 1,
            'format' 		=> 'json',
        );

        $response = $this->_do_request('tvseries', $params);

        return $response;
    }

    public function topList($limit, $sort, $page = 1)
    {
		$params 		= array(
            'partner' 		=> $this->_partner_key,
            'count' 		=> $limit,
            'page' 			=> $page,
            'profile'		=> 'small',
            'filter'		=> 'nowshowing',
            'order'			=> $sort,
            'format' 		=> 'json'
        );

        // do the request
        $response = $this->_do_request('movielist', $params);

        return $response;
    }
    
    public function topList_save($limit, $sort, $page = 1)
    {
		$params 		= array(
            'partner' 		=> $this->_partner_key,
            'count' 		=> $limit,
            'page' 			=> $page,
            'profile'		=> 'large',
            'filter'		=> 'comingsoon',
            'order'			=> $sort,
            'format' 		=> 'json'
        );

        // do the request
        $response = $this->_do_request('movielist', $params);

        return $response;
    }
}