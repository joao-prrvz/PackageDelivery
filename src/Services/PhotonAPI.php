<?php
namespace PackageDelivery\Services;

class PhotonAPI {
    public function __construct(
        private string $baseUrl
    ) { }

    /**
     * Undocumented function
     *
     * @param string $address
     * @return array{features: array{type:string, geometry: array{coordinates: float[]}}[]}|null
     */
    public function search(string $address): array|null {
        $query = urlencode($address);
        $url = "{$this->baseUrl}/?q={$query}";
        $response = file_get_contents($url);
        $result = json_decode($response, true);
        if (!isset($result["features"]))
            null;
        if (count($result["features"]) < 1)
            return null;
        return $result;
    }
}