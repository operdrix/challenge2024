<?php

namespace App\Service;

use Monolog\Logger;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService
{
    public function __construct(
        private SluggerInterface $slugger,
        private Logger $logger
    ) {
    }

    public function upload(UploadedFile $fileToUpload, string $directory, string $fileToRemove = null)
    {
        $originalFilename = pathinfo($fileToUpload->getClientOriginalExtension(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $filename = $safeFilename . '-' . uniqid() . '.' . $fileToUpload->guessExtension();

        try {
            $fileToUpload->move($directory, $filename);

            if (!is_null($fileToRemove)) {
                $this->remove($fileToRemove, $directory);
            }
        } catch (FileException $error) {
            $this->logger->error("Error while trying to uplad file : " . $error->getMessage());
        }

        return $filename;
    }

    public function remove(string $fileToRemove, string $directory)
    {
        $fileSystem = new Filesystem();

        $fileSystem->remove($directory . '/' . $fileToRemove);
    }
}
