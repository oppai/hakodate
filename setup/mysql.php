CREATE TABLE `books` (
`book_id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`book_name` VARCHAR( 255 ) NOT NULL ,
`price` INT NOT NULL ,
INDEX ( `book_name` )
) ENGINE = MYISAM ;


INSERT INTO `books` (
`book_id` ,
`book_name` ,
`price`
)
VALUES (
NULL , 'Book ABC', '100'
), (
NULL , 'Book XYZ', '200'
);
