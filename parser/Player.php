<?php

class Player extends Parser
{
    const TABLE = 'players';

    /**
     * @var int
     */
    protected $id;

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
    protected $birthdayDate;

    /**
     * @var string
     */
    protected $birthdayPlace;

    /**
     * @var int
     */
    protected $weight;

    /**
     * @var int
     */
    protected $size;

    /**
     * @var string
     */
    protected $nationality;

    /**
     * @var string
     */
    protected $poste;

    /**
     * @var string
     */
    protected $photo;

    /**
     * @var string
     */
    protected $link;

    public function parse()
    {
        $data = $this->getElementByClass('nom_sportif')->item(0);

        if ($data) {
            $this->setShortName($data->nodeValue)
                 ->setName($data->nodeValue)
                 ->setBirthdayDate($this->getValue('identite', 'birthday_date'))
                 ->setBirthdayPlace($this->getValue('identite', 'birthday_place'))
                 ->setSize($this->getValue('identite', 'size', -1))
                 ->setWeight($this->getValue('identite', 'weight', -1))
                 ->setNationality($this->getValue('identite', 'nationality'))
                 ->setPoste($this->getValue('identite', 'poste', -1))
                 ->setPhoto(
                   $this->getElementByClass('visuel')
                        ->item(0)
                        ->getElementsByTagName('img')
                        ->item(0)
                        ->getAttribute('src')
                 )
                 ->setId($this->save());
        }

        return $this;
    }

    public function saveTeam($idTeam)
    {
        if (!$this->getId()) {
          return;
        }
        $number = (int) $this->getValue('identite', 'number', -1);
        $stmt = $this->db->prepare('INSERT INTO players_has_teams (id_player, id_team, `number`) VALUES (:id_player, :id_team, :number)');
        $stmt->bindValue(':id_player', $this->getId());
        $stmt->bindValue(':id_team', $idTeam);
        $stmt->bindValue(':number', $number);
        $stmt->execute();
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
     * Get the value of Birthday Date
     *
     * @return string
     */
    public function getBirthdayDate()
    {
        return $this->birthdayDate;
    }

    /**
     * Set the value of Birthday Date
     *
     * @param string $birthdayDate
     *
     * @return self
     */
    public function setBirthdayDate($birthdayDate)
    {
        $this->birthdayDate = $birthdayDate;

        return $this;
    }

    /**
     * Get the value of Birthday Place
     *
     * @return string
     */
    public function getBirthdayPlace()
    {
        return $this->birthdayPlace;
    }

    /**
     * Set the value of Birthday Place
     *
     * @param string $birthdayPlace
     *
     * @return self
     */
    public function setBirthdayPlace($birthdayPlace)
    {
        $this->birthdayPlace = $birthdayPlace;

        return $this;
    }

    /**
     * Get the value of Weight
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set the value of Weight
     *
     * @param int $weight
     *
     * @return self
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get the value of Size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Set the value of Size
     *
     * @param int $size
     *
     * @return self
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get the value of Nationality
     *
     * @return string
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * Set the value of Nationality
     *
     * @param string $nationality
     *
     * @return self
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;

        return $this;
    }

    /**
     * Get the value of Poste
     *
     * @return string
     */
    public function getPoste()
    {
        return $this->poste;
    }

    /**
     * Set the value of Poste
     *
     * @param string $poste
     *
     * @return self
     */
    public function setPoste($poste)
    {
        $this->poste = $poste;

        return $this;
    }


    /**
     * Get the value of Id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of Id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of Photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * Set the value of Photo
     *
     * @param string $photo
     *
     * @return self
     */
    public function setPhoto($photo)
    {
        $this->photo = 'https:' . $photo;

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

}
