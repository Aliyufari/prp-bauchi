<?php

namespace App\Enums;

enum ConstituencyType: string
{
    case GOVERNORSHIP = 'governorship';

    case SENATORIAL = 'senatorial';

    case HOUSE_OF_REPRESENTATIVES = 'house_of_representatives';

    case STATE_ASSEMBLY = 'state_assembly';

    case CHAIRMANSHIP = 'chairmanship';

    case COUNCILLOR = 'councillor';
}