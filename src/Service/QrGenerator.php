<?php

namespace App\Service;

use ZipArchive;
use Bolt\Entity\Content;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Response;
use Endroid\QrCodeBundle\Response\QrCodeResponse;

class QrGenerator
{
    private BuilderInterface $qrBuilder;
    const QR_CODE_ZIP_FILE = '/tmp/qrCode/qrCode.zip';
    const QR_CODE_IMAGE_DIRECTORY = '/tmp/qrCode/images';

    public function __construct(BuilderInterface $customQrCodeBuilder)
    {
        $this->qrBuilder = $customQrCodeBuilder;
    }

    public function getQRs(array $slugs): array
    {       
        return $this->generateLink($slugs);
    }


    private function generateLink(array $slugs): array
    {
        $serverLink = $_SERVER['SYMFONY_DEFAULT_ROUTE_URL'];
        $qrcodes = [];
        foreach ($slugs as $slug => $contentType) {
            $link = $serverLink . $contentType . '/' . $slug;
            $qrcodes[$slug] = $this->generateQr($link, $slug);
        }
        $this->ZipFile();
        return $qrcodes;
    }

    private function generateQr(string $link, string $slug)
    {
        $result = $this->qrBuilder
            ->size(400)
            ->margin(20)
            ->data($link)
            ->build();
        $qrCode = new QrCodeResponse($result);
       $this->createImage($qrCode, $slug);
         return $qrCode;
    }

    private function createImage(QrCodeResponse $qrCode, string $slug){
        $filesystem = new Filesystem();
       if(!$filesystem->exists(self::QR_CODE_IMAGE_DIRECTORY)){
              $filesystem->mkdir(self::QR_CODE_IMAGE_DIRECTORY);
       }
       $filesystem->touch(self::QR_CODE_IMAGE_DIRECTORY.'/'.$slug.'.png');
       $filesystem->appendToFile(self::QR_CODE_IMAGE_DIRECTORY.'/'.$slug.'.png', $qrCode->getContent());
    }

    private function ZipFile(){
        if(file_exists(self::QR_CODE_ZIP_FILE)){
            unlink(self::QR_CODE_ZIP_FILE);
        }
        touch(self::QR_CODE_ZIP_FILE);

        $pathdir = self::QR_CODE_IMAGE_DIRECTORY."/";
        $dir = opendir($pathdir);
        
        $zip = new ZipArchive();
        $zip->open(self::QR_CODE_ZIP_FILE);
        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
               $zip -> addFile($pathdir.$file, $file);
            }
         }
        $zip->close();
    }

    public function purgeDirectories(){
        $files = glob(self::QR_CODE_IMAGE_DIRECTORY.'/*');
        foreach($files as $file){ // iterate files
            if(is_file($file)) {
              unlink($file); // delete file
            }
          }
    }


    public function get()
    {
        $om = $this->objectManager;
        $qb = $om->createQueryBuilder();
        $qb->select("ft.value")
            ->from(Content::class, 't')
            ->where("t.contentType = 'videos'")
            ->join(Field::class, 'f', 'WITH', 'f.content = t.id')
            ->andWhere("f.name = 'slug'")
            ->join(FieldTranslation::class, 'ft', 'WITH', 'ft.translatable = f.id')
            ->orderBy("t.id");
        $query = $qb->getQuery();
        $results = $query->getResult();
        dd($results);
    }
}
