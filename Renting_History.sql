CREATE DATABASE assignment2;
use assignment2;

DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `user_email` varchar(30) DEFAULT NULL,
  `rent_date` date DEFAULT NULL,
  `bond_amount` int(10) DEFAULT NULL
)ENGINE=MyISAM DEFAULT CHARSET=latin1;
