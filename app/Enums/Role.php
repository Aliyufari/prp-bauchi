<?php

namespace App\Enums;

enum Role: string
{
    case SUPER_ADMIN = 'super_admin';
    case ADMIN = 'admin';
    case ASPIRANT = 'aspirant';
    case MEMBER = 'member';
    case SUPER_PARTY_AGENT = 'super_party_agent';
    case PARTY_AGENT = 'party_agent';
    case COORDINATOR = 'coordinator';
    case STAKEHOLDER = 'stakeholder';
    case RETURNING_OFFICER = 'returning_officer';
    case SUPERVISORY_AGENT = 'supervisory_agent';
    case CAMPAIGN_TEAM = 'campaign_team';
    case MOBILIZERS = 'mobilizers';
    case USER = 'user'; // For the rest
}
