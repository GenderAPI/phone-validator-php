<?php

/**
 * GenderAPI.io Phone Number Validation SDK for PHP
 *
 * This lightweight SDK allows you to validate, format, and analyze
 * phone numbers using the GenderAPI Phone Validation & Formatter API.
 *
 * Features:
 *   - Validates phone numbers from all over the world
 *   - Supports E.164 formatting
 *   - Returns metadata such as line type, region, and carrier
 *
 * API Documentation: https://genderapi.io/docs/phone-validation-formatter-api
 */
class PhoneValidator
{
    private $apiKey;
    private $baseUrl;

    /**
     * PhoneValidator constructor.
     *
     * @param string $apiKey Your GenderAPI Bearer token.
     * @param string $baseUrl Optional API base URL. Default: https://api.genderapi.io
     */
    public function __construct($apiKey, $baseUrl = 'https://api.genderapi.io')
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Validate and analyze a phone number.
     *
     * @param string $number The phone number to validate. (Required)
     * @param string|null $address Optional full address or country code to improve region detection.
     * @return array The API response as an associative array.
     * @throws \Exception
     */
    public function validate($number, $address = null)
    {
        return $this->postRequest('/api/phone', [
            'number' => $number,
            'address' => $address
        ]);
    }

    /**
     * Internal helper to send POST requests via cURL.
     *
     * @param string $endpoint API endpoint (e.g. /api/phone)
     * @param array $payload Request payload
     * @return array Decoded JSON response
     * @throws \Exception
     */
    private function postRequest($endpoint, array $payload)
    {
        $url = $this->baseUrl . $endpoint;

        $payload = array_filter($payload, fn($v) => $v !== null);

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->apiKey,
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);

        curl_close($ch);

        if ($curlError) {
            throw new \Exception("cURL error: $curlError");
        }

        if (in_array($httpCode, [500, 502, 503, 504, 408])) {
            throw new \Exception("Server error ($httpCode).");
        }

        $json = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Invalid JSON response.");
        }

        return $json;
    }
}
