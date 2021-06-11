<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210611062007 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Seeding measurement units';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'m\', \'{"ru": {"label": "м."}, "ua": {"label": "м."}}\', \'2021-06-11 09:21:51\')');
        $meterId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=1 where "id" in (\'e50c8fbb-2868-479b-9899-b3148864c26e\',\'42d5ef0d-271a-4df4-8f7e-2ad96d977057\',\'0aeb5a02-1d77-4e1f-a43c-9da63e92d4fe\',\'ca6e5b41-9946-4f0e-8a81-dd85e00dfc35\',\'d5a0fd3b-64cc-4aa3-97a7-d9031c048a0c\')');

        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'sqm\', \'{"ru": {"label": "кв.м."}, "ua": {"label": "кв.м."}}\', \'2021-06-11 09:21:51\')');
        $squareMeterId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=2 where "id" in (\'76102fc0-1c09-4f53-90ec-e0922ba54bae\',\'1d9af683-4962-4ed8-b86d-a4c8e36260ae\',\'eba4abef-1acd-4590-8e96-6e540f8ebe51\',\'075326d4-eb9b-4a91-9b52-be32821e7a8b\',\'b0850dfb-f045-4af5-9b1a-b88a29218d07\',\'f0853803-3ce3-4b74-abeb-ca680dbdfdf5\',\'4a0f37a2-2060-4317-846b-645c7f127aa6\',\'5ccfb83b-80c1-499f-a437-167465f358d9\',\'7f67c86d-2eee-4fd6-90d1-8826d664c43a\',\'b22d72ff-9ca7-4855-9028-66e99f817f78\',\'1c261a89-0315-454e-9032-2ed47680d362\',\'99d2eefa-0938-4ef4-9d23-a6d1532777c1\',\'4b11ab3b-8d1d-4b7a-ab55-1d0d51fe3f4d\')');

        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'akr\', \'{"ru": {"label": "сот."}, "ua": {"label": "сот."}}\', \'2021-06-11 09:21:51\')');
        $akrId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=3 where "id" in (\'1d9af683-4962-4ed8-b86d-a4c8e36260ae\',\'5ccfb83b-80c1-499f-a437-167465f358d9\')');

        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'y\', \'{"ru": {"label": "г."}, "ua": {"label": "р."}}\', \'2021-06-11 09:21:51\')');
        $yearId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=4 where "id" in (\'385e94fc-1586-44dc-ac57-c8ec590f1ba9\',\'639aafb6-3721-437a-af89-3cfac92f9b82\')');

        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'min\', \'{"ru": {"label": "мин."}, "ua": {"label": "хв."}}\', \'2021-06-11 09:21:51\')');
        $minId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=5 where "id" in (\'5c55b070-966c-4cc8-a4d4-595ee3ceeb06\',\'25aa46f2-622f-4497-b244-b28e9292ca1c\',\'5c55b070-966c-4cc8-a4d4-595ee3ceeb07\',\'5c55b070-966c-4cc8-a4d4-595ee3ceeb08\',\'25aa46f2-622f-4497-b244-b28e9292ca1d\',\'25aa46f2-622f-4497-b244-b28e9292ca1a\',\'7f006ce5-7d3e-40a4-a98c-ea89a9343ec6\')');

        $this->addSql('INSERT INTO "public"."measure_units" ("si_name", "i18n", "created_at") VALUES (\'km\', \'{"ru": {"label": "км."}, "ua": {"label": "км."}}\', \'2021-06-11 09:21:51\')');
        $kmId = $this->connection->lastInsertId();
        $this->addSql('update "characteristics" set measure_unit_id=6 where "id" in (\'801f1060-fc55-487c-a1ed-102d53521784\')');
    }

    public function down(Schema $schema): void
    {
    }
}
