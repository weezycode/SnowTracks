<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Image;
use App\Entity\Trick;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


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
}
