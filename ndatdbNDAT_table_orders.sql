
-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `table_no` int(5) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `customer_id`, `table_no`, `quantity`, `product_id`) VALUES
(10125, 1027, NULL, 3, 'M01-1'),
(10135, 1027, NULL, 3, 'M01-1'),
(10136, 1027, NULL, 1, 'M01-10'),
(10137, 1027, NULL, 10, 'M01-1');
