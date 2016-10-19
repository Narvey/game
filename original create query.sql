CREATE TABLE IF NOT EXISTS Map (
n BIGINT,
w BIGINT,
groundcolor BINARY(3),
item_type MEDIUMINT UNSIGNED,
item_value TEXT(30),
item_color BINARY(3),
PRIMARY KEY (n, w)
