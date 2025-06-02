CREATE TABLE IF NOT EXISTS users (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    failed_attempts INT DEFAULT 0,
    last_failed_login TIMESTAMP NULL,
    account_locked_until TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Crear un tipo ENUM para PostgreSQL
DO $$
BEGIN
    IF NOT EXISTS (SELECT 1 FROM pg_type WHERE typname = 'event_type_enum') THEN
        CREATE TYPE event_type_enum AS ENUM ('login', 'logout', 'register');
    END IF;
END
$$;

CREATE TABLE IF NOT EXISTS auth_log (
    id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    event_type event_type_enum NOT NULL,
    ip_address VARCHAR(45),
    login_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
