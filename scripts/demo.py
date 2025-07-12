#!/usr/bin/env python3
"""
PeopleOS Export Demo Script

This script demonstrates the export functionality with mock data.
"""

import json
from datetime import datetime
from export_account_data import PeopleOSDataExporter


def create_mock_data():
    """Create mock data for demonstration."""
    return {
        'export_info': {
            'exported_at': datetime.now().isoformat(),
            'account_id': 1,
            'version': '1.0'
        },
        'account': {
            'id': 1,
            'has_lifetime_access': False,
            'trial_ends_at': '2025-02-20T10:30:00',
            'auto_delete_account': False,
            'create_task_on_reminder': True,
            'created_at': '2025-01-01T00:00:00',
            'updated_at': '2025-01-20T10:30:00'
        },
        'users': [
            {
                'id': 1,
                'account_id': 1,
                'first_name': 'John',
                'last_name': 'Doe',
                'email': 'john@example.com',
                'is_instance_admin': True,
                'created_at': '2025-01-01T00:00:00',
                'updated_at': '2025-01-20T10:30:00'
            }
        ],
        'persons': [
            {
                'id': 1,
                'account_id': 1,
                'first_name': 'Jane',
                'last_name': 'Smith',
                'nickname': 'Janey',
                'how_we_met': 'At a coffee shop',
                'created_at': '2025-01-05T00:00:00',
                'updated_at': '2025-01-15T00:00:00'
            },
            {
                'id': 2,
                'account_id': 1,
                'first_name': 'Mike',
                'last_name': 'Johnson',
                'nickname': 'Mikey',
                'how_we_met': 'Through mutual friends',
                'created_at': '2025-01-10T00:00:00',
                'updated_at': '2025-01-18T00:00:00'
            }
        ],
        'notes': [
            {
                'id': 1,
                'person_id': 1,
                'content': 'Jane loves hiking and photography',
                'created_at': '2025-01-06T00:00:00',
                'updated_at': '2025-01-06T00:00:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'tasks': [
            {
                'id': 1,
                'account_id': 1,
                'person_id': 1,
                'name': 'Send birthday card to Jane',
                'is_completed': False,
                'due_at': '2025-02-15T00:00:00',
                'created_at': '2025-01-15T00:00:00',
                'updated_at': '2025-01-15T00:00:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'encounters': [
            {
                'id': 1,
                'account_id': 1,
                'person_id': 1,
                'seen_at': '2025-01-20T14:30:00',
                'context': 'Met at the local park',
                'created_at': '2025-01-20T14:30:00',
                'updated_at': '2025-01-20T14:30:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'journals': [
            {
                'id': 1,
                'account_id': 1,
                'name': 'Daily Journal',
                'slug': 'daily-journal',
                'created_at': '2025-01-01T00:00:00',
                'updated_at': '2025-01-01T00:00:00'
            }
        ],
        'entries': [
            {
                'id': 1,
                'journal_id': 1,
                'day': 20,
                'month': 1,
                'year': 2025,
                'created_at': '2025-01-20T00:00:00',
                'updated_at': '2025-01-20T00:00:00',
                'journal_name': 'Daily Journal'
            }
        ],
        'pets': [
            {
                'id': 1,
                'account_id': 1,
                'person_id': 1,
                'name': 'Buddy',
                'species': 'Dog',
                'breed': 'Golden Retriever',
                'gender': 'Male',
                'created_at': '2025-01-12T00:00:00',
                'updated_at': '2025-01-12T00:00:00',
                'person_first_name': 'Jane',
                'person_last_name': 'Smith'
            }
        ],
        'addresses': [
            {
                'id': 1,
                'account_id': 1,
                'person_id': 1,
                'address_line_1': '123 Main St',
                'city': 'New York',
                'state': 'NY',
                'postal_code': '10001',
                'country': 'USA',
                'is_active': True,
                'created_at': '2025-01-08T00:00:00',
                'updated_at': '2025-01-08T00:00:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'children': [
            {
                'id': 1,
                'account_id': 1,
                'parent_id': 1,
                'first_name': 'Emma',
                'last_name': 'Smith',
                'food_allergies': 'Peanuts',
                'created_at': '2025-01-14T00:00:00',
                'updated_at': '2025-01-14T00:00:00',
                'parent_first_name': 'Jane',
                'parent_last_name': 'Smith'
            }
        ],
        'love_relationships': [
            {
                'id': 1,
                'person_id': 1,
                'related_person_id': 2,
                'type': 'Dating',
                'is_current': True,
                'notes': 'Started dating in January 2025',
                'created_at': '2025-01-16T00:00:00',
                'updated_at': '2025-01-16T00:00:00',
                'person_first_name': 'Jane',
                'person_last_name': 'Smith',
                'related_person_first_name': 'Mike',
                'related_person_last_name': 'Johnson'
            }
        ],
        'special_dates': [
            {
                'id': 1,
                'person_id': 1,
                'date': '1990-05-15',
                'age_old': 34,
                'created_at': '2025-01-07T00:00:00',
                'updated_at': '2025-01-07T00:00:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'emails_sent': [
            {
                'id': 1,
                'account_id': 1,
                'person_id': 1,
                'subject': 'Happy Birthday!',
                'content': 'Wishing you a wonderful birthday!',
                'sent_at': '2025-01-20T09:00:00',
                'created_at': '2025-01-20T09:00:00',
                'updated_at': '2025-01-20T09:00:00',
                'first_name': 'Jane',
                'last_name': 'Smith'
            }
        ],
        'statistics': {
            'total_users': 1,
            'total_persons': 2,
            'total_notes': 1,
            'total_tasks': 1,
            'total_encounters': 1,
            'total_journals': 1,
            'total_entries': 1,
            'total_pets': 1,
            'total_addresses': 1,
            'total_children': 1,
            'total_love_relationships': 1,
            'total_special_dates': 1,
            'total_emails_sent': 1
        }
    }


def main():
    """Generate a demo export file."""
    print("🎭 Generating demo export data...")
    
    data = create_mock_data()
    
    # Write to demo file
    output_file = 'demo_export.json'
    with open(output_file, 'w', encoding='utf-8') as f:
        json.dump(data, f, indent=2, ensure_ascii=False, default=str)
    
    print(f"✅ Demo export created: {output_file}")
    print(f"📊 Statistics:")
    for key, value in data['statistics'].items():
        print(f"   {key}: {value}")
    
    print("\n🎉 Demo completed successfully!")
    print("You can now view the demo_export.json file to see the export format.")


if __name__ == '__main__':
    main() 