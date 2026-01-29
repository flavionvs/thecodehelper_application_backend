-- STEP 1: Sync all id values to my_row_id
SET FOREIGN_KEY_CHECKS = 0;

UPDATE application_attachments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE application_completion_attachments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE application_statuses SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE applications SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE basic_settings SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE categories SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE contact_queries SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE failed_jobs SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE langs SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE messages SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE migrations SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE notifications SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE payments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE permissions SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE personal_access_tokens SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE programming_languages SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE projects SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE roles SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE sub_categories SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE technologies SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE transactions SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE unverified_users SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE user_categories SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE user_langs SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE user_languages SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE user_programming_languages SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE user_technologies SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE users SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;

SELECT 'STEP 1 COMPLETE' as status;
