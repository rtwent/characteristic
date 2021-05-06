<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506093902 extends AbstractMigration
{
    public function getDescription(): string
    {
        /**
         *
         *

         *
         */
        return 'Apartment complex characteristics';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'b3b3d8d9-c989-4980-b5d1-7c9f7f9e59d9\',  \'site\', \'{"ru": {"label": "сайт", "short": "сайт"}, "ua": {"label": "сайт", "short": "сайт"}}\',\'{}\', \'string\',235,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'6d8c83d5-3281-4a1f-2396-78945c339fa3\',  \'first_fee\', \'{"ru": {"label": "Первый взнос", "short": "Взнос"}, "ua": {"label": "Первый взнос", "short": "Взнос"}}\',\'{}\', \'boolean\',236,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'6d8c83d5-3281-4a1f-2396-78945c339fa2\',  \'without_percents\', \'{"ru": {"label": "Без процентов", "short": "Без процентов"}, "ua": {"label": "Без процентов", "short": "Без процентов"}}\',\'{}\', \'boolean\',239,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'a9690c9a-8b00-023c-83db-f58bd6b9666c\',  \'warming\', \'{"ru": {"label": "Утепление", "short": "Утепление"}, "ua": {"label": "Утепление", "short": "Утепление"}}\',\'{}\', \'fk\',240,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'1b4f999e-db97-6d21-c044-3090e2640f1b\',  \'flats_amount\', \'{"ru": {"label": "Всего квартир", "short": "Квартир"}, "ua": {"label": "Всего квартир", "short": "Квартир"}}\',\'{}\', \'int\',241,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'426ba835-89a0-4b60-8086-0006e63531e5\',  \'territory\', \'{"ru": {"label": "Территория", "short": "Территория"}, "ua": {"label": "Территория", "short": "Территория"}}\',\'{}\', \'fk\',242,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'13908407-cb74-4bd8-bb24-be207473b24f\',  \'parking_type\', \'{"ru": {"label": "Тип парковки", "short": "Тип парковки"}, "ua": {"label": "Тип парковки", "short": "Тип парковки"}}\',\'{}\', \'fk\',243,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'eea1aa2b-95df-4838-94de-6a2fdc6a130d\',  \'services\', \'{"ru": {"label": "Обслуживание", "short": "Обслуживание"}, "ua": {"label": "Обслуживание", "short": "Обслуживание"}}\',\'{}\', \'fk\',244,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'25aa46f2-622f-4497-b244-b28e9292ca1c\',  \'center_distance\', \'{"ru": {"label": "До центра", "short": "До центра"}, "ua": {"label": "До центра", "short": "До центра"}}\',\'{}\', \'int\',245,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'25aa46f2-622f-4497-b244-b28e9292ca1d\',  \'sea_distance\', \'{"ru": {"label": "До моря", "short": "До моря"}, "ua": {"label": "До моря", "short": "До моря"}}\',\'{}\', \'int\',246,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'25aa46f2-622f-4497-b244-b28e9292ca1a\',  \'shops_distance\', \'{"ru": {"label": "До магазинов", "short": "До магазинов"}, "ua": {"label": "До магазинов", "short": "До магазинов"}}\',\'{}\', \'int\',247,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'5c55b070-966c-4cc8-a4d4-595ee3ceeb08\',  \'school_distance\', \'{"ru": {"label": "До школы", "short": "До школы"}, "ua": {"label": "До школы", "short": "До школы"}}\',\'{}\', \'int\',248,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'5c55b070-966c-4cc8-a4d4-595ee3ceeb07\',  \'kindergarten_distance\', \'{"ru": {"label": "До садика", "short": "До садика"}, "ua": {"label": "До садика", "short": "До садика"}}\',\'{}\', \'int\',249,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'5c55b070-966c-4cc8-a4d4-595ee3ceeb06\',  \'business_center_distance\', \'{"ru": {"label": "До бизнес центра", "short": "До бизнес центра"}, "ua": {"label": "До бизнес центра", "short": "До бизнес центра"}}\',\'{}\', \'int\',250,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'385063aa-78e1-4f87-8a34-8b14a19451dd\',  \'adv_description\', \'{"ru": {"label": "Реклама", "short": "Реклама"}, "ua": {"label": "Реклама", "short": "Реклама"}}\',\'{}\', \'string\',251,\'{}\',\'2021-05-05 19:43:01\');');
        $this->addSql('INSERT INTO "characteristics" ("id", "alias", "i18n", "property", "type", "old_vector_id", "old_form_builder", "created_at") VALUES (\'36d223c6-aa81-4560-ba07-a7c2e27d39b9\',  \'complex_name\', \'{"ru": {"label": "Название комплекса", "short": "Название комплекса"}, "ua": {"label": "Название комплекса", "short": "Название комплекса"}}\',\'{}\', \'string\',252,\'{}\',\'2021-05-05 19:43:01\');');
    }

    public function down(Schema $schema): void
    {
    }
}
