<?php

class GoogleAccessTokenObject
{
    public readonly string $accessToken;
    public readonly int $expiresAt;
    public readonly string $scope;
    public readonly string $tokenType;
    public readonly string $idToken;
    public readonly int $createdAt;


    public function __construct(array $params)
    {
        $requiredParams = [
            'access_token',
            'expires_in',
            'scope',
            'token_type',
            'id_token',
            'created'
        ];

        $missingKeys = array_diff(array_keys($params), $requiredParams);

        if (count($missingKeys) > 0)
        {
            throw new Exception("Missing required fields in access token array: " . implode(', ', $missingKeys));
        }

        $this->accessToken = $params['access_token'];
        $this->createdAt = $params['created'];
        $this->expiresAt = $this->createdAt + $params['expires_in'];
        $this->idToken = $params['id_token'];
        $this->tokenType = $params['token_type'];
        $this->scope = $params['scope'];
    }
}