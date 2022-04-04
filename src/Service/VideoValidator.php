<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Video;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VideoValidator extends AbstractController
{

    /**
     * @param string $value
     * @return string
     */

    public function setUrl(string $value): string
    {
        $url = "/^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube\.com|youtu.be))(\/(?:[\w\-]+\?v=|embed\/|v\/)?)([\w\-]+)(\S+)?$/";

        preg_match($url, $value, $matches);

        if (empty($matches[5])) {
            throw $this->createNotFoundException('Cette url n\'est pas bonne !');
        }
        return $matches[5];
    }

    /**
     * @param Video $video
     * @param ?string $url
     */
    public function getYoutubeUrl(Video $video): void
    {

        $video->setUrl('https://www.youtube.com/embed/' . $this->setUrl($video->getUrl()));
    }
}
