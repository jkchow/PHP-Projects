/*
Navicat MySQL Data Transfer

Source Server         : localhostmysql5
Source Server Version : 50540
Source Host           : localhost:3306
Source Database       : juzhencms1.5

Target Server Type    : MYSQL
Target Server Version : 50540
File Encoding         : 65001

Date: 2017-07-25 09:43:42
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cms_ad`
-- ----------------------------
DROP TABLE IF EXISTS `cms_ad`;
CREATE TABLE `cms_ad` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `space_id` int(11) DEFAULT NULL COMMENT '广告位ID',
  `menu_id` int(11) DEFAULT '0' COMMENT '栏目频道ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '广告标题',
  `content_link` varchar(200) DEFAULT NULL COMMENT '链接地址',
  `content_target` varchar(20) DEFAULT NULL COMMENT '打开方式(默认:当前窗口,新窗口:_blank)',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '广告类型:1图片，2轮播',
  `content_file` varchar(60) DEFAULT NULL COMMENT '广告文件路径',
  `code_str` varchar(200) DEFAULT NULL COMMENT '广告html代码或js代码，用于个性化的广告展示',
  `position` int(11) DEFAULT '999' COMMENT '排序位置序号',
  `publish` tinyint(4) DEFAULT '0' COMMENT '发布状态:0隐藏,1发布',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=106 DEFAULT CHARSET=utf8 COMMENT='广告表';

-- ----------------------------
-- Records of cms_ad
-- ----------------------------
INSERT INTO `cms_ad` VALUES ('104', '76', '0', '33333333', '', null, null, '', '', '999', '1', '1', '2016-09-27 23:48:02');
INSERT INTO `cms_ad` VALUES ('105', '76', '0', '4444444444', '', null, null, '', '', '999', '1', '1', '2016-09-27 23:53:09');

-- ----------------------------
-- Table structure for `cms_ad_apply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_ad_apply`;
CREATE TABLE `cms_ad_apply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `company_name` varchar(40) DEFAULT NULL COMMENT '公司名称',
  `content_name` varchar(30) DEFAULT NULL COMMENT '联系人姓名',
  `content_mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `content_tel` varchar(30) DEFAULT NULL COMMENT '座机',
  `content_email` varchar(50) DEFAULT NULL COMMENT '联系邮箱',
  `content_website` varchar(80) DEFAULT NULL COMMENT '公司网站',
  `ad_position` varchar(80) DEFAULT NULL COMMENT '广告位置',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '备注',
  `content_status` tinyint(4) DEFAULT '0' COMMENT '状态:0未处理,1已处理',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='广告申请表';

-- ----------------------------
-- Records of cms_ad_apply
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_ad_space`
-- ----------------------------
DROP TABLE IF EXISTS `cms_ad_space`;
CREATE TABLE `cms_ad_space` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '广告位名称',
  `content_desc` varchar(120) DEFAULT NULL COMMENT '简介',
  `ad_location` int(11) DEFAULT '0' COMMENT '广告位置，关联系统中的广告位变量',
  `content_width` varchar(11) DEFAULT NULL COMMENT '广告位宽度',
  `content_height` varchar(11) DEFAULT NULL COMMENT '广告位高度',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '广告类型:1图片广告,2轮播广告',
  `menu_case` tinyint(4) DEFAULT '0' COMMENT '是否关联频道',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=77 DEFAULT CHARSET=utf8 COMMENT='广告位';

-- ----------------------------
-- Records of cms_ad_space
-- ----------------------------
INSERT INTO `cms_ad_space` VALUES ('76', 'ceshi', '', '0', '', '', '0', '0', '999', '1', '2016-09-27 23:47:56');

-- ----------------------------
-- Table structure for `cms_address_city`
-- ----------------------------
DROP TABLE IF EXISTS `cms_address_city`;
CREATE TABLE `cms_address_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `city_index` int(11) NOT NULL COMMENT '排序位置',
  `province_id` int(11) NOT NULL COMMENT '省份ID',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '城市名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=392 DEFAULT CHARSET=utf8 COMMENT='地址城市表';

-- ----------------------------
-- Records of cms_address_city
-- ----------------------------
INSERT INTO `cms_address_city` VALUES ('1', '1', '1', '北京市');
INSERT INTO `cms_address_city` VALUES ('2', '1', '2', '天津市');
INSERT INTO `cms_address_city` VALUES ('3', '1', '3', '上海市');
INSERT INTO `cms_address_city` VALUES ('4', '1', '4', '重庆市');
INSERT INTO `cms_address_city` VALUES ('5', '1', '5', '石家庄市');
INSERT INTO `cms_address_city` VALUES ('6', '2', '5', '唐山市');
INSERT INTO `cms_address_city` VALUES ('7', '3', '5', '秦皇岛市');
INSERT INTO `cms_address_city` VALUES ('8', '4', '5', '邯郸市');
INSERT INTO `cms_address_city` VALUES ('9', '5', '5', '邢台市');
INSERT INTO `cms_address_city` VALUES ('10', '6', '5', '保定市');
INSERT INTO `cms_address_city` VALUES ('11', '7', '5', '张家口市');
INSERT INTO `cms_address_city` VALUES ('12', '8', '5', '承德市');
INSERT INTO `cms_address_city` VALUES ('13', '9', '5', '沧州市');
INSERT INTO `cms_address_city` VALUES ('14', '10', '5', '廊坊市');
INSERT INTO `cms_address_city` VALUES ('15', '11', '5', '衡水市');
INSERT INTO `cms_address_city` VALUES ('16', '1', '6', '太原市');
INSERT INTO `cms_address_city` VALUES ('17', '2', '6', '大同市');
INSERT INTO `cms_address_city` VALUES ('18', '3', '6', '阳泉市');
INSERT INTO `cms_address_city` VALUES ('19', '4', '6', '长治市');
INSERT INTO `cms_address_city` VALUES ('20', '5', '6', '晋城市');
INSERT INTO `cms_address_city` VALUES ('21', '6', '6', '朔州市');
INSERT INTO `cms_address_city` VALUES ('22', '7', '6', '晋中市');
INSERT INTO `cms_address_city` VALUES ('23', '8', '6', '运城市');
INSERT INTO `cms_address_city` VALUES ('24', '9', '6', '忻州市');
INSERT INTO `cms_address_city` VALUES ('25', '10', '6', '临汾市');
INSERT INTO `cms_address_city` VALUES ('26', '11', '6', '吕梁市');
INSERT INTO `cms_address_city` VALUES ('27', '1', '7', '台北市');
INSERT INTO `cms_address_city` VALUES ('28', '2', '7', '高雄市');
INSERT INTO `cms_address_city` VALUES ('29', '3', '7', '基隆市');
INSERT INTO `cms_address_city` VALUES ('30', '4', '7', '台中市');
INSERT INTO `cms_address_city` VALUES ('31', '5', '7', '台南市');
INSERT INTO `cms_address_city` VALUES ('32', '6', '7', '新竹市');
INSERT INTO `cms_address_city` VALUES ('33', '7', '7', '嘉义市');
INSERT INTO `cms_address_city` VALUES ('34', '8', '7', '台北县');
INSERT INTO `cms_address_city` VALUES ('35', '9', '7', '宜兰县');
INSERT INTO `cms_address_city` VALUES ('36', '10', '7', '桃园县');
INSERT INTO `cms_address_city` VALUES ('37', '11', '7', '新竹县');
INSERT INTO `cms_address_city` VALUES ('38', '12', '7', '苗栗县');
INSERT INTO `cms_address_city` VALUES ('39', '13', '7', '台中县');
INSERT INTO `cms_address_city` VALUES ('40', '14', '7', '彰化县');
INSERT INTO `cms_address_city` VALUES ('41', '15', '7', '南投县');
INSERT INTO `cms_address_city` VALUES ('42', '16', '7', '云林县');
INSERT INTO `cms_address_city` VALUES ('43', '17', '7', '嘉义县');
INSERT INTO `cms_address_city` VALUES ('44', '18', '7', '台南县');
INSERT INTO `cms_address_city` VALUES ('45', '19', '7', '高雄县');
INSERT INTO `cms_address_city` VALUES ('46', '20', '7', '屏东县');
INSERT INTO `cms_address_city` VALUES ('47', '21', '7', '澎湖县');
INSERT INTO `cms_address_city` VALUES ('48', '22', '7', '台东县');
INSERT INTO `cms_address_city` VALUES ('49', '23', '7', '花莲县');
INSERT INTO `cms_address_city` VALUES ('50', '1', '8', '沈阳市');
INSERT INTO `cms_address_city` VALUES ('51', '2', '8', '大连市');
INSERT INTO `cms_address_city` VALUES ('52', '3', '8', '鞍山市');
INSERT INTO `cms_address_city` VALUES ('53', '4', '8', '抚顺市');
INSERT INTO `cms_address_city` VALUES ('54', '5', '8', '本溪市');
INSERT INTO `cms_address_city` VALUES ('55', '6', '8', '丹东市');
INSERT INTO `cms_address_city` VALUES ('56', '7', '8', '锦州市');
INSERT INTO `cms_address_city` VALUES ('57', '8', '8', '营口市');
INSERT INTO `cms_address_city` VALUES ('58', '9', '8', '阜新市');
INSERT INTO `cms_address_city` VALUES ('59', '10', '8', '辽阳市');
INSERT INTO `cms_address_city` VALUES ('60', '11', '8', '盘锦市');
INSERT INTO `cms_address_city` VALUES ('61', '12', '8', '铁岭市');
INSERT INTO `cms_address_city` VALUES ('62', '13', '8', '朝阳市');
INSERT INTO `cms_address_city` VALUES ('63', '14', '8', '葫芦岛市');
INSERT INTO `cms_address_city` VALUES ('64', '1', '9', '长春市');
INSERT INTO `cms_address_city` VALUES ('65', '2', '9', '吉林市');
INSERT INTO `cms_address_city` VALUES ('66', '3', '9', '四平市');
INSERT INTO `cms_address_city` VALUES ('67', '4', '9', '辽源市');
INSERT INTO `cms_address_city` VALUES ('68', '5', '9', '通化市');
INSERT INTO `cms_address_city` VALUES ('69', '6', '9', '白山市');
INSERT INTO `cms_address_city` VALUES ('70', '7', '9', '松原市');
INSERT INTO `cms_address_city` VALUES ('71', '8', '9', '白城市');
INSERT INTO `cms_address_city` VALUES ('72', '9', '9', '延边朝鲜族自治州');
INSERT INTO `cms_address_city` VALUES ('73', '1', '10', '哈尔滨市');
INSERT INTO `cms_address_city` VALUES ('74', '2', '10', '齐齐哈尔市');
INSERT INTO `cms_address_city` VALUES ('75', '3', '10', '鹤岗市');
INSERT INTO `cms_address_city` VALUES ('76', '4', '10', '双鸭山市');
INSERT INTO `cms_address_city` VALUES ('77', '5', '10', '鸡西市');
INSERT INTO `cms_address_city` VALUES ('78', '6', '10', '大庆市');
INSERT INTO `cms_address_city` VALUES ('79', '7', '10', '伊春市');
INSERT INTO `cms_address_city` VALUES ('80', '8', '10', '牡丹江市');
INSERT INTO `cms_address_city` VALUES ('81', '9', '10', '佳木斯市');
INSERT INTO `cms_address_city` VALUES ('82', '10', '10', '七台河市');
INSERT INTO `cms_address_city` VALUES ('83', '11', '10', '黑河市');
INSERT INTO `cms_address_city` VALUES ('84', '12', '10', '绥化市');
INSERT INTO `cms_address_city` VALUES ('85', '13', '10', '大兴安岭地区');
INSERT INTO `cms_address_city` VALUES ('86', '1', '11', '南京市');
INSERT INTO `cms_address_city` VALUES ('87', '2', '11', '无锡市');
INSERT INTO `cms_address_city` VALUES ('88', '3', '11', '徐州市');
INSERT INTO `cms_address_city` VALUES ('89', '4', '11', '常州市');
INSERT INTO `cms_address_city` VALUES ('90', '5', '11', '苏州市');
INSERT INTO `cms_address_city` VALUES ('91', '6', '11', '南通市');
INSERT INTO `cms_address_city` VALUES ('92', '7', '11', '连云港市');
INSERT INTO `cms_address_city` VALUES ('93', '8', '11', '淮安市');
INSERT INTO `cms_address_city` VALUES ('94', '9', '11', '盐城市');
INSERT INTO `cms_address_city` VALUES ('95', '10', '11', '扬州市');
INSERT INTO `cms_address_city` VALUES ('96', '11', '11', '镇江市');
INSERT INTO `cms_address_city` VALUES ('97', '12', '11', '泰州市');
INSERT INTO `cms_address_city` VALUES ('98', '13', '11', '宿迁市');
INSERT INTO `cms_address_city` VALUES ('99', '1', '12', '杭州市');
INSERT INTO `cms_address_city` VALUES ('100', '2', '12', '宁波市');
INSERT INTO `cms_address_city` VALUES ('101', '3', '12', '温州市');
INSERT INTO `cms_address_city` VALUES ('102', '4', '12', '嘉兴市');
INSERT INTO `cms_address_city` VALUES ('103', '5', '12', '湖州市');
INSERT INTO `cms_address_city` VALUES ('104', '6', '12', '绍兴市');
INSERT INTO `cms_address_city` VALUES ('105', '7', '12', '金华市');
INSERT INTO `cms_address_city` VALUES ('106', '8', '12', '衢州市');
INSERT INTO `cms_address_city` VALUES ('107', '9', '12', '舟山市');
INSERT INTO `cms_address_city` VALUES ('108', '10', '12', '台州市');
INSERT INTO `cms_address_city` VALUES ('109', '11', '12', '丽水市');
INSERT INTO `cms_address_city` VALUES ('110', '1', '13', '合肥市');
INSERT INTO `cms_address_city` VALUES ('111', '2', '13', '芜湖市');
INSERT INTO `cms_address_city` VALUES ('112', '3', '13', '蚌埠市');
INSERT INTO `cms_address_city` VALUES ('113', '4', '13', '淮南市');
INSERT INTO `cms_address_city` VALUES ('114', '5', '13', '马鞍山市');
INSERT INTO `cms_address_city` VALUES ('115', '6', '13', '淮北市');
INSERT INTO `cms_address_city` VALUES ('116', '7', '13', '铜陵市');
INSERT INTO `cms_address_city` VALUES ('117', '8', '13', '安庆市');
INSERT INTO `cms_address_city` VALUES ('118', '9', '13', '黄山市');
INSERT INTO `cms_address_city` VALUES ('119', '10', '13', '滁州市');
INSERT INTO `cms_address_city` VALUES ('120', '11', '13', '阜阳市');
INSERT INTO `cms_address_city` VALUES ('121', '12', '13', '宿州市');
INSERT INTO `cms_address_city` VALUES ('122', '13', '13', '巢湖市');
INSERT INTO `cms_address_city` VALUES ('123', '14', '13', '六安市');
INSERT INTO `cms_address_city` VALUES ('124', '15', '13', '亳州市');
INSERT INTO `cms_address_city` VALUES ('125', '16', '13', '池州市');
INSERT INTO `cms_address_city` VALUES ('126', '17', '13', '宣城市');
INSERT INTO `cms_address_city` VALUES ('127', '1', '14', '福州市');
INSERT INTO `cms_address_city` VALUES ('128', '2', '14', '厦门市');
INSERT INTO `cms_address_city` VALUES ('129', '3', '14', '莆田市');
INSERT INTO `cms_address_city` VALUES ('130', '4', '14', '三明市');
INSERT INTO `cms_address_city` VALUES ('131', '5', '14', '泉州市');
INSERT INTO `cms_address_city` VALUES ('132', '6', '14', '漳州市');
INSERT INTO `cms_address_city` VALUES ('133', '7', '14', '南平市');
INSERT INTO `cms_address_city` VALUES ('134', '8', '14', '龙岩市');
INSERT INTO `cms_address_city` VALUES ('135', '9', '14', '宁德市');
INSERT INTO `cms_address_city` VALUES ('136', '1', '15', '南昌市');
INSERT INTO `cms_address_city` VALUES ('137', '2', '15', '景德镇市');
INSERT INTO `cms_address_city` VALUES ('138', '3', '15', '萍乡市');
INSERT INTO `cms_address_city` VALUES ('139', '4', '15', '九江市');
INSERT INTO `cms_address_city` VALUES ('140', '5', '15', '新余市');
INSERT INTO `cms_address_city` VALUES ('141', '6', '15', '鹰潭市');
INSERT INTO `cms_address_city` VALUES ('142', '7', '15', '赣州市');
INSERT INTO `cms_address_city` VALUES ('143', '8', '15', '吉安市');
INSERT INTO `cms_address_city` VALUES ('144', '9', '15', '宜春市');
INSERT INTO `cms_address_city` VALUES ('145', '10', '15', '抚州市');
INSERT INTO `cms_address_city` VALUES ('146', '11', '15', '上饶市');
INSERT INTO `cms_address_city` VALUES ('147', '1', '16', '济南市');
INSERT INTO `cms_address_city` VALUES ('148', '2', '16', '青岛市');
INSERT INTO `cms_address_city` VALUES ('149', '3', '16', '淄博市');
INSERT INTO `cms_address_city` VALUES ('150', '4', '16', '枣庄市');
INSERT INTO `cms_address_city` VALUES ('151', '5', '16', '东营市');
INSERT INTO `cms_address_city` VALUES ('152', '6', '16', '烟台市');
INSERT INTO `cms_address_city` VALUES ('153', '7', '16', '潍坊市');
INSERT INTO `cms_address_city` VALUES ('154', '8', '16', '济宁市');
INSERT INTO `cms_address_city` VALUES ('155', '9', '16', '泰安市');
INSERT INTO `cms_address_city` VALUES ('156', '10', '16', '威海市');
INSERT INTO `cms_address_city` VALUES ('157', '11', '16', '日照市');
INSERT INTO `cms_address_city` VALUES ('158', '12', '16', '莱芜市');
INSERT INTO `cms_address_city` VALUES ('159', '13', '16', '临沂市');
INSERT INTO `cms_address_city` VALUES ('160', '14', '16', '德州市');
INSERT INTO `cms_address_city` VALUES ('161', '15', '16', '聊城市');
INSERT INTO `cms_address_city` VALUES ('162', '16', '16', '滨州市');
INSERT INTO `cms_address_city` VALUES ('163', '17', '16', '菏泽市');
INSERT INTO `cms_address_city` VALUES ('164', '1', '17', '郑州市');
INSERT INTO `cms_address_city` VALUES ('165', '2', '17', '开封市');
INSERT INTO `cms_address_city` VALUES ('166', '3', '17', '洛阳市');
INSERT INTO `cms_address_city` VALUES ('167', '4', '17', '平顶山市');
INSERT INTO `cms_address_city` VALUES ('168', '5', '17', '安阳市');
INSERT INTO `cms_address_city` VALUES ('169', '6', '17', '鹤壁市');
INSERT INTO `cms_address_city` VALUES ('170', '7', '17', '新乡市');
INSERT INTO `cms_address_city` VALUES ('171', '8', '17', '焦作市');
INSERT INTO `cms_address_city` VALUES ('172', '9', '17', '濮阳市');
INSERT INTO `cms_address_city` VALUES ('173', '10', '17', '许昌市');
INSERT INTO `cms_address_city` VALUES ('174', '11', '17', '漯河市');
INSERT INTO `cms_address_city` VALUES ('175', '12', '17', '三门峡市');
INSERT INTO `cms_address_city` VALUES ('176', '13', '17', '南阳市');
INSERT INTO `cms_address_city` VALUES ('177', '14', '17', '商丘市');
INSERT INTO `cms_address_city` VALUES ('178', '15', '17', '信阳市');
INSERT INTO `cms_address_city` VALUES ('179', '16', '17', '周口市');
INSERT INTO `cms_address_city` VALUES ('180', '17', '17', '驻马店市');
INSERT INTO `cms_address_city` VALUES ('181', '18', '17', '济源市');
INSERT INTO `cms_address_city` VALUES ('182', '1', '18', '武汉市');
INSERT INTO `cms_address_city` VALUES ('183', '2', '18', '黄石市');
INSERT INTO `cms_address_city` VALUES ('184', '3', '18', '十堰市');
INSERT INTO `cms_address_city` VALUES ('185', '4', '18', '荆州市');
INSERT INTO `cms_address_city` VALUES ('186', '5', '18', '宜昌市');
INSERT INTO `cms_address_city` VALUES ('187', '6', '18', '襄樊市');
INSERT INTO `cms_address_city` VALUES ('188', '7', '18', '鄂州市');
INSERT INTO `cms_address_city` VALUES ('189', '8', '18', '荆门市');
INSERT INTO `cms_address_city` VALUES ('190', '9', '18', '孝感市');
INSERT INTO `cms_address_city` VALUES ('191', '10', '18', '黄冈市');
INSERT INTO `cms_address_city` VALUES ('192', '11', '18', '咸宁市');
INSERT INTO `cms_address_city` VALUES ('193', '12', '18', '随州市');
INSERT INTO `cms_address_city` VALUES ('194', '13', '18', '仙桃市');
INSERT INTO `cms_address_city` VALUES ('195', '14', '18', '天门市');
INSERT INTO `cms_address_city` VALUES ('196', '15', '18', '潜江市');
INSERT INTO `cms_address_city` VALUES ('197', '16', '18', '神农架林区');
INSERT INTO `cms_address_city` VALUES ('198', '17', '18', '恩施土家族苗族自治州');
INSERT INTO `cms_address_city` VALUES ('199', '1', '19', '长沙市');
INSERT INTO `cms_address_city` VALUES ('200', '2', '19', '株洲市');
INSERT INTO `cms_address_city` VALUES ('201', '3', '19', '湘潭市');
INSERT INTO `cms_address_city` VALUES ('202', '4', '19', '衡阳市');
INSERT INTO `cms_address_city` VALUES ('203', '5', '19', '邵阳市');
INSERT INTO `cms_address_city` VALUES ('204', '6', '19', '岳阳市');
INSERT INTO `cms_address_city` VALUES ('205', '7', '19', '常德市');
INSERT INTO `cms_address_city` VALUES ('206', '8', '19', '张家界市');
INSERT INTO `cms_address_city` VALUES ('207', '9', '19', '益阳市');
INSERT INTO `cms_address_city` VALUES ('208', '10', '19', '郴州市');
INSERT INTO `cms_address_city` VALUES ('209', '11', '19', '永州市');
INSERT INTO `cms_address_city` VALUES ('210', '12', '19', '怀化市');
INSERT INTO `cms_address_city` VALUES ('211', '13', '19', '娄底市');
INSERT INTO `cms_address_city` VALUES ('212', '14', '19', '湘西土家族苗族自治州');
INSERT INTO `cms_address_city` VALUES ('213', '1', '20', '广州市');
INSERT INTO `cms_address_city` VALUES ('214', '2', '20', '深圳市');
INSERT INTO `cms_address_city` VALUES ('215', '3', '20', '珠海市');
INSERT INTO `cms_address_city` VALUES ('216', '4', '20', '汕头市');
INSERT INTO `cms_address_city` VALUES ('217', '5', '20', '韶关市');
INSERT INTO `cms_address_city` VALUES ('218', '6', '20', '佛山市');
INSERT INTO `cms_address_city` VALUES ('219', '7', '20', '江门市');
INSERT INTO `cms_address_city` VALUES ('220', '8', '20', '湛江市');
INSERT INTO `cms_address_city` VALUES ('221', '9', '20', '茂名市');
INSERT INTO `cms_address_city` VALUES ('222', '10', '20', '肇庆市');
INSERT INTO `cms_address_city` VALUES ('223', '11', '20', '惠州市');
INSERT INTO `cms_address_city` VALUES ('224', '12', '20', '梅州市');
INSERT INTO `cms_address_city` VALUES ('225', '13', '20', '汕尾市');
INSERT INTO `cms_address_city` VALUES ('226', '14', '20', '河源市');
INSERT INTO `cms_address_city` VALUES ('227', '15', '20', '阳江市');
INSERT INTO `cms_address_city` VALUES ('228', '16', '20', '清远市');
INSERT INTO `cms_address_city` VALUES ('229', '17', '20', '东莞市');
INSERT INTO `cms_address_city` VALUES ('230', '18', '20', '中山市');
INSERT INTO `cms_address_city` VALUES ('231', '19', '20', '潮州市');
INSERT INTO `cms_address_city` VALUES ('232', '20', '20', '揭阳市');
INSERT INTO `cms_address_city` VALUES ('233', '21', '20', '云浮市');
INSERT INTO `cms_address_city` VALUES ('234', '1', '21', '兰州市');
INSERT INTO `cms_address_city` VALUES ('235', '2', '21', '金昌市');
INSERT INTO `cms_address_city` VALUES ('236', '3', '21', '白银市');
INSERT INTO `cms_address_city` VALUES ('237', '4', '21', '天水市');
INSERT INTO `cms_address_city` VALUES ('238', '5', '21', '嘉峪关市');
INSERT INTO `cms_address_city` VALUES ('239', '6', '21', '武威市');
INSERT INTO `cms_address_city` VALUES ('240', '7', '21', '张掖市');
INSERT INTO `cms_address_city` VALUES ('241', '8', '21', '平凉市');
INSERT INTO `cms_address_city` VALUES ('242', '9', '21', '酒泉市');
INSERT INTO `cms_address_city` VALUES ('243', '10', '21', '庆阳市');
INSERT INTO `cms_address_city` VALUES ('244', '11', '21', '定西市');
INSERT INTO `cms_address_city` VALUES ('245', '12', '21', '陇南市');
INSERT INTO `cms_address_city` VALUES ('246', '13', '21', '临夏回族自治州');
INSERT INTO `cms_address_city` VALUES ('247', '14', '21', '甘南藏族自治州');
INSERT INTO `cms_address_city` VALUES ('248', '1', '22', '成都市');
INSERT INTO `cms_address_city` VALUES ('249', '2', '22', '自贡市');
INSERT INTO `cms_address_city` VALUES ('250', '3', '22', '攀枝花市');
INSERT INTO `cms_address_city` VALUES ('251', '4', '22', '泸州市');
INSERT INTO `cms_address_city` VALUES ('252', '5', '22', '德阳市');
INSERT INTO `cms_address_city` VALUES ('253', '6', '22', '绵阳市');
INSERT INTO `cms_address_city` VALUES ('254', '7', '22', '广元市');
INSERT INTO `cms_address_city` VALUES ('255', '8', '22', '遂宁市');
INSERT INTO `cms_address_city` VALUES ('256', '9', '22', '内江市');
INSERT INTO `cms_address_city` VALUES ('257', '10', '22', '乐山市');
INSERT INTO `cms_address_city` VALUES ('258', '11', '22', '南充市');
INSERT INTO `cms_address_city` VALUES ('259', '12', '22', '眉山市');
INSERT INTO `cms_address_city` VALUES ('260', '13', '22', '宜宾市');
INSERT INTO `cms_address_city` VALUES ('261', '14', '22', '广安市');
INSERT INTO `cms_address_city` VALUES ('262', '15', '22', '达州市');
INSERT INTO `cms_address_city` VALUES ('263', '16', '22', '雅安市');
INSERT INTO `cms_address_city` VALUES ('264', '17', '22', '巴中市');
INSERT INTO `cms_address_city` VALUES ('265', '18', '22', '资阳市');
INSERT INTO `cms_address_city` VALUES ('266', '19', '22', '阿坝藏族羌族自治州');
INSERT INTO `cms_address_city` VALUES ('267', '20', '22', '甘孜藏族自治州');
INSERT INTO `cms_address_city` VALUES ('268', '21', '22', '凉山彝族自治州');
INSERT INTO `cms_address_city` VALUES ('269', '1', '23', '贵阳市');
INSERT INTO `cms_address_city` VALUES ('270', '2', '23', '六盘水市');
INSERT INTO `cms_address_city` VALUES ('271', '3', '23', '遵义市');
INSERT INTO `cms_address_city` VALUES ('272', '4', '23', '安顺市');
INSERT INTO `cms_address_city` VALUES ('273', '5', '23', '铜仁地区');
INSERT INTO `cms_address_city` VALUES ('274', '6', '23', '毕节地区');
INSERT INTO `cms_address_city` VALUES ('275', '7', '23', '黔西南布依族苗族自治州');
INSERT INTO `cms_address_city` VALUES ('276', '8', '23', '黔东南苗族侗族自治州');
INSERT INTO `cms_address_city` VALUES ('277', '9', '23', '黔南布依族苗族自治州');
INSERT INTO `cms_address_city` VALUES ('278', '1', '24', '海口市');
INSERT INTO `cms_address_city` VALUES ('279', '2', '24', '三亚市');
INSERT INTO `cms_address_city` VALUES ('280', '3', '24', '五指山市');
INSERT INTO `cms_address_city` VALUES ('281', '4', '24', '琼海市');
INSERT INTO `cms_address_city` VALUES ('282', '5', '24', '儋州市');
INSERT INTO `cms_address_city` VALUES ('283', '6', '24', '文昌市');
INSERT INTO `cms_address_city` VALUES ('284', '7', '24', '万宁市');
INSERT INTO `cms_address_city` VALUES ('285', '8', '24', '东方市');
INSERT INTO `cms_address_city` VALUES ('286', '9', '24', '澄迈县');
INSERT INTO `cms_address_city` VALUES ('287', '10', '24', '定安县');
INSERT INTO `cms_address_city` VALUES ('288', '11', '24', '屯昌县');
INSERT INTO `cms_address_city` VALUES ('289', '12', '24', '临高县');
INSERT INTO `cms_address_city` VALUES ('290', '13', '24', '白沙黎族自治县');
INSERT INTO `cms_address_city` VALUES ('291', '14', '24', '昌江黎族自治县');
INSERT INTO `cms_address_city` VALUES ('292', '15', '24', '乐东黎族自治县');
INSERT INTO `cms_address_city` VALUES ('293', '16', '24', '陵水黎族自治县');
INSERT INTO `cms_address_city` VALUES ('294', '17', '24', '保亭黎族苗族自治县');
INSERT INTO `cms_address_city` VALUES ('295', '18', '24', '琼中黎族苗族自治县');
INSERT INTO `cms_address_city` VALUES ('296', '1', '25', '昆明市');
INSERT INTO `cms_address_city` VALUES ('297', '2', '25', '曲靖市');
INSERT INTO `cms_address_city` VALUES ('298', '3', '25', '玉溪市');
INSERT INTO `cms_address_city` VALUES ('299', '4', '25', '保山市');
INSERT INTO `cms_address_city` VALUES ('300', '5', '25', '昭通市');
INSERT INTO `cms_address_city` VALUES ('301', '6', '25', '丽江市');
INSERT INTO `cms_address_city` VALUES ('302', '7', '25', '思茅市');
INSERT INTO `cms_address_city` VALUES ('303', '8', '25', '临沧市');
INSERT INTO `cms_address_city` VALUES ('304', '9', '25', '文山壮族苗族自治州');
INSERT INTO `cms_address_city` VALUES ('305', '10', '25', '红河哈尼族彝族自治州');
INSERT INTO `cms_address_city` VALUES ('306', '11', '25', '西双版纳傣族自治州');
INSERT INTO `cms_address_city` VALUES ('307', '12', '25', '楚雄彝族自治州');
INSERT INTO `cms_address_city` VALUES ('308', '13', '25', '大理白族自治州');
INSERT INTO `cms_address_city` VALUES ('309', '14', '25', '德宏傣族景颇族自治州');
INSERT INTO `cms_address_city` VALUES ('310', '15', '25', '怒江傈傈族自治州');
INSERT INTO `cms_address_city` VALUES ('311', '16', '25', '迪庆藏族自治州');
INSERT INTO `cms_address_city` VALUES ('312', '1', '26', '西宁市');
INSERT INTO `cms_address_city` VALUES ('313', '2', '26', '海东地区');
INSERT INTO `cms_address_city` VALUES ('314', '3', '26', '海北藏族自治州');
INSERT INTO `cms_address_city` VALUES ('315', '4', '26', '黄南藏族自治州');
INSERT INTO `cms_address_city` VALUES ('316', '5', '26', '海南藏族自治州');
INSERT INTO `cms_address_city` VALUES ('317', '6', '26', '果洛藏族自治州');
INSERT INTO `cms_address_city` VALUES ('318', '7', '26', '玉树藏族自治州');
INSERT INTO `cms_address_city` VALUES ('319', '8', '26', '海西蒙古族藏族自治州');
INSERT INTO `cms_address_city` VALUES ('320', '1', '27', '西安市');
INSERT INTO `cms_address_city` VALUES ('321', '2', '27', '铜川市');
INSERT INTO `cms_address_city` VALUES ('322', '3', '27', '宝鸡市');
INSERT INTO `cms_address_city` VALUES ('323', '4', '27', '咸阳市');
INSERT INTO `cms_address_city` VALUES ('324', '5', '27', '渭南市');
INSERT INTO `cms_address_city` VALUES ('325', '6', '27', '延安市');
INSERT INTO `cms_address_city` VALUES ('326', '7', '27', '汉中市');
INSERT INTO `cms_address_city` VALUES ('327', '8', '27', '榆林市');
INSERT INTO `cms_address_city` VALUES ('328', '9', '27', '安康市');
INSERT INTO `cms_address_city` VALUES ('329', '10', '27', '商洛市');
INSERT INTO `cms_address_city` VALUES ('330', '1', '28', '南宁市');
INSERT INTO `cms_address_city` VALUES ('331', '2', '28', '柳州市');
INSERT INTO `cms_address_city` VALUES ('332', '3', '28', '桂林市');
INSERT INTO `cms_address_city` VALUES ('333', '4', '28', '梧州市');
INSERT INTO `cms_address_city` VALUES ('334', '5', '28', '北海市');
INSERT INTO `cms_address_city` VALUES ('335', '6', '28', '防城港市');
INSERT INTO `cms_address_city` VALUES ('336', '7', '28', '钦州市');
INSERT INTO `cms_address_city` VALUES ('337', '8', '28', '贵港市');
INSERT INTO `cms_address_city` VALUES ('338', '9', '28', '玉林市');
INSERT INTO `cms_address_city` VALUES ('339', '10', '28', '百色市');
INSERT INTO `cms_address_city` VALUES ('340', '11', '28', '贺州市');
INSERT INTO `cms_address_city` VALUES ('341', '12', '28', '河池市');
INSERT INTO `cms_address_city` VALUES ('342', '13', '28', '来宾市');
INSERT INTO `cms_address_city` VALUES ('343', '14', '28', '崇左市');
INSERT INTO `cms_address_city` VALUES ('344', '1', '29', '拉萨市');
INSERT INTO `cms_address_city` VALUES ('345', '2', '29', '那曲地区');
INSERT INTO `cms_address_city` VALUES ('346', '3', '29', '昌都地区');
INSERT INTO `cms_address_city` VALUES ('347', '4', '29', '山南地区');
INSERT INTO `cms_address_city` VALUES ('348', '5', '29', '日喀则地区');
INSERT INTO `cms_address_city` VALUES ('349', '6', '29', '阿里地区');
INSERT INTO `cms_address_city` VALUES ('350', '7', '29', '林芝地区');
INSERT INTO `cms_address_city` VALUES ('351', '1', '30', '银川市');
INSERT INTO `cms_address_city` VALUES ('352', '2', '30', '石嘴山市');
INSERT INTO `cms_address_city` VALUES ('353', '3', '30', '吴忠市');
INSERT INTO `cms_address_city` VALUES ('354', '4', '30', '固原市');
INSERT INTO `cms_address_city` VALUES ('355', '5', '30', '中卫市');
INSERT INTO `cms_address_city` VALUES ('356', '1', '31', '乌鲁木齐市');
INSERT INTO `cms_address_city` VALUES ('357', '2', '31', '克拉玛依市');
INSERT INTO `cms_address_city` VALUES ('358', '3', '31', '石河子市　');
INSERT INTO `cms_address_city` VALUES ('359', '4', '31', '阿拉尔市');
INSERT INTO `cms_address_city` VALUES ('360', '5', '31', '图木舒克市');
INSERT INTO `cms_address_city` VALUES ('361', '6', '31', '五家渠市');
INSERT INTO `cms_address_city` VALUES ('362', '7', '31', '吐鲁番市');
INSERT INTO `cms_address_city` VALUES ('363', '8', '31', '阿克苏市');
INSERT INTO `cms_address_city` VALUES ('364', '9', '31', '喀什市');
INSERT INTO `cms_address_city` VALUES ('365', '10', '31', '哈密市');
INSERT INTO `cms_address_city` VALUES ('366', '11', '31', '和田市');
INSERT INTO `cms_address_city` VALUES ('367', '12', '31', '阿图什市');
INSERT INTO `cms_address_city` VALUES ('368', '13', '31', '库尔勒市');
INSERT INTO `cms_address_city` VALUES ('369', '14', '31', '昌吉市　');
INSERT INTO `cms_address_city` VALUES ('370', '15', '31', '阜康市');
INSERT INTO `cms_address_city` VALUES ('371', '16', '31', '米泉市');
INSERT INTO `cms_address_city` VALUES ('372', '17', '31', '博乐市');
INSERT INTO `cms_address_city` VALUES ('373', '18', '31', '伊宁市');
INSERT INTO `cms_address_city` VALUES ('374', '19', '31', '奎屯市');
INSERT INTO `cms_address_city` VALUES ('375', '20', '31', '塔城市');
INSERT INTO `cms_address_city` VALUES ('376', '21', '31', '乌苏市');
INSERT INTO `cms_address_city` VALUES ('377', '22', '31', '阿勒泰市');
INSERT INTO `cms_address_city` VALUES ('378', '1', '32', '呼和浩特市');
INSERT INTO `cms_address_city` VALUES ('379', '2', '32', '包头市');
INSERT INTO `cms_address_city` VALUES ('380', '3', '32', '乌海市');
INSERT INTO `cms_address_city` VALUES ('381', '4', '32', '赤峰市');
INSERT INTO `cms_address_city` VALUES ('382', '5', '32', '通辽市');
INSERT INTO `cms_address_city` VALUES ('383', '6', '32', '鄂尔多斯市');
INSERT INTO `cms_address_city` VALUES ('384', '7', '32', '呼伦贝尔市');
INSERT INTO `cms_address_city` VALUES ('385', '8', '32', '巴彦淖尔市');
INSERT INTO `cms_address_city` VALUES ('386', '9', '32', '乌兰察布市');
INSERT INTO `cms_address_city` VALUES ('387', '10', '32', '锡林郭勒盟');
INSERT INTO `cms_address_city` VALUES ('388', '11', '32', '兴安盟');
INSERT INTO `cms_address_city` VALUES ('389', '12', '32', '阿拉善盟');
INSERT INTO `cms_address_city` VALUES ('390', '1', '33', '澳门特别行政区');
INSERT INTO `cms_address_city` VALUES ('391', '1', '34', '香港特别行政区');

-- ----------------------------
-- Table structure for `cms_address_province`
-- ----------------------------
DROP TABLE IF EXISTS `cms_address_province`;
CREATE TABLE `cms_address_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(50) DEFAULT NULL COMMENT '城市名称',
  `letter` varchar(5) DEFAULT NULL COMMENT '城市首字母',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='地址省份表';

-- ----------------------------
-- Records of cms_address_province
-- ----------------------------
INSERT INTO `cms_address_province` VALUES ('1', '北京', 'B');
INSERT INTO `cms_address_province` VALUES ('2', '天津', 'T');
INSERT INTO `cms_address_province` VALUES ('3', '上海', 'S');
INSERT INTO `cms_address_province` VALUES ('4', '重庆', 'C');
INSERT INTO `cms_address_province` VALUES ('5', '河北', 'H');
INSERT INTO `cms_address_province` VALUES ('6', '山西', 'S');
INSERT INTO `cms_address_province` VALUES ('7', '台湾', 'T');
INSERT INTO `cms_address_province` VALUES ('8', '辽宁', 'L');
INSERT INTO `cms_address_province` VALUES ('9', '吉林', 'J');
INSERT INTO `cms_address_province` VALUES ('10', '黑龙江', 'H');
INSERT INTO `cms_address_province` VALUES ('11', '江苏', 'J');
INSERT INTO `cms_address_province` VALUES ('12', '浙江', 'Z');
INSERT INTO `cms_address_province` VALUES ('13', '安徽', 'A');
INSERT INTO `cms_address_province` VALUES ('14', '福建', 'F');
INSERT INTO `cms_address_province` VALUES ('15', '江西', 'J');
INSERT INTO `cms_address_province` VALUES ('16', '山东', 'S');
INSERT INTO `cms_address_province` VALUES ('17', '河南', 'H');
INSERT INTO `cms_address_province` VALUES ('18', '湖北', 'H');
INSERT INTO `cms_address_province` VALUES ('19', '湖南', 'H');
INSERT INTO `cms_address_province` VALUES ('20', '广东', 'G');
INSERT INTO `cms_address_province` VALUES ('21', '甘肃', 'G');
INSERT INTO `cms_address_province` VALUES ('22', '四川', 'S');
INSERT INTO `cms_address_province` VALUES ('23', '贵州', 'G');
INSERT INTO `cms_address_province` VALUES ('24', '海南', 'H');
INSERT INTO `cms_address_province` VALUES ('25', '云南', 'Y');
INSERT INTO `cms_address_province` VALUES ('26', '青海', 'Q');
INSERT INTO `cms_address_province` VALUES ('27', '陕西', 'S');
INSERT INTO `cms_address_province` VALUES ('28', '广西', 'G');
INSERT INTO `cms_address_province` VALUES ('29', '西藏', 'X');
INSERT INTO `cms_address_province` VALUES ('30', '宁夏', 'N');
INSERT INTO `cms_address_province` VALUES ('31', '新疆', 'X');
INSERT INTO `cms_address_province` VALUES ('32', '内蒙古', 'N');
INSERT INTO `cms_address_province` VALUES ('33', '澳门', 'A');
INSERT INTO `cms_address_province` VALUES ('34', '香港', 'X');

-- ----------------------------
-- Table structure for `cms_app_api`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_api`;
CREATE TABLE `cms_app_api` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `desc` varchar(200) DEFAULT NULL,
  `type` int(11) DEFAULT '0',
  `param_example` varchar(500) DEFAULT NULL,
  `return_example` varchar(500) DEFAULT NULL,
  `auto_position` int(11) DEFAULT '999',
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_app_api
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_app_api_datafield`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_api_datafield`;
CREATE TABLE `cms_app_api_datafield` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_id` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='接口输入参数';

-- ----------------------------
-- Records of cms_app_api_datafield
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_app_api_param`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_api_param`;
CREATE TABLE `cms_app_api_param` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `api_id` int(11) DEFAULT '0',
  `pid` int(11) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `desc` varchar(100) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='接口输入参数';

-- ----------------------------
-- Records of cms_app_api_param
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_app_api_type`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_api_type`;
CREATE TABLE `cms_app_api_type` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` int(11) DEFAULT '0',
  `name` varchar(30) DEFAULT NULL,
  `auto_position` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='接口分类';

-- ----------------------------
-- Records of cms_app_api_type
-- ----------------------------
INSERT INTO `cms_app_api_type` VALUES ('1', '0', '初始化', '1472026956', '2016-08-24 16:21:00');
INSERT INTO `cms_app_api_type` VALUES ('2', '0', '首页', '1472026967', '2016-08-24 16:21:00');
INSERT INTO `cms_app_api_type` VALUES ('3', '0', '会员', '1472026970', '2016-08-24 16:21:00');
INSERT INTO `cms_app_api_type` VALUES ('4', '0', '收货地址', '1472026978', '2016-08-24 16:21:00');
INSERT INTO `cms_app_api_type` VALUES ('5', '0', '商品', '1472026988', '2016-08-24 16:21:00');
INSERT INTO `cms_app_api_type` VALUES ('6', '0', '购物车', '1472026999', '2016-08-24 16:21:00');

-- ----------------------------
-- Table structure for `cms_app_datalog`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_datalog`;
CREATE TABLE `cms_app_datalog` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `app_id` int(11) DEFAULT '0',
  `device_id` varchar(40) DEFAULT NULL COMMENT '设备编号',
  `member_id` int(11) DEFAULT '0' COMMENT '会员ID',
  `acl` varchar(30) DEFAULT NULL COMMENT '控制器',
  `method` varchar(40) DEFAULT NULL COMMENT '方法',
  `request_data` text COMMENT '请求数据',
  `return_data` text COMMENT '服务器返回数据',
  `result` tinyint(4) DEFAULT '0' COMMENT '执行结果:1成功,0失败,-1需要登录',
  `ip_address` varchar(20) DEFAULT NULL COMMENT '客户端ip地址',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='app数据接口日志';

-- ----------------------------
-- Records of cms_app_datalog
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_app_device`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_device`;
CREATE TABLE `cms_app_device` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `app_id` tinyint(4) DEFAULT '0' COMMENT '备用字段用于同一项目中存在多个app的情况',
  `app_type` tinyint(4) DEFAULT '0' COMMENT '1:ios,2:android',
  `device_id` varchar(60) DEFAULT NULL COMMENT '设备号',
  `devie_type` varchar(40) DEFAULT '' COMMENT '设备型号，如iphone6s',
  `os_version` varchar(40) DEFAULT NULL COMMENT '系统版本，如ios版本号为:9.3.2',
  `lat` double(9,6) DEFAULT '0.000000' COMMENT 'GPS经度',
  `lng` double(9,6) DEFAULT '0.000000' COMMENT 'GPS纬度',
  `city_id` int(11) DEFAULT '0' COMMENT '城市ID',
  `city` varchar(20) DEFAULT NULL COMMENT '城市名称',
  `address` varchar(80) DEFAULT NULL COMMENT '地址',
  `push_id` varchar(20) DEFAULT NULL COMMENT '推送接口ID',
  `member_type` tinyint(4) DEFAULT '0' COMMENT '登录会员类型',
  `member_id` int(11) DEFAULT '0' COMMENT '登录会员ID',
  `token` varchar(20) DEFAULT NULL COMMENT '接口参数密钥,字段已弃用,改为使用会员表的token字段',
  `session_id` varchar(40) DEFAULT NULL COMMENT '服务端sessionID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='app设备表';

-- ----------------------------
-- Records of cms_app_device
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_app_version`
-- ----------------------------
DROP TABLE IF EXISTS `cms_app_version`;
CREATE TABLE `cms_app_version` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `app_id` int(11) DEFAULT '1',
  `os_type` tinyint(4) DEFAULT NULL COMMENT '系统类型,1:ios,2:android',
  `version_num` int(11) DEFAULT NULL COMMENT '版本号，100代表1.0.0',
  `version_name` varchar(30) DEFAULT NULL COMMENT '版本名称',
  `version_desc` varchar(100) DEFAULT NULL COMMENT '更新说明',
  `content_file` varchar(50) DEFAULT NULL COMMENT '下载文件，用于android',
  `content_url` varchar(100) DEFAULT NULL COMMENT '下载地址，用于ios',
  `publish` tinyint(4) DEFAULT '1' COMMENT '发布状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='app版本发布';

-- ----------------------------
-- Records of cms_app_version
-- ----------------------------
INSERT INTO `cms_app_version` VALUES ('1', '1', '2', '100', '1.0.0', '测试版', '2016/11/30/1480685314.apk', '', '1', '2016-07-17 15:39:31', '1');
INSERT INTO `cms_app_version` VALUES ('2', '1', '1', '100', '1.0.0', '测试版', '', 'https://itunes.apple.com/us/app/qing-qu-wai-mai/id1139047803?l=zh&ls=1&mt=8', '1', '2016-07-17 15:46:50', '1');

-- ----------------------------
-- Table structure for `cms_article`
-- ----------------------------
DROP TABLE IF EXISTS `cms_article`;
CREATE TABLE `cms_article` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `menu_id` int(11) DEFAULT NULL COMMENT '频道ID',
  `content_desc` varchar(500) DEFAULT NULL COMMENT '备注',
  `content_img` varchar(50) DEFAULT NULL COMMENT '图片',
  `content_body` text COMMENT '正文内容',
  `content_video` varchar(50) DEFAULT NULL COMMENT '视频地址',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=46 DEFAULT CHARSET=utf8 COMMENT='文章单页';

-- ----------------------------
-- Records of cms_article
-- ----------------------------
INSERT INTO `cms_article` VALUES ('45', '224', '', '', '<p>123</p>\n', '', '1', '2017-07-18 17:38:39');

-- ----------------------------
-- Table structure for `cms_cash_apply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_cash_apply`;
CREATE TABLE `cms_cash_apply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `content_mobile` varchar(20) DEFAULT NULL,
  `content_name` varchar(30) DEFAULT NULL,
  `content_money` double(10,2) DEFAULT NULL,
  `trans_type` tinyint(4) DEFAULT NULL,
  `account_info` varchar(100) DEFAULT NULL,
  `content_desc` varchar(100) DEFAULT NULL,
  `content_status` tinyint(4) DEFAULT '0',
  `create_user` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='提现申请';

-- ----------------------------
-- Records of cms_cash_apply
-- ----------------------------
INSERT INTO `cms_cash_apply` VALUES ('10', '29', '15101022452', '薛新峰', '50.00', '1', 'test', 'sdfsdfsdgsdg', '1', '1', '2016-11-10 18:26:04');
INSERT INTO `cms_cash_apply` VALUES ('11', '29', '15101022452', '薛新峰', '20.00', '2', '招行435345346346', '完成', '1', null, '2016-11-12 16:24:55');

-- ----------------------------
-- Table structure for `cms_comment`
-- ----------------------------
DROP TABLE IF EXISTS `cms_comment`;
CREATE TABLE `cms_comment` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_type` int(11) DEFAULT '1' COMMENT '评论类型:1新闻2产品',
  `member_name` varchar(20) DEFAULT NULL COMMENT '会员昵称',
  `object_id` int(11) DEFAULT NULL COMMENT '评论对象ID',
  `object_name` varchar(50) DEFAULT NULL COMMENT '评论对象名称',
  `content_comment` varchar(120) DEFAULT NULL COMMENT '评论内容',
  `publish` int(11) DEFAULT '1' COMMENT '发布状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='评论表';

-- ----------------------------
-- Records of cms_comment
-- ----------------------------
INSERT INTO `cms_comment` VALUES ('3', '8', '1', '中国工商银行', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', 'zailaiyici再来一次', '1', '2015-05-02 00:56:02');
INSERT INTO `cms_comment` VALUES ('4', '8', '1', '中国工商银行', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', '可以了', '1', '2015-05-02 00:56:12');
INSERT INTO `cms_comment` VALUES ('8', '13', '1', '薛新峰', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', '测试发表', '1', '2015-05-02 09:18:07');
INSERT INTO `cms_comment` VALUES ('9', '13', '1', '薛新峰', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', '测试发表', '1', '2015-05-02 09:18:11');
INSERT INTO `cms_comment` VALUES ('11', '13', '1', '薛新峰', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', '测试发表', '1', '2015-05-02 09:18:26');
INSERT INTO `cms_comment` VALUES ('12', '13', '1', '薛新峰', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', '测试发表', '1', '2015-05-02 09:18:32');
INSERT INTO `cms_comment` VALUES ('13', '13', '1', '薛新峰', '876', '美元理财产品收益持续下滑 平均收益率仅为1.46%', 'dfhdfh', '1', '2015-05-02 15:59:15');
INSERT INTO `cms_comment` VALUES ('14', '13', '2', '薛新峰', '16', '心喜系列2015年第11期人民币组合投资型非保本理财产品', 'tttt', '1', '2015-05-02 16:11:16');
INSERT INTO `cms_comment` VALUES ('15', '8', '2', '中国工商银行', '13', '保本型个人人民币理财产品(BBD15042)(仅深圳)', 'asfsaf', '1', '2015-05-02 22:39:55');
INSERT INTO `cms_comment` VALUES ('16', '8', '2', '中国工商银行', '13', '保本型个人人民币理财产品(BBD15042)(仅深圳)', 'tttt', '1', '2015-05-02 22:40:05');
INSERT INTO `cms_comment` VALUES ('17', '7', '3', '陆金所', '1', '测试003', '11111', '1', '2015-05-03 21:01:03');

-- ----------------------------
-- Table structure for `cms_course`
-- ----------------------------
DROP TABLE IF EXISTS `cms_course`;
CREATE TABLE `cms_course` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(40) DEFAULT NULL COMMENT '课程名称',
  `sub_title` varchar(60) DEFAULT NULL COMMENT '副标题',
  `goods_sn` varchar(30) DEFAULT NULL COMMENT '课程编号',
  `category_id` int(20) DEFAULT NULL COMMENT '课程分类ID',
  `menu_id` int(11) DEFAULT '0' COMMENT '栏目id',
  `brand_id` int(11) DEFAULT NULL COMMENT '品牌ID',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '课程简介',
  `content_price` double(12,2) DEFAULT '0.00' COMMENT '价格',
  `content_num` int(11) DEFAULT '99999' COMMENT '库存',
  `market_price` double(12,2) DEFAULT '0.00' COMMENT '市场价',
  `content_salesnum` int(11) DEFAULT '0' COMMENT '报名人数',
  `publish` tinyint(4) DEFAULT '1' COMMENT '发布状态',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `position` int(11) DEFAULT '999' COMMENT '排序位置序号',
  `activity_status` tinyint(4) DEFAULT '0' COMMENT '是否开启活动',
  `activity_begin_date` datetime DEFAULT NULL COMMENT '活动开始时间',
  `activity_end_date` datetime DEFAULT NULL COMMENT '活动结束时间',
  `activity_price` double(12,2) DEFAULT NULL COMMENT '活动价格',
  `content_img` varchar(50) DEFAULT NULL COMMENT '图片1',
  `content_img2` varchar(50) DEFAULT NULL COMMENT '图片2',
  `content_img3` varchar(50) DEFAULT NULL COMMENT '图片3',
  `recommend_img` varchar(50) DEFAULT NULL COMMENT '推荐图片',
  `content_body` text COMMENT '正文内容',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='课程表';

-- ----------------------------
-- Records of cms_course
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_course_apply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_course_apply`;
CREATE TABLE `cms_course_apply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `parent_name` varchar(40) DEFAULT NULL COMMENT '家长姓名',
  `content_name` varchar(30) DEFAULT NULL COMMENT '孩子姓名',
  `content_tel` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `content_email` varchar(50) DEFAULT NULL COMMENT '联系邮箱',
  `content_birthday` varchar(20) DEFAULT NULL COMMENT '出生日期',
  `content_age` tinyint(4) DEFAULT NULL COMMENT '年龄',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '备注',
  `province_id` int(11) DEFAULT NULL COMMENT '所在省份ID',
  `school_id` int(11) DEFAULT NULL COMMENT '报名校区ID',
  `school_name` varchar(50) DEFAULT NULL COMMENT '校区名称',
  `content_status` tinyint(4) DEFAULT '0' COMMENT '处理状态:0未处理,1已处理',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员id',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='课程申请表';

-- ----------------------------
-- Records of cms_course_apply
-- ----------------------------
INSERT INTO `cms_course_apply` VALUES ('1', '公司名称', '张三', '67312300', 'efsdf@163.com', null, '1', '测试简介', '1', '1', '测试专题01', '1', '2014-09-09 00:49:54', '1');
INSERT INTO `cms_course_apply` VALUES ('2', 'a343', 'b', 'd', 'e', null, '2', 'h', '3', '1', '测试专题01', '1', '2015-04-08 17:29:33', '1');
INSERT INTO `cms_course_apply` VALUES ('3', '测试', null, '2423523653', 'xuefeng@163.com', '1987-02-04', '3', '', '5', '1', '测试专题01', '0', '2015-07-12 17:00:06', null);
INSERT INTO `cms_course_apply` VALUES ('4', 'aa', null, '15101022342', 'xuexinfeng@126.com', '2015-07-19', null, null, '1', '1', '北京分中心', '0', '2015-07-19 17:07:28', null);
INSERT INTO `cms_course_apply` VALUES ('5', 'aas', null, '15101022453', '', '2015-07-30', null, '', '1', '1', '', '0', '2015-07-19 17:09:42', null);
INSERT INTO `cms_course_apply` VALUES ('6', 'hongjun', null, '17710096069', 'hjyygs123@126.com', '2015-06-29', null, '', '1', '1', '北京分中心', '0', '0000-00-00 00:00:00', null);
INSERT INTO `cms_course_apply` VALUES ('7', 'ksdjkdj', null, '15629328249', '1313@qq.com', '2015-07-01', null, null, '1', '1', '北京分中心', '0', '2015-07-24 02:04:12', null);
INSERT INTO `cms_course_apply` VALUES ('8', '洪君', null, '13811903243', 'hong-jun83@126.com', '2009-07-08', null, null, '1', '1', '优贝乐（常营）校区', '0', '2015-07-24 03:15:39', null);
INSERT INTO `cms_course_apply` VALUES ('9', 'jg', null, '13254454541', null, '2015-07-01', null, null, '27', '29', '优贝乐（西安）校区', '0', '2015-07-28 15:29:29', null);
INSERT INTO `cms_course_apply` VALUES ('10', '234aa', null, '15101022452', null, '2015-08-12', null, null, '1', '8', '优贝乐（怀柔）校区', '0', '2015-08-02 12:01:07', null);

-- ----------------------------
-- Table structure for `cms_course_category`
-- ----------------------------
DROP TABLE IF EXISTS `cms_course_category`;
CREATE TABLE `cms_course_category` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `content_name` varchar(30) DEFAULT NULL COMMENT '分类名称',
  `auto_code` varchar(20) DEFAULT NULL COMMENT '分类自增编码(四位数字代表一级)',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `auto_position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='课程分类表';

-- ----------------------------
-- Records of cms_course_category
-- ----------------------------
INSERT INTO `cms_course_category` VALUES ('1', 'C-CREATIVITY 创造性游戏阶段 0-3岁', '1000', '1', '1414681424', '2014-10-30 23:03:11', '1');
INSERT INTO `cms_course_category` VALUES ('2', 'T-THINKING 创造性思维阶段 3-6岁', '1001', '1', '1414681435', '2014-10-30 23:03:48', '1');
INSERT INTO `cms_course_category` VALUES ('6', 'S-SCIENCE 创造性科学阶段 6+', '1002', '1', '1415278906', '2014-11-06 21:01:29', '1');
INSERT INTO `cms_course_category` VALUES ('10', 'CREATIVE ART 创意艺术课程 1-3岁', '1003', '1', '1430749700', '2015-05-04 22:28:15', '1');
INSERT INTO `cms_course_category` VALUES ('11', 'MUSICAL INTELLIGENCE音乐智能课程0-5岁', '1004', '1', '1430749705', '2015-05-04 22:28:20', '1');
INSERT INTO `cms_course_category` VALUES ('31', 'MATHEMATICAL THINKING数学思维课程3-6', '1005', '1', '1436088289', '2015-07-05 17:24:46', '1');

-- ----------------------------
-- Table structure for `cms_define_url`
-- ----------------------------
DROP TABLE IF EXISTS `cms_define_url`;
CREATE TABLE `cms_define_url` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `acl` varchar(30) DEFAULT '' COMMENT '控制器名称',
  `method` varchar(30) DEFAULT '' COMMENT '方法名称',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `data_id` int(11) DEFAULT NULL COMMENT '数据ID',
  `id_field` varchar(30) DEFAULT NULL COMMENT '数据ID对应的get参数字段名',
  `url_path` varchar(50) DEFAULT '' COMMENT '目录，可设置多级，以/开头，结尾不加/',
  `file_name` varchar(50) DEFAULT NULL COMMENT '文件名，如test.html',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='自定义url，用于静态化';

-- ----------------------------
-- Records of cms_define_url
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_dictionary`
-- ----------------------------
DROP TABLE IF EXISTS `cms_dictionary`;
CREATE TABLE `cms_dictionary` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(25) DEFAULT NULL COMMENT '变量名(英文，用于程序调用的名称)',
  `content_text` varchar(20) DEFAULT NULL COMMENT '变量名称(中文)',
  `content_desc` varchar(100) DEFAULT NULL COMMENT '简介',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COMMENT='数据字典表';

-- ----------------------------
-- Records of cms_dictionary
-- ----------------------------
INSERT INTO `cms_dictionary` VALUES ('19', 'cashApplyTypeVars', '提现申请方式', '', '999', '1', '2016-11-13 17:57:03');

-- ----------------------------
-- Table structure for `cms_dictionary_item`
-- ----------------------------
DROP TABLE IF EXISTS `cms_dictionary_item`;
CREATE TABLE `cms_dictionary_item` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `dictionary_id` int(11) DEFAULT NULL COMMENT '变量ID',
  `content_text` varchar(20) DEFAULT NULL COMMENT '选项名称',
  `content_value` varchar(20) DEFAULT NULL COMMENT '选项值',
  `content_desc` varchar(200) DEFAULT NULL COMMENT '简介',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=71 DEFAULT CHARSET=utf8 COMMENT='数据字典变量选项表';

-- ----------------------------
-- Records of cms_dictionary_item
-- ----------------------------
INSERT INTO `cms_dictionary_item` VALUES ('69', '19', '支付宝', '1', '', '1', '999', '1', '2016-11-13 17:57:27');
INSERT INTO `cms_dictionary_item` VALUES ('70', '19', '网银转账', '2', '', '1', '999', '1', '2016-11-13 17:57:35');

-- ----------------------------
-- Table structure for `cms_email_record`
-- ----------------------------
DROP TABLE IF EXISTS `cms_email_record`;
CREATE TABLE `cms_email_record` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_email` varchar(60) DEFAULT NULL COMMENT '收件人邮箱',
  `content_title` varchar(60) DEFAULT NULL COMMENT '邮件标题',
  `content_body` text COMMENT '邮件正文',
  `content_result` tinyint(4) DEFAULT '0' COMMENT '是否发送成功',
  `from_email` varchar(60) DEFAULT NULL COMMENT '发信人邮箱',
  `create_time` datetime DEFAULT NULL COMMENT '发送时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='邮件记录';

-- ----------------------------
-- Records of cms_email_record
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_email_templet`
-- ----------------------------
DROP TABLE IF EXISTS `cms_email_templet`;
CREATE TABLE `cms_email_templet` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_event` varchar(30) DEFAULT NULL COMMENT '事件标识(程序读取)',
  `content_title` varchar(50) DEFAULT NULL COMMENT '邮件标题',
  `content_body` text COMMENT '邮件内容',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='邮件模板';

-- ----------------------------
-- Records of cms_email_templet
-- ----------------------------
INSERT INTO `cms_email_templet` VALUES ('1', 'forgetPwd', '使用邮箱重置密码', '<p>尊敬的用户，您好:<br />\n您正在使用密码找回功能，请点击下方链接进行下一步操作（或将链接复制到浏览器地址栏运行），如非本人操作请忽略本邮件。<br />\n<br />\n{link}</p>\n', '1', '999', '2017-03-03 16:28:55', '1');
INSERT INTO `cms_email_templet` VALUES ('2', '', '邮件标题', '<p>邮件正文</p>\n', '1', '999', '2017-03-03 16:35:10', '1');
INSERT INTO `cms_email_templet` VALUES ('3', 'editEmail', '修改邮箱', '<p>尊敬的用户，您好:<br />\n您正在使用修改邮箱功能，验证码为{code}，如非本人操作请忽略本邮件。<br />\n&nbsp;</p>\n', '1', '999', '2017-04-14 15:31:43', '1');

-- ----------------------------
-- Table structure for `cms_event_type`
-- ----------------------------
DROP TABLE IF EXISTS `cms_event_type`;
CREATE TABLE `cms_event_type` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) DEFAULT '1' COMMENT '1:积分事件,2:账户事件',
  `rate` tinyint(4) DEFAULT '1' COMMENT '1:每天,2每次',
  `name` varchar(30) DEFAULT NULL,
  `event` varchar(30) DEFAULT NULL,
  `num` int(11) DEFAULT '0' COMMENT '数值',
  `publish` tinyint(4) DEFAULT '1',
  `position` int(11) DEFAULT '999',
  `create_time` datetime DEFAULT NULL,
  `create_user` int(11) DEFAULT '1',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_event_type
-- ----------------------------
INSERT INTO `cms_event_type` VALUES ('1', '1', '1', '每天首次登陆', 'login', '10', '1', '999', '2017-03-05 16:44:30', '1');
INSERT INTO `cms_event_type` VALUES ('2', '1', '1', '每天首次上传策略附件', 'uploadStrategyFile', '10', '1', '999', '2017-03-05 16:46:44', '1');
INSERT INTO `cms_event_type` VALUES ('3', '2', '3', '会员首次认证', 'memberAuth', '50', '1', '999', '2017-03-11 15:25:43', '1');
INSERT INTO `cms_event_type` VALUES ('4', '1', '1', '每天首次发表话题', 'publishSubject', '5', '1', '999', '2017-03-11 15:27:22', '1');
INSERT INTO `cms_event_type` VALUES ('5', '1', '1', '每天首次评论话题', 'replySubject', '2', '1', '999', '2017-03-11 15:28:12', '1');
INSERT INTO `cms_event_type` VALUES ('6', '1', '3', '会员注册', 'register', '50', '1', '999', '2017-03-11 15:56:27', '1');

-- ----------------------------
-- Table structure for `cms_exam`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam`;
CREATE TABLE `cms_exam` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_title` varchar(100) DEFAULT NULL COMMENT '标题',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '简介',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='问卷调查';

-- ----------------------------
-- Records of cms_exam
-- ----------------------------
INSERT INTO `cms_exam` VALUES ('1', '测试使用的', '235235', '0', '777', '2015-04-06 18:57:07', '1');
INSERT INTO `cms_exam` VALUES ('2', '个人投资者风险承受能力调查问卷', '本问卷旨在了解您对投资风险的承受意愿及能力\r\n问卷结果可能不能完全呈现您面对投资风险的真正态度，您可和您的投资顾问或我们的客服进一步沟通。', '1', '666', '2015-04-06 18:58:18', '1');

-- ----------------------------
-- Table structure for `cms_exam_question`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam_question`;
CREATE TABLE `cms_exam_question` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT NULL COMMENT '问卷ID',
  `content_name` varchar(100) DEFAULT NULL COMMENT '问题标题',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '问题描述',
  `content_img` varchar(40) DEFAULT NULL COMMENT '问题图片',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='问卷调查问题表';

-- ----------------------------
-- Records of cms_exam_question
-- ----------------------------
INSERT INTO `cms_exam_question` VALUES ('1', '1', '鳞片颜色', 'sdhgbggg', '2014/10/05/1413151943.png', '1', '88', '2014-09-21 15:47:52', null);
INSERT INTO `cms_exam_question` VALUES ('2', '1', '鳞片形状', '22222', '', '1', '999', '2014-09-21 15:48:16', null);
INSERT INTO `cms_exam_question` VALUES ('5', '1', '题目002', null, null, '1', '77', '2015-04-06 22:10:39', null);
INSERT INTO `cms_exam_question` VALUES ('6', '2', '您个人目前已经或者准备投资的基金金额占您或者家庭所拥有的总资产的比重是多少（备注：总资产包括存款、证券投资、房地产及实业等）', null, null, '1', '999', '2015-04-29 17:41:24', null);
INSERT INTO `cms_exam_question` VALUES ('7', '2', '您目前的个人及家庭财务状况属于以下哪一种', null, null, '1', '999', '2015-04-29 17:45:05', null);
INSERT INTO `cms_exam_question` VALUES ('8', '2', '您的年收入是多少', null, null, '1', '999', '2015-04-29 17:47:39', null);
INSERT INTO `cms_exam_question` VALUES ('9', '2', '您计划中的基金投资期限是多长', null, null, '1', '999', '2015-04-29 17:48:02', null);
INSERT INTO `cms_exam_question` VALUES ('10', '2', '您是否有过股票与基金的投资经历，如有，投资时间是多长', null, null, '1', '999', '2015-04-29 17:48:25', null);

-- ----------------------------
-- Table structure for `cms_exam_question_answer`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam_question_answer`;
CREATE TABLE `cms_exam_question_answer` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT NULL COMMENT '问题ID',
  `content_name` varchar(60) DEFAULT NULL COMMENT '选项内容',
  `content_score` int(11) DEFAULT '0' COMMENT '得分',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='问卷答案选项表';

-- ----------------------------
-- Records of cms_exam_question_answer
-- ----------------------------
INSERT INTO `cms_exam_question_answer` VALUES ('1', '1', '棕褐色、灰色鳞片', '0', '1', '999', '2014-09-21 15:59:11', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('2', '1', '多为白色或浅肤色', '0', '1', '333', '2014-09-21 15:59:44', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('3', '1', '鳞屑偏黑、褐色', '3', '1', '444', '2014-09-21 15:59:48', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('4', '2', '圆形', '0', '1', '999', '2014-10-05 22:52:28', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('5', '2', '三角形', '0', '1', '999', '2014-10-05 22:52:35', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('6', '1', '皮肤发红、鳞屑呈褐色、褐色', '0', '1', '999', '2014-10-07 21:02:25', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('7', '1', '覆盖黄、白色胶质物，胶质物脱落露出红色皮肤', '0', '1', '999', '2014-10-07 21:02:38', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('8', '2', '鱼鳞形', '0', '1', '999', '2014-10-07 21:03:44', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('9', '5', '001', '1', '1', '999', '2015-04-29 11:29:24', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('10', '5', '002', '2', '1', '999', '2015-04-29 11:29:32', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('11', '6', '80%以上', '5', '1', '999', '2015-04-29 17:43:56', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('12', '6', '50%-80%', '4', '1', '999', '2015-04-29 17:44:13', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('13', '6', '20%-50%', '3', '1', '999', '2015-04-29 17:44:26', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('14', '6', '10%-20%', '2', '1', '999', '2015-04-29 17:44:35', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('15', '6', '0-10%', '1', '1', '999', '2015-04-29 17:44:44', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('16', '7', '有未到期的贷款或借款', '1', '1', '999', '2015-04-29 17:46:01', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('17', '7', '收入和支出相抵', '2', '1', '999', '2015-04-29 17:46:24', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('18', '7', '有一定积蓄', '3', '1', '999', '2015-04-29 17:46:36', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('19', '7', '有较为丰厚的积蓄并有一定的投资', '4', '1', '999', '2015-04-29 17:46:43', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('20', '7', '比较富裕且有相当的投资', '5', '1', '999', '2015-04-29 17:47:08', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('21', '8', '2万元以下', '1', '1', '999', '2015-04-29 17:49:17', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('22', '8', '2万元至5万元', '2', '1', '999', '2015-04-29 17:49:36', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('23', '8', '5万元至15万元', '3', '1', '999', '2015-04-29 17:49:49', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('24', '8', '15万元至50万元', '4', '1', '999', '2015-04-29 17:50:01', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('25', '8', '50万元以上', '5', '1', '999', '2015-04-29 17:50:13', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('26', '9', '没有期限，想短炒一把', '1', '1', '999', '2015-04-29 17:50:39', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('27', '9', '少于1年', '2', '1', '999', '2015-04-29 17:51:04', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('28', '9', '1-3年', '3', '1', '999', '2015-04-29 17:51:14', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('29', '9', '3-5年', '4', '1', '999', '2015-04-29 17:51:21', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('30', '9', '5年以上', '5', '1', '999', '2015-04-29 17:51:27', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('31', '10', '没有', '1', '1', '999', '2015-04-29 17:51:47', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('32', '10', '有，但是少于1年', '2', '1', '999', '2015-04-29 17:52:05', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('33', '10', '有，在1-3年之间', '3', '1', '999', '2015-04-29 17:52:16', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('34', '10', '有，在3-5年之间', '4', '1', '999', '2015-04-29 17:52:30', '1');
INSERT INTO `cms_exam_question_answer` VALUES ('35', '10', '有，长于5年', '5', '1', '999', '2015-04-29 17:52:42', '1');

-- ----------------------------
-- Table structure for `cms_exam_record`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam_record`;
CREATE TABLE `cms_exam_record` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT NULL COMMENT '问卷ID',
  `session_id` varchar(40) DEFAULT NULL COMMENT '用户sessionID',
  `member_id` int(11) DEFAULT '0' COMMENT '会员ID',
  `content_ip` varchar(20) DEFAULT NULL COMMENT '用户IP地址',
  `content_score` int(11) DEFAULT '0' COMMENT '总分数',
  `content_info` varchar(50) DEFAULT NULL COMMENT '用户信息预留字段',
  `result_id` int(11) DEFAULT '0' COMMENT '测试结果ID',
  `content_result` varchar(100) DEFAULT NULL COMMENT '测试结果名称',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='问卷答题记录';

-- ----------------------------
-- Records of cms_exam_record
-- ----------------------------
INSERT INTO `cms_exam_record` VALUES ('1', '1', null, '0', 'dsfsd22', '0', null, '0', 'sdgdsh', '2014-09-21 18:07:33');
INSERT INTO `cms_exam_record` VALUES ('2', '1', null, '0', '192.168.1.1', '0', null, '0', 'sdfdsggsg', '2014-09-21 18:09:33');
INSERT INTO `cms_exam_record` VALUES ('3', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 Ů,', '0', '寻常型鱼鳞病:35%\n板层型鱼鳞病:10%\n大疱型红皮样鱼鳞病:40%\n', '2014-10-05 23:05:50');
INSERT INTO `cms_exam_record` VALUES ('4', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 Ů,', '0', '寻常型鱼鳞病:35%\n板层型鱼鳞病:10%\n大疱型红皮样鱼鳞病:40%\n', '2014-10-05 23:06:38');
INSERT INTO `cms_exam_record` VALUES ('5', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 Ů,', '0', '大疱型红皮样鱼鳞病:100%\n寻常型鱼鳞病:15%\n', '2014-10-05 23:10:18');
INSERT INTO `cms_exam_record` VALUES ('6', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 男,背面', '0', '性连型鱼鳞病:50%\n板层型鱼鳞病:34%\n', '2014-10-05 23:47:42');
INSERT INTO `cms_exam_record` VALUES ('7', '1', null, '0', '192.168.1.105', '0', '河北省,廊坊市 男,正面', '0', '大疱型红皮样鱼鳞病:100%\n寻常型鱼鳞病:15%\n', '2014-10-06 09:57:19');
INSERT INTO `cms_exam_record` VALUES ('8', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 男,正面', '0', '性连型鱼鳞病:50%\n板层型鱼鳞病:34%\n', '2014-10-06 22:29:22');
INSERT INTO `cms_exam_record` VALUES ('9', '1', null, '0', '192.168.1.104', '0', '河北省,廊坊市 女,正面', '0', '性连型鱼鳞病:50%\n板层型鱼鳞病:50%\n', '2014-10-07 21:08:01');
INSERT INTO `cms_exam_record` VALUES ('10', '1', null, '0', '192.168.1.104', '0', '河北省,廊坊市 女,正面', '0', '性连型鱼鳞病:50%\n板层型鱼鳞病:34%\n', '2014-10-07 21:08:43');
INSERT INTO `cms_exam_record` VALUES ('11', '1', null, '0', '192.168.1.104', '0', '河北省,廊坊市 女,正面', '0', '大疱型红皮样鱼鳞病:80%\n板层型鱼鳞病:34%\n', '2014-10-07 21:09:24');
INSERT INTO `cms_exam_record` VALUES ('12', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 女,正面', '0', '板层型鱼鳞病:34%\n', '2014-10-07 23:02:50');
INSERT INTO `cms_exam_record` VALUES ('13', '1', null, '0', '127.0.0.1', '0', '河北省,廊坊市 女,正面', '0', '大疱型红皮样鱼鳞病:80%\n板层型鱼鳞病:34%\n', '2014-10-09 19:56:16');
INSERT INTO `cms_exam_record` VALUES ('14', '1', null, '0', '192.168.1.104', '0', '河北省,廊坊市 女,正面', '0', '性连型鱼鳞病:50%\n板层型鱼鳞病:34%\n', '2014-10-09 19:57:01');
INSERT INTO `cms_exam_record` VALUES ('15', '1', null, '0', '127.0.0.1', '0', ', 女,正面', '0', '大疱型红皮样鱼鳞病:80%\n板层型鱼鳞病:34%\n', '2014-10-17 12:33:35');
INSERT INTO `cms_exam_record` VALUES ('17', '1', null, '0', '192.168.1.104', '0', ', 女,正面', '0', '大疱型红皮样鱼鳞病:80%\n板层型鱼鳞病:34%\n', '2014-10-17 12:42:15');
INSERT INTO `cms_exam_record` VALUES ('18', '1', null, '0', '127.0.0.1', '0', ', 女,正面', '0', '大疱型红皮样鱼鳞病:80%\n板层型鱼鳞病:34%\n', '2015-03-31 22:40:53');
INSERT INTO `cms_exam_record` VALUES ('19', '1', null, '13', '127.0.0.1', '2', null, '1', '低风险', '2015-04-29 16:01:45');
INSERT INTO `cms_exam_record` VALUES ('20', '1', null, '13', '127.0.0.1', '1', null, '1', '低风险', '2015-04-29 16:04:48');
INSERT INTO `cms_exam_record` VALUES ('21', '2', null, '13', '127.0.0.1', '25', null, '7', '进取型', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record` VALUES ('22', '2', null, '0', '::1', '12', null, '5', '平衡型', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record` VALUES ('23', '2', null, '0', '::1', '12', null, '5', '平衡型', '2017-01-22 16:56:53');

-- ----------------------------
-- Table structure for `cms_exam_record_answer`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam_record_answer`;
CREATE TABLE `cms_exam_record_answer` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT NULL COMMENT '测试记录ID',
  `question_id` int(11) DEFAULT NULL COMMENT '问题ID',
  `answer_id` int(11) DEFAULT NULL COMMENT '答案ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='问卷记录答案表';

-- ----------------------------
-- Records of cms_exam_record_answer
-- ----------------------------
INSERT INTO `cms_exam_record_answer` VALUES ('1', '1', '1', '1', '2014-09-21 18:14:20');
INSERT INTO `cms_exam_record_answer` VALUES ('2', '4', '1', '2', '2014-10-05 23:06:38');
INSERT INTO `cms_exam_record_answer` VALUES ('3', '4', '2', '4', '2014-10-05 23:06:38');
INSERT INTO `cms_exam_record_answer` VALUES ('4', '5', '1', '3', '2014-10-05 23:10:18');
INSERT INTO `cms_exam_record_answer` VALUES ('5', '5', '2', '4', '2014-10-05 23:10:18');
INSERT INTO `cms_exam_record_answer` VALUES ('6', '6', '1', '1', '2014-10-05 23:47:42');
INSERT INTO `cms_exam_record_answer` VALUES ('7', '6', '2', '5', '2014-10-05 23:47:42');
INSERT INTO `cms_exam_record_answer` VALUES ('8', '7', '1', '3', '2014-10-06 09:57:19');
INSERT INTO `cms_exam_record_answer` VALUES ('9', '7', '2', '4', '2014-10-06 09:57:19');
INSERT INTO `cms_exam_record_answer` VALUES ('10', '8', '1', '1', '2014-10-06 22:29:22');
INSERT INTO `cms_exam_record_answer` VALUES ('11', '8', '2', '5', '2014-10-06 22:29:22');
INSERT INTO `cms_exam_record_answer` VALUES ('12', '9', '1', '1', '2014-10-07 21:08:01');
INSERT INTO `cms_exam_record_answer` VALUES ('13', '9', '2', '8', '2014-10-07 21:08:01');
INSERT INTO `cms_exam_record_answer` VALUES ('14', '10', '1', '1', '2014-10-07 21:08:43');
INSERT INTO `cms_exam_record_answer` VALUES ('15', '10', '2', '5', '2014-10-07 21:08:43');
INSERT INTO `cms_exam_record_answer` VALUES ('16', '11', '1', '3', '2014-10-07 21:09:24');
INSERT INTO `cms_exam_record_answer` VALUES ('17', '11', '2', '5', '2014-10-07 21:09:24');
INSERT INTO `cms_exam_record_answer` VALUES ('18', '12', '1', '6', '2014-10-07 23:02:50');
INSERT INTO `cms_exam_record_answer` VALUES ('19', '12', '2', '5', '2014-10-07 23:02:50');
INSERT INTO `cms_exam_record_answer` VALUES ('20', '13', '1', '3', '2014-10-09 19:56:17');
INSERT INTO `cms_exam_record_answer` VALUES ('21', '13', '2', '5', '2014-10-09 19:56:17');
INSERT INTO `cms_exam_record_answer` VALUES ('22', '14', '1', '1', '2014-10-09 19:57:01');
INSERT INTO `cms_exam_record_answer` VALUES ('23', '14', '2', '5', '2014-10-09 19:57:01');
INSERT INTO `cms_exam_record_answer` VALUES ('24', '15', '1', '3', '2014-10-17 12:33:35');
INSERT INTO `cms_exam_record_answer` VALUES ('25', '15', '2', '5', '2014-10-17 12:33:35');
INSERT INTO `cms_exam_record_answer` VALUES ('26', '16', '1', '2', '2014-10-17 12:39:53');
INSERT INTO `cms_exam_record_answer` VALUES ('27', '16', '2', '5', '2014-10-17 12:39:53');
INSERT INTO `cms_exam_record_answer` VALUES ('28', '17', '1', '3', '2014-10-17 12:42:15');
INSERT INTO `cms_exam_record_answer` VALUES ('29', '17', '2', '5', '2014-10-17 12:42:15');
INSERT INTO `cms_exam_record_answer` VALUES ('30', '18', '1', '3', '2015-03-31 22:40:53');
INSERT INTO `cms_exam_record_answer` VALUES ('31', '18', '2', '5', '2015-03-31 22:40:53');
INSERT INTO `cms_exam_record_answer` VALUES ('32', '19', '5', '10', '2015-04-29 16:01:45');
INSERT INTO `cms_exam_record_answer` VALUES ('33', '19', '1', '1', '2015-04-29 16:01:45');
INSERT INTO `cms_exam_record_answer` VALUES ('34', '19', '2', '5', '2015-04-29 16:01:45');
INSERT INTO `cms_exam_record_answer` VALUES ('35', '20', '5', '9', '2015-04-29 16:04:48');
INSERT INTO `cms_exam_record_answer` VALUES ('36', '20', '1', '2', '2015-04-29 16:04:48');
INSERT INTO `cms_exam_record_answer` VALUES ('37', '20', '2', '5', '2015-04-29 16:04:48');
INSERT INTO `cms_exam_record_answer` VALUES ('38', '21', '6', '11', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record_answer` VALUES ('39', '21', '7', '20', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record_answer` VALUES ('40', '21', '8', '25', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record_answer` VALUES ('41', '21', '9', '30', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record_answer` VALUES ('42', '21', '10', '35', '2015-04-29 17:59:05');
INSERT INTO `cms_exam_record_answer` VALUES ('43', '22', '6', '12', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record_answer` VALUES ('44', '22', '7', '17', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record_answer` VALUES ('45', '22', '8', '21', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record_answer` VALUES ('46', '22', '9', '27', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record_answer` VALUES ('47', '22', '10', '33', '2017-01-22 16:55:49');
INSERT INTO `cms_exam_record_answer` VALUES ('48', '23', '6', '12', '2017-01-22 16:56:53');
INSERT INTO `cms_exam_record_answer` VALUES ('49', '23', '7', '17', '2017-01-22 16:56:53');
INSERT INTO `cms_exam_record_answer` VALUES ('50', '23', '8', '21', '2017-01-22 16:56:53');
INSERT INTO `cms_exam_record_answer` VALUES ('51', '23', '9', '27', '2017-01-22 16:56:53');
INSERT INTO `cms_exam_record_answer` VALUES ('52', '23', '10', '33', '2017-01-22 16:56:53');

-- ----------------------------
-- Table structure for `cms_exam_result`
-- ----------------------------
DROP TABLE IF EXISTS `cms_exam_result`;
CREATE TABLE `cms_exam_result` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT NULL COMMENT '问卷ID',
  `content_title` varchar(40) DEFAULT NULL COMMENT '结果名称',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '结果说明',
  `content_score` int(11) DEFAULT '0' COMMENT '达到此结果的最低分值',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='问卷结果分类表';

-- ----------------------------
-- Records of cms_exam_result
-- ----------------------------
INSERT INTO `cms_exam_result` VALUES ('1', '1', '低风险', '您的风险偏好偏低，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '0', '999');
INSERT INTO `cms_exam_result` VALUES ('2', '1', '中风险', '您的风险偏好适中，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '50', '888');
INSERT INTO `cms_exam_result` VALUES ('3', '2', '保守型', '您的风险偏好保守，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '0', '999');
INSERT INTO `cms_exam_result` VALUES ('4', '2', '稳健型', '您的风险偏好稳健，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '5', '999');
INSERT INTO `cms_exam_result` VALUES ('5', '2', '平衡型', '您的风险偏好平衡，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '10', '999');
INSERT INTO `cms_exam_result` VALUES ('6', '2', '积极型', '您的风险偏好积极，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '15', '999');
INSERT INTO `cms_exam_result` VALUES ('7', '2', '进取型', '您的风险偏好进取，您对投资的期望是用平衡的风险换取合理的回报，不过度追求风险也不过度追求收益。', '20', '999');

-- ----------------------------
-- Table structure for `cms_example`
-- ----------------------------
DROP TABLE IF EXISTS `cms_example`;
CREATE TABLE `cms_example` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `content_name` varchar(60) DEFAULT NULL COMMENT '名称字段',
  `favor` varchar(50) DEFAULT NULL,
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `content_desc` varchar(255) DEFAULT NULL COMMENT '简介字段',
  `content_body` text COMMENT '正文字段',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片字段',
  `content_file` varchar(60) DEFAULT NULL,
  `content_video` varchar(60) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='模型开发参考';

-- ----------------------------
-- Records of cms_example
-- ----------------------------
INSERT INTO `cms_example` VALUES ('4', '0', '55555', ';1;2;', '1', '88', '0', '4444444', '<p>aaaaaa</p>\n', '2016/11/24/1480314134.jpg', '2016/11/24/1480302506.docx', '2016/11/24/1480475979.mp4', '2015-01-25 21:28:03', '1');
INSERT INTO `cms_example` VALUES ('5', null, '4356', ';1;3;', '1', '999', '0', '4444', null, null, null, null, '2016-08-03 15:17:52', null);
INSERT INTO `cms_example` VALUES ('6', '0', '234234', '', '1', '999', '0', '23423', '', '', '', '', '2016-11-24 16:46:47', '1');
INSERT INTO `cms_example` VALUES ('7', '0', '343534534', '', '1', '999', '0', 'dddddddd', '', '', '', '', '2016-11-24 22:58:11', '1');
INSERT INTO `cms_example` VALUES ('8', '0', '2222222', '', '1', '999', '0', '2222222222222', '', '', '', '', '2017-05-12 15:04:58', '1');
INSERT INTO `cms_example` VALUES ('9', '0', '2222222', '', '1', '999', '0', '2222222222222', '', '', '', '', '2017-05-12 15:04:58', '1');
INSERT INTO `cms_example` VALUES ('10', '0', '2222222', '', '1', '999', '0', '2222222222222', '', '', '', '', '2017-05-12 15:04:58', '1');
INSERT INTO `cms_example` VALUES ('11', '0', '11111111111', '', '1', '999', '0', '111111111111', '', '', '', '', '2017-05-12 15:15:39', '1');
INSERT INTO `cms_example` VALUES ('12', '0', '111111111112', '', '1', '999', '0', '1111111111112', '', '', '', '', '2017-05-12 15:15:39', '1');
INSERT INTO `cms_example` VALUES ('13', '0', '111111111', '', '1', '999', '0', '1111111111111111', '', '', '', '', '2017-05-12 15:16:07', '1');
INSERT INTO `cms_example` VALUES ('14', '0', '111111111222', '', '1', '999', '0', '1111111111111111222', '', '', '', '', '2017-05-12 15:16:07', '1');
INSERT INTO `cms_example` VALUES ('15', '0', '111111', '', '1', '999', '0', '111111111111111111', '', '', '', '', '2017-05-12 15:17:39', '1');
INSERT INTO `cms_example` VALUES ('16', '0', '111111111111', '', '1', '999', '0', '1111111111111', '', '', '', '', '2017-05-12 15:17:59', '1');
INSERT INTO `cms_example` VALUES ('17', '0', '3333333333334', '', '1', '999', '0', '3333333333334', '', '', '', '', '2017-05-12 15:18:50', '1');

-- ----------------------------
-- Table structure for `cms_forbidden_ip`
-- ----------------------------
DROP TABLE IF EXISTS `cms_forbidden_ip`;
CREATE TABLE `cms_forbidden_ip` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `begin_ip` varchar(20) DEFAULT '',
  `end_ip` varchar(20) DEFAULT '',
  `begin_ip_value` bigint(12) DEFAULT '0',
  `end_ip_value` bigint(12) DEFAULT '0',
  `publish` tinyint(4) DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `create_user` int(11) DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_forbidden_ip
-- ----------------------------
INSERT INTO `cms_forbidden_ip` VALUES ('1', '192.168.1.186', '192.168.1.190', '192168001186', '192168001190', '0', '2017-03-04 08:19:04', '1');
INSERT INTO `cms_forbidden_ip` VALUES ('2', '192.168.1.101', '192.168.1.185', '192168001101', '192168001185', '0', '2017-03-04 08:20:47', '1');

-- ----------------------------
-- Table structure for `cms_job`
-- ----------------------------
DROP TABLE IF EXISTS `cms_job`;
CREATE TABLE `cms_job` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '职位名称',
  `work_place` varchar(20) DEFAULT NULL COMMENT '工作地点',
  `content_salary` varchar(20) DEFAULT NULL COMMENT '薪资待遇',
  `content_num` varchar(20) DEFAULT NULL COMMENT '招聘人数',
  `content_duty` varchar(250) DEFAULT NULL COMMENT '岗位职责',
  `content_requirement` varchar(250) DEFAULT NULL COMMENT '任职要求',
  `content_tel` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `content_email` varchar(50) DEFAULT NULL COMMENT '联系邮箱',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT NULL COMMENT '是否发布',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='招聘职位';

-- ----------------------------
-- Records of cms_job
-- ----------------------------
INSERT INTO `cms_job` VALUES ('1', '100', 'VS.Net软件开发工程师    ', '北京', '2500--8000', '3', '软件研发\r\n软件设计\r\n数据库设计', '素质要求：	\r\n		1.责任心强，工作稳定性好。\r\n                2.工作认真、有耐心、踏实肯干。\r\n		3.能够接受出差和工作紧急时加班。	\r\n技术要求：	\r\n		1.熟悉Oracle,SQLServer数据库操作及SQL语句编写。\r\n                2.会使用.NET开发工具，有.NET开发经验的优先。\r\n', '13301268820', 'hr@vacox.cn', '999', '1', '2014-09-09 01:39:30', '1');
INSERT INTO `cms_job` VALUES ('2', '100', '软件系统实施  工程师', '北京', '2500--6000', '2', '数据准备\r\n软件培训\r\n本地化修改\r\n系统上线\r\n后期维护', '熟悉数据库及软件系统', '13301268820', 'hr@vacox.cn', '999', '0', '2014-09-09 01:43:39', '1');
INSERT INTO `cms_job` VALUES ('3', '100', '技术支持', '北京', '3000+', '22', '开发', '本科 ', '010-67867545', 'xsdfdsg@163.com', '999', '1', '2015-04-18 10:01:13', '1');
INSERT INTO `cms_job` VALUES ('4', '216', '移动产品经理', '北京', '1万/月', '10人', '1、熟悉手机互联网，3年以上APP产品策划经验，有移动产品工作任职经历(社交APP、O2O、支付APP等经验)者优先考虑。\r\n2、优秀的交互设计能力，能够熟练使用Axure,PhotoShop等专业工具进行原型制作 \r\n3、优秀的文档能力，熟练使用office,visio,project等工具，擅长PPT者优先 \r\n4、优秀的沟通与协调能力，有和UI、开发、测试、市场、运营等跨功能团队协作的经验\r\n5、具有移动端产品的成功经历优先考虑 6、了解手机开发技术、无线技术、移动平台接入技术者优先', '1、熟悉手机互联网，3年以上APP产品策划经验，有移动产品工作任职经历(社交APP、O2O、支付APP等经验)者优先考虑。\r\n2、优秀的交互设计能力，能够熟练使用Axure,PhotoShop等专业工具进行原型制作 \r\n3、优秀的文档能力，熟练使用office,visio,project等工具，擅长PPT者优先 \r\n4、优秀的沟通与协调能力，有和UI、开发、测试、市场、运营等跨功能团队协作的经验\r\n5、具有移动端产品的成功经历优先考虑 6、了解手机开发技术、无线技术、移动平台接入技术者优先', '', '', '999', '1', '2015-11-15 19:09:10', '1');
INSERT INTO `cms_job` VALUES ('5', '216', 'java开发经理', '上海', '20000', '5', '1、熟悉手机互联网，3年以上APP产品策划经验，有移动产品工作任职经历(社交APP、O2O、支付APP等经验)者优先考虑。\r\n2、优秀的交互设计能力，能够熟练使用Axure,PhotoShop等专业工具进行原型制作 \r\n3、优秀的文档能力，熟练使用office,visio,project等工具，擅长PPT者优先 \r\n4、优秀的沟通与协调能力，有和UI、开发、测试、市场、运营等跨功能团队协作的经验\r\n5、具有移动端产品的成功经历优先考虑 6、了解手机开发技术、无线技术、移动平台接入技术者优先', '1、熟悉手机互联网，3年以上APP产品策划经验，有移动产品工作任职经历(社交APP、O2O、支付APP等经验)者优先考虑。\r\n2、优秀的交互设计能力，能够熟练使用Axure,PhotoShop等专业工具进行原型制作 \r\n3、优秀的文档能力，熟练使用office,visio,project等工具，擅长PPT者优先 \r\n4、优秀的沟通与协调能力，有和UI、开发、测试、市场、运营等跨功能团队协作的经验\r\n5、具有移动端产品的成功经历优先考虑 6、了解手机开发技术、无线技术、移动平台接入技术者优先', '', '', '999', '1', '2015-11-15 19:10:30', '1');
INSERT INTO `cms_job` VALUES ('6', '226', '测试职位', '', '', '', '', '', '', '', '999', '0', '2017-04-22 18:20:52', '1');

-- ----------------------------
-- Table structure for `cms_job_apply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_job_apply`;
CREATE TABLE `cms_job_apply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `job_id` int(11) DEFAULT NULL COMMENT '职位ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `content_sex` tinyint(4) DEFAULT '0' COMMENT '性别:1男2女',
  `content_birthday` varchar(20) DEFAULT NULL COMMENT '出生日期',
  `content_marriage` varchar(20) DEFAULT NULL COMMENT '婚姻状况',
  `content_university` varchar(30) DEFAULT NULL COMMENT '毕业院校',
  `content_education` varchar(20) DEFAULT NULL COMMENT '学历',
  `content_major` varchar(20) DEFAULT NULL COMMENT '专业',
  `graduate_date` varchar(20) DEFAULT NULL COMMENT '毕业日期',
  `content_hometown` varchar(20) DEFAULT NULL COMMENT '户籍地',
  `education_desc` varchar(250) DEFAULT NULL COMMENT '教育经历',
  `work_desc` varchar(250) DEFAULT NULL COMMENT '工作经历',
  `content_tel` varchar(30) DEFAULT NULL COMMENT '联系电话',
  `content_mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `content_email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `content_address` varchar(50) DEFAULT NULL COMMENT '联系地址',
  `post_code` varchar(10) DEFAULT NULL COMMENT '邮编',
  `publish` tinyint(4) DEFAULT NULL COMMENT '发布状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='应聘简历表';

-- ----------------------------
-- Records of cms_job_apply
-- ----------------------------
INSERT INTO `cms_job_apply` VALUES ('1', '1', '1112', '1', '1986-04-23', 'cxvxc', 'xcvx', 'xcvxcv', 'xcvxcv', 'xcvxcv', 'ertert', '3464', '3463', '346346', '346', '34646@163.com', 'ffffffffff', '100025', '1', '2014-09-09 01:40:54', '1');
INSERT INTO `cms_job_apply` VALUES ('2', '2', '测试444', '1', '', '', '', '', '', '', '4444', '', '', '', '13345677654', 'ewfrwe11@163.com', '', '', '0', '2014-09-15 23:48:44', null);
INSERT INTO `cms_job_apply` VALUES ('3', '3', '测试', '1', '', '', '', '', '', '', '35325', '', '', '', '15123456789', 'sdfsdg@163.com', '', '', '0', '2014-09-15 23:52:00', null);
INSERT INTO `cms_job_apply` VALUES ('4', '1', '003', '1', 'qwr', 'wq', '1', '2', '3', '4', '3466', '345436346', '346346', '346346', '15101022452', 'xuexinfeng@126.com', 'wetwet', '100025', '0', '2015-06-08 00:17:05', null);

-- ----------------------------
-- Table structure for `cms_join_apply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_join_apply`;
CREATE TABLE `cms_join_apply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `linkman_name` varchar(50) DEFAULT NULL COMMENT '联系人',
  `content_sex` tinyint(4) DEFAULT '1' COMMENT '性别:1男,2女',
  `content_mobile` varchar(40) DEFAULT NULL COMMENT '手机号',
  `province_id` int(11) DEFAULT NULL COMMENT '省份ID',
  `city_id` int(11) DEFAULT NULL COMMENT '城市ID',
  `content_address` varchar(100) DEFAULT NULL COMMENT '联系地址',
  `content_desc` varchar(200) DEFAULT NULL COMMENT '简介',
  `content_status` tinyint(4) DEFAULT '0' COMMENT '处理状态:0未处理,1已处理',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='加盟申请';

-- ----------------------------
-- Records of cms_join_apply
-- ----------------------------
INSERT INTO `cms_join_apply` VALUES ('1', 'b', null, 'c', '5', '12', null, 'dsfsdgsh', '1', '2015-07-18 18:20:41');
INSERT INTO `cms_join_apply` VALUES ('2', 'cc', null, '15101022452', '5', '14', null, null, '0', '2015-07-18 20:14:21');
INSERT INTO `cms_join_apply` VALUES ('3', '分身', null, '12345678914', '1', '1', null, null, '0', '2015-07-23 21:29:10');
INSERT INTO `cms_join_apply` VALUES ('4', '刘洋', '2', '13269826992', '9', '64', null, 'ccc', '0', '2015-07-24 14:00:35');
INSERT INTO `cms_join_apply` VALUES ('5', 'ccc', '2', '46346347', '5', '8', null, '', '0', '2015-07-25 21:44:59');
INSERT INTO `cms_join_apply` VALUES ('6', '34', '1', '45646346', '4', '4', null, 'ttt', '1', '2015-07-25 21:45:41');

-- ----------------------------
-- Table structure for `cms_links`
-- ----------------------------
DROP TABLE IF EXISTS `cms_links`;
CREATE TABLE `cms_links` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `content_name` varchar(60) DEFAULT NULL COMMENT '标题',
  `content_link` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=319 DEFAULT CHARSET=utf8 COMMENT='友情链接';

-- ----------------------------
-- Records of cms_links
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_magazine`
-- ----------------------------
DROP TABLE IF EXISTS `cms_magazine`;
CREATE TABLE `cms_magazine` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '杂志名称',
  `content_link` varchar(100) DEFAULT NULL COMMENT '外链地址（可选）',
  `content_author` varchar(30) DEFAULT NULL COMMENT '作者',
  `content_img` varchar(40) DEFAULT NULL COMMENT '封面图片',
  `content_desc` varchar(500) DEFAULT NULL COMMENT '摘要',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COMMENT='杂志表';

-- ----------------------------
-- Records of cms_magazine
-- ----------------------------
INSERT INTO `cms_magazine` VALUES ('1', '13', '青年文摘', '', '人民日报出版社', '2014/05/25/1401067142.jpg', '文艺出版社文艺出版社文艺出版社文艺出版社文艺出版社文艺出版社', '1', '999', '1', '2014-05-25 14:00:24');
INSERT INTO `cms_magazine` VALUES ('3', '13', '读者', '', '', '', '', '1', '999', '1', '2014-05-25 14:40:23');
INSERT INTO `cms_magazine` VALUES ('4', '56', '协会期刊01', '', '测试出版社', 'nophoto.jpg', '协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介,协会期刊01简介', '1', '999', '1', '2014-06-02 21:33:10');
INSERT INTO `cms_magazine` VALUES ('5', '56', '协会期刊02', '', '测试出版社', 'nophoto.jpg', '协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介,协会期刊02简介', '1', '999', '1', '2014-06-02 21:33:30');
INSERT INTO `cms_magazine` VALUES ('6', '57', '推荐期刊01', '', '', 'nophoto.jpg', '简介', '1', '999', '1', '2014-06-02 21:33:41');
INSERT INTO `cms_magazine` VALUES ('7', '57', '推荐期刊02', '', '', 'nophoto.jpg', '简介', '1', '999', '1', '2014-06-02 21:33:50');
INSERT INTO `cms_magazine` VALUES ('8', '57', '推荐期刊03', '', '', 'nophoto.jpg', '简介', '1', '999', '1', '2014-06-02 21:33:58');
INSERT INTO `cms_magazine` VALUES ('9', '57', '推荐期刊04', 'http://www.baidu.com', '', 'nophoto.jpg', '简介', '1', '999', '1', '2014-06-02 21:34:06');

-- ----------------------------
-- Table structure for `cms_magazine_item`
-- ----------------------------
DROP TABLE IF EXISTS `cms_magazine_item`;
CREATE TABLE `cms_magazine_item` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `magazine_id` int(11) DEFAULT NULL COMMENT '杂志ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '刊号名称',
  `content_desc` varchar(500) DEFAULT NULL COMMENT '摘要',
  `content_body` text COMMENT '目录说明',
  `content_file` varchar(40) DEFAULT NULL COMMENT '附件地址',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `content_hit` int(11) DEFAULT '0' COMMENT '阅读量',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COMMENT='杂志期数列表（期刊）';

-- ----------------------------
-- Records of cms_magazine_item
-- ----------------------------
INSERT INTO `cms_magazine_item` VALUES ('1', '1', '2014年第三期', '简介测试', '<p>为二位二位</p>\r\n', '2014/05/25/1401396997.docx', '1', '999', '12', '1', '2014-05-25 14:34:11');
INSERT INTO `cms_magazine_item` VALUES ('3', '3', '中国妇幼卫生杂志 2013年第八期', '2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期', '', '2014/06/08/1402458285.docx', '1', '999', '0', '1', '2014-05-25 14:40:36');
INSERT INTO `cms_magazine_item` VALUES ('4', '6', '中国妇幼卫生杂志 2013年第八期', '2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期', '<ul>\r\n	<li>2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期</li>\r\n	<li>2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期</li>\r\n	<li>2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期</li>\r\n	<li>2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期</li>\r\n	<li>2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期2014年第4期</li>\r\n</ul>\r\n', '2014/06/08/1402458285.docx', '1', '999', '2', '1', '2014-06-08 15:49:11');
INSERT INTO `cms_magazine_item` VALUES ('5', '4', '2014第一期测试期刊', '2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊', '<p>2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊</p>\r\n\r\n<p>2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊</p>\r\n\r\n<p>2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊</p>\r\n', '2014/06/08/1402458285.docx', '1', '999', '105', '1', '2014-06-29 16:52:35');
INSERT INTO `cms_magazine_item` VALUES ('6', '7', '2014推荐期刊第二期02', '2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02', '<p>2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02</p>\r\n\r\n<p>2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02</p>\r\n\r\n<p>2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02,2014推荐期刊第二期02</p>\r\n', '2014/05/25/1401396997.docx', '1', '999', '23', '1', '2014-06-29 16:58:20');
INSERT INTO `cms_magazine_item` VALUES ('7', '6', '中国妇幼卫生杂志 2013年第9期', '中国妇幼卫生杂志 2013年第9期,中国妇幼卫生杂志中国妇幼卫生杂志 2013年第9期,中国妇幼卫生杂志 2013年第9期 2013年第9期,', '<p>中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期</p>\r\n\r\n<p>中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期中国妇幼卫生杂志 2013年第9期</p>\r\n', '2014/05/25/1401396997.docx', '1', '999', '0', '1', '2014-06-29 16:59:05');
INSERT INTO `cms_magazine_item` VALUES ('8', '4', '2014第二期测试期刊', '2014第一期测试期刊,2014第一期测试期刊\r\n2014第一期测试期刊,2014第一期测试期刊\r\n2014第一期测试期刊,2014第一期测试期刊', '<p>2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊</p>\r\n\r\n<p>2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊2014第一期测试期刊,2014第一期测试期刊</p>\r\n', '2014/05/25/1401396997.docx', '1', '999', '46', '1', '2014-06-29 17:00:27');

-- ----------------------------
-- Table structure for `cms_magazine_item_news`
-- ----------------------------
DROP TABLE IF EXISTS `cms_magazine_item_news`;
CREATE TABLE `cms_magazine_item_news` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `magazine_item_id` int(11) DEFAULT NULL COMMENT '期刊ID',
  `content_name` varchar(60) DEFAULT NULL COMMENT '文章标题',
  `content_img` varchar(60) DEFAULT NULL COMMENT '标题图片',
  `content_file` varchar(60) DEFAULT NULL COMMENT '文章附件',
  `content_link` varchar(100) DEFAULT NULL COMMENT '外链地址（可选）',
  `content_desc` varchar(200) DEFAULT NULL COMMENT '文章摘要',
  `content_body` text COMMENT '文章正文',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `content_hit` int(11) DEFAULT '0' COMMENT '点击量',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='杂志文章表';

-- ----------------------------
-- Records of cms_magazine_item_news
-- ----------------------------
INSERT INTO `cms_magazine_item_news` VALUES ('2', '5', '测试文章', '', '2014/07/27/1406961893.docx', '', 'sdgdsg', '<p>sdgsdgdsg</p>\r\n', '0', '999', '106', '1', '2014-07-27 15:53:08', '1');
INSERT INTO `cms_magazine_item_news` VALUES ('3', '5', '测试文章02', '', '', '', 'wrwfsedf', '', '0', '888', '0', '1', '2014-07-27 15:53:58', '1');

-- ----------------------------
-- Table structure for `cms_member`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member`;
CREATE TABLE `cms_member` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_type` tinyint(4) DEFAULT '1' COMMENT '会员类型:1个人会员,2企业会员',
  `group_id` int(11) DEFAULT '1',
  `content_level` tinyint(4) DEFAULT '1' COMMENT '会员等级',
  `content_user` varchar(30) DEFAULT NULL COMMENT '用户名',
  `content_pass` varchar(40) DEFAULT NULL COMMENT '密码',
  `pass_randstr` varchar(20) DEFAULT NULL COMMENT '秘钥',
  `token` varchar(10) DEFAULT '' COMMENT '加密密钥，app接口使用',
  `content_email` varchar(60) DEFAULT NULL COMMENT '邮箱',
  `content_mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `content_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `content_sex` tinyint(4) DEFAULT '0' COMMENT '性别',
  `province_id` int(11) DEFAULT '0' COMMENT '省份ID',
  `city_id` int(11) DEFAULT '0' COMMENT '城市ID',
  `lat` double(9,6) DEFAULT NULL COMMENT 'GPS经度',
  `lng` double(9,6) DEFAULT NULL COMMENT 'GPS纬度',
  `content_address` varchar(50) DEFAULT NULL,
  `content_desc` varchar(120) DEFAULT NULL COMMENT '备注',
  `content_head` varchar(200) DEFAULT NULL COMMENT '头像',
  `linkman_name` varchar(30) DEFAULT NULL COMMENT '联系人姓名，用于企业会员',
  `content_tel` varchar(40) DEFAULT NULL COMMENT '企业联系电话',
  `account_balance` double(10,2) DEFAULT '0.00' COMMENT '会员账户余额',
  `content_credits` int(11) DEFAULT '0',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否发布',
  `is_agree` tinyint(4) DEFAULT '0' COMMENT '审核状态',
  `is_synbbs` tinyint(4) DEFAULT '0' COMMENT '是否同步到论坛',
  `uc_id` int(11) DEFAULT '0' COMMENT 'ucenter_id',
  `weixin_appid` varchar(50) DEFAULT NULL COMMENT '微信appID',
  `weixin_openid` varchar(50) DEFAULT NULL COMMENT '微信openid',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `first_letter` varchar(5) DEFAULT NULL COMMENT '名称首字母',
  `login_fail_times` int(11) DEFAULT '0',
  `last_login_fail_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8 COMMENT='会员表';

-- ----------------------------
-- Records of cms_member
-- ----------------------------
INSERT INTO `cms_member` VALUES ('29', '1', '1', '1', null, '068f2d5e9457bf6077fbac76144b2a82', '2105773', '', 'xuexinfeng@126.com', '15101022452', '开心兔', '1', '0', '0', null, null, '测试地址', '备注', '2016/11/13/1479980722_s.jpg', null, null, '30.06', '0', '1', '0', '0', '0', null, null, null, '2016-11-05 11:35:22', null, '0', null);
INSERT INTO `cms_member` VALUES ('30', '2', '4', '1', null, '5d93a2ff91835f891e72f04f21f5820d', '1500427', '', 'test123@163.com', '18033660486', '北京矩阵CMS科技', '1', '1', '1', '39.911899', '116.611325', '测试地址', '测试', '2016/11/07/1479300812.jpg', '匿名', '4000000000', '0.00', '0', '1', '1', '0', '0', null, null, '1', '2016-11-07 15:45:53', null, '0', null);

-- ----------------------------
-- Table structure for `cms_member_account`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_account`;
CREATE TABLE `cms_member_account` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_id` int(11) DEFAULT NULL,
  `content_type` tinyint(4) DEFAULT '1' COMMENT '1获取2消费',
  `content_event` varchar(20) DEFAULT NULL COMMENT '事件标识',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '说明',
  `content_money` double(10,2) DEFAULT NULL COMMENT '金额',
  `balance_monay` double(10,2) DEFAULT NULL COMMENT '账户余额',
  `order_id` int(11) DEFAULT NULL,
  `order_sn` varchar(20) DEFAULT NULL,
  `cash_apply_id` int(11) DEFAULT '0' COMMENT '关联的提现申请记录id',
  `create_user` int(11) DEFAULT NULL,
  `create_time` datetime DEFAULT NULL,
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='会员账户记录';

-- ----------------------------
-- Records of cms_member_account
-- ----------------------------
INSERT INTO `cms_member_account` VALUES ('23', '29', '1', null, '奖励', '100.00', '100.00', '0', '', '0', '1', '2016-11-10 18:21:50');
INSERT INTO `cms_member_account` VALUES ('24', '29', '2', 'cashApply', '申请提现', '-50.00', '50.00', null, null, '0', null, '2016-11-10 18:26:53');
INSERT INTO `cms_member_account` VALUES ('25', '29', '1', 'fill_account', '账户充值', '0.04', '50.04', '7', '1611131631388165', '0', null, '2016-11-13 16:32:08');
INSERT INTO `cms_member_account` VALUES ('26', '29', '1', 'fill_account', '账户充值', '0.02', '50.06', '8', '1611131633552228', '0', null, '2016-11-13 16:34:20');
INSERT INTO `cms_member_account` VALUES ('27', '29', '2', 'cashApply', '申请提现', '-20.00', '30.06', null, null, '0', null, '2016-11-13 18:00:47');

-- ----------------------------
-- Table structure for `cms_member_address`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_address`;
CREATE TABLE `cms_member_address` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT '0' COMMENT '会员ID',
  `device_id` varchar(60) DEFAULT NULL COMMENT '设备ID',
  `is_default` tinyint(4) DEFAULT '0' COMMENT '是否是默认地址',
  `content_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `content_mobile` varchar(20) DEFAULT NULL COMMENT '手机号',
  `province_id` int(11) NOT NULL COMMENT '省份ID',
  `city_id` int(11) DEFAULT NULL COMMENT '城市ID',
  `street_name` varchar(40) DEFAULT NULL COMMENT '街道名称',
  `content_address` varchar(60) DEFAULT NULL COMMENT '详细地址',
  `lat` double(9,6) DEFAULT NULL COMMENT 'GPS经度',
  `lng` double(9,6) DEFAULT NULL COMMENT 'GPS纬度',
  `last_use_time` datetime DEFAULT NULL COMMENT '最后使用时间',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='收货地址表';

-- ----------------------------
-- Records of cms_member_address
-- ----------------------------
INSERT INTO `cms_member_address` VALUES ('2', '8', null, '0', '薛新峰', '15101022452', '5', '14', null, '燕郊星河皓月502室', null, null, '2015-03-31 00:01:28', '2014-11-15 16:23:52');
INSERT INTO `cms_member_address` VALUES ('4', '0', null, '1', '刘桂贤', '15910381023', '5', '14', null, '燕顺路星河皓月', null, null, '2014-11-15 20:07:27', '2014-11-15 20:07:27');
INSERT INTO `cms_member_address` VALUES ('5', '8', null, '0', '薛新峰', '15101022452', '1', '1', null, '朝阳区慈云寺住邦', null, null, '2014-12-29 00:32:35', '2014-11-16 10:33:31');
INSERT INTO `cms_member_address` VALUES ('7', '8', null, '0', '薛新峰', '15101022452', '9', '71', null, '白头山大城镇陈家村12号', null, null, '2015-01-02 22:38:22', '2015-01-02 22:38:12');
INSERT INTO `cms_member_address` VALUES ('8', '8', null, '1', '薛新峰', '15101022452', '16', '155', null, '肥城矿务局234', null, null, '2015-03-31 00:45:15', '2015-03-17 23:54:40');
INSERT INTO `cms_member_address` VALUES ('10', '35', null, '0', 'xuexinfeng', '15101022452', '1', '1', null, '123456', null, null, '2015-05-16 22:25:33', '2015-05-16 22:25:33');
INSERT INTO `cms_member_address` VALUES ('11', '35', null, '0', 'Dfgghjjj03', '15101022452', '1', '1', null, '1234567', null, null, '2015-05-16 22:40:15', '2015-05-16 22:30:35');
INSERT INTO `cms_member_address` VALUES ('12', '35', null, '1', 'Fgggtfghhhh1', '15101022452', '1', '1', null, '3456778', null, null, '2015-08-06 00:12:42', '2015-05-16 22:34:41');
INSERT INTO `cms_member_address` VALUES ('13', '21', null, '1', '薛新峰', '15101022452', '1', '1', '国贸', '华贸写字楼', '39.914112', '116.487719', null, '2015-09-04 18:04:50');
INSERT INTO `cms_member_address` VALUES ('16', '21', '2ACD10F8-1AF2-49FF-A953-8EDEA9E75779', '0', '薛新峰', '15101022452', '5', '14', '星河皓月-北门', '星河皓月Q1栋', '39.989312', '116.781594', null, '2015-09-05 08:54:45');
INSERT INTO `cms_member_address` VALUES ('17', '23', '2ACD10F8-1AF2-49FF-A953-8EDEA9E75779', '0', '薛新峰', '15101022452', '5', '14', '星河皓月-北门', '星河皓月Q1栋', '39.989312', '116.781594', null, '2015-09-05 08:56:27');
INSERT INTO `cms_member_address` VALUES ('18', '21', '2ACD10F8-1AF2-49FF-A953-8EDEA9E75779', '0', '薛新峰', '15101022452', '5', '14', '星河皓月-北门', '星河皓月Q3栋', '39.989312', '116.781594', null, '2015-09-05 09:08:08');

-- ----------------------------
-- Table structure for `cms_member_collect`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_collect`;
CREATE TABLE `cms_member_collect` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_type` tinyint(4) DEFAULT '0' COMMENT '收藏类型:1新闻2产品',
  `object_id` int(11) DEFAULT NULL COMMENT '收藏对象ID',
  `object_name` varchar(50) DEFAULT NULL COMMENT '收藏对象名称',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员收藏夹';

-- ----------------------------
-- Records of cms_member_collect
-- ----------------------------
INSERT INTO `cms_member_collect` VALUES ('2', '13', '2', '15', '心喜系列2015年第11期人民币信托债券非保本理财产品', '2015-05-02 17:29:54');
INSERT INTO `cms_member_collect` VALUES ('3', '8', '2', '13', '保本型个人人民币理财产品(BBD15042)(仅深圳)', '2015-05-02 22:39:46');
INSERT INTO `cms_member_collect` VALUES ('4', '7', '3', '1', '测试003', '2015-05-03 20:53:24');

-- ----------------------------
-- Table structure for `cms_member_credits`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_credits`;
CREATE TABLE `cms_member_credits` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_type` tinyint(4) DEFAULT '1' COMMENT '类型:1获取2消费',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `order_sn` varchar(20) DEFAULT NULL COMMENT '订单号',
  `content_credits` int(11) DEFAULT '0' COMMENT '积分数量',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '说明',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=54 DEFAULT CHARSET=utf8 COMMENT='会员积分记录';

-- ----------------------------
-- Records of cms_member_credits
-- ----------------------------
INSERT INTO `cms_member_credits` VALUES ('53', '23', '1', '1', '345435', '100', '购物积分', '2015-10-08 11:03:33', null);

-- ----------------------------
-- Table structure for `cms_member_group`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_group`;
CREATE TABLE `cms_member_group` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '分组名称',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '简介',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `cent_limit` int(11) DEFAULT '0' COMMENT '自动晋级的积分标准',
  `reward_percent` double(5,2) DEFAULT '0.00' COMMENT '返佣比例，将会按照返佣比例给推荐人返佣金',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='会员分组表';

-- ----------------------------
-- Records of cms_member_group
-- ----------------------------
INSERT INTO `cms_member_group` VALUES ('1', '普通会员', '会员注册后的默认组', '0', '0', null, '2015-09-13 12:23:09', '1');
INSERT INTO `cms_member_group` VALUES ('4', 'VIP会员', '', '0', '0', '0.10', '2016-03-26 22:45:12', '1');

-- ----------------------------
-- Table structure for `cms_member_photos`
-- ----------------------------
DROP TABLE IF EXISTS `cms_member_photos`;
CREATE TABLE `cms_member_photos` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_name` varchar(40) DEFAULT NULL COMMENT '照片标题',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '1' COMMENT '是否公开',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='会员相册表';

-- ----------------------------
-- Records of cms_member_photos
-- ----------------------------
INSERT INTO `cms_member_photos` VALUES ('1', '28', null, '2015/09/05/1442172422.jpg', '999', '1', '2015-09-04 18:14:00');
INSERT INTO `cms_member_photos` VALUES ('2', '28', null, '2015/09/05/1442172422.jpg', '999', '1', '2015-09-05 18:14:24');
INSERT INTO `cms_member_photos` VALUES ('4', '21', null, '2015/09/05/1442172422.jpg', '999', '1', '2015-09-05 18:14:43');
INSERT INTO `cms_member_photos` VALUES ('5', '21', null, '2015/10/28/1446096421_s.jpg', '999', '1', '2015-10-28 22:33:23');
INSERT INTO `cms_member_photos` VALUES ('6', '21', null, '2015/10/28/1446756477_s.jpg', '999', '1', '2015-10-28 22:37:15');

-- ----------------------------
-- Table structure for `cms_menu`
-- ----------------------------
DROP TABLE IF EXISTS `cms_menu`;
CREATE TABLE `cms_menu` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT '0' COMMENT '父级ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '栏目名称',
  `content_link` varchar(150) DEFAULT NULL COMMENT '外链地址',
  `link_target` varchar(20) DEFAULT NULL COMMENT '打开方式,默认:当前窗口打开,新窗口:_blank',
  `url_path` varchar(50) DEFAULT '' COMMENT '栏目目录名称，用于静态化',
  `action_method` varchar(30) DEFAULT NULL COMMENT '控制器方法名或模板名称',
  `detail_method` varchar(30) DEFAULT NULL,
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `content_desc` varchar(255) DEFAULT NULL COMMENT '频道简介',
  `auto_position` int(11) DEFAULT NULL COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `show_submenu` tinyint(4) DEFAULT '0' COMMENT '是否显示下级菜单',
  `content_module` varchar(30) DEFAULT NULL COMMENT '关联的功能模型',
  `seo_keywords` varchar(120) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=228 DEFAULT CHARSET=utf8 COMMENT='频道栏目表';

-- ----------------------------
-- Records of cms_menu
-- ----------------------------
INSERT INTO `cms_menu` VALUES ('1', '0', '首页', 'index.php', null, '', 'index.php', null, '', '', '3', '1', '0', '', '', '', '2015-04-13 10:51:35', '1');
INSERT INTO `cms_menu` VALUES ('223', '0', '新闻', '', '', '', '', null, '', '', '1474187576', '1', '0', 'news', '', '', '2016-09-18 16:32:42', '1');
INSERT INTO `cms_menu` VALUES ('224', '0', '关于我们', '', '', '', '', '', '', '', '1492855625', '1', '0', 'article', '', '', '2017-04-22 18:06:57', '1');
INSERT INTO `cms_menu` VALUES ('225', '0', '友情链接', '', '', '', '', '', '', '', '1492855851', '1', '0', 'links', '', '', '2017-04-22 18:10:42', '1');
INSERT INTO `cms_menu` VALUES ('226', '0', '招聘功能', '', '', '', '', '', '', '', '1492855862', '1', '0', 'job', '', '', '2017-04-22 18:10:53', '1');
INSERT INTO `cms_menu` VALUES ('227', '0', '留言板', '', '', '', '', '', '', '', '1492855871', '1', '0', 'messageBoard', '', '', '2017-04-22 18:11:03', '1');

-- ----------------------------
-- Table structure for `cms_message_board`
-- ----------------------------
DROP TABLE IF EXISTS `cms_message_board`;
CREATE TABLE `cms_message_board` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '栏目ID',
  `content_title` varchar(50) DEFAULT NULL COMMENT '留言标题',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '留言内容',
  `company_name` varchar(40) DEFAULT NULL COMMENT '公司名称',
  `company_address` varchar(60) DEFAULT NULL COMMENT '公司地址',
  `post_code` varchar(10) DEFAULT NULL COMMENT '邮编',
  `content_name` varchar(30) DEFAULT NULL COMMENT '联系人姓名',
  `content_tel` varchar(30) DEFAULT NULL COMMENT '固话号码',
  `content_mobile` varchar(20) DEFAULT NULL COMMENT '手机号码',
  `content_fax` varchar(30) DEFAULT NULL COMMENT '传真',
  `content_email` varchar(50) DEFAULT NULL COMMENT '邮箱',
  `publish` tinyint(4) DEFAULT NULL COMMENT '是否发布',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='留言板';

-- ----------------------------
-- Records of cms_message_board
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_mobile_msg_record`
-- ----------------------------
DROP TABLE IF EXISTS `cms_mobile_msg_record`;
CREATE TABLE `cms_mobile_msg_record` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_type` varchar(10) DEFAULT NULL COMMENT '事件标识，用于区分短信用途',
  `content_mobile` varchar(40) DEFAULT NULL COMMENT '手机号',
  `content_text` varchar(100) DEFAULT NULL COMMENT '短信内容',
  `order_id` int(11) DEFAULT '0' COMMENT '订单ID',
  `validate_code` varchar(10) DEFAULT NULL COMMENT '验证码',
  `validate_state` tinyint(4) DEFAULT '0' COMMENT '验证码使用状态:0未使用,1已使用',
  `api_return` varchar(200) DEFAULT NULL COMMENT '服务器返回的数据',
  `content_result` varchar(100) DEFAULT NULL COMMENT '短信接口返回的结果',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='短信记录';

-- ----------------------------
-- Records of cms_mobile_msg_record
-- ----------------------------
INSERT INTO `cms_mobile_msg_record` VALUES ('17', 'reg', '15101022452', '您正在逸丝风尚进行注册操作,验证码为45562,请妥善保管并切勿转告他人', '0', '45562', '1', null, '1', '2015-08-15 19:44:55');
INSERT INTO `cms_mobile_msg_record` VALUES ('18', 'reg', '13263188186', '您正在逸丝风尚进行注册操作,验证码为78439,请妥善保管并切勿转告他人', '0', '78439', '0', null, '1', '2015-08-24 14:09:11');
INSERT INTO `cms_mobile_msg_record` VALUES ('19', 'reg', '13263188186', '您正在逸丝风尚进行注册操作,验证码为70356,请妥善保管并切勿转告他人', '0', '70356', '0', null, '1', '2015-08-24 14:09:17');
INSERT INTO `cms_mobile_msg_record` VALUES ('20', 'reg', '13263188186', '您正在逸丝风尚进行注册操作,验证码为52750,请妥善保管并切勿转告他人', '0', '52750', '1', null, '1', '2015-08-24 14:09:18');
INSERT INTO `cms_mobile_msg_record` VALUES ('21', 'reg', '18801073806', '您正在逸丝风尚进行注册操作,验证码为98044,请妥善保管并切勿转告他人', '0', '98044', '0', null, '1', '2015-08-25 10:35:35');
INSERT INTO `cms_mobile_msg_record` VALUES ('22', 'reg', '18801073806', '您正在逸丝风尚进行注册操作,验证码为82279,请妥善保管并切勿转告他人', '0', '82279', '1', null, '1', '2015-08-25 10:35:36');
INSERT INTO `cms_mobile_msg_record` VALUES ('23', 'reg', '17600854184', '您正在逸丝风尚进行注册操作,验证码为36792,请妥善保管并切勿转告他人', '0', '36792', '1', null, '1', '2015-08-25 10:41:42');
INSERT INTO `cms_mobile_msg_record` VALUES ('24', 'reg', '13717587077', '您正在逸丝风尚进行注册操作,验证码为99360,请妥善保管并切勿转告他人', '0', '99360', '1', null, '1', '2015-08-25 11:54:26');
INSERT INTO `cms_mobile_msg_record` VALUES ('25', 'reg', '18511358255', '您正在逸丝风尚进行注册操作,验证码为46411,请妥善保管并切勿转告他人', '0', '46411', '0', null, '1', '2015-08-25 12:20:45');
INSERT INTO `cms_mobile_msg_record` VALUES ('26', 'reg', '18511358255', '您正在逸丝风尚进行注册操作,验证码为96624,请妥善保管并切勿转告他人', '0', '96624', '0', null, '1', '2015-08-25 12:21:00');
INSERT INTO `cms_mobile_msg_record` VALUES ('27', 'reg', '18511358255', '您正在逸丝风尚进行注册操作,验证码为81954,请妥善保管并切勿转告他人', '0', '81954', '1', null, '1', '2015-08-25 12:21:41');
INSERT INTO `cms_mobile_msg_record` VALUES ('28', 'reg', '13488791001', '您正在逸丝风尚进行注册操作,验证码为38405,请妥善保管并切勿转告他人', '0', '38405', '1', null, '1', '2015-08-25 14:47:24');
INSERT INTO `cms_mobile_msg_record` VALUES ('29', 'forgetPwd', '15101022452', '您正在逸丝风尚进行重置面膜操作,验证码为36911,请妥善保管并切勿转告他人', '0', '36911', '1', null, '1', '2015-10-11 23:27:10');
INSERT INTO `cms_mobile_msg_record` VALUES ('30', 'forgetPwd', '15101022452', '您正在逸丝风尚进行重置密码操作,验证码为46587,请妥善保管并切勿转告他人', '0', '46587', '1', null, '1', '2015-10-11 23:33:05');
INSERT INTO `cms_mobile_msg_record` VALUES ('31', 'forgetPwd', '15101022452', '您正在逸丝风尚进行重置密码操作,验证码为25507,请妥善保管并切勿转告他人', '0', '25507', '1', null, '1', '2015-10-11 23:38:18');

-- ----------------------------
-- Table structure for `cms_mobile_msg_templet`
-- ----------------------------
DROP TABLE IF EXISTS `cms_mobile_msg_templet`;
CREATE TABLE `cms_mobile_msg_templet` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '模板名称',
  `content_text` varchar(200) DEFAULT NULL COMMENT '模板内容',
  `content_event` varchar(20) DEFAULT NULL COMMENT '事件标识',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否开启',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='短信模板';

-- ----------------------------
-- Records of cms_mobile_msg_templet
-- ----------------------------
INSERT INTO `cms_mobile_msg_templet` VALUES ('1', '下单成功提醒', '恭喜您提交订单成功，订单号为{order_sn}，请登录网站查看并及时付款。如非本人操作请及时联系客服', 'orderSuccess', '2', '0', '2014-11-23 16:09:37', '1');
INSERT INTO `cms_mobile_msg_templet` VALUES ('2', '会员注册短信验证码', '您正在进行会员注册操作,验证码为{msg_code},请妥善保管并切勿转告他人', 'memberRegCode', '1', '1', '2015-10-31 23:44:53', '1');
INSERT INTO `cms_mobile_msg_templet` VALUES ('3', '支付成功提醒', '恭喜您支付订单成功，订单号为{order_sn}，请登录网站查看。如非本人操作请及时联系平台客服', 'paySuccess', '3', '0', '2015-12-11 01:21:27', '1');
INSERT INTO `cms_mobile_msg_templet` VALUES ('4', '支付成功提醒管理员', '订单{order_sn}已支付，支付金额{money}元,请登录网站进行查看', 'adminPayNotice ', '999', '1', '2016-04-22 23:26:29', '1');
INSERT INTO `cms_mobile_msg_templet` VALUES ('5', '取货验证码', '您购买的{goods_name}已经支付成功,取货验证码为{validate_code},请妥善保管切勿随意转发', 'orderValidate', '999', '1', '2016-06-15 20:17:01', '1');
INSERT INTO `cms_mobile_msg_templet` VALUES ('6', '下单成功通知管理员', '有新的订单，订单号{order_sn}，请及时处理', 'adminOrderNotice', '999', '1', '2016-09-10 07:03:41', '1');

-- ----------------------------
-- Table structure for `cms_news`
-- ----------------------------
DROP TABLE IF EXISTS `cms_news`;
CREATE TABLE `cms_news` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '频道栏目ID',
  `content_name` varchar(100) DEFAULT NULL COMMENT '标题',
  `content_subname` varchar(60) DEFAULT NULL COMMENT '副标题',
  `content_link` varchar(100) DEFAULT NULL COMMENT '外链地址',
  `content_author` varchar(20) DEFAULT NULL COMMENT '作者',
  `content_source` varchar(20) DEFAULT NULL COMMENT '来源',
  `content_desc` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content_keywords` varchar(50) DEFAULT NULL COMMENT '关键词',
  `content_img` varchar(150) DEFAULT NULL COMMENT '标题图片',
  `content_file` varchar(60) DEFAULT NULL COMMENT '附件',
  `content_video` varchar(60) DEFAULT NULL COMMENT '视频',
  `content_body` text COMMENT '正文内容',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `content_hit` int(11) DEFAULT '0' COMMENT '点击量',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `auto_position` int(11) DEFAULT NULL COMMENT '自动生成的排序位（备用字段）',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `seo_keywords` varchar(120) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `file_name` varchar(50) DEFAULT '' COMMENT '页面文件名，用于静态化',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='新闻';

-- ----------------------------
-- Records of cms_news
-- ----------------------------
INSERT INTO `cms_news` VALUES ('1', '223', '新闻-测试资讯数据标题1', '副标题新闻-1', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.1', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文1', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('2', '223', '新闻-测试资讯数据标题2', '副标题新闻-2', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.2', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文2', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('3', '223', '新闻-测试资讯数据标题3', '副标题新闻-3', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.3', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文3', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('4', '223', '新闻-测试资讯数据标题4', '副标题新闻-4', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.4', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文4', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('5', '223', '新闻-测试资讯数据标题5', '副标题新闻-5', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.5', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文5', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('6', '223', '新闻-测试资讯数据标题6', '副标题新闻-6', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.6', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文6', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('7', '223', '新闻-测试资讯数据标题7', '副标题新闻-7', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.7', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文7', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('8', '223', '新闻-测试资讯数据标题8', '副标题新闻-8', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.8', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文8', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('9', '223', '新闻-测试资讯数据标题9', '副标题新闻-9', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.9', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文9', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('10', '223', '新闻-测试资讯数据标题10', '副标题新闻-10', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.10', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文10', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('11', '223', '新闻-测试资讯数据标题11', '副标题新闻-11', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.11', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文11', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('12', '223', '新闻-测试资讯数据标题12', '副标题新闻-12', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.12', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文12', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('13', '223', '新闻-测试资讯数据标题13', '副标题新闻-13', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.13', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文13', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('14', '223', '新闻-测试资讯数据标题14', '副标题新闻-14', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.14', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文14', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('15', '223', '新闻-测试资讯数据标题15', '副标题新闻-15', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.15', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文15', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('16', '223', '新闻-测试资讯数据标题16', '副标题新闻-16', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.16', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文16', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('17', '223', '新闻-测试资讯数据标题17', '副标题新闻-17', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.17', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文17', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('18', '223', '新闻-测试资讯数据标题18', '副标题新闻-18', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.18', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文18', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('19', '223', '新闻-测试资讯数据标题19', '副标题新闻-19', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.19', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文19', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');
INSERT INTO `cms_news` VALUES ('20', '223', '新闻-测试资讯数据标题20', '副标题新闻-20', null, '匿名作者', '互联网虚构', '新闻-测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介,测试资讯数据简介.20', null, 'nophoto.jpg', null, null, '新闻-测试资讯数据正文20', '0', '99', '999', '999', '1', null, null, '', '2017-05-03 16:59:09', '1');

-- ----------------------------
-- Table structure for `cms_onlinepay_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_onlinepay_log`;
CREATE TABLE `cms_onlinepay_log` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pay_sn` varchar(20) DEFAULT NULL COMMENT '支付订单号，一般直接采用订单号',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `order_sn` varchar(20) DEFAULT NULL COMMENT '订单号',
  `api_order_sn` varchar(40) DEFAULT '' COMMENT '支付接口订单号',
  `onlinepay_type` varchar(20) DEFAULT NULL COMMENT '支付方式类型',
  `content_status` tinyint(4) DEFAULT '0' COMMENT '支付状态',
  `content_money` double(12,2) DEFAULT '0.00' COMMENT '支付金额',
  `account_money` double(12,2) DEFAULT '0.00' COMMENT '账户余额支付金额',
  `receive_account` varchar(40) DEFAULT NULL COMMENT '收款账号,备用字段',
  `success_url` varchar(150) DEFAULT NULL COMMENT '支付成功跳转地址',
  `fail_url` varchar(150) DEFAULT NULL COMMENT '支付失败跳转地址',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='在线支付日志';

-- ----------------------------
-- Records of cms_onlinepay_log
-- ----------------------------
INSERT INTO `cms_onlinepay_log` VALUES ('10', '1604082055346941', '101', '1604082055346941', '', '微信支付', '0', '0.02', null, '', null, null, null, '2016-04-08 22:22:02');
INSERT INTO `cms_onlinepay_log` VALUES ('11', '1604082234210458', '102', '1604082234210458', '', '微信支付', '0', '0.03', null, '', null, null, null, '2016-04-08 22:34:24');
INSERT INTO `cms_onlinepay_log` VALUES ('12', '1604091704161141', '103', '1604091704161141', '', '微信支付', '0', '46.01', null, '', null, null, null, '2016-04-09 17:04:33');
INSERT INTO `cms_onlinepay_log` VALUES ('13', '1604181150288903', '105', '1604181150288903', '', '微信支付', '0', '45.01', null, '', null, null, null, '2016-04-18 11:50:51');
INSERT INTO `cms_onlinepay_log` VALUES ('14', '1604181158036138', '106', '1604181158036138', '', '微信支付', '0', '36.01', null, '', null, null, null, '2016-04-18 11:58:26');
INSERT INTO `cms_onlinepay_log` VALUES ('15', '1604181158503641', '107', '1604181158503641', '', '微信支付', '0', '36.01', null, '', null, null, null, '2016-04-18 12:00:06');
INSERT INTO `cms_onlinepay_log` VALUES ('16', '1604222346286114', '111', '1604222346286114', '', '微信支付', '0', '0.03', null, '', null, null, null, '2016-04-22 23:46:32');
INSERT INTO `cms_onlinepay_log` VALUES ('17', '1604230004516710', '112', '1604230004516710', '', '微信支付', '0', '0.03', null, '', null, null, null, '2016-04-23 00:04:54');
INSERT INTO `cms_onlinepay_log` VALUES ('18', '1605171147292401', '123', '1605171147292401', '', '微信支付', '0', '108.01', null, '', null, null, null, '2016-05-17 11:47:49');
INSERT INTO `cms_onlinepay_log` VALUES ('19', '1606141011407147', '124', '1606141011407147', '', 'alipay_pc', '0', '5.01', null, null, 'http://127.0.0.1/b2c/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', 'http://127.0.0.1/b2c/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', null, '2016-06-14 10:11:45');
INSERT INTO `cms_onlinepay_log` VALUES ('20', '1606141011407147', '124', '1606141011407147', '', 'weixin_qrcode', '0', '5.01', null, null, 'http://127.0.0.1/b2c/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', 'http://127.0.0.1/b2c/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', null, '2016-06-14 10:21:23');
INSERT INTO `cms_onlinepay_log` VALUES ('21', '1606141011407147', '124', '1606141011407147', '', 'alipay_wap', '0', '5.01', null, null, 'http://127.0.0.1/b2c/mobile/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', 'http://127.0.0.1/b2c/mobile/index.php?acl=member&method=orderInfo&order_sn=1606141011407147', null, '2016-06-14 10:48:19');
INSERT INTO `cms_onlinepay_log` VALUES ('22', '1611131758180674', '9', '1611131758180674', '', 'alipay_pc', '0', '0.02', '0.00', null, 'http://localhost/juzhencms1.6/index.php?acl=member&method=account', 'http://localhost/juzhencms1.6/index.php?acl=member&method=account', null, '2016-11-13 17:58:19');

-- ----------------------------
-- Table structure for `cms_order`
-- ----------------------------
DROP TABLE IF EXISTS `cms_order`;
CREATE TABLE `cms_order` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `order_sn` varchar(30) DEFAULT NULL COMMENT '订单编号',
  `name` varchar(30) DEFAULT NULL COMMENT '订单名称',
  `type` tinyint(4) DEFAULT '0' COMMENT '类型',
  `data_id` int(11) DEFAULT '0' COMMENT '对应的相应数据表记录的ID',
  `data_body` text,
  `member_id` int(11) DEFAULT NULL,
  `pay_money` double(10,2) DEFAULT NULL,
  `pay_type` tinyint(4) DEFAULT '1' COMMENT '1在线支付，2线下付款',
  `pay_status` tinyint(4) DEFAULT '0' COMMENT '支付状态',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='订单表';

-- ----------------------------
-- Records of cms_order
-- ----------------------------
INSERT INTO `cms_order` VALUES ('1', '1611121812352453', '账户充值', '4', '0', null, '29', '0.02', '1', '0', '2016-11-12 18:12:35');
INSERT INTO `cms_order` VALUES ('2', '1611121826488726', '账户充值', '4', '0', null, '29', '0.02', '1', '0', '2016-11-12 18:26:48');
INSERT INTO `cms_order` VALUES ('3', '1611131554574195', '账户充值', '4', '0', null, '29', '10.00', '1', '0', '2016-11-13 15:54:57');
INSERT INTO `cms_order` VALUES ('4', '1611131558056447', '账户充值', '4', '0', null, '29', '0.02', '1', '0', '2016-11-13 15:58:05');
INSERT INTO `cms_order` VALUES ('5', '1611131600462853', '账户充值', '4', '0', null, '29', '0.02', '1', '1', '2016-11-13 16:00:46');
INSERT INTO `cms_order` VALUES ('6', '1611131628076603', '账户充值', '4', '0', null, '29', '0.03', '1', '1', '2016-11-13 16:28:07');
INSERT INTO `cms_order` VALUES ('7', '1611131631388165', '账户充值', '4', '0', null, '29', '0.04', '1', '1', '2016-11-13 16:31:38');
INSERT INTO `cms_order` VALUES ('8', '1611131633552228', '账户充值', '4', '0', null, '29', '0.02', '1', '1', '2016-11-13 16:33:55');
INSERT INTO `cms_order` VALUES ('9', '1611131758180674', '账户充值', '4', '0', null, '29', '0.02', '1', '0', '2016-11-13 17:58:18');
INSERT INTO `cms_order` VALUES ('10', '1611221537083042', '账户充值', '4', '0', null, '29', '0.20', '1', '0', '2016-11-22 15:37:08');

-- ----------------------------
-- Table structure for `cms_order_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_order_log`;
CREATE TABLE `cms_order_log` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `order_id` int(11) DEFAULT NULL COMMENT '订单ID',
  `order_sn` varchar(20) DEFAULT NULL COMMENT '订单号',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '类型(备用字段)',
  `content_name` varchar(30) DEFAULT NULL COMMENT '操作人账号/姓名',
  `content_title` varchar(50) DEFAULT NULL COMMENT '操作内容',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '备注',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=181 DEFAULT CHARSET=utf8 COMMENT='订单操作日志';

-- ----------------------------
-- Records of cms_order_log
-- ----------------------------
INSERT INTO `cms_order_log` VALUES ('163', '1', '', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-10-08 10:55:38', null);
INSERT INTO `cms_order_log` VALUES ('164', '1', '', null, '管理员:admin(系统管理员)', '将支付状态修改为已支付', null, '2015-10-08 10:55:47', null);
INSERT INTO `cms_order_log` VALUES ('165', '1', '345435', null, '管理员:admin(系统管理员)', '将订单状态修改为已完成', null, '2015-10-08 10:57:45', null);
INSERT INTO `cms_order_log` VALUES ('166', '1', '345435', null, '管理员:admin(系统管理员)', '将支付状态修改为已支付', null, '2015-10-08 10:57:48', null);
INSERT INTO `cms_order_log` VALUES ('167', '1', '345435', null, '管理员:admin(系统管理员)', '将订单状态修改为待确认', null, '2015-10-08 11:03:31', null);
INSERT INTO `cms_order_log` VALUES ('168', '1', '345435', null, '管理员:admin(系统管理员)', '将订单状态修改为已完成', null, '2015-10-08 11:03:33', null);
INSERT INTO `cms_order_log` VALUES ('169', '1', '345435', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-10-08 11:03:34', null);
INSERT INTO `cms_order_log` VALUES ('170', '1', '345435', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-10-08 11:05:24', null);
INSERT INTO `cms_order_log` VALUES ('171', '1', '345435', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-10-08 11:14:36', null);
INSERT INTO `cms_order_log` VALUES ('172', '4', '1510111810028149', null, '用户', '用户取消订单', null, '2015-10-11 18:19:47', null);
INSERT INTO `cms_order_log` VALUES ('173', '8', '1510242336542846', null, '商户', '商户响应订单', null, '2015-10-25 00:49:33', null);
INSERT INTO `cms_order_log` VALUES ('174', '7', '1510242336463785', null, '商户', '商户拒绝订单', null, '2015-10-25 00:54:38', null);
INSERT INTO `cms_order_log` VALUES ('175', '6', '1510242336032978', null, '商户', '商户响应订单', null, '2015-10-25 00:58:03', null);
INSERT INTO `cms_order_log` VALUES ('176', '5', '1510242335446578', null, '商户', '商户响应订单', null, '2015-10-25 00:58:12', null);
INSERT INTO `cms_order_log` VALUES ('177', '6', '1510242336032978', null, '商户', '商户取消订单', null, '2015-10-25 00:58:44', null);
INSERT INTO `cms_order_log` VALUES ('178', '5', '1510242335446578', null, '商户', '商户完成订单', null, '2015-10-25 01:00:46', null);
INSERT INTO `cms_order_log` VALUES ('179', '9', '1511081301329069', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-11-08 13:08:03', null);
INSERT INTO `cms_order_log` VALUES ('180', '9', '1511081301329069', null, '管理员:admin(系统管理员)', '编辑订单', null, '2015-11-08 13:08:13', null);

-- ----------------------------
-- Table structure for `cms_params`
-- ----------------------------
DROP TABLE IF EXISTS `cms_params`;
CREATE TABLE `cms_params` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_module` varchar(30) DEFAULT NULL COMMENT '所属模块',
  `content_name` varchar(30) DEFAULT NULL COMMENT '参数英文名称(程序调用使用)',
  `content_text` varchar(30) DEFAULT NULL COMMENT '参数名称',
  `content_value` varchar(500) DEFAULT NULL COMMENT '参数值',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COMMENT='配置参数';

-- ----------------------------
-- Records of cms_params
-- ----------------------------
INSERT INTO `cms_params` VALUES ('1', 'global', 'content_title', '网站标题', '矩阵CMS');
INSERT INTO `cms_params` VALUES ('2', 'global', 'seo_keywords', 'SEO关键词', '矩阵CMS');
INSERT INTO `cms_params` VALUES ('3', 'global', 'seo_description', 'SEO描述', '矩阵CMS');
INSERT INTO `cms_params` VALUES ('4', 'global', 'content_copyright', '版权信息', 'Copyright ©2014 smallcms, All Rights Reserved 京ICP备XXXXXXX号');
INSERT INTO `cms_params` VALUES ('5', 'global', 'count_code', '流量统计代码', '<script>\nvar _hmt = _hmt || [];\n(function() {\n  var hm = document.createElement(\"script\");\n  hm.src = \"//hm.baidu.com/hm.js?b54102de97f71b5caec20c507f022c45\";\n  var s = document.getElementsByTagName(\"script\")[0]; \n  s.parentNode.insertBefore(hm, s);\n})();\n</script>');
INSERT INTO `cms_params` VALUES ('6', 'global', 'mobile_msg_api', '短信接口', 'http://utf8.sms.webchinese.cn/?Uid=xuexinfeng&Key=14525d9250f1e3775ba1&smsMob={mobile}&smsText={text}');
INSERT INTO `cms_params` VALUES ('7', 'global', 'service_tel', '客服电话', '400-887-6688');
INSERT INTO `cms_params` VALUES ('8', 'global', 'service_qq', '客服QQ', '');
INSERT INTO `cms_params` VALUES ('9', 'global', 'content_name', '网站简短名称', '矩阵CMS');
INSERT INTO `cms_params` VALUES ('10', 'global', 'email_host', '邮件服务器', 'smtp.163.com');
INSERT INTO `cms_params` VALUES ('11', 'global', 'email_port', '端口号', '25');
INSERT INTO `cms_params` VALUES ('12', 'global', 'email_email', '发信邮箱', 'smallcms@163.com');
INSERT INTO `cms_params` VALUES ('13', 'global', 'email_user', '邮箱用户名', 'smallcms');
INSERT INTO `cms_params` VALUES ('14', 'global', 'email_pass', '邮箱密码', 'small123');
INSERT INTO `cms_params` VALUES ('19', 'global', 'company_address', '公司地址', '北京市朝阳区慧忠里103号洛克时代中心B座13A01');
INSERT INTO `cms_params` VALUES ('24', 'global', 'service_email', '客服邮箱', 'smallcms@163.com');

-- ----------------------------
-- Table structure for `cms_product`
-- ----------------------------
DROP TABLE IF EXISTS `cms_product`;
CREATE TABLE `cms_product` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_org` varchar(40) DEFAULT NULL COMMENT '单位名称',
  `content_name` varchar(50) DEFAULT NULL COMMENT '产品名称',
  `content_type` tinyint(4) DEFAULT '0' COMMENT '产品类型',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `content_hit` int(11) DEFAULT '0' COMMENT '点击量',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COMMENT='产品表';

-- ----------------------------
-- Records of cms_product
-- ----------------------------
INSERT INTO `cms_product` VALUES ('2', '9', '广发银行', '薪满益足人民币理财计划150414版(私行版)', '1', '1', '999', '1', '1', '2015-04-06 12:30:00', '1');
INSERT INTO `cms_product` VALUES ('7', '9', '广发银行', '薪满益足人民币理财计划150414版(乐享版)', '0', '0', '999', '1', '0', '2015-04-27 16:55:06', '1');
INSERT INTO `cms_product` VALUES ('5', '10', '招商银行', '招银进宝之鼎鼎成金12819号理财计划(150天)', '1', '1', '999', '1', '0', '2015-04-27 16:41:17', '1');
INSERT INTO `cms_product` VALUES ('6', '9', '广发银行', '薪加薪16号人民币理财计划(2015年第50期)', '1', '0', '999', '1', '0', '2015-04-27 16:49:55', '1');
INSERT INTO `cms_product` VALUES ('8', '10', '招商银行', '招银进宝之鼎鼎成金12428号理财计划(91天)', '1', '1', '999', '1', '1', '2015-04-27 16:51:50', '1');
INSERT INTO `cms_product` VALUES ('9', '8', '中国工商银行', '工银个人客户尊享系列封闭净值型理财产品2015年第15期', '1', '0', '999', '1', '25', '2015-05-03 12:35:21', '1');
INSERT INTO `cms_product` VALUES ('10', '11', '中国建设银行', '山东省分行\"乾元通财\"非保本型人民币2015年第10期理财产品(49天) ', '1', '0', '999', '1', '0', '2015-04-27 17:00:02', '1');
INSERT INTO `cms_product` VALUES ('17', '8', '中国工商银行', '测试新产品', '2', '0', '999', '1', '0', '2015-05-03 11:28:31', null);
INSERT INTO `cms_product` VALUES ('12', '11', '中国建设银行', '山东省分行\"乾元通财\"非保本型人民币2015年第12期理财产品(132天) ', '1', '0', '999', '1', '0', '2015-04-27 17:04:45', '1');
INSERT INTO `cms_product` VALUES ('13', '8', '中国工商银行', '保本型个人人民币理财产品(BBD15042)(仅深圳)', '1', '0', '999', '1', '5', '2015-04-27 17:12:42', '1');
INSERT INTO `cms_product` VALUES ('14', '12', '北京银行', '心喜系列2015年第14期人民币组合投资型非保本理财产品', '1', '0', '999', '1', '0', '2015-04-27 17:15:37', '1');
INSERT INTO `cms_product` VALUES ('15', '12', '北京银行', '心喜系列2015年第11期人民币信托债券非保本理财产品', '1', '0', '999', '1', '4', '2015-04-27 17:17:57', '1');
INSERT INTO `cms_product` VALUES ('16', '12', '北京银行', '心喜系列2015年第11期人民币组合投资型非保本理财产品', '1', '0', '999', '1', '8', '2015-04-27 17:20:32', '1');

-- ----------------------------
-- Table structure for `cms_role`
-- ----------------------------
DROP TABLE IF EXISTS `cms_role`;
CREATE TABLE `cms_role` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '角色名称',
  `content_value` text COMMENT '角色权限',
  `publish` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否开启',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='管理员角色';

-- ----------------------------
-- Records of cms_role
-- ----------------------------
INSERT INTO `cms_role` VALUES ('1', '超级管理员', 'root', '1', '2014-04-30 22:48:12', '1');
INSERT INTO `cms_role` VALUES ('7', '资讯管理', 'menu,menu.223,menu.223.edit,', '1', '2016-10-22 14:02:00', '11');

-- ----------------------------
-- Table structure for `cms_sql_debug`
-- ----------------------------
DROP TABLE IF EXISTS `cms_sql_debug`;
CREATE TABLE `cms_sql_debug` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_url` varchar(500) DEFAULT NULL COMMENT 'url地址',
  `content_sql` varchar(500) DEFAULT NULL COMMENT 'sql语句',
  `content_error` varchar(500) DEFAULT NULL COMMENT '错误信息',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '报错时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='sql报错日志';

-- ----------------------------
-- Records of cms_sql_debug
-- ----------------------------
INSERT INTO `cms_sql_debug` VALUES ('1', '/angularjs_component/server/index.php?acl=news&method=gridLists&menu=223&content_name=&content_author=&content_source=&pageIndex=1&pageSize=10', 'select auto_id,content_name,content_subname,menu_id,content_link,content_img,content_file,content_desc,create_time  from cms_news where  publish=\'1\' and menu_id =\'223\'  order by recommend desc,position asc,create_time desc,auto_id desc limit 0,', 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\' at line 1', '2017-07-21 15:44:23');
INSERT INTO `cms_sql_debug` VALUES ('2', '/angularjs_component/server/index.php?acl=news&method=gridLists&menu=223&content_name=&content_author=&content_source=&pageIndex=1&pageSize=10', 'select auto_id,content_name,content_subname,menu_id,content_link,content_img,content_file,content_desc,create_time  from cms_news where  publish=\'1\' and menu_id =\'223\'  order by recommend desc,position asc,create_time desc,auto_id desc limit 0,', 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\' at line 1', '2017-07-21 15:44:26');
INSERT INTO `cms_sql_debug` VALUES ('3', '/angularjs_component/server/index.php?acl=news&method=gridLists&menu=223&content_name=&content_author=&content_source=&pageIndex=1&pageSize=10', 'select auto_id,content_name,content_subname,menu_id,content_link,content_img,content_file,content_desc,create_time  from cms_news where  publish=\'1\' and menu_id =\'223\'  order by recommend desc,position asc,create_time desc,auto_id desc limit 0,', 'You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near \'\' at line 1', '2017-07-21 15:44:30');
INSERT INTO `cms_sql_debug` VALUES ('4', '/angularjs_component/server/index.php?acl=news&method=gridLists&menu=223&content_name=&content_author=&content_source=&pageIndex=1&pageSize=10', 'select auto_id,content_name,content_author,menu_id,content_sourse,content_img,content_file,content_desc,create_time  from cms_news where  publish=\'1\' and menu_id =\'223\'  order by recommend desc,position asc,create_time desc,auto_id desc limit 0,10', 'Unknown column \'content_sourse\' in \'field list\'', '2017-07-21 15:47:19');

-- ----------------------------
-- Table structure for `cms_subject`
-- ----------------------------
DROP TABLE IF EXISTS `cms_subject`;
CREATE TABLE `cms_subject` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `content_author` varchar(30) DEFAULT NULL COMMENT '作者名称',
  `content_title` varchar(50) DEFAULT NULL COMMENT '标题',
  `content_body` text COMMENT '内容',
  `category_id` int(11) DEFAULT NULL COMMENT '分类ID',
  `content_status` tinyint(4) DEFAULT '0' COMMENT '状态:0待审核,1已发布,2已关闭',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='话题表';

-- ----------------------------
-- Records of cms_subject
-- ----------------------------
INSERT INTO `cms_subject` VALUES ('1', '6', '薛新峰', 'dfhdfh', 'fncncvncv', '2', '1', '0', '999', '2015-03-07 17:34:20');

-- ----------------------------
-- Table structure for `cms_subject_category`
-- ----------------------------
DROP TABLE IF EXISTS `cms_subject_category`;
CREATE TABLE `cms_subject_category` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `pid` int(11) DEFAULT '0' COMMENT '上级ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '分类名称',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '简介',
  `auto_position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '1' COMMENT '发布状态',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员id',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='话题分类表';

-- ----------------------------
-- Records of cms_subject_category
-- ----------------------------
INSERT INTO `cms_subject_category` VALUES ('1', '0', '生活', '生活分类', '1425723330', '1', '1', '2015-03-07 18:15:26');
INSERT INTO `cms_subject_category` VALUES ('2', '1', '情感', '', '1425723706', '1', '1', '2015-03-07 18:20:58');
INSERT INTO `cms_subject_category` VALUES ('3', '1', '饮食', '', '1425723668', '1', '1', '2015-03-07 18:21:39');
INSERT INTO `cms_subject_category` VALUES ('4', '0', '工作', '', '1425723727', '1', '1', '2015-03-07 18:22:01');
INSERT INTO `cms_subject_category` VALUES ('5', '4', '商务', '', '1425723747', '1', '1', '2015-03-07 18:22:08');
INSERT INTO `cms_subject_category` VALUES ('6', '4', '求职', '', '1425734874', '1', '1', '2015-03-07 21:27:43');

-- ----------------------------
-- Table structure for `cms_subject_reply`
-- ----------------------------
DROP TABLE IF EXISTS `cms_subject_reply`;
CREATE TABLE `cms_subject_reply` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `subject_id` int(11) DEFAULT NULL COMMENT '话题ID',
  `pid` int(11) DEFAULT '0' COMMENT '被回复内容id，若是直接回复主题则为0',
  `content_reply` varchar(200) DEFAULT NULL COMMENT '回复内容',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='话题回复表';

-- ----------------------------
-- Records of cms_subject_reply
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_topic`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic`;
CREATE TABLE `cms_topic` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_type` tinyint(4) DEFAULT '0' COMMENT '专题类型（备用字段）',
  `content_name` varchar(60) DEFAULT NULL COMMENT '专题名称',
  `content_desc` varchar(250) DEFAULT NULL COMMENT '简介',
  `content_img` varchar(50) DEFAULT NULL COMMENT '图片',
  `publish` tinyint(4) DEFAULT '1' COMMENT '发布状态',
  `is_templet` tinyint(4) DEFAULT '0' COMMENT '是否是模板（被复制的）',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `content_hit` int(11) DEFAULT '0' COMMENT '点击量',
  `register_num` int(11) DEFAULT '0' COMMENT '报名人数',
  `content_tel` varchar(50) DEFAULT NULL COMMENT '联系电话',
  `content_address` varchar(50) DEFAULT NULL COMMENT '地址',
  `apply_endtime` datetime DEFAULT NULL COMMENT '报名截止时间',
  `content_copyright` varchar(150) DEFAULT NULL COMMENT '版权信息',
  `seo_keywords` varchar(200) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(250) DEFAULT NULL COMMENT 'SEO描述',
  `province_id` int(11) DEFAULT NULL COMMENT '省份ID',
  `city_id` int(11) DEFAULT NULL COMMENT '城市ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '创建人',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8 COMMENT='专题子站表';

-- ----------------------------
-- Records of cms_topic
-- ----------------------------
INSERT INTO `cms_topic` VALUES ('1', '2', '优贝乐（常营）校区', '中心简介', '2014/12/07/1418406177.jpg', '1', '0', '788', '152', '0', '010-85526155', '北京市朝阳区长楹天街西区三层', '2014-12-19 01:00:00', '主办：中国医师协会妇产科医师分会 Copyright 2014 All rights reserved <br/>\r\n京ICP备05086604号-8', '中国医师协会妇产科医师分会2222', '中国医师协会妇产科医师分会333', '1', '1', '2014-11-27 22:37:18', '1');
INSERT INTO `cms_topic` VALUES ('7', '0', '优贝乐（广渠门）校区', '中心简介', '', '1', '0', '999', '0', '0', '010-87926577', '北京市东城区夕照寺街16号华城SOHO宝达大厦3层', null, null, null, null, '1', '1', '2015-07-24 02:23:54', '1');
INSERT INTO `cms_topic` VALUES ('8', '0', '优贝乐（怀柔）校区', '中心简介', '', '1', '0', '999', '0', '0', '010-60686160 ', '北京市怀柔区青春路15号（快乐娃后院3层）', null, null, null, null, '1', '1', '2015-07-24 02:24:49', '1');
INSERT INTO `cms_topic` VALUES ('9', '0', '优贝乐（哈尔滨）校区 ', '中心简介', '', '1', '0', '999', '0', '0', '0451-89648822', '哈尔滨香坊区衡山路18号远东大厦C区1楼（万达广场对面）', null, null, null, null, '10', '73', '2015-07-24 02:25:28', '1');
INSERT INTO `cms_topic` VALUES ('10', '0', '优贝乐（长春）校区', '中心简介', '', '1', '0', '999', '0', '0', '0431-88546333', '长春市朝阳区安达街199号百聚商务广场601室', null, null, null, null, '9', '64', '2015-07-24 02:26:56', '1');
INSERT INTO `cms_topic` VALUES ('11', '0', ' 优贝乐（包头）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '', null, null, null, null, '32', '379', '2015-07-24 02:27:29', '1');
INSERT INTO `cms_topic` VALUES ('12', '0', '优贝乐（呼和浩特）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '呼和浩特市赛汗区', null, null, null, null, '32', '378', '2015-07-24 02:28:09', '1');
INSERT INTO `cms_topic` VALUES ('13', '0', '优贝乐（鄂尔多斯）校区', '中心简介', '', '1', '0', '999', '0', '0', '0477-7581001', '内蒙古鄂尔多斯乌审旗五马路建行个人贷款中心北边二楼', null, null, null, null, '32', '383', '2015-07-24 02:28:45', '1');
INSERT INTO `cms_topic` VALUES ('14', '0', '优贝乐（南开 ）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '天津市南开区东马路138号新世界百货商务中心三层', null, null, null, null, '2', '2', '2015-07-24 02:29:19', '1');
INSERT INTO `cms_topic` VALUES ('15', '0', '优贝乐（河西）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '天津市河西区下瓦房恒华大厦2门3层A20', null, null, null, null, '2', '2', '2015-07-24 02:29:58', '1');
INSERT INTO `cms_topic` VALUES ('16', '0', '优贝乐（秦皇岛）校区', '中心简介', '', '1', '0', '999', '5', '0', '0335-3624113/ 3624117', '秦皇岛市海港区迎宾路9号电视台院内万科楼B座', null, null, null, null, '5', '7', '2015-07-24 02:30:36', '1');
INSERT INTO `cms_topic` VALUES ('17', '0', '优贝乐（廊坊 ）校区', '中心简介', '', '1', '0', '999', '0', '0', '0316-5269690', '河北廊坊市广阳区华夏幸福城润园小区6-23', null, null, null, null, '5', '14', '2015-07-24 02:32:23', '1');
INSERT INTO `cms_topic` VALUES ('18', '0', '优贝乐（济南）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '济南市历下区利农庄路8号绿景尚品', null, null, null, null, '16', '147', '2015-07-24 02:35:27', '1');
INSERT INTO `cms_topic` VALUES ('19', '0', '优贝乐（马鞍山）校区', '中心简介', '', '1', '0', '999', '0', '0', '0555-2776866', '安徽省马鞍山市海外海茗仕苑底商5栋106', null, null, null, null, '13', '114', '2015-07-24 02:35:47', '1');
INSERT INTO `cms_topic` VALUES ('20', '0', '优贝乐（海珠）校区', '中心简介', '', '1', '0', '999', '0', '0', '020-34329917', '广州市海珠区叠景路227号合生广场北区二楼206A', null, null, null, null, '20', '215', '2015-07-24 02:36:17', '1');
INSERT INTO `cms_topic` VALUES ('21', '0', '优贝乐（韶关）校区', '中心简介', '', '1', '0', '999', '4', '0', '0751-6970169', '', null, null, null, null, '20', '217', '2015-07-24 02:37:16', '1');
INSERT INTO `cms_topic` VALUES ('22', '0', '优贝乐（乌鲁木齐）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '乌鲁木齐市沙依巴克区格林威治城商业街11号', null, null, null, null, '31', '356', '2015-07-24 02:38:03', '1');
INSERT INTO `cms_topic` VALUES ('23', '0', '优贝乐（喀什）校区 ', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '新疆喀什市解放南路136号和田玉交易市场C座一单元1603', null, null, null, null, '31', '364', '2015-07-24 02:38:29', '1');
INSERT INTO `cms_topic` VALUES ('29', '0', '优贝乐（西安）校区', '中心简介', '', '1', '0', '999', '0', '0', '0298-8865418', '西安市高新区高新路88号尚品国际B座1201', null, null, null, null, '27', '320', '2015-07-24 02:43:01', '1');
INSERT INTO `cms_topic` VALUES ('30', '0', '优贝乐（宁海 ）校区 ', '中心简介', '', '1', '0', '999', '0', '0', '0574-65222988', '宁海县跃龙街道气象北路306,308号', null, null, null, null, '12', '100', '2015-07-24 02:43:36', '1');
INSERT INTO `cms_topic` VALUES ('25', '0', '优贝乐（曲靖）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '云南省曲靖市麒麟区翠峰路89号', null, null, null, null, '25', '297', '2015-07-24 02:39:35', '1');
INSERT INTO `cms_topic` VALUES ('26', '0', '优贝乐（南宁）校区', '中心简介', '', '1', '0', '999', '0', '0', '0771-6776506', '南宁市青秀区民族大道航洋国际购物中心三层', null, null, null, null, '28', '330', '2015-07-24 02:40:25', '1');
INSERT INTO `cms_topic` VALUES ('27', '0', '优贝乐（贵港）校区', '中心简介', '', '1', '0', '999', '0', '0', '077-54259002', '贵港市贵北区盛世名门C18-C19', null, null, null, null, '28', '337', '2015-07-24 02:40:55', '1');
INSERT INTO `cms_topic` VALUES ('28', '0', '优贝乐（武汉 ）校区', '中心简介', '', '1', '0', '999', '0', '0', '0278-5507310', '武汉市万达广场', null, null, null, null, '18', '182', '2015-07-24 02:41:38', '1');
INSERT INTO `cms_topic` VALUES ('31', '0', '优贝乐（镇江 ）校区', '中心简介', '', '1', '0', '999', '0', '0', '4008-869-896', '江苏省镇江市香山华庭', null, null, null, null, '11', '96', '2015-07-24 02:45:08', '1');

-- ----------------------------
-- Table structure for `cms_topic_ad`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_ad`;
CREATE TABLE `cms_topic_ad` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题ID',
  `space_id` int(11) DEFAULT NULL COMMENT '广告位ID',
  `content_name` varchar(30) DEFAULT NULL COMMENT '广告名称',
  `content_title` varchar(50) DEFAULT NULL COMMENT '标题',
  `content_link` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `content_target` varchar(20) DEFAULT NULL COMMENT '打开方式',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '广告类型',
  `content_file` varchar(60) DEFAULT NULL COMMENT '广告文件',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '发布状态',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 COMMENT='专题子站广告表';

-- ----------------------------
-- Records of cms_topic_ad
-- ----------------------------
INSERT INTO `cms_topic_ad` VALUES ('37', '1', '34', '01', null, '', null, '1', '2014/12/08/1418679311.jpg', '999', '1', '1', '2014-12-08 22:11:33');
INSERT INTO `cms_topic_ad` VALUES ('38', '1', '35', '01', null, '', null, '1', '2014/12/08/1418761602.jpg', '999', '1', '1', '2014-12-08 22:12:15');
INSERT INTO `cms_topic_ad` VALUES ('39', '1', '35', '02', null, '', null, '1', '2014/12/08/1418284856.jpg', '999', '1', '1', '2014-12-08 22:12:43');

-- ----------------------------
-- Table structure for `cms_topic_ad_space`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_ad_space`;
CREATE TABLE `cms_topic_ad_space` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题ID，预留字段，目前各子站的广告位是通用的',
  `content_name` varchar(30) DEFAULT NULL COMMENT '广告位名称',
  `content_desc` varchar(120) DEFAULT NULL COMMENT '简介',
  `content_width` varchar(11) DEFAULT NULL COMMENT '广告位宽度',
  `content_height` varchar(11) DEFAULT NULL COMMENT '广告位高度',
  `content_type` tinyint(4) DEFAULT NULL COMMENT '广告位类型:1图片广告,2轮播广告',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=utf8 COMMENT='专题子站广告位';

-- ----------------------------
-- Records of cms_topic_ad_space
-- ----------------------------
INSERT INTO `cms_topic_ad_space` VALUES ('35', '1', '首页轮播广告', '', '410', '260', '2', '999', '1', '2014-12-07 23:13:50');
INSERT INTO `cms_topic_ad_space` VALUES ('34', '1', 'banner广告位', '', '980', '365', '1', '999', '1', '2014-12-07 23:10:19');

-- ----------------------------
-- Table structure for `cms_topic_article`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_article`;
CREATE TABLE `cms_topic_article` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '频道ID',
  `content_desc` varchar(500) DEFAULT NULL COMMENT '文章摘要',
  `content_img` varchar(50) DEFAULT NULL COMMENT '图片',
  `content_body` text COMMENT '文章正文',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题文章单页';

-- ----------------------------
-- Records of cms_topic_article
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_topic_links`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_links`;
CREATE TABLE `cms_topic_links` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题id',
  `menu_id` int(11) DEFAULT NULL COMMENT '频道id',
  `content_name` varchar(60) DEFAULT NULL COMMENT '标题',
  `content_link` varchar(100) DEFAULT NULL COMMENT '链接地址',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=53 DEFAULT CHARSET=utf8 COMMENT='专题子站友情链接';

-- ----------------------------
-- Records of cms_topic_links
-- ----------------------------
INSERT INTO `cms_topic_links` VALUES ('32', '1', '85', '掌上医讯', '', '2014/12/07/1418238120.jpg', '999', '1', '1', '2014-12-07 23:41:19');
INSERT INTO `cms_topic_links` VALUES ('33', '1', '85', '合作媒体-测试友情链接标题1', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('34', '1', '85', '合作媒体-测试友情链接标题2', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('35', '1', '85', '合作媒体-测试友情链接标题3', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('36', '1', '85', '合作媒体-测试友情链接标题4', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('37', '1', '85', '合作媒体-测试友情链接标题5', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('38', '1', '85', '合作媒体-测试友情链接标题6', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('39', '1', '85', '合作媒体-测试友情链接标题7', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('40', '1', '85', '合作媒体-测试友情链接标题8', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('41', '1', '85', '合作媒体-测试友情链接标题9', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('42', '1', '85', '合作媒体-测试友情链接标题10', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('43', '1', '85', '合作媒体-测试友情链接标题11', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('44', '1', '85', '合作媒体-测试友情链接标题12', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('45', '1', '85', '合作媒体-测试友情链接标题13', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('46', '1', '85', '合作媒体-测试友情链接标题14', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('47', '1', '85', '合作媒体-测试友情链接标题15', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('48', '1', '85', '合作媒体-测试友情链接标题16', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('49', '1', '85', '合作媒体-测试友情链接标题17', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('50', '1', '85', '合作媒体-测试友情链接标题18', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('51', '1', '85', '合作媒体-测试友情链接标题19', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');
INSERT INTO `cms_topic_links` VALUES ('52', '1', '85', '合作媒体-测试友情链接标题20', 'http://www.baidu.com', 'nophoto.jpg', '999', '1', '1', '2014-12-08 23:19:51');

-- ----------------------------
-- Table structure for `cms_topic_menu`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_menu`;
CREATE TABLE `cms_topic_menu` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题ID',
  `menu_key` varchar(20) DEFAULT '' COMMENT '专题标识，用于程序调用',
  `content_name` varchar(30) DEFAULT NULL COMMENT '栏目名称',
  `content_link` varchar(100) DEFAULT NULL COMMENT '外链地址',
  `content_alias` varchar(30) DEFAULT NULL COMMENT '栏目目录',
  `action_method` varchar(30) DEFAULT NULL COMMENT '模板标识',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `content_desc` varchar(255) DEFAULT NULL COMMENT '简介',
  `auto_code` varchar(20) DEFAULT NULL COMMENT '自动生成的栏目编码',
  `auto_position` int(11) DEFAULT NULL COMMENT '排序位置',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `content_module` varchar(30) DEFAULT NULL COMMENT '栏目功能模块',
  `seo_keywords` varchar(120) DEFAULT NULL COMMENT 'SEO关键词',
  `seo_description` varchar(255) DEFAULT NULL COMMENT 'SEO描述',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=303 DEFAULT CHARSET=utf8 COMMENT='专题菜单表';

-- ----------------------------
-- Records of cms_topic_menu
-- ----------------------------
INSERT INTO `cms_topic_menu` VALUES ('83', '0', '83', '课程介绍', '', null, '', null, null, '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('84', '0', '84', '教师团队', '', null, '', null, null, '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('89', '0', '1', '中心首页', '', null, '', null, null, '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('90', '0', '90', '中心介绍', '', null, '', null, null, '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('91', '0', '91', '联系我们', '', null, null, null, null, '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('105', '1', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '0', 'topicNews', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('106', '1', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('107', '1', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('108', '1', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('109', '1', '91', '联系我们', '', '', '', '', '', '1026', '1437302804', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('110', '1', '103', '精彩瞬间', '', '', '', '', '', '1027', '1418310794', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('111', '1', '104', '最新活动', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('103', '0', '103', '精彩瞬间', '', null, '', null, null, '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('104', '0', '104', '活动资讯', '', null, '', null, null, '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('112', '5', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('113', '5', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('114', '5', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('115', '5', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('116', '5', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('117', '5', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('118', '5', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('119', '6', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('120', '6', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('121', '6', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('122', '6', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('123', '6', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('124', '6', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('125', '6', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('126', '7', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('127', '7', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('128', '7', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('129', '7', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('130', '7', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('131', '7', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('132', '7', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('133', '8', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('134', '8', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('135', '8', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('136', '8', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('137', '8', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('138', '8', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('139', '8', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('140', '9', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('141', '9', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('142', '9', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('143', '9', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('144', '9', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('145', '9', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('146', '9', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('147', '10', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('148', '10', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('149', '10', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('150', '10', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('151', '10', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('152', '10', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('153', '10', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('154', '11', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('155', '11', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('156', '11', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('157', '11', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('158', '11', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('159', '11', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('160', '11', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('161', '12', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('162', '12', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('163', '12', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('164', '12', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('165', '12', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('166', '12', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('167', '12', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('168', '13', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('169', '13', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('170', '13', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('171', '13', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('172', '13', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('173', '13', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('174', '13', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('175', '14', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('176', '14', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('177', '14', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('178', '14', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('179', '14', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('180', '14', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('181', '14', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('182', '15', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('183', '15', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('184', '15', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('185', '15', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('186', '15', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('187', '15', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('188', '15', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('189', '16', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('190', '16', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('191', '16', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('192', '16', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('193', '16', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('194', '16', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('195', '16', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('196', '17', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('197', '17', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('198', '17', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('199', '17', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('200', '17', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('201', '17', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('202', '17', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('203', '18', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('204', '18', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('205', '18', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('206', '18', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('207', '18', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('208', '18', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('209', '18', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('210', '19', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('211', '19', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('212', '19', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('213', '19', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('214', '19', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('215', '19', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('216', '19', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('217', '20', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('218', '20', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('219', '20', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('220', '20', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('221', '20', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('222', '20', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('223', '20', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('224', '21', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('225', '21', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('226', '21', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('227', '21', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('228', '21', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('229', '21', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('230', '21', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('231', '22', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('232', '22', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('233', '22', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('234', '22', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('235', '22', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('236', '22', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('237', '22', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('238', '23', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('239', '23', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('240', '23', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('241', '23', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('242', '23', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('243', '23', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('244', '23', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('245', '24', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('246', '24', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('247', '24', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('248', '24', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('249', '24', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('250', '24', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('251', '24', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('252', '25', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('253', '25', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('254', '25', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('255', '25', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('256', '25', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('257', '25', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('258', '25', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('259', '26', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('260', '26', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('261', '26', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('262', '26', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('263', '26', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('264', '26', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('265', '26', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('266', '27', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('267', '27', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('268', '27', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('269', '27', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('270', '27', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('271', '27', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('272', '27', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('273', '28', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('274', '28', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('275', '28', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('276', '28', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('277', '28', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('278', '28', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('279', '28', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('280', '29', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('281', '29', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('282', '29', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('283', '29', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('284', '29', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('285', '29', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('286', '29', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('287', '30', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('288', '30', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('289', '30', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('290', '30', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('291', '30', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('292', '30', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('293', '30', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('294', '31', '83', '课程介绍', '', '', '', '', '', '1018', '1417194889', '1', 'topicArticle', '', '', '2014-11-29 01:14:38', '1');
INSERT INTO `cms_topic_menu` VALUES ('295', '31', '84', '教师团队', '', '', '', '', '', '1019', '1418050211', '1', 'topicNews', '', '', '2014-11-29 01:14:56', '1');
INSERT INTO `cms_topic_menu` VALUES ('296', '31', '1', '中心首页', '', '', '', '', '', '1024', '1417192165', '1', '', '', '', '2014-12-08 22:47:02', '1');
INSERT INTO `cms_topic_menu` VALUES ('297', '31', '90', '中心介绍', '', '', '', '', '', '1025', '1417194877', '1', 'topicArticle', '', '', '2014-12-08 22:49:50', '1');
INSERT INTO `cms_topic_menu` VALUES ('298', '31', '91', '联系我们', '', '', '', '', '', '1026', '1418310794', '1', 'topicArticle', '', '', '2014-12-08 22:50:04', '1');
INSERT INTO `cms_topic_menu` VALUES ('299', '31', '103', '优秀学员', '', '', '', '', '', '1027', '1437302804', '1', 'topicNews', '', '', '2014-12-11 23:12:47', '1');
INSERT INTO `cms_topic_menu` VALUES ('300', '31', '104', '活动资讯', '', '', '', '', '', '10291002', '1418050233', '1', 'topicNews', '', '', '2015-07-19 18:46:30', '1');
INSERT INTO `cms_topic_menu` VALUES ('301', '1', '0', '活动资讯', '', null, '', null, null, '1029', '1437981451', '1', '', '', '', '2015-07-27 15:17:05', '1');
INSERT INTO `cms_topic_menu` VALUES ('302', '1', '0', '活动回顾', '', null, '', null, null, '10291001', '1437981478', '1', 'topicNews', '', '', '2015-07-27 15:17:39', '1');

-- ----------------------------
-- Table structure for `cms_topic_news`
-- ----------------------------
DROP TABLE IF EXISTS `cms_topic_news`;
CREATE TABLE `cms_topic_news` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `topic_id` int(11) DEFAULT NULL COMMENT '专题ID',
  `menu_id` int(11) DEFAULT NULL COMMENT '频道ID',
  `content_name` varchar(60) DEFAULT NULL COMMENT '标题',
  `content_subname` varchar(60) DEFAULT NULL COMMENT '副标题',
  `content_link` varchar(100) DEFAULT NULL COMMENT '外链地址',
  `content_author` varchar(20) DEFAULT NULL COMMENT '作者',
  `content_source` varchar(20) DEFAULT NULL COMMENT '来源',
  `content_desc` varchar(255) DEFAULT NULL COMMENT '摘要',
  `content_keywords` varchar(50) DEFAULT NULL COMMENT '关键词',
  `content_img` varchar(60) DEFAULT NULL COMMENT '图片',
  `content_file` varchar(60) DEFAULT NULL COMMENT '附件',
  `content_body` text COMMENT '正文',
  `recommend` tinyint(4) DEFAULT '0' COMMENT '是否推荐',
  `content_hit` int(11) DEFAULT '0' COMMENT '点击量',
  `position` int(11) DEFAULT '999' COMMENT '排序位置',
  `auto_position` int(11) DEFAULT NULL COMMENT '排序位置（备用）',
  `publish` tinyint(4) DEFAULT '0' COMMENT '是否发布',
  `seo_keywords` varchar(120) DEFAULT NULL COMMENT 'seo关键词',
  `seo_description` varchar(255) DEFAULT NULL COMMENT 'seo描述',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='专题资讯表';

-- ----------------------------
-- Records of cms_topic_news
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_user`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user`;
CREATE TABLE `cms_user` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_user` varchar(30) DEFAULT NULL COMMENT '用户名',
  `content_pass` varchar(40) DEFAULT NULL COMMENT '密码',
  `pass_randstr` varchar(20) DEFAULT NULL COMMENT '密钥',
  `content_token` varchar(20) DEFAULT NULL COMMENT '验证token，用于flash上传文件',
  `content_name` varchar(30) DEFAULT NULL COMMENT '管理员姓名',
  `content_role` varchar(100) DEFAULT NULL COMMENT '角色ID，多个角色之间用半角逗号隔开',
  `org_id` int(11) DEFAULT '0' COMMENT '职位ID',
  `publish` tinyint(4) NOT NULL DEFAULT '0' COMMENT '是否发布',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  `create_user` int(11) DEFAULT NULL COMMENT '操作管理员ID',
  `last_login_fail_time` datetime DEFAULT NULL,
  `login_fail_times` int(11) DEFAULT '0',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COMMENT='管理员用户';

-- ----------------------------
-- Records of cms_user
-- ----------------------------
INSERT INTO `cms_user` VALUES ('1', 'admin', '3d68bd788076dc6a662c301078455657', '7421783', '9536926', '系统管理员', '1', '1', '1', '2014-04-24 00:09:00', '1', null, '0');
INSERT INTO `cms_user` VALUES ('10', 'jishu01', '61de8444806896d72038478d8591996b', '7672271', '58106', '技术01', '7,', '4', '1', '2016-10-22 13:57:47', '1', null, '0');
INSERT INTO `cms_user` VALUES ('11', 'jishu02', '63671e8a640464700fcaac8b92f4cc11', '8578369', '29352', '技术 02', '7,', '4', '1', '2016-10-22 13:58:21', '1', null, '0');
INSERT INTO `cms_user` VALUES ('12', 'jishuzhuguan', '458e28afe305cdc2ad50415973d89622', '5238250', '13946', '主管', '7,', '2', '1', '2016-10-22 13:58:49', '1', null, '0');

-- ----------------------------
-- Table structure for `cms_user_department`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_department`;
CREATE TABLE `cms_user_department` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `auto_code` varchar(30) DEFAULT NULL,
  `content_desc` varchar(50) DEFAULT NULL,
  `auto_position` int(11) DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `create_user` int(11) DEFAULT '0',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='部门表';

-- ----------------------------
-- Records of cms_user_department
-- ----------------------------
INSERT INTO `cms_user_department` VALUES ('1', '总经理办公室', '1000', '', '1474988545', '2016-09-27 23:01:39', '1');
INSERT INTO `cms_user_department` VALUES ('2', '技术部', '10001002', '', '1474990938', '2016-09-27 23:06:25', '1');
INSERT INTO `cms_user_department` VALUES ('3', '运营部', '10001001', '', '1474990956', '2016-09-27 23:15:29', '1');

-- ----------------------------
-- Table structure for `cms_user_level`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_level`;
CREATE TABLE `cms_user_level` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) DEFAULT NULL,
  `department_id` int(11) DEFAULT '0',
  `auto_code` varchar(30) DEFAULT NULL,
  `content_desc` varchar(50) DEFAULT NULL,
  `auto_position` int(11) DEFAULT '0',
  `create_time` datetime DEFAULT NULL,
  `create_user` int(11) DEFAULT '0',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user_level
-- ----------------------------
INSERT INTO `cms_user_level` VALUES ('1', '总经理', '1', '1000', '', '1474988545', '2016-09-27 23:01:39', '1');
INSERT INTO `cms_user_level` VALUES ('2', '技术部主管', '2', '10001002', '部门负责人', '1474990938', '2016-09-27 23:06:25', '1');
INSERT INTO `cms_user_level` VALUES ('3', '运营部主管', '3', '10001001', '', '1474990956', '2016-09-27 23:15:29', '1');
INSERT INTO `cms_user_level` VALUES ('4', '开发工程师', '2', '100010021000', '', '1474989362', '2016-09-27 23:15:44', '1');
INSERT INTO `cms_user_level` VALUES ('5', '网站编辑', '3', '100010011000', '', '1474989376', '2016-09-27 23:16:04', '1');

-- ----------------------------
-- Table structure for `cms_user_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_log`;
CREATE TABLE `cms_user_log` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(11) DEFAULT NULL COMMENT '管理员用户ID',
  `content_user` varchar(30) DEFAULT NULL COMMENT '用户名',
  `content_name` varchar(30) DEFAULT NULL COMMENT '姓名',
  `acl` varchar(30) DEFAULT NULL,
  `method` varchar(30) DEFAULT NULL,
  `url` varchar(150) DEFAULT NULL COMMENT 'url地址',
  `request_data` varchar(250) DEFAULT NULL COMMENT '请求的数据',
  `content_desc` varchar(50) DEFAULT NULL COMMENT '备注',
  `ip` varchar(30) DEFAULT NULL COMMENT 'ip地址',
  `create_time` datetime DEFAULT NULL COMMENT '创建时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of cms_user_log
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_user_login_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_user_login_log`;
CREATE TABLE `cms_user_login_log` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `user_id` int(11) DEFAULT NULL COMMENT '用户ID',
  `content_user` varchar(30) DEFAULT NULL COMMENT '用户名',
  `content_name` varchar(20) DEFAULT NULL COMMENT '管理员姓名',
  `create_time` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '登录时间',
  PRIMARY KEY (`auto_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='管理员登录日志';

-- ----------------------------
-- Records of cms_user_login_log
-- ----------------------------

-- ----------------------------
-- Table structure for `cms_vistor_log`
-- ----------------------------
DROP TABLE IF EXISTS `cms_vistor_log`;
CREATE TABLE `cms_vistor_log` (
  `auto_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `content_flag` varchar(20) DEFAULT NULL COMMENT '访问站点标识，如mobile代表手机站',
  `member_id` int(11) DEFAULT NULL COMMENT '会员ID',
  `session_id` varchar(50) DEFAULT NULL COMMENT '用户session_id',
  `content_hit` int(11) DEFAULT '0' COMMENT '浏览页面数量',
  `create_time` datetime DEFAULT NULL COMMENT '首次访问时间',
  `last_time` datetime DEFAULT NULL COMMENT '最后访问时间',
  `content_date` date DEFAULT NULL COMMENT '日期',
  PRIMARY KEY (`auto_id`),
  KEY `content_date_index` (`content_date`),
  KEY `session_id_index` (`session_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1295 DEFAULT CHARSET=utf8 COMMENT='访问记录';

-- ----------------------------
-- Records of cms_vistor_log
-- ----------------------------
INSERT INTO `cms_vistor_log` VALUES ('1271', 'web', '0', 'ss94koun3es5vsaqj05kg00jr6', '1', '2016-10-19 10:56:15', '2016-10-19 10:56:15', '2016-10-19');
INSERT INTO `cms_vistor_log` VALUES ('1272', 'web', '0', '9f0i9sti5lb3v9ltstkkn6m2r6', '15', '2016-10-19 13:33:03', '2016-10-19 13:46:29', '2016-10-19');
INSERT INTO `cms_vistor_log` VALUES ('1273', 'web', '0', '5j0d0f0uehsha5o9umbhp2jh81', '3', '2016-11-07 16:06:46', '2016-11-07 16:06:54', '2016-11-07');
INSERT INTO `cms_vistor_log` VALUES ('1274', 'web', '29', '1avdgn65f4tdlsfn44690mv9r6', '18', '2016-11-13 17:52:41', '2016-11-13 18:06:34', '2016-11-13');
INSERT INTO `cms_vistor_log` VALUES ('1275', 'web', '29', 'gdr30pgig1akogbgusgltcapm6', '3', '2016-11-14 09:55:38', '2016-11-14 09:55:45', '2016-11-14');
INSERT INTO `cms_vistor_log` VALUES ('1276', 'web', '0', 'ds43i1518b01us6tseer9lkjm6', '2', '2016-11-16 17:52:23', '2016-11-16 19:07:23', '2016-11-16');
INSERT INTO `cms_vistor_log` VALUES ('1277', 'web', '0', '3nlmsr191l0jrq42q0illg7dv1', '4', '2016-11-16 17:54:40', '2016-11-16 17:55:54', '2016-11-16');
INSERT INTO `cms_vistor_log` VALUES ('1278', 'web', '29', 'uvldrkshc4pm9euald8pbbu472', '5', '2016-11-22 15:36:57', '2016-11-22 15:37:11', '2016-11-22');
INSERT INTO `cms_vistor_log` VALUES ('1279', 'web', '29', 'e47m1ban17h85j5d36c28ln1i2', '7', '2016-11-22 21:58:55', '2016-11-22 22:14:54', '2016-11-22');
INSERT INTO `cms_vistor_log` VALUES ('1280', 'web', '0', '00fk9rls4u6r0n8sfpmv4sauv3', '12', '2016-11-22 22:15:55', '2016-11-22 23:33:39', '2016-11-22');
INSERT INTO `cms_vistor_log` VALUES ('1281', 'web', '29', 'dkq24kk5edn98f5eacc2leal42', '9', '2016-11-27 21:25:47', '2016-11-27 21:26:31', '2016-11-27');
INSERT INTO `cms_vistor_log` VALUES ('1282', 'web', '29', '8j7b7dm5eri4cud7gkn1epe0c7', '4', '2016-12-06 09:15:27', '2016-12-06 10:37:34', '2016-12-06');
INSERT INTO `cms_vistor_log` VALUES ('1283', 'web', '0', '0h4uaklhrq8l08ulvkdnp88i70', '1', '2016-12-12 12:14:33', '2016-12-12 12:14:33', '2016-12-12');
INSERT INTO `cms_vistor_log` VALUES ('1284', 'web', '29', 'o7t3d7iioouto8s3926fo54js3', '5', '2016-12-15 10:44:48', '2016-12-15 10:45:31', '2016-12-15');
INSERT INTO `cms_vistor_log` VALUES ('1285', 'web', '29', 'sp8kq236fdlgi91iuapt38kg75', '5', '2016-12-25 13:05:33', '2016-12-25 13:05:47', '2016-12-25');
INSERT INTO `cms_vistor_log` VALUES ('1286', 'web', '0', '3ld3pj3oep8sri4ijlfk3jfej1', '7', '2017-01-22 13:43:52', '2017-01-22 16:57:05', '2017-01-22');
INSERT INTO `cms_vistor_log` VALUES ('1287', 'web', '0', 'pv2regmcjr0ijon1nhs0evpno3', '1', '2017-02-09 20:18:56', '2017-02-09 20:18:56', '2017-02-09');
INSERT INTO `cms_vistor_log` VALUES ('1288', 'web', '0', '334hg3i5rarv1rg5g7re8870c0', '2', '2017-02-17 16:17:09', '2017-02-17 16:17:20', '2017-02-17');
INSERT INTO `cms_vistor_log` VALUES ('1289', 'web', '0', 'vaeminaq482di0cdmc162k40p5', '1', '2017-02-21 11:11:50', '2017-02-21 11:11:50', '2017-02-21');
INSERT INTO `cms_vistor_log` VALUES ('1290', 'web', '0', '8r16bd4ocpeebi8ktvktcbljn7', '1', '2017-02-26 13:32:01', '2017-02-26 13:32:01', '2017-02-26');
INSERT INTO `cms_vistor_log` VALUES ('1291', 'web', '0', 'jhgmssk6p1mo5ftfncorm90d97', '1', '2017-03-13 13:44:04', '2017-03-13 13:44:04', '2017-03-13');
INSERT INTO `cms_vistor_log` VALUES ('1292', 'web', '0', 'omq2nhsu0pkbsmfni6s4d0r3k5', '3', '2017-03-21 17:57:33', '2017-03-21 18:03:40', '2017-03-21');
INSERT INTO `cms_vistor_log` VALUES ('1293', 'web', '29', 'k9r8ifhkno1r6234j0rq0jt1l4', '12', '2017-04-02 08:42:47', '2017-04-02 08:45:31', '2017-04-02');
INSERT INTO `cms_vistor_log` VALUES ('1294', 'web', '29', '0kp79iulo24mm4o1j5p5dt9ej3', '2', '2017-04-04 18:07:08', '2017-04-04 18:07:12', '2017-04-04');
