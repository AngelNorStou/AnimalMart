<?php
require_once '../model/PetsModel.php';

/**
 * PetController
 * Secure controller layer for Pets model
 * Handles request validation only (no SQL / DB logic)
 */
class PetController
{

    private PetsModel $petModel;
    private PDO $conn;

    /**
     * Constructor
     */
    public function __construct(PetsModel $petModel,$conn)
    {
        $this->petModel = $petModel;
        $this->conn = $conn;
    }

    /**
     * Verify and handle ADD pet request
     */
    public function verifyAddPet(array $postData): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        // Extract safely
        $size   = $postData['size']   ?? null;
        $weight = $postData['weight'] ?? null;
        $age    = $postData['age']    ?? null;

        // Validate numeric fields if provided
        if (
            ($size !== null && $size !== '' && !is_numeric($size)) ||
            ($weight !== null && $weight !== '' && !is_numeric($weight)) ||
            ($age !== null && $age !== '' && !is_numeric($age))
        ) {
            return "The pet's size, weight, and age must be numeric values.";
        }

        // Delegate to model (model handles redirect & DB logic)
        $result = $this->petModel->insertPet($postData);

        // If model returns a message, pass it back
        if (is_array($result) && isset($result['success']) && $result['success'] === false) {
            return $result['message'] ?? 'Unable to add pet.';
        }

        return '';
    }

    /**
     * Verify and handle EDIT pet request
     */
    public function verifyEditPet(array $postData): string
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return '';
        }

        // Extract safely
        $size   = $postData['edit_pet_size']   ?? null;
        $weight = $postData['edit_pet_weight'] ?? null;
        $age    = $postData['edit_pet_age']    ?? null;

        // Validate numeric fields if provided
        if (
            ($size !== null && $size !== '' && !is_numeric($size)) ||
            ($weight !== null && $weight !== '' && !is_numeric($weight)) ||
            ($age !== null && $age !== '' && !is_numeric($age))
        ) {
            return "The pet's size, weight, and age must be numeric values.";
        }

        // Delegate to model
        $result = $this->petModel->updatePet($postData);

        if (is_array($result) && isset($result['success']) && $result['success'] === false) {
            return $result['message'] ?? 'Unable to update pet.';
        }

        return '';
    }
}
