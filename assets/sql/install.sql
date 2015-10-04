--
-- MySQL 5.6.24
-- Sun, 04 Oct 2015 12:26:28 +0000
--

CREATE TABLE `sp_user_meta` (
   `user_id` int(11),
   `meta` varchar(254) not null,
   `value` text,
   PRIMARY KEY (`meta`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sp_users` (
   `id` int(11) not null auto_increment,
   `username` varchar(20) not null,
   `email` varchar(254) not null,
   `password` varchar(20) not null,
   `active` int(1) not null,
   `activation_token` varchar(16) not null,
   `created` datetime not null,
   `last_sign_in` datetime,
   `updated` datetime,
   PRIMARY KEY (`id`),
   UNIQUE KEY (`username`),
   UNIQUE KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=8;