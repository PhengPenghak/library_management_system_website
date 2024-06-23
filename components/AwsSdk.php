<?php

namespace app\components;

use yii\base\Component;
use Aws;
use Aws\CommandPool;
use yii\helpers\Inflector;

class AwsSdk extends Component
{
  /*
	 * @var array specifies the AWS credentials
	 */
  public $credentials = [];

  /*
	 * @var string specifies the AWS region
	 */
  public $region = null;

  /*
	 * @var string specifies the AWS version
	 */
  public $version = null;

  /*
	 * @var string specifies the AWS S3 bucket
	 */
  public $defaultBucket = null;

  /*
	 * @var string specifies the server url that use get file. Because, we don't have permission get file direct from S3
	 */
  public $defaultBaseUrl = null;

  /*
	 * @var array specifies extra params
	 */
  public $extra = [];

  /** 
   * @var string specifies the AWS S3 folder. Default is `null` 
   * 
   * When setup this value, you must use `/` as separator.
   * 
   * The folder will be created automatically if not exists.
   * 
   * If you don't want to create folder, please set this value to `null`.
   * 
   * @example $defaultFolder 
   * ```php
   * 		$defaultFolder = 'uploads/';
   * 		$defaultFolder = 'uploads/images/';	
   * 		$defaultFolder = 'uploads/images/avatars/';
   * 		[
   * 			// ....
   * 			'defaultFolder' => $defaultFolder
   *      	// ....
   * 		]
   * ```
   */
  public $defaultFolder = null;

  /**
   * @var Aws\Sdk instance
   */
  protected $_awssdk;

  /**
   * @var Aws\S3\S3Client instance
   */
  protected $_s3;

  /**
   * Initializes (if needed) and fetches the AWS SDK instance
   * @return Aws\Sdk instance
   */
  public function getAwsSdk(): Aws\Sdk
  {
    if (empty($this->_awssdk) || !$this->_awssdk instanceof Aws\Sdk) {
      $this->setAwsSdk();
    }
    return $this->_awssdk;
  }

  /**
   * Sets the AWS SDK instance
   */
  public function setAwsSdk()
  {
    $this->_awssdk = new Aws\Sdk(array_merge([
      'credentials' => $this->credentials,
      'region' => $this->region,
      'version' => $this->version
    ], $this->extra));
  }

  /**
   * Initializes (if needed) and fetches the AWS S3 instance
   * @return Aws\S3\S3Client
   */
  public function getS3Client(): Aws\S3\S3Client
  {
    if (empty($this->_s3) || !$this->_s3 instanceof Aws\S3\S3Client) {
      $this->setS3Client();
    }

    return $this->_s3;
  }

  /**
   * Sets the AWS S3 instance
   */
  public function setS3Client()
  {
    $this->_s3 = $this->getAwsSdk()->createS3();
  }

  /**
   * Get aws bucket name
   * @return ?string
   */
  public function getBucket(): ?string
  {
    return $this->defaultBucket;
  }

  /**
   * Sets the bucket name
   */
  public function setBucket($bucket)
  {
    $this->defaultBucket = $bucket;
  }

  /**
   * Upload file to S3
   * @param array $args
   * @return Aws\Result
   * @example $args
   * ```php
   * $imageFile = UploadedFile::getInstance($model, 'imageFile');
   * 
   * $result = $awssdk->upload([
   *  'Key' => $key, 
   *  'Body' => $imageFile->name, 
   *  'SourceFile' => $imageFile->tempName,
   *  'Content-Type' => $imageFile->type,
   *  'acl' => 'public-read', 
   * ]);
   * ```
   */
  public function upload($args = []): Aws\Result
  {
    $client = $this->getS3Client();
    return $client->putObject(array_merge([
      'Bucket' => $this->getBucket(),
    ], $args));
  }

