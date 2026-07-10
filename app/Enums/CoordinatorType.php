<?php

namespace App\Enums;

enum CoordinatorType: string
{
    case STATE_COORDINATOR = 'state_coordinator';
    case ZONAL_COORDINATOR = 'zonal_coordinator';
    case LGA_COORDINATOR = 'lga_coordinator';
    case WARD_COORDINATOR = 'ward_coordinator';
    case PU_COORDINATOR = 'pu_coordinator';
    case VOLUNTEER = 'volunteer';
}
