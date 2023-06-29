<?php
require_once "App/config/connection.php";

class VoteController
{
    public function index()
    {
        
        require_once __DIR__ . '/RegionController.php';
        require_once __DIR__ . '/CandidateController.php';
        require_once __DIR__ . '/KnowusController.php';

        $data = [
            'regions' => RegionController::getRegions(),
            'candidates' => CandidateController::getCandidates(),
            'checkboxs' => KnowusController::getCheckboxsKnowus(),
        ];
        
        require_once __DIR__ . '/../views/vote.view.php';
    }

    public function create()
    {
        require_once __DIR__ . '/../Models/VoteModel.php';
        $voteModel = new VoteModel(Database::getInstance()->getConnection());
        $resp = $voteModel->saveVote($_POST);
        echo json_encode($resp);
    }

}