<?php
require_once(dirname(__FILE__).'/vendor/autoload.php');

use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Translate\TranslateClient;

$image_annotator = new ImageAnnotatorClient();

$file_name = 'images/sea.jpg'; //認識したい画像を指定

$image = file_get_contents($file_name);

$response = $image_annotator->labelDetection($image);
$labels = $response->getLabelAnnotations();

if ($labels) {
    echo("認識成功:" . PHP_EOL);
    $translate = new TranslateClient();
    foreach ($labels as $label) {
        $text =$label->getDescription();

        //英語を日本語に変換
        $result = $translate->translate($text, [
            'target' => 'ja'
        ]);
        echo ($result['text'] . PHP_EOL);
    }
} else {
    echo('認識失敗' . PHP_EOL);
}