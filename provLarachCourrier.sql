CREATE DATABASE IF NOT EXISTS provlaracheCollect;

USE provlaracheCollect;

SET
  SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
  time_zone = "+00:00";
  

-- Table `districts`
CREATE TABLE
  IF NOT EXISTS `districts` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `name` varchar(50) NOT NULL,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `AALs`
CREATE TABLE
  IF NOT EXISTS `AALs` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `name` varchar(50) NOT NULL,
    `district_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`district_id`) REFERENCES `districts` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `roles`
CREATE TABLE
  IF NOT EXISTS `roles` (
    `id` int NOT NULL AUTO_INCREMENT,
    `nom` varchar(50) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `users`
CREATE TABLE
  IF NOT EXISTS `users` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `aal_id` int,
    `role_id` int,
    PRIMARY KEY (`id`),
    UNIQUE KEY `username` (`username`),
    FOREIGN KEY (`aal_id`) REFERENCES `AALs` (`id`),
    FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `agents`

CREATE TABLE
  IF NOT EXISTS `agents` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `firstname` varchar(50) NOT NULL,
    `lastname` varchar(50) NOT NULL,
    `phone` varchar(50) NOT NULL,
    `aal_id` int,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`aal_id`) REFERENCES `AALs` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

-- Table `Datas`
CREATE TABLE
  IF NOT EXISTS `datas` (
    `id` int NOT NULL AUTO_INCREMENT,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    `list_douar` TEXT NOT NULL,
    `nbr_menage` int NOT NULL,
    `cumul_menage` int,
    `nbr_famille` int NOT NULL,
    `cumul_famille` int,
    `observations` TEXT,
    `agent_id` int NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`agent_id`) REFERENCES `agents` (`id`)
  ) ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

INSERT INTO `districts` (`name`)
VALUES 
('(District) MOULAY ALI BOUGHALEB'),
('(District) District Lamrina'),
('(District) LALLA MENANA'),
('(District) EL MAGHRIB EL JADID'),
('(District) SIDI EL ARBI'),
('(Cercle) LOUKOUS'),
('(Cercle) MOULAY ABDESLAM BEN MACHICH'),
('(Cercle) OUED AL MAKHAZINE');

INSERT INTO `AALs` (`id`, `name`, `district_id`)
VALUES
-- MOULAY ALI BOUGHALEB (district_id = 1)
(1, '(Annexe administrative) PREMIERE', 1),
(2, '(Annexe administrative) DEUXIEME', 1),
(3, '(Annexe administrative) SIXIEME', 1),

-- District Lamrina (district_id = 2)
(4, '(Annexe administrative) TROISIEME', 2),
(5, '(Annexe administrative) QUATRIEME', 2),
(6, '(Annexe administrative) CINQUIEME', 2),

-- LALLA MENANA (district_id = 3)
(7, '(Annexe administrative) PREMIERE', 3),
(8, '(Annexe administrative) DEUXIEME', 3),
(9, '(Annexe administrative) TROISIEME', 3),

-- EL MAGHRIB EL JADID (district_id = 4)
(10, '(Annexe administrative) QUATRIEME', 4),
(11, '(Annexe administrative) CINQUIEME', 4),

-- SIDI EL ARBI (district_id = 5)
(12, '(Annexe administrative) SIXIEME', 5),
(13, '(Annexe administrative) SEPTIEME', 5),

-- LOUKOUS (district_id = 6)
(14, '(Caidat) LAAOUAMRA', 6),
(15, '(Caidat) QOLLA', 6),
(16, '(Caidat) SIDI SLAMA', 6),
(17, '(Caidat) TATOFT', 6),

-- MOULAY ABDESLAM BEN MACHICH (district_id = 7)
(18, '(Caidat) AYACHA', 7),
(19, '(Caidat) BNI AROUSS', 7),
(20, '(Caidat) BNI GERFET', 7),
(21, '(Caidat) TAZROUTE', 7),

-- OUED AL MAKHAZINE (district_id = 8)
(22, '(Caidat) OULAD OUCHIH SOUAKEN', 8),
(23, '(Caidat) RISSANA', 8),
(24, '(Caidat) SAHEL', 8),
(25, '(Caidat) SOUK TOLBA', 8);

INSERT INTO `roles` (`nom`) VALUES ('agent'), ('sg_gouv');

INSERT INTO `users` (`username`, `password`, `aal_id`, `role_id`) 
VALUES ('agent1', '$2a$12$Ti6lncbmo99HPFNgQSnh8O2xu2F9TPJAV1HOk05ImPAMNW2FKDiXK', 14, 1), 
        ('agent2', '$2a$12$Ti6lncbmo99HPFNgQSnh8O2xu2F9TPJAV1HOk05ImPAMNW2FKDiXK', 17, 1), 
        ('sg', '$2a$12$CyOfs02.0Z6mdXTKY6Pthe6as3ax3Ba1ZtYkBObAMK.4Ai/iu3s9a', null, 2),
        ('gouv', '$2a$12$n4n6/mKG.evIPrkEAREj/OyMJwfacvirBGLtiYpbgTsJKqdwikpXm', null, 2);

INSERT INTO `agents` (`firstname`, `lastname`, `phone`, `aal_id`) VALUES
('فضول', 'الرواز', '', 14),
('أحمد', 'سريفت', '', 14),
('محمد', 'حوشة', '', 14),
('العمراني', 'حسون', '', 14),
('محمد', 'اسحيساح', '', 14),
('رضوان', 'الرداد', '', 14),
('عبد العالي', 'طامة', '', 14),
('البوخاري', 'البوخاري', '', 14),
('عبد الواحد', 'بعيوة', '', 14),
('مصطفى', 'السخاسخ', '', 14),
('بوسلهام', 'اللبينة', '', 14),
('امحمد', 'مازار', '', 14),
('المهدي', 'الرامي', '', 14),
('لمياء', 'بليري', '', 14),
('الهادي', 'العيساوي', '', 14),
('بلال', 'دنانة', '', 14),
('بوسلهام', 'الاشهب', '', 14),
('بوسلهام', 'سطة', '', 14),
('محمد', 'حيمد', '', 14),
('رشيد', 'ستيتو', '', 14),
('امبارك', 'المكرحي', '', 14),
('حسن', 'حبيبي', '', 14),
('عبد الله', 'الخنشوشي', '', 14),
('عبد العزيز', 'الحجام', '', 14),
('محمد', 'المخنتر', '', 14),
('سلام', 'قراب', '', 14),
('عبد النبي', 'الغزواني', '', 14),
('دردر', 'الهواري', '', 14),
('محمد', 'اسوييف', '', 14),
('العربي', 'الزهيري', '', 14),
('عبد القادر', 'الريض', '', 14),
('الحبيب', 'البوخاري', '', 14),
('أيوب', 'العلام', '', 14),
('نور الدين', 'الرواز', '', 14),
('محمد', 'الحيلي', '', 14),
('يوسف', 'الجعنين', '', 15),
('محمد', 'المثيوي', '', 15),
('محمد', 'بلصفار', '', 15),
('محمد', 'المرابط', '', 15),
('عبد السلام', 'المريني', '', 15),
('محمد', 'إسماعيل', '', 15),
('محمد', 'حاجي', '', 15),
('عبد السلام', 'بومعزة', '', 15),
('عبد السلام', 'بخات', '', 15),
('مصطفى', 'احميمد', '', 15),
('هدى', 'بنادي', '', 15),
('براهيم', 'عياد', '', 15),
('احمد', 'الكنوني', '', 15),
('محمد', 'الجزولي', '', 15),
('احمد', 'السقال', '', 15),
('عبد السلام', 'المعطي', '', 15),
('عمر', 'بوعزة', '', 15),
('محمد', 'بوعزة', '', 15),
('سعيد', 'الجعنين', '', 15),
('رشيد', 'بوزيد', '', 15),
('محمد', 'مودن', '', 15),
('عبد المالك', 'مودن', '', 15),
('الحسن', 'احمدي', '', 15),
('مصطفى', 'الحضور', '', 15),
('ادريس', 'دودي', '', 15),
('احمد', 'الحضور', '', 15),
('عبد السلام', 'المعطي', '', 15),
('محمد', 'الواث', '', 15),
('محمد', 'بنادي', '', 15),
('عبد الرحمان', 'حاجي', '', 15),
('محمد', 'لمامة', '', 15),
('العياشي', 'المنصوري', '', 15),
('مصطفى', 'الاحمدي', '', 15),
('حسن', 'حاجي', '', 15),
('محمد', 'بنعاشر', '', 15),
('يوسف', 'عتو', '', 15),
('أيوب', 'بنعبيدي', '', 17),
('سليمان', 'سليماني', '', 17),
('أيوب', 'بن احمد', '', 17),
('محمد', 'المنصوري', '', 17),
('عبدالسلام', 'المودن', '', 17),
('العربي', 'عتو', '', 17),
('احمد', 'الغازي', '', 17),
('عبد الرزاق', 'العسري', '', 17),
('عبدالله', 'البردعي', '', 17),
('عبد الخالق', 'الحوزي', '', 17),
('عبد الرحمان', 'اوسدي', '', 17),
('بشير', 'بوكرين', '', 17),
('عبدالسلام', 'الحتيمي', '', 17),
('عبد السلام', 'اليونسي', '', 17),
('عبد العزيز', 'السباعي', '', 17),
('عبد الخالق', 'البكوري', '', 17),
('عبد السلام', 'البوهاني', '', 17),
('علمي', 'البوطي', '', 17),
('عبد اللطيف', 'عوالي', '', 17),
('محمد', 'الطريفي', '', 17),
('العربي', 'السلموني', '', 17),
('العربي', 'الغزاوي', '', 17),
('هشام', 'النتيفي', '', 17),
('عبد الواحد', 'الجغدال', '', 17),
('عبد السلام', 'القرقري', '', 17),
('عبد الباقي', 'الحميدي', '', 17),
('عبد العزيز', 'الحرتوك', '', 17),
('محمد', 'الشلي', '', 17),
('عبد الكبير', 'المجدوبي', '', 17),
('حمزة', 'الحراق', '', 17),
('الحمدوني', 'حمدون', '', 17),
('مصطفى', 'الموخي', '', 17),
('محمد', 'الزفري', '', 17),
('محمد', 'الحمودي', '', 17),
('محمد', 'الساهل', '', 17),
('يوسف', 'العناز', '', 17),
('العربي', 'اليونسي', '', 17),
('محمد', 'الخنفري', '', 17),
('عبد العزيز', 'المريني', '', 17),
('محمد', 'الدامون', '', 17),
('عبد السلام', 'المودن', '', 17),
('عبد العزيز', 'الحراق', '', 17),
('الحسين', 'الزوبير', '', 17),
('المصطفى', 'شهاب', '', 16),
('محمد', 'اليشيوي', '', 16),
('بوسلهام', 'السني', '', 16),
('محمد', 'الشرقاوي', '', 16),
('عبد العالي', 'مولود', '', 16),
('مصطفى', 'بوعجاج', '', 16),
('بوسلهام', 'النكيري', '', 16),
('علال', 'العنكودي', '', 16),
('الحسين', 'العنكودي', '', 16),
('بلال', 'معروف', '', 16),
('السعيد', 'اولاد الحاج', '', 16),
('محمد', 'البركة', '', 16),
('أحمد', 'اليشيوي', '', 16),
('محمد', 'الطاهري', '', 16),
('أحمد', 'بن عقري', '', 16),
('أحمد', 'كورة', '', 16),
('عبد العزيز', 'ارطيل', '', 16),
('عبد العزيز', 'العباسي', '', 16),
('عبد الاله', 'الدميعي', '', 16),
('محمد', 'الرهوني', '', 16),
('حسن', 'حيمود', '', 16),
('يوسف', 'اطريبش', '', 16),
('محمد', 'ازروكي', '', 16),
('محمد', 'اعريوة', '', 16),
('أحمد', 'اسماينة', '', 16),
('عبدالصمد', 'العلام', '', 16),
('سلام', 'المادي', '', 16),
('التهامي', 'بن موح', '', 16),
('امبارك', 'بن موح', '', 16),
('سلام', 'زيزون', '', 16),
('عبدالقادر', 'لمسياح', '', 16),
('العمراني', 'بلخير', '', 16),
('محمد', 'طارزان', '', 16),
('سلام', 'بروك', '', 16),
('محمد', 'ادحيبر', '', 16),
('محمد', 'هرو', '', 16),
('محمد', 'كروية', '', 16),
('عبدالسلام', 'القرافلي', '', 16),
('عبدالله', 'الحارس', '', 16),
('محمد', 'العوادية', '', 16),
('مصطفى', 'بلفقيه', '', 16),
  ('الشايط', 'عبدالله', '', 16),
  ('اسماينة', 'سلام', '', 16),
  ('الشيباني', 'عبدالقادر', '', 16),
  ('النيش', 'محمد', '', 16),
  ('المرضي', 'محمد', '', 16),
  ('قرباش', 'بوسلهام', '', 16),
  ('القوج', 'محمد', '', 16),
  ('الزاهر', 'مراد', '', 16),
  ('الطريف', 'إلياس', '', 16),
  ('رويني', 'رجاء', '', 16),
  ('الشرقاوي', 'علال', '', 16),
  ('عبد العزيز', 'اخريف', '', 19),
  ('مصطفى', 'اخريف', '', 19),
  ('إبراهيم', 'العبادي', '', 19),
  ('عبدالسلام', 'زروق', '', 19),
  ('عبدالسلام', 'الطالبي', '', 19),
  ('عبدالسلام', 'الوهابي', '', 19),
  ('احمد', 'الطالبي', '', 19),
  ('محمد', 'الوهابي', '', 19),
  ('عبدالمغيت', 'الوهابي', '', 19),
  ('المفضل', 'الوهابي', '', 19),
  ('عبدالحميد', 'يخلف', '', 19),
  ('المفضل', 'الوهابي', '', 19),
  ('عبدالسلام', 'الردام', '', 19),
  ('عبدالكريم', 'ابنعيش', '', 19),
  ('محمد', 'العافية', '', 19),
  ('رشيد', 'الحاج بركة', '', 19),
  ('محي الدين', 'اخريف', '', 19),
  ('عبد المجيد', 'الوهابي', '', 19),
  ('عبدالطيف', 'الوهابي', '', 19),
  ('محمد', 'يخلف', '', 19),
  ('محمد', 'العافي', '', 19),
  ('كريم', 'المرابط', '', 19),
  ('بلال', 'زروق', '', 19),
  ('الراضي', 'البقالي', '', 18),
  ('عبدالمنعم', 'الطريباق', '', 18),
  ('محمد', 'الكريسي', '', 18),
  ('الحسين', 'البقالي', '', 18),
  ('هشام', 'مرصو', '', 18),
  ('كريم', 'الوهابي', '', 18),
  ('عبدالاله', 'الزواوي', '', 18),
  ('عبدالواحد', 'بنموسى', '', 18),
  ('صابر', 'الحاجي', '', 18),
  ('لحسن', 'الخراز', '', 18),
  ('احمد', 'ازواوي', '', 18),
  ('مصطفى', 'الستيتو', '', 18),
  ('احمد', 'النعيمي', '', 18),
  ('حسن', 'الزواوي', '', 18),
  ('عماد', 'اعليلش', '', 18),
  ('محمد', 'بنعياد', '', 18),
  ('عبدالمالك', 'الوهابي', '', 18),
  ('محمد', 'الحليمي', '', 18),
  ('هشام', 'اعليلش', '', 18),
  ('العياشي', 'الحراتي', '', 18),
  ('حسن', 'رضوان', '', 18),
  ('عبدالحق', 'الكريسي', '', 18),
  ('محمد', 'الوهابي', '', 18),
  ('عبد السلام', 'بندريس', '', 20),
  ('عبد الحميد', 'دحمان', '', 20),
  ('المصطفى', 'مرصو', '', 20),
  ('علي', 'العزيزي', '', 20),
  ('عبد الهادي', 'بن عبد الجليل', '', 20),
  ('أحمد', 'العيادي', '', 20),
  ('الأمين', 'الرواص', '', 20),
  ('عبد الحق', 'المغربي', '', 20),
  ('عبد السلام', 'الجباري', '', 20),
  ('عبد العزيز', 'العمراني', '', 20),
  ('محمد', 'الحراق', '', 20),
  ('محمد', 'الجميلي', '', 20),
  ('علي', 'كريمص', '', 20),
  ('أحمد', 'الحراق', '', 20),
  ('عبد السلام', 'بن عمران', '', 20),
  ('البشير', 'برماق', '', 20),
  ('امحمد', 'بنوار', '', 20),
  ('محمد', 'الطيبي', '', 20),
  ('محمد', 'العسري', '', 20),
  ('محمد', 'المثيوي', '', 20),
  ('عبد العزيز', 'القميري', '', 20),
  ('محمد', 'القادري', '', 20),
  ('عبد السلام', 'القشتول', '', 20),
  ('عبد السلام', 'القسمي', '', 20),
  ('عبد الحفيظ', 'برعدي الحواث', '', 20),
  ('محمد', 'التقال', '', 20),
  ('عبد السلام', 'الصروخ', '', 20),
  ('محمد', 'جععباق', '', 20),
  ('أحمد', 'الصروخ', '', 20),
  ('عبد السلام', 'العصعاص', '', 20),
  ('السعيد', 'الحراق', '', 20),
  ('محمد', 'اليملاحي', '', 20),
  ('علي', 'العاتق', '', 20),
  ('السعيد', 'أفلاد', '', 20),
  ('عبد الحميد', 'المودن', '', 20),
  ('عبد السلام', 'الصروخ', '', 20),
  ('محمد', 'اليملاحي', '', 20),
  ('خالد', 'العمراني', '', 20),
  ('أحمد', 'الشنتوف', '', 20),
  ('محمد', 'بنوار', '', 20),
  ('محمد', 'حسون', '', 20),
  ('أحمد', 'بنوار', '', 20),
  ('نور الدين', 'الحراق', '', 20),
  ('محمد', 'اغشيشم', '', 20),
  ('عبد السلام', 'الحراق', '', 20),
  ('أحمد', 'شابو', '', 20),
  ('عبد السلام', 'يرماق', '', 20),
  ('محمد', 'يرمق', '', 20),
  ('محمد', 'ألواث', '', 20),
  ('عبد السلام', 'الجباري', '', 20),
  ('الطيب', 'الميموني', '', 20),
  ('الحسين', 'الميموني', '', 20),
  ('عبد الرحيم', 'الحراق', '', 20),
  ('عبد الحميد', 'الشنتوف', '', 20),
  ('أحمد', 'الشنتوف', '', 20),
  ('إبراهيم', 'الجميلي', '', 20),
  ('مروان', 'المودن', '', 20),
  ('اليزيد', 'الطيبي', '', 20),
  ('عبد السلام', 'بن عبد الوهاب ', '', 21),
  ('محسن', 'الوهابي', '', 21),
  ('يحيى', 'الوهابي', '', 21),
  ('عبد الحميد', 'الوهابي', '', 21),
  ('المختار', 'الوهابي', '', 21),
  ('عبد العزيز', 'المودن', '', 21),
  ('محمد', 'شقور', '', 21),
  ('يوسف', 'شقور', '', 21),
  ('لحسن', 'اغبالو', '', 21),
  ('عبد السلام', 'العمراني', '', 21),
  ('محمد', 'الحسيني', '', 21),
  ('أحمد', 'القاطي', '', 21),
  ('محمد', 'القاطي', '', 21),
  ('محمد', 'بنموسى', '', 21),
  ('محمد', 'العمراني', '', 21),
  ('السعيد', 'الخراز', '', 21),
  ('يونس', 'العمراني', '', 21),
  ('رشيد', 'الوهابي', '', 21),
  ('حمزة', 'الخراز', '', 21),
('عبد السلام', 'البغدادي', '', 24),
('عبد السلام', 'اداوود', '', 24),
('فؤاد', 'الخالدي', '', 24),
('سلام', 'البوزيدي', '', 24),
('مصطفى', 'البغدادي', '', 24),
('عبد الاله', 'سلمون', '', 24),
('محمد', 'اليملاحي', '', 24),
('العياشي', 'اليملاحي', '', 24),
('احساين', 'الحراق', '', 24),
('كريم', 'داوود', '', 24),
('عبد السلام', 'الجباري', '', 24),
('محمد', 'المصباحي', '', 24),
('احمد', 'الربيعي', '', 24),
('الطاهر', 'المساري', '', 24),
('عبد الاله', 'المليحي', '', 24),
('الأمين', 'المودن', '', 24),
('سعيد', 'اخزان', '', 24),
('عبد الصمد', 'اماطوش', '', 24),
('عبد السلام', 'يونس', '', 24),
('العياشي', 'التليدي', '', 24),
('نورالدين', 'بوقنطار', '', 24),
('نهيلة', 'امطوش', '', 24),
('محمد', 'جبيلو', '', 24),
('محمد', 'العريبي', '', 22),
('احمد', 'بنزينة', '', 22),
('عبد السلام', 'الجلولي', '', 22),
('عبد القادر', 'العويشي', '', 22),
('ال عمراني', 'الضريصي', '', 22),
('عبدالله', 'الخاديري', '', 22),
('امحمد', 'العويشي', '', 22),
('مصطفى', 'الحسني', '', 22),
('محمد', 'المستاوي', '', 22),
('العربي', 'الجمال', '', 22),
('موسى', 'الكراوي', '', 22),
('ادريس', 'ابيش', '', 22),
('العربي', 'شويشة', '', 22),
('السعيد', 'جبان', '', 22),
('امبارك', 'الطويل', '', 22),
('مصطفى', 'العكال', '', 22),
('المصطفى', 'الفرم', '', 22),
('عبدالسلام', 'الحداد', '', 22),
('الخليل', 'شنشانة', '', 22),
('العربي', 'بوفراشة', '', 22),
('يوسف', 'جدوب', '', 22),
('سعيد', 'الجميلي', '', 22),
('احمد', 'بلة', '', 22),
('محمد', 'الخصال', '', 22),
('عبدالعزيز', 'الروين', '', 22),
('مصطفى', 'الهويني', '', 22),
('محمد', 'بوفراشة', '', 22),
('محمد', 'بنخدة', '', 22),
('احمد', 'القائد', '', 22),
('الحسن', 'عمر', '', 22),
('خليل', 'غيوان', '', 22),
('عبدالسلام', 'شحموط', '', 22),
('محمد', 'رمان', '', 22),
('احمد', 'الخزاعلي', '', 22),
('نور الدين', 'بلقائد', '', 22),
('احمد', 'الفقير', '', 22),
('الشلحي', 'بوسلهام', '', 25),
('المعلم', 'محمد', '', 25),
('الحيرش', 'العربي', '', 25),
('الجاري', 'عبد القادر', '', 25),
('الفقير', 'نورالدين', '', 25),
('الزعني', 'عبد النبي', '', 25),
('حمادة', 'بلال', '', 25),
('بونواظر', 'العربي', '', 25),
('بن الطاهر', 'رشيد', '', 25),
('بخدة', 'مصطفى', '', 25),
('الريطب', 'مصطفى', '', 25),
('الشبوك', 'محمد', '', 25),
('الواهبي', 'محمد', '', 25),
('الجقو', 'حميد', '', 25),
('البرش', 'عبداللطيف', '', 25),
('الطرشي', 'احمد', '', 25),
('السويسي', 'محمد', '', 25),
('الازعر', 'السعيد', '', 25),
('بلفقيه', 'احمد', '', 25),
('الشراكي', 'عبدالله', '', 25),
('الحليمي', 'عبدالرحيم', '', 25),
('مدني', 'مصعب', '', 25),
('العباس', 'مصطفى', '', 25),
('الركادي', 'محمد', '', 25),
('بوليس', 'نورالدين', '', 25),
('بن الشيخ', 'عبدالاله', '', 23),
('بالرايحي', 'الرياحي', '', 23),
('جحير', 'محمد', '', 23),
('الفيطح', 'العربي', '', 23),
('مهير', 'أحمد', '', 23),
('الكاملة', 'العمراني', '', 23),
('عويش', 'الخليل', '', 23),
('البرنوصي', 'أحمد', '', 23),
('المجدوبي', 'عبدالله', '', 23),
('عسو', 'حميد', '', 23),
('العيساوي', 'محمد', '', 23),
('يعكوب', 'عبدالسلام', '', 23),
('الوادكي', 'غيلان', '', 23),
('الكنار', 'عبدالعالي', '', 23),
('الوهراني', 'بنعيسى', '', 23),
('علوية', 'محمد', '', 23),
('الريفي', 'عبدالله', '', 23),
('فريشكال', 'عادل', '', 23),
('باخدة', 'التهامي', '', 23),
('الأشلم', 'العزيز', '', 23),
('الملاحي', 'عبدالسلام', '', 23),
('ابحيباح', 'عبدالعزيز', '', 23),
('كريش', 'ادريس', '', 23),
('الفيل', 'هشام', '', 23),
('السليتي', 'مصطفى', '', 23),
('الخشاني', 'محمد', '', 23),
('الشلخة', 'أحمد', '', 23),
('الصيباري', 'بنعيسى', '', 23),
('باخدة', 'مريم', '', 23),
('الزحتي', 'محمد', '', 23),
('اجمول', 'عمر', '', 23),
('بوطالب', 'محمد', '', 23);