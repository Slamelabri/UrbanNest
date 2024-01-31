<?php

namespace App\Service;

use Cloudinary\Api\Admin\AdminApi;
use Cloudinary\Api\ApiResponse;
use Cloudinary\Api\Exception\ApiError;
use Cloudinary\Api\Upload\UploadApi;
use Cloudinary\Configuration\Configuration;

class CloudinaryService
{

    public function __construct(private $cloudinary){
    }

    public function upload($file, $options = []): ApiResponse{
        Configuration::instance([
            'cloud' => [
                'cloud_name' => $this->cloudinary['cloud_name'],
                'api_key' => $this->cloudinary['api_key'],
                'api_secret' => $this->cloudinary['api_secret']],
            'url' => [
                'secure' => true]]);
        return (new UploadApi())->upload($file, $options);
    }
}