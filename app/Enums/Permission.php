<?php

namespace App\Enums;

<?php

namespace App\Enums;

enum Permission: string
{
    // User Management
    case CREATE_ADMIN = 'create_admin';

    case CREATE_COORDINATOR = 'create_coordinator';
    case CREATE_PARTY_AGENT = 'create_party_agent';
    case CREATE_MEMBER = 'create_member';
    case CREATE_STAKEHOLDER = 'create_stakeholder';
    case CREATE_RETURNING_OFFICER = 'create_returning_officer';
    case CREATE_ASPIRANT = 'create_aspirant';
    case CREATE_CAMPAIGN_TEAM = 'create_campaign_team';
    case CREATE_MOBILIZER = 'create_mobilizer';

    case VIEW_USERS = 'view_users';
    case UPDATE_USERS = 'update_users';
    case DELETE_USERS = 'delete_users';

    // Reports
    case VIEW_REPORTS = 'view_reports';
    case SUBMIT_REPORTS = 'submit_reports';

    // Locations
    case MANAGE_LOCATIONS = 'manage_locations';

    // Settings
    case MANAGE_SETTINGS = 'manage_settings';
}