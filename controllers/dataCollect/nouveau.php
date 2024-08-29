<?php


function comptesNouveau($request, $db)
{
    $viewVars = [
        "message" => null,
        "error" => null,
    ];


    // handle form submission
    if ($request->isPost()) {

    }

    return $viewVars;
}

$vars = comptesNouveau($this->request, $this->db);
extract($vars);
