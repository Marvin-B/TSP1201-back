<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230315132515 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE talent (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(30) NOT NULL, color INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_pokemon (type_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_4AFDFF06C54C8C93 (type_id), INDEX IDX_4AFDFF062FE71C3E (pokemon_id), PRIMARY KEY(type_id, pokemon_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE type_pokemon ADD CONSTRAINT FK_4AFDFF06C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE type_pokemon ADD CONSTRAINT FK_4AFDFF062FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE pokemon ADD talent_id INT NOT NULL, CHANGE description description LONGTEXT NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD CONSTRAINT FK_62DC90F318777CEF FOREIGN KEY (talent_id) REFERENCES talent (id)');
        $this->addSql('CREATE INDEX IDX_62DC90F318777CEF ON pokemon (talent_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon DROP FOREIGN KEY FK_62DC90F318777CEF');
        $this->addSql('ALTER TABLE type_pokemon DROP FOREIGN KEY FK_4AFDFF06C54C8C93');
        $this->addSql('ALTER TABLE type_pokemon DROP FOREIGN KEY FK_4AFDFF062FE71C3E');
        $this->addSql('DROP TABLE talent');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE type_pokemon');
        $this->addSql('DROP INDEX IDX_62DC90F318777CEF ON pokemon');
        $this->addSql('ALTER TABLE pokemon DROP talent_id, CHANGE description description VARCHAR(255) DEFAULT NULL');
    }
}
