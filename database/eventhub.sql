

DROP DATABASE IF EXISTS eventhub;
CREATE DATABASE eventhub;
USE eventhub;


CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    username      VARCHAR(50)  NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role          ENUM('admin', 'organizer', 'user') NOT NULL DEFAULT 'user'
);


CREATE TABLE events (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    title       VARCHAR(150) NOT NULL,
    description TEXT,
    event_date  DATETIME NOT NULL,
    capacity    INT NOT NULL,
    owner_id    INT NOT NULL,
    CONSTRAINT fk_events_owner
        FOREIGN KEY (owner_id) REFERENCES users(id)
        ON DELETE CASCADE
);


CREATE TABLE registrations (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    user_id    INT NOT NULL,
    event_id   INT NOT NULL,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_reg_user
        FOREIGN KEY (user_id) REFERENCES users(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_reg_event
        FOREIGN KEY (event_id) REFERENCES events(id)
        ON DELETE CASCADE,
    CONSTRAINT uq_user_event UNIQUE (user_id, event_id) 
);


INSERT INTO users (username, password_hash, role) VALUES
('alice',   'hash_alice_123',   'admin'),
('bob',     'hash_bob_456',     'organizer'),
('charlie', 'hash_charlie_789', 'organizer'),
('diana',   'hash_diana_101',   'user'),
('erwan',   'hash_erwan_112',   'user'),
('fatima',  'hash_fatima_131',  'user'),
('gabriel', 'hash_gabriel_141', 'user');


INSERT INTO events (title, description, event_date, capacity, owner_id) VALUES
('Conférence Web Dev 2026',    'Les tendances du développement web pour 2026', '2026-09-15 09:00:00', 100, 2),
('Atelier React & Node.js',    'Atelier pratique full-stack',                  '2026-09-22 14:00:00', 30,  2),
('Meetup Cybersécurité',       'Discussion sur les failles récentes',          '2026-10-01 18:30:00', 50,  3),
('Hackathon HEPIA',            'Compétition de dev en 24h',                    '2026-10-10 08:00:00', 80,  3),
('Soirée Networking Tech',     'Rencontre entre développeurs et entreprises',  '2026-11-05 19:00:00', 60,  1);


INSERT INTO registrations (user_id, event_id, created_at) VALUES
(4, 1, '2026-08-01 10:15:00'),
(5, 1, '2026-08-02 11:00:00'),
(6, 1, '2026-08-03 09:30:00'),
(4, 2, '2026-08-05 16:20:00'),
(7, 2, '2026-08-06 12:00:00'),
(5, 3, '2026-08-10 08:45:00'),
(6, 4, '2026-08-12 17:00:00'),
(7, 4, '2026-08-13 10:00:00'),
(4, 4, '2026-08-14 14:30:00'),
(5, 5, '2026-08-15 09:00:00');