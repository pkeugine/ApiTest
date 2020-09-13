<?php
$json_data = file_get_contents("php://input");
$obj_json = json_decode($json_data);
$received = $obj_json->action->detailParams;
$class1 = $received->Classes->value;

//$class2 = $received->class2->value;
//$class3 = $received->class3->value;
//$class4 = $received->class4->value;
//$class5 = $received->class5->value;
//$class6 = $received->class6->value;

//$schedule = '당신의 스케줄: '.$class1.', '.$class2.', '.$class3.', '.$class4.', '.$class5.', '.$class6.'입니다.';
$schedule = '당신의 스케줄: '.$class1.' 수업을 들어야해요.';
$jayParseAry = [
  "version" => "2.0",
  "template" => [
    "outputs" => [
      [
        "basicCard" => [
		  "title" => "testing",	
          "description" => $schedule,
		  "thumbnail" => [
			"imageUrl" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT4BJ9LU4Ikr_EvZLmijfcjzQKMRCJ2bO3A8SVKNuQ78zu2KOqM"
		  ]
        ]
      ]
    ]
  ]
];

echo json_encode($jayParseAry, JSON_UNESCAPED_UNICODE);