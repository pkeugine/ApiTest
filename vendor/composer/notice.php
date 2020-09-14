<?php
require __DIR__ . '/vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\HttpClient\HttpClient;

$json_data = file_get_contents("php://input");
$obj_json = json_decode($json_data);

$client = new Client();
// $crawler = $client->request('GET', 'https://www.kw.ac.kr/ko/life/notice.jsp?MaxRows=10&tpage=1&searchKey=1&searchVal=&srCategoryId=');
$crawler = $client->request('GET', 'https://www.naver.com');
$type = "basicCard";

// $description = $crawler->filterXPath('//strong[contains(@class, "category")]')->text();
$description = $crawler->filterXPath('//a[contains(@href, "https://mail.naver.com/")]')->text();
$tempItem->title = "tempo";
$tempItem->description = $description;
$tempItem->imageUrl = "http://k.kakaocdn.net/dn/83BvP/bl20duRC1Q1/lj3JUcmrzC53YIjNDkqbWK/i_6piz1p.jpg";
$tempItem->thumbnail = [ "imageUrl" => $tempItem->imageUrl ];
$button = 	[
				"action" => "message",
				"label" => "open",
				"messageText" => "tada! we found it"
			];
$tempItem->buttons = [ $button ];

//===========================================
//===========================================
//===========================================
$item = 
	[
		"title" => $tempItem->title,
		"description" => $tempItem->description,
		//"thumbnail" => $tempItem->thumbnail,
		"buttons" => $tempItem->buttons
	];
$items = [$item, $item];
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