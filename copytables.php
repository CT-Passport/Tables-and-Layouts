<?php
$servername = "localhost";
$username = "root";
$password = "";

dropTables($servername, $username, $password);
//copyTables($servername, $username, $password);

function copyTables($servername, $username, $password)

{
    $conn = new mysqli($servername, $username, $password);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query='CREATE TABLE `lwsp-ct`.`h82im_customtables_categories` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `categoryname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int UNSIGNED NOT NULL DEFAULT "0",
  `modified_by` int UNSIGNED NOT NULL DEFAULT "0",
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `checked_out` int UNSIGNED NOT NULL DEFAULT "0",
  `checked_out_time` datetime DEFAULT NULL,
  `asset_id` int UNSIGNED NOT NULL DEFAULT "0",
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `version` int UNSIGNED NOT NULL DEFAULT "1",
  `hits` int UNSIGNED NOT NULL DEFAULT "0",
  `ordering` int NOT NULL DEFAULT "0"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_categories` ADD PRIMARY KEY (`id`), ADD KEY `idx_published` (`published`), ADD KEY `idx_categoryname` (`categoryname`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_categories` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_categories`(`id`, `published`, `categoryname`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `asset_id`, `params`, `version`, `hits`, `ordering`) SELECT `id`, `published`, `categoryname`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `asset_id`, `params`, `version`, `hits`, `ordering` FROM `lwsp`.`h82im_customtables_categories`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_fields` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `tableid` int UNSIGNED NOT NULL,
  `fieldname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fieldtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `allowordering` tinyint NOT NULL DEFAULT "1",
  `isrequired` tinyint NOT NULL DEFAULT "1",
  `isdisabled` tinyint NOT NULL DEFAULT "0",
  `alwaysupdatevalue` tinyint NOT NULL DEFAULT "0",
  `parentid` int UNSIGNED DEFAULT NULL,
  `ordering` int DEFAULT NULL,
  `defaultvalue` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customfieldname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `typeparams` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valuerule` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `valuerulecaption` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_by` int UNSIGNED NOT NULL DEFAULT "0",
  `modified_by` int UNSIGNED NOT NULL DEFAULT "0",
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `checked_out` int UNSIGNED NOT NULL DEFAULT "0",
  `checked_out_time` datetime DEFAULT NULL,
  `fieldtitle_es` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fieldtitle_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_sk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fieldtitle_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_es` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fieldtitle_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_de` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fieldtitle_delu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_delu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fieldtitle_sl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_sl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asset_id` int UNSIGNED NOT NULL DEFAULT "0",
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `version` int UNSIGNED NOT NULL DEFAULT "1",
  `hits` int UNSIGNED NOT NULL DEFAULT "0",
  `phponadd` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `phponchange` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `fieldtitle_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fieldtitle_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `fieldtitle_vi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_zh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_vi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_fields` ADD PRIMARY KEY (`id`), ADD KEY `idx_published` (`published`), ADD KEY `idx_tableid` (`tableid`), ADD KEY `idx_fieldname` (`fieldname`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_fields` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1047 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_fields`(`id`, `published`, `tableid`, `fieldname`, `fieldtitle`, `description`, `allowordering`, `isrequired`, `isdisabled`, `alwaysupdatevalue`, `parentid`, `ordering`, `defaultvalue`, `customfieldname`, `type`, `typeparams`, `valuerule`, `valuerulecaption`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `fieldtitle_es`, `fieldtitle_sk`, `description_sk`, `fieldtitle_ru`, `description_ru`, `description_es`, `fieldtitle_de`, `description_de`, `fieldtitle_delu`, `description_delu`, `fieldtitle_sl`, `description_sl`, `asset_id`, `params`, `version`, `hits`, `phponadd`, `phponchange`, `fieldtitle_zh`, `fieldtitle_ar`, `fieldtitle_vi`, `description_zh`, `description_ar`, `description_vi`) SELECT `id`, `published`, `tableid`, `fieldname`, `fieldtitle`, `description`, `allowordering`, `isrequired`, `isdisabled`, `alwaysupdatevalue`, `parentid`, `ordering`, `defaultvalue`, `customfieldname`, `type`, `typeparams`, `valuerule`, `valuerulecaption`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `fieldtitle_es`, `fieldtitle_sk`, `description_sk`, `fieldtitle_ru`, `description_ru`, `description_es`, `fieldtitle_de`, `description_de`, `fieldtitle_delu`, `description_delu`, `fieldtitle_sl`, `description_sl`, `asset_id`, `params`, `version`, `hits`, `phponadd`, `phponchange`, `fieldtitle_zh`, `fieldtitle_ar`, `fieldtitle_vi`, `description_zh`, `description_ar`, `description_vi` FROM `lwsp`.`h82im_customtables_fields`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_compcontracts` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_compcontracts` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_compcontracts` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_companies_compcontracts`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_companies_compcontracts`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_documents` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_documents` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_documents` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_companies_documents`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_companies_documents`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_shared` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_shared` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_companies_shared` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_companies_shared`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_companies_shared`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_contracts_files` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_contracts_files` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_contracts_files` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_contracts_files`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_contracts_files`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_files` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_files` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_files` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_files`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migmvdlois_files`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_folderlink` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_folderlink` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_folderlink` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migmvdlois_folderlink`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migmvdlois_folderlink`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocs` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocs` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocs` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocs`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocs`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migprojectcases_files` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migprojectcases_files` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migprojectcases_files` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migprojectcases_files`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migprojectcases_files`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_migrelministryenqletters_docs` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migrelministryenqletters_docs` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_migrelministryenqletters_docs` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_migrelministryenqletters_docs`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_migrelministryenqletters_docs`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_filebox_people_documents` (
`fileid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `file_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_people_documents` ADD PRIMARY KEY (`fileid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_filebox_people_documents` MODIFY `fileid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_filebox_people_documents`(`fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `fileid`, `listingid`, `ordering`, `file_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_filebox_people_documents`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_gallery_workhours_images` (
`photoid` bigint NOT NULL,
  `listingid` bigint NOT NULL,
  `ordering` int NOT NULL,
  `photo_ext` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_gallery_workhours_images` ADD PRIMARY KEY (`photoid`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_gallery_workhours_images` MODIFY `photoid` bigint NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_gallery_workhours_images`(`photoid`, `listingid`, `ordering`, `photo_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `photoid`, `listingid`, `ordering`, `photo_ext`, `title`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_gallery_workhours_images`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_layouts` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `tableid` int UNSIGNED NOT NULL,
  `layoutname` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `layouttype` int UNSIGNED NOT NULL DEFAULT "0",
  `layoutcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `layoutmobile` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `layoutcss` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `layoutjs` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `changetimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` int UNSIGNED NOT NULL DEFAULT "0",
  `modified_by` int UNSIGNED NOT NULL DEFAULT "0",
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `checked_out` int UNSIGNED NOT NULL DEFAULT "0",
  `checked_out_time` datetime DEFAULT NULL,
  `asset_id` int UNSIGNED NOT NULL DEFAULT "0",
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `version` int UNSIGNED NOT NULL DEFAULT "1",
  `hits` int UNSIGNED NOT NULL DEFAULT "0",
  `ordering` int NOT NULL DEFAULT "0"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_layouts` ADD PRIMARY KEY (`id`), ADD KEY `idx_published` (`published`), ADD KEY `idx_tableid` (`tableid`), ADD KEY `idx_layoutname` (`layoutname`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_layouts` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_layouts`(`id`, `published`, `tableid`, `layoutname`, `layouttype`, `layoutcode`, `layoutmobile`, `layoutcss`, `layoutjs`, `changetimestamp`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `asset_id`, `params`, `version`, `hits`, `ordering`) SELECT `id`, `published`, `tableid`, `layoutname`, `layouttype`, `layoutcode`, `layoutmobile`, `layoutcss`, `layoutjs`, `changetimestamp`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `asset_id`, `params`, `version`, `hits`, `ordering` FROM `lwsp`.`h82im_customtables_layouts`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_log` (
`id` int UNSIGNED NOT NULL,
  `userid` int UNSIGNED NOT NULL DEFAULT "0",
  `datetime` datetime DEFAULT NULL,
  `tableid` int UNSIGNED NOT NULL DEFAULT "0",
  `action` smallint UNSIGNED NOT NULL DEFAULT "0",
  `listingid` int UNSIGNED NOT NULL DEFAULT "0",
  `Itemid` int UNSIGNED NOT NULL DEFAULT "0"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_log` ADD PRIMARY KEY (`id`), ADD KEY `idx_userid` (`userid`), ADD KEY `idx_action` (`action`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_log` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2305 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_log`(`id`, `userid`, `datetime`, `tableid`, `action`, `listingid`, `Itemid`) SELECT `id`, `userid`, `datetime`, `tableid`, `action`, `listingid`, `Itemid` FROM `lwsp`.`h82im_customtables_log`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_options` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `optionname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` bigint DEFAULT NULL,
  `imageparams` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ordering` int UNSIGNED NOT NULL DEFAULT "0",
  `parentid` int UNSIGNED DEFAULT NULL,
  `sublevel` int DEFAULT NULL,
  `isselectable` tinyint NOT NULL DEFAULT "1",
  `optionalcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `familytree` varchar(1024) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `familytreestr` varchar(1024) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `title_ru` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_zh` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_ar` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_vi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_options` ADD PRIMARY KEY (`id`), ADD KEY `idx_published` (`published`), ADD KEY `idx_optionname` (`optionname`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_options` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_options`(`id`, `published`, `optionname`, `title`, `image`, `imageparams`, `ordering`, `parentid`, `sublevel`, `isselectable`, `optionalcode`, `link`, `familytree`, `familytreestr`, `title_ru`, `title_zh`, `title_ar`, `title_vi`) SELECT `id`, `published`, `optionname`, `title`, `image`, `imageparams`, `ordering`, `parentid`, `sublevel`, `isselectable`, `optionalcode`, `link`, `familytree`, `familytreestr`, `title_ru`, `title_zh`, `title_ar`, `title_vi` FROM `lwsp`.`h82im_customtables_options`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_tables` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `tablename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabletitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tablecategory` int DEFAULT NULL,
  `customphp` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customtablename` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customidfield` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allowimportcontent` tinyint NOT NULL DEFAULT "0",
  `created_by` int UNSIGNED NOT NULL DEFAULT "0",
  `modified_by` int UNSIGNED NOT NULL DEFAULT "0",
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `checked_out` int UNSIGNED NOT NULL DEFAULT "0",
  `checked_out_time` datetime DEFAULT NULL,
  `tabletitle_es` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_es` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tabletitle_sk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_sk` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tabletitle_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_ru` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tabletitle_de` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_de` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tabletitle_delu` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_delu` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `tabletitle_sl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_sl` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `asset_id` int UNSIGNED NOT NULL DEFAULT "0",
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `version` int UNSIGNED NOT NULL DEFAULT "1",
  `hits` int UNSIGNED NOT NULL DEFAULT "0",
  `ordering` int NOT NULL DEFAULT "0",
  `tabletitle_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabletitle_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tabletitle_vi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description_zh` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_ar` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `description_vi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_customtables_tables` ADD PRIMARY KEY (`id`), ADD KEY `idx_published` (`published`), ADD KEY `idx_tablename` (`tablename`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_tables` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_tables`(`id`, `published`, `tablename`, `tabletitle`, `description`, `tablecategory`, `customphp`, `customtablename`, `customidfield`, `allowimportcontent`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `tabletitle_es`, `description_es`, `tabletitle_sk`, `description_sk`, `tabletitle_ru`, `description_ru`, `tabletitle_de`, `description_de`, `tabletitle_delu`, `description_delu`, `tabletitle_sl`, `description_sl`, `asset_id`, `params`, `version`, `hits`, `ordering`, `tabletitle_zh`, `tabletitle_ar`, `tabletitle_vi`, `description_zh`, `description_ar`, `description_vi`) SELECT `id`, `published`, `tablename`, `tabletitle`, `description`, `tablecategory`, `customphp`, `customtablename`, `customidfield`, `allowimportcontent`, `created_by`, `modified_by`, `created`, `modified`, `checked_out`, `checked_out_time`, `tabletitle_es`, `description_es`, `tabletitle_sk`, `description_sk`, `tabletitle_ru`, `description_ru`, `tabletitle_de`, `description_de`, `tabletitle_delu`, `description_delu`, `tabletitle_sl`, `description_sl`, `asset_id`, `params`, `version`, `hits`, `ordering`, `tabletitle_zh`, `tabletitle_ar`, `tabletitle_vi`, `description_zh`, `description_ar`, `description_vi` FROM `lwsp`.`h82im_customtables_tables`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_applications` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Full Name",
  `es_document` int UNSIGNED DEFAULT NULL COMMENT "Document",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_company` int UNSIGNED DEFAULT NULL COMMENT "Company",
  `es_invitingcompany` int UNSIGNED DEFAULT NULL COMMENT "Inviting Company",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_persontype` int UNSIGNED DEFAULT NULL,
  `es_worker` int UNSIGNED DEFAULT NULL COMMENT "Worker",
  `es_visa` int UNSIGNED DEFAULT NULL COMMENT "Visa",
  `es_appdate` datetime DEFAULT NULL COMMENT "Application Date",
  `es_quarter` int DEFAULT NULL COMMENT "Quarter",
  `es_refn` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Applications";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_applications` ADD PRIMARY KEY (`id`), ADD KEY `es_document` (`es_document`), ADD KEY `es_person` (`es_person`), ADD KEY `es_company` (`es_company`), ADD KEY `es_invitingcompany` (`es_invitingcompany`), ADD KEY `es_worker` (`es_worker`), ADD KEY `es_visa` (`es_visa`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_applications` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_applications`(`id`, `published`, `es_fullname`, `es_document`, `es_person`, `es_company`, `es_invitingcompany`, `es_comment`, `es_persontype`, `es_worker`, `es_visa`, `es_appdate`, `es_quarter`, `es_refn`) SELECT `id`, `published`, `es_fullname`, `es_document`, `es_person`, `es_company`, `es_invitingcompany`, `es_comment`, `es_persontype`, `es_worker`, `es_visa`, `es_appdate`, `es_quarter`, `es_refn` FROM `lwsp`.`h82im_customtables_table_applications`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_capitalstatus` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Сapital Status";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_capitalstatus` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_capitalstatus` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_capitalstatus`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_capitalstatus`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_citizenshiptypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Citizenship Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_citizenshiptypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_citizenshiptypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_citizenshiptypes`(`id`, `published`, `es_name`, `es_comment`) SELECT `id`, `published`, `es_name`, `es_comment` FROM `lwsp`.`h82im_customtables_table_citizenshiptypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_companies` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_address` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Email",
  `es_contactperson` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Contact Person",
  `es_contactpersonposition` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Contact Person Position",
  `es_fullnamerus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_fullnamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "fullname_lat",
  `es_fullnamenative` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Fullname Native",
  `es_shortnamerus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Short name Rus",
  `es_shortnamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Short name lat",
  `es_shortnamenative` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Shortname native",
  `es_regnumber` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_taxnumber` varchar(12) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Tax Number",
  `es_taxreasoncode` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Tax Reason code",
  `es_estdate` date DEFAULT NULL COMMENT "Establishment Day",
  `es_activitycodes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Activity Codes",
  `es_statisticscodes` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Statistics Codes",
  `es_addressrus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address Rus",
  `es_addresslat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address Lat",
  `es_baccaccnumb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc1_accnumb",
  `es_bacc1accnumb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc1currency` int UNSIGNED DEFAULT NULL COMMENT "bacc1_currency",
  `es_bacc1bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc1corracc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc1_corracc",
  `es_bacc1bank_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc1swift` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc1_swift",
  `es_bacc1corrbank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc1_corrbank",
  `es_bacc1misc` text COLLATE utf8mb4_unicode_ci,
  `es_bacc2accnumb` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc2_accnumb",
  `es_bacc2bank` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc2bank_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc2corracc` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc2_corracc",
  `es_bacc2corrbank` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc2_corrbank",
  `es_bacc2currency` int UNSIGNED DEFAULT NULL COMMENT "bacc2_currency",
  `es_bacc2misc` text COLLATE utf8mb4_unicode_ci,
  `es_bacc2swift` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "bacc2_swift",
  `es_ceo` int UNSIGNED DEFAULT NULL,
  `es_emailcopy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "email",
  `es_email1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Email1",
  `es_phonecopy` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Phone",
  `es_website` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Website",
  `es_documents` bigint UNSIGNED DEFAULT NULL COMMENT "Documents",
  `es_compcontracts` bigint UNSIGNED DEFAULT NULL COMMENT "Contracts",
  `es_shared` bigint UNSIGNED DEFAULT NULL COMMENT "Shared files",
  `es_comment` mediumtext COLLATE utf8mb4_unicode_ci,
  `es_dbentry` datetime DEFAULT NULL COMMENT "DB Entry Date",
  `es_upddate` datetime DEFAULT NULL COMMENT "Update Date",
  `es_mvdregnum` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "MVD regnum",
  `es_phone1` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_address1rus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_address1lat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_addressoutsideofrussia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address Outside of Russia",
  `es_addressoutsideofrussia1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address Outside of Russia 1",
  `es_externalfiles` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "External Files",
  `es_bacc1bank_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc2bank_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc1bank_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc2bank_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc1bank_vi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bacc2bank_vi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_bank1bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 1 BIK",
  `es_bank2bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 2 BIK",
  `es_bass2bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 2 BIK",
  `es_bass1bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 1 BIK",
  `es_bacc1bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 1 BIK",
  `es_bacc2bik` varchar(9) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Bank 2 BIK",
  `es_zipcode` int DEFAULT NULL COMMENT "Zip Code",
  `es_bacc1corraccount` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Account 1 corresponding account",
  `es_bacc1corraccrus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Account 1 corresponding account",
  `es_bacc2corraccrus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Account 2 corresponding account in russia"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Companies";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_companies` ADD PRIMARY KEY (`id`), ADD KEY `es_bacc1currency` (`es_bacc1currency`), ADD KEY `es_bacc2currency` (`es_bacc2currency`), ADD KEY `es_ceo` (`es_ceo`), ADD KEY `es_address` (`es_address`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_companies` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_companies`(`id`, `published`, `es_name`, `es_address`, `es_phone`, `es_email`, `es_contactperson`, `es_contactpersonposition`, `es_fullnamerus`, `es_fullnamelat`, `es_fullnamenative`, `es_shortnamerus`, `es_shortnamelat`, `es_shortnamenative`, `es_regnumber`, `es_taxnumber`, `es_taxreasoncode`, `es_estdate`, `es_activitycodes`, `es_statisticscodes`, `es_addressrus`, `es_addresslat`, `es_baccaccnumb`, `es_bacc1accnumb`, `es_bacc1currency`, `es_bacc1bank`, `es_bacc1corracc`, `es_bacc1bank_ru`, `es_bacc1swift`, `es_bacc1corrbank`, `es_bacc1misc`, `es_bacc2accnumb`, `es_bacc2bank`, `es_bacc2bank_ru`, `es_bacc2corracc`, `es_bacc2corrbank`, `es_bacc2currency`, `es_bacc2misc`, `es_bacc2swift`, `es_ceo`, `es_emailcopy`, `es_email1`, `es_phonecopy`, `es_website`, `es_documents`, `es_compcontracts`, `es_shared`, `es_comment`, `es_dbentry`, `es_upddate`, `es_mvdregnum`, `es_phone1`, `es_address1rus`, `es_address1lat`, `es_addressoutsideofrussia`, `es_addressoutsideofrussia1`, `es_externalfiles`, `es_bacc1bank_zh`, `es_bacc2bank_zh`, `es_bacc1bank_ar`, `es_bacc2bank_ar`, `es_bacc1bank_vi`, `es_bacc2bank_vi`, `es_bank1bik`, `es_bank2bik`, `es_bass2bik`, `es_bass1bik`, `es_bacc1bik`, `es_bacc2bik`, `es_zipcode`, `es_bacc1corraccount`, `es_bacc1corraccrus`, `es_bacc2corraccrus`) SELECT `id`, `published`, `es_name`, `es_address`, `es_phone`, `es_email`, `es_contactperson`, `es_contactpersonposition`, `es_fullnamerus`, `es_fullnamelat`, `es_fullnamenative`, `es_shortnamerus`, `es_shortnamelat`, `es_shortnamenative`, `es_regnumber`, `es_taxnumber`, `es_taxreasoncode`, `es_estdate`, `es_activitycodes`, `es_statisticscodes`, `es_addressrus`, `es_addresslat`, `es_baccaccnumb`, `es_bacc1accnumb`, `es_bacc1currency`, `es_bacc1bank`, `es_bacc1corracc`, `es_bacc1bank_ru`, `es_bacc1swift`, `es_bacc1corrbank`, `es_bacc1misc`, `es_bacc2accnumb`, `es_bacc2bank`, `es_bacc2bank_ru`, `es_bacc2corracc`, `es_bacc2corrbank`, `es_bacc2currency`, `es_bacc2misc`, `es_bacc2swift`, `es_ceo`, `es_emailcopy`, `es_email1`, `es_phonecopy`, `es_website`, `es_documents`, `es_compcontracts`, `es_shared`, `es_comment`, `es_dbentry`, `es_upddate`, `es_mvdregnum`, `es_phone1`, `es_address1rus`, `es_address1lat`, `es_addressoutsideofrussia`, `es_addressoutsideofrussia1`, `es_externalfiles`, `es_bacc1bank_zh`, `es_bacc2bank_zh`, `es_bacc1bank_ar`, `es_bacc2bank_ar`, `es_bacc1bank_vi`, `es_bacc2bank_vi`, `es_bank1bik`, `es_bank2bik`, `es_bass2bik`, `es_bass1bik`, `es_bacc1bik`, `es_bacc2bik`, `es_zipcode`, `es_bacc1corraccount`, `es_bacc1corraccrus`, `es_bacc2corraccrus` FROM `lwsp`.`h82im_customtables_table_companies`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_companyemployees` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_company` int UNSIGNED DEFAULT NULL COMMENT "Company",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_position` int UNSIGNED DEFAULT NULL COMMENT "Position",
  `es_phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Phone",
  `es_phone1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Phone1",
  `es_email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "email",
  `es_email1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "email1",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_ismigrant` tinyint NOT NULL DEFAULT "0" COMMENT "Is migrant"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Company Employees";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_companyemployees` ADD PRIMARY KEY (`id`), ADD KEY `es_person` (`es_person`), ADD KEY `es_position` (`es_position`), ADD KEY `es_company` (`es_company`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_companyemployees` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_companyemployees`(`id`, `published`, `es_company`, `es_person`, `es_position`, `es_phone`, `es_phone1`, `es_email`, `es_email1`, `es_comment`, `es_ismigrant`) SELECT `id`, `published`, `es_company`, `es_person`, `es_position`, `es_phone`, `es_phone1`, `es_email`, `es_email1`, `es_comment`, `es_ismigrant` FROM `lwsp`.`h82im_customtables_table_companyemployees`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_contracts` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_contractor1` int UNSIGNED DEFAULT NULL COMMENT "Contractor1",
  `es_contractor2` int UNSIGNED DEFAULT NULL COMMENT "Contractor2",
  `es_contractor3` int UNSIGNED DEFAULT NULL COMMENT "Contractor3",
  `es_contractnum` int DEFAULT NULL COMMENT "Contract Number",
  `es_date` date DEFAULT NULL COMMENT "Date",
  `es_number` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_essence` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Essence",
  `es_file` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "File",
  `es_files` bigint UNSIGNED DEFAULT NULL COMMENT "Files",
  `es_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Contracts";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_contracts` ADD PRIMARY KEY (`id`), ADD KEY `es_contractor1` (`es_contractor1`), ADD KEY `es_contractor2` (`es_contractor2`), ADD KEY `es_contractor3` (`es_contractor3`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_contracts` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_contracts`(`id`, `published`, `es_contractor1`, `es_contractor2`, `es_contractor3`, `es_contractnum`, `es_date`, `es_number`, `es_name`, `es_essence`, `es_file`, `es_files`, `es_comment`) SELECT `id`, `published`, `es_contractor1`, `es_contractor2`, `es_contractor3`, `es_contractnum`, `es_date`, `es_number`, `es_name`, `es_essence`, `es_file`, `es_files`, `es_comment` FROM `lwsp`.`h82im_customtables_table_contracts`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_countries` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `es_code` varchar(2) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Code",
  `es_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_namerussubj` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusaccus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_snamelat` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerussubj` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerusgen` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerusdat` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerusabl` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerusaccus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerusprep` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_namenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Native",
  `es_langnative` int UNSIGNED DEFAULT NULL COMMENT "Language Native",
  `es_capital` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Capital",
  `es_iso3` varchar(3) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "ISO3"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Countries";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_countries` ADD PRIMARY KEY (`id`), ADD KEY `es_langnative` (`es_langnative`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_countries` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2457 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_countries`(`id`, `published`, `es_code`, `es_name`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_snamelat`, `es_snamerussubj`, `es_snamerusgen`, `es_snamerusdat`, `es_snamerusabl`, `es_snamerusaccus`, `es_snamerusprep`, `es_namenative`, `es_langnative`, `es_capital`, `es_iso3`) SELECT `id`, `published`, `es_code`, `es_name`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_snamelat`, `es_snamerussubj`, `es_snamerusgen`, `es_snamerusdat`, `es_snamerusabl`, `es_snamerusaccus`, `es_snamerusprep`, `es_namenative`, `es_langnative`, `es_capital`, `es_iso3` FROM `lwsp`.`h82im_customtables_table_countries`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_currencies` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Lat",
  `es_namerussubj` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusaccus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_code` varchar(3) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Code",
  `es_country` int UNSIGNED DEFAULT NULL COMMENT "Country"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Currencies";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_currencies` ADD PRIMARY KEY (`id`), ADD KEY `es_country` (`es_country`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_currencies` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_currencies`(`id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_code`, `es_country`) SELECT `id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_code`, `es_country` FROM `lwsp`.`h82im_customtables_table_currencies`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_developmentprogress` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_tablename` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_allfieldsfill` tinyint NOT NULL DEFAULT "0",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_addonsite` tinyint NOT NULL DEFAULT "0",
  `es_commentcopy` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_commentfields` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_commentfieldss` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_comment1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_commentfrontendforms` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="progress";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_developmentprogress` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_developmentprogress` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_developmentprogress`(`id`, `published`, `es_tablename`, `es_allfieldsfill`, `es_comment`, `es_addonsite`, `es_commentcopy`, `es_commentfields`, `es_commentfieldss`, `es_comment1`, `es_commentfrontendforms`) SELECT `id`, `published`, `es_tablename`, `es_allfieldsfill`, `es_comment`, `es_addonsite`, `es_commentcopy`, `es_commentfields`, `es_commentfieldss`, `es_comment1`, `es_commentfrontendforms` FROM `lwsp`.`h82im_customtables_table_developmentprogress`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_divtypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Div Type";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_divtypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_divtypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_divtypes`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_divtypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_documents` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Full Name",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_citizenship` int UNSIGNED DEFAULT NULL COMMENT "Citizenship",
  `es_lastnameeng` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_firstname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "First Name ENG",
  `es_firstnameeng` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_middlenameeng` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_lastnamerus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_firstnamerus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_middlenamerus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_lastnamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_middlenamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_firstnamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_nativelanguage` int UNSIGNED DEFAULT NULL COMMENT "Native Language",
  `es_sex` int UNSIGNED DEFAULT NULL COMMENT "Sex",
  `es_passportnumber` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "PASSPORT №",
  `es_dateofbirth` date DEFAULT NULL COMMENT "Date of birth",
  `es_placeofbirth` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Place of Birth",
  `es_passportdateofissue` date DEFAULT NULL COMMENT "Passport date of issue",
  `es_passportdateofvalidity` date DEFAULT NULL COMMENT "Passport date of validity",
  `es_passportissuedby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "PASSPORT ISSUED BY (Authority)",
  `es_type` int UNSIGNED DEFAULT NULL COMMENT "Type"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Documents UNUSED";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_documents` ADD PRIMARY KEY (`id`), ADD KEY `es_person` (`es_person`), ADD KEY `es_citizenship` (`es_citizenship`), ADD KEY `es_nativelanguage` (`es_nativelanguage`), ADD KEY `es_sex` (`es_sex`), ADD KEY `es_type` (`es_type`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_documents` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_documents`(`id`, `published`, `es_fullname`, `es_person`, `es_citizenship`, `es_lastnameeng`, `es_firstname`, `es_firstnameeng`, `es_middlenameeng`, `es_lastnamerus`, `es_firstnamerus`, `es_middlenamerus`, `es_lastnamenative`, `es_middlenamenative`, `es_firstnamenative`, `es_nativelanguage`, `es_sex`, `es_passportnumber`, `es_dateofbirth`, `es_placeofbirth`, `es_passportdateofissue`, `es_passportdateofvalidity`, `es_passportissuedby`, `es_type`) SELECT `id`, `published`, `es_fullname`, `es_person`, `es_citizenship`, `es_lastnameeng`, `es_firstname`, `es_firstnameeng`, `es_middlenameeng`, `es_lastnamerus`, `es_firstnamerus`, `es_middlenamerus`, `es_lastnamenative`, `es_middlenamenative`, `es_firstnamenative`, `es_nativelanguage`, `es_sex`, `es_passportnumber`, `es_dateofbirth`, `es_placeofbirth`, `es_passportdateofissue`, `es_passportdateofvalidity`, `es_passportissuedby`, `es_type` FROM `lwsp`.`h82im_customtables_table_documents`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_emp_id` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="employee id in database";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_emp_id` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_emp_id` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_emp_id`(`id`, `published`) SELECT `id`, `published` FROM `lwsp`.`h82im_customtables_table_emp_id`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_eststat` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="EstateStatus";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_eststat` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_eststat` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_eststat`(`id`, `published`) SELECT `id`, `published` FROM `lwsp`.`h82im_customtables_table_eststat`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_ethnicity` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Lat",
  `es_namerussubj` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_namerusaccus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_namenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Native",
  `es_nativelang` int UNSIGNED DEFAULT NULL COMMENT "Native Lang",
  `es_omment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Сomment",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_synonym` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Synonym"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Ethnicity";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_ethnicity` ADD PRIMARY KEY (`id`), ADD KEY `es_nativelang` (`es_nativelang`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_ethnicity` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_ethnicity`(`id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namenative`, `es_nativelang`, `es_omment`, `es_comment`, `es_synonym`) SELECT `id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namenative`, `es_nativelang`, `es_omment`, `es_comment`, `es_synonym` FROM `lwsp`.`h82im_customtables_table_ethnicity`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_genders` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint NOT NULL DEFAULT "1",
  `es_namelat` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gender",
  `es_icon` bigint DEFAULT NULL COMMENT "Icon",
  `es_gender` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gender",
  `es_namerus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gender Rus",
  `es_snamerus` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Short",
  `es_snamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gender Short Lat",
  `es_citizenship` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Citizenship",
  `es_citizenshipshort` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "CitizenshipShort"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Genders";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_genders` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_genders` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_genders`(`id`, `published`, `es_namelat`, `es_icon`, `es_gender`, `es_namerus`, `es_snamerus`, `es_snamelat`, `es_citizenship`, `es_citizenshipshort`) SELECT `id`, `published`, `es_namelat`, `es_icon`, `es_gender`, `es_namerus`, `es_snamerus`, `es_snamelat`, `es_citizenship`, `es_citizenshipshort` FROM `lwsp`.`h82im_customtables_table_genders`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_housetypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="House Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_housetypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_housetypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_housetypes`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_housetypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_housingtype` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Housing Type";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_housingtype` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_housingtype` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_housingtype`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_housingtype`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_languages` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "English",
  `es_namerus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Russian",
  `es_native` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Native",
  `es_englishshort` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "English Short",
  `es_russianshort` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Russian Short",
  `es_langnamelat` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_langnamerus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_langnamenative` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_langsnamerus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_langsnamelat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_langsnamenative` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Native Short",
  `es_code` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Code",
  `es_snamenative` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamerus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_snamelat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_namenative` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_flagimg` bigint DEFAULT NULL COMMENT "Flagimg",
  `es_coord` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Coordinates",
  `es_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Languages";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_languages` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_languages` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_languages`(`id`, `published`, `es_namelat`, `es_namerus`, `es_native`, `es_englishshort`, `es_russianshort`, `es_langnamelat`, `es_langnamerus`, `es_langnamenative`, `es_langsnamerus`, `es_langsnamelat`, `es_langsnamenative`, `es_code`, `es_snamenative`, `es_snamerus`, `es_snamelat`, `es_namenative`, `es_flagimg`, `es_coord`, `es_comment`) SELECT `id`, `published`, `es_namelat`, `es_namerus`, `es_native`, `es_englishshort`, `es_russianshort`, `es_langnamelat`, `es_langnamerus`, `es_langnamenative`, `es_langsnamerus`, `es_langsnamelat`, `es_langsnamenative`, `es_code`, `es_snamenative`, `es_snamerus`, `es_snamelat`, `es_namenative`, `es_flagimg`, `es_coord`, `es_comment` FROM `lwsp`.`h82im_customtables_table_languages`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentsmisc` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_person` int UNSIGNED DEFAULT NULL,
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_file` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_type` int UNSIGNED DEFAULT NULL,
  `es_personpass` int UNSIGNED DEFAULT NULL,
  `es_date` datetime DEFAULT NULL COMMENT "Date",
  `es_link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Link"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Documents Misc";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentsmisc` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentsmisc` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migdocumentsmisc`(`id`, `published`, `es_person`, `es_name`, `es_file`, `es_type`, `es_personpass`, `es_date`, `es_link`) SELECT `id`, `published`, `es_person`, `es_name`, `es_file`, `es_type`, `es_personpass`, `es_date`, `es_link` FROM `lwsp`.`h82im_customtables_table_migdocumentsmisc`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentstypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig Documents types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentstypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migdocumentstypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migdocumentstypes`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_migdocumentstypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmidcompanyloiletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_regnum` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_submdate` date DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_rusentrydate` date DEFAULT NULL,
  `es_visaenddate` date DEFAULT NULL,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_status` int UNSIGNED DEFAULT NULL COMMENT "Status",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_fullnamerus` int UNSIGNED DEFAULT NULL COMMENT "Full name rus",
  `es_gender` int UNSIGNED DEFAULT NULL COMMENT "Gender",
  `es_birthdate` date DEFAULT NULL COMMENT "Birth date",
  `es_invcompanyname` int UNSIGNED DEFAULT NULL COMMENT "Invitation company name",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_invcompany` int UNSIGNED DEFAULT NULL COMMENT "Invitation company ",
  `es_passport` int UNSIGNED DEFAULT NULL COMMENT "Passport",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project Batch",
  `es_projectsite` int UNSIGNED DEFAULT NULL COMMENT "Project Site",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project Site",
  `es_letterdocslink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Letter Docs Link",
  `es_rescountry` int UNSIGNED DEFAULT NULL COMMENT "Country of residence",
  `es_resplace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "resplace",
  `es_visa` int UNSIGNED DEFAULT NULL COMMENT "Visa",
  `es_visamultiplicity` int UNSIGNED DEFAULT NULL COMMENT "Visa multiplicity",
  `es_visatype` int UNSIGNED DEFAULT NULL COMMENT "Visa Type",
  `es_rusvisitplaces` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Visit Places",
  `es_rusentrypurpose` int UNSIGNED DEFAULT NULL COMMENT "Entry Purpose"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="MID company loi letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmidcompanyloiletters` ADD PRIMARY KEY (`id`), ADD KEY `es_status` (`es_status`), ADD KEY `es_project` (`es_project`), ADD KEY `es_fullnamerus` (`es_fullnamerus`), ADD KEY `es_gender` (`es_gender`), ADD KEY `es_invcompanyname` (`es_invcompanyname`), ADD KEY `es_person` (`es_person`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_invcompany` (`es_invcompany`), ADD KEY `es_passport` (`es_passport`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_rescountry` (`es_rescountry`), ADD KEY `es_visa` (`es_visa`), ADD KEY `es_visamultiplicity` (`es_visamultiplicity`), ADD KEY `es_visatype` (`es_visatype`), ADD KEY `es_rusentrypurpose` (`es_rusentrypurpose`), ADD KEY `es_rusvisitplaces` (`es_rusvisitplaces`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmidcompanyloiletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmidcompanyloiletters`(`id`, `published`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_rusentrydate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_project`, `es_fullnamerus`, `es_gender`, `es_birthdate`, `es_invcompanyname`, `es_person`, `es_invcompany`, `es_passport`, `es_employee`, `es_projectbatch`, `es_projectsite`, `es_projsite`, `es_letterdocslink`, `es_rescountry`, `es_resplace`, `es_visa`, `es_visamultiplicity`, `es_visatype`, `es_rusvisitplaces`, `es_rusentrypurpose`) SELECT `id`, `published`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_rusentrydate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_project`, `es_fullnamerus`, `es_gender`, `es_birthdate`, `es_invcompanyname`, `es_person`, `es_invcompany`, `es_passport`, `es_employee`, `es_projectbatch`, `es_projectsite`, `es_projsite`, `es_letterdocslink`, `es_rescountry`, `es_resplace`, `es_visa`, `es_visamultiplicity`, `es_visatype`, `es_rusvisitplaces`, `es_rusentrypurpose` FROM `lwsp`.`h82im_customtables_table_migmidcompanyloiletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplications` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_mvdappregnum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_mvdappdate` date DEFAULT NULL,
  `es_mvdappsubmdate` date DEFAULT NULL,
  `es_mvdappdbentrydate` date DEFAULT NULL,
  `es_mvdapprusentrydate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_mvdappplanissdate` date DEFAULT NULL,
  `es_mvdappvisaenddate` date DEFAULT NULL,
  `es_mvdappinvcomppoanum` int DEFAULT NULL,
  `es_mvdappinvcomppoadate` date DEFAULT NULL,
  `es_mvdappcomment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_mvdappchangedate` date DEFAULT NULL,
  `es_mvdappchangedby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_regnum` bigint UNSIGNED DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_submdate` date DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_rusentrydate` date DEFAULT NULL,
  `es_planissdate` date DEFAULT NULL,
  `es_visaenddate` date DEFAULT NULL,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_invcompanyname` int UNSIGNED DEFAULT NULL,
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_projectsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_visitpurpose` int UNSIGNED DEFAULT NULL COMMENT "Visit Purpose",
  `es_visamultiplicity` int UNSIGNED DEFAULT NULL COMMENT "Visa Multiplicity",
  `es_visatermdays` int DEFAULT NULL COMMENT "Visa Term Days",
  `es_visatype` int UNSIGNED DEFAULT NULL COMMENT "Visa Type",
  `es_applicationdate` date DEFAULT NULL COMMENT "Application creation date",
  `es_reasonsforurgentregistrationareattached` tinyint NOT NULL DEFAULT "0" COMMENT "Reasons for urgent registration are attached",
  `es_employees` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employees",
  `es_speedupdate` date DEFAULT NULL COMMENT "Speedup Date"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Applications to MVD";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplications` ADD PRIMARY KEY (`id`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_visitpurpose` (`es_visitpurpose`), ADD KEY `es_visamultiplicity` (`es_visamultiplicity`), ADD KEY `es_visatype` (`es_visatype`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplications` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdapplications`(`id`, `published`, `es_mvdappregnum`, `es_mvdappdate`, `es_mvdappsubmdate`, `es_mvdappdbentrydate`, `es_mvdapprusentrydate`, `es_mvdappplanissdate`, `es_mvdappvisaenddate`, `es_mvdappinvcomppoanum`, `es_mvdappinvcomppoadate`, `es_mvdappcomment`, `es_mvdappchangedate`, `es_mvdappchangedby`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_rusentrydate`, `es_planissdate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_invcompanyname`, `es_project`, `es_projsite`, `es_projectbatch`, `es_employee`, `es_projectsite`, `es_visitpurpose`, `es_visamultiplicity`, `es_visatermdays`, `es_visatype`, `es_applicationdate`, `es_reasonsforurgentregistrationareattached`, `es_employees`, `es_speedupdate`) SELECT `id`, `published`, `es_mvdappregnum`, `es_mvdappdate`, `es_mvdappsubmdate`, `es_mvdappdbentrydate`, `es_mvdapprusentrydate`, `es_mvdappplanissdate`, `es_mvdappvisaenddate`, `es_mvdappinvcomppoanum`, `es_mvdappinvcomppoadate`, `es_mvdappcomment`, `es_mvdappchangedate`, `es_mvdappchangedby`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_rusentrydate`, `es_planissdate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_invcompanyname`, `es_project`, `es_projsite`, `es_projectbatch`, `es_employee`, `es_projectsite`, `es_visitpurpose`, `es_visamultiplicity`, `es_visatermdays`, `es_visatype`, `es_applicationdate`, `es_reasonsforurgentregistrationareattached`, `es_employees`, `es_speedupdate` FROM `lwsp`.`h82im_customtables_table_migmvdapplications`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplicationssub` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_migmvdapplication` int UNSIGNED DEFAULT NULL COMMENT "Applications to MVD",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_rescountry` int UNSIGNED DEFAULT NULL COMMENT "Residency Country",
  `es_resplace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Residency Place",
  `es_resplacerus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Residency Place (In Russian)",
  `es_rusentrydate` date DEFAULT NULL COMMENT "Enter to country date",
  `es_visaenddate` date DEFAULT NULL COMMENT "visa end date",
  `es_visitpurpose` int UNSIGNED DEFAULT NULL COMMENT "Visit Purpose",
  `es_visamultiplicity` int UNSIGNED DEFAULT NULL COMMENT "Visa Multiplicity",
  `es_visatype` int UNSIGNED DEFAULT NULL COMMENT "Visa Type",
  `es_rusvisitplaces` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Vsit Places",
  `es_visaisscountry` int UNSIGNED DEFAULT NULL COMMENT "Visa Issue Country",
  `es_visaisscity` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Visa Issue City",
  `es_position` int UNSIGNED DEFAULT NULL COMMENT "Position",
  `es_empworkplace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employee Workplace",
  `es_empworkaddress` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employee Work Address",
  `es_stayaddressinrus` varchar(36) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia",
  `es_stayaddressinrushouse` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia House",
  `es_stayaddressinrusstructure` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia Structure",
  `es_stayaddressinrussframe` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia Frame",
  `es_stayaddressinrussapartment` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia Apartment",
  `es_stayaddressinrussphone` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Addreess in Russia Phone"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Applications to MVD - Workers";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplicationssub` ADD PRIMARY KEY (`id`), ADD KEY `es_migmvdapplication` (`es_migmvdapplication`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_rescountry` (`es_rescountry`), ADD KEY `es_visitpurpose` (`es_visitpurpose`), ADD KEY `es_visamultiplicity` (`es_visamultiplicity`), ADD KEY `es_visatype` (`es_visatype`), ADD KEY `es_visaisscountry` (`es_visaisscountry`), ADD KEY `es_position` (`es_position`), ADD KEY `es_stayaddressinrus` (`es_stayaddressinrus`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdapplicationssub` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdapplicationssub`(`id`, `published`, `es_migmvdapplication`, `es_employee`, `es_rescountry`, `es_resplace`, `es_resplacerus`, `es_rusentrydate`, `es_visaenddate`, `es_visitpurpose`, `es_visamultiplicity`, `es_visatype`, `es_rusvisitplaces`, `es_visaisscountry`, `es_visaisscity`, `es_position`, `es_empworkplace`, `es_empworkaddress`, `es_stayaddressinrus`, `es_stayaddressinrushouse`, `es_stayaddressinrusstructure`, `es_stayaddressinrussframe`, `es_stayaddressinrussapartment`, `es_stayaddressinrussphone`) SELECT `id`, `published`, `es_migmvdapplication`, `es_employee`, `es_rescountry`, `es_resplace`, `es_resplacerus`, `es_rusentrydate`, `es_visaenddate`, `es_visitpurpose`, `es_visamultiplicity`, `es_visatype`, `es_rusvisitplaces`, `es_visaisscountry`, `es_visaisscity`, `es_position`, `es_empworkplace`, `es_empworkaddress`, `es_stayaddressinrus`, `es_stayaddressinrushouse`, `es_stayaddressinrusstructure`, `es_stayaddressinrussframe`, `es_stayaddressinrussapartment`, `es_stayaddressinrussphone` FROM `lwsp`.`h82im_customtables_table_migmvdapplicationssub`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdcorrletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_ornum` int DEFAULT NULL,
  `es_regnum` bigint UNSIGNED DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_rusentrydate` date DEFAULT NULL,
  `es_visaenddate` date DEFAULT NULL,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_status` int UNSIGNED DEFAULT NULL COMMENT "Status",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_invcompany` int UNSIGNED DEFAULT NULL COMMENT "Invitation company",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project Site",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_passport` int UNSIGNED DEFAULT NULL COMMENT "Passport",
  `es_beretsaizrabotnikapasporta` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Letter Docs Link",
  `es_rescountry` int UNSIGNED DEFAULT NULL COMMENT "Country of residence",
  `es_resplace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Place of residence",
  `es_visa` int UNSIGNED DEFAULT NULL COMMENT "Visa",
  `es_rusexitdate` date DEFAULT NULL COMMENT "Exit Date"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="MVD correct letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdcorrletters` ADD PRIMARY KEY (`id`), ADD KEY `es_status` (`es_status`), ADD KEY `es_person` (`es_person`), ADD KEY `es_invcompany` (`es_invcompany`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_passport` (`es_passport`), ADD KEY `es_rescountry` (`es_rescountry`), ADD KEY `es_visa` (`es_visa`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdcorrletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdcorrletters`(`id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_dbentrydate`, `es_rusentrydate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_person`, `es_invcompany`, `es_projectbatch`, `es_projsite`, `es_project`, `es_employee`, `es_passport`, `es_beretsaizrabotnikapasporta`, `es_rescountry`, `es_resplace`, `es_visa`, `es_rusexitdate`) SELECT `id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_dbentrydate`, `es_rusentrydate`, `es_visaenddate`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_person`, `es_invcompany`, `es_projectbatch`, `es_projsite`, `es_project`, `es_employee`, `es_passport`, `es_beretsaizrabotnikapasporta`, `es_rescountry`, `es_resplace`, `es_visa`, `es_rusexitdate` FROM `lwsp`.`h82im_customtables_table_migmvdcorrletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdemplists` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_emplistordnum` int DEFAULT NULL,
  `es_emplistregnum` int DEFAULT NULL,
  `es_emplistsubmitdate` date DEFAULT NULL,
  `es_empliststatus` int UNSIGNED DEFAULT NULL,
  `es_emplistinvcompany` int UNSIGNED DEFAULT NULL,
  `es_emplistcompcardnum` int UNSIGNED DEFAULT NULL,
  `es_emplistdbentrydate` date DEFAULT NULL,
  `es_emplistcomment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_emplistchangedate` date DEFAULT NULL,
  `es_emplistchangedby` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_ordnum` bigint UNSIGNED DEFAULT NULL,
  `es_regnum` int DEFAULT NULL,
  `es_submitdate` date DEFAULT NULL,
  `es_status` int UNSIGNED DEFAULT NULL,
  `es_invcompany` int UNSIGNED DEFAULT NULL,
  `es_compcardnum` int UNSIGNED DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_projbatch` int UNSIGNED DEFAULT NULL,
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project Batch",
  `es_createdby` int UNSIGNED DEFAULT NULL COMMENT "Name of person who created the record",
  `es_visamultiplicity` int UNSIGNED DEFAULT NULL COMMENT "Visa Multiplicity"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="migmvdemplists";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdemplists` ADD PRIMARY KEY (`id`), ADD KEY `es_projbatch` (`es_projbatch`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_status` (`es_status`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_createdby` (`es_createdby`), ADD KEY `es_visamultiplicity` (`es_visamultiplicity`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdemplists` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdemplists`(`id`, `published`, `es_emplistordnum`, `es_emplistregnum`, `es_emplistsubmitdate`, `es_empliststatus`, `es_emplistinvcompany`, `es_emplistcompcardnum`, `es_emplistdbentrydate`, `es_emplistcomment`, `es_emplistchangedate`, `es_emplistchangedby`, `es_ordnum`, `es_regnum`, `es_submitdate`, `es_status`, `es_invcompany`, `es_compcardnum`, `es_dbentrydate`, `es_comment`, `es_changedate`, `es_changedby`, `es_projbatch`, `es_project`, `es_projsite`, `es_projectbatch`, `es_createdby`, `es_visamultiplicity`) SELECT `id`, `published`, `es_emplistordnum`, `es_emplistregnum`, `es_emplistsubmitdate`, `es_empliststatus`, `es_emplistinvcompany`, `es_emplistcompcardnum`, `es_emplistdbentrydate`, `es_emplistcomment`, `es_emplistchangedate`, `es_emplistchangedby`, `es_ordnum`, `es_regnum`, `es_submitdate`, `es_status`, `es_invcompany`, `es_compcardnum`, `es_dbentrydate`, `es_comment`, `es_changedate`, `es_changedby`, `es_projbatch`, `es_project`, `es_projsite`, `es_projectbatch`, `es_createdby`, `es_visamultiplicity` FROM `lwsp`.`h82im_customtables_table_migmvdemplists`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdguaranteeletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_regnum` bigint UNSIGNED DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_submdate` date DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_mvdgletinvcomppoadate` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_passnum` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_invcompanyname` int UNSIGNED DEFAULT NULL,
  `es_ethnicity` int UNSIGNED DEFAULT NULL,
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project Site",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_gletdocslink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Document Link",
  `es_status` int UNSIGNED DEFAULT NULL COMMENT "Status"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="MVD Guarantee Letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdguaranteeletters` ADD PRIMARY KEY (`id`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_status` (`es_status`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdguaranteeletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdguaranteeletters`(`id`, `published`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_invcomppoanum`, `es_mvdgletinvcomppoadate`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_passnum`, `es_invcompanyname`, `es_ethnicity`, `es_project`, `es_projsite`, `es_projectbatch`, `es_employee`, `es_gletdocslink`, `es_status`) SELECT `id`, `published`, `es_regnum`, `es_date`, `es_submdate`, `es_dbentrydate`, `es_invcomppoanum`, `es_mvdgletinvcomppoadate`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_passnum`, `es_invcompanyname`, `es_ethnicity`, `es_project`, `es_projsite`, `es_projectbatch`, `es_employee`, `es_gletdocslink`, `es_status` FROM `lwsp`.`h82im_customtables_table_migmvdguaranteeletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdloidocstatuses` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_migmvdemplists` tinyint NOT NULL DEFAULT "0" COMMENT "For Mig MVD Emp Lists"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig MVD Loidoc Statuses";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdloidocstatuses` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdloidocstatuses` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdloidocstatuses`(`id`, `published`, `es_name`, `es_migmvdemplists`) SELECT `id`, `published`, `es_name`, `es_migmvdemplists` FROM `lwsp`.`h82im_customtables_table_migmvdloidocstatuses`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdlois` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_loinum` int DEFAULT NULL,
  `es_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_passseries` int UNSIGNED DEFAULT NULL COMMENT "Passport serie",
  `es_passnum` int UNSIGNED DEFAULT NULL COMMENT "Passport number",
  `es_empbatchornum` int UNSIGNED DEFAULT NULL COMMENT "Employee batch order number",
  `es_folderlink` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_lastnamelat` int UNSIGNED DEFAULT NULL COMMENT "Employee latin last name",
  `es_firstnamelat` int UNSIGNED DEFAULT NULL COMMENT "Employee latin first name",
  `es_middlenamelat` int UNSIGNED DEFAULT NULL COMMENT "Employee latin middle name",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_passport` int UNSIGNED DEFAULT NULL COMMENT "Passport",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_visa` int UNSIGNED DEFAULT NULL COMMENT "Visa",
  `es_files` bigint UNSIGNED DEFAULT NULL COMMENT "Files"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="MVD lois";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdlois` ADD PRIMARY KEY (`id`), ADD KEY `es_passseries` (`es_passseries`), ADD KEY `es_passnum` (`es_passnum`), ADD KEY `es_empbatchornum` (`es_empbatchornum`), ADD KEY `es_lastnamelat` (`es_lastnamelat`), ADD KEY `es_firstnamelat` (`es_firstnamelat`), ADD KEY `es_middlenamelat` (`es_middlenamelat`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_passport` (`es_passport`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_visa` (`es_visa`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdlois` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdlois`(`id`, `published`, `es_dbentrydate`, `es_loinum`, `es_comment`, `es_changedate`, `es_changedby`, `es_passseries`, `es_passnum`, `es_empbatchornum`, `es_folderlink`, `es_lastnamelat`, `es_firstnamelat`, `es_middlenamelat`, `es_employee`, `es_passport`, `es_projsite`, `es_project`, `es_projectbatch`, `es_visa`, `es_files`) SELECT `id`, `published`, `es_dbentrydate`, `es_loinum`, `es_comment`, `es_changedate`, `es_changedby`, `es_passseries`, `es_passnum`, `es_empbatchornum`, `es_folderlink`, `es_lastnamelat`, `es_firstnamelat`, `es_middlenamelat`, `es_employee`, `es_passport`, `es_projsite`, `es_project`, `es_projectbatch`, `es_visa`, `es_files` FROM `lwsp`.`h82im_customtables_table_migmvdlois`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migmvdspeedupletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_ornum` int DEFAULT NULL,
  `es_regnum` int DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_status` int UNSIGNED DEFAULT NULL COMMENT "Status",
  `es_invcompanyname` int UNSIGNED DEFAULT NULL COMMENT "Invitation Company name",
  `es_taxnum` int UNSIGNED DEFAULT NULL COMMENT "Tax number",
  `es_taxreasoncode` int UNSIGNED DEFAULT NULL COMMENT "Tax reason code",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_invcomprepposition` int UNSIGNED DEFAULT NULL COMMENT "InvCompRePosition",
  `es_invcomprepname` int UNSIGNED DEFAULT NULL COMMENT "InvCompRepName",
  `es_projbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_speedletdocslink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_speedletdocslinkcopy` bigint UNSIGNED DEFAULT NULL COMMENT "Speed letter docs link",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_employees` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employee",
  `es_speedletdocs` bigint UNSIGNED DEFAULT NULL COMMENT "Speed letter docs",
  `es_changedbycopy` int UNSIGNED DEFAULT NULL COMMENT "Change by",
  `es_createdby` int UNSIGNED DEFAULT NULL COMMENT "Created by",
  `es_invcompany` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Inviting Company"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="MVD Speed up letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdspeedupletters` ADD PRIMARY KEY (`id`), ADD KEY `es_status` (`es_status`), ADD KEY `es_invcompanyname` (`es_invcompanyname`), ADD KEY `es_taxnum` (`es_taxnum`), ADD KEY `es_taxreasoncode` (`es_taxreasoncode`), ADD KEY `es_projsite` (`es_projsite`), ADD KEY `es_project` (`es_project`), ADD KEY `es_invcomprepposition` (`es_invcomprepposition`), ADD KEY `es_invcomprepname` (`es_invcomprepname`), ADD KEY `es_projbatch` (`es_projbatch`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_changedbycopy` (`es_changedbycopy`), ADD KEY `es_createdby` (`es_createdby`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migmvdspeedupletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migmvdspeedupletters`(`id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_text`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_invcompanyname`, `es_taxnum`, `es_taxreasoncode`, `es_projsite`, `es_project`, `es_invcomprepposition`, `es_invcomprepname`, `es_projbatch`, `es_speedletdocslink`, `es_speedletdocslinkcopy`, `es_projectbatch`, `es_employee`, `es_employees`, `es_speedletdocs`, `es_changedbycopy`, `es_createdby`, `es_invcompany`) SELECT `id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_text`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_status`, `es_invcompanyname`, `es_taxnum`, `es_taxreasoncode`, `es_projsite`, `es_project`, `es_invcomprepposition`, `es_invcomprepname`, `es_projbatch`, `es_speedletdocslink`, `es_speedletdocslinkcopy`, `es_projectbatch`, `es_employee`, `es_employees`, `es_speedletdocs`, `es_changedbycopy`, `es_createdby`, `es_invcompany` FROM `lwsp`.`h82im_customtables_table_migmvdspeedupletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojectbatches` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_projname` int UNSIGNED DEFAULT NULL COMMENT "Project Name",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project Site",
  `es_batchnum` int DEFAULT NULL COMMENT "batchnum",
  `es_date` date DEFAULT NULL,
  `es_employees` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employees",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_fullname` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "FullName"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Project Batches";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectbatches` ADD PRIMARY KEY (`id`), ADD KEY `es_projname` (`es_projname`), ADD KEY `es_projsite` (`es_projsite`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectbatches` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=50 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojectbatches`(`id`, `published`, `es_projname`, `es_projsite`, `es_batchnum`, `es_date`, `es_employees`, `es_project`, `es_fullname`) SELECT `id`, `published`, `es_projname`, `es_projsite`, `es_batchnum`, `es_date`, `es_employees`, `es_project`, `es_fullname` FROM `lwsp`.`h82im_customtables_table_migprojectbatches`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcases` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_status` tinyint NOT NULL DEFAULT "0" COMMENT "Status",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_startdate` date DEFAULT NULL,
  `es_enddate` date DEFAULT NULL COMMENT "End Date",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_essence` mediumtext COLLATE utf8mb4_unicode_ci,
  `es_comment` mediumtext COLLATE utf8mb4_unicode_ci,
  `es_dbentrydate` datetime DEFAULT NULL COMMENT "DB Entry Date",
  `es_files` bigint UNSIGNED DEFAULT NULL COMMENT "Files",
  `es_externaldocuments` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "External Documents"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig Project Cases";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcases` ADD PRIMARY KEY (`id`), ADD KEY `es_project` (`es_project`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcases` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojectcases`(`id`, `published`, `es_status`, `es_project`, `es_startdate`, `es_enddate`, `es_name`, `es_essence`, `es_comment`, `es_dbentrydate`, `es_files`, `es_externaldocuments`) SELECT `id`, `published`, `es_status`, `es_project`, `es_startdate`, `es_enddate`, `es_name`, `es_essence`, `es_comment`, `es_dbentrydate`, `es_files`, `es_externaldocuments` FROM `lwsp`.`h82im_customtables_table_migprojectcases`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcoverletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_number` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Number",
  `es_date` date DEFAULT NULL COMMENT "Date",
  `es_company` int UNSIGNED DEFAULT NULL COMMENT "Company",
  `es_forwhom` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_address` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address",
  `es_essence` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Essence",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_file` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "File"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Project Cover Letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcoverletters` ADD PRIMARY KEY (`id`), ADD KEY `es_company` (`es_company`), ADD KEY `es_forwhom` (`es_forwhom`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectcoverletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojectcoverletters`(`id`, `published`, `es_number`, `es_date`, `es_company`, `es_forwhom`, `es_address`, `es_essence`, `es_comment`, `es_file`) SELECT `id`, `published`, `es_number`, `es_date`, `es_company`, `es_forwhom`, `es_address`, `es_essence`, `es_comment`, `es_file` FROM `lwsp`.`h82im_customtables_table_migprojectcoverletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojects` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_status` tinyint NOT NULL DEFAULT "0" COMMENT "Status",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_startdate` date DEFAULT NULL COMMENT "Start date",
  `es_enddate` date DEFAULT NULL COMMENT "End Date",
  `es_location` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Location",
  `es_contactperson` int UNSIGNED DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_projectsites` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_contractors` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_company` int UNSIGNED DEFAULT NULL COMMENT "Company",
  `es_companycreateyear` date DEFAULT NULL COMMENT "Company create year",
  `es_companyandyear` varchar(512) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci GENERATED ALWAYS AS (concat(`es_company`,_utf8mb4" ",`es_companycreateyear`)) VIRTUAL COMMENT "Company and year",
  `es_cases` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Cases"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Projects";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojects` ADD PRIMARY KEY (`id`), ADD KEY `es_contactperson` (`es_contactperson`), ADD KEY `es_company` (`es_company`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojects` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojects`(`id`, `published`, `es_status`, `es_name`, `es_startdate`, `es_enddate`, `es_location`, `es_contactperson`, `es_comment`, `es_projectsites`, `es_contractors`, `es_company`, `es_companycreateyear`, `es_cases`) SELECT `id`, `published`, `es_status`, `es_name`, `es_startdate`, `es_enddate`, `es_location`, `es_contactperson`, `es_comment`, `es_projectsites`, `es_contractors`, `es_company`, `es_companycreateyear`, `es_cases` FROM `lwsp`.`h82im_customtables_table_migprojects`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsemployees` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_id` bigint UNSIGNED DEFAULT NULL COMMENT "ID",
  `es_comment` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Comment",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Create employee profile connecting with person profile";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsemployees` ADD PRIMARY KEY (`id`), ADD KEY `es_person` (`es_person`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsemployees` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojectsemployees`(`id`, `published`, `es_id`, `es_comment`, `es_person`) SELECT `id`, `published`, `es_id`, `es_comment`, `es_person` FROM `lwsp`.`h82im_customtables_table_migprojectsemployees`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsites` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_location` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "location",
  `es_contractors` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Contractors",
  `es_employees` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Employees"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Project sites";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsites` ADD PRIMARY KEY (`id`), ADD KEY `es_project` (`es_project`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migprojectsites` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migprojectsites`(`id`, `published`, `es_project`, `es_name`, `es_location`, `es_contractors`, `es_employees`) SELECT `id`, `published`, `es_project`, `es_name`, `es_location`, `es_contractors`, `es_employees` FROM `lwsp`.`h82im_customtables_table_migprojectsites`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletterlist` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_letterlink` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_ornum` int DEFAULT NULL,
  `es_relminlistempnamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_relminlistempbirthdate` date DEFAULT NULL,
  `es_rusvisitperiod` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_rusentrydate` date DEFAULT NULL,
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_empbirthdate` date DEFAULT NULL,
  `es_empnamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_empworkplace` int UNSIGNED DEFAULT NULL COMMENT "Employee work place",
  `es_empposition` int UNSIGNED DEFAULT NULL COMMENT "Employee position",
  `es_rusentrypurpose` int UNSIGNED DEFAULT NULL COMMENT "Russia entry purpose",
  `es_invcompany` int UNSIGNED DEFAULT NULL COMMENT "Invitation company",
  `es_invcompcontacts` int UNSIGNED DEFAULT NULL COMMENT "Invitation company contacts"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Ministry enqury letter list";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletterlist` ADD PRIMARY KEY (`id`), ADD KEY `es_empworkplace` (`es_empworkplace`), ADD KEY `es_empposition` (`es_empposition`), ADD KEY `es_rusentrypurpose` (`es_rusentrypurpose`), ADD KEY `es_invcompany` (`es_invcompany`), ADD KEY `es_invcompcontacts` (`es_invcompcontacts`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletterlist` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migrelministryenqletterlist`(`id`, `published`, `es_letterlink`, `es_ornum`, `es_relminlistempnamelat`, `es_relminlistempbirthdate`, `es_rusvisitperiod`, `es_rusentrydate`, `es_dbentrydate`, `es_comment`, `es_changedate`, `es_changedby`, `es_empbirthdate`, `es_empnamelat`, `es_empworkplace`, `es_empposition`, `es_rusentrypurpose`, `es_invcompany`, `es_invcompcontacts`) SELECT `id`, `published`, `es_letterlink`, `es_ornum`, `es_relminlistempnamelat`, `es_relminlistempbirthdate`, `es_rusvisitperiod`, `es_rusentrydate`, `es_dbentrydate`, `es_comment`, `es_changedate`, `es_changedby`, `es_empbirthdate`, `es_empnamelat`, `es_empworkplace`, `es_empposition`, `es_rusentrypurpose`, `es_invcompany`, `es_invcompcontacts` FROM `lwsp`.`h82im_customtables_table_migrelministryenqletterlist`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletters` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_ornum` int DEFAULT NULL,
  `es_regnum` bigint UNSIGNED DEFAULT NULL,
  `es_date` date DEFAULT NULL,
  `es_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_invcomppoanum` int DEFAULT NULL,
  `es_invcomppoadate` date DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_changedate` datetime DEFAULT NULL,
  `es_changedby` int UNSIGNED DEFAULT NULL,
  `es_invcompany` int UNSIGNED DEFAULT NULL COMMENT "Invitatin company",
  `es_projbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch",
  `es_project` int UNSIGNED DEFAULT NULL COMMENT "Project",
  `es_projsite` int UNSIGNED DEFAULT NULL COMMENT "Project site",
  `es_speedletdocslink` bigint UNSIGNED DEFAULT NULL COMMENT "Speed letter docs link",
  `es_docs` bigint UNSIGNED DEFAULT NULL,
  `es_employee` int UNSIGNED DEFAULT NULL COMMENT "Employee",
  `es_projectbatch` int UNSIGNED DEFAULT NULL COMMENT "Project batch"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Ministry enqury letters";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletters` ADD PRIMARY KEY (`id`), ADD KEY `es_invcompany` (`es_invcompany`), ADD KEY `es_projbatch` (`es_projbatch`), ADD KEY `es_project` (`es_project`), ADD KEY `es_projsite` (`es_projsite`), ADD KEY `es_employee` (`es_employee`), ADD KEY `es_projectbatch` (`es_projectbatch`), ADD KEY `es_changedby` (`es_changedby`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migrelministryenqletters` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migrelministryenqletters`(`id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_text`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_invcompany`, `es_projbatch`, `es_project`, `es_projsite`, `es_speedletdocslink`, `es_docs`, `es_employee`, `es_projectbatch`) SELECT `id`, `published`, `es_ornum`, `es_regnum`, `es_date`, `es_text`, `es_invcomppoanum`, `es_invcomppoadate`, `es_comment`, `es_changedate`, `es_changedby`, `es_invcompany`, `es_projbatch`, `es_project`, `es_projsite`, `es_speedletdocslink`, `es_docs`, `es_employee`, `es_projectbatch` FROM `lwsp`.`h82im_customtables_table_migrelministryenqletters`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migvisamultiplicityterm` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_multiplicity` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_termdays` int DEFAULT NULL COMMENT "Max Days",
  `es_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Multiplicity",
  `es_maxdays` int DEFAULT NULL COMMENT "Term Days",
  `es_termmonth` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Term Month",
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_govdoclink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gov Doc Link",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_multiplicitystring` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Multiplicity String",
  `es_multiplicityanddays` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Multiplicity and max days"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig visa multiplicity term";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisamultiplicityterm` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisamultiplicityterm` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migvisamultiplicityterm`(`id`, `published`, `es_multiplicity`, `es_termdays`, `es_name`, `es_maxdays`, `es_termmonth`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_multiplicitystring`, `es_multiplicityanddays`) SELECT `id`, `published`, `es_multiplicity`, `es_termdays`, `es_name`, `es_maxdays`, `es_termmonth`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_multiplicitystring`, `es_multiplicityanddays` FROM `lwsp`.`h82im_customtables_table_migvisamultiplicityterm`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migvisatypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_type` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type",
  `es_dbentrydate` date DEFAULT NULL COMMENT "DB Entry Date НЕПОНЯТНО",
  `es_govdoclink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gov Doc Link",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_typesingle` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type Single",
  `es_typesinglenominativecasesingle` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type Single",
  `es_typesinglegen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Genitive case Single)",
  `es_typesingledat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Dative case Single)",
  `es_typesingledat2` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Dative case Single)2",
  `es_typesingleabl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Instrumental case Single)",
  `es_typesingleaccus` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Accusative case Single)",
  `es_typesingleprep` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type (Prepositional case Single)",
  `es_category` int UNSIGNED DEFAULT NULL COMMENT "Category"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig Visa Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisatypes` ADD PRIMARY KEY (`id`), ADD KEY `es_category` (`es_category`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisatypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migvisatypes`(`id`, `published`, `es_type`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_typesingle`, `es_typesinglenominativecasesingle`, `es_typesinglegen`, `es_typesingledat`, `es_typesingledat2`, `es_typesingleabl`, `es_typesingleaccus`, `es_typesingleprep`, `es_category`) SELECT `id`, `published`, `es_type`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_typesingle`, `es_typesinglenominativecasesingle`, `es_typesinglegen`, `es_typesingledat`, `es_typesingledat2`, `es_typesingleabl`, `es_typesingleaccus`, `es_typesingleprep`, `es_category` FROM `lwsp`.`h82im_customtables_table_migvisatypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_migvisitpurposes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_visatype` int UNSIGNED DEFAULT NULL COMMENT "Visa Type",
  `es_dbentrydate` date DEFAULT NULL COMMENT "DB Entry Date",
  `es_govdoclink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Gov Doc Link",
  `es_comment` text COLLATE utf8mb4_unicode_ci,
  `es_ornum` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Mig Visit Purposes";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisitpurposes` ADD PRIMARY KEY (`id`), ADD KEY `es_visatype` (`es_visatype`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_migvisitpurposes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_migvisitpurposes`(`id`, `published`, `es_name`, `es_visatype`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_ornum`) SELECT `id`, `published`, `es_name`, `es_visatype`, `es_dbentrydate`, `es_govdoclink`, `es_comment`, `es_ornum` FROM `lwsp`.`h82im_customtables_table_migvisitpurposes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_passissueauthorities` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Lat",
  `es_namerussubj` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusaccus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusabl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusprep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_namenative` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Native",
  `es_country` int UNSIGNED DEFAULT NULL COMMENT "Country",
  `es_place` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Place"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Passport Issue Authorities";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passissueauthorities` ADD PRIMARY KEY (`id`), ADD KEY `es_country` (`es_country`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passissueauthorities` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=239 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_passissueauthorities`(`id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusaccus`, `es_namerusabl`, `es_namerusprep`, `es_namenative`, `es_country`, `es_place`) SELECT `id`, `published`, `es_namelat`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusaccus`, `es_namerusabl`, `es_namerusprep`, `es_namenative`, `es_country`, `es_place` FROM `lwsp`.`h82im_customtables_table_passissueauthorities`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_passportprimarystatus` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Passport Primary Status";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passportprimarystatus` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passportprimarystatus` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_passportprimarystatus`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_passportprimarystatus`;

CREATE TABLE `lwsp-ct`.`h82im_customtables_table_passporttypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type",
  `es_type_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_type_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_type_ar` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_type_vi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Passport Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passporttypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passporttypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_passporttypes`(`id`, `published`, `es_type`, `es_type_ru`, `es_type_zh`, `es_type_ar`, `es_type_vi`) SELECT `id`, `published`, `es_type`, `es_type_ru`, `es_type_zh`, `es_type_ar`, `es_type_vi` FROM `lwsp`.`h82im_customtables_table_passporttypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_passvaliditystatus` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Passport Validity Status";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passvaliditystatus` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_passvaliditystatus` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_passvaliditystatus`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_passvaliditystatus`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_people` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_firstnamelat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Lat",
  `es_firstnamerussubj` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Subj",
  `es_firstnamerusgen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Gen",
  `es_firstnamerusdat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Dat",
  `es_firstnamerusabl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Abl",
  `es_firstnamerusaccus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Accus",
  `es_firstnamerusprep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Firstname Rus Prep",
  `es_frstnamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Frstname Native",
  `es_middlenamelat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Lat",
  `es_middlenamerussubj` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Subj",
  `es_middlenamerusgen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Gen",
  `es_middlenamerusdat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Dat",
  `es_middlenamerusabl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Abl",
  `es_middlenamerusaccus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Accus",
  `es_middlenamerusprep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Rus Prep",
  `es_middlenamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Middlename Native",
  `es_firstnamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_lastnamelat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Lat",
  `es_lastnamerussubj` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Subj",
  `es_lastnamerusgen` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Gen",
  `es_lastnamerusdat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Dat",
  `es_lastnamerusabl` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Abl",
  `es_lastnamerusaccus` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Accus",
  `es_lastnamerusprep` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Rus Prep",
  `es_lastnamenative` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Lastname Native",
  `es_dateofbirth` date DEFAULT NULL COMMENT "Date of birth",
  `es_translatepassports` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Passports",
  `es_photo` bigint DEFAULT NULL COMMENT "Photo",
  `es_documents` bigint UNSIGNED DEFAULT NULL COMMENT "Documents",
  `es_gender` int UNSIGNED DEFAULT NULL,
  `es_citizenshiptype` int UNSIGNED DEFAULT NULL,
  `es_ethnicity` int UNSIGNED DEFAULT NULL,
  `es_id` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_passports` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_fullnamelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_fullnamerus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_fullnamenative` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Full name native",
  `es_isemployee` tinyint NOT NULL DEFAULT "0" COMMENT "Is Employee",
  `es_idcopy` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "ID",
  `es_ismigrant` tinyint NOT NULL DEFAULT "0" COMMENT "Is migrant"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="People";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_people` ADD PRIMARY KEY (`id`), ADD KEY `es_gender` (`es_gender`), ADD KEY `es_citizenshiptype` (`es_citizenshiptype`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_people` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_people`(`id`, `published`, `es_firstnamelat`, `es_firstnamerussubj`, `es_firstnamerusgen`, `es_firstnamerusdat`, `es_firstnamerusabl`, `es_firstnamerusaccus`, `es_firstnamerusprep`, `es_frstnamenative`, `es_middlenamelat`, `es_middlenamerussubj`, `es_middlenamerusgen`, `es_middlenamerusdat`, `es_middlenamerusabl`, `es_middlenamerusaccus`, `es_middlenamerusprep`, `es_middlenamenative`, `es_firstnamenative`, `es_lastnamelat`, `es_lastnamerussubj`, `es_lastnamerusgen`, `es_lastnamerusdat`, `es_lastnamerusabl`, `es_lastnamerusaccus`, `es_lastnamerusprep`, `es_lastnamenative`, `es_dateofbirth`, `es_translatepassports`, `es_photo`, `es_documents`, `es_gender`, `es_citizenshiptype`, `es_ethnicity`, `es_id`, `es_passports`, `es_fullnamelat`, `es_fullnamerus`, `es_fullnamenative`, `es_isemployee`, `es_idcopy`, `es_ismigrant`) SELECT `id`, `published`, `es_firstnamelat`, `es_firstnamerussubj`, `es_firstnamerusgen`, `es_firstnamerusdat`, `es_firstnamerusabl`, `es_firstnamerusaccus`, `es_firstnamerusprep`, `es_frstnamenative`, `es_middlenamelat`, `es_middlenamerussubj`, `es_middlenamerusgen`, `es_middlenamerusdat`, `es_middlenamerusabl`, `es_middlenamerusaccus`, `es_middlenamerusprep`, `es_middlenamenative`, `es_firstnamenative`, `es_lastnamelat`, `es_lastnamerussubj`, `es_lastnamerusgen`, `es_lastnamerusdat`, `es_lastnamerusabl`, `es_lastnamerusaccus`, `es_lastnamerusprep`, `es_lastnamenative`, `es_dateofbirth`, `es_translatepassports`, `es_photo`, `es_documents`, `es_gender`, `es_citizenshiptype`, `es_ethnicity`, `es_id`, `es_passports`, `es_fullnamelat`, `es_fullnamerus`, `es_fullnamenative`, `es_isemployee`, `es_idcopy`, `es_ismigrant` FROM `lwsp`.`h82im_customtables_table_people`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_peoplesrussianvisas` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_dbentrydate` datetime DEFAULT NULL,
  `es_num` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Num",
  `es_issuedate` date DEFAULT NULL COMMENT "Issue Date",
  `es_visatermdates` int DEFAULT NULL COMMENT "Visa Term Date",
  `es_visatermdays` int UNSIGNED DEFAULT NULL,
  `es_multiplicity` int UNSIGNED DEFAULT NULL COMMENT "Multiplicity",
  `es_visatype` int UNSIGNED DEFAULT NULL COMMENT "Visa Type",
  `es_visitpurpose` int UNSIGNED DEFAULT NULL COMMENT "Visit Purpose",
  `es_invcompanyname` int UNSIGNED DEFAULT NULL COMMENT "Invitation Company name",
  `es_stayplace` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Stay Place",
  `es_loinum` int UNSIGNED DEFAULT NULL,
  `es_changedate` datetime DEFAULT NULL COMMENT "Change Date",
  `es_changedby` int UNSIGNED DEFAULT NULL COMMENT "Changed By",
  `es_birthdate` int UNSIGNED DEFAULT NULL COMMENT "Birthdate",
  `es_gender` int UNSIGNED DEFAULT NULL COMMENT "Gender",
  `es_passseries` int UNSIGNED DEFAULT NULL COMMENT "Passport series",
  `es_passnum` int UNSIGNED DEFAULT NULL COMMENT "Passport number",
  `es_multiplicitycopy` int UNSIGNED DEFAULT NULL COMMENT "Multiplicity",
  `es_firstnamelat` int UNSIGNED DEFAULT NULL COMMENT "First name latin",
  `es_firstnamerus` int UNSIGNED DEFAULT NULL COMMENT "First name russian",
  `es_fullnamelat` int UNSIGNED DEFAULT NULL COMMENT "Full name latin",
  `es_fullnamerus` int UNSIGNED DEFAULT NULL COMMENT "First name russian",
  `es_person` int UNSIGNED DEFAULT NULL COMMENT "Person",
  `es_passport` int UNSIGNED DEFAULT NULL COMMENT "Passport",
  `es_visaenddate` date DEFAULT NULL COMMENT "Visa End Date"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Russian Visas";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_peoplesrussianvisas` ADD PRIMARY KEY (`id`), ADD KEY `es_multiplicity` (`es_multiplicity`), ADD KEY `es_visatype` (`es_visatype`), ADD KEY `es_visitpurpose` (`es_visitpurpose`), ADD KEY `es_invcompanyname` (`es_invcompanyname`), ADD KEY `es_changedby` (`es_changedby`), ADD KEY `es_birthdate` (`es_birthdate`), ADD KEY `es_gender` (`es_gender`), ADD KEY `es_passseries` (`es_passseries`), ADD KEY `es_passnum` (`es_passnum`), ADD KEY `es_multiplicitycopy` (`es_multiplicitycopy`), ADD KEY `es_firstnamelat` (`es_firstnamelat`), ADD KEY `es_firstnamerus` (`es_firstnamerus`), ADD KEY `es_fullnamelat` (`es_fullnamelat`), ADD KEY `es_fullnamerus` (`es_fullnamerus`), ADD KEY `es_person` (`es_person`), ADD KEY `es_passport` (`es_passport`), ADD KEY `es_loinum` (`es_loinum`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_peoplesrussianvisas` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_peoplesrussianvisas`(`id`, `published`, `es_dbentrydate`, `es_num`, `es_issuedate`, `es_visatermdates`, `es_visatermdays`, `es_multiplicity`, `es_visatype`, `es_visitpurpose`, `es_invcompanyname`, `es_stayplace`, `es_loinum`, `es_changedate`, `es_changedby`, `es_birthdate`, `es_gender`, `es_passseries`, `es_passnum`, `es_multiplicitycopy`, `es_firstnamelat`, `es_firstnamerus`, `es_fullnamelat`, `es_fullnamerus`, `es_person`, `es_passport`, `es_visaenddate`) SELECT `id`, `published`, `es_dbentrydate`, `es_num`, `es_issuedate`, `es_visatermdates`, `es_visatermdays`, `es_multiplicity`, `es_visatype`, `es_visitpurpose`, `es_invcompanyname`, `es_stayplace`, `es_loinum`, `es_changedate`, `es_changedby`, `es_birthdate`, `es_gender`, `es_passseries`, `es_passnum`, `es_multiplicitycopy`, `es_firstnamelat`, `es_firstnamerus`, `es_fullnamelat`, `es_fullnamerus`, `es_person`, `es_passport`, `es_visaenddate` FROM `lwsp`.`h82im_customtables_table_peoplesrussianvisas`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_persontypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Type",
  `es_type_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Person Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_persontypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_persontypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_persontypes`(`id`, `published`, `es_type`, `es_type_ru`) SELECT `id`, `published`, `es_type`, `es_type_ru` FROM `lwsp`.`h82im_customtables_table_persontypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_placescities` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namerussubj` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusaccus` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_namelat` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Lat",
  `es_namenative` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Native",
  `es_country` int UNSIGNED DEFAULT NULL COMMENT "Country",
  `es_nativelang` int UNSIGNED DEFAULT NULL COMMENT "Native Language",
  `es_coordinates` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Coordinates",
  `es_capitalstatus` int UNSIGNED DEFAULT NULL COMMENT "Capital Status",
  `es_consstatus` int UNSIGNED DEFAULT NULL COMMENT "Consulate Status",
  `es_consaddresslat` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Consulate Address Lat",
  `es_consaddressrus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Consulate Address Rus",
  `es_consweb` varchar(1024) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Consulate Website",
  `es_comment` text COLLATE utf8mb4_unicode_ci COMMENT "Comment"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Places cities";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_placescities` ADD PRIMARY KEY (`id`), ADD KEY `es_country` (`es_country`), ADD KEY `es_nativelang` (`es_nativelang`), ADD KEY `es_capitalstatus` (`es_capitalstatus`), ADD KEY `es_consstatus` (`es_consstatus`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_placescities` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_placescities`(`id`, `published`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namelat`, `es_namenative`, `es_country`, `es_nativelang`, `es_coordinates`, `es_capitalstatus`, `es_consstatus`, `es_consaddresslat`, `es_consaddressrus`, `es_consweb`, `es_comment`) SELECT `id`, `published`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namelat`, `es_namenative`, `es_country`, `es_nativelang`, `es_coordinates`, `es_capitalstatus`, `es_consstatus`, `es_consaddresslat`, `es_consaddressrus`, `es_consweb`, `es_comment` FROM `lwsp`.`h82im_customtables_table_placescities`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_positions` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(255) DEFAULT NULL COMMENT "Name Lat",
  `es_namerussubj` varchar(255) DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namelat_ru` varchar(255) DEFAULT NULL,
  `es_namerusgen` varchar(255) DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(255) DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(255) DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusaccus` varchar(255) DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(255) DEFAULT NULL COMMENT "Name Rus Prep",
  `es_comment` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci COMMENT="Positions";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_positions` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_positions` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_positions`(`id`, `published`, `es_namelat`, `es_namerussubj`, `es_namelat_ru`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_comment`) SELECT `id`, `published`, `es_namelat`, `es_namerussubj`, `es_namelat_ru`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_comment` FROM `lwsp`.`h82im_customtables_table_positions`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_purposes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Title",
  `es_title_ru` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_title_zh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Purposes";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_purposes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_purposes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_purposes`(`id`, `published`, `es_title`, `es_title_ru`, `es_title_zh`) SELECT `id`, `published`, `es_title`, `es_title_ru`, `es_title_zh` FROM `lwsp`.`h82im_customtables_table_purposes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_regions` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name",
  `es_code` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `es_region` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Region",
  `es_federaldistrict` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Federal district"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Regions";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_regions` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_regions` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_regions`(`id`, `published`, `es_name`, `es_code`, `es_region`, `es_federaldistrict`) SELECT `id`, `published`, `es_name`, `es_code`, `es_region`, `es_federaldistrict` FROM `lwsp`.`h82im_customtables_table_regions`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_rfconsulatestatus` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Russian Federation Consulate Status";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_rfconsulatestatus` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_rfconsulatestatus` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_rfconsulatestatus`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_rfconsulatestatus`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_stayplaces` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Full Name",
  `es_region` int UNSIGNED DEFAULT NULL COMMENT "Region",
  `es_typeofstay` int UNSIGNED DEFAULT NULL COMMENT "Type of Stay",
  `es_city` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "City / Town",
  `es_district` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "District",
  `es_typeofdistrict` int UNSIGNED DEFAULT NULL COMMENT "Type of District",
  `es_street` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Street",
  `es_house` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "House",
  `es_housing` int UNSIGNED DEFAULT NULL COMMENT "Housing",
  `es_building` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Building",
  `es_flat` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Flat",
  `es_phone` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Phone",
  `es_details` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Details",
  `es_streettype` int UNSIGNED DEFAULT NULL COMMENT "Street type",
  `es_housetype` int UNSIGNED DEFAULT NULL COMMENT "House Type",
  `es_typeofpremisses` int UNSIGNED DEFAULT NULL COMMENT "Type of premisses",
  `es_typeofinnerpremisses` int UNSIGNED DEFAULT NULL COMMENT "Type of innerpremisses",
  `es_innerpremissesn` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Inner premissesn",
  `es_address` int UNSIGNED DEFAULT NULL COMMENT "Address",
  `es_premtype` int UNSIGNED DEFAULT NULL,
  `es_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Stay Places";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_stayplaces` ADD PRIMARY KEY (`id`), ADD KEY `es_region` (`es_region`), ADD KEY `es_typeofstay` (`es_typeofstay`), ADD KEY `es_streettype` (`es_streettype`), ADD KEY `es_housetype` (`es_housetype`), ADD KEY `es_housing` (`es_housing`), ADD KEY `es_typeofdistrict` (`es_typeofdistrict`), ADD KEY `es_typeofpremisses` (`es_typeofpremisses`), ADD KEY `es_typeofinnerpremisses` (`es_typeofinnerpremisses`), ADD KEY `es_address` (`es_address`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_stayplaces` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_stayplaces`(`id`, `published`, `es_fullname`, `es_region`, `es_typeofstay`, `es_city`, `es_district`, `es_typeofdistrict`, `es_street`, `es_house`, `es_housing`, `es_building`, `es_flat`, `es_phone`, `es_details`, `es_streettype`, `es_housetype`, `es_typeofpremisses`, `es_typeofinnerpremisses`, `es_innerpremissesn`, `es_address`, `es_premtype`, `es_comment`) SELECT `id`, `published`, `es_fullname`, `es_region`, `es_typeofstay`, `es_city`, `es_district`, `es_typeofdistrict`, `es_street`, `es_house`, `es_housing`, `es_building`, `es_flat`, `es_phone`, `es_details`, `es_streettype`, `es_housetype`, `es_typeofpremisses`, `es_typeofinnerpremisses`, `es_innerpremissesn`, `es_address`, `es_premtype`, `es_comment` FROM `lwsp`.`h82im_customtables_table_stayplaces`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_staytypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Stay Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_staytypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_staytypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_staytypes`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_staytypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_streettypes` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Street Types";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_streettypes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_streettypes` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_streettypes`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_streettypes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_testtable` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="TEST TABLE";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_testtable` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_testtable` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_testtable`(`id`, `published`) SELECT `id`, `published` FROM `lwsp`.`h82im_customtables_table_testtable`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_type` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Type";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_type` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_type` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_type`(`id`, `published`) SELECT `id`, `published` FROM `lwsp`.`h82im_customtables_table_type`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_typeofinnerpremisses` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Type of Innerpremisses";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typeofinnerpremisses` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typeofinnerpremisses` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_typeofinnerpremisses`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_typeofinnerpremisses`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_typeofpremisses` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Type of premisses";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typeofpremisses` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typeofpremisses` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_typeofpremisses`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_typeofpremisses`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_typesofdistrict` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(25) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Types of district";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typesofdistrict` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_typesofdistrict` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_typesofdistrict`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_typesofdistrict`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_visas` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_worker` int UNSIGNED DEFAULT NULL COMMENT "Worker",
  `es_countryofissue` int UNSIGNED DEFAULT NULL COMMENT "Country of Issue",
  `es_placeofresidence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Place of Residence",
  `es_addressofresidence` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Address of Residence",
  `es_dateofentry` date DEFAULT NULL COMMENT "Date of Entry",
  `es_dateofexit` date DEFAULT NULL COMMENT "Date of Exit",
  `es_placeofvisacity` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "PLACE OF VISA CITY",
  `es_finaldateforvisa` date DEFAULT NULL COMMENT "FINAL DATE FOR VISA",
  `es_visitlocations` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Visit Locations",
  `es_visamultiplicity` int UNSIGNED DEFAULT NULL COMMENT "Visa Multiplicity",
  `es_period` int DEFAULT NULL COMMENT "Period",
  `es_purpose` int UNSIGNED DEFAULT NULL COMMENT "Purpose",
  `es_lastnamelat` int UNSIGNED DEFAULT NULL COMMENT "Last name latin",
  `es_fullnamelat` int UNSIGNED DEFAULT NULL COMMENT "Full name latin"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Visas (Unused)";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_visas` ADD PRIMARY KEY (`id`), ADD KEY `es_worker` (`es_worker`), ADD KEY `es_countryofissue` (`es_countryofissue`), ADD KEY `es_visamultiplicity` (`es_visamultiplicity`), ADD KEY `es_purpose` (`es_purpose`), ADD KEY `es_lastnamelat` (`es_lastnamelat`), ADD KEY `es_fullnamelat` (`es_fullnamelat`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_visas` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_visas`(`id`, `published`, `es_worker`, `es_countryofissue`, `es_placeofresidence`, `es_addressofresidence`, `es_dateofentry`, `es_dateofexit`, `es_placeofvisacity`, `es_finaldateforvisa`, `es_visitlocations`, `es_visamultiplicity`, `es_period`, `es_purpose`, `es_lastnamelat`, `es_fullnamelat`) SELECT `id`, `published`, `es_worker`, `es_countryofissue`, `es_placeofresidence`, `es_addressofresidence`, `es_dateofentry`, `es_dateofexit`, `es_placeofvisacity`, `es_finaldateforvisa`, `es_visitlocations`, `es_visamultiplicity`, `es_period`, `es_purpose`, `es_lastnamelat`, `es_fullnamelat` FROM `lwsp`.`h82im_customtables_table_visas`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_visatypecategories` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_name` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Visa Type Categories";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_visatypecategories` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_visatypecategories` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_visatypecategories`(`id`, `published`, `es_name`) SELECT `id`, `published`, `es_name` FROM `lwsp`.`h82im_customtables_table_visatypecategories`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_workers` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_fullname` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Full Name",
  `es_document` int UNSIGNED DEFAULT NULL COMMENT "Document",
  `es_persontype` int UNSIGNED DEFAULT NULL COMMENT "Person Type"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Workers";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_workers` ADD PRIMARY KEY (`id`), ADD KEY `es_document` (`es_document`), ADD KEY `es_persontype` (`es_persontype`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_workers` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_workers`(`id`, `published`, `es_fullname`, `es_document`, `es_persontype`) SELECT `id`, `published`, `es_fullname`, `es_document`, `es_persontype` FROM `lwsp`.`h82im_customtables_table_workers`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_workhours` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_date` date DEFAULT NULL,
  `es_startwork` int DEFAULT NULL,
  `es_finishwork` int DEFAULT NULL,
  `es_whatmade` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `es_hours` decimal(20,2) DEFAULT NULL,
  `es_ordering` int UNSIGNED NOT NULL DEFAULT "0" COMMENT "Ordering",
  `es_images` bigint UNSIGNED DEFAULT NULL COMMENT "Images"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="work hours";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_workhours` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_workhours` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_workhours`(`id`, `published`, `es_date`, `es_startwork`, `es_finishwork`, `es_whatmade`, `es_hours`, `es_ordering`, `es_images`) SELECT `id`, `published`, `es_date`, `es_startwork`, `es_finishwork`, `es_whatmade`, `es_hours`, `es_ordering`, `es_images` FROM `lwsp`.`h82im_customtables_table_workhours`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_worldregions` (
`id` int UNSIGNED NOT NULL,
  `published` tinyint(1) NOT NULL DEFAULT "1",
  `es_namelat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Lat",
  `es_country` int UNSIGNED DEFAULT NULL COMMENT "Country",
  `es_namerussubj` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Subj",
  `es_namerusgen` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Gen",
  `es_namerusdat` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Dat",
  `es_namerusabl` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Abl",
  `es_namerusaccus` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Accus",
  `es_namerusprep` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Rus Prep",
  `es_namenative` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Name Native",
  `es_nativelang` int UNSIGNED DEFAULT NULL COMMENT "Native Lang",
  `es_coord` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Coordinates",
  `es_googlelink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Google Link",
  `es_comment` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="World Regions";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_worldregions` ADD PRIMARY KEY (`id`), ADD KEY `es_country` (`es_country`), ADD KEY `es_nativelang` (`es_nativelang`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_worldregions` MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_worldregions`(`id`, `published`, `es_namelat`, `es_country`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namenative`, `es_nativelang`, `es_coord`, `es_googlelink`, `es_comment`) SELECT `id`, `published`, `es_namelat`, `es_country`, `es_namerussubj`, `es_namerusgen`, `es_namerusdat`, `es_namerusabl`, `es_namerusaccus`, `es_namerusprep`, `es_namenative`, `es_nativelang`, `es_coord`, `es_googlelink`, `es_comment` FROM `lwsp`.`h82im_customtables_table_worldregions`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerycategories` (
`id` int NOT NULL,
  `published` tinyint(1) DEFAULT "1",
  `es_categoryname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Category Name",
  `es_parentid` int UNSIGNED DEFAULT NULL COMMENT "Parent",
  `es_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Description",
  `es_image` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Image"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Youtube Gallery Categories";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerycategories` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerycategories` MODIFY `id` int NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_youtubegallerycategories`(`id`, `published`, `es_categoryname`, `es_parentid`, `es_description`, `es_image`) SELECT `id`, `published`, `es_categoryname`, `es_parentid`, `es_description`, `es_image` FROM `lwsp`.`h82im_customtables_table_youtubegallerycategories`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerysettings` (
`id` int NOT NULL,
  `published` tinyint(1) DEFAULT "1",
  `es_option` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Option",
  `es_value` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Value"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Youtube Gallery Settings";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerysettings` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerysettings` MODIFY `id` int NOT NULL AUTO_INCREMENT;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_youtubegallerysettings`(`id`, `published`, `es_option`, `es_value`) SELECT `id`, `published`, `es_option`, `es_value` FROM `lwsp`.`h82im_customtables_table_youtubegallerysettings`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerythemes` (
`id` int NOT NULL,
  `published` tinyint(1) DEFAULT "1",
  `es_themename` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Theme name",
  `es_width` int DEFAULT NULL COMMENT "Player Area Width",
  `es_height` int DEFAULT NULL COMMENT "Player Area Height",
  `es_playvideo` tinyint NOT NULL DEFAULT "0" COMMENT "Show First Video",
  `es_orderby` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Order By",
  `es_customlimit` int DEFAULT NULL COMMENT "Pagination Limit",
  `es_navbarstyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Navigation bar CSS Style",
  `es_bgcolor` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Thumbnail Background color",
  `es_thumbnailstyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Thumbnail CSS Style",
  `es_listnamestyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Video List Name CSS Style",
  `es_activevideotitlestyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Active Video Title CSS Style",
  `es_descrstyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Active Video Description CSS Style",
  `es_cssstyle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "CSS Style",
  `es_autoplay` tinyint NOT NULL DEFAULT "0" COMMENT "Autoplay",
  `es_repeat` tinyint NOT NULL DEFAULT "0" COMMENT " Repeat (loop single video)",
  `es_fullscreen` tinyint NOT NULL DEFAULT "0" COMMENT "Fullscreen",
  `es_allowplaylist` tinyint NOT NULL DEFAULT "0" COMMENT "Allow Playlist",
  `es_related` tinyint NOT NULL DEFAULT "0" COMMENT "Related Videos",
  `es_controls` tinyint NOT NULL DEFAULT "0" COMMENT "Controls",
  `es_border` tinyint NOT NULL DEFAULT "0" COMMENT "Show Border",
  `es_colorone` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Primary Border Color",
  `es_colortwo` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT " Mute Player Yes No Initial Volume (0-100), -1 for system default Youtube Parameters",
  `es_muteonplay` tinyint NOT NULL DEFAULT "0" COMMENT "Mute Player",
  `es_volume` int DEFAULT NULL COMMENT "Initial Volume (0-100), -1 for system default",
  `es_youtubeparams` varchar(450) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Youtube Parameters",
  `es_customlayout` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Custom Layout",
  `es_customnavlayout` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Thumbnail Layout",
  `es_headscript` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "HTML document head script",
  `es_openinnewwindow` int DEFAULT NULL COMMENT "Switch Video As",
  `es_rel` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Rel option to apply any shadow/lightbox",
  `es_hrefaddon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "HREF addon",
  `es_useglass` tinyint NOT NULL DEFAULT "0" COMMENT "Use glass cover",
  `es_logocover` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Logo Cover",
  `es_prepareheadtags` int DEFAULT NULL COMMENT "Prepare Head Tags",
  `es_changepagetitle` int DEFAULT NULL COMMENT "Change Page Title",
  `es_responsive` int DEFAULT NULL COMMENT "Responsive",
  `es_nocookie` tinyint NOT NULL DEFAULT "0" COMMENT "No Cookie",
  `es_mediafolder` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Media Folder",
  `es_themedescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Theme Description"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Youtube Gallery Themes";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerythemes` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegallerythemes` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_youtubegallerythemes`(`id`, `published`, `es_themename`, `es_width`, `es_height`, `es_playvideo`, `es_orderby`, `es_customlimit`, `es_navbarstyle`, `es_bgcolor`, `es_thumbnailstyle`, `es_listnamestyle`, `es_activevideotitlestyle`, `es_descrstyle`, `es_cssstyle`, `es_autoplay`, `es_repeat`, `es_fullscreen`, `es_allowplaylist`, `es_related`, `es_controls`, `es_border`, `es_colorone`, `es_colortwo`, `es_muteonplay`, `es_volume`, `es_youtubeparams`, `es_customlayout`, `es_customnavlayout`, `es_headscript`, `es_openinnewwindow`, `es_rel`, `es_hrefaddon`, `es_useglass`, `es_logocover`, `es_prepareheadtags`, `es_changepagetitle`, `es_responsive`, `es_nocookie`, `es_mediafolder`, `es_themedescription`) SELECT `id`, `published`, `es_themename`, `es_width`, `es_height`, `es_playvideo`, `es_orderby`, `es_customlimit`, `es_navbarstyle`, `es_bgcolor`, `es_thumbnailstyle`, `es_listnamestyle`, `es_activevideotitlestyle`, `es_descrstyle`, `es_cssstyle`, `es_autoplay`, `es_repeat`, `es_fullscreen`, `es_allowplaylist`, `es_related`, `es_controls`, `es_border`, `es_colorone`, `es_colortwo`, `es_muteonplay`, `es_volume`, `es_youtubeparams`, `es_customlayout`, `es_customnavlayout`, `es_headscript`, `es_openinnewwindow`, `es_rel`, `es_hrefaddon`, `es_useglass`, `es_logocover`, `es_prepareheadtags`, `es_changepagetitle`, `es_responsive`, `es_nocookie`, `es_mediafolder`, `es_themedescription` FROM `lwsp`.`h82im_customtables_table_youtubegallerythemes`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideolists` (
`id` int NOT NULL,
  `published` tinyint(1) DEFAULT "1",
  `es_listname` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "List Name",
  `es_videolist` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Video Links (Source)",
  `es_catid` int UNSIGNED DEFAULT NULL COMMENT "Category",
  `es_updateperiod` decimal(20,5) DEFAULT NULL COMMENT "Cache Update Period",
  `es_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Video List Description",
  `es_authorurl` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Link to the author page",
  `es_watchusergroup` int UNSIGNED DEFAULT NULL COMMENT " Who may watch the Videos",
  `es_image` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Image",
  `es_note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Additional Note",
  `es_lastplaylistupdate` datetime DEFAULT NULL COMMENT "Last playlist update time"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Youtube Gallery Video Lists ";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideolists` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideolists` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideolists`(`id`, `published`, `es_listname`, `es_videolist`, `es_catid`, `es_updateperiod`, `es_description`, `es_authorurl`, `es_watchusergroup`, `es_image`, `es_note`, `es_lastplaylistupdate`) SELECT `id`, `published`, `es_listname`, `es_videolist`, `es_catid`, `es_updateperiod`, `es_description`, `es_authorurl`, `es_watchusergroup`, `es_image`, `es_note`, `es_lastplaylistupdate` FROM `lwsp`.`h82im_customtables_table_youtubegalleryvideolists`;
CREATE TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideos` (
`id` int NOT NULL,
  `published` tinyint(1) DEFAULT "1",
  `es_videosource` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Video Source",
  `es_videoid` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Video ID",
  `es_imageurl` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Image URL",
  `es_description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Description",
  `es_customimageurl` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Custom Image URL",
  `es_customtitle` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Custom Title",
  `es_customdescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Custom Description",
  `es_specialparams` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Special Params",
  `es_lastupdate` datetime DEFAULT NULL COMMENT "Last Update ",
  `es_allowupdates` tinyint NOT NULL DEFAULT "0" COMMENT "Allow Updates",
  `es_status` int DEFAULT NULL COMMENT "Status",
  `es_isvideo` tinyint NOT NULL DEFAULT "0" COMMENT "Is Video",
  `es_link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Link",
  `es_ordering` int DEFAULT NULL COMMENT "Ordering",
  `es_publisheddate` datetime DEFAULT NULL COMMENT "Published Date",
  `es_duration` int DEFAULT NULL COMMENT "Duration",
  `es_ratingaverage` decimal(20,2) DEFAULT NULL COMMENT "Rating Average",
  `es_ratingmax` int DEFAULT NULL COMMENT "Rating Max",
  `es_ratingmin` int DEFAULT NULL COMMENT "Rating Min",
  `es_ratingnumberofraters` int DEFAULT NULL COMMENT "Rating Number of Raters",
  `es_statisticsfavoritecount` int DEFAULT NULL COMMENT "Statistics Favorite Count",
  `es_statisticsviewcount` int DEFAULT NULL COMMENT "StatisticsView Count",
  `es_keywords` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Keywords",
  `es_startsecond` int DEFAULT NULL COMMENT "Start Second ",
  `es_endsecond` int DEFAULT NULL COMMENT "End Second",
  `es_likes` int DEFAULT NULL COMMENT "Likes",
  `es_dislikes` int DEFAULT NULL COMMENT "Dislikes",
  `es_commentcount` int DEFAULT NULL COMMENT "Comment Count ",
  `es_channelusername` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Channel Username",
  `es_channeltitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Channel Title",
  `es_channelsubscribers` int DEFAULT NULL COMMENT "Channel Subscribers",
  `es_channelsubscribed` int DEFAULT NULL COMMENT "Channel Subscribed",
  `es_channellocation` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Channel Location",
  `es_channelcommentcount` int DEFAULT NULL COMMENT "Channel Comment Count",
  `es_channelviewcount` int DEFAULT NULL COMMENT "Channel Viewcount",
  `es_channelvideocount` int DEFAULT NULL COMMENT "Channel Videocount",
  `es_channeldescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Channel Description",
  `es_alias` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Alias",
  `es_rawdata` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Rawdata",
  `es_datalink` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Data Link",
  `es_error` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Error",
  `es_title` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Title",
  `es_trackid` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT "Track ID",
  `es_videoids` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci COMMENT "Video IDs",
  `es_latitude` decimal(20,7) DEFAULT NULL COMMENT "Latitude",
  `es_longitude` decimal(20,7) DEFAULT NULL COMMENT "Longitude",
  `es_altitude` int DEFAULT NULL COMMENT "Altitude",
  `es_videolist` int UNSIGNED DEFAULT NULL COMMENT "listid",
  `es_parentid` int UNSIGNED DEFAULT NULL COMMENT "Parent (Playlist or Channel)"
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT="Youtube Gallery Videos";
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideos` ADD PRIMARY KEY (`id`);
ALTER TABLE `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideos` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_customtables_table_youtubegalleryvideos`(`id`, `published`, `es_videosource`, `es_videoid`, `es_imageurl`, `es_description`, `es_customimageurl`, `es_customtitle`, `es_customdescription`, `es_specialparams`, `es_lastupdate`, `es_allowupdates`, `es_status`, `es_isvideo`, `es_link`, `es_ordering`, `es_publisheddate`, `es_duration`, `es_ratingaverage`, `es_ratingmax`, `es_ratingmin`, `es_ratingnumberofraters`, `es_statisticsfavoritecount`, `es_statisticsviewcount`, `es_keywords`, `es_startsecond`, `es_endsecond`, `es_likes`, `es_dislikes`, `es_commentcount`, `es_channelusername`, `es_channeltitle`, `es_channelsubscribers`, `es_channelsubscribed`, `es_channellocation`, `es_channelcommentcount`, `es_channelviewcount`, `es_channelvideocount`, `es_channeldescription`, `es_alias`, `es_rawdata`, `es_datalink`, `es_error`, `es_title`, `es_trackid`, `es_videoids`, `es_latitude`, `es_longitude`, `es_altitude`, `es_videolist`, `es_parentid`) SELECT `id`, `published`, `es_videosource`, `es_videoid`, `es_imageurl`, `es_description`, `es_customimageurl`, `es_customtitle`, `es_customdescription`, `es_specialparams`, `es_lastupdate`, `es_allowupdates`, `es_status`, `es_isvideo`, `es_link`, `es_ordering`, `es_publisheddate`, `es_duration`, `es_ratingaverage`, `es_ratingmax`, `es_ratingmin`, `es_ratingnumberofraters`, `es_statisticsfavoritecount`, `es_statisticsviewcount`, `es_keywords`, `es_startsecond`, `es_endsecond`, `es_likes`, `es_dislikes`, `es_commentcount`, `es_channelusername`, `es_channeltitle`, `es_channelsubscribers`, `es_channelsubscribed`, `es_channellocation`, `es_channelcommentcount`, `es_channelviewcount`, `es_channelvideocount`, `es_channeldescription`, `es_alias`, `es_rawdata`, `es_datalink`, `es_error`, `es_title`, `es_trackid`, `es_videoids`, `es_latitude`, `es_longitude`, `es_altitude`, `es_videolist`, `es_parentid` FROM `lwsp`.`h82im_customtables_table_youtubegalleryvideos`;
CREATE TABLE `lwsp-ct`.`h82im_menu` (
`id` int NOT NULL,
  `menutype` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The type of menu this item belongs to. FK to #__menu_types.menutype",
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The display title of the menu item.",
  `alias` varchar(400) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL COMMENT "The SEF alias of the menu item.",
  `note` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "",
  `path` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The computed path of the menu item based on the alias field.",
  `link` varchar(1024) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The actually link the menu item refers to.",
  `type` varchar(16) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The type of link: Component, URL, Alias, Separator",
  `published` tinyint NOT NULL DEFAULT "0" COMMENT "The published state of the menu link.",
  `parent_id` int UNSIGNED NOT NULL DEFAULT "1" COMMENT "The parent menu item in the menu tree.",
  `level` int UNSIGNED NOT NULL DEFAULT "0" COMMENT "The relative level in the tree.",
  `component_id` int UNSIGNED NOT NULL DEFAULT "0" COMMENT "FK to #__extensions.id",
  `checked_out` int UNSIGNED DEFAULT NULL COMMENT "FK to #__users.id",
  `checked_out_time` datetime DEFAULT NULL COMMENT "The time the menu item was checked out.",
  `browserNav` tinyint NOT NULL DEFAULT "0" COMMENT "The click behaviour of the link.",
  `access` int UNSIGNED NOT NULL DEFAULT "0" COMMENT "The access level required to view the menu item.",
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "The image of the menu item.",
  `template_style_id` int UNSIGNED NOT NULL DEFAULT "0",
  `params` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT "JSON encoded data for the menu item.",
  `lft` int NOT NULL DEFAULT "0" COMMENT "Nested set lft.",
  `rgt` int NOT NULL DEFAULT "0" COMMENT "Nested set rgt.",
  `home` tinyint UNSIGNED NOT NULL DEFAULT "0" COMMENT "Indicates if this menu item is the home or default page.",
  `language` char(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT "",
  `client_id` tinyint NOT NULL DEFAULT "0",
  `publish_up` datetime DEFAULT NULL,
  `publish_down` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
ALTER TABLE `lwsp-ct`.`h82im_menu` ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `idx_client_id_parent_id_alias_language` (`client_id`,`parent_id`,`alias`(100),`language`), ADD KEY `idx_componentid` (`component_id`,`menutype`,`published`,`access`), ADD KEY `idx_menutype` (`menutype`), ADD KEY `idx_left_right` (`lft`,`rgt`), ADD KEY `idx_alias` (`alias`(100)), ADD KEY `idx_path` (`path`(100)), ADD KEY `idx_language` (`language`);
ALTER TABLE `lwsp-ct`.`h82im_menu` MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3781 ;

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

INSERT INTO `lwsp-ct`.`h82im_menu`(`id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`, `publish_up`, `publish_down`) SELECT `id`, `menutype`, `title`, `alias`, `note`, `path`, `link`, `type`, `published`, `parent_id`, `level`, `component_id`, `checked_out`, `checked_out_time`, `browserNav`, `access`, `img`, `template_style_id`, `params`, `lft`, `rgt`, `home`, `language`, `client_id`, `publish_up`, `publish_down` FROM `lwsp`.`h82im_menu`;
';
$result = $conn->query($query);

    echo "Tables copied<br/>";
    }

function dropTables($servername, $username, $password)
{
    $dbname = "lwsp-ct";
    $conn = new mysqli($servername, $username, $password,$dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $query='DROP TABLE `h82im_customtables_categories`, `h82im_customtables_fields`, `h82im_customtables_filebox_companies_compcontracts`, `h82im_customtables_filebox_companies_documents`, `h82im_customtables_filebox_companies_shared`, `h82im_customtables_filebox_contracts_files`, `h82im_customtables_filebox_migmvdlois_files`, `h82im_customtables_filebox_migmvdlois_folderlink`, `h82im_customtables_filebox_migmvdspeedupletters_speedletdocs`, `h82im_customtables_filebox_migmvdspeedupletters_speedletdocslink`, `h82im_customtables_filebox_migprojectcases_files`, `h82im_customtables_filebox_migrelministryenqletters_docs`, `h82im_customtables_filebox_people_documents`, `h82im_customtables_gallery_workhours_images`, `h82im_customtables_layouts`, `h82im_customtables_log`, `h82im_customtables_options`, `h82im_customtables_tables`, `h82im_customtables_table_applications`, `h82im_customtables_table_capitalstatus`, `h82im_customtables_table_citizenshiptypes`, `h82im_customtables_table_companies`, `h82im_customtables_table_companyemployees`, `h82im_customtables_table_contracts`, `h82im_customtables_table_countries`, `h82im_customtables_table_currencies`, `h82im_customtables_table_developmentprogress`, `h82im_customtables_table_divtypes`, `h82im_customtables_table_documents`, `h82im_customtables_table_emp_id`, `h82im_customtables_table_eststat`, `h82im_customtables_table_ethnicity`, `h82im_customtables_table_genders`, `h82im_customtables_table_housetypes`, `h82im_customtables_table_housingtype`, `h82im_customtables_table_languages`, `h82im_customtables_table_migdocumentsmisc`, `h82im_customtables_table_migdocumentstypes`, `h82im_customtables_table_migmidcompanyloiletters`, `h82im_customtables_table_migmvdapplications`, `h82im_customtables_table_migmvdapplicationssub`, `h82im_customtables_table_migmvdcorrletters`, `h82im_customtables_table_migmvdemplists`, `h82im_customtables_table_migmvdguaranteeletters`, `h82im_customtables_table_migmvdloidocstatuses`, `h82im_customtables_table_migmvdlois`, `h82im_customtables_table_migmvdspeedupletters`, `h82im_customtables_table_migprojectbatches`, `h82im_customtables_table_migprojectcases`, `h82im_customtables_table_migprojectcoverletters`, `h82im_customtables_table_migprojects`, `h82im_customtables_table_migprojectsemployees`, `h82im_customtables_table_migprojectsites`, `h82im_customtables_table_migrelministryenqletterlist`, `h82im_customtables_table_migrelministryenqletters`, `h82im_customtables_table_migvisamultiplicityterm`, `h82im_customtables_table_migvisatypes`, `h82im_customtables_table_migvisitpurposes`, `h82im_customtables_table_passissueauthorities`, `h82im_customtables_table_passportprimarystatus`, `h82im_customtables_table_passporttypes`, `h82im_customtables_table_passvaliditystatus`, `h82im_customtables_table_people`, `h82im_customtables_table_peoplesrussianvisas`, `h82im_customtables_table_persontypes`, `h82im_customtables_table_placescities`, `h82im_customtables_table_positions`, `h82im_customtables_table_purposes`, `h82im_customtables_table_regions`, `h82im_customtables_table_rfconsulatestatus`, `h82im_customtables_table_stayplaces`, `h82im_customtables_table_staytypes`, `h82im_customtables_table_streettypes`, `h82im_customtables_table_testtable`, `h82im_customtables_table_type`, `h82im_customtables_table_typeofinnerpremisses`, `h82im_customtables_table_typeofpremisses`, `h82im_customtables_table_typesofdistrict`, `h82im_customtables_table_visas`, `h82im_customtables_table_visatypecategories`, `h82im_customtables_table_workers`, `h82im_customtables_table_workhours`, `h82im_customtables_table_worldregions`, `h82im_customtables_table_youtubegallerycategories`, `h82im_customtables_table_youtubegallerysettings`, `h82im_customtables_table_youtubegallerythemes`, `h82im_customtables_table_youtubegalleryvideolists`, `h82im_customtables_table_youtubegalleryvideos`, `h82im_menu`;';
    $result = $conn->query($query);

    echo "Tables dropped<br/>";
}