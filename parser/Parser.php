<?php

abstract class Parser
{
    protected $dom;
    protected $db;

    public function __construct($path)
    {
        $this->db = new PDO('mysql:host=localhost;dbname=football_french_championship', 'root', '', array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
        ));
        $html = utf8_decode(file_get_contents('https://www.lequipe.fr' . $path));
        $this->dom = new DOMDocument();
        @$this->dom->loadHTML($html);
    }

    abstract public function parse();

    protected function getValue($class, $field, $i = 0)
    {
        $data = $this->getElementByClass($class)->item(0)->getElementsByTagName('strong');
        $refs = $this->getElementByClass($class)->item(0)->getElementsByTagName('td');

        foreach ($data as $key => $value) {
            $value = $value->nodeValue;
            if ($item = $refs->item($i)) {
                if ($field === 'nationality' && strpos($item->nodeValue, 'Pays') !== false) {
                    return $value;
                } else if ($field === 'birthday_date' && strpos($item->nodeValue, 'Né le') !== false) {
                    return $this->dateFormat($value);
                } else if (!$this->getBirthdayPlace() && $field === 'birthday_place' && strpos($item->nodeValue, 'Né le') !== false && $data->item($key + 1)) {
                    return $this->placeFormat($data->item($key + 1)->nodeValue);
                } else if ($field === 'size' && strpos($item->nodeValue, 'Taille') !== false ) {
                    return $this->sizeFormat($value);
                } else if ($field === 'weight' && strpos($item->nodeValue, 'Poids') !== false) {
                    return $this->weightFormat($value);
                } else if ($field === 'poste' && strpos($item->nodeValue, 'Poste') !== false) {
                    return $value;
                } else if ($field === 'number' && strpos($item->nodeValue, 'Numéro') !== false) {
                    return $value;
                }
            }
            $i++;
        }
        return null;
    }

    protected function save()
    {
        $req = 'INSERT INTO ' . static::TABLE . ' (';
        $params = [];

        $fields = array_keys(get_class_vars(get_called_class()));

        foreach ($fields as $field) {
            $methodName = 'get' . ucfirst($field);
            if (method_exists($this, $methodName)) {
                $field = $this->toSnakeCase($field);
                $req .= $field . ', ';
                $params[':' . $field] = $this->$methodName();
            }
        }

        $req = substr($req, 0, -2) . ') VALUES (';

        foreach ($params as $key => $value) {
            $req .= $key . ', ';
        }

        $req = substr($req, 0, -2) . ')';

        $stmt = $this->db->prepare($req);

        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }

        $stmt->execute();

        return $this->db->lastInsertId();
    }

    protected function getElementByClass($name)
    {
        $finder = new DomXPath($this->dom);
        return $finder->query("//*[contains(@class, '$name')]");
    }

    protected function dateFormat($date)
    {
        $month = [
            'janvier',
            'fevrier',
            'mars',
            'avril',
            'mai',
            'juin',
            'juillet',
            'auot',
            'september',
            'octobre',
            'november',
            'décembre',
        ];
        $date = explode(' ', trim($date));
        $m = array_search($date[1], $month) + 1;
        return $date[2] . '-' . $m . '-' . $date[0];
    }

    protected function placeFormat($input)
    {
        return trim(substr($input, 4));
    }

    protected function weightFormat($input)
    {
        return (int) $input;
    }

    protected function sizeFormat($input)
    {
        return str_replace('m', '', $input);
    }

    private function toSnakeCase($input)
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);
        $ret = $matches[0];
        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }
        return implode('_', $ret);
    }
}
