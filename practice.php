<?php
require 'vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\CssSelector\CssSelectorConverter;

$url = 'https://www.kw.ac.kr/ko/life/notice.jsp';
$client = new GuzzleHttp\Client();
$res = $client->request('GET', $url);

// Check connection. If it returns 200, the connection is right.
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
	
	$ico_new = $node
		->filter('.ico-new')
		->text("");
	
	$ico_file = $node
		->filter('.ico-file')
		->text("");
	
	$title = $node->text();
	// 20 letter limited title
	//$title = iconv_substr($title, iconv_strlen($category, "utf-8"), 18, "utf-8")."..";
	$title = iconv_substr($title, iconv_strlen($category, "utf-8"), -(iconv_strlen($ico_new, "utf-8")+iconv_strlen($ico_file, "utf-8")+1), "utf-8");
	$webUrl = 'https://www.kw.ac.kr'.$node->attr('href');
	/*
	return [
		"category" => $category,
		"title" => $title,
		"webUrl" => $webUrl
	];
	*/
	
	return [
		"title" => $title,
		"description" => $category." ".$ico_file,
		"thumbnail" => "http://k.kakaocdn.net/dn/83BvP/bl20duRC1Q1/lj3JUcmrzC53YIjNDkqbWK/i_6piz1p.jpg",
		"buttons" => 
		[
			[
				"action" => "webLink",
				"label" => "자세히 보기",
				"webLinkUrl" => $webUrl
			]	
		]
	];
});

$type = "basicCard";
//$tempItem->title = "tempo";
//$tempItem->description = $description;
//$tempItem->imageUrl = "http://k.kakaocdn.net/dn/83BvP/bl20duRC1Q1/lj3JUcmrzC53YIjNDkqbWK/i_6piz1p.jpg";
//$tempItem->thumbnail = [ "imageUrl" => $tempItem->imageUrl ];
$button = 	[
				"action" => "webLink",
				"label" => "공지 보기",
				"webLinkUrl" => notice[0]->webUrl
			];
$buttons = [ $button ];

//===========================================
//===========================================
//===========================================
$item = 
	[
		"title" => $notice[0]->title,
		"description" => $notice[0]->category,
		"thumbnail" => "http://k.kakaocdn.net/dn/83BvP/bl20duRC1Q1/lj3JUcmrzC53YIjNDkqbWK/i_6piz1p.jpg",
		"buttons" => $buttons
	];
$items = $notice;
$carousel =
	[
		"type" => $type,
		"items" => $items
		//--header currently only supports CommerceCard--
		//,"header"
	];

//========== CREATE OUTPUTS PART ==========
$outputs = [ "carousel" => $carousel ];
$templateOutputs = [ $outputs ];

//========== RESPONSE INFORMATION ==========
$responseVersion = "2.0";
$responseTemplate = [ "outputs" => $templateOutputs ];
$responseContext = [];
$responseData = [];

//========== FINAL JSON FORMAT ==========
$responseJson = [
	"version" => $responseVersion,
	"template" => $responseTemplate
	//"context" => $responseContext,
	//"data" => $responseData
];

echo json_encode($responseJson, JSON_UNESCAPED_UNICODE);