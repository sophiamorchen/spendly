DROP TABLE IF EXISTS expense;            -- dépend de user et category → en premier
DROP TABLE IF EXISTS category;           -- ne dépend de rien
DROP TABLE IF EXISTS user;               -- ne dépend de rien


CREATE TABLE IF NOT EXISTS user (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(255) UNIQUE COLLATE utf8mb4_unicode_ci NOT NULL,
    password VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS category (
    id_category INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    name VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS expense (
    id_expense INT PRIMARY KEY AUTO_INCREMENT,
    amount DECIMAL(15,2) NOT NULL,
    title VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL,
    expense_date DATE NOT NULL,
    id_category INT NOT NULL,
    id_user INT NOT NULL,
    FOREIGN KEY (id_category) REFERENCES category (id_category),
    FOREIGN KEY (id_user) REFERENCES user (id_user)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;