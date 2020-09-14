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

$nodeValues = $crawler->filter('a')->each(function (Crawler $node, $i) {
	return $node->text();
});

print_r($nodeValues);