<?php
header("Content-type: text/plain");

$o = [
	'class' => "",
	'style' => "background: url(/img/stroika.jpg) 50% 50%;",
	'title' => "ООО СК ГЕНСТРОЙУРАЛ -<br/>Комплексный подход к строительству!",
	'items' => [
		[
			'caption' => "Малоэтажное строительство",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 0
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 0
				],
				[
					'text' => 'Школы',
					'link_id' => 0
				],
				[
					'text' => 'Детские сады',
					'link_id' => 0
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 0
		],
		[
			'caption' => "Социальное строительство",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 0
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 0
				],
				[
					'text' => 'Школы',
					'link_id' => 0
				],
				[
					'text' => 'Детские сады',
					'link_id' => 0
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 0
		],
		[
			'caption' => "Коммерческое строительство",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 0
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 0
				],
				[
					'text' => 'Школы',
					'link_id' => 0
				],
				[
					'text' => 'Детские сады',
					'link_id' => 0
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 0
		],
		[
			'caption' => "Увеличение площади",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 0
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 0
				],
				[
					'text' => 'Школы',
					'link_id' => 0
				],
				[
					'text' => 'Детские сады',
					'link_id' => 0
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 0
		],
		[
			'caption' => "Быстровозводимое строительство",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 4001
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 4002
				],
				[
					'text' => 'Школы',
					'link_id' => 4002
				],
				[
					'text' => 'Детские сады',
					'link_id' => 4003
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 4001
		],
		[
			'caption' => "Промышленное строительство",
			'items' => [
				[
					'text' => 'Дошкольно-образовательные учреждения',
					'link_id' => 0
				],
				[
					'text' => 'Физкультурно-оздорови тельные комплексы',
					'link_id' => 0
				],
				[
					'text' => 'Школы',
					'link_id' => 0
				],
				[
					'text' => 'Детские сады',
					'link_id' => 0
				],
				[
					'text' => 'Больницы',
					'link_id' => 0
				],
			],
			'more_text' => 'Дополнительно',
			'more_link_id' => 4001
		]
	]
];

$o = [
	'class' => '',
	'style' => 'background: url(/img/stroika.jpg) 50% 0%;',
	'title' => 'Наш опыт в цифрах',
	'items' => [
		[	
			'icon' => 'chart1',
			'number' => 7,
			'suffix' => 'Лет',
			'description' => 'Работы на рынке строительных и инженерных работ'
		],
		[
			'icon' => 'home',
			'number' => '45',
			'prefix' => 'Более',
			'description' => 'Объектов построено'
		],
		[
			'icon' => 'globe',
			'number' => 38,
			'prefix' => 'В',
			'description' => 'Городах мы провели строительство'
		],
		[
			'icon' => 'picture',
			'number' => 280983,
			'suffix' => 'м<sup>2</sup>',
			'description' => 'Площадей построено'
		]
	],
	'more_text' => 'Посмотреть опыт',
	'more_link_id' => 4001
];

echo json_encode($o);