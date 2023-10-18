<?php
namespace App\Dto;

use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;


#[ApiFilter(SearchFilter::class, strategy:'partial')]
#[ApiFilter(OrderFilter::class, properties: ['title'=>'ASC', 'date' => 'DESC', 'averageTimeMedium' => 'DESC', 'averageTimeLong' => 'DESC'], arguments: ['orderParameterName' => 'ord'])]
final class RaceRepresentation  {
    
    public ?string $title = null;
    public ?string $date = null;
    public ?string $averageTimeMedium= null;
    public ?string $averageTimeLong = null;
   
}