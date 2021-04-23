<?php
declare(strict_types=1);


namespace App\Entity\ValueObjects;


use App\Enum\LangsEnum;
use App\Exceptions\ValueObjectConstraint;
use App\Interfaces\ToArray;

final class I18nValuesVO implements \JsonSerializable, ToArray
{
    /**
     * @var I18nValuesVO[]
     */
    private array $i18nFields;

    /**
     * @param array $i18nFields
     * @throws ValueObjectConstraint
     */
    public function __construct(array $i18nFields)
    {
        $this->i18nFields = $this->setI18nFields($i18nFields);
    }

    public function jsonSerialize()
    {
        return json_encode($this->i18nFields, \JSON_UNESCAPED_UNICODE);
    }

    public function toArray(): array
    {
        return json_decode($this->jsonSerialize(), true);
    }

    public function singleLanguage(string $lang): I18nValuesVO
    {
        if (!LangsEnum::accepts($lang)) {
            throw new ValueObjectConstraint(sprintf("Lang %s is not presented in LangEnum", $lang));
        }

        if (!array_key_exists($lang, $this->toArray())) {
            return new I18nValuesVO("-");
        }

        return $this->i18nFields[$lang];
    }

    /**
     * @param array $i18nFields
     * @return array
     * @throws ValueObjectConstraint
     */
    private function setI18nFields(array $i18nFields): array
    {
        $langFromParam = array_keys($i18nFields);
        $langFromEnum = LangsEnum::values();
        $diff = array_diff($langFromEnum, $langFromParam);
        if (count($diff) > 0) {
            throw new ValueObjectConstraint(sprintf("Incorrect keys %s for setting language", implode(', ', $diff)));
        }

        foreach ($i18nFields as $i18nField) {
            if (!$i18nField instanceof I18nValuesVO) {
                throw new ValueObjectConstraint("Instance of I18nValuesVO expected");
            }
        }

        return $i18nFields;
    }


}