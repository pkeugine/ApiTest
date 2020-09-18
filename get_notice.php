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

$notice = $crawler->each(function (Crawler $node, $i) {
	$category = $node
		->filter('.category')
		->text("");
	
	$title = $node->text();
	$title = iconv_substr($title, iconv_strlen($category, "utf-8"), 18, "utf-8")."..";
	
	$link = 'https://www.kw.ac.kr'.$node->attr('href');
	
	return [
		"category" => $category,
		"title" => $title,
		"link" => $link
	];
});

print_r($notice);