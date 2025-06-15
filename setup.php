<?php

require_once 'Database.php';

$db = (new Database())->connect();

// ------------------------------------------------------------
//  ROLES
// ------------------------------------------------------------
$db->exec(
    "CREATE TABLE IF NOT EXISTS roles (
        id   SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE
    );"
);

$db->exec(
    "INSERT INTO roles (name) VALUES ('user'), ('admin')
     ON CONFLICT DO NOTHING;"
);

// ------------------------------------------------------------
//  USERS
// ------------------------------------------------------------
$db->exec(
    "CREATE TABLE IF NOT EXISTS users (
        id            SERIAL PRIMARY KEY,
        role_id       INT REFERENCES roles(id) ON DELETE SET NULL,
        email         VARCHAR(255) NOT NULL UNIQUE,
        password_hash VARCHAR(255) NOT NULL,
        created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );"
);

// ------------------------------------------------------------
//  USER_PROFILES (1‑1 z users)
// ------------------------------------------------------------
$db->exec(
    "CREATE TABLE IF NOT EXISTS user_profiles (
        user_id     INT PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
        full_name   VARCHAR(100),
        avatar_path VARCHAR(255)
    );"
);

// ------------------------------------------------------------
//  NOTES (1‑N z users)
// ------------------------------------------------------------
$db->exec(
    "CREATE TABLE IF NOT EXISTS notes (
        id          SERIAL PRIMARY KEY,
        user_id     INT NOT NULL REFERENCES users(id) ON DELETE CASCADE,
        title       VARCHAR(255) NOT NULL,
        content     TEXT,
        is_favorite BOOLEAN DEFAULT FALSE,
        created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );"
);

// ------------------------------------------------------------
//  TAGS + NOTE_TAGS (N‑N)
// ------------------------------------------------------------
$db->exec(
    "CREATE TABLE IF NOT EXISTS tags (
        id   SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL UNIQUE
    );"
);

$db->exec(
    "CREATE TABLE IF NOT EXISTS note_tags (
        note_id INT NOT NULL REFERENCES notes(id) ON DELETE CASCADE,
        tag_id  INT NOT NULL REFERENCES tags(id)  ON DELETE CASCADE,
        PRIMARY KEY (note_id, tag_id)
    );"
);

// ------------------------------------------------------------
//  VIEW: view_notes_with_tags
// ------------------------------------------------------------
$db->exec(
    "CREATE OR REPLACE VIEW view_notes_with_tags AS
     SELECT
         n.*,
         ARRAY_REMOVE(array_agg(t.name), NULL)          AS tag_arr,  
         STRING_AGG(t.name, ', ' ORDER BY t.name)       AS tag_list,
         COUNT(t.id)                                    AS tag_count
     FROM notes n
     LEFT JOIN note_tags nt ON nt.note_id = n.id
     LEFT JOIN tags      t  ON t.id      = nt.tag_id
     GROUP BY n.id;"
);

// ------------------------------------------------------------
//  VIEW: view_user_profile
// ------------------------------------------------------------
$db->exec(
   "CREATE OR REPLACE VIEW view_user_profile AS
    SELECT
        u.id,
        u.role_id,
        u.email,
        u.password_hash,
        p.full_name,
        p.avatar_path,
        r.name AS role_name,
        u.created_at
    FROM users u
    LEFT JOIN user_profiles p ON p.user_id = u.id
    LEFT JOIN roles        r ON r.id      = u.role_id;"
);

// ------------------------------------------------------------
//  FUNCTION: count_favorite_notes
// ------------------------------------------------------------
$db->exec(
    "CREATE OR REPLACE FUNCTION count_favorite_notes(p_user_id INT)
     RETURNS INT LANGUAGE plpgsql AS $$
     BEGIN
         RETURN (SELECT COUNT(*) FROM notes WHERE user_id = p_user_id AND is_favorite);
     END;
     $$;"
);

// ------------------------------------------------------------
//  TRIGGER: automatically set updated_at
// ------------------------------------------------------------
$db->exec(
    "CREATE OR REPLACE FUNCTION trg_set_updated_at() RETURNS TRIGGER AS $$
     BEGIN
         NEW.updated_at = CURRENT_TIMESTAMP;
         RETURN NEW;
     END;
     $$ LANGUAGE plpgsql;"
);

$db->exec("DROP TRIGGER IF EXISTS trg_set_updated_at ON notes;");
$db->exec(
    "CREATE TRIGGER trg_set_updated_at
     BEFORE UPDATE ON notes
     FOR EACH ROW EXECUTE FUNCTION trg_set_updated_at();"
);

// ------------------------------------------------------------
//  SEED: default tags
// ------------------------------------------------------------
$db->exec(
    "INSERT INTO tags(name) VALUES ('work'), ('personal'), ('ideas'), ('important')
     ON CONFLICT DO NOTHING;"
);

// ------------------------------------------------------------
//  SEED: default admin user
// ------------------------------------------------------------
$adminEmail =  getenv('ADMIN_EMAIL');
$adminPass  = password_hash(getenv('ADMIN_PASSWORD'), PASSWORD_DEFAULT);

$roleAdminId = $db->query("SELECT id FROM roles WHERE name = 'admin' LIMIT 1;")->fetchColumn();

$stmt = $db->prepare(
    "INSERT INTO users (role_id, email, password_hash)
     VALUES (:rid, :email, :hash)
     ON CONFLICT(email) DO NOTHING;"
);

$stmt->execute([
    ':rid'  => $roleAdminId,
    ':email'=> $adminEmail,
    ':hash' => $adminPass
]);

echo "Setup complete! All tables are ready.\n";
