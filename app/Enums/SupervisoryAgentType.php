<?php

namespace App\Enums;

enum SupervisoryAgentType: string
{
    case STATE_SUPERVISOR = 'state_supervisor';
    case ZONAL_SUPERVISOR = 'zonal_supervisor';
    case LGA_SUPERVISOR = 'lga_supervisor';
    case WARD_SUPERVISOR = 'ward_supervisor';
}