<?php

namespace App\Service;

use App\Service\Interface\FileServiceInterface;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService implements FileServiceInterface
{
    public function __construct(
        private SluggerInterface $slugger,
        private LoggerInterface $logger
    ) {
    }

    public function upload(UploadedFile $fileToUpload, string $directory, string $fileToRemove = null): string
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

    public function remove(string $fileToRemove, string $directory): void
    {
        $fileSystem = new Filesystem();

        $fileSystem->remove($directory . '/' . $fileToRemove);
    }
}
