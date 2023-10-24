<?php
namespace App\Serializer;



use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\CsvEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;

final class MediaObjectNormalizer implements NormalizerInterface, DenormalizerInterface
{
    
    private $encoder;
    private $normalizer;
    private $serializer;
    public function __construct(NormalizerInterface $normalizer)
    {
        if (!$normalizer instanceof DenormalizerInterface) {
            throw new \InvalidArgumentException('The normalizer must implement the DenormalizerInterface');
        }
        $this->normalizer = $normalizer;
      
    }
    public function denormalize($data, $class, $format = null, array $context = []) : array|string|int|float|bool|\ArrayObject|null
    {
        $encoder = [new CsvEncoder()];
        $normalizer = [new ObjectNormalizer(), new ArrayDenormalizer()];
        $serializer = new Serializer($normalizer, $encoder);
        $options = ['csv_headers' => ['fullName', 'distance', 'time', 'ageCategory']];
;       $output = $serializer->decode($data,'csv', $options);
        return $this->normalizer->denormalize($output, $class, $format, $context);
    }
    public function supportsDenormalization($data, $type, $format = null): bool
    {
        return $this->normalizer->supportsDenormalization($data, $type, $format);
    }
    public function normalize($object, $format = null, array $context = []):array|string|int|float|bool|\ArrayObject|null
    {
        $normalizer = [new ObjectNormalizer(), new ArrayDenormalizer()];
        return $this->normalizer->normalize($object, $format, $context);
    }
    public function supportsNormalization($data, $format = null): bool
    {
        return $this->normalizer->supportsNormalization($data, $format);
    }

    
}