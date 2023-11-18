-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th10 18, 2023 lúc 05:01 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `moviebooking`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_active` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`, `is_active`) VALUES
(1, 'admin', 'admin', '$2y$10$dbRt7igECNTReORritCCQeLdb2EBny5cnOF24LnwHtHkU1x5M6frK', b'1');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `booking`
--

CREATE TABLE `booking` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `seats` varchar(50) NOT NULL,
  `total_seats` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `showtime_id` int(11) NOT NULL,
  `total_price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `booking`
--

INSERT INTO `booking` (`id`, `user_id`, `seats`, `total_seats`, `booking_date`, `showtime_id`, `total_price`) VALUES
(16, 2, 'B1,B2', 2, '2023-11-17', 15, '800.00'),
(18, 2, 'C4,D1', 2, '2023-11-17', 15, '800.00'),
(35, 2, 'B4,F4', 2, '2023-11-17', 13, '400.00'),
(40, 2, 'F1', 1, '2023-11-17', 15, '400.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `message` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`id`, `name`, `email`, `message`) VALUES
(1, 'testuser', 'testuser@gmail.com', 'test');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `genre_name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `genre`
--

INSERT INTO `genre` (`id`, `genre_name`) VALUES
(1, 'Science'),
(2, 'Adventure '),
(3, 'Drama'),
(4, ' Historical'),
(5, 'Comedy'),
(6, 'Action'),
(7, 'Biographical War');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `movies`
--

CREATE TABLE `movies` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL DEFAULT '0',
  `director` varchar(100) NOT NULL DEFAULT '0',
  `release_date` date NOT NULL,
  `genre_id` int(11) NOT NULL DEFAULT 0,
  `language` varchar(100) NOT NULL DEFAULT '0',
  `trailer_link` varchar(255) NOT NULL DEFAULT '0',
  `description` varchar(300) NOT NULL DEFAULT '0',
  `image` varchar(100) NOT NULL DEFAULT '0',
  `status` int(11) NOT NULL DEFAULT 0,
  `running` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `movies`
--

