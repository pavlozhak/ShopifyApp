
-- --------------------------------------------------------

--
-- Структура таблиці `collections`
--

CREATE TABLE `collections` (
  `id` int(10) NOT NULL,
  `collection_id` bigint(10) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Дамп даних таблиці `collections`
--

INSERT INTO `collections` (`id`, `collection_id`, `title`, `description`) VALUES
(1, 60705702006, 'AMD Pack', 'Рекомендовані товари підбираются на основі сумісності з процесорами AMD'),
(2, 60698427510, 'CPU', 'Нові продукти від провідних копманій в області мікророцесорних технологій'),
(3, 60705898614, 'Intel Pack', 'Рекомендовані товари підбираются на основі сумісності з процесорами Intel');