  /**
   * Upload multiple files to S3
   * @param string $args	
   * @deprecated use `uploadMany` insteal
   * @example $args
   * ```php
   * $results = $awssdk->uploadMultiple([
   * 	[
   * 		'Key' => 'file1.txt',
   * 		'Body' => fopen('file1.txt', 'r')
   * 	],
   * 	[
   * 		'Key' => 'file2.txt',
   * 		'Body' => fopen('file2.txt', 'r')
   * 	]
   * ]);
   * ```
   */
  public function uploadMultiple($args = [])
  {
    $client = $this->getS3Client();
    /** @var Aws\CommandInterface $commands */
    $commands = [];
    foreach ($args as $arg) {
      $commands[] = $client->getCommand(
        'PutObject',
        array_merge(['Bucket' => $this->getBucket()], $arg)
      );
    }

    return CommandPool::batch($client, $commands);
  }

  /**
   * Upload multiple files to S3
   * @param string $args	
   * @example $args
   * ```php
   * 
   * $files = UploadedFile::getInstances($model, 'files');
   * 
   * $args = [];
   * foreach($files as $file){
   *   $key = $awssdk->generateKey($file->name);
   *   $args[] = [
   *     'Key' => $key,
   *     'Body' => $file->name,
   *     'SourceFile' => $file->tempName,
   *     'Content-Type' => $file->type,
   *     'acl' => 'public-read', 
   *   ]
   * }
   * $results = $awssdk->uploadMany($args)
   * 
   * // Or
   * 
   * $results = $awssdk->uploadMany([
   * 	[
   * 		'Key' => 'file1.txt',
   * 		'Body' => fopen('file1.txt', 'r')
   * 	],
   * 	[
   * 		'Key' => 'file2.txt',
   * 		'Body' => fopen('file2.txt', 'r')
   * 	]
   * ]);
   * ```
   */
  public function uploadMany($args = [])
  {
    $client = $this->getS3Client();
    /** @var Aws\CommandInterface $commands */
    $commands = [];
    foreach ($args as $arg) {
      $commands[] = $client->getCommand(
        'PutObject',
        array_merge(['Bucket' => $this->getBucket()], $arg)
      );
    }

    return CommandPool::batch($client, $commands);
  }

  /**
   * Copy a file from the same bucket in S3
   * @param array $args
   * @return Aws\Result
   * 
   * @example $args
   * ```php
   * $result = $awssdk->copy([
   *   'Key' => 'file1.txt',
   *   'CopySource' => 'file1-copy.txt',
   * ])
   * ```
   */
  public function copy($args = []): Aws\Result
  {
    $client = $this->getS3Client();

    return $client->copyObject(array_merge([
      'Bucket' => $this->getBucket(),
    ], $args));
  }

  /**
   * Copy many files from the same bucket in S3
   * @param string $args	
   * @example $args
   * ```php
   * 
   * $results = $awssdk->copyMany([
   * 	[
   * 		'Key' => 'file1.txt',
   * 		'CopySource' => 'file1-copy.txt',
   * 	],
   * 	[
   * 		'Key' => 'file2.txt',
   * 		'CopySource' => 'file2-copy.txt',
   * 	]
   * ]);
   * ```
   */
  public function copyMany($args = [])
  {
    $client = $this->getS3Client();

    /** @var Aws\CommandInterface $commands */
    $commands = [];

    foreach ($args as $arg) {
      $commands[] = $client->getCommand(
        'CopyObject',
        array_merge(['Bucket' => $this->getBucket()], $arg)
      );
    }

    return CommandPool::batch($client, $commands);
  }

  /**
   * Delete file from S3
   * @param array $args
   * @return Aws\Result
   */
  public function delete(array $args = []): Aws\Result
  {
    $client = $this->getS3Client();
    return $client->deleteObject(array_merge([
      'Bucket' => $this->getBucket(),
    ], $args));
  }

  /**
   * Delete file from S3 by key
   * @param string $key
   * @return Aws\Result
   */
  public function deleteByKey(string $key): Aws\Result
  {
    return $this->delete([
      'Key' => $key,
    ]);
  }

