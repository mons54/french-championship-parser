<?php

class Coach extends Parser
{
    const TABLE = 'coachs';

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
    protected $birthdayDate;

    /**
     * @var string
     */
    protected $birthdayPlace;

    /**
     * @var string
     */
    protected $nationality;

    public function parse()
    {
        $data = $this->getElementByClass('nom_sportif')->item(0);
        $this->setName($data->nodeValue);

        $this->setBirthdayDate($this->getValue('identite', 'birthday_date'));
        $this->setBirthdayPlace($this->getValue('identite', 'birthday_place'));
        $this->setNationality($this->getValue('identite', 'nationality'));

        $this->setId($this->save());

        return $this;
    }

    public function saveTeam($idTeam)
    {
        $stmt = $this->db->prepare('INSERT INTO coachs_has_teams (id_coach, id_team) VALUES (:id_coach, :id_team)');
        $stmt->bindValue(':id_coach', $this->getId());
        $stmt->bindValue(':id_team', $idTeam);
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

}
