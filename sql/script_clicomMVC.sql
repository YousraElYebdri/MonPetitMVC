# --SCRIPT CREATION BDD MVC-- #
--ROOT --

CREATE USER 'dbcreateur'@'localhost' IDENTIFIED BY "Plonger83";
GRANT CREATE,REFERENCES,DROP,ALTER on *.* to 'dbcreateur'@'localhost';

-- dbcreateur -- 
# Executer le script
USE clicommvc;
SELECT * FROM utilisateur;
