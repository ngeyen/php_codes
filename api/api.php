<?php
require_once __DIR__ . '/models/family_code.php';
require_once __DIR__ . '/utils/generate.php';
require_once __DIR__ . '/database/crud.php';

/**
 * Class API
 * Handles operations related to family codes.
 */

class API
{

    private $familyCodeCRUD;

    public function __construct($db)
    {
        $this->familyCodeCRUD = new FamilyCodeCRUD($db);
    }


    /**
     * Retrieve family codes from the database and return as JSON, We are also able to label family codes that are in use.
     *
     * @return string JSON representation of an array of FamilyCode objects.
     */
    public function fetchAllFamilyCodes()
    {
        $familyCodes = $this->familyCodeCRUD->fetchAll();

        // Create an array to hold the family codes data.
        $codes = [];

        foreach ($familyCodes as $familyCodeData) {
            $codes[] = [
                'id' => $familyCodeData['id'],
                'code' => $familyCodeData['code'],
                'is_registered' => $familyCodeData['is_registered'],
                'date_registered' => $familyCodeData['date_registered']
            ];
        }

        // Create a JSON response with the array of codes.
        $response = json_encode($codes);

        return $response;
    }


    /**
     * Retrieve a family code by its code and return as JSON.
     *
     * @param string $code The family code to fetch.
     * @return string JSON representation of the FamilyCode object.
     */
    public function fetchFamilyCode($code)
    {
        // Check if the code exists in the database.
        $familyCodeData = $this->familyCodeCRUD->fetchByCode($code);

        if (!$familyCodeData) {
            return json_encode(['error' => 'Family code not found']);
        }

        // Create a FamilyCode model
        $familyCode = new FamilyCode(
            $familyCodeData['id'],
            $familyCodeData['code'],
            $familyCodeData['is_registered'],
            $familyCodeData['date_registered']
        );

        // Encode the FamilyCode model as JSON and return it
        return json_encode($familyCode);
    }

    /**
     * Retrieve a family code by its code and return as JSON.
     *
     * @param string $code The family code to fetch.
     * @return string JSON representation of the FamilyCode object.
     */
    function flagFamilyCode($code)
    {

        // Check if the code exists in the database.
        $familyCodeData = $this->familyCodeCRUD->fetchByCode($code);

        // If the code does not exist, return an error response.
        if (!$familyCodeData) {
            return json_encode(['error' => 'Family code not found']);
        }

        // Update the 'is_registered' field using FamilyCodeCRUD.
        $isUpdated = $this->familyCodeCRUD->updateIsRegistered($code);
        if ($isUpdated) {
            $response = json_encode(['message' => 'Family code is now registered']);
        } else {
            $response = json_encode(['error' => 'Failed to update family code']);
        }

        // Return the response.
        return $response;
    }

    /**
     * Generate and create new FamilyCode records with unique codes.
     *
     * @param string $prefix The prefix for generating unique codes.
     * @param int $batchSize The number of unique codes to generate and create.
     *
     * @return string JSON-encoded response with a list of created FamilyCode records or an error message.
     */
    function generateBatchCodes($prefix, $batchSize)
    {
        $codesList = [];

        // Check if the prefix length is greater than or equal to 8 characters
        if (strlen($prefix) >= 8) {
            http_response_code(400);
            $response = json_encode(['error' => 'Prefix longer than 8 characters']);
            return $response;
        }

        for ($i = 0; $i < $batchSize; $i++) {
            $code = generateCode($prefix);

            // Check if the code generator returns false
            if ($code === false) {
                http_response_code(400);
                $response = json_encode(['error' => 'Prefix longer than 8 characters']);
                return $response;
            }

            // Check if the code already exists in the database
            $familyCode = $this->familyCodeCRUD->fetchByCode($code);
            if (!$familyCode) {

                $newCode = $this->familyCodeCRUD->create($code);
                $codesList[] = $newCode;
            }
        }

        return json_encode($codesList);
    }


}

?>