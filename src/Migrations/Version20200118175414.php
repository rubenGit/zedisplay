<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200118175414 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE symfony_demo_post_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE symfony_demo_tag_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE symfony_demo_comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE symfony_demo_post (id INT NOT NULL, author_id VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, summary VARCHAR(255) NOT NULL, content TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_58A92E65F675F31B ON symfony_demo_post (author_id)');
        $this->addSql('CREATE TABLE symfony_demo_post_tag (post_id INT NOT NULL, tag_id INT NOT NULL, PRIMARY KEY(post_id, tag_id))');
        $this->addSql('CREATE INDEX IDX_6ABC1CC44B89032C ON symfony_demo_post_tag (post_id)');
        $this->addSql('CREATE INDEX IDX_6ABC1CC4BAD26311 ON symfony_demo_post_tag (tag_id)');
        $this->addSql('CREATE TABLE establishment (id VARCHAR(255) NOT NULL, group_company_id VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DBEFB1EE40567B64 ON establishment (group_company_id)');
        $this->addSql('CREATE INDEX IDX_DBEFB1EE19EB6921 ON establishment (client_id)');
        $this->addSql('CREATE TABLE symfony_demo_tag (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4D5855405E237E06 ON symfony_demo_tag (name)');
        $this->addSql('CREATE TABLE symfony_demo_user (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, enabled BOOLEAN NOT NULL, full_name VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, plain_password VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1F85E0677 ON symfony_demo_user (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8FB094A1E7927C74 ON symfony_demo_user (email)');
        $this->addSql('CREATE INDEX IDX_8FB094A119EB6921 ON symfony_demo_user (client_id)');
        $this->addSql('CREATE TABLE content (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, url VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FEC530A919EB6921 ON content (client_id)');
        $this->addSql('CREATE TABLE group_company (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C9BF5D4319EB6921 ON group_company (client_id)');
        $this->addSql('CREATE TABLE channel (id VARCHAR(255) NOT NULL, client_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_A2F98E4719EB6921 ON channel (client_id)');
        $this->addSql('CREATE TABLE channel_content (channel_id VARCHAR(255) NOT NULL, content_id VARCHAR(255) NOT NULL, PRIMARY KEY(channel_id, content_id))');
        $this->addSql('CREATE INDEX IDX_49860FA872F5A1AA ON channel_content (channel_id)');
        $this->addSql('CREATE INDEX IDX_49860FA884A0A3ED ON channel_content (content_id)');
        $this->addSql('CREATE TABLE symfony_demo_comment (id INT NOT NULL, post_id INT NOT NULL, author_id VARCHAR(255) NOT NULL, content TEXT NOT NULL, published_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_53AD8F834B89032C ON symfony_demo_comment (post_id)');
        $this->addSql('CREATE INDEX IDX_53AD8F83F675F31B ON symfony_demo_comment (author_id)');
        $this->addSql('CREATE TABLE device (id VARCHAR(255) NOT NULL, establishment_id VARCHAR(255) DEFAULT NULL, client_id VARCHAR(255) DEFAULT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_92FB68E8565851 ON device (establishment_id)');
        $this->addSql('CREATE INDEX IDX_92FB68E19EB6921 ON device (client_id)');
        $this->addSql('CREATE TABLE device_channel (device_id VARCHAR(255) NOT NULL, channel_id VARCHAR(255) NOT NULL, PRIMARY KEY(device_id, channel_id))');
        $this->addSql('CREATE INDEX IDX_284F57DA94A4C7D4 ON device_channel (device_id)');
        $this->addSql('CREATE INDEX IDX_284F57DA72F5A1AA ON device_channel (channel_id)');
        $this->addSql('CREATE TABLE client (id VARCHAR(255) NOT NULL, name_client VARCHAR(255) NOT NULL, company_name VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, postal_code VARCHAR(255) NOT NULL, contact_person_phone VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE symfony_demo_post ADD CONSTRAINT FK_58A92E65F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC44B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_post_tag ADD CONSTRAINT FK_6ABC1CC4BAD26311 FOREIGN KEY (tag_id) REFERENCES symfony_demo_tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment ADD CONSTRAINT FK_DBEFB1EE40567B64 FOREIGN KEY (group_company_id) REFERENCES group_company (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE establishment ADD CONSTRAINT FK_DBEFB1EE19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_user ADD CONSTRAINT FK_8FB094A119EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT FK_FEC530A919EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE group_company ADD CONSTRAINT FK_C9BF5D4319EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT FK_A2F98E4719EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel_content ADD CONSTRAINT FK_49860FA872F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channel_content ADD CONSTRAINT FK_49860FA884A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F834B89032C FOREIGN KEY (post_id) REFERENCES symfony_demo_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE symfony_demo_comment ADD CONSTRAINT FK_53AD8F83F675F31B FOREIGN KEY (author_id) REFERENCES symfony_demo_user (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E8565851 FOREIGN KEY (establishment_id) REFERENCES establishment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device ADD CONSTRAINT FK_92FB68E19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_channel ADD CONSTRAINT FK_284F57DA94A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE device_channel ADD CONSTRAINT FK_284F57DA72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP CONSTRAINT FK_6ABC1CC44B89032C');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP CONSTRAINT FK_53AD8F834B89032C');
        $this->addSql('ALTER TABLE device DROP CONSTRAINT FK_92FB68E8565851');
        $this->addSql('ALTER TABLE symfony_demo_post_tag DROP CONSTRAINT FK_6ABC1CC4BAD26311');
        $this->addSql('ALTER TABLE symfony_demo_post DROP CONSTRAINT FK_58A92E65F675F31B');
        $this->addSql('ALTER TABLE symfony_demo_comment DROP CONSTRAINT FK_53AD8F83F675F31B');
        $this->addSql('ALTER TABLE channel_content DROP CONSTRAINT FK_49860FA884A0A3ED');
        $this->addSql('ALTER TABLE establishment DROP CONSTRAINT FK_DBEFB1EE40567B64');
        $this->addSql('ALTER TABLE channel_content DROP CONSTRAINT FK_49860FA872F5A1AA');
        $this->addSql('ALTER TABLE device_channel DROP CONSTRAINT FK_284F57DA72F5A1AA');
        $this->addSql('ALTER TABLE device_channel DROP CONSTRAINT FK_284F57DA94A4C7D4');
        $this->addSql('ALTER TABLE establishment DROP CONSTRAINT FK_DBEFB1EE19EB6921');
        $this->addSql('ALTER TABLE symfony_demo_user DROP CONSTRAINT FK_8FB094A119EB6921');
        $this->addSql('ALTER TABLE content DROP CONSTRAINT FK_FEC530A919EB6921');
        $this->addSql('ALTER TABLE group_company DROP CONSTRAINT FK_C9BF5D4319EB6921');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT FK_A2F98E4719EB6921');
        $this->addSql('ALTER TABLE device DROP CONSTRAINT FK_92FB68E19EB6921');
        $this->addSql('DROP SEQUENCE symfony_demo_post_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE symfony_demo_tag_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE symfony_demo_comment_id_seq CASCADE');
        $this->addSql('DROP TABLE symfony_demo_post');
        $this->addSql('DROP TABLE symfony_demo_post_tag');
        $this->addSql('DROP TABLE establishment');
        $this->addSql('DROP TABLE symfony_demo_tag');
        $this->addSql('DROP TABLE symfony_demo_user');
        $this->addSql('DROP TABLE content');
        $this->addSql('DROP TABLE group_company');
        $this->addSql('DROP TABLE channel');
        $this->addSql('DROP TABLE channel_content');
        $this->addSql('DROP TABLE symfony_demo_comment');
        $this->addSql('DROP TABLE device');
        $this->addSql('DROP TABLE device_channel');
        $this->addSql('DROP TABLE client');
    }
}
