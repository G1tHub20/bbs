-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- ホスト: 127.0.0.1
-- 生成日時: 2022-02-05 04:45:11
-- サーバのバージョン： 8.0.22
-- PHP のバージョン: 8.0.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `min_bbs`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int NOT NULL,
  `name` text NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `picture` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `created`, `modified`) VALUES
(1, 'カートマン', 'techpit_user', 'password123', '20220125234235_butterfly.jpg', '2022-01-25 22:42:43', '2022-01-25 22:42:43'),
(7, 'Elic', 'yahoomail', '$2y$10$z87FEl3a3vYgAI9K9A565.yjUN1HpAhz/fZ/RiKx75jhK/UQnDNcC', '', '2022-01-30 12:45:36', '2022-01-30 12:45:36'),
(8, 'aoshi', 'a6m2cy', '$2y$10$Q998mmCIClaSXMIXMVoJaOd/WCdkjoxYekDt9d1ZwiZ5WO6o64Dau', '', '2022-02-05 00:09:09', '2022-02-05 00:09:09'),
(9, 'おっぷ', 'opp@', '$2y$10$UpXddN6Fp5EOtCvXBEOLX.GCWG.M3UWTu6yyWqk5ezBGDExv4YwDC', '20220205022427_cpp00246946s.jpg', '2022-02-05 01:26:35', '2022-02-05 01:26:35');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int NOT NULL,
  `message` text NOT NULL,
  `member_id` int NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `created`, `modified`) VALUES
(1, 'こんにちは', 7, '2022-02-05 09:29:51', '2022-02-05 00:29:51'),
(3, 'よろしく', 7, '2022-02-05 09:30:39', '2022-02-05 00:30:39'),
(6, 'I am Opp', 9, '2022-02-05 10:27:05', '2022-02-05 01:27:05');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルの AUTO_INCREMENT
--

--
-- テーブルの AUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- テーブルの AUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
