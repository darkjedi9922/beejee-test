<?php namespace base;

/**
 * Data in this cookies is loaded and then removed immediately.
 * Use this class for example to transmit validation errors. 
 */
class FlashCookies
{
    private $name;
    private $data = [];

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->data = $this->loadData();
        $this->removeData();
    }

    public function getData(): array
    {
        return $this->data;
    }

    public function saveData(array $allData)
    {
        setcookie($this->name, json_encode($allData), 0, '/');
        $this->data = $allData;
    }

    private function loadData()
    {
        return json_decode($_COOKIE[$this->name] ?? '{}', true);
    }

    private function removeData()
    {
        setcookie($this->name, '', time() - 3600, '/');
    }
}