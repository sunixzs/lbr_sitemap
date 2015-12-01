#
# Table structure for table 'pages'
#
CREATE TABLE pages (
	tx_lbrsitemap_description text NOT NULL,
	tx_lbrsitemap_image int(11) unsigned NOT NULL default '0',
	tx_lbrsitemap_changefreq  varchar(7) DEFAULT '' NOT NULL,
	tx_lbrsitemap_priority  varchar(3) DEFAULT '' NOT NULL,
);

#
# Table structure for table 'pages_language_overlay'
#
CREATE TABLE pages_language_overlay (
	tx_lbrsitemap_description text NOT NULL,
	tx_lbrsitemap_image int(11) unsigned NOT NULL default '0',
	tx_lbrsitemap_changefreq  varchar(7) DEFAULT '' NOT NULL,
	tx_lbrsitemap_priority  varchar(3) DEFAULT '' NOT NULL,
);