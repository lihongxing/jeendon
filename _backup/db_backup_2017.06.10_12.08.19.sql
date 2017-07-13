-- -------------------------------------------
SET AUTOCOMMIT=0;
START TRANSACTION;
SET SQL_QUOTE_SHOW_CREATE = 1;
SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
-- -------------------------------------------
-- -------------------------------------------
-- START BACKUP
-- -------------------------------------------
-- -------------------------------------------
-- TABLE `dp_admin`
-- -------------------------------------------
DROP TABLE IF EXISTS `dp_admin`;
CREATE TABLE IF NOT EXISTS `dp_admin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(32) NOT NULL,
  `email` varchar(32) NOT NULL,
  `password_hash` varchar(64) NOT NULL,
  `auth_key` varchar(100) NOT NULL DEFAULT '',
  `accessToken` varchar(100) NOT NULL DEFAULT '',
  `mobile` varchar(11) NOT NULL COMMENT '手机号码',
  `createtime1` int(10) NOT NULL COMMENT '创建时间',
  `status` smallint(4) DEFAULT '10' COMMENT '用户状态10启用2禁用',
  `head_img` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `role` varchar(255) DEFAULT '未设置',
  `updated_at` int(11) DEFAULT NULL,
  `password_reset_token` varchar(255) DEFAULT NULL,
  `created_at` int(255) DEFAULT NULL,
  `department` int(11) DEFAULT NULL,
  `color` varchar(32) DEFAULT NULL COMMENT '值班列表颜色',
  `type` tinyint(4) DEFAULT NULL,
  `parent_u_id` tinyint(4) DEFAULT NULL COMMENT '父级用户id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员';

-- -------------------------------------------
-- TABLE DATA dp_admin
-- -------------------------------------------
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('1','admin','1211419561@qq.com','$2y$13$eEkoV/N7I/RArLO8YpHvUua/BR.7dz38e6XR1eU92ERICRrGVc1sG','','UFMxSTBUbU4KNmMOWwIafDEeXxtCDRoFGyMGGHcSBgAYOFslXD4LBQ%3D%3D','15221382805','1452844511','10','/attachement/image/1/2016/08/12-220424_232.jpg','[\"\\u6743\\u9650\\u7ba1\\u7406\",\"\\u89c6\\u5c4f\\u64ad\\u653e\\uff08\\u5ba1\\u6838\\u6743\\u9650\\uff09\",\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\"]','1491962968','M_L25X8gowuymNOUnRDQNww8CtwH2L9S_1491962968','1475050994','58','#af3636','','');
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('17','hjaudit','2581677068@qq.com','$2y$13$eEkoV/N7I/RArLO8YpHvUua/BR.7dz38e6XR1eU92ERICRrGVc1sG','','','15221382806','0','10','/attachement/image/admin/2016/09/26/57e8c5547640a.jpg','[\"\\u503c\\u73ed\\u5907\\u52e4\\uff08\\u666e\\u901a\\u6743\\u9650\\uff09\",\"\\u7ad9\\u5185\\u4fe1\",\"\\u89c6\\u5c4f\\u64ad\\u653e\\uff08\\u4e0a\\u8f7d\\u6743\\u9650\\uff09\",\"\\u901a\\u77e5\\u901a\\u62a5\\uff08\\u5ba1\\u6838\\u6743\\u9650\\uff09\"]','1487944811','40uqHJ69phw32fmCjQBRrtNG-WLDXlAA_1487944811','1475050583','44','#7a5353','2','');
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('18','hjgeneral','798161229@qq.com','$2y$13$25u/4HUEV.QMk3.vKDFU3uG91aIfF0HYbj.htdsTxMWYBRVJ2JTH6','','','15221382808','0','10','/attachement/image/admin/2016/08/18/20131981535211.jpg','[\"\\u7ad9\\u5185\\u4fe1\",\"\\u901a\\u77e5\\u901a\\u62a5\\uff08\\u4e0a\\u8f7d\\u6743\\u9650\\uff09\"]','1476838778','_nAKuy6ngOrRwTY3pcad2gjv6DlJwZVZ_1476838063','1475050807','44','#000000','1','');
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('19','jygeneral','1211419561@qq.com','$2y$13$Dm3fsBT6ctl4HvMkxS3q6erCwSlfmSYd7J6P02YUeSSJdCAr99Wmm','','','15221382803','0','10','/attachement/image/admin/2016/08/18/20131981535211.jpg','[\"\\u901a\\u77e5\\u901a\\u62a5\\uff08\\u4e0a\\u8f7d\\u6743\\u9650\\uff09\"]','1476860777','yJyuXmReX7Gl_WPX8nBz2uvB2bRmkp44_1476860777','1475050994','45','#937070','1','');
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('20','jyaudit','2587956412@qq.com','$2y$13$EG.MWcdCCQ.qZZI2ZVkHzezo0WGfwxow0W4CiihoSAH7eM9pZK6C6','','','15221382855','0','10','/attachement/image/admin/2016/09/26/57e8c71fbba77.jpg','[\"\\u8d85\\u7ea7\\u7ba1\\u7406\\u5458\"]','1476870995','F_24ArHQV48y09PX3XG9W5g8LRyjp12A_1476870763','1475222112','45','#9e2424','2','');
INSERT INTO `dp_admin` (`id`,`username`,`email`,`password_hash`,`auth_key`,`accessToken`,`mobile`,`createtime1`,`status`,`head_img`,`role`,`updated_at`,`password_reset_token`,`created_at`,`department`,`color`,`type`,`parent_u_id`) VALUES
('25','jiandoukefu','798161229@qq.com','$2y$13$vNJfkdsi2K70sWkUStIFseX0WJqQPLZ6M2oLRHNwqIvu8WkCk7CZK','','','13611636733','0','10','/attachement/image/admin/2017/02/16/0/2/3/7/58a560dbe2b58.jpg','未设置','1492855601','GCiIDhX3gzFGo5JauQgRn5ubOnqNwpXG_1492855601','1487233297','','#000000','1','');



-- -------------------------------------------
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
COMMIT;
-- -------------------------------------------
-- -------------------------------------------
-- END BACKUP
-- -------------------------------------------
