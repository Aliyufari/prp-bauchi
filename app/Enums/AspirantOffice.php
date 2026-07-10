<?php

namespace App\Enums;

enum AspirantOffice: string
{
    case GOVERNOR = 'governor';
    case DEPUTY_GOVERNOR = 'deputy_governor';
    case SENATE = 'senate';
    case HOUSE_OF_REPS = 'house_of_reps';
    case HOUSE_OF_ASSEMBLY = 'house_of_assembly';
    case CHAIRMAN = 'chairman';
    case COUNCILLOR = 'councillor';
    case OTHER = 'other';
}