
SET search_path = public, pg_catalog;
DROP INDEX IF EXISTS public.sys_storage_templates_name;
DROP INDEX IF EXISTS public.sys_storage_fields_field;
DROP INDEX IF EXISTS public.sys_storage_fields_storage;
DROP INDEX IF EXISTS public.sys_modules_order;
DROP INDEX IF EXISTS public.sys_module_templates_name;
DROP INDEX IF EXISTS public.sys_links_order;
DROP INDEX IF EXISTS public.sys_index_words_word;
DROP INDEX IF EXISTS public.sys_index_word;
DROP INDEX IF EXISTS public.sys_tree_levels;
DROP INDEX IF EXISTS public.sys_tree_name;
DROP TABLE IF EXISTS public.sys_statistics;
DROP TABLE IF EXISTS public.sys_statsarchive;
DROP TABLE IF EXISTS public.sys_blobs_categories;
DROP TABLE IF EXISTS public.texts;
DROP TABLE IF EXISTS public.sys_usgroup;
DROP TABLE IF EXISTS public.sys_uscache;
DROP TABLE IF EXISTS public.sys_umusersgroups;
DROP TABLE IF EXISTS public.sys_umusers;
DROP TABLE IF EXISTS public.sys_umgroups;
DROP TABLE IF EXISTS public.sys_tree;
DROP TABLE IF EXISTS public.sys_templates;
DROP TABLE IF EXISTS public.sys_storages;
DROP TABLE IF EXISTS public.sys_storage_fields;
DROP TABLE IF EXISTS public.sys_storage_templates;
DROP TABLE IF EXISTS public.sys_settings;
DROP TABLE IF EXISTS public.sys_resources;
DROP TABLE IF EXISTS public.sys_repository;
DROP TABLE IF EXISTS public.sys_notices;
DROP TABLE IF EXISTS public.sys_modules;
DROP TABLE IF EXISTS public.sys_module_templates;
DROP TABLE IF EXISTS public.sys_links;
DROP TABLE IF EXISTS public.sys_languages;
DROP TABLE IF EXISTS public.sys_index_words;
DROP TABLE IF EXISTS public.sys_index;
DROP TABLE IF EXISTS public.sys_blobs_data;
DROP TABLE IF EXISTS public.sys_blobs_cache;
DROP TABLE IF EXISTS public.sys_blobs;

DROP SEQUENCE IF EXISTS public.sys_blobs_categories_category_id_seq;
DROP SEQUENCE IF EXISTS public.texts_texts_id_seq;
DROP SEQUENCE IF EXISTS public.sys_tree_tree_id_seq;
DROP SEQUENCE IF EXISTS public.sys_templates_templates_id_seq;
DROP SEQUENCE IF EXISTS public.sys_storages_storage_id_seq;
DROP SEQUENCE IF EXISTS public.sys_storage_templates_storage_templates_id_seq;
DROP SEQUENCE IF EXISTS public.sys_storage_fields_storage_field_id_seq;
DROP SEQUENCE IF EXISTS public.sys_settings_setting_id_seq;
DROP SEQUENCE IF EXISTS public.sys_resources_resource_id_seq;
DROP SEQUENCE IF EXISTS public.sys_repository_repository_id_seq;
DROP SEQUENCE IF EXISTS public.sys_notices_notice_id_seq;
DROP SEQUENCE IF EXISTS public.sys_modules_module_id_seq;
DROP SEQUENCE IF EXISTS public.sys_module_templates_module_templates_id_seq;
DROP SEQUENCE IF EXISTS public.sys_links_link_id_seq;
DROP SEQUENCE IF EXISTS public.sys_index_words_index_word_id_seq;
DROP SEQUENCE IF EXISTS public.sys_blobs_cache_blobs_cache_id_seq;
DROP SEQUENCE IF EXISTS public.sys_blobs_blobs_id_seq;

DROP FUNCTION IF EXISTS public.from_unixtime (bigint);
DROP FUNCTION IF EXISTS public.unix_timestamp (timestamp with time zone);
DROP FUNCTION IF EXISTS public.unix_timestamp ();

--
-- Definition for function unix_timestamp (OID = 71538) : 
--
CREATE FUNCTION public.unix_timestamp () RETURNS integer
AS 
$body$
SELECT
ROUND(EXTRACT( EPOCH FROM abstime(now()) ))::int4 AS result;
$body$
    LANGUAGE sql;
--
-- Definition for function unix_timestamp (OID = 71539) : 
--
CREATE FUNCTION public.unix_timestamp (timestamp with time zone) RETURNS integer
AS 
$body$
SELECT
ROUND(EXTRACT( EPOCH FROM ABSTIME($1) ))::int4 AS result;
$body$
    LANGUAGE sql;
--
-- Definition for function from_unixtime (OID = 71589) : 
--
CREATE FUNCTION public.from_unixtime (bigint) RETURNS timestamp without time zone
AS 
$body$
SELECT
CAST($1 as integer)::abstime::timestamp without time zone AS result
$body$
    LANGUAGE sql;
--
-- Definition for sequence sys_blobs_blobs_id_seq (OID = 68797) : 
--
CREATE SEQUENCE public.sys_blobs_blobs_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_blobs (OID = 68799) : 
--
CREATE TABLE public.sys_blobs (
    blobs_id bigint DEFAULT nextval('sys_blobs_blobs_id_seq'::regclass) NOT NULL,
    blobs_alt character varying(255) DEFAULT NULL::character varying,
    blobs_category character varying(255) DEFAULT NULL::character varying,
    blobs_filename character varying(255) DEFAULT NULL::character varying,
    blobs_type character varying(10) DEFAULT NULL::character varying,
    blobs_parent bigint DEFAULT (- (1)::bigint) NOT NULL,
    blobs_isfolder boolean DEFAULT false NOT NULL,
    blobs_bsize bigint DEFAULT (0)::bigint,
    blobs_securitycache text,
    blobs_lastaccessed date,
    blobs_width bigint,
    blobs_height bigint,
    blobs_modified date
) WITHOUT OIDS;
--
-- Definition for sequence sys_blobs_cache_blobs_cache_id_seq (OID = 68813) : 
--
CREATE SEQUENCE public.sys_blobs_cache_blobs_cache_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_blobs_cache (OID = 68815) : 
--
CREATE TABLE public.sys_blobs_cache (
    blobs_cache_id bigint DEFAULT nextval('sys_blobs_cache_blobs_cache_id_seq'::regclass) NOT NULL,
    blobs_cache_blobs_id bigint DEFAULT (0)::bigint NOT NULL,
    blobs_cache_date timestamp without time zone DEFAULT now() NOT NULL,
    blobs_cache_width integer DEFAULT 0 NOT NULL,
    blobs_cache_height integer DEFAULT 0 NOT NULL,
    blobs_cache_data bytea
) WITHOUT OIDS;
--
-- Structure for table sys_blobs_data (OID = 68826) : 
--
CREATE TABLE public.sys_blobs_data (
    blobs_id bigint DEFAULT (0)::bigint NOT NULL,
    blobs_data bytea
) WITHOUT OIDS;
--
-- Structure for table sys_index (OID = 68833) : 
--
CREATE TABLE public.sys_index (
    index_folder bigint DEFAULT (0)::bigint NOT NULL,
    index_publication bigint DEFAULT (0)::bigint NOT NULL,
    index_word character varying(100) DEFAULT ''::character varying NOT NULL,
    index_language character varying(2) DEFAULT ''::character varying NOT NULL,
    index_site bigint NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_index_words_index_word_id_seq (OID = 68840) : 
--
CREATE SEQUENCE public.sys_index_words_index_word_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_index_words (OID = 68842) : 
--
CREATE TABLE public.sys_index_words (
    index_word_id bigint DEFAULT nextval('sys_index_words_index_word_id_seq'::regclass) NOT NULL,
    index_word character varying(255) DEFAULT NULL::character varying
) WITHOUT OIDS;
--
-- Structure for table sys_languages (OID = 68847) : 
--
CREATE TABLE public.sys_languages (
    language_id character varying(2) DEFAULT ''::character varying NOT NULL,
    language_view character varying(100) DEFAULT '<some title>'::character varying NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_links_link_id_seq (OID = 68852) : 
--
CREATE SEQUENCE public.sys_links_link_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_links (OID = 68854) : 
--
CREATE TABLE public.sys_links (
    link_id bigint DEFAULT nextval('sys_links_link_id_seq'::regclass) NOT NULL,
    link_parent_storage_id bigint DEFAULT (0)::bigint NOT NULL,
    link_parent_id bigint DEFAULT (0)::bigint NOT NULL,
    link_child_storage_id bigint DEFAULT (0)::bigint NOT NULL,
    link_child_id bigint DEFAULT (0)::bigint NOT NULL,
    link_creationdate timestamp without time zone DEFAULT now() NOT NULL,
    link_order bigint DEFAULT (0)::bigint NOT NULL,
    link_template character varying(255) DEFAULT ''::character varying NOT NULL,
    link_object_type bigint DEFAULT (0)::bigint NOT NULL,
    link_propertiesvalues text,
    link_modifieddate date NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_module_templates_module_templates_id_seq (OID = 68869) : 
--
CREATE SEQUENCE public.sys_module_templates_module_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_module_templates (OID = 68871) : 
--
CREATE TABLE public.sys_module_templates (
    module_templates_id bigint DEFAULT nextval('sys_module_templates_module_templates_id_seq'::regclass) NOT NULL,
    module_templates_name character varying(20) DEFAULT 'new template'::character varying NOT NULL,
    module_templates_module_id bigint DEFAULT (0)::bigint NOT NULL,
    module_templates_list text,
    module_templates_properties text,
    module_templates_styles text,
    module_templates_composite boolean DEFAULT false NOT NULL,
    module_templates_description character varying(255),
    module_templates_cache boolean DEFAULT false NOT NULL,
    module_templates_cachecheck character varying(255) NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_modules_module_id_seq (OID = 68880) : 
--
CREATE SEQUENCE public.sys_modules_module_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_modules (OID = 68882) : 
--
CREATE TABLE public.sys_modules (
    module_id bigint DEFAULT nextval('sys_modules_module_id_seq'::regclass) NOT NULL,
    module_order bigint DEFAULT (1)::bigint NOT NULL,
    module_state integer DEFAULT 0 NOT NULL,
    module_entry character varying(255) NOT NULL,
    module_title character varying(255) NOT NULL,
    module_description text,
    module_version character varying(20) DEFAULT '1.0'::character varying NOT NULL,
    module_admincompat text NOT NULL,
    module_compat text NOT NULL,
    module_code text,
    module_storages text,
    module_libraries text,
    module_type integer DEFAULT 0 NOT NULL,
    module_haseditor boolean DEFAULT false NOT NULL,
    module_publicated boolean DEFAULT false NOT NULL,
    module_favorite boolean DEFAULT false NOT NULL,
    module_iconpack character varying(255)
) WITHOUT OIDS;
--
-- Definition for sequence sys_notices_notice_id_seq (OID = 68895) : 
--
CREATE SEQUENCE public.sys_notices_notice_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_notices (OID = 68897) : 
--
CREATE TABLE public.sys_notices (
    notice_id bigint DEFAULT nextval('sys_notices_notice_id_seq'::regclass) NOT NULL,
    notice_keyword character varying(255) DEFAULT 'NEW_NOTICE'::character varying NOT NULL,
    notice_subject text NOT NULL,
    notice_encoding character varying(255) DEFAULT ''::character varying NOT NULL,
    notice_body text NOT NULL,
    notice_securitycache text
) WITHOUT OIDS;
--
-- Definition for sequence sys_repository_repository_id_seq (OID = 68906) : 
--
CREATE SEQUENCE public.sys_repository_repository_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_repository (OID = 68908) : 
--
CREATE TABLE public.sys_repository (
    repository_id bigint DEFAULT nextval('sys_repository_repository_id_seq'::regclass) NOT NULL,
    repository_name character varying(255) DEFAULT NULL::character varying,
    repository_type character varying(20) DEFAULT 'PHP_CODE'::character varying NOT NULL,
    repository_code text,
    repository_datemodified date
) WITHOUT OIDS;
--
-- Definition for sequence sys_resources_resource_id_seq (OID = 68917) : 
--
CREATE SEQUENCE public.sys_resources_resource_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_resources (OID = 68919) : 
--
CREATE TABLE public.sys_resources (
    resource_id bigint DEFAULT nextval('sys_resources_resource_id_seq'::regclass) NOT NULL,
    resource_name character varying(255) DEFAULT ''::character varying NOT NULL,
    resource_language character varying(2) DEFAULT 'en'::character varying NOT NULL,
    resource_value text NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_settings_setting_id_seq (OID = 68928) : 
--
CREATE SEQUENCE public.sys_settings_setting_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_settings (OID = 68930) : 
--
CREATE TABLE public.sys_settings (
    setting_id bigint DEFAULT nextval('sys_settings_setting_id_seq'::regclass) NOT NULL,
    setting_name character varying(100) DEFAULT 'SETTING_'::character varying,
    setting_value text,
    setting_type character varying(100) DEFAULT 'memo'::character varying NOT NULL,
    setting_securitycache text,
    setting_issystem boolean DEFAULT false,
    setting_category character varying(100) DEFAULT 'User settings'::character varying
) WITHOUT OIDS;
--
-- Definition for sequence sys_storage_fields_storage_field_id_seq (OID = 68959) : 
--
CREATE SEQUENCE public.sys_storage_fields_storage_field_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_storage_fields (OID = 68961) : 
--
CREATE TABLE public.sys_storage_fields (
    storage_field_id bigint DEFAULT nextval('sys_storage_fields_storage_field_id_seq'::regclass) NOT NULL,
    storage_field_storage_id integer DEFAULT 0 NOT NULL,
    storage_field_name character varying(200) DEFAULT ''::character varying NOT NULL,
    storage_field_field character varying(200) DEFAULT ''::character varying NOT NULL,
    storage_field_type character varying(100) DEFAULT 'text'::character varying NOT NULL,
    storage_field_default character varying(255) DEFAULT NULL::character varying,
    storage_field_required boolean DEFAULT false NOT NULL,
    storage_field_showintemplate boolean DEFAULT true NOT NULL,
    storage_field_lookup text,
    storage_field_order bigint DEFAULT (0)::bigint NOT NULL,
    storage_field_values text,
    storage_field_group character varying(255) DEFAULT ''::character varying NOT NULL,
    storage_field_onetomany character varying(255) DEFAULT ''::character varying
) WITHOUT OIDS;
--
-- Definition for sequence sys_storage_templates_storage_templates_id_seq (OID = 68977) : 
--
CREATE SEQUENCE public.sys_storage_templates_storage_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_storage_templates (OID = 68979) : 
--
CREATE TABLE public.sys_storage_templates (
    storage_templates_id bigint DEFAULT nextval('sys_storage_templates_storage_templates_id_seq'::regclass) NOT NULL,
    storage_templates_name character varying(255) DEFAULT 'new template'::character varying,
    storage_templates_storage_id bigint DEFAULT (0)::bigint NOT NULL,
    storage_templates_list text,
    storage_templates_properties text,
    storage_templates_composite boolean DEFAULT false NOT NULL,
    storage_templates_styles text,
    storage_templates_description character varying(255),
    storage_templates_cache boolean DEFAULT false NOT NULL,
    storage_templates_cachecheck character varying(255) NOT NULL
) WITHOUT OIDS;
--
-- Definition for sequence sys_storages_storage_id_seq (OID = 68989) : 
--
CREATE SEQUENCE public.sys_storages_storage_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_storages (OID = 68991) : 
--
CREATE TABLE public.sys_storages (
    storage_id bigint DEFAULT nextval('sys_storages_storage_id_seq'::regclass) NOT NULL,
    storage_name character varying(100) DEFAULT ''::character varying NOT NULL,
    storage_table character varying(200) DEFAULT ''::character varying NOT NULL,
    storage_securitycache text,
    storage_color character varying(50),
    storage_group character varying(255),
    storage_parent character varying(255)
) WITHOUT OIDS;
--
-- Definition for sequence sys_templates_templates_id_seq (OID = 69001) : 
--
CREATE SEQUENCE public.sys_templates_templates_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_templates (OID = 69003) : 
--
CREATE TABLE public.sys_templates (
    templates_id bigint DEFAULT nextval('sys_templates_templates_id_seq'::regclass) NOT NULL,
    templates_name character varying(255) DEFAULT 'newtemplate'::character varying NOT NULL,
    templates_head text,
    templates_body text,
    templates_head_title text,
    templates_head_metakeywords text,
    templates_head_metadescription text,
    templates_head_shortcuticon character varying(255) DEFAULT NULL::character varying,
    templates_head_baseurl character varying(255) DEFAULT NULL::character varying,
    templates_head_styles text,
    templates_head_scripts text,
    templates_head_aditionaltags text,
    templates_html_doctype text,
    templates_repositories text
) WITHOUT OIDS;
--
-- Definition for sequence sys_tree_tree_id_seq (OID = 69013) : 
--
CREATE SEQUENCE public.sys_tree_tree_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_tree (OID = 69015) : 
--
CREATE TABLE public.sys_tree (
    tree_id bigint DEFAULT nextval('sys_tree_tree_id_seq'::regclass) NOT NULL,
    tree_left_key bigint DEFAULT (0)::bigint NOT NULL,
    tree_right_key bigint DEFAULT (0)::bigint NOT NULL,
    tree_level bigint DEFAULT (0)::bigint NOT NULL,
    tree_sid real DEFAULT (0)::real NOT NULL,
    tree_published boolean DEFAULT false NOT NULL,
    tree_name character varying(255) DEFAULT 'new tree item'::character varying NOT NULL,
    tree_keyword character varying(50) DEFAULT 'newitem'::character varying NOT NULL,
    tree_template integer DEFAULT 0 NOT NULL,
    tree_notes text NOT NULL,
    tree_datecreated timestamp without time zone DEFAULT now() NOT NULL,
    tree_datemodified timestamp without time zone DEFAULT now() NOT NULL,
    tree_description character varying(255) DEFAULT NULL::character varying,
    tree_language character varying(2) DEFAULT ''::character varying NOT NULL,
    tree_domain character varying(255) DEFAULT NULL::character varying,
    tree_header_description text,
    tree_header_keywords text,
    tree_header_shortcuticon text,
    tree_header_basehref character varying(255) DEFAULT NULL::character varying,
    tree_header_inlinestyles text,
    tree_header_inlinescripts text,
    tree_header_aditionaltags text,
    tree_header_statictitle text,
    tree_properties text,
    tree_propertiesvalues text,
    tree_securitycache text
) WITHOUT OIDS;
--
-- Structure for table sys_umgroups (OID = 69036) : 
--
CREATE TABLE public.sys_umgroups (
    groups_name character varying(255) DEFAULT ''::character varying NOT NULL,
    groups_description text
) WITHOUT OIDS;
--
-- Structure for table sys_umusers (OID = 69043) : 
--
CREATE TABLE public.sys_umusers (
    users_name character varying(255) DEFAULT ''::character varying NOT NULL,
    users_created bigint,
    users_modified bigint,
    users_password text NOT NULL,
    users_lastlogindate bigint,
    users_lastloginfrom character varying(15) DEFAULT NULL::character varying,
    users_roles text,
    users_profile text
) WITHOUT OIDS;
--
-- Structure for table sys_umusersgroups (OID = 69051) : 
--
CREATE TABLE public.sys_umusersgroups (
    "user" character varying(255) DEFAULT ''::character varying NOT NULL,
    "group" character varying(255) DEFAULT ''::character varying NOT NULL
) WITHOUT OIDS;
--
-- Structure for table sys_uscache (OID = 69059) : 
--
CREATE TABLE public.sys_uscache (
    uscache_key character varying(100) DEFAULT ''::character varying NOT NULL,
    uscache_created bigint DEFAULT (0)::bigint NOT NULL,
    uscache_modified bigint DEFAULT (0)::bigint NOT NULL,
    uscache_cache text NOT NULL
) WITHOUT OIDS;
--
-- Structure for table sys_usgroup (OID = 69068) : 
--
CREATE TABLE public.sys_usgroup (
    usgroup_name character varying(255) DEFAULT ''::character varying NOT NULL,
    usgroup_description character varying(20) DEFAULT NULL::character varying,
    usgroup_defaultrole character varying(255) DEFAULT ''::character varying NOT NULL,
    usgroup_users text
) WITHOUT OIDS;
--
-- Definition for sequence sys_blobs_categories_category_id_seq (OID = 70227) : 
--
CREATE SEQUENCE public.sys_blobs_categories_category_id_seq
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;
--
-- Structure for table sys_blobs_categories (OID = 70229) : 
--
CREATE TABLE public.sys_blobs_categories (
    category_id bigint DEFAULT nextval('sys_blobs_categories_category_id_seq'::regclass) NOT NULL,
    category_parent bigint DEFAULT -1::bigint NOT NULL,
    category_description character varying(255) DEFAULT 'New category'::character varying NOT NULL,
    category_securitycache text
) WITHOUT OIDS;
--
-- Structure for table sys_statsarchive (OID = 70870) : 
--
CREATE TABLE public.sys_statsarchive (
    stats_date bigint DEFAULT 0::bigint NOT NULL,
    stats_archive text
) WITHOUT OIDS;
--
-- Structure for table sys_statistics (OID = 81288) : 
--
CREATE TABLE public.sys_statistics (
    stats_date bigint DEFAULT 0::bigint NOT NULL,
    stats_site bigint DEFAULT 0::bigint NOT NULL,
    stats_folder bigint DEFAULT 0::bigint NOT NULL,
    stats_publication bigint DEFAULT 0::bigint NOT NULL,
    stats_country_code character varying(50) DEFAULT ''::character varying NOT NULL,
    stats_country_code3 character varying(50) DEFAULT ''::character varying NOT NULL,
    stats_country_name character varying(100) DEFAULT ''::character varying NOT NULL,
    stats_city character varying(100) DEFAULT ''::character varying NOT NULL,
    stats_remoteaddress bigint DEFAULT 0::bigint NOT NULL,
    stats_localaddress bigint DEFAULT 0::bigint NOT NULL,
    stats_session character varying(255) DEFAULT ''::character varying NOT NULL,
    stats_browser character varying(100) DEFAULT ''::character varying NOT NULL,
    stats_browser_version character varying(50) DEFAULT ''::character varying NOT NULL,
    stats_os character varying(100) DEFAULT ''::character varying NOT NULL,
    stats_os_version character varying(50) DEFAULT ''::character varying NOT NULL,
    stats_browser_type character varying(50) DEFAULT ''::character varying NOT NULL,
    stats_referer_domain character varying(100) DEFAULT ''::character varying NOT NULL,
    stats_referer_query text NOT NULL,
    stats_querystring text NOT NULL,
    stats_cookie text NOT NULL,
    stats_region character varying(50)
) WITHOUT OIDS;
--
-- Definition for index sys_tree_name (OID = 69092) : 
--
CREATE INDEX sys_tree_name ON sys_tree USING btree (tree_name);
--
-- Definition for index sys_tree_levels (OID = 69093) : 
--
CREATE INDEX sys_tree_levels ON sys_tree USING btree (tree_left_key, tree_right_key, tree_level);
--
-- Definition for index sys_index_word (OID = 69094) : 
--
CREATE INDEX sys_index_word ON sys_index USING btree (index_word);
--
-- Definition for index sys_index_words_word (OID = 69095) : 
--
CREATE INDEX sys_index_words_word ON sys_index_words USING btree (index_word);
--
-- Definition for index sys_links_order (OID = 69096) : 
--
CREATE INDEX sys_links_order ON sys_links USING btree (link_order);
--
-- Definition for index sys_module_templates_name (OID = 69097) : 
--
CREATE INDEX sys_module_templates_name ON sys_module_templates USING btree (module_templates_name);
--
-- Definition for index sys_modules_order (OID = 69098) : 
--
CREATE INDEX sys_modules_order ON sys_modules USING btree (module_order);
--
-- Definition for index sys_storage_fields_storage (OID = 69099) : 
--
CREATE INDEX sys_storage_fields_storage ON sys_storage_fields USING btree (storage_field_storage_id);
--
-- Definition for index sys_storage_fields_field (OID = 69100) : 
--
CREATE INDEX sys_storage_fields_field ON sys_storage_fields USING btree (storage_field_field);
--
-- Definition for index sys_storage_templates_name (OID = 69101) : 
--
CREATE INDEX sys_storage_templates_name ON sys_storage_templates USING btree (storage_templates_name);
--
-- Definition for index sys_blobs_cache_pkey (OID = 69104) : 
--
ALTER TABLE ONLY sys_blobs_cache
    ADD CONSTRAINT sys_blobs_cache_pkey PRIMARY KEY (blobs_cache_id);
--
-- Definition for index sys_index_words_pkey (OID = 69106) : 
--
ALTER TABLE ONLY sys_index_words
    ADD CONSTRAINT sys_index_words_pkey PRIMARY KEY (index_word_id);
--
-- Definition for index sys_languages_pkey (OID = 69108) : 
--
ALTER TABLE ONLY sys_languages
    ADD CONSTRAINT sys_languages_pkey PRIMARY KEY (language_id);
--
-- Definition for index sys_links_pkey (OID = 69110) : 
--
ALTER TABLE ONLY sys_links
    ADD CONSTRAINT sys_links_pkey PRIMARY KEY (link_id);
--
-- Definition for index sys_module_templates_pkey (OID = 69112) : 
--
ALTER TABLE ONLY sys_module_templates
    ADD CONSTRAINT sys_module_templates_pkey PRIMARY KEY (module_templates_id);
--
-- Definition for index sys_modules_pkey (OID = 69114) : 
--
ALTER TABLE ONLY sys_modules
    ADD CONSTRAINT sys_modules_pkey PRIMARY KEY (module_id);
--
-- Definition for index sys_notices_pkey (OID = 69116) : 
--
ALTER TABLE ONLY sys_notices
    ADD CONSTRAINT sys_notices_pkey PRIMARY KEY (notice_id);
--
-- Definition for index sys_repository_pkey (OID = 69118) : 
--
ALTER TABLE ONLY sys_repository
    ADD CONSTRAINT sys_repository_pkey PRIMARY KEY (repository_id);
--
-- Definition for index sys_resources_pkey (OID = 69120) : 
--
ALTER TABLE ONLY sys_resources
    ADD CONSTRAINT sys_resources_pkey PRIMARY KEY (resource_id);
--
-- Definition for index sys_settings_pkey (OID = 69122) : 
--
ALTER TABLE ONLY sys_settings
    ADD CONSTRAINT sys_settings_pkey PRIMARY KEY (setting_id);
--
-- Definition for index sys_storage_fields_pkey (OID = 69124) : 
--
ALTER TABLE ONLY sys_storage_fields
    ADD CONSTRAINT sys_storage_fields_pkey PRIMARY KEY (storage_field_id);
--
-- Definition for index sys_storage_templates_pkey (OID = 69126) : 
--
ALTER TABLE ONLY sys_storage_templates
    ADD CONSTRAINT sys_storage_templates_pkey PRIMARY KEY (storage_templates_id);
--
-- Definition for index sys_storages_pkey (OID = 69128) : 
--
ALTER TABLE ONLY sys_storages
    ADD CONSTRAINT sys_storages_pkey PRIMARY KEY (storage_id);
--
-- Definition for index sys_templates_pkey (OID = 69130) : 
--
ALTER TABLE ONLY sys_templates
    ADD CONSTRAINT sys_templates_pkey PRIMARY KEY (templates_id);
--
-- Definition for index sys_tree_pkey (OID = 69132) : 
--
ALTER TABLE ONLY sys_tree
    ADD CONSTRAINT sys_tree_pkey PRIMARY KEY (tree_id);
--
-- Definition for index sys_umgroups_pkey (OID = 69134) : 
--
ALTER TABLE ONLY sys_umgroups
    ADD CONSTRAINT sys_umgroups_pkey PRIMARY KEY (groups_name);
--
-- Definition for index sys_umusers_pkey (OID = 69136) : 
--
ALTER TABLE ONLY sys_umusers
    ADD CONSTRAINT sys_umusers_pkey PRIMARY KEY (users_name);
--
-- Definition for index sys_uscache_pkey (OID = 69138) : 
--
ALTER TABLE ONLY sys_uscache
    ADD CONSTRAINT sys_uscache_pkey PRIMARY KEY (uscache_key);
--
-- Definition for index sys_usgroup_pkey (OID = 69140) : 
--
ALTER TABLE ONLY sys_usgroup
    ADD CONSTRAINT sys_usgroup_pkey PRIMARY KEY (usgroup_name);
--
-- Definition for index texts_pkey (OID = 69142) : 
--
ALTER TABLE ONLY texts
    ADD CONSTRAINT texts_pkey PRIMARY KEY (texts_id);
--
-- Definition for index sys_blobs_data_id (OID = 69144) : 
--
ALTER TABLE ONLY sys_blobs_data
    ADD CONSTRAINT sys_blobs_data_id UNIQUE (blobs_id);
--
-- Definition for index sys_links_unique (OID = 69146) : 
--
ALTER TABLE ONLY sys_links
    ADD CONSTRAINT sys_links_unique UNIQUE (link_parent_storage_id, link_parent_id, link_child_storage_id, link_child_id);
--
-- Definition for index sys_modules_entry (OID = 69148) : 
--
ALTER TABLE ONLY sys_modules
    ADD CONSTRAINT sys_modules_entry UNIQUE (module_entry);
--
-- Definition for index sys_notices_keyword (OID = 69150) : 
--
ALTER TABLE ONLY sys_notices
    ADD CONSTRAINT sys_notices_keyword UNIQUE (notice_keyword);
--
-- Definition for index sys_repository_name (OID = 69152) : 
--
ALTER TABLE ONLY sys_repository
    ADD CONSTRAINT sys_repository_name UNIQUE (repository_name);
--
-- Definition for index sys_settings_name (OID = 69154) : 
--
ALTER TABLE ONLY sys_settings
    ADD CONSTRAINT sys_settings_name UNIQUE (setting_name);
--
-- Definition for index sys_storage_fields_name (OID = 69156) : 
--
ALTER TABLE ONLY sys_storage_fields
    ADD CONSTRAINT sys_storage_fields_name UNIQUE (storage_field_name);
--
-- Definition for index sys_storage_templates_unique (OID = 69158) : 
--
ALTER TABLE ONLY sys_storage_templates
    ADD CONSTRAINT sys_storage_templates_unique UNIQUE (storage_templates_storage_id, storage_templates_name);
--
-- Definition for index sys_storages_name (OID = 69160) : 
--
ALTER TABLE ONLY sys_storages
    ADD CONSTRAINT sys_storages_name UNIQUE (storage_name);
--
-- Definition for index sys_templates_name (OID = 69162) : 
--
ALTER TABLE ONLY sys_templates
    ADD CONSTRAINT sys_templates_name UNIQUE (templates_id);
--
-- Definition for index sys_umusersgroups_idx (OID = 69164) : 
--
ALTER TABLE ONLY sys_umusersgroups
    ADD CONSTRAINT sys_umusersgroups_idx PRIMARY KEY ("user", "group");
--
-- Definition for index category_id (OID = 70238) : 
--
ALTER TABLE ONLY sys_blobs_categories
    ADD CONSTRAINT category_id PRIMARY KEY (category_id);
--
-- Definition for index sys_blobs_pkey (OID = 72779) : 
--
ALTER TABLE ONLY sys_blobs
    ADD CONSTRAINT sys_blobs_pkey PRIMARY KEY (blobs_id);

--
-- Data for table public.sys_languages (OID = 68847) (LIMIT 0,2)
--
INSERT INTO sys_languages (language_id, language_view)
VALUES ('en', 'English');

INSERT INTO sys_languages (language_id, language_view)
VALUES ('ru', 'Russian');

--
-- Data for table public.sys_settings (OID = 68930) (LIMIT 0,9)
--
INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (1, 'BLOB_CACHE_FOLDER', '/assets/static', 'memo', 'O:9:"Hashtable":2:{s:8:"', false, 'Blob manager settings | Настройки менеджера ресурсов');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (2, 'MAIL_SMTP', 'island.grc.ru', 'memo', NULL, false, 'System settings | Настройки системы');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (3, 'DEVELOPER_EMAIL', 'mk@e-time.ru;spawn@e-time.ru', 'memo', 'O:9:"Hashtable":2:{s:8:"', false, 'System settings | Настройки системы');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (4, 'COPYRIGHT', 'Company copyright', 'memo', 'O:9:"Hashtable":2:{s:8:"', false, 'User settings | Пользовательские настройки');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (5, 'USE_MOD_REWRITE', 'default', 'memo', NULL, false, 'System settings | Настройки системы');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (6, 'SYSTEM_RESTORE_CRON_MAX', '5', 'memo', NULL, false, 'System restore settings | Настройки системы восстановления');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (7, 'SETTING_COMPANY_EMAIL', 'company@e.mail', 'memo', 'O:9:"Hashtable":2:{s:8:"', false, 'User settings | Пользовательские настройки');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (8, 'SETTING_COMPANY_TITLE', 'Company title', 'memo', 'O:9:"Hashtable":2:{s:8:"', true, 'User settings | Пользовательские настройки');

INSERT INTO sys_settings (setting_id, setting_name, setting_value, setting_type, setting_securitycache, setting_issystem, setting_category)
VALUES (9, 'SETTING_PAGESIZE', '10', 'memo', 'O:9:"Hashtable":2:{s:8:"', false, 'System settings | Настройки системы');

--
-- Data for table public.sys_templates (OID = 69003) (LIMIT 0,1)
--
INSERT INTO sys_templates (templates_id, templates_name, templates_head, templates_body, templates_head_title, templates_head_metakeywords, templates_head_metadescription, templates_head_shortcuticon, templates_head_baseurl, templates_head_styles, templates_head_scripts, templates_head_aditionaltags, templates_html_doctype, templates_repositories)
VALUES (1, 'default', '', '<? echo phpinfo(); ?>', 'Default Site', '', '', '', '', '', '', '', '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">', '');

--
-- Data for table public.sys_tree (OID = 69015) (LIMIT 0,2)
--
INSERT INTO sys_tree (tree_id, tree_left_key, tree_right_key, tree_level, tree_sid, tree_published, tree_name, tree_keyword, tree_template, tree_notes, tree_datecreated, tree_datemodified, tree_description, tree_language, tree_domain, tree_header_description, tree_header_keywords, tree_header_shortcuticon, tree_header_basehref, tree_header_inlinestyles, tree_header_inlinescripts, tree_header_aditionaltags, tree_header_statictitle, tree_properties, tree_propertiesvalues, tree_securitycache)
VALUES (1, 1, 86, 0, 4.37359e+011, true, 'root', 'root', 2, '', '2006-12-12 15:41:50', '2006-12-12 15:41:50', 'root', 'ru', 'root', '', '', '', '', '', '', '', 'root', NULL, NULL, NULL);

INSERT INTO sys_tree (tree_id, tree_left_key, tree_right_key, tree_level, tree_sid, tree_published, tree_name, tree_keyword, tree_template, tree_notes, tree_datecreated, tree_datemodified, tree_description, tree_language, tree_domain, tree_header_description, tree_header_keywords, tree_header_shortcuticon, tree_header_basehref, tree_header_inlinestyles, tree_header_inlinescripts, tree_header_aditionaltags, tree_header_statictitle, tree_properties, tree_propertiesvalues, tree_securitycache)
VALUES (2, 7, 85, 1, 4.8647e+011, true, 'site', 'site', 1, '', '2006-12-12 15:41:50', '2008-10-07 18:41:31', 'Default site', 'ru', '', '', '', '', '', '', '', '', 'Default site', NULL, NULL, NULL);

--
-- Data for table public.sys_umgroups (OID = 69036) (LIMIT 0,1)
--
INSERT INTO sys_umgroups (groups_name, groups_description)
VALUES ('Administrators', 'System administrators');

--
-- Data for table public.sys_umusers (OID = 69043) (LIMIT 0,1)
--
INSERT INTO sys_umusers (users_name, users_created, users_modified, users_password, users_lastlogindate, users_lastloginfrom, users_roles, users_profile)
VALUES ('admin', NULL, NULL, '4b6dP/8=', 1223410134, '93.80.180.159', 'system_administrator', 'O:8:"stdClass":1:{s:5:"admin";O:8:"Profiler":4:{s:4:"user";O:4:"User":2:{s:11:"');

--
-- Data for table public.sys_umusersgroups (OID = 69051) (LIMIT 0,1)
--
INSERT INTO sys_umusersgroups ("user", "group")
VALUES ('admin', 'Administrators');
