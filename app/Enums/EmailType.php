<?php

declare(strict_types=1);

namespace App\Enums;

enum EmailType: string
{
    case API_CREATED = 'api_created';
    case API_DESTROYED = 'api_destroyed';
    case LOGIN_FAILED = 'login_failed';
    case MAGIC_LINK_CREATED = 'magic_link_created';
    case REMINDER_SENT = 'reminder_sent';
    case MARKETING_TESTIMONIAL_SUBMITTED_EMAIL = 'marketing_testimonial_submitted_email';
    case MARKETING_TESTIMONIAL_REVIEWED_EMAIL = 'marketing_testimonial_reviewed_email';
    case MARKETING_TESTIMONIAL_REJECTED_EMAIL = 'marketing_testimonial_rejected_email';
    case TRIAL_ENDING_SOON = 'trial_ending_soon';
}
