
DROP DATABASE IF EXISTS `rinky`;

CREATE DATABASE `rinky`;

CREATE TABLE `rinky`.`ingredients` (
    `id` INT(12) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `abv` DECIMAL(5.2),
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rinky`.`recipes` (
    `id` INT(12) NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255),
    `instructions` TEXT,
    `description` TEXT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `rinky`.`recipes_ingredients` (
    `ingredient_id` INT(12) NOT NULL,
    `recipe_id` INT(12) NOT NULL,
    `amount` INT(5),
    PRIMARY KEY (`ingredient_id`, `recipe_id`),
    CONSTRAINT `fk_ingredients` FOREIGN KEY (`ingredient_id`) REFERENCES `ingredients`(`id`),
    CONSTRAINT `fk_recipe` FOREIGN KEY (`recipe_id`) REFERENCES `recipes`(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `rinky`.`recipes` (`id`, `name`, `instructions`, `description`)
    VALUES
        (1, 'Cosmopolitan', 'Add all ingredients into cocktail shaker filled with ice. Shake well and double strain into large cocktail glass. Garnish with lime wheel.', 'Pink, stylish and delicious.'),
        (2, 'Mojito', 'Mint sprigs muddled with sugar and lime juice. Rum added and topped with soda water. Garnished with sprig of mint leaves. Served with a straw.', 'A traditional cuban highball cocktail.'),
        (3, 'Long Island Iced Tea', 'Mix ingredients in glass over ice, stir, garnish and serve.', 'A very strong cocktail that does not contain tea.');

INSERT INTO `rinky`.`ingredients` (`id`, `name`, `abv`)
    VALUES
        (1, 'Vodka', 41),
        (2, 'Cointreau', 40),
        (3, 'Lime Juice', 0),
        (4, 'Cranberry Juice', 0),
        (5, 'White Rum', 38),
        (6, 'Soda Water', 0),
        (7, 'Tequila', 39),
        (8, 'Triple Sec', 30),
        (9, 'Gin', 70),
        (10, 'Lemon Juice', 0),
        (11, 'Sugar Syrup', 0),
        (12, 'Coke', 0);


INSERT INTO `rinky`.`recipes_ingredients` (`recipe_id`, `ingredient_id`, `amount`)
    VALUES
        (1, 1, 40), (1, 2, 15), (1, 3, 15), (1, 4, 30),
        (2, 5, 40), (2, 3, 30), (2, 6, 50),
        (3, 1, 15), (3, 7, 15), (3, 5, 15), (3, 8, 15), (3, 9, 15), (3, 10, 25), (3, 11, 30), (3, 12, 25);

