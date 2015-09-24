INSERT INTO `page_blocks` (`page_id`, `module`, `title_text_key`, `content_text_key`) VALUES
(3001, 'PageGenerator/DropDownMenu', 'page.block#3001-1.title', 'page.block#3001-1.content'),
(3001, 'PageGenerator/NumbersInfo', 'page.block#3001-2.title', 'page.block#3001-2.content');

INSERT INTO `locale_texts` (`locale_id`, `key`, `value`) VALUES
(101, 'page.block#3001-1.title', 'Менюшка с домиками'),
(102, 'page.block#3001-1.title', 'Menushka s domikami'),
(101, 'page.block#3001-2.title', 'Наш опыт в цифрах'),
(102, 'page.block#3001-2.title', 'Nash opyt v cifrah'),

(101, 'page.block#3001-1.content', '{class:"",style:"background: url(/img/stroika.jpg) 50% 50%;",title:"ООО СК ГЕНСТРОЙУРАЛ -<br/>Комплексный подход к строительству!",items:{{title:"Малоэтажное строительство",list:{}},{title:"Социальное строительство",list:{}},{title:"Коммерческое строительство",list:{}},{title:"Увеличение площади",list:{}},{title:"Быстровозводимое строительство",list:{}},{title:"Промышленное строительство",list:{}}}}'),
(102, 'page.block#3001-1.content', '{}'),
(101, 'page.block#3001-2.content', '{class:"",style:"background: url(/img/stroika.jpg) 50% 50%;",title:"Наш опыт в цифрах",items:{{icon:"key",number:7,suffix:"Лет",description:"Работы на рынке строительных и инженерных работ"},{icon:"time_house",number:45,prefix:"Более",text:"Объектов построено"},{icon:"map_point",number:38,prefix:"В",text:"Городах мы провели строительство"},{icon:"blueprint",number:280983,suffix:"м<sup>2</sup>",text:"Площадей построено"}}}'),
(102, 'page.block#3001-2.content', '{}');