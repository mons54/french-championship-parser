<?php

class Teams extends Parser
{
    public function parse()
    {
        $links = [];

        $data = $this->getElementByClass('Points')->item(0)->getElementsByTagName('a');

        foreach ($data as $key => $value) {
            $links[] = $value->getAttribute('href');
        }

        return $links;
    }
}
