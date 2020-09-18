// loop through the data
$nodeValues = $crawler->filter('.board-text > a')->each(function (Crawler $node, $i) {
	$category = $node->filter
	return [
		'category' => $node->filter('.category')->text(),
		'text' => $node->text(),
		'link' => 'https://www.kw.ac.kr'.$node->attr('href')
	];
	//return $node->text();
});

print_r($nodeValues);

------------------------------------------

<?php
require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

$url = 'https://www.kw.ac.kr/ko/life/notice.jsp';
$client = new GuzzleHttp\Client();
$res = $client->request('GET', $url);

// echo $res->getStatusCode(); // 200
// echo $res->getHeader('content-type')[0];

$html = ''.$res->getBody();

// get the data from $url
$crawler = new Crawler($html);
$crawler = $crawler
	->filter('.board-text > a')
	->reduce(function (Crawler $node, $i) {
		// bring up to 12 notice
		return ($i < 12);
	});

$category = $crawler->each(function (Crawler $node, $i) {
	return $node
		->filter('.category')
		->text("");
});

$title = $crawler->each(function (Crawler $node, $i) {
	$tmpString = $node->text();
	$tmpString = substr($tmpString, strlen($category[$i]));
	return $tmpString;
	//return $node->text();
});
print_r($title);