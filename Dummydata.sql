-- Insert sample data into employees table
INSERT INTO employees (name, role, hourly_rate, total_hours_worked) VALUES
('John Doe', 'boss', 50.00, 160), -- Boss with hourly rate $50 and 160 total hours worked
('Jane Smith', 'manager', 30.00, 150), -- Manager with hourly rate $30 and 150 total hours worked
('Alice Johnson', 'worker', 20.00, 140), -- Worker with hourly rate $20 and 140 total hours worked
('Bob Brown', 'worker', 20.00, 160), -- Worker with hourly rate $20 and 160 total hours worked
('Emily Davis', 'worker', 20.00, 170); -- Worker with hourly rate $20 and 170 total hours worked

-- Insert sample data into employee_login table
INSERT INTO employee_login (employee_id, username, password) VALUES
(1, 'john_doe', 'password1'), -- Employee ID 1 (John Doe) with username 'john_doe' and password 'password1'
(2, 'jane_smith', 'password2'), -- Employee ID 2 (Jane Smith) with username 'jane_smith' and password 'password2'
(3, 'alice_johnson', 'password3'), -- Employee ID 3 (Alice Johnson) with username 'alice_johnson' and password 'password3'
(4, 'bob_brown', 'password4'), -- Employee ID 4 (Bob Brown) with username 'bob_brown' and password 'password4'
(5, 'emily_davis', 'password5'); -- Employee ID 5 (Emily Davis) with username 'emily_davis' and password 'password5'

-- Insert sample data into payroll table for a specific pay period
INSERT INTO payroll (employee_id, pay_date, total_hours_worked, total_pay) VALUES
(1, '2024-03-01', 160, 8000.00), -- John Doe's payroll for March 2024 with 160 hours worked and $8000 total pay
(2, '2024-03-01', 150, 4500.00), -- Jane Smith's payroll for March 2024 with 150 hours worked and $4500 total pay
(3, '2024-03-01', 140, 2800.00), -- Alice Johnson's payroll for March 2024 with 140 hours worked and $2800 total pay
(4, '2024-03-01', 160, 3200.00), -- Bob Brown's payroll for March 2024 with 160 hours worked and $3200 total pay
(5, '2024-03-01', 170, 3400.00); -- Emily Davis's payroll for March 2024 with 170 hours worked and $3400 total pay
