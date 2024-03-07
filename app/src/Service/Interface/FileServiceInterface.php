<?php

namespace App\Service\Interface;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileServiceInterface
{
    /**
     * Handle file uplaod
     *
     * @param UploadedFile $fileToUpload
     * @param string $directory
     * @param ?string $fileToRemove
     * 
     * @return string $safeFilename
     */
    public function upload(UploadedFile $fileToUpload, string $directory, string $fileToRemove = null): string;

    /**
     * Handle file deletion
     * 
     * @param string $fileToRemove
     * @param string $directory
     */
    public function remove(string $fileToRemove, string $directory): void;
}
