CREATE TABLE users (
id serial PRIMARY KEY,
email text NOT NULL UNIQUE,
first_name text NOT NULL,
last_name text NOT NULL,
currency_amount money NOT NULL DEFAULT 0,
admin boolean NOT NULL DEFAULT false,
driver boolean NOT NULL,
rider boolean NOT NULL,
password text NOT NULL
);
/* relation declaration */

INSERT INTO users (id,first_name,last_name,email,currency_amount,admin,driver,rider,password) VALUES ('7','Kenny','Mcdowe','kennymcdow@nus.edu.sg','$2.40','f','f','t','password');
INSERT INTO users (id,first_name,last_name,email,currency_amount,admin,driver,rider,password) VALUES ('1','Jaimie','Oliver','jamieolive@email.com','$37.45','f','t','f','password');
INSERT INTO users (id,first_name,last_name,email,currency_amount,admin,driver,rider,password) VALUES ('2','Joan','Lim','joannelim@nus.edu.sg','$50.50','f','t','f','password');
INSERT INTO users (id,first_name,last_name,email,currency_amount,admin,driver,rider,password) VALUES ('6','Tonny','Mcfarlene','mcfarlene@nus.edu.sg','$10.00','f','f','t','password');
/* create sample t-uples */
