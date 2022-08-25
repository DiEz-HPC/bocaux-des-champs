<?php

namespace App;

use Bolt\Entity\Taxonomy;
use Doctrine\ORM\EntityManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TagCloudTwigExtension extends AbstractExtension
{
    /** @var EntityManagerInterface */
    private $objectManager;

    public function __construct(EntityManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('tag_cloud_videos', [$this, 'tagCloudVideos']),
        ];
    }

    public function tagCloudVideos() {
        $om = $this->objectManager;
        $qb = $om->createQueryBuilder();
        $qb->select("t.name, t.slug")
            ->addSelect("count(c) as count")
            ->from(Taxonomy::class, 't')
            ->leftJoin('t.content', 'c')
            ->where("t.type = 'videos-tags'")
            ->groupBy("t.id")
            ->orderBy("t.name");
        $query = $qb->getQuery();
        $results = $query->getResult();
        return $results;
    }
}