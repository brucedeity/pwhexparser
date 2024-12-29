<?php

namespace App\Contracts;

abstract class Translate
{
    private string $lang = 'pt-BR';

    private string $langFilePath;

    public function setLang(string $lang = 'pt-BR') : void
    {
        $this->lang = $lang;
        $this->langFilePath = __DIR__ . '/../../lang/' . $this->lang . '/' . $this->getClassFileName().'.php';

        if (!file_exists($this->langFilePath)) {
            throw new \Exception('Language: ' . $this->lang . ' not available yet at path: "' . $this->langFilePath . '"');
        }
    }

    public function getTranslatedStructure() : array
    {
        if (!$this->langFilePath) {
            throw new \Exception('Language not set yet, please call setLang() method before calling getTranslatedStructure()!');
        }

        return require($this->langFilePath);
    }

    public function getClassFileName() : string
    {
        $parts = explode('\\', get_called_class());
        $name = end($parts);

        return $name;
    }
    
    public function getStructure(): array
    {
        return [];
    }

    public function getMinimumLength(): int32
    {
        return 0;
    }
}
