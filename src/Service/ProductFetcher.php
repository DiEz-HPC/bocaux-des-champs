<?php

namespace App\Service;

use Bolt\Repository\ContentRepository;

class ProductFetcher
{
    /** @var ContentRepository */
    private $contentRepository;

    public function __construct(ContentRepository $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function fetch($id)
    {
        // Find record with specific ID
        $record = $this->contentRepository->find($id);

        // Get all records matching criteria, e.g. Content Type
       // $entries = $this->contentRepository->findBy([
      //     'contentType' => 'entries'
      //  ]);

       
        // Find by the record slug
      //  $aboutUs = $this->contentRepository->findOneBySlug('about-us');


        // Let's return some records here.
        return $record;
    }
}