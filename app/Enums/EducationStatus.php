<?php

namespace App\Enums;

enum EducationStatus: string
{
    case PRIMARY = 'primary';
    case SECONDARY = 'secondary';
    case NCE = 'nce';
    case ND = 'nd';
    case HND = 'hnd';
    case BSC = 'bsc';
    case MSC = 'msc';
    case PHD = 'phd';
    case OTHER = 'other';
}