INSERT INTO `movies` (`id`, `title`, `director`, `release_date`, `genre_id`, `language`, `trailer_link`, `description`, `image`, `status`, `running`) VALUES
(1, 'Black Panther: Wakanda Forever', 'Kevin Feige', '2020-11-11', 2, 'English', 'https://www.youtube.com/embed/RlOB3UALvrQ', 'Queen Ramonda, Shuri, M\'Baku, Okoye and the Dora Milaje fight to protect their nation from intervening world powers in the wake of King T\'Challa\'s death. As the Wakandans strive to embrace their next chapter, the heroes must band together with Nakia and Everett Ross to forge a new path for their bel', 'Wankanda.jpg', 1, 1),
(2, 'Avengers', 'Kevin Feige', '2012-04-11', 1, 'English', 'https://www.youtube.com/embed/eOrNdBpGMv8', 'The Avengers began as a group of extraordinary individuals who were assembled to defeat Loki and his Chitauri army in New York City. Since then, the team has expanded its roster and faced a host of new threats, while dealing with their own turmoil.', 'aven.jpg', 1, 1),
(4, 'Playing With Fire ', 'Andrea Sedlackova', '2019-11-06', 5, 'English', 'https://www.youtube.com/embed/fd5GlZUpfaM', ' Playing with Fire is a 2019 American family comedy film directed by Andy Fickman from a screenplay by Dan Ewen and Matt Lieberman based on a story by Ewen. The film stars John Cena, Keegan-Michael Key, John Leguizamo, Dennis Haysbert, Brianna Hildebrand and Judy Greer, and follows a ', 'movieposter_en.jpg', 1, 1),
(5, 'Black Adam', 'Warner Bros', '2020-10-03', 4, 'English', 'https://www.youtube.com/embed/Fva_W_AF0IM?si=PhwudSNX7azpd_1Y', 'Black Adam was originally depicted as a supervillain and the ancient magical champion predecessor of Captain Marvel, who fought his way to modern times to challenge the hero and his Marvel Family associates.', 'blackadam.jpg', 1, 1),
(6, 'Spider-Man: No Way Home', 'Jon Watts', '2021-12-17', 6, 'English', 'https://www.youtube.com/embed/JfVOs4VSpmA?si=g7oPJhyfn9g2ZHFt', 'With Spider-Mans identity now revealed, Peter asks Doctor Strange for help. When a spell goes wrong, dangerous foes from other worlds start to appear, forcing Peter to discover what it truly means to be Spider-Man.', 'spiderman.jpg', 1, 1),
(7, 'Ant-Man and the Wasp: Quantumania', 'Peyton Reed', '2023-05-16', 7, 'English', 'https://www.youtube.com/embed/ZlNFpri-Y40?si=40E7qGgvqqPKTzaJ', 'The movie will see super-hero couple Scott Lang (Paul Rudd) and Hope van Dyne (Evangeline Lilly) reprise their roles as Ant-Man and the Wasp. They are joined by Michael Douglas and Michelle Pfeiffer, who return as Hopes parents, Hank Pym and Janet van Dyne. Kathryn Newton joins the cast as Cassie La', 'nguoikien.jpg', 1, 1),
(8, 'Aquaman and the Lost Kingdom', 'DC Studios', '2023-12-22', 1, 'Test', 'https://www.youtube.com/embed/FV3bqvOHRQo?si=jloFhthFfHm1a9Ek', 'Aquaman and the Lost Kingdom is the much-anticipated sequel to 2018s Aquaman. It will once again be directed by James Wan, but well have to wait just that little bit longer to see it on our screens.', 'aquaman.jpg', 1, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `screens`
--

CREATE TABLE `screens` (
  `id` tinyint(4) NOT NULL,
  `theater_id` tinyint(4) NOT NULL DEFAULT 0,
  `screen_name` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `screens`
--

INSERT INTO `screens` (`id`, `theater_id`, `screen_name`) VALUES
(1, 1, '2D Phụ Đề'),
(2, 1, '3D Phụ Đề'),
(3, 2, '2D Phụ Đề'),
(4, 2, '3D Phụ Đề');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `showtimes`
--

CREATE TABLE `showtimes` (
  `id` int(11) NOT NULL,
  `movie_id` int(11) NOT NULL,
  `theater_id` tinyint(4) NOT NULL,
  `screen_id` tinyint(4) NOT NULL,
  `showtime` datetime NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Đang đổ dữ liệu cho bảng `showtimes`
--

INSERT INTO `showtimes` (`id`, `movie_id`, `theater_id`, `screen_id`, `showtime`, `price`) VALUES
(13, 1, 1, 1, '2023-11-18 20:14:00', '200.00'),
(14, 2, 1, 2, '2023-11-18 20:20:00', '300.00'),
(15, 1, 2, 3, '2023-11-19 20:20:00', '400.00'),
(16, 1, 1, 2, '2023-11-18 20:20:00', '500.00'),
(17, 1, 1, 1, '2023-11-18 22:21:00', '300.00'),
(20, 1, 1, 1, '2023-11-19 20:42:00', '10.00'),
(21, 1, 1, 2, '2023-11-19 21:42:00', '10.00'),
(22, 1, 1, 2, '2023-11-19 21:43:00', '20.00'),
(23, 1, 2, 3, '2023-11-19 22:35:00', '100.00'),
(24, 1, 1, 1, '2023-11-19 22:42:00', '100.00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `theaters`
--

CREATE TABLE `theaters` (
  `id` tinyint(4) NOT NULL,
  `theater_name` varchar(50) DEFAULT NULL,
  `theater_address` varchar(100) DEFAULT NULL,
  `theater_phone` varchar(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `theaters`
--

INSERT INTO `theaters` (`id`, `theater_name`, `theater_address`, `theater_phone`) VALUES
(1, 'AZIR 2D', 'Nha Trang', '0123456789'),
(2, 'AZID 3D', 'Nha Trang', '0928282828');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `birthday` varchar(50) NOT NULL,
  `image` varchar(100) NOT NULL,
  `gender` bit(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `password`, `phone`, `birthday`, `image`, `gender`) VALUES
(2, 'testuser', 'test', 'test@gmail.com', '$2y$10$hqww.h10Dr9eXxvNCWxY9uwo4NsbvUIPkeRLA75KEJURr1qCKqf1K', '1293132232', '2023-11-16', 'avatar-uid-2.jpg', b'1'),
(16, 'testuser3', 'Jin Pham', 'user@demo.com', '$2y$10$YH5hyQiGt6nfrd18SHNvQeYrF3jkJl1yv/qVu5asvhHH5P7pc4Qc6', '0929322222', '2023-11-17', 'avatar-uid-16.jpg', b'0'),
(17, 'testuser6', 'Test Admin', 'test@gmail.com', '$2y$10$DqIMEqyK0Frs8RFEer9Zqe/VJsSXzbsxp4bXp.I/DXnyB6.S4A1Km', '0928282828', '2023-11-17', 'avatar-uid-17.jpg', b'0'),
(18, 'testuser7', 'Test Admin', 'test@gmail.com', '$2y$10$w5kgwrR7EnJR.gOP3C1RuOWcRPdU6KVRF0MOCXviCtWoLe.2YNH5q', '0928282828', '2023-11-17', 'avatar-uid-18.jpeg', b'0');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`);

--
-- Chỉ mục cho bảng `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `seats` (`seats`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `showtime_id` (`showtime_id`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD KEY `genre_id` (`genre_id`);

--
-- Chỉ mục cho bảng `screens`
--
ALTER TABLE `screens`
  ADD PRIMARY KEY (`id`,`theater_id`) USING BTREE,
  ADD KEY `theater_id` (`theater_id`),
  ADD KEY `id` (`id`);

--
-- Chỉ mục cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `movie_id` (`movie_id`),
  ADD KEY `threater_id` (`theater_id`),
  ADD KEY `screen_id` (`screen_id`);

--
-- Chỉ mục cho bảng `theaters`
--
ALTER TABLE `theaters`
  ADD PRIMARY KEY (`id`) USING BTREE;

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`) USING BTREE,
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `booking`
--
ALTER TABLE `booking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `movies`
--
ALTER TABLE `movies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `screens`
--
ALTER TABLE `screens`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT cho bảng `theaters`
--
ALTER TABLE `theaters`
  MODIFY `id` tinyint(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`showtime_id`) REFERENCES `showtimes` (`id`);

--
-- Các ràng buộc cho bảng `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `movies_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`);

--
-- Các ràng buộc cho bảng `screens`
--
ALTER TABLE `screens`
  ADD CONSTRAINT `screens_ibfk_1` FOREIGN KEY (`theater_id`) REFERENCES `theaters` (`id`);

--
-- Các ràng buộc cho bảng `showtimes`
--
ALTER TABLE `showtimes`
  ADD CONSTRAINT `showtimes_ibfk_1` FOREIGN KEY (`movie_id`) REFERENCES `movies` (`id`),
  ADD CONSTRAINT `showtimes_ibfk_2` FOREIGN KEY (`theater_id`) REFERENCES `theaters` (`id`),
  ADD CONSTRAINT `showtimes_ibfk_3` FOREIGN KEY (`screen_id`) REFERENCES `screens` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
