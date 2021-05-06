<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210506120101 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('Update values set only_type=\'["apartment", "house", "commercial"]\'::JSONB where only_type=\'[]\'::JSONB');
        $this->addSql('update "characteristics" set "id"=\'7ff70c40-c43d-4881-b577-ae73bf1f573a\' where alias =\'without_percents\'');
        $this->addSql('update "characteristics" set "id"=\'0228f9b8-d689-469d-bb19-aa77cb985351\' where alias =\'first_fee\'');
        $this->addSql('update "characteristics" set "id"=\'8443442d-31cf-40f6-9987-4afca2e408fc\' where alias =\'flats_amount\'');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'74849289-750d-4370-83a5-232fbef2167f\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "Минеральная вата"}, "ua": {"label": "Минеральная вата"}}\', 1, 1, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 718);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'caa3f2ec-3b99-4b26-b1da-f982658ea37c\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "стеклофибробетон"}, "ua": {"label": "стеклофибробетон"}}\', 2, 2, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 719);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'a6fa3d22-1560-4159-80a3-866e26794335\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "керамогранитная плитка"}, "ua": {"label": "керамогранитная плитка"}}\', 3, 3, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 720);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'4ece03ab-2c83-4112-a1c7-0fa675d17f5a\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "пенополистирол"}, "ua": {"label": "пенополистирол"}}\', 4, 4, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 721);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'816fbe85-ffdd-4585-acb1-dcddf7331806\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "базальтовая вата"}, "ua": {"label": "базальтовая вата"}}\', 5, 5, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 722);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'58e6bd81-ac06-4a32-aa32-f3102c149e88\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{"ru": {"label": "Минеральная каменная плита"}, "ua": {"label": "Минеральная каменная плита"}}\', 6, 6, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 723);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'a7613704-1b2c-4069-91d3-edfdc42caab8\', \'426ba835-89a0-4b60-8086-0006e63531e5\', \'{"ru": {"label": "Закрытая"}, "ua": {"label": "Закрытая"}}\', 1, 1, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 724);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'00ed2ea1-0b08-4dd8-99ae-0f11720fb97a\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{"ru": {"label": "подземная"}, "ua": {"label": "подземная"}}\', 1, 1, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 725);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'80b2bd55-f228-4d2e-9028-21ca528c9634\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{"ru": {"label": "подземная и гостевая"}, "ua": {"label": "подземная и гостевая"}}\', 2, 2, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 726);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'36ac5e96-1c0c-44a7-96c8-beea2beda994\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{"ru": {"label": "гостевой"}, "ua": {"label": "гостевой"}}\', 3, 3, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 727);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'a18d710c-dd7e-4b1c-84b1-669a577d8204\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{"ru": {"label": "наземный"}, "ua": {"label": "наземный"}}\', 4, 4, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 728);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'12894331-d28e-4d8b-a71a-4849dc47de04\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{"ru": {"label": "подземная, наземная и гостевая"}, "ua": {"label": "подземная, наземная и гостевая"}}\', 5, 5, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 729);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'84fd0f76-98dc-4034-a1b2-1bb29ee8260b\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{"ru": {"label": "охрана"}, "ua": {"label": "охрана"}}\', 1, 1, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 730);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'3c29bbd3-90da-42c2-b731-4c2c849cc61e\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{"ru": {"label": "Консьерж"}, "ua": {"label": "Консьерж"}}\', 2, 2, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 731);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'51abed9b-d64a-4ef8-a7f0-a37705b126d8\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{"ru": {"label": "охрана и консьерж"}, "ua": {"label": "охрана и консьерж"}}\', 3, 3, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 732);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'7253d5a8-26d2-4dba-a436-80ab06a5fc1d\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{"ru": {"label": "консерж - сервис"}, "ua": {"label": "консерж - сервис"}}\', 4, 4, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 733);');
        $this->addSql('INSERT INTO "values" ("id", "fk_char", "i18n", "key", "default_sort", "only_type", "service_config", "created_at", "old_vector_id") VALUES (\'a5785eac-823c-4190-b01a-c6c592b15e04\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{"ru": {"label": "охрана, консерж - серви, управление, уборка"}, "ua": {"label": "охрана, консерж - серви, управление, уборка"}}\', 5, 5, \'[]\', \'{}\', \'2021-05-06 08:40:01\', 734);');

        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'b3b3d8d9-c989-4980-b5d1-7c9f7f9e59d9\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'0228f9b8-d689-469d-bb19-aa77cb985351\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'7ff70c40-c43d-4881-b577-ae73bf1f573a\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'a9690c9a-8b00-023c-83db-f58bd6b9666c\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'8443442d-31cf-40f6-9987-4afca2e408fc\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'426ba835-89a0-4b60-8086-0006e63531e5\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'13908407-cb74-4bd8-bb24-be207473b24f\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'eea1aa2b-95df-4838-94de-6a2fdc6a130d\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'25aa46f2-622f-4497-b244-b28e9292ca1c\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'25aa46f2-622f-4497-b244-b28e9292ca1d\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'25aa46f2-622f-4497-b244-b28e9292ca1a\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'5c55b070-966c-4cc8-a4d4-595ee3ceeb08\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'5c55b070-966c-4cc8-a4d4-595ee3ceeb07\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'5c55b070-966c-4cc8-a4d4-595ee3ceeb06\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'385063aa-78e1-4f87-8a34-8b14a19451dd\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
        $this->addSql('INSERT INTO "representation_values" ("fk_rep_uuid", "fk_characteristic", "rep_char_values", "settings") VALUES (\'22dfa2fc-8b17-40bf-b9ca-cfca49f1aaf4\', \'36d223c6-aa81-4560-ba07-a7c2e27d39b9\', \'{}\', \'{"rowId": 0, "types": ["apartment_complex"], "rowOrder": 0}\');');
    }

    public function down(Schema $schema) : void
    {
    }
}
