-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Lis 2020, 19:38
-- Wersja serwera: 10.4.11-MariaDB
-- Wersja PHP: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `medium_strumieniowe`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `albums`
--

CREATE TABLE `albums` (
  `idalbums` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `likes` int(11) DEFAULT 0,
  `describe` varchar(400) DEFAULT NULL,
  `genre` varchar(45) DEFAULT NULL,
  `cover` int(11) DEFAULT NULL,
  `author` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `albums`
--

INSERT INTO `albums` (`idalbums`, `title`, `likes`, `describe`, `genre`, `cover`, `author`, `created_at`) VALUES
(1, 'Under Construction', 0, NULL, 'Rock', 4, 1, '2020-10-29 13:49:56'),
(10, 'EKT- Najlepsze Shanty', 0, NULL, 'Szanty', 1, 1, '2020-10-29 13:49:56');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `comments`
--

CREATE TABLE `comments` (
  `idcomments` int(11) NOT NULL,
  `content` varchar(400) NOT NULL,
  `song` int(11) NOT NULL,
  `author` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `covers`
--

CREATE TABLE `covers` (
  `idcovers` int(11) NOT NULL,
  `source` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `covers`
--

INSERT INTO `covers` (`idcovers`, `source`) VALUES
(1, 'img/nullcover.png'),
(4, '../storage/app/uploads/covers/1/undercon4.jpg'),
(14, '../storage/app/uploads/covers/1/11592159209.jpg'),
(19, '../storage/app/uploads/covers/1/11603045004.jpg'),
(20, '../storage/app/uploads/covers/1/11605136746.jpg'),
(21, '../storage/app/uploads/covers/1/11605136795.jpg');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `likes`
--

CREATE TABLE `likes` (
  `likeId` int(15) NOT NULL,
  `userId` int(11) NOT NULL,
  `songId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `likes`
--

INSERT INTO `likes` (`likeId`, `userId`, `songId`) VALUES
(114, 1, 75),
(116, 1, 63);

--
-- Wyzwalacze `likes`
--
DELIMITER $$
CREATE TRIGGER `Add_like` AFTER INSERT ON `likes` FOR EACH ROW UPDATE `songs` SET `likes` = `likes` + 1 WHERE `songs`.idsongs = NEW.songId
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `idmessages` int(11) NOT NULL,
  `sender` int(11) NOT NULL,
  `reciver` int(11) NOT NULL,
  `messagetext` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `isviewed` bit(1) DEFAULT b'0',
  `added` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`idmessages`, `sender`, `reciver`, `messagetext`, `isviewed`, `added`) VALUES
(50, 1, 1, 'Zapisz sobie', b'1', '2020-11-19 12:32:25'),
(51, 1, 1, 'Lol', b'1', '2020-11-19 12:35:18'),
(52, 3, 1, 'Hello\nTest', b'1', '2020-11-19 16:06:21'),
(53, 3, 1, 'TESTTEST', b'1', '2020-11-19 16:06:44'),
(54, 1, 1, 'Napisz', b'1', '2020-11-19 16:11:06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Zrzut danych tabeli `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('konrad.mazur97@wp.pl', '$2y$10$0bE2.ra1f//bGoUHqxgsMuKyk.PMGDi89Av0/Qs7bbRHm5.aXmxVi', '2020-11-11 16:20:14');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `playlists`
--

CREATE TABLE `playlists` (
  `idplaylists` int(11) NOT NULL,
  `playlistName` varchar(45) DEFAULT NULL,
  `author` int(11) DEFAULT NULL,
  `ispublic` bit(1) DEFAULT b'1',
  `likes` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='		';

--
-- Zrzut danych tabeli `playlists`
--

INSERT INTO `playlists` (`idplaylists`, `playlistName`, `author`, `ispublic`, `likes`) VALUES
(1, 'Rock alternatywny', 1, b'0', 0),
(88, 'Dupaa', 1, b'1', 0),
(89, 'Rock', 3, b'1', 0),
(90, 'Tak', 1, b'1', 0),
(91, 'Tak', 1, b'1', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `songs`
--

CREATE TABLE `songs` (
  `idsongs` int(11) NOT NULL,
  `source` varchar(255) NOT NULL,
  `title` varchar(45) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `author` int(11) NOT NULL,
  `album` int(11) DEFAULT NULL,
  `genre` varchar(45) DEFAULT NULL,
  `feat` varchar(45) DEFAULT NULL,
  `likes` int(11) DEFAULT 0,
  `license` varchar(250) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `cover` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `songs`
--

INSERT INTO `songs` (`idsongs`, `source`, `title`, `author`, `album`, `genre`, `feat`, `likes`, `license`, `created_at`, `cover`) VALUES
(34, '../storage/app/uploads/1/11592153461.mp3', 'Another brick in the wall', 1, 1, 'Rock', NULL, 0, NULL, NULL, 4),
(63, '../storage/app/uploads/1/11592218721.mp3', 'Happiest Days of Our Lives', 1, 1, 'Rock', NULL, 1, NULL, NULL, 4),
(65, '../storage/app/uploads/1/11592326179.mp3', 'Is there Anybody Out There', 1, 1, NULL, NULL, 0, NULL, '2020-06-16 16:49:39', 4),
(66, '../storage/app/uploads/1/11602775483.mp3', 'The trial', 1, 1, 'Rock', NULL, 0, NULL, '2020-10-15 15:24:43', 4),
(67, '../storage/app/uploads/1/11602776831.mp3', 'Test', 1, 1, NULL, NULL, 0, NULL, '2020-10-15 15:47:11', 4),
(70, '../storage/app/uploads/1/11603618549.mp3', 'Bijatyka', 1, 10, NULL, 'EKT', 0, NULL, '2020-10-25 11:30:45', 1),
(74, '../storage/app/uploads/1/11605136746.mp3', 'Test', 1, 1, NULL, NULL, 0, NULL, '2020-11-11 23:19:06', 1);

--
-- Wyzwalacze `songs`
--
DELIMITER $$
CREATE TRIGGER `SignCoversToSongs` BEFORE INSERT ON `songs` FOR EACH ROW IF NEW.album IS NOT NULL AND NEW.cover IS NULL
	THEN
    SET NEW.cover = (SELECT a.cover from albums a where idalbums = NEW.album);
END IF
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `songs_in_playlists`
--

CREATE TABLE `songs_in_playlists` (
  `song` int(11) NOT NULL,
  `playlist` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `songs_in_playlists`
--

INSERT INTO `songs_in_playlists` (`song`, `playlist`) VALUES
(65, 88),
(74, 1),
(75, 1),
(89, 88);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `Admin` bit(1) DEFAULT NULL,
  `username` varchar(45) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `country` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `songs` int(11) DEFAULT 0,
  `followers` int(11) DEFAULT 0,
  `following` int(11) DEFAULT 0,
  `name` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT 'uploads/avatars/default.jpg',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `last_song` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `Admin`, `username`, `password`, `country`, `email`, `songs`, `followers`, `following`, `name`, `avatar`, `created_at`, `updated_at`, `remember_token`, `last_song`) VALUES
(1, NULL, NULL, '$2y$10$YlfPDrmzL7WluRNwHpSBmeSgII7.kbjkOjR0kO4uscBG2sDe2YIwG', NULL, 'konrad.mazur97@wp.pl', 0, 2, 2, 'Konrad Mazur', '../storage/app/uploads/avatars/1/11603927801jpg', '2020-06-13 17:33:59', '2020-10-28 22:30:01', 'Rca4kGIeIRnVhIOXZLaOey4Xdg5nzxP01Eld0kWp3TKiaxlXZcd2xGTu6dVX', NULL),
(3, NULL, NULL, '$2y$10$HjPL.rvlcpEUXhbPfigF/.pwWpzVYe73.eYmT6Tc2mf0LHotppCN2', NULL, 'fazi230@wp.pl', 0, 1, 1, 'Maks Mazur', '../storage/app/uploads/avatars/3/31603964721jpg', '2020-10-28 19:03:44', '2020-10-29 08:45:22', NULL, NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `user_follows`
--

CREATE TABLE `user_follows` (
  `follower` int(11) NOT NULL,
  `follows` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Zrzut danych tabeli `user_follows`
--

INSERT INTO `user_follows` (`follower`, `follows`) VALUES
(1, 1),
(1, 3),
(3, 1);

--
-- Wyzwalacze `user_follows`
--
DELIMITER $$
CREATE TRIGGER `AddFollowers` BEFORE INSERT ON `user_follows` FOR EACH ROW UPDATE `users` SET `followers` = `followers` + 1 WHERE `users`.id = NEW.follows
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `AddFollowing` BEFORE INSERT ON `user_follows` FOR EACH ROW UPDATE `users`
SET `following` = `following` + 1 
WHERE `users`.id = NEW.follower
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RemoveFollowers` BEFORE DELETE ON `user_follows` FOR EACH ROW UPDATE `users` SET `followers` = `followers` - 1 WHERE `users`.id = old.follows
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `RemoveFollowing` BEFORE DELETE ON `user_follows` FOR EACH ROW UPDATE `users`
SET `following` = `following` - 1 
WHERE `users`.id = old.follower
$$
DELIMITER ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`idalbums`,`author`) USING BTREE,
  ADD KEY `fk_albums_users1_idx` (`author`),
  ADD KEY `fk_albums_covers1_idx` (`cover`);

--
-- Indeksy dla tabeli `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`idcomments`,`song`,`author`),
  ADD UNIQUE KEY `idcomments_UNIQUE` (`idcomments`),
  ADD KEY `fk_comments_songs1_idx` (`song`),
  ADD KEY `fk_comments_users1_idx` (`author`);

--
-- Indeksy dla tabeli `covers`
--
ALTER TABLE `covers`
  ADD PRIMARY KEY (`idcovers`),
  ADD UNIQUE KEY `idcovers_UNIQUE` (`idcovers`);

--
-- Indeksy dla tabeli `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`likeId`),
  ADD KEY `userId` (`userId`),
  ADD KEY `songId` (`songId`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`idmessages`);

--
-- Indeksy dla tabeli `playlists`
--
ALTER TABLE `playlists`
  ADD PRIMARY KEY (`idplaylists`),
  ADD UNIQUE KEY `idplaylist_UNIQUE` (`idplaylists`);

--
-- Indeksy dla tabeli `songs`
--
ALTER TABLE `songs`
  ADD PRIMARY KEY (`idsongs`),
  ADD UNIQUE KEY `idsongs_UNIQUE` (`idsongs`);

--
-- Indeksy dla tabeli `songs_in_playlists`
--
ALTER TABLE `songs_in_playlists`
  ADD PRIMARY KEY (`song`,`playlist`),
  ADD KEY `fk_songs_has_playlists_playlists1_idx` (`playlist`),
  ADD KEY `fk_songs_has_playlists_songs1_idx` (`song`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `idusers_UNIQUE` (`id`);

--
-- Indeksy dla tabeli `user_follows`
--
ALTER TABLE `user_follows`
  ADD PRIMARY KEY (`follower`,`follows`),
  ADD KEY `fk_users_has_users_users2_idx` (`follows`),
  ADD KEY `fk_users_has_users_users1_idx` (`follower`);

--
-- AUTO_INCREMENT dla tabel zrzutów
--

--
-- AUTO_INCREMENT dla tabeli `albums`
--
ALTER TABLE `albums`
  MODIFY `idalbums` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT dla tabeli `covers`
--
ALTER TABLE `covers`
  MODIFY `idcovers` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT dla tabeli `likes`
--
ALTER TABLE `likes`
  MODIFY `likeId` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=117;

--
-- AUTO_INCREMENT dla tabeli `messages`
--
ALTER TABLE `messages`
  MODIFY `idmessages` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT dla tabeli `playlists`
--
ALTER TABLE `playlists`
  MODIFY `idplaylists` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- AUTO_INCREMENT dla tabeli `songs`
--
ALTER TABLE `songs`
  MODIFY `idsongs` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT dla tabeli `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
