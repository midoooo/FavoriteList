<?php

		public function destroy($tweet_id)
		{


			 require 'tmhOAuth.php';
             require 'app_tokens.php';

             $connection = new tmhOAuth(array(
                 'consumer_key' => $consumer_key, 
                 'consumer_secret' => $consumer_secret,
                 'user_token' => $user_token,
                 'user_secret' => $user_secret
                 ));

            $http_code = $connection->request('GET',$connection->url('/1.1/favorites/destroy'), 
                 array('id' => '$tweet_id',
                 'include_entities' => 'true'));

            $tweet_data = json_decode($connection->response['response'],true);



}
			 





?>