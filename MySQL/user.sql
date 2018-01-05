SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

INSERT INTO `site_users` (`user_id`, `user_login`, `user_password`, `user_name`, `user_address`, `user_city`, `user_state`, `user_zip`, `user_country`, `user_phone`, `user_email`, `user_email2`, `user_im_aol`, `user_im_icq`, `user_im_msn`, `user_im_yahoo`, `user_im_other`, `user_status`, `user_level`, `user_pending`, `user_date`, `last_login`, `last_ip`, `user_msg_send`, `user_msg_subject`, `user_protect_delete`, `user_protect_edit`) VALUES
(1, 'admin', '$2a$08$oId6n7GyLv8fFjPDT40G0ury7Qm7mdvncEM0i6JYtJ12FYm63M.dy', 'Site Admin', '', '', '', '', '', '', 'admin@example.com', 'someone@example.com', '', '', '', '', '', 0, 0, 0, 0, 1395186217, '127.0.0.1', 1, 'New Message', 1, 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
