<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\User;
use App\Entity\Image;
use App\Entity\Trick;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;


class ImageUploader extends AbstractController
{

    public function uploadImage(Trick $trick, array $images): void
    {
        foreach ($images as $image) {
            $fileName = md5(uniqid()) . '.' . $image->guessExtension();
            $image->move(
                $this->getParameter('figure_directory'),
                $fileName
            );
            $img = new Image();
            $img->setFilename($fileName);
            if (count($images) === 1) {
                $img->setMain(true);
            } else {
                $img->setMain(false);
            }
            $trick->addImage($img);
        }
    }


    public function uploadAvatar(UploadedFile $image)
    {

        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $originalFilename;
        $fileName = $safeFilename . '-' . uniqid() . '.' . $image->guessExtension();
        try {
            $image->move($this->getParameter('figure_directory'), $fileName);
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        return $fileName;
    }

    /**
     * @param array $images
     * 
     */
    public function removeImage($images): void
    {

        unlink(
            $this->getParameter('figure_directory') . '/' .
                $images
        );
    }
}
