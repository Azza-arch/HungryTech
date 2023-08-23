
-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `product_id` varchar(255) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `comments` char(200) NOT NULL,
  `star_rating` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `product_id`, `customer_id`, `comments`, `star_rating`) VALUES
(44, 'M01-1', 1027, 'sedap', NULL),
(76, 'M01-1', 1027, 'makanan sedap', NULL),
(80, 'M01-5', 1027, 'sedap', NULL),
(81, 'M01-1', 1027, 'sedapngat', NULL);
