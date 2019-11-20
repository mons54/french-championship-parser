<?php

class Stadium extends Parser
{
    const TABLE = 'stadiums';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $adress;

    /**
     * @var string
     */
    protected $tel;

    /**
     * @var int
     */
    protected $capacity;

    public function parse()
    {
        $data = $this->getElementByClass('stade')->item(0)->getElementsByTagName('strong');

        foreach ($data as $key => $value) {
            $value = $value->nodeValue;
            if ($key === 0) {
                $this->setName($value);
            } else if ($key === 1) {
                $this->setCapacity((int) $value);
            } else if ($key === 2) {
                $this->setAdress($value);
            } else if ($key === 3) {
                $this->setTel($value);
            }
        }

        return $this->save();
    }

    /**
     * Get the value of Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of Name
     *
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of Adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set the value of Adress
     *
     * @param string $adress
     *
     * @return self
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get the value of Tel
     *
     * @return string
     */
    public function getTel()
    {
        return $this->tel;
    }

    /**
     * Set the value of Tel
     *
     * @param string $tel
     *
     * @return self
     */
    public function setTel($tel)
    {
        $this->tel = $tel;

        return $this;
    }

    /**
     * Get the value of Capacity
     *
     * @return int
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set the value of Capacity
     *
     * @param int $capacity
     *
     * @return self
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;

        return $this;
    }
}
