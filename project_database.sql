-- phpMyAdmin SQL Dump
-- version 5.1.3
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 14, 2022 lúc 06:00 PM
-- Phiên bản máy phục vụ: 10.4.24-MariaDB
-- Phiên bản PHP: 7.4.28

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
  `gender` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCard_front` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `idCard_back` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `initialPassword` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `wrongPassCount` int(10) DEFAULT 0,
  `active` tinyint(1) DEFAULT 0,
  `role` varchar(255) COLLATE utf8_unicode_ci DEFAULT 'pending',
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT '0',
  `wallet` int(255) NOT NULL DEFAULT 50000
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `account`
--

INSERT INTO `account` (`email`, `phoneNumber`, `fullname`, `gender`, `address`, `birthday`, `idCard_front`, `idCard_back`, `password`, `initialPassword`, `wrongPassCount`, `active`, `role`, `createdAt`, `updatedAt`, `wallet`) VALUES
('kjnwjnpham@gmail.com', '0399551917', 'pham nguyen hoang quan', 'Male', '793 tran xuan soan tp hcm', '219372831', 'http://localhost/public/assest/img/uploads/26869704dae07148190b_51900419.PNG', 'http://localhost/public/assest/img/uploads/be3b6b583b0048c94d9e_51900419.PNG', '$2y$10$W2D9qWU8XVsfY0XWkt/EnOI0MCAiA8buBqkuqACBlDf5nMZiMBwK2', 'NULL', 0, 0, 'actived', '1647444034', '1649229105', 20000002),
('phamnguyenhoang.quan.1412@gmail.com', '0948995290', 'pham van hoang', 'Female', 'tp hcm,vie nam', '1638378000', 'http://localhost/public/assest/img/uploads/a271f04d54d2d66597c6_Swanky%20Robo.png', 'http://localhost/public/assest/img/uploads/96628c9ce5ce6133091a_Swanky%20Robo.png', '$2y$10$9e7Koru1RPc7vHtUNCpUAeZTGUpZieB6Hv6/371a45JSuX.6qvydK', 'NULL', 3, 0, 'pending', '1649091758', '1649229041', 50000),
('test.mytest.user@gmail.com', '0702907154', 'Phạm Trường Giang', 'Male', '793/49/3 Trần Xuân Soạn, Tân Hưng, Quận 7, HCM', '986213568000', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', 'http://localhost/public/assest/img/uploads/bf2fb4c8ff7e99592437_AnyConv.com%2032690b7c2eb039d076c73cadaeb27a8c.png', '$2y$10$W2D9qWU8XVsfY0XWkt/EnOI0MCAiA8buBqkuqACBlDf5nMZiMBwK2', 'NULL', 0, 0, 'pending', '1646324757', '1648636754', 4750001);

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
-- Cấu trúc bảng cho bảng `phonecard`
--

CREATE TABLE `phonecard` (
  `phoneCard_id` int(255) NOT NULL,
  `transaction_id` int(255) NOT NULL,
  `mno` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `phoneCardType` int(255) NOT NULL,
  `amount` int(255) NOT NULL,
  `createdAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `updatedAt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `phonecard`
--

INSERT INTO `phonecard` (`phoneCard_id`, `transaction_id`, `mno`, `phoneCardType`, `amount`, `createdAt`, `updatedAt`) VALUES
(1111142062, 238623, 'viettel', 10000, 1, '1647722697', '1647722697');

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
  `action` int(11) DEFAULT 1,
  `card_id` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Đang đổ dữ liệu cho bảng `transaction`
--

INSERT INTO `transaction` (`transaction_id`, `email`, `phoneRecipient`, `type_transaction`, `value_money`, `description`, `costBearer`, `createdAt`, `updatedAt`, `action`, `card_id`) VALUES
(94574, 'kjnwjnpham@gmail.com', NULL, '1', '5000001', NULL, NULL, '1648749130', '1648749130', 1, '111111'),
(186800, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647711031', '1647711016', 1, NULL),
(204883, 'kjnwjnpham@gmail.com', '0702907154', '2', '5000001', 'tranfer for job!', 'recipient', '1647623818', '1648636754', 1, NULL),
(238623, 'kjnwjnpham@gmail.com', NULL, '4', '10000', NULL, NULL, '1647722697', '1647722697', 1, NULL),
(282585, 'kjnwjnpham@gmail.com', '0702907154', '2', '5000001', 'tranfer for job!', 'sender', '1647624095', '1648667262', 2, NULL),
(299896, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647712559', '1647712544', 1, NULL),
(308426, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647709829', '1647709814', 1, NULL),
(342154, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647710311', '1647710296', 1, NULL),
(456896, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647705323', '1647705323', 1, NULL),
(561950, 'kjnwjnpham@gmail.com', NULL, '3', '52500', 'withdraw for job!', NULL, '1647629670', '1648494204', 0, NULL),
(795240, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', 'sender', '1647711847', '1647711832', 1, NULL),
(798654, 'kjnwjnpham@gmail.com', NULL, '3', '6000000', 'withdraw for job!', NULL, '1647629941', '1648547020', 0, NULL),
(950743, 'kjnwjnpham@gmail.com', '0702907154', '2', '1000000', 'tranfer for job!', NULL, '1647544674', '1648494233', 0, NULL),
(959540, 'kjnwjnpham@gmail.com', NULL, '3', '1000000', 'withdraw for job!', NULL, '1647629799', '1648490674', 0, NULL);

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
-- Chỉ mục cho bảng `phonecard`
--
ALTER TABLE `phonecard`
  ADD PRIMARY KEY (`phoneCard_id`),
  ADD KEY `fk_transaction_id_phonecard` (`transaction_id`);

--
-- Chỉ mục cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_account_email_transaction` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `phonecard`
--
ALTER TABLE `phonecard`
  MODIFY `phoneCard_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1111142063;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `phonecard`
--
ALTER TABLE `phonecard`
  ADD CONSTRAINT `fk_transaction_id_phonecard` FOREIGN KEY (`transaction_id`) REFERENCES `transaction` (`transaction_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Các ràng buộc cho bảng `transaction`
--
ALTER TABLE `transaction`
  ADD CONSTRAINT `fk_account_email_transaction` FOREIGN KEY (`email`) REFERENCES `account` (`email`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
