<?php
  ob_start();
  require_once('php-sdk/facebook.php');

  if(!array_key_exists("config", $_SESSION)){
    $oauthXml = simplexml_load_file('oauth.php');
    $config_ = array();

    foreach ($oauthXml as $myApp_) {
      // just 1
      // TODO: improve this, take out foreach
      if(count($config_) < 1){
        $config_ = array(
          'appId' => (string)$myApp_['app_id'],
          'secret' => (string)$myApp_['app_secret'],
          'allowSignedRequest' => false );
      }
    }
    $_SESSION['config'] = $config_;
  }

  if(!array_key_exists("facebook", $_SESSION)){
    $config = $_SESSION['config'];
    $facebook_ = new Facebook($config);
    $_SESSION['facebook'] = $facebook_;
    $_SESSION['config'] = $config;
  }
  $facebook = $_SESSION['facebook'];

  $user_id = $facebook->getUser();
  if(($user_id == 0) || ($_GET['status'] != 'connected')){
    $login_url = $facebook->getLoginUrl( array( 'scope' => 'read_stream,user_likes,publish_actions,publish_stream,user_likes,friends_checkins,friends_events,friends_interests,friends_likes,friends_notes,friends_photos,friends_status,friends_videos',
      'redirect_uri' => 'http://www.thiagohersan.com/iLikeYou/cgi-bin/login.php?status=connected') );
    ob_end_clean();
    header('Location: '.$login_url);
  }
  else{
    ob_end_clean();
    header('Location: '.'http://www.thiagohersan.com/iLikeYou');    
  }

?>
