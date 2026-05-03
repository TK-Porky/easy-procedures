-- SQL script to insert initial data for the easy-procedures database

-- -----------------------------------------------------
-- Roles
-- -----------------------------------------------------
INSERT INTO `roles` (`id_role`, `name`, `description`) VALUES
(1, 'Client', 'End user of the application'),
(2, 'Agent', 'Staff member who manages requests'),
(3, 'Administrator', 'Full system access');

-- -----------------------------------------------------
-- Requirement Types
-- -----------------------------------------------------
INSERT INTO `requirementtypes` (`type`, `name`, `Description`, `deleted`, `created`, `modified`) VALUES
('formulaire', 'Form Requirement', 'A requirement that needs form data input', 0, NOW(), NOW()),
('file', 'File Requirement', 'A requirement that needs a file upload', 0, NOW(), NOW());
