--
-- Первичный ввод данных
--

INSERT INTO `configs` (`key`, `value`) VALUES
('title', 'Test Phalcon Site'),
('default_locale', 'RU');

INSERT INTO `locales` (`id`, `prefix`, `title`) VALUES
(101, 'RU', 'Русский'),
(102, 'EN', 'English');

-- хеш пароля 123 = $2y$10$AkpL03ToBXnsdw9bD5YEzOZspSuVEe.iQu3FQSWQt0I0.YlS6Tpu2
INSERT INTO `persons` (`id`, `username`, `email`, `password`, `admin`) VALUES
(1001, 'admin', 'admin@myhost.ru', '$2y$10$AkpL03ToBXnsdw9bD5YEzOZspSuVEe.iQu3FQSWQt0I0.YlS6Tpu2', 1);

--
-- Категории страниц
--

INSERT INTO `page_cats` (`id`, `title`, `parent_id`) VALUES
(2001, 'Страницы сайта', NULL),
(2011, 'О холдинге', 2001),
(2012, 'Структура холдинга', 2001),
(2013, 'Наши проекты', 2001),
(2014, 'Карьера', 2001),
(2015, 'Пресс-центр', 2001),
(2016, 'Контакты', 2001),
(2017, 'Задайте вопрос', 2001),
(2018, 'Стать партнером', 2001);

--
-- Добавление страниц
--

INSERT INTO `pages` (`id`, `title_text_key`, `page_cat_id`, `urn`) VALUES
(3001, 'page#3001.title', 2011, '/'),
(3002, 'page#3002.title', 2011, '/holding'),
(3003, 'page#3003.title', 2011, '/holding/vacancy');

INSERT INTO `locale_texts` (`locale_id`, `key`, `value`) VALUES
(101, 'page#3001.title', 'Главная страница'),
(102, 'page#3001.title', 'Home page'),
(101, 'page#3002.title', 'О компании'),
(102, 'page#3002.title', 'About'),
(101, 'page#3003.title', 'Вакансии'),
(102, 'page#3003.title', 'Work');

--
-- Ссылки
--

INSERT INTO `links` (`id`, `title_text_key`, `page_id`) VALUES
(4001, 'link#4001.title', 3001),
(4002, 'link#4001.title', 3002),
(4003, 'link#4001.title', 3003);

INSERT INTO `locale_texts` (`locale_id`, `key`, `value`) VALUES
(101, 'link#4001.title', 'Главная страница'),
(102, 'link#4001.title', 'Home page'),
(101, 'link#4002.title', 'О компании'),
(102, 'link#4002.title', 'About'),
(101, 'link#4003.title', 'Вакансии'),
(102, 'link#4003.title', 'Work');

--
-- Пункты меню
--

INSERT INTO `menus` (`id`, `parent_id`, `title_text_key`, `link_id`) VALUES
(5001, NULL, 'menu#5001.title', NULL),
	(5010, 5001, 'menu#5010.title', NULL),
		(5011, 5010, 'menu#5011.title', 4002),
		(5012, 5010, 'menu#5012.title', 4003),
	(5020, 5001, 'menu#5020.title', NULL),
	(5030, 5001, 'menu#5030.title', NULL),
	(5040, 5001, 'menu#5040.title', NULL),
	(5050, 5001, 'menu#5050.title', NULL),
	(5060, 5001, 'menu#5060.title', NULL),
	(5070, 5001, 'menu#5070.title', NULL),
	(5080, 5001, 'menu#5080.title', NULL);

INSERT INTO `locale_texts` (`locale_id`, `key`, `value`) VALUES
(101, 'menu#5001.title', 'Главное меню'),
(102, 'menu#5001.title', 'Main menu'),
	(101, 'menu#5010.title', 'О холдинге'),
	(102, 'menu#5010.title', 'About'),
		(101, 'menu#5011.title', 'О холдинге'),
		(102, 'menu#5011.title', 'About'),
		(101, 'menu#5012.title', 'Вакансии'),
		(102, 'menu#5012.title', 'Vacancy'),
	(101, 'menu#5020.title', 'Структура холдинга'),
	(102, 'menu#5020.title', 'Structure'),
	(101, 'menu#5030.title', 'Наши проекты'),
	(102, 'menu#5030.title', 'Projects'),
	(101, 'menu#5040.title', 'Карьера'),
	(102, 'menu#5040.title', 'Carier'),
	(101, 'menu#5050.title', 'Пресс-центр'),
	(102, 'menu#5050.title', 'Press centre'),
	(101, 'menu#5060.title', 'Контакты'),
	(102, 'menu#5060.title', 'Contacts'),
	(101, 'menu#5070.title', 'Задайте вопрос'),
	(102, 'menu#5070.title', 'Your questions'),
	(101, 'menu#5080.title', 'Стать партнером'),
	(102, 'menu#5080.title', 'Partnership');