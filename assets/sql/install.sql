--
-- MySQL 5.6.24
-- Wed, 07 Oct 2015 06:01:20 +0000
--

CREATE TABLE `sp_follows` (
   `id` int(11) not null auto_increment,
   `user_id_1` int(11),
   `user_id_2` int(11),
   `type` int(1),
   `followed_on` datetime,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=31;


CREATE TABLE `sp_posts` (
   `id` int(11) not null auto_increment,
   `user_id` int(11) not null,
   `type` int(1) not null default '1',
   `content` text,
   `extra` text,
   `created` datetime not null default CURRENT_TIMESTAMP,
   `updated` datetime,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=21;


CREATE TABLE `sp_user_meta` (
   `id` int(11) not null auto_increment,
   `user_id` int(11),
   `meta` varchar(254) not null,
   `value` text,
   PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=25;


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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=22;

CREATE TABLE `sp_comments`(

   `id` int(11) not null auto_increment,
   `post_id` int(11) not null references sp_posts(id),
   `post_owner_id` int(11) not null,
   `comment_owner_id` int(11) not null,
   `comment` text,
   `created` datetime not null default CURRENT_TIMESTAMP,
   `updated` datetime,
   PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;


CREATE TABLE `sp_votes`(

   `id` int(11) not null auto_increment,
   `post_id` int(11) not null references sp_posts(id),
   `post_owner_id` int(11) not null references sp_users(id),
   `vote_owner_id` int(11) not null references sp_users(id),
   `type` int(11),
   `created` datetime not null default CURRENT_TIMESTAMP,
   `updated` datetime,
   PRIMARY KEY (`id`)

) ENGINE=InnoDB DEFAULT CHARSET=utf8;