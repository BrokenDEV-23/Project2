CREATE DATABASE payroll_db;

CREATE TABLE employees(
	id int not null PRIMARY KEY AUTO_INCREMENT,
	name text not null,
	role text not null,
	hourly_rate decimal not null,
	total_hours_worked decimal NOT null);
    
CREATE TABLE employee_login(
    id int NOT null PRIMARY KEY,
    employee_id int not null,
    username text not null,
    `password` text not null,
	FOREIGN KEY(employee_id) REFERENCES employees(id));
    
CREATE TABLE payroll(
    id int NOT null PRIMARY KEY,
    employee_id int not null,
    pay_date date NOT null,
    total_hours_worked decimal NOT null,
    total_pay decimal not null);