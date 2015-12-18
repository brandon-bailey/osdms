SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `dms_database`
--

-- --------------------------------------------------------

--
-- Table structure for table `dms_access_log`
--

CREATE TABLE IF NOT EXISTS `dms_access_log` (
  `file_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `action` enum('A','B','C','V','D','M','X','I','O','Y','R') CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_admin`
--

CREATE TABLE IF NOT EXISTS `dms_admin` (
  `id` int(11) unsigned DEFAULT NULL,
  `admin` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_admin`
--

INSERT INTO `dms_admin` (`id`, `admin`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dms_category`
--

CREATE TABLE IF NOT EXISTS `dms_category` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT ''
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_category`
--

INSERT INTO `dms_category` (`id`, `name`) VALUES
(1, 'SOP'),
(2, 'Training Manual'),
(3, 'Letters'),
(4, 'Presentation'),
(5, 'Support Document'),
(6, 'Policy');

-- --------------------------------------------------------

--
-- Table structure for table `dms_department`
--

CREATE TABLE IF NOT EXISTS `dms_department` (
`id` int(11) unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `color` varchar(255) CHARACTER SET latin1 NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_department`
--

INSERT INTO `dms_department` (`id`, `name`, `color`) VALUES
(1, 'Security', '#ff8080'),
(2, 'Human Resources', ''),
(3, 'Customer Service', '#74af50'),
(4, 'Finance', '#ff0000'),
(5, 'Marketing', '#0000ff');

-- --------------------------------------------------------

--
-- Table structure for table `dms_dept_perms`
--

CREATE TABLE IF NOT EXISTS `dms_dept_perms` (
  `fid` int(11) unsigned DEFAULT NULL,
  `dept_id` int(11) unsigned DEFAULT NULL,
  `rights` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


-- --------------------------------------------------------

--
-- Table structure for table `dms_dept_reviewer`
--

CREATE TABLE IF NOT EXISTS `dms_dept_reviewer` (
  `dept_id` int(11) unsigned DEFAULT NULL,
  `user_id` int(11) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_dept_reviewer`
--

INSERT INTO `dms_dept_reviewer` (`dept_id`, `user_id`) VALUES
(1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `dms_dmssys`
--

CREATE TABLE IF NOT EXISTS `dms_dmssys` (
`id` int(11) NOT NULL,
  `sys_name` varchar(16) CHARACTER SET latin1 DEFAULT NULL,
  `sys_value` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_dmssys`
--

INSERT INTO `dms_dmssys` (`id`, `sys_name`, `sys_value`) VALUES
(1, 'version', '0.0.1');

-- --------------------------------------------------------

--
-- Table structure for table `dms_documents`
--

CREATE TABLE IF NOT EXISTS `dms_documents` (
`id` int(11) NOT NULL,
  `category` int(11) NOT NULL,
  `owner` int(11) DEFAULT NULL,
  `realname` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'This is the human readable format of the file',
  `created` datetime NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'The description of the file which we will use to allow for searching the database',
  `comment` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` smallint(6) DEFAULT NULL COMMENT 'The status determines whether a document is checked out or not, if it is checked out, the status will be set to the user who checked it out last.',
  `department` smallint(6) DEFAULT NULL,
  `default_rights` tinyint(4) DEFAULT NULL,
  `publishable` tinyint(4) DEFAULT NULL COMMENT 'The publishable status determines whether or not the document has been approved by an administrator or not',
  `reviewer` int(11) DEFAULT NULL,
  `reviewer_comments` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'This is the filename as it is saved in the documents file system',
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'document' COMMENT 'This table maybe utilized with a mass search feature to differentiate the original location of the individual values',
  `modules` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT 'At this time, we are storing an json array of the module ids included in the dynamically created documents'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_log`
--

CREATE TABLE IF NOT EXISTS `dms_log` (
  `id` int(11) unsigned NOT NULL DEFAULT '0',
  `modified_on` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `modified_by` varchar(25) CHARACTER SET latin1 DEFAULT NULL,
  `note` text CHARACTER SET latin1,
  `revision` varchar(255) CHARACTER SET latin1 DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_modules`
--

CREATE TABLE IF NOT EXISTS `dms_modules` (
`id` int(11) NOT NULL,
  `category` varchar(50) CHARACTER SET latin1 NOT NULL,
  `created` datetime NOT NULL,
  `description` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `location` varchar(255) CHARACTER SET latin1 NOT NULL,
  `publishable` tinyint(4) DEFAULT NULL,
  `owner` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_plugins`
--

CREATE TABLE IF NOT EXISTS `dms_plugins` (
`id` int(11) NOT NULL,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `isactive` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_udf`
--

CREATE TABLE IF NOT EXISTS `dms_udf` (
`id` int(11) NOT NULL,
  `table_name` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `display_name` varchar(30) CHARACTER SET latin1 DEFAULT NULL COMMENT 'This is the field that will be displayed to the browser and the "label"',
  `field_type` int(11) DEFAULT NULL COMMENT 'These values correspond to the type of field they will be, the option are 1. Select List 2. Radio Button 3. Text 4. Sub Select List'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dms_user`
--

CREATE TABLE IF NOT EXISTS `dms_user` (
`id` int(11) unsigned NOT NULL,
  `username` varchar(25) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `password` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `department` int(11) unsigned DEFAULT NULL,
  `phone` varchar(20) CHARACTER SET latin1 DEFAULT NULL,
  `email` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `last_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `first_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `pw_reset_code` varchar(50) CHARACTER SET latin1 DEFAULT NULL COMMENT 'This is mainly for first time user creation',
  `can_add` tinyint(1) DEFAULT '1',
  `can_checkin` tinyint(1) DEFAULT '1',
  `date` datetime NOT NULL COMMENT 'This is the original sign up date. should not be changed',
  `avatar` mediumblob NOT NULL COMMENT 'This is a blob of user profile image.',
  `last_pw_reset` datetime NOT NULL COMMENT 'This date field will be reset each time the password is reset'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dms_user`
--

INSERT INTO `dms_user` (`id`, `username`, `password`, `department`, `phone`, `email`, `last_name`, `first_name`, `pw_reset_code`, `can_add`, `can_checkin`, `date`, `avatar`, `last_pw_reset`) VALUES
(1, 'admin', '$2y$10$88eaACo69ZPbtvU91ZCtle9sWog4S.tlXhAGvnxyp57wOWNpcvkca', 7, '5555551212', 'example@test.com', 'User', 'Admin', '', 1, 1, '0000-00-00 00:00:00', 0xffd8ffe000104a46494600010100000100010000fffe003b43524541544f523a2067642d6a7065672076312e3020287573696e6720494a47204a50454720763930292c207175616c697479203d2035300affdb004300100b0c0e0c0a100e0d0e1211101318281a181616183123251d283a333d3c3933383740485c4e404457453738506d51575f626768673e4d71797064785c656763ffdb0043011112121815182f1a1a2f634238426363636363636363636363636363636363636363636363636363636363636363636363636363636363636363636363636363ffc000110800c800cd03012200021101031101ffc4001f0000010501010101010100000000000000000102030405060708090a0bffc400b5100002010303020403050504040000017d01020300041105122131410613516107227114328191a1082342b1c11552d1f02433627282090a161718191a25262728292a3435363738393a434445464748494a535455565758595a636465666768696a737475767778797a838485868788898a92939495969798999aa2a3a4a5a6a7a8a9aab2b3b4b5b6b7b8b9bac2c3c4c5c6c7c8c9cad2d3d4d5d6d7d8d9dae1e2e3e4e5e6e7e8e9eaf1f2f3f4f5f6f7f8f9faffc4001f0100030101010101010101010000000000000102030405060708090a0bffc400b51100020102040403040705040400010277000102031104052131061241510761711322328108144291a1b1c109233352f0156272d10a162434e125f11718191a262728292a35363738393a434445464748494a535455565758595a636465666768696a737475767778797a82838485868788898a92939495969798999aa2a3a4a5a6a7a8a9aab2b3b4b5b6b7b8b9bac2c3c4c5c6c7c8c9cad2d3d4d5d6d7d8d9dae2e3e4e5e6e7e8e9eaf2f3f4f5f6f7f8f9faffda000c03010002110311003f00c774c0c62a12b56a661559eb173d49440c39a00c50d9cd2e29a772c70e9d28c8a407039a6b353b80e3d6948a6034e0450004714f88669848a7c0e3760d3116047c54f121c5351c1a995c0aa248db39a63ae47352bb8cd34b02bc503284d1f27151c6a54d597e4d446a4a278d88a7b3e45431b034f278a77158aee496a74741539a720a8658fa8a4073529e95139a48048c1245695ba818aa90151cd5e8996b58d8ce45e8c803ad3de4c9e0d5167f43511b920e3357cc89b19cce49a693934bb6942d7258a1856936e29fde9db73c55a1909f6151b035659702a361c5004229e3a52628c1a7718114d0486a9429239a411966014124f4029a604d1b62a759288ec6609ba52b12fab1a923b32dcfce57d4ae01fa66aae1cac889c9a4df81d2adfd9a35e3f787fdd19c5412425796ce3b0db8345c3959589cd31b8a7c8e918f9f2bef8c8a606493ee306c7a526316334fcf34c1c5380a4809460f1498db42d2b74a4c06122a3229e452aaf34d218d008e45396539eb4e3c0a8c8ee0531139989e334deb5111b86693eed02b13b2814c22959e9bbab26ac2486e39a7818a053d47145c6c615cd44c3b5583c544dd6a909110193522ae6855153c31976000a63162b6790e11726ae4482dd4a4606efe294f4cfa01de91a758bf748c15463731ec7fa9fe555249dee58243b96219f9b772df8d3b16958b335dc31390acf35c63181dbfc3f9d42167b93bae26651d910d3618a28477f5c2f03ebef4c7bd183b4b63380883afe3fe45301658130a9b8841d89e4d3259228d36094a11f5a6ac9237df0b10ec3258d44f7419f6c70b1038dccb8cd302160bc9258b7a85ff00ebd35830e54edfd0d3d9b3dd40fad46cc10e724fd18d02258e6dff002b603633d6a75e05663cd0ff00755bf03572d265650848ddd79a4d08b894add28148e6a1811371407205239a60c9a69813a9dc29fb78e951a7cbd6a512014ee026ca6320cf5a7bb5465b3402184d2d0ca41a00e6a6c2145481bd6981690f1516024dd51b1cd30be29a5e8b8120e4e075356c3fd9e203ef48c70a07afff005bad55b5cb4a0e33b7a0f7ed56e42130e0fcfcaa9fe6d5a457529223c2fde93944e31dc93dbf1ef4c69d89f2e3009032463007b9f6f6ef51cf3a47b100dd2b72a83b7b9f4a962898a80141c9ce07f11f526a8a192301192ecdcfde60393ec0761f5a6c68e54b8411ae3d72c7ea6ac490aa1f3267decbc903a2fb0a1e2790ab4f905bee42bd147ab5170b1599649182c9210a7a46871f9914302842602afa7ff5bfc6ac4a522523840072ddea05812700a6fda79c7ddfc49345c2c54956266c6e6ddf41cfe5d285460bf21391fdec13534de446711ba8edc0cd44c8991b4ae7ff001ea2e2b112ee2e4b6491e9802a361109339f9bd4e78ab3951feb08247f78d559c6d62432953c006989a3552549630c8d92060e7ad05ab3ac6468dce40dadc12bfa55f039c1eb5125a8836ee34f0829ca2a50840cd080aec0ad30b62a7941c702aa3abd0171c651d29be68a84a9a4da6981a32608a8fa53a5351f3509928901e298f49bb1484e690d11b75a6d485734c208a605eb44db6c241f79989fc0532f662a9b97b2e17da9d6ef8b400e3a9028921f314827a0abe8688a9a7c2259f24e4fde63eb5ade5c8e1846368e84d3f46d3b6ba961c1527f1e07f5ae852c1047b40e2a1b6cd6292dce6e0b321c31cb3e78cff3a560c8ccb12fcdddcf35d23d980b855c678aa72591dc405db18ffc78d4ea5591cef91b9c9237e0f25ba54c6366f955777b91c7e55b1f62cb7dde2acc3621474a2ed872a39b6d399b06424fb0141d39d870b8f526baa1683d29e2d07a53d4343934d35cb6dd8303b91d6a0bed33cb2bf2e71ce3d6bb55b551daa0bbb557423038a7764348e06181c677704923f1e3156df2a54e79c735a17291a4a7e5ef9c552ba189063d2adbba316ac08f5694e4567ae41cd588e4352992cb2403d6a192207a5485b229a092698155e3c1e4534c79ed56dd73480014ae31ac3351b0a909a69acd1044c334d1c53dcf150b37a534343f348c41a883d28357628b11b62255ef93576dc866c1e9c0cd50870cc011d0d5cb7526e02a8ef4dec6913adb185444981d05682ad56b45daaa0fa55b2ca3b8a948b1760a8de256ed4a64c7435199bde98c3c81e94f58c0a6f9c28f387ad1a06a49b052e054067f7a89afa04fbd2a0fc68b858b640ed504e383c66a34d4616fbac0fe34f69e391719e680392d4576ddba8acfb8f99c7b2815abae26dbf040fbcb9acc9971291ec2937a18cc8314f5a760534f150999932376a9578aa8afcd584f9856880908cf4a615c9a7e08148491da9d80ae0d3588a616a42fc56361d8476aaeedcd3ddaa12d9ad120b0669f192cc140cb138151f15734840faa5b03d37e79f619aa292bbb1be3c38d6f6cb30b8595c7df40385fa1ef49616f8be8cfbf4abfa5432049254c9cb72a4f5a9a28546aca50614aeec7a542773a6a53507645cb8730af02b2ee2e65e4f9c107bd6cddc0648b8e4fa573f71617a242cab1863d0bf3b47b0a1dee28dac539e4b8fbeb74f8f50a714cb7d42ec3e05c2c9ea0f5a27d26f9e625ee5997fda722a44d358ca9b5d5b6e036e273f506935e6545dfa1b16972f3a7230d56242c8b9c5269b6be5363a8f7abd730e62207a5093b037a9ccdfdd48f9557da07715971c51cb2659a47f73c0ad7bab1255b0406edbba555934a13c6aa922890679342436f4d0963863b75042103d71c55cb69b730dbdeb3edf47b9b705a39cab13d89db8fa569e9fa74e926f2c9cf5dbd3343567a0b9aeb520d7212d756fb472c303f3a6de6976896c14c845eed2c06786c76c76ad7be8f6cd6ad8cec6fe9546fed5a39619db962e334e4ecb4153a719bb48e631919a6b74a9645d92baf65623f5a8db9a9b1c6c8973baadc07d6ab818353c756985cb3d69a783480e286604d5a623398d318d3d8546d592286354647352535866b44c6340a9ad65f22e6297fb8e1bf5a8c03451703d09e6169681e1fe3395f71da92c0486249ee14798c59437b555f0fc91ea3a5db46ee04b092bcf71dbf4ad79c154da46369e3dc545b5b9d8e4a51f32d46728054535b7983b0fc29b13e05580e3d6a96a66663e9c59b9738a7c5631c5ef57dd862a0f30349b1793d4fb51648abb63e250a453e5e5680318a24e94c452921573822ab49a5863b9491f4abd365177819c751524522b2820d4d8777ba2845a7b83f34848abc917962a62cb8a824931de9d9216acaba8abcb03c711c3b29da7f5aa56f379962c6625bcaf98e7daafefdd38c727071f5aa1abf916365380dba49c6d00741536d6e5c65cb16730c7712c7a939a61a466a617e2a4e2dc7d28256a20f4e2e3146a2b12994e2985ce7ad445a9b934ee31c47151b0a90b546dcd3486308e6940a502940e6980dc52115300314d6514ae05bd0b50fecebcdcffea9c61bdbd0d7556f7b15ce1d6753db1bab88db4aa3632b0fe120fe54d9719b8ab1e85bf6d28b8f7a8a56ddc8e879a85c1d991537b1d087cf784b08d3963fa53f73c10978fe67c743dea9c08100790fcce6b41648b6e0c8bf9d35a8dbec648d6aec3106264c1efd2992eb3718dcb93ec2b4654864c80ca49a816cd101ddb403eb459949aec4565ab4b74fe5946c9ea4f6abde6f9520cf1e945bdb468329b7f0a4b98f72943de86b4136ae59fb46475aaf2dc67806aac25c2957eaa719a523e6a9b86885964545dcee14fd6b1753ba374c8377ca831f5352eacd9bb55feea0aa447155639e72be8549148aaec4e6af3006a1299ed4d1162a8739a7824d486119e9408e931342014ec0a5da451823b545c92b96a51cd371cd38569718ec528a4cd00f3480900cd38a0c5354d3b9ef5203368a08e314e3c1a3b53133aeb19bceb281fb9419faf4ab414118358da0c8c6c8e79092103db3cd6d273834ce98bba4cab7d61f6b89d158a3118561dab0f4cb29619cda5fbca1b2424a0e41f415d6a8a8ae61de37281bb1d0f7a691a465e6652690ce108ba241cee23d47a531b4aba5f309b9385fbbef56bcc11b61a26423fba6a39ae636e024ae4f6278a564742536f733aee19ecd4b1ba2485070bd49f4a7694ba95c1f36ea4db1ff0002773f5abd05a995b7488157d3b9ad00800e060516339bb697b91150a327a9eb5131e73524c4e71546ee71144cde838fad498dccbbe9bcebc91b3c03b47e15017229b9ee7ad3589238a77399b11a419a5421ba54453279a55f9698d3262b4ddb485cfad37cc39a437625d949b6857cf5a76e1eb53a0b4281c526690b52673576210fcd140141e3a5003d4e2a40d9a801a7ab00286863fad1834039a5cd224e83c329bed2e90ff7d7f956a44fb5b6b704567785398aebfde5fe46b4aee223e75ea3ad33a23f0a2e44430a91a3cf4acb86eb63735a11dca9ef5487b0c92d19fb8a8c58e3b8fcaad34e31c114d138ef4ec8ae6646b6e41e692501169ef728a0e48acdbabd566217a0a4ec84db624d2639aced5136d92337567fd306adc2ad3c809e951788004b5817b6e3fcaa052f84c238a696cf4a46714cdc28b180fc527434df3290b66985c18fa53439a4269a4d3b0324125383d572d8a3cc153ca490ee269c0d4629eb5a3289d4f1431a68e941a924693cd394d328069944e1a90bd45be90b1da4fa0a146ec477de1fb116ba341363f7973fbc63edd87e557641b948ab51c61349b303a2c6a3f4150b0a725666d0d62654f6f8276f1549de588e46456cc899cd529e3c1e99150cd1140dfcc0fdefce83a94a460914b35aa3f38aae6da343d32695cab0ff003e594fde27dea68a167ebd28822f6c0abb1a8f4c0a4264d6d10418fe7516af626f74e99909f36dc798a3d477156a31c7f4abd651e63b82470632bf9d691577622a7c2cf332f9a4dd51b1e7f1a01a1c5a7639ef724dd4d66c525318d090c5f332694366a1342be0f35404d4d2bcf1406a50681910a950514526492f6a639a28a9111134668a2a8628e686fba47a8a28ada92ea4c8f58d25d6eb45b52df76485738ec7150ca8f149b241cf66ecd4514aa2ea6949eb623619155a54a28ac0e845396227a0a88418e4d1454d8b4c9a38b8e98156234c628a2988b08bf3000649e80569b28b7b275ee14b31f7c51456d4918567d0f2256cfe34b9c1a28ad2a256b984437521a28ac4d06114d228a29885048a78345140cfffd9, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `dms_user_perms`
--

CREATE TABLE IF NOT EXISTS `dms_user_perms` (
  `fid` int(11) unsigned DEFAULT NULL,
  `uid` int(11) unsigned NOT NULL DEFAULT '0',
  `rights` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dms_category`
--
ALTER TABLE `dms_category`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dms_department`
--
ALTER TABLE `dms_department`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dms_dept_perms`
--
ALTER TABLE `dms_dept_perms`
 ADD KEY `rights` (`rights`), ADD KEY `dept_id` (`dept_id`), ADD KEY `fid` (`fid`);

--
-- Indexes for table `dms_dmssys`
--
ALTER TABLE `dms_dmssys`
 ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `dms_documents`
--
ALTER TABLE `dms_documents`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dms_log`
--
ALTER TABLE `dms_log`
 ADD KEY `id` (`id`), ADD KEY `modified_on` (`modified_on`);

--
-- Indexes for table `dms_modules`
--
ALTER TABLE `dms_modules`
 ADD PRIMARY KEY (`id`), ADD FULLTEXT KEY `description` (`description`);

--
-- Indexes for table `dms_plugins`
--
ALTER TABLE `dms_plugins`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dms_udf`
--
ALTER TABLE `dms_udf`
 ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `dms_user`
--
ALTER TABLE `dms_user`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `dms_user_perms`
--
ALTER TABLE `dms_user_perms`
 ADD KEY `user_perms_idx` (`fid`,`uid`,`rights`), ADD KEY `fid` (`fid`), ADD KEY `uid` (`uid`), ADD KEY `rights` (`rights`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dms_category`
--
ALTER TABLE `dms_category`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `dms_department`
--
ALTER TABLE `dms_department`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `dms_dmssys`
--
ALTER TABLE `dms_dmssys`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `dms_documents`
--
ALTER TABLE `dms_documents`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dms_modules`
--
ALTER TABLE `dms_modules`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `dms_plugins`
--
ALTER TABLE `dms_plugins`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `dms_udf`
--

ALTER TABLE `dms_udf`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `dms_user`
--
ALTER TABLE `dms_user`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
