<?php
/**
 * Created by PhpStorm.
 * User: isk
 * Date: 16.02.18
 * Time: 15:41
 */

namespace App\Service\Uploads;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface ImageInterface
{
    /**
     * @return string|null
     */
    public function getPlace();

    /**
     * @param int $place
     * @return void
     */
    public function setPlace(int $place): void;

    /**
     * @return UploadedFile|null
     */
    public function getUrl();

    /**
     * @param UploadedFile $uploadedFile
     */
    public function setUrl(UploadedFile $uploadedFile): void;


}