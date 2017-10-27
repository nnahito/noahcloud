CREATE TABLE "file_list" ( `file_list_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `repository_id` INTEGER NOT NULL, `file_name` TEXT NOT NULL, `upload_person` INTEGER NOT NULL, `uploaded_at` TEXT NOT NULL )
CREATE TABLE "repository" ( `repository_id` INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE, `repository_name` TEXT, `created_at` TEXT )
CREATE TABLE `repository_group` ( `repository_group_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `repository_id` INTEGER NOT NULL, `user_id` INTEGER NOT NULL, `created_dt` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP, `modified_dt` TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP )
CREATE TABLE `user` ( `user_id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `user_name` TEXT NOT NULL, `email` TEXT NOT NULL, `password` TEXT NOT NULL, `permission` TEXT NOT NULL )
