<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240809181733 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE food_category (food_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_2E013E83BA8E87C4 (food_id), INDEX IDX_2E013E8312469DE2 (category_id), PRIMARY KEY(food_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_category (menu_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_2A1D5C57CCD7E912 (menu_id), INDEX IDX_2A1D5C5712469DE2 (category_id), PRIMARY KEY(menu_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', api_token VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE food_category ADD CONSTRAINT FK_2E013E83BA8E87C4 FOREIGN KEY (food_id) REFERENCES food (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE food_category ADD CONSTRAINT FK_2E013E8312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C57CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C5712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDEB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_E00CEDDEB1E7706E ON booking (restaurant_id)');
        $this->addSql('ALTER TABLE menu ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE menu ADD CONSTRAINT FK_7D053A93B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_7D053A93B1E7706E ON menu (restaurant_id)');
        $this->addSql('ALTER TABLE picture ADD restaurant_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89B1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89B1E7706E ON picture (restaurant_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE food_category DROP FOREIGN KEY FK_2E013E83BA8E87C4');
        $this->addSql('ALTER TABLE food_category DROP FOREIGN KEY FK_2E013E8312469DE2');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C57CCD7E912');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C5712469DE2');
        $this->addSql('DROP TABLE food_category');
        $this->addSql('DROP TABLE menu_category');
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDEB1E7706E');
        $this->addSql('DROP INDEX IDX_E00CEDDEB1E7706E ON booking');
        $this->addSql('ALTER TABLE booking DROP restaurant_id');
        $this->addSql('ALTER TABLE menu DROP FOREIGN KEY FK_7D053A93B1E7706E');
        $this->addSql('DROP INDEX IDX_7D053A93B1E7706E ON menu');
        $this->addSql('ALTER TABLE menu DROP restaurant_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89B1E7706E');
        $this->addSql('DROP INDEX IDX_16DB4F89B1E7706E ON picture');
        $this->addSql('ALTER TABLE picture DROP restaurant_id');
    }
}
