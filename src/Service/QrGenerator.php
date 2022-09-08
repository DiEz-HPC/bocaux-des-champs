<?php

namespace App\Service;

use ZipArchive;
use Endroid\QrCode\Builder\BuilderInterface;
use Symfony\Component\Filesystem\Filesystem;
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

    public function parseFormData(array $data)
    {
        $options = [
            'size' => 400,
            'label' => '',
            'margin' => 20,
        ];
        foreach ($data as $key => $value) {
            if ($key == 'qrCodeSize') {
                $options['size'] = $value;
                unset($data[$key]);
            } elseif ($key == 'LabelQrCode') {
                $options['label'] = $value;
                unset($data[$key]);
            } elseif ($key == 'qrCodeMargin') {
                $options['margin'] = $value;
                unset($data[$key]);
            }
        }
        $this->generateLink($data, $options);
    }

    private function generateLink(array $slugs, array $options): array
    {
        $serverLink = $_SERVER['SYMFONY_DEFAULT_ROUTE_URL'];
        $qrcodes = [];
        foreach ($slugs as $slug => $contentType) {
            $link = $serverLink . $contentType . '/' . $slug;
            $qrcodes[$slug] = $this->generateQr($link, $slug, $options);
        }
        $this->ZipFile();
        return $qrcodes;
    }

    private function generateQr(string $link, string $slug, array $options)
    {
        $options['label'] === 'moviesName' ? $options['label'] = $slug : $options['label'] = $_SERVER['SERVER_NAME'];

        return $this->createImage(
            new QrCodeResponse($this->qrBuilder
                ->size($options['size'])
                ->margin($options['margin'])
                ->data($link)
                ->labelText($options['label'])
                ->build()),
            $slug
        );
    }

    private function createImage(QrCodeResponse $qrCode, string $slug)
    {
        $filesystem = new Filesystem();
        if (!$filesystem->exists(self::QR_CODE_IMAGE_DIRECTORY)) {
            $filesystem->mkdir(self::QR_CODE_IMAGE_DIRECTORY);
        }
        $filesystem->touch(self::QR_CODE_IMAGE_DIRECTORY . '/' . $slug . '.png');
        $filesystem->appendToFile(self::QR_CODE_IMAGE_DIRECTORY . '/' . $slug . '.png', $qrCode->getContent());
    }

    private function ZipFile()
    {
        if (file_exists(self::QR_CODE_ZIP_FILE)) {
            unlink(self::QR_CODE_ZIP_FILE);
        }
        touch(self::QR_CODE_ZIP_FILE);

        $pathdir = self::QR_CODE_IMAGE_DIRECTORY . "/";
        $dir = opendir($pathdir);

        $zip = new ZipArchive();
        $zip->open(self::QR_CODE_ZIP_FILE);
        while ($file = readdir($dir)) {
            if (is_file($pathdir . $file)) {
                $zip->addFile($pathdir . $file, $file);
            }
        }
        $zip->close();
    }

    public function purgeDirectories()
    {
        $files = glob(self::QR_CODE_IMAGE_DIRECTORY . '/*');
        foreach ($files as $file) { // iterate files
            if (is_file($file)) {
                unlink($file); // delete file
            }
        }
    }
}
