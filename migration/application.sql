CREATE SCHEMA IF NOT EXISTS simple_messenger;

CREATE TABLE IF NOT EXISTS simple_messenger."user"
(
    id            SERIAL       NOT NULL,
    name          VARCHAR(100) NOT NULL,
    surname       VARCHAR(150) NOT NULL,
    email         VARCHAR(255)
        CONSTRAINT user_email_key
            UNIQUE             NOT NULL,
    password      VARCHAR(255) NOT NULL,
    api_key       VARCHAR(32)  NOT NULL,
    created       TIMESTAMP WITH TIME ZONE,
    created_by_id INT,
    updated       TIMESTAMP WITH TIME ZONE,
    updated_by_id INT,
    PRIMARY KEY (id),
    FOREIGN KEY (created_by_id) REFERENCES simple_messenger."user" (id) ON UPDATE CASCADE ON DELETE SET NULL,
    FOREIGN KEY (updated_by_id) REFERENCES simple_messenger."user" (id) ON UPDATE CASCADE ON DELETE SET NULL
);