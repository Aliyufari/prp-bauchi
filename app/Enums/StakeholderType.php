<?php

namespace App\Enums;

enum StakeholderType: string
{
    case TRADITIONAL_RULER = 'traditional_ruler';
    case RELIGIOUS_LEADER = 'religious_leader';
    case COMMUNITY_LEADER = 'community_leader';
    case NGO_REPRESENTATIVE = 'ngo_representative';
    case BUSINESS_LEADER = 'business_leader';
    case YOUTH_LEADER = 'youth_leader';
    case WOMEN_LEADER = 'women_leader';
}