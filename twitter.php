<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>user timeline</title>
    <script src="//twemoji.maxcdn.com/twemoji.min.js"></script>
</head>
<body>
      <a href=""><h1>Testなう</h1></a>
<?php
// tw_more8 foreachを使った複数画像とハッシュタグの取得　デバッグ用の配列

require_once("twitteroauth/twitteroauth.php");

$consumerKey = "";
$consumerSecret = "";
$accessToken = "";
$accessTokenSecret = "";

$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);

$request = $twObj->OAuthRequest('https://api.twitter.com/1.1/statuses/user_timeline.json','GET',
    array(
        'count'=>'200',
        'screen_name' => 'Missdoshisha_mm',
        'screen_name' => 'echizenya_yota',
        // 'include_entities'=>true

        //（"entities"→trueでもfalseでも表示,"extended_entities"はtrueは表示されるがfalseでは表示されない）
        // "include_entities"をコメントアウトすると、"entities"も"extended_entities"もどちらも表示される

        // http://syncer.jp/twitter-api-statuses-home-timeline#content-7(参考)
        // https://dev.twitter.com/rest/public/uploading-media-multiple-photos
        // https://dev.twitter.com/overview/api/entities-in-twitter-objects
        ));
$results = json_decode($request);
?>
<?php
if(isset($results) && empty($results->errors)){
    foreach($results as $tweet){
?>

<?php // print_r($tweet); // デバッグ用Tweet全体の配列が見れる ?>
    <?php echo date('Y-m-d H:i:s', strtotime($tweet->created_at)) ; ?></br>
    <img src="<?php echo $tweet->user->profile_image_url; ?>"></br>
    <?php echo $tweet->user->screen_name; ?></br>
    <?php echo $tweet->text; ?></br>
    <!--<?php echo $tweet->id; ?></br>-->
    <!--<?php echo $tweet->retweet_count; ?></br> -->
    <!--<img src="<?php echo $tweet->entities->media[0]->media_url; ?>">-->

    <?php if (is_array($tweet->extended_entities->media)) { ?>
        <?php foreach($tweet->extended_entities->media as $key => $media) { ?>
            <?php if (isset($tweet->extended_entities->media[$key])) { ?>
            <img src="<?php echo $tweet->extended_entities->media[$key]->media_url; ?><?php echo ':small';?>"></br>
            <?php echo $tweet->extended_entities->media[$key]->sizes->medium->resize; ?></br>
            <?php echo $tweet->extended_entities->media[$key]->sizes->medium->h; ?></br>
            <?php echo $tweet->extended_entities->media[$key]->display_url; ?></br>
            <?php }  ?>
        <?php } ?>
    <?php } ?>

         <?php foreach($tweet->entities->hashtags as $hashtag) { ?>
            <?php echo ($hashtag->text); ?>
         <?php } ?>

    <?php echo ($tweet->entities->hashtags[1]->text);?>
    <!-- ドキュメントのhashtag[]の後にtextがない-->
    <?php echo ($tweet->entities->hashtags[2]->text);?></br></br>
    <?php echo $tweet->entities->media[0]->display_url; ?></br></br>
     <?php // print_r($tweet); デバッグ用Tweet全体の配列が見れる ?>
    <?php } ?>
<?php }else{ ?>
        <?php echo "関連したつぶやきがありません。"; ?>
<?php } ?>

<?php
/*
if (isset($results) && empty($results->errors)) {
    echo '<dl>';
    foreach ($results as $tweet) {
        echo '<dt>' . date('Y-m-d H:i:s', strtotime($tweet->created_at)) . '</dt>';
        echo '<dd>' . $tweet->text . '';
        echo '<dd>' . $tweet->retweet_count . '';
        echo '<dd>' . $tweet->entities->media[0]->media_url;
    }
    echo '</dd></dl>';
} else {
    echo 'つぶやきはありません。';
}
*/

?>
<script>
twemoji.parse(document.body);
</script>
</body>
</html>