<?php
namespace App\Dto;

use ApiPlatform\Metadata\ApiFilter;
use App\Filter\SearchDtoFilter;
use App\Filter\OrderDtoFilter;


#[ApiFilter(SearchDtoFilter::class, properties: ['title'] )]
#[ApiFilter(OrderDtoFilter::class, properties: ['title', 'date' => 'DESC', 'averageTimeMedium' => 'DESC', 'averageTimeLong' => 'DESC'], arguments: ['orderParameterName' => 'ord'])]
class RaceRepresentation  {
    
    public ?string $title = null;
    public ?string $date = null;
    public ?string $averageTimeMedium= null;
    public ?string $averageTimeLong = null;
   
}