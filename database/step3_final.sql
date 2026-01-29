SET SESSION sql_mode='ALLOW_INVALID_DATES';
SET sql_generate_invisible_primary_key = OFF;
SET FOREIGN_KEY_CHECKS = 0;

ALTER TABLE model_has_roles ADD COLUMN id BIGINT UNSIGNED NOT NULL FIRST;
SET @row_num = 0;
UPDATE model_has_roles SET id = (@row_num := @row_num + 1);
ALTER TABLE model_has_roles DROP COLUMN my_row_id;
ALTER TABLE model_has_roles MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

ALTER TABLE password_resets ADD COLUMN id BIGINT UNSIGNED NOT NULL FIRST;
SET @row_num = 0;
UPDATE password_resets SET id = (@row_num := @row_num + 1);
ALTER TABLE password_resets DROP COLUMN my_row_id;
ALTER TABLE password_resets MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

ALTER TABLE role_has_permissions ADD COLUMN id BIGINT UNSIGNED NOT NULL FIRST;
SET @row_num = 0;
UPDATE role_has_permissions SET id = (@row_num := @row_num + 1);
ALTER TABLE role_has_permissions DROP COLUMN my_row_id;
ALTER TABLE role_has_permissions MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY;

SET FOREIGN_KEY_CHECKS = 1;

SELECT 'ALL COMPLETE' as status;
