<?php

set_time_limit(1000);

spl_autoload_register(function ($name) {
    include_once 'parser/' . $name . '.php';
});

$teams  = new Teams('/Football/ligue-1/page-classement-equipes/general');
$teamsLinks = $teams->parse();

foreach ($teamsLinks as $key => $teamLink) {
    $stadium = new Stadium($teamLink);
    $idStadium = $stadium->parse();
    $team = new Team($teamLink);
    $team->setIdStadium($idStadium);
    $idTeam = $team->parse();
    $playersLinks = $team->getPlayersLinks();
    foreach ($playersLinks as $playerLink) {
        $player = new Player($playerLink);
        $idPlayer = $player->parse()->saveTeam($idTeam);
    }
    $coachLink = $team->getCoachLink();
    $coach = new Coach($coachLink);
    $coach->parse()->saveTeam($idTeam);
}
