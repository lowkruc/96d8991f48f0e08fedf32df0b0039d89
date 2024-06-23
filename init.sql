-- Create database if not exists
-- Check if database exists
DO $$ BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM pg_database
        WHERE datname = 'levart_blastemail'
    ) THEN
        CREATE DATABASE levart_blastemail;
    END IF;
END $$;

-- Connect to database
\c levart_blastemail;

-- Create table emails
CREATE TABLE IF NOT EXISTS emails (
    id SERIAL PRIMARY KEY,
    email VARCHAR(255),
    subject VARCHAR(255),
    body TEXT,
    status VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create table users
CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255),
    username VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255)
);

-- Insert default data user
INSERT INTO users (name, username, password) VALUES
('Ahmad Saekoni', 'ahmadsaekoni', '0192023a7bbd73250516f069df18b500');


-- Grant permission to connect to levart_blastemail database
GRANT CONNECT ON DATABASE levart_blastemail TO postgres;

-- Grant permission to create tables to postgres user
GRANT CREATE ON DATABASE levart_blastemail TO postgres;

-- Grant permission to insert, update, delete on users table to postgres user
GRANT INSERT, UPDATE, DELETE ON TABLE users TO postgres;

