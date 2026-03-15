-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: localhost
-- Thời gian đã tạo: Th6 24, 2025 lúc 01:59 PM
-- Phiên bản máy phục vụ: 10.6.17-MariaDB-cll-lve-log
-- Phiên bản PHP: 8.2.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `tvtumnvlhosting_canhanhoa`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `achievements`
--

CREATE TABLE `achievements` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `organization` varchar(200) DEFAULT NULL,
  `year` int(11) DEFAULT NULL,
  `article_link` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `achievements`
--

INSERT INTO `achievements` (`id`, `title`, `organization`, `year`, `article_link`) VALUES
(3, 'Giải Nhất cuộc thi Khoa học - Kỹ thuật và ngày hội STEM tỉnh Đồng Tháp', 'Bộ Giáo dục và Đào tạo tỉnh Đồng Tháp', 2019, 'http://thpttramchimdt.edu.vn/tin-tuc/ket-qua-cuoc-thi-khoa-hoc-ky-thuat-va-ngay-hoi-stem-tinh-don.html');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `certificates`
--

CREATE TABLE `certificates` (
  `id` int(11) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `organization` varchar(200) DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `credential_id` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `certificates`
--

INSERT INTO `certificates` (`id`, `title`, `organization`, `issue_date`, `expiry_date`, `credential_id`) VALUES
(1, 'Kỹ thuật sửa chữa, cài đặt và lắp ráp máy tính', 'UNESCO & Trường Cao đẳng Cộng đồng Đồng Tháp ', '2024-07-21', NULL, '118/2024/LRCĐMT-K24');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `document_links`
--

CREATE TABLE `document_links` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `url` varchar(500) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `category` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `document_links`
--

INSERT INTO `document_links` (`id`, `name`, `url`, `icon`, `description`, `category`) VALUES
(2, 'Drive của hai772038', 'https://drive.google.com/drive/u/0/home', 'fab fa-google-drive', 'lưu bài', 'File'),
(4, 'Drive của rikakinguyen2004@gmail.com', 'https://drive.google.com/drive/u/1/my-drive', 'fab fa-google-drive', 'lưu bài thôi', 'File');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `education`
--

CREATE TABLE `education` (
  `id` int(11) NOT NULL,
  `school` varchar(200) DEFAULT NULL,
  `degree` varchar(200) DEFAULT NULL,
  `start_year` int(11) DEFAULT NULL,
  `end_year` int(11) DEFAULT NULL,
  `gpa` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `education`
--

INSERT INTO `education` (`id`, `school`, `degree`, `start_year`, `end_year`, `gpa`) VALUES
(1, 'Trường Trung Học Phổ Thông Tràm Chim', 'Cấp 3', 2019, 2022, 3.8),
(3, 'Trường Cao đẳng Cộng đồng Đồng Tháp', 'Kỹ sư Công nghệ thông tin', 2022, 2025, 3.8),
(10, 'Trường Đại Học Cần Thơ', 'Cử nhân Công nghệ thông tin', 2025, 2027, 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `experience`
--

CREATE TABLE `experience` (
  `id` int(11) NOT NULL,
  `company` varchar(200) DEFAULT NULL,
  `position` varchar(200) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_current` tinyint(1) DEFAULT NULL,
  `responsibilities` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `experience`
--

INSERT INTO `experience` (`id`, `company`, `position`, `start_date`, `end_date`, `is_current`, `responsibilities`) VALUES
(1, 'Thực tập sinh tại Trường Cao đẳng Cộng đồng Đồng Tháp', 'Fullstack Developer', '2024-11-21', '2024-12-22', 0, 'Phân tích yêu cầu, thiết kế giao diện (UI/UX) và phát triển toàn bộ hệ thống website thương mại điện tử. Đảm nhiệm front-end (HTML, CSS, Bootstrap, JavaScript), back-end (PHP/Laravel) và cơ sở dữ liệu (MySQL). Triển khai chức năng quản lý sản phẩm, giỏ hàng, thanh toán online và tối ưu website đảm bảo bảo mật và hiệu suất.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `personal_info`
--

CREATE TABLE `personal_info` (
  `id` int(11) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `name` varchar(100) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `dob` date DEFAULT NULL,
  `github` varchar(100) DEFAULT NULL,
  `linkedin` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `personal_info`
--

INSERT INTO `personal_info` (`id`, `avatar`, `name`, `title`, `email`, `phone`, `location`, `dob`, `github`, `linkedin`) VALUES
(1, '6761248473962.jpg', 'Nguyễn Văn Ngọc Hãi', 'Kỹ sư công nghệ thông tin', 'hai772038@gmail.com', '0967326154', 'Tam Nông, Đồng Tháp, Việt Nam', '2004-08-10', 'github.com/nvnh2399', 'linkedin.com/in/nvnh2399');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `description` text DEFAULT NULL,
  `technologies` varchar(255) DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `status` enum('planning','in_progress','completed','on_hold') DEFAULT 'in_progress',
  `github_link` varchar(255) DEFAULT NULL,
  `demo_link` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `team_size` int(11) DEFAULT 1,
  `challenges` text DEFAULT NULL,
  `results` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `technologies`, `start_date`, `end_date`, `status`, `github_link`, `demo_link`, `image`, `role`, `team_size`, `challenges`, `results`) VALUES
(1, 'Xây dựng Website thương mại điện tử về đồ ăn nhanh', 'Đây là dự án cho quá trình thực tập tốt nghiệp của cá nhân tôi ', 'PHP, MySQL, HTML, CSS, JS, Boostrap, jQuery', '2024-11-21', '2024-12-22', 'completed', 'https://github.com/RikakiNguyen', 'https://nvnh.id.vn/bandoannhanh/', '1734426457_pj1.jpg', 'fullstack', 1, 'Kiến thức về JavaScript, Boostrap cũng như jQuery còn hạn chế, phải tự tìm hiểu để trao dồi thêm nên dẫn đến việc dự án bị delay khá nhiều lần', 'Hoàn thành đầy đủ các chức năng mà giảng viên cố vấn đặt ra'),
(2, 'Thiết kế giao diện Website bán laptop', 'Đây là bài báo cáo kết thúc môn học \"Thiết kế Web\", dự án này nói chung làm cũng khá nhanh chỉ khoảng 1 tuần là hoàn thành kể cả bài báo cáo.', 'HTML, CSS, JS', '2022-07-06', '2022-11-17', 'completed', 'https://github.com/RikakiNguyen', 'https://thi-web.vercel.app/', '1734445160_1706247992333.jpg', 'Front-end', 1, 'Lúc này mới học căn bản về html và css, js là tự tìm hiểu tự học nên bài làm bị lâu', 'Hoàn thành rồi nộp bài với điểm số môn là 9.5, quá tuyệt vời!');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `skills`
--

CREATE TABLE `skills` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `skills`
--

INSERT INTO `skills` (`id`, `name`) VALUES
(1, 'JavaScript'),
(2, 'C#'),
(5, 'SQL Server'),
(8, 'PHP & MySQL'),
(9, 'Git'),
(10, 'Xamarin'),
(12, 'C++'),
(13, 'ReactJS'),
(14, 'Python');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `rule` tinyint(1) DEFAULT 0,
  `status` enum('active','blocked') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fullname`, `email`, `rule`, `status`, `created_at`) VALUES
(1, 'admin', '$2y$10$BvglIm6ugt5awRrQ1RHW8ecHerAAmOWi7WE1Qt0nnwAH3w2I6t/Ei', 'Nguyễn Văn Ngọc Hãi', '', 1, 'active', '2024-12-17 13:00:24');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `achievements`
--
ALTER TABLE `achievements`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `document_links`
--
ALTER TABLE `document_links`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `education`
--
ALTER TABLE `education`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `experience`
--
ALTER TABLE `experience`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `personal_info`
--
ALTER TABLE `personal_info`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `skills`
--
ALTER TABLE `skills`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `achievements`
--
ALTER TABLE `achievements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `certificates`
--
ALTER TABLE `certificates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `document_links`
--
ALTER TABLE `document_links`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `education`
--
ALTER TABLE `education`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `experience`
--
ALTER TABLE `experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `personal_info`
--
ALTER TABLE `personal_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT cho bảng `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `skills`
--
ALTER TABLE `skills`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
