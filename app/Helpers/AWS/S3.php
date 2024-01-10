<?php

namespace App\Helpers\AWS;
use Aws\S3\S3Client;
use Aws\Sdk;

class S3
{
    /**
     * @var Sdk
     */
    public Sdk $sdk;
    public function __construct(Sdk $sdk)
    {
        $this->sdk = $sdk;
    }

    /**
     * Upload file content to AWS S3 and Return file url.
     *
     * @param $fileName
     * @param $sourceFile
     *
     * @return string
     */
    public function upload($fileName, $sourceFile): string
    {
        $bucket = env('AWS_BUCKET');
        $client = $this->getClient();

        $client->putObject([
            'Bucket'     => $bucket,
            'Key'        => $fileName,
            'SourceFile' => $sourceFile
        ]);

        return $client->getObjectUrl($bucket, $fileName);
    }


    /**
     * @return S3Client
     */
    public function getClient(): S3Client
    {
        return $this->sdk->createS3($this->getS3Credentials());
    }

    public function getS3Credentials(): array
    {
        return [
            'version' => 'latest',
            'credentials' => [
                'key' => env('AWS_ACCESS_KEY_ID'),
                'secret' => env('AWS_SECRET_ACCESS_KEY'),
            ],
            'use_path_style_endpoint' => true,
            'bucket' => env('AWS_BUCKET'),
            'region' => env('AWS_DEFAULT_REGION')
        ];
    }
}
