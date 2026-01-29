-- STEP 2B: Continue restructuring remaining tables
SET sql_generate_invisible_primary_key = OFF;
SET FOREIGN_KEY_CHECKS = 0;

-- projects (has UNIQUE index named 'projects_id_unique')
ALTER TABLE projects DROP INDEX projects_id_unique;
ALTER TABLE projects DROP COLUMN my_row_id;
ALTER TABLE projects MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- roles
ALTER TABLE roles DROP COLUMN my_row_id;
ALTER TABLE roles MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- sub_categories
ALTER TABLE sub_categories DROP COLUMN my_row_id;
ALTER TABLE sub_categories MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- technologies
ALTER TABLE technologies DROP COLUMN my_row_id;
ALTER TABLE technologies MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- transactions
ALTER TABLE transactions DROP COLUMN my_row_id;
ALTER TABLE transactions MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- unverified_users
ALTER TABLE unverified_users DROP COLUMN my_row_id;
ALTER TABLE unverified_users MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- user_categories
ALTER TABLE user_categories DROP COLUMN my_row_id;
ALTER TABLE user_categories MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- user_langs
ALTER TABLE user_langs DROP COLUMN my_row_id;
ALTER TABLE user_langs MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- user_languages
ALTER TABLE user_languages DROP COLUMN my_row_id;
ALTER TABLE user_languages MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- user_programming_languages
ALTER TABLE user_programming_languages DROP COLUMN my_row_id;
ALTER TABLE user_programming_languages MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- user_technologies
ALTER TABLE user_technologies DROP COLUMN my_row_id;
ALTER TABLE user_technologies MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- users
ALTER TABLE users DROP COLUMN my_row_id;
ALTER TABLE users MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

-- sessions (id is varchar PRIMARY KEY, just drop the my_row_id unique index and column)
ALTER TABLE sessions DROP INDEX my_row_id;
ALTER TABLE sessions DROP COLUMN my_row_id;

-- Tables with ONLY my_row_id (no id column) - rename my_row_id to id
ALTER TABLE model_has_permissions CHANGE COLUMN my_row_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE model_has_roles CHANGE COLUMN my_row_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE password_resets CHANGE COLUMN my_row_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE role_has_permissions CHANGE COLUMN my_row_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT;

SET FOREIGN_KEY_CHECKS = 1;

SELECT 'STEP 2 COMPLETE - All tables restructured' as status;
