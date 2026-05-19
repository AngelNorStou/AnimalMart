<?php

/**
 * PetView
 * Responsible ONLY for rendering pet-related HTML
 */
class PetView
{
    private PetsModel $petModel;

    public function __construct(PetsModel $petModel)
    {
        $this->petModel = $petModel;
    }

    /**
     * Escape output for HTML
     */
    private function e(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }

    /**
     * Display all pets for a given owner (username)
     */
    public function displayPets(string $owner): string
    {
        $owner = trim($owner);
        if ($owner === '') {
            return '<p class="text-muted">No owner specified.</p>';
        }

        $pets = $this->petModel->displayPetsByUsername($owner);

        if (empty($pets)) {
            return '<p class="text-muted">No pets found for this user.</p>';
        }

        $html = '';

        foreach ($pets as $pet) {
            $petId = (int)($pet['pet_id'] ?? 0);

            $html .= '
                <div class="card col" style="width: 17rem; margin: 2%;">
                    <div class="card-body">
                        <div class="row mb-3">
                            <label class="form-label card-text">Name: ' . $this->e($pet['pet_name'] ?? '') . '</label>
                            <label class="form-label card-text">Type: ' . $this->e($pet['pet_type'] ?? '') . '</label>
                            <label class="form-label card-text">Breed: ' . $this->e($pet['breed'] ?? '') . '</label>
                            <label class="form-label card-text">Gender: ' . $this->e($pet['gender'] ?? '') . '</label>
                            <label class="form-label card-text">Size: ' . $this->e($pet['size'] ?? '') . '</label>
                            <label class="form-label card-text">Weight: ' . $this->e((string)($pet['weight'] ?? '')) . '</label>
                            <label class="form-label card-text">Age: ' . $this->e((string)($pet['age'] ?? '')) . '</label>
                        </div>

                        <a class="btn btn-primary" href="editPet.php?petEdit=' . $petId . '">Edit</a>
                        <a class="btn btn-danger" href="deletePet.php?petDelete=' . $petId . '" onclick="return confirm(\'Are you sure you want to delete this pet?\')">Delete</a>
                    </div>
                </div>
            ';
        }

        return $html;
    }

    /**
     * Safely display a single allowed pet field
     */
    public function displayItem(int $id, string $item): string
    {
        $allowedFields = [
            'pet_name',
            'pet_type',
            'breed',
            'gender',
            'size',
            'weight',
            'age'
        ];

        if ($id <= 0 || !in_array($item, $allowedFields, true)) {
            return '';
        }

        $pet = $this->petModel->displayPetById($id);

        if (!$pet || !isset($pet[$item])) {
            return '';
        }

        return $this->e((string)$pet[$item]);
    }

    /**
     * Display gender <option> elements securely
     */
    public function displayGender(int $id): string
    {
        if ($id <= 0) {
            return '';
        }

        $pet = $this->petModel->displayPetById($id);

        if (!$pet || !isset($pet['gender'])) {
            return '';
        }

        $gender = $pet['gender'];

        if ($gender === 'M') {
            return '
                <option value="M" selected>Male</option>
                <option value="F">Female</option>
            ';
        }

        return '
            <option value="M">Male</option>
            <option value="F" selected>Female</option>
        ';
    }
}
