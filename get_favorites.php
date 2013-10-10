<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<?php

    
    require 'connection.php';
    require 'tmhOAuth.php';
    require 'app_tokens.php';
	class Favorites
	{


        
        public $connection;

		

        


        //
		public function get_favorites()
		{

             

             $connection = new tmhOAuth(array(
                 'consumer_key' => $consumer_key, 
                 'consumer_secret' => $consumer_secret,
                 'user_token' => $user_token,
                 'user_secret' => $user_secret
                 ));

            $http_code = $connection->request('GET',$connection->url('/1.1/favorites/list'), 
                 array('screen_name' => 'd7my11',
                 'include_entities' => 'true'));

            $tweet_data = json_decode($connection->response['response'],true);

           


            foreach($tweet_data as $tweet) {
                 // Add this tweet's text to the results
                 $tweet_id = $tweet['id_str'];
                 $tweet_text = $tweet['text'];
                 $tweet_user = $tweet['user'];
                 $screen_name = $tweet_user['screen_name'];
                 $profile_image = $tweet_user['profile_image_url_https'];
                 
                 
                 $final_url = self::extract($tweet_text);
                 
                 
                    self::store($tweet_id, $tweet_text, $screen_name, $final_url, $profile_image ); 
                   

                    //$http_code = $connection->request('POST',$connection->url('/1.1/favorites/destroy'), 
                 //   array('id' => '$tweet_id',
                  //  'include_entities' => 'true'));

                    //$tweet_data = json_decode($connection->response['response'],true);
        
                    
             }

		}


        public function store($tweetId, $tweetText, $screenName, $final_url, $profile_image)
        {
            
            
            $this->mySQLi = connect();
            $this->mySQLi->query("INSERT INTO favoritelist (id, tweet, screen_name, url, profile_image) 
                                    VALUES ('$tweetId', '$tweetText', '$screenName', '$final_url', '$profile_image')");
        }



        public function extract($text)
        {
            $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";

            // The Text you want to filter for urls

            // Check if there is a url in the text
            if(preg_match($reg_exUrl, $text, $url)) {


            // make the urls hyper links
              $final_url = $url['0'];
              return $final_url;
             
            } 
            else
            {

            // if no urls in the text just return the text
            return 0;

            }

        }


        


	}

$test = new Favorites();
$test->get_favorites();

?>

</body>
</html>