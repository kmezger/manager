<?php

class CharacterController extends Controller {
    private $characterModel;

    public function __construct() {
        parent::__construct();
        $this->characterModel = $this->loadModel('Character');
    }

    public function index() {
        $characters = $this->characterModel->all();
        $this->view->render('characters/index.twig', [
            'characters' => $characters,
            'title' => 'DSA Charakterübersicht'
        ]);
    }
    public function show($id) {
        $character = $this->characterModel->load($id);
        if (!$character) {
            $this->redirect('characters');
        }
        $this->view->render('characters/show.twig', [
            'character' => $character,
            'talents' => $this->characterModel->getTalents(),
            'title' => 'Charakter: ' . $character['char_name']
        ]);
    }

    public function create() {
        $this->view->render('characters/create.twig', [
            'title' => 'Neuer Charakter'
        ]);
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'race' => $_POST['race'] ?? '',
                'profession' => $_POST['profession'] ?? '',
                'experience' => $_POST['experience'] ?? 0
            ];

            $this->characterModel->create($data);
            $this->redirect('characters');
        }
    }

    public function edit($id) {
        $character = $this->characterModel->load($id);
        if (!$character) {
            $this->redirect('characters');
        }
        $this->view->render('characters/edit.twig', [
            'character' => $character,
            'title' => 'Charakter bearbeiten'
        ]);
    }

    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'race' => $_POST['race'] ?? '',
                'profession' => $_POST['profession'] ?? '',
                'experience' => $_POST['experience'] ?? 0
            ];

            $this->characterModel->update($id, $data);
            $this->redirect('characters/' . $id);
        }
    }

    public function destroy($id) {
        $this->characterModel->delete($id);
        $this->redirect('characters');
    }
}