<?php

class Team extends Parser
{
    const TABLE = 'teams';

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $shortName;

    /**
     * @var string
     */
    protected $fundationDate;

    /**
     * @var string
     */
    protected $president;

    /**
     * @var string
     */
    protected $adress;

    /**
     * @var string
     */
    protected $website;

    /**
     * @var int
     */
    protected $idStadium;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $logo;

    public function parse()
    {
        $data = $this->getElementByClass('nom_sportif')->item(0);
        $this->setShortName($data->nodeValue);

        $this->setLogo(
          $this->getElementByClass('visuels-club')
               ->item(0)
               ->getElementsByTagName('img')
               ->item(0)
               ->getAttribute('src')
        );

        $data = $this->getElementByClass('identite')->item(0)->getElementsByTagName('strong');

        foreach ($data as $key => $value) {
            $value = $value->nodeValue;
            if ($key === 0) {
                $this->setName($value);
            } else if ($key === 1) {
                $this->setFundationDate($value . '-01-01');
            } else if ($key === 2) {
                $this->setPresident($value);
            }
        }

        $data = $this->getElementByClass('data-content')->item(4)->getElementsByTagName('strong');

        foreach ($data as $key => $value) {
            $value = $value->nodeValue;
            if ($key === 0) {
                $this->setWebsite($value);
            } else if ($key === 2) {
                $this->setAdress($value);
            }
        }

        return $this->save();
    }

    public function getPlayersLinks()
    {
        $links = [];

        $data = $this->getElementByClass('effectifclub')->item(0)->getElementsByTagName('a');

        foreach ($data as $key => $value) {
            $links[] = $value->getAttribute('href');
        }

        return $links;
    }

    public function getCoachLink()
    {
        return $this->getElementByClass('identite')->item(0)->getElementsByTagName('a')->item(0)->getAttribute('href');
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
     * Get the value of Short Name
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }

    /**
     * Set the value of Short Name
     *
     * @param string $shortName
     *
     * @return self
     */
    public function setShortName($shortName)
    {
        $this->shortName = $shortName;

        return $this;
    }

    /**
     * Get the value of Fundation Date
     *
     * @return string
     */
    public function getFundationDate()
    {
        return $this->fundationDate;
    }

    /**
     * Set the value of Fundation Date
     *
     * @param string $fundationDate
     *
     * @return self
     */
    public function setFundationDate($fundationDate)
    {
        $this->fundationDate = $fundationDate;

        return $this;
    }

    /**
     * Get the value of President
     *
     * @return string
     */
    public function getPresident()
    {
        return $this->president;
    }

    /**
     * Set the value of President
     *
     * @param string $president
     *
     * @return self
     */
    public function setPresident($president)
    {
        $this->president = $president;

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
     * Get the value of Website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Set the value of Website
     *
     * @param string $website
     *
     * @return self
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }


    /**
     * Get the value of Id Stadium
     *
     * @return int
     */
    public function getIdStadium()
    {
        return $this->idStadium;
    }

    /**
     * Set the value of Id Stadium
     *
     * @param int $idStadium
     *
     * @return self
     */
    public function setIdStadium($idStadium)
    {
        $this->idStadium = $idStadium;

        return $this;
    }


    /**
     * Get the value of Link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of Link
     *
     * @param string $link
     *
     * @return self
     */
    public function setLink($link)
    {
        $this->link = static::BASE_LINK . $link;

        return $this;
    }

    /**
     * Get the value of Logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set the value of Logo
     *
     * @param string $logo
     *
     * @return self
     */
    public function setLogo($logo)
    {
        $this->logo = 'https:' . $logo;

        return $this;
    }

}
