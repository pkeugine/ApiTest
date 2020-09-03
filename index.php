<?php
$json_data = file_get_contents("php://input");
$obj_json = json_decode($json_data);
$received = $obj_json->action->detailParams;
$class1 = $received->class1->value;
$class2 = $received->class2->value;
$class3 = $received->class3->value;
$class4 = $received->class4->value;
$class5 = $received->class5->value;
$class6 = $received->class6->value;

$schedule = '당신의 스케줄: '.$class1.', '.$class2.', '.$class3.', '.$class4.', '.$class5.', '.$class6.'입니다.';
$jayParseAry = [
  "version" => "0.0",
  "template" => [
    "outputs" => [
      [
        "simpleText"=> [
          "text" => $schedule
        ]
      ]
    ]
  ]
];

echo json_encode($jayParseAry, JSON_UNESCAPED_UNICODE);