
-- --------------------------------------------------------

--
-- Table structure for table `cashier`
--

CREATE TABLE `cashier` (
  `cashier_email` char(15) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `cashier_password` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `cashier`
--

INSERT INTO `cashier` (`cashier_email`, `order_id`, `cashier_password`) VALUES
('admin@gmail.com', NULL, '1121231234');
