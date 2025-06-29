USE agro_crm;

CREATE TABLE tbl_users (
    user_indx INT(11) AUTO_INCREMENT UNIQUE,
    user_key VARCHAR(60) PRIMARY KEY,
    user_fname VARCHAR(100) DEFAULT NULL,
    user_mname VARCHAR(100) DEFAULT NULL,
    user_lname VARCHAR(100) DEFAULT NULL,
    user_email VARCHAR(100) DEFAULT NULL,
    user_phone DOUBLE DEFAULT NULL,
    user_mobile DOUBLE DEFAULT NULL,
    user_gender VARCHAR(60) DEFAULT NULL,
    user_login_name VARCHAR(60) NOT NULL,
    user_status INT(11) DEFAULT NULL,
    user_role VARCHAR(60) DEFAULT NULL,
    user_verified VARCHAR(60) DEFAULT NULL,
    user_email_vrified VARCHAR(60) DEFAULT NULL, -- Consider fixing typo if it's supposed to be 'verified'
    user_email_token TEXT DEFAULT NULL,
    user_image TEXT DEFAULT NULL,
    user_permissions LONGTEXT,
    user_create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    user_update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    user_password TEXT DEFAULT NULL,
    user_remarks LONGTEXT NOT NULL,
    user_otp INT(11) DEFAULT NULL,
    user_delete ENUM('Y', 'N') DEFAULT 'N'
);

CREATE TABLE tbl_leads (
    lead_indx INT AUTO_INCREMENT UNIQUE,
    lead_id VARCHAR(60) PRIMARY KEY,
    lead_name VARCHAR(100) DEFAULT NULL,
    lead_email VARCHAR(100) DEFAULT NULL,
    lead_phone BIGINT DEFAULT NULL,
    lead_enquiry_for VARCHAR(255) DEFAULT NULL,
    lead_type VARCHAR(100) DEFAULT NULL,
    lead_status VARCHAR(100) DEFAULT NULL,
    lead_given_date VARCHAR(100) DEFAULT NULL,
    lead_user_id VARCHAR(60) DEFAULT NULL,
    lead_assigned_user VARCHAR(60) DEFAULT NULL,
    lead_create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    lead_update_date DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    lead_delete ENUM('Y', 'N') DEFAULT 'N'
);


INSERT INTO tbl_users (user_indx, user_key, user_fname, user_mname, user_lname, user_email, user_phone, user_mobile, user_gender, user_login_name, user_status, user_role, user_verified, user_email_vrified, user_email_token, user_image, user_permissions, user_create_date, user_update_date, user_password, user_remarks, user_otp, user_delete)
  VALUES
  (19, 'USR00001', 'User', '', 'One', 'userone@gmail.com', 9874563210, 9988665544, 'M', 'superadmin', 1, 'superadmin', 'Y', 'Y', 'superadmin -> superadmin!@#_', '', NULL, '2025-06-09 09:10:01', '2025-06-09 09:10:01', 'e87f74cddd5648de7305d946c12bc751', '', 0, 'N');

SELECT * FROM tbl_leads tl  ORDER BY tl.lead_indx DESC;

UPDATE tbl_leads tl SET tl.lead_assigned_user='DSE' WHERE tl.lead_indx BETWEEN 301 AND 500;












