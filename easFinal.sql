USE mysql;

DROP USER IF EXISTS 'uSTU'@'localhost';
DROP USER IF EXISTS 'uTEC'@'localhost';
DROP USER IF EXISTS 'uSTU'@'%';
DROP USER IF EXISTS 'uTEC'@'%';

CREATE USER 'uSTU'@'localhost' IDENTIFIED BY 'student';
CREATE USER 'uTEC'@'localhost' IDENTIFIED BY 'teacher';

GRANT SELECT ON eas.course TO 'uSTU'@'localhost';
GRANT SELECT, INSERT, DELETE ON eas.chosedcourse TO 'uSTU'@'localhost';
GRANT SELECT ON eas.student TO 'uSTU'@'localhost';
GRANT SELECT ON eas.teacher TO 'uSTU'@'localhost';

GRANT SELECT, INSERT, DELETE ON eas.course TO 'uTEC'@'localhost';
GRANT SELECT, UPDATE ON eas.chosedcourse TO 'uTEC'@'localhost';
GRANT SELECT ON eas.student TO 'uTEC'@'localhost';
GRANT SELECT ON eas.teacher TO 'uTEC'@'localhost';

SET NAMES utf8;
DROP DATABASE IF EXISTS eas;
USE eas;


-- ----------------------------
-- Table structure for chosedcourse
-- ----------------------------
DROP TABLE IF EXISTS `chosedcourse`;
CREATE TABLE `chosedcourse`
(
    `sid`   char(12) NOT NULL,
    `cid`   char(6)  NOT NULL,
    `score` smallint DEFAULT NULL,
    PRIMARY KEY (`sid`, `cid`),
    KEY `cid` (`cid`),
    CONSTRAINT `chosedcourse_copy1_ibfk_1` FOREIGN KEY (`sid`) REFERENCES `student` (`sid`) ON DELETE CASCADE,
    CONSTRAINT `chosedcourse_copy1_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `course` (`cid`) ON DELETE CASCADE,
    CONSTRAINT `chosedcourse_copy1_chk_1` CHECK (((`score` is null) or (`score` between 0 and 100)))
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3;

-- ----------------------------
-- Table structure for course
-- ----------------------------
DROP TABLE IF EXISTS `course`;
CREATE TABLE `course`
(
    `cid`    char(6)       NOT NULL,
    `cname`  char(20)      NOT NULL,
    `tid`    char(10)      NOT NULL,
    `credit` decimal(3, 1) NOT NULL,
    `day`    char(40) DEFAULT NULL,
    PRIMARY KEY (`cid`),
    KEY `tid` (`tid`),
    CONSTRAINT `course_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `teacher` (`tid`) ON DELETE CASCADE
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3;

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`
(
    `sid`      char(12) NOT NULL,
    `sname`    char(20) NOT NULL,
    `scollege` char(20) NOT NULL,
    `sphone`   char(11) DEFAULT NULL,
    `ssex`     char(6)  NOT NULL,
    PRIMARY KEY (`sid`),
    CONSTRAINT `student_chk_1` CHECK ((`ssex` in (_utf8mb4'male', _utf8mb4'female')))
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3;


-- ----------------------------
-- Table structure for teacher
-- ----------------------------
DROP TABLE IF EXISTS `teacher`;
CREATE TABLE `teacher`
(
    `tid`      char(10) NOT NULL,
    `tname`    char(20) NOT NULL,
    `tcollege` char(20) NOT NULL,
    `tphone`   char(11) DEFAULT NULL,
    `tsex`     char(6)  NOT NULL,
    PRIMARY KEY (`tid`),
    CONSTRAINT `teacher_chk_1` CHECK ((`tsex` in (_utf8mb4'male', _utf8mb4'female')))
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3;


-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`
(
    `uid`  char(12) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
    `pwd`  char(40)                                            NOT NULL,
    `mode` char(3) CHARACTER SET utf8 COLLATE utf8_general_ci  NOT NULL,
    PRIMARY KEY (`uid`),
    CONSTRAINT `user_chk_1` CHECK ((`mode` in (_utf8mb3'STU', _utf8mb3'TEC', _utf8mb3'SPU')))
) ENGINE = InnoDB
  DEFAULT CHARSET = utf8mb3;


