<?php
declare(strict_types=1);


namespace App\Services\Locale;


use App\Enum\LangsEnum;

final class CurrentLanguage
{
    private static ?CurrentLanguage $instance = null;
    private string $currentLang = '';

    public static function getInstance(): CurrentLanguage
    {
        if (\is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function currentLang(): string
    {
        return $this->currentLang;
    }

    public function setLang(string $lang): void
    {
        if (!LangsEnum::accepts($lang)) {
            throw new \Exception(sprintf("Lang %s is not supported", $lang));
        }

        if (!$this->currentLang === '') {
            throw new \Exception(sprintf("Language was already set with value %s", $lang));
        }

        $this->currentLang = $lang;
    }

    protected function __construct()
    {
    }

    protected function __clone()
    {
    }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }
}