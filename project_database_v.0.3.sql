-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th3 19, 2022 lúc 08:22 PM
-- Phiên bản máy phục vụ: 10.4.22-MariaDB
-- Phiên bản PHP: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `project_database`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `account`
--

CREATE TABLE `account` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fullname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCard_front` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCard_back` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initialPassword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrongPassCount` int(10) DEFAULT 0,
  `deleted` tinyint(1) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `wallet` int(255) NOT NULL DEFAULT 50000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`email`, `phoneNumber`, `fullname`, `gender`, `address`, `birthday`, `idCard_front`, `idCard_back`, `password`, `initialPassword`, `wrongPassCount`, `deleted`, `active`, `role`, `createdAt`, `updatedAt`, `wallet`) VALUES
('kjnwjnpham@gmail.com', '0399551917', 'pham nguyen hoang quan', 'Male', '793 tran xuan soan tp hcm', '219372831', 'http://localhost/public/assest/img/uploads/26869704dae07148190b_51900419.PNG', 'http://localhost/public/assest/img/uploads/be3b6b583b0048c94d9e_51900419.PNG', '$2y$10$W2D9qWU8XVsfY0XWkt/EnOI0MCAiA8buBqkuqACBlDf5nMZiMBwK2', 'NULL', 0, 0, 0, 'pending', '1647444034', '1647712544', 4750000),
('truonggiangit793@gmail.com', '0702907154', 'Phạm Trường Giang', 'Male', '793/49/3 Trần Xuân Soạn, Tân Hưng, Quận 7, HCM', '986213568000', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', '$2y$10$W2D9qWU8XVsfY0XWkt/EnOI0MCAiA8buBqkuqACBlDf5nMZiMBwK2', 'NULL', 0, 0, 0, 'pending', '1646324757', '1647712544', 5250000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `card`
--

CREATE TABLE `card` (
  `card_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `expiredDay` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cvv` int(255) NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `card`
--

INSERT INTO `card` (`card_id`, `expiredDay`, `cvv`, `description`) VALUES
('111111', '10/10/2022', 411, 'Không giới hạn số lần nạp và số tiền mỗi lần nạp.'),
('222222', '11/11/2022', 443, 'Không giới hạn số lần nạp nhưng chỉ được nạp tối đa 1 triệu/lần.'),
('333333', '12/12/2022', 577, 'Khi nạp bằng thẻ này thì luôn nhận được thông báo là “thẻ hết tiền”.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `transaction`
--

CREATE TABLE `transaction` (
  `transaction_id` int(255) NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneRecipient` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type_transaction` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `value_money` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `costBearer` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `action` int(11) DEFAULT NULL,
  `card_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `email`, `phoneRecipient`, `type_transaction`, `value_money`, `description`, `costBearer`, `createdAt`, `updatedAt`, `action`, `card_id`) VALUES
(186800, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647711031', '1647711016', 1, NULL),
(204883, 'kjnwjnpham@gmail.com', '0702907154', '2', '5000001', 'tranfer for job!', 'sender', '1647623818', '1647623818', 0, NULL),
(282585, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647624095', '1647624095', 1, NULL),
(299896, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647712559', '1647712544', 1, NULL),
(308426, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647709829', '1647709814', 1, NULL),
(342154, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647710311', '1647710296', 1, NULL),
(456896, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647705323', '1647705323', 1, NULL),
(561950, 'kjnwjnpham@gmail.com', NULL, '3', '52500', 'withdraw for job!', NULL, '1647629670', '1647629670', 1, NULL),
(795240, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647711847', '1647711832', 1, NULL),
(798654, 'kjnwjnpham@gmail.com', NULL, '3', '6000000', 'withdraw for job!', NULL, '1647629941', '1647629941', 0, NULL),
(950743, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', NULL, '1647544674', '1647544674', 1, NULL),
(959540, 'kjnwjnpham@gmail.com', NULL, '3', '6300000', 'withdraw for job!', NULL, '1647629799', '1647629799', 0, NULL);

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`email`);

--
-- Chỉ mục cho bảng `card`
--
ALTER TABLE `card`
  ADD PRIMARY KEY (`card_id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_account_email_transaction` (`email`),
  ADD KEY `fk_card_id_transaction` (`card_id`);

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_account_email_transaction` FOREIGN KEY (`email`) REFERENCES `account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
