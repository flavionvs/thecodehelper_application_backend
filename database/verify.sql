SELECT TABLE_NAME, COLUMN_NAME, COLUMN_KEY, EXTRA 
FROM information_schema.COLUMNS 
WHERE TABLE_SCHEMA = 'codehelper' 
AND COLUMN_NAME = 'id'
AND TABLE_NAME IN ('projects', 'applications', 'users', 'messages', 'payments', 'notifications')
ORDER BY TABLE_NAME;