  /**
   * Delete multiple files from S3
   * @param array $args
   * @example $args
   * ```php
   * $results = $awssdk->deleteMultiple([
   * 	[
   * 		'Key' => 'file1.txt',
   * 	],
   * 	[
   * 		'Key' => 'file2.txt',
   * 	]
   * ]);
   * ```
   */
  public function deleteMultiple(array $args = [])
  {
    $client = $this->getS3Client();
    /** @var Aws\CommandInterface $commands */
    $commands = [];
    foreach ($args as $arg) {
      $commands[] = $client->getCommand(
        'DeleteObject',
        array_merge(['Bucket' => $this->getBucket()], $arg)
      );
    }

    return CommandPool::batch($client, $commands);
  }

  /**
   * Delete multiple files from S3 by key
   * @param array $keys
   * @example $keys
   * ```php
   * $results = $awssdk->deleteMultipleByKey([
   * 	'file1.txt',
   * 	'file2.txt',
   * ]);
   * ```
   */
  public function deleteMultipleByKey(array $keys)
  {
    $args = [];
    foreach ($keys as $key) {
      $args[] = [
        'Key' => $key,
      ];
    }

    return $this->deleteMultiple($args);
  }

  /**
   * Generate file key
   * @param string $name
   * @return string
   */
  public function generateKey(string $name): string
  {
    $folder = ltrim($this->getFolder() ?? '', '/');
    $filename =  Inflector::slug(pathinfo($name, PATHINFO_FILENAME));
    $g = \Yii::$app->security->generateRandomString(10);
    $extension = pathinfo($name, PATHINFO_EXTENSION);
    return ltrim(sprintf("%s/%s-%s.%s", $folder, $filename, $g, $extension), '/');
  }

  /**
   * Get download url
   */
  public function getBaseUrl()
  {
    return $this->defaultBaseUrl;
  }

  /**
   * Update donwload url
   */
  public function setBaseUrl(string $url)
  {
    $this->defaultBaseUrl = $url;
  }

  /**
   * Get folder name
   */
  public function getFolder()
  {
    return $this->defaultFolder;
  }

  /**
   * Update folder name
   */
  public function setFolder(string $folder)
  {
    $this->defaultFolder = $folder;
  }

  /**
   * Return the image url with custom some options
   * 
   * @param string $key
   * @param int $width
   * @param int $height
   * @return string
   * @example $key
   * ```php
   * Yii::$app->awssdk->getImageUrl($key, $width, $height);
   * ```
   */
  public function getImageUrl(string $key, ?int $width = null, ?int $height = null)
  {
    $client = $this->getS3Client();
    // if ($client->doesObjectExist($this->getBucket(), $key)) {
    //   if (!$width && !$height) {
    //     return  sprintf('%s/%s', $this->getBaseUrl(), $key);
    //   }
    //   return sprintf("%s/%sx%s/%s", $this->getBaseUrl(), $width, $height, $key);
    // }
    if ($client->doesObjectExist($this->getBucket(), $key)) {
      return "https://s3.ap-southeast-1.amazonaws.com/" . $this->getBaseUrl() . "/" . $key;
    }
    return $this->getUrl('logo-placeholder.png');
  }

  /**
   * Get file url with sign
   * @param string $key
   * @param string $expires Default '+20 minutes'
   * @return string
   */
  public function getPresignedUrl(string $key, string $expires = '+20 minutes')
  {
    $client = $this->getS3Client();
    $command = $client->getCommand('GetObject', [
      'Bucket' => $this->getBucket(),
      'Key' => $key,
    ]);
    $request = $client->createPresignedRequest($command, $expires);
    return (string) $request->getUri();
  }

  /**
   * Download file 
   * @param string $key
   * @param string $expires Default '+20 minutes'
   * @return string
   */
  public function downloadByKey(string $key, string $expires = '+90 minutes')
  {
    return $this->getPresignedUrl($key, $expires);
  }

  /**
   * Get file url
   * @param string $key
   * @return string
   */
  public function getUrl(string $key)
  {
    $client = $this->getS3Client();
    if ($client->doesObjectExist($this->getBucket(), $key)) {
      return sprintf("%s/%s", $this->getBaseUrl(), $key);
    }
    return $this->getUrl('logo-placeholder.png');
  }
}
