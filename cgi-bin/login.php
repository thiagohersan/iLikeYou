<?php
  ob_start();
  require_once('php-sdk/facebook.php');

  if(!array_key_exists("configs", $_SESSION)){
    $configs_ = array();
    $oauthXml = simplexml_load_file('oauth.xml');

    foreach ($oauthXml as $myApp_) {
      array_push($configs_, array(
        'appId' => (string)$myApp_['app_id'],
        'secret' => (string)$myApp_['app_secret'],
        'allowSignedRequest' => false
        ));
    }
    $_SESSION['configs'] = $configs_;
  }

  if(!array_key_exists("facebooks", $_SESSION)){
    $configs = $_SESSION['configs'];
    $facebooks_ = array();
    foreach ($configs as $key => $thisConfig) {
      $facebook_ = new Facebook($thisConfig);
      array_push($facebooks_, $facebook_);
    }
    $_SESSION['facebooks'] = $facebooks_;
    $_SESSION['configs'] = $configs;
  }

  $facebooks = $_SESSION['facebooks'];
  $allLoggedIn = true;

  foreach ($facebooks as $key => $thisFacebook) {
    $user_id = $thisFacebook->getUser();
    if($user_id == 0){
      $allLoggedIn = false;
      $login_url = $thisFacebook->getLoginUrl( array( 'scope' => 'read_stream,user_likes,publish_actions,publish_stream,user_likes,friends_checkins,friends_events,friends_interests,friends_likes,friends_notes,friends_photos,friends_status,friends_videos') );
      ob_end_clean();
      header('Location: '.$login_url);
    }
  }

  if($allLoggedIn){
    ob_end_clean();
    header('Location: '.'http://www.thiagohersan.com/iLoveYou');
  }
?>
