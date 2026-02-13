

CREATE TABLE `rpos_admin` (
  `admin_id` varchar(200) NOT NULL,
  `admin_name` varchar(200) NOT NULL,
  `admin_email` varchar(200) NOT NULL,
  `admin_password` varchar(200) NOT NULL,
  `attempt` int(11) NOT NULL,
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_admin VALUES("10e0b6dc958adfb5b094d8935a13aeadbe783c25","Edjay","admin@mail.com","10470c3b4b1fed12c3baac014be15fac67c6e815","0");



CREATE TABLE `rpos_customers` (
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `customer_phoneno` varchar(200) NOT NULL,
  `customer_email` varchar(200) NOT NULL,
  `customer_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_customers VALUES("2cd30a45621e","Vilser Catabijan","12891011","pogi@mail.com","10470c3b4b1fed12c3baac014be15fac67c6e815","2024-04-29 08:23:31.332192");
INSERT INTO rpos_customers VALUES("4ebafa1c6b0f","Tetchie","1234567891","Tetchie@mial.com","10470c3b4b1fed12c3baac014be15fac67c6e815","2024-04-28 15:33:47.936674");
INSERT INTO rpos_customers VALUES("d0ba61555aee","Dako ulo","4125556587","Dako_ulo@mail.com","10470c3b4b1fed12c3baac014be15fac67c6e815","2024-04-28 15:19:04.294377");
INSERT INTO rpos_customers VALUES("d7c2db8f6cbf","Jayrom","1458887896","Jayrom@mail.com","10470c3b4b1fed12c3baac014be15fac67c6e815","2024-04-28 15:18:37.677667");



CREATE TABLE `rpos_orders` (
  `order_id` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `customer_name` varchar(200) NOT NULL,
  `prod_id` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `prod_qty` varchar(200) NOT NULL,
  `order_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`order_id`),
  KEY `CustomerOrder` (`customer_id`),
  KEY `ProductOrder` (`prod_id`),
  CONSTRAINT `CustomerOrder` FOREIGN KEY (`customer_id`) REFERENCES `rpos_customers` (`customer_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `ProductOrder` FOREIGN KEY (`prod_id`) REFERENCES `rpos_products` (`prod_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_orders VALUES("25f1c03a46","PLKM-4608","4ebafa1c6b0f","Tetchie","2b976e49a0","Cheeseburger","3","2","Paid","2024-04-28 15:35:17.492481");
INSERT INTO rpos_orders VALUES("2d441287a9","NXHK-2819","d7c2db8f6cbf","Jayrom","f4ce3927bf","Hot Dog","25","4","Paid","2024-05-06 09:39:08.350269");
INSERT INTO rpos_orders VALUES("4613969216","GRVA-7908","d7c2db8f6cbf","Jayrom","f9c2770a32","Whipped Milk Shake","75","2","Paid","2024-05-16 16:10:48.498334");
INSERT INTO rpos_orders VALUES("4887031811","PWUB-9473","d7c2db8f6cbf","Jayrom","ec18c5a4f0","Corn Dogs","4","2","Paid","2024-04-28 15:23:45.432817");
INSERT INTO rpos_orders VALUES("bf9415221d","BHYP-3964","d7c2db8f6cbf","Jayrom","f4ce3927bf","Hot Dog","4","50","Paid","2024-04-28 15:32:53.805442");



CREATE TABLE `rpos_pass_resets` (
  `reset_id` int(20) NOT NULL AUTO_INCREMENT,
  `reset_code` varchar(200) NOT NULL,
  `reset_token` varchar(200) NOT NULL,
  `reset_email` varchar(200) NOT NULL,
  `reset_status` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`reset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_pass_resets VALUES("1","63KU9QDGSO","4ac4cee0a94e82a2aedc311617aa437e218bdf68","sysadmin@icofee.org","Pending","2020-08-17 23:20:14.318643");



CREATE TABLE `rpos_payments` (
  `pay_id` varchar(200) NOT NULL,
  `pay_code` varchar(200) NOT NULL,
  `order_code` varchar(200) NOT NULL,
  `customer_id` varchar(200) NOT NULL,
  `pay_amt` varchar(200) NOT NULL,
  `pay_method` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`pay_id`),
  KEY `order` (`order_code`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_payments VALUES("0aa5b1","GNUAZW6CPH","PWUB-9473","d7c2db8f6cbf","8","Cash","2024-04-28 15:23:45.428030");
INSERT INTO rpos_payments VALUES("0bf592","9UMWLG4BF8","EJKA-4501","35135b319ce3","8","Cash","2022-09-05 00:31:54.525284");
INSERT INTO rpos_payments VALUES("4423d7","QWERT0YUZ1","JFMB-0731","35135b319ce3","11","Cash","2022-09-05 00:37:03.655834");
INSERT INTO rpos_payments VALUES("442865","146XLFSC9V","INHG-0875","9c7fcc067bda","10","Paypal","2022-09-05 00:35:22.470600");
INSERT INTO rpos_payments VALUES("65891b","MF2TVJA1PY","ZPXD-6951","e711dcc579d9","16","Cash","2022-09-03 21:12:46.959558");
INSERT INTO rpos_payments VALUES("65b428","1458887896","NXHK-2819","d7c2db8f6cbf","100","Cash","2024-05-06 09:39:08.345104");
INSERT INTO rpos_payments VALUES("75ae21","1QIKVO69SA","IUSP-9453","fe6bb69bdd29","10","Cash","2022-09-03 19:50:40.496625");
INSERT INTO rpos_payments VALUES("7e1989","KLTF3YZHJP","QOEH-8613","29c759d624f9","9","Cash","2022-09-03 20:02:32.926529");
INSERT INTO rpos_payments VALUES("968488","5E31DQ2NCG","COXP-6018","7c8f2100d552","22","Cash","2022-09-03 20:17:44.639979");
INSERT INTO rpos_payments VALUES("96e0b4","1458887896","ALCE-6950","d7c2db8f6cbf","6","Cash","2024-04-28 15:25:56.114065");
INSERT INTO rpos_payments VALUES("984539","LSBNK1WRFU","FNAB-9142","35135b319ce3","18","Paypal","2022-09-05 00:32:14.852482");
INSERT INTO rpos_payments VALUES("9fcee7","AZSUNOKEI7","OTEV-8532","3859d26cd9a5","15","Cash","2022-09-03 21:13:38.855058");
INSERT INTO rpos_payments VALUES("ab046d","1458887896","GRVA-7908","d7c2db8f6cbf","150","Cash","2024-05-16 16:10:48.494184");
INSERT INTO rpos_payments VALUES("b0bb08","1KWP4J7REX","PLKM-4608","4ebafa1c6b0f","6","Cash","2024-04-28 15:35:17.487926");
INSERT INTO rpos_payments VALUES("b1a972","1458887896","KJAR-6183","d7c2db8f6cbf","16","Cash","2024-04-29 23:17:37.022832");
INSERT INTO rpos_payments VALUES("c5f5ad","1458887896","BHYP-3964","d7c2db8f6cbf","200","Cash","2024-04-28 15:32:53.792660");
INSERT INTO rpos_payments VALUES("c81d2e","WERGFCXZSR","AEHM-0653","06549ea58afd","8","Cash","2022-09-03 21:26:00.331494");
INSERT INTO rpos_payments VALUES("e46e29","QMCGSNER3T","ONSY-2465","57b7541814ed","12","Cash","2022-09-03 16:35:50.172062");



CREATE TABLE `rpos_products` (
  `prod_id` varchar(200) NOT NULL,
  `prod_code` varchar(200) NOT NULL,
  `prod_name` varchar(200) NOT NULL,
  `prod_img` varchar(200) NOT NULL,
  `prod_desc` longtext NOT NULL,
  `prod_price` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_products VALUES("2b976e49a0","CEWV-9438","Cheeseburger","cheeseburgers.jpg","BUY 1 TAKE 1","78","2024-05-06 09:36:06.086249");
INSERT INTO rpos_products VALUES("31dfcc94cf","SYQP-3710","Buffalo Wings","buffalo_wings.jpg","A Buffalo wing in American cuisine is an unbreaded chicken wing section that is generally deep-fried and then coated or dipped in a sauce consisting of a vinegar-based cayenne pepper hot sauce and melted butter prior to serving.","220","2024-05-06 09:35:22.073774");
INSERT INTO rpos_products VALUES("4e68e0dd49","QLKW-0914","Caramel Macchiato","iStock-856503922-2-320x320.jpg","Steamed milk, espresso and caramel; what could be more enticing? This blissful flavor is a favorite of coffee lovers due to its deliciously bold taste of creamy caramel and strong coffee flavor. These","45","2024-05-06 09:32:28.239354");
INSERT INTO rpos_products VALUES("a419f2ef1c","EPNX-3728","Chicken Nugget","chicnuggets.jpeg","A chicken nugget is a food product consisting of a small piece of deboned chicken meat that is breaded or battered, then deep-fried or baked. Invented in the 1950s, chicken nuggets have become a very popular fast food restaurant item, as well as widely sold frozen for home use","120","2024-05-06 09:33:57.123279");
INSERT INTO rpos_products VALUES("e2af35d095","IDLC-7819","Pepperoni Pizza","peperopizza.jpg","Pepperoni is an American variety of spicy salami made from cured pork and beef seasoned with paprika or other chili pepper. Prior to cooking, pepperoni is characteristically soft, slightly smoky, and bright red. Thinly sliced pepperoni is one of the most popular pizza toppings in American pizzerias.","135","2024-05-06 09:33:25.512404");
INSERT INTO rpos_products VALUES("ec18c5a4f0","PQFV-7049","Corn Dogs","corndog.jpg","A corn dog is a sausage on a stick that has been coated in a thick layer of cornmeal batter and deep fried. It originated in the United States and is commonly found in American cuisine","10","2024-05-06 09:32:53.802835");
INSERT INTO rpos_products VALUES("f4ce3927bf","EAHD-1980","Hot Dog","hotdog0.jpg","A hot dog is a food consisting of a grilled or steamed sausage served in the slit of a partially sliced bun. The term hot dog can also refer to the sausage itself. The sausage used is a wiener or a frankfurter. The names of these sausages also commonly refer to their assembled dish.","25","2024-05-06 09:34:21.302751");
INSERT INTO rpos_products VALUES("f9c2770a32","YXLA-2603","Whipped Milk Shake","milkshake.jpeg","Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,","75","2024-05-06 09:36:39.881982");



CREATE TABLE `rpos_staff` (
  `staff_id` int(20) NOT NULL AUTO_INCREMENT,
  `staff_name` varchar(200) NOT NULL,
  `staff_number` varchar(200) NOT NULL,
  `staff_email` varchar(200) NOT NULL,
  `staff_password` varchar(200) NOT NULL,
  `created_at` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6),
  PRIMARY KEY (`staff_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

INSERT INTO rpos_staff VALUES("2","Tetchie","QEUY-9042","Tetchie1@mial.com","123456","2024-04-28 15:37:54.206287");
INSERT INTO rpos_staff VALUES("3","AKO EH LANGAN","ZOPN-8941","ako@mail.com","10470c3b4b1fed12c3baac014be15fac67c6e815","2024-04-29 22:53:06.687090");

