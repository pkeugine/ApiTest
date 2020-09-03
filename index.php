<?php
$json_data = file_get_contents("php://input");
$obj_json = json_decode($json_data);
$singer = $obj_json->action->detailParams->singer->value;
$num_album = $obj_json->action->detailParams->num_album->origin;

$text = 'order checked : '.$singer.'s '.$num_album.' has been ordered.';
$jayParseAry = [
  "version" => "2.0",
  "template" => [
    "outputs" => [
      [
        "simpleText"=> [
          "text" => $text
        ]
      ]
    ]
  ]
];

echo json_encode($jayParseAry, JSON_UNESCAPED_UNICODE);