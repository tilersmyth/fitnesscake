 <?php define('WP_USE_THEMES', false);
require('wp-blog-header.php');
//header("HTTP/1.1 200 OK");


if (!empty($_POST["value"])):

$results = array();	
$querystring = parse_url($_POST["value"], PHP_URL_QUERY);
parse_str($querystring, $var);
$embed = $var['v'];

$json = json_decode(file_get_contents("http://gdata.youtube.com/feeds/api/videos/".$embed."?v=2&alt=jsonc"));

$results['title'] = $json->data->title;
$results['desc'] = $json->data->description;
$results['vidID'] = $json->data->id;
$results['vidthumb'] = $json->data->thumbnail->hqDefault;


echo json_encode($results);

endif;


?>