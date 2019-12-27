<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191227111346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE contents_channels (content_id VARCHAR(255) NOT NULL, channel_id VARCHAR(255) NOT NULL, PRIMARY KEY(content_id, channel_id))');
        $this->addSql('CREATE INDEX IDX_B8520C8B84A0A3ED ON contents_channels (content_id)');
        $this->addSql('CREATE INDEX IDX_B8520C8B72F5A1AA ON contents_channels (channel_id)');
        $this->addSql('CREATE TABLE channels_devices (channel_id VARCHAR(255) NOT NULL, device_id VARCHAR(255) NOT NULL, PRIMARY KEY(channel_id, device_id))');
        $this->addSql('CREATE INDEX IDX_763AADF972F5A1AA ON channels_devices (channel_id)');
        $this->addSql('CREATE INDEX IDX_763AADF994A4C7D4 ON channels_devices (device_id)');
        $this->addSql('ALTER TABLE contents_channels ADD CONSTRAINT FK_B8520C8B84A0A3ED FOREIGN KEY (content_id) REFERENCES content (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE contents_channels ADD CONSTRAINT FK_B8520C8B72F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channels_devices ADD CONSTRAINT FK_763AADF972F5A1AA FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE channels_devices ADD CONSTRAINT FK_763AADF994A4C7D4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE content DROP CONSTRAINT fk_fec530a972f5a1aa');
        $this->addSql('DROP INDEX idx_fec530a972f5a1aa');
        $this->addSql('ALTER TABLE content DROP channel_id');
        $this->addSql('ALTER TABLE channel DROP CONSTRAINT fk_a2f98e4794a4c7d4');
        $this->addSql('DROP INDEX idx_a2f98e4794a4c7d4');
        $this->addSql('ALTER TABLE channel DROP device_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE contents_channels');
        $this->addSql('DROP TABLE channels_devices');
        $this->addSql('ALTER TABLE content ADD channel_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE content ADD CONSTRAINT fk_fec530a972f5a1aa FOREIGN KEY (channel_id) REFERENCES channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_fec530a972f5a1aa ON content (channel_id)');
        $this->addSql('ALTER TABLE channel ADD device_id VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE channel ADD CONSTRAINT fk_a2f98e4794a4c7d4 FOREIGN KEY (device_id) REFERENCES device (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_a2f98e4794a4c7d4 ON channel (device_id)');
    }
}
