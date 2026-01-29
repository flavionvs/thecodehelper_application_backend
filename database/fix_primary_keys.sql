-- ============================================================
-- PERMANENT FIX: Make `id` the primary key, remove `my_row_id`
-- Run this on Azure MySQL database
-- 
-- IMPORTANT: Before running:
-- 1. BACKUP YOUR DATABASE FIRST!
-- 2. Run each block one table at a time if needed
-- ============================================================

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS = 0;

-- ============================================================
-- STEP 1: Sync all id values to my_row_id first
-- This ensures no data is lost when we switch primary keys
-- ============================================================

-- Core tables
UPDATE projects SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE applications SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE payments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE notifications SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE messages SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE users SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE categories SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;

-- Related tables (if they have my_row_id)
UPDATE application_statuses SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE application_attachments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;
UPDATE application_completion_attachments SET id = my_row_id WHERE id IS NULL OR id = 0 OR id != my_row_id;

-- ============================================================
-- STEP 2: Restructure each table - make `id` the primary key
-- Run these one at a time if you get errors
-- ============================================================

-- PROJECTS
ALTER TABLE projects 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE projects DROP COLUMN my_row_id;

-- APPLICATIONS  
ALTER TABLE applications 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE applications DROP COLUMN my_row_id;

-- PAYMENTS
ALTER TABLE payments 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE payments DROP COLUMN my_row_id;

-- NOTIFICATIONS
ALTER TABLE notifications 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE notifications DROP COLUMN my_row_id;

-- MESSAGES
ALTER TABLE messages 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE messages DROP COLUMN my_row_id;

-- USERS
ALTER TABLE users 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE users DROP COLUMN my_row_id;

-- CATEGORIES
ALTER TABLE categories 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE categories DROP COLUMN my_row_id;

-- APPLICATION_STATUSES
ALTER TABLE application_statuses 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE application_statuses DROP COLUMN my_row_id;

-- APPLICATION_ATTACHMENTS
ALTER TABLE application_attachments 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE application_attachments DROP COLUMN my_row_id;

-- APPLICATION_COMPLETION_ATTACHMENTS
ALTER TABLE application_completion_attachments 
    DROP PRIMARY KEY,
    MODIFY id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    ADD PRIMARY KEY (id);
ALTER TABLE application_completion_attachments DROP COLUMN my_row_id;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- VERIFICATION: Run these to confirm the fix worked
-- ============================================================
-- SHOW COLUMNS FROM projects;
-- SHOW COLUMNS FROM applications;
-- SHOW COLUMNS FROM payments;
-- SELECT id FROM projects LIMIT 5;
-- SELECT id FROM applications LIMIT 5;

-- ============================================================
-- DONE! Now `id` is the primary key everywhere
-- All Laravel models will work with standard $model->id
-- ============================================================
