<?php
ini_set('display_errors', 1);
function saveImagesFromUrl($url) {
  $html = file_get_contents($url);
  preg_match_all('/<img.*?src=["\'](.+?)["\'].*?>/i', $html, $matches);
  preg_match_all("/background-image:\s*url\('(.*?)'\)/i", $html, $style_matches);
  $images = array_merge($matches[1], $style_matches[1]);
  foreach ($images as $image) {
    $filename = basename($image);
    $dir = dirname($image);
    if (!is_dir($dir)) {
      mkdir($dir, 0777, true);
    }
    $path = $dir . '/' . $filename;
    
    $image_url = (parse_url($image, PHP_URL_SCHEME) ? '' : parse_url($url, PHP_URL_SCHEME) . '://') . parse_url($url, PHP_URL_HOST) . '/' . $image;
    echo $image_url, PHP_EOL;
    file_put_contents($path, file_get_contents($image_url));
  }
}

saveImagesFromUrl('https://megaone.acrothemes.com/index-digital-university.html');
?>