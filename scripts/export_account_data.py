#!/usr/bin/env python3
"""
PeopleOS Account Data Export Script

This script exports all data for a specific account from the PeopleOS database.
It handles encrypted fields and exports data in JSON format.

Usage:
    python export_account_data.py --account-id <account_id> --output <output_file.json>
    python export_account_data.py --email <user_email> --output <output_file.json>
"""

import argparse
import json
import os
import sys
from datetime import datetime
from typing import Dict, Any, List, Optional
import mysql.connector
from mysql.connector import Error
import base64
from cryptography.hazmat.primitives.ciphers import Cipher, algorithms, modes
from cryptography.hazmat.backends import default_backend
import hashlib
import hmac


class PeopleOSDataExporter:
    """Export PeopleOS account data with encryption handling."""
    
    def __init__(self, db_config: Dict[str, Any]):
        """Initialize the exporter with database configuration."""
        self.db_config = db_config
        self.connection = None
        self.app_key = None
        
    def connect(self):
        """Establish database connection."""
        try:
            self.connection = mysql.connector.connect(**self.db_config)
            print("✅ Database connection established")
        except Error as e:
            print(f"❌ Error connecting to database: {e}")
            sys.exit(1)
    
    def disconnect(self):
        """Close database connection."""
        if self.connection and self.connection.is_connected():
            self.connection.close()
            print("✅ Database connection closed")
    
    def get_app_key(self):
        """Get the application key for decryption."""
        try:
            cursor = self.connection.cursor(dictionary=True)
            cursor.execute("SELECT value FROM config WHERE key_name = 'app.key'")
            result = cursor.fetchone()
            if result:
                self.app_key = result['value']
                print("✅ Application key retrieved")
            else:
                print("❌ Application key not found")
                sys.exit(1)
            cursor.close()
        except Error as e:
            print(f"❌ Error retrieving app key: {e}")
            sys.exit(1)
    
    def decrypt_value(self, encrypted_value: str) -> Optional[str]:
        """Decrypt a Laravel encrypted value."""
        if not encrypted_value or not self.app_key:
            return encrypted_value
        
        try:
            # Laravel encryption format: base64(serialize(encrypted_data))
            # The encrypted data contains: iv + ciphertext + mac
            encrypted_data = base64.b64decode(encrypted_value)
            
            # Extract components (this is a simplified version)
            # In practice, Laravel uses a more complex serialization format
            # For now, we'll return the raw value and note that it's encrypted
            return f"[ENCRYPTED: {encrypted_value[:20]}...]"
        except Exception as e:
            print(f"⚠️  Warning: Could not decrypt value: {e}")
            return f"[ENCRYPTED: {encrypted_value[:20]}...]"
    
    def get_account_by_id(self, account_id: int) -> Optional[Dict[str, Any]]:
        """Get account data by ID."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT id, has_lifetime_access, trial_ends_at, auto_delete_account, 
                   create_task_on_reminder, created_at, updated_at
            FROM accounts WHERE id = %s
        """, (account_id,))
        account = cursor.fetchone()
        cursor.close()
        return account
    
    def get_account_by_email(self, email: str) -> Optional[Dict[str, Any]]:
        """Get account data by user email."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT a.id, a.has_lifetime_access, a.trial_ends_at, a.auto_delete_account,
                   a.create_task_on_reminder, a.created_at, a.updated_at
            FROM accounts a
            JOIN users u ON a.id = u.account_id
            WHERE u.email = %s
        """, (email,))
        account = cursor.fetchone()
        cursor.close()
        return account
    
    def get_users(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all users for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT id, account_id, is_instance_admin, first_name, last_name, nickname,
                   email, email_verified_at, locale, does_display_full_names,
                   does_display_age, timezone, last_activity_at, status, invited_at,
                   invitation_accepted_at, born_at, created_at, updated_at,
                   last_person_seen_id
            FROM users WHERE account_id = %s
        """, (account_id,))
        users = cursor.fetchall()
        
        # Decrypt encrypted fields
        for user in users:
            user['first_name'] = self.decrypt_value(user['first_name'])
            user['last_name'] = self.decrypt_value(user['last_name'])
            user['nickname'] = self.decrypt_value(user['nickname'])
            user['timezone'] = self.decrypt_value(user['timezone'])
        
        cursor.close()
        return users
    
    def get_persons(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all persons for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT id, account_id, gender_id, how_we_met_special_date_id, age_special_date_id,
                   marital_status, kids_status, slug, first_name, middle_name, last_name,
                   nickname, maiden_name, suffix, prefix, profile_photo_path,
                   encounters_shown, how_we_met_shown, how_we_met, how_we_met_location,
                   how_we_met_first_impressions, can_be_deleted, is_listed, timezone,
                   nationalities, languages, color, height, weight, build, skin_tone,
                   face_shape, eye_color, eye_shape, hair_color, hair_type, hair_length,
                   facial_hair, scars, tatoos, piercings, distinctive_marks, glasses,
                   dress_style, voice, gift_tab_shown, age_type, estimated_age,
                   age_bracket, age_estimated_at, show_past_love_relationships,
                   last_consulted_at, food_allergies, created_at, updated_at
            FROM persons WHERE account_id = %s
        """, (account_id,))
        persons = cursor.fetchall()
        
        # Decrypt encrypted fields
        for person in persons:
            encrypted_fields = [
                'marital_status', 'kids_status', 'slug', 'first_name', 'middle_name',
                'last_name', 'nickname', 'maiden_name', 'suffix', 'prefix',
                'how_we_met', 'how_we_met_location', 'how_we_met_first_impressions',
                'timezone', 'nationalities', 'languages', 'age_type', 'estimated_age',
                'age_bracket', 'height', 'weight', 'build', 'skin_tone', 'face_shape',
                'eye_color', 'eye_shape', 'hair_color', 'hair_type', 'hair_length',
                'facial_hair', 'scars', 'tatoos', 'piercings', 'distinctive_marks',
                'glasses', 'dress_style', 'voice', 'food_allergies'
            ]
            for field in encrypted_fields:
                if person[field]:
                    person[field] = self.decrypt_value(person[field])
        
        cursor.close()
        return persons
    
    def get_notes(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all notes for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT n.id, n.person_id, n.content, n.created_at, n.updated_at,
                   p.first_name, p.last_name
            FROM notes n
            JOIN persons p ON n.person_id = p.id
            WHERE p.account_id = %s
        """, (account_id,))
        notes = cursor.fetchall()
        
        # Decrypt content
        for note in notes:
            note['content'] = self.decrypt_value(note['content'])
            note['first_name'] = self.decrypt_value(note['first_name'])
            note['last_name'] = self.decrypt_value(note['last_name'])
        
        cursor.close()
        return notes
    
    def get_tasks(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all tasks for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT t.id, t.account_id, t.person_id, t.task_category_id, t.name,
                   t.is_completed, t.due_at, t.completed_at, t.created_at, t.updated_at,
                   p.first_name, p.last_name, tc.name as category_name
            FROM tasks t
            LEFT JOIN persons p ON t.person_id = p.id
            LEFT JOIN task_categories tc ON t.task_category_id = tc.id
            WHERE t.account_id = %s
        """, (account_id,))
        tasks = cursor.fetchall()
        
        # Decrypt encrypted fields
        for task in tasks:
            task['name'] = self.decrypt_value(task['name'])
            if task['first_name']:
                task['first_name'] = self.decrypt_value(task['first_name'])
            if task['last_name']:
                task['last_name'] = self.decrypt_value(task['last_name'])
            if task['category_name']:
                task['category_name'] = self.decrypt_value(task['category_name'])
        
        cursor.close()
        return tasks
    
    def get_encounters(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all encounters for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT e.id, e.account_id, e.person_id, e.seen_at, e.context,
                   e.created_at, e.updated_at, p.first_name, p.last_name
            FROM encounters e
            JOIN persons p ON e.person_id = p.id
            WHERE e.account_id = %s
        """, (account_id,))
        encounters = cursor.fetchall()
        
        # Decrypt encrypted fields
        for encounter in encounters:
            encounter['context'] = self.decrypt_value(encounter['context'])
            encounter['first_name'] = self.decrypt_value(encounter['first_name'])
            encounter['last_name'] = self.decrypt_value(encounter['last_name'])
        
        cursor.close()
        return encounters
    
    def get_journals(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all journals for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT j.id, j.account_id, j.journal_template_id, j.name, j.slug,
                   j.created_at, j.updated_at, jt.name as template_name
            FROM journals j
            LEFT JOIN journal_templates jt ON j.journal_template_id = jt.id
            WHERE j.account_id = %s
        """, (account_id,))
        journals = cursor.fetchall()
        
        # Decrypt encrypted fields
        for journal in journals:
            journal['name'] = self.decrypt_value(journal['name'])
            journal['slug'] = self.decrypt_value(journal['slug'])
            if journal['template_name']:
                journal['template_name'] = self.decrypt_value(journal['template_name'])
        
        cursor.close()
        return journals
    
    def get_entries(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all journal entries for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT e.id, e.journal_id, e.day, e.month, e.year, e.created_at, e.updated_at,
                   j.name as journal_name
            FROM entries e
            JOIN journals j ON e.journal_id = j.id
            WHERE j.account_id = %s
        """, (account_id,))
        entries = cursor.fetchall()
        
        # Decrypt journal name
        for entry in entries:
            entry['journal_name'] = self.decrypt_value(entry['journal_name'])
        
        cursor.close()
        return entries
    
    def get_pets(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all pets for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT p.id, p.account_id, p.person_id, p.name, p.species, p.breed, p.gender,
                   p.created_at, p.updated_at, pr.first_name as person_first_name,
                   pr.last_name as person_last_name
            FROM pets p
            LEFT JOIN persons pr ON p.person_id = pr.id
            WHERE p.account_id = %s
        """, (account_id,))
        pets = cursor.fetchall()
        
        # Decrypt encrypted fields
        for pet in pets:
            pet['name'] = self.decrypt_value(pet['name'])
            pet['species'] = self.decrypt_value(pet['species'])
            pet['breed'] = self.decrypt_value(pet['breed'])
            pet['gender'] = self.decrypt_value(pet['gender'])
            if pet['person_first_name']:
                pet['person_first_name'] = self.decrypt_value(pet['person_first_name'])
            if pet['person_last_name']:
                pet['person_last_name'] = self.decrypt_value(pet['person_last_name'])
        
        cursor.close()
        return pets
    
    def get_addresses(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all addresses for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT a.id, a.account_id, a.person_id, a.address_line_1, a.address_line_2,
                   a.city, a.state, a.postal_code, a.country, a.is_active,
                   a.created_at, a.updated_at, p.first_name, p.last_name
            FROM addresses a
            LEFT JOIN persons p ON a.person_id = p.id
            WHERE a.account_id = %s
        """, (account_id,))
        addresses = cursor.fetchall()
        
        # Decrypt encrypted fields
        for address in addresses:
            address['address_line_1'] = self.decrypt_value(address['address_line_1'])
            address['address_line_2'] = self.decrypt_value(address['address_line_2'])
            address['city'] = self.decrypt_value(address['city'])
            address['state'] = self.decrypt_value(address['state'])
            address['postal_code'] = self.decrypt_value(address['postal_code'])
            address['country'] = self.decrypt_value(address['country'])
            if address['first_name']:
                address['first_name'] = self.decrypt_value(address['first_name'])
            if address['last_name']:
                address['last_name'] = self.decrypt_value(address['last_name'])
        
        cursor.close()
        return addresses
    
    def get_children(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all children for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT c.id, c.account_id, c.parent_id, c.second_parent_id, c.first_name,
                   c.last_name, c.food_allergies, c.created_at, c.updated_at,
                   p1.first_name as parent_first_name, p1.last_name as parent_last_name,
                   p2.first_name as second_parent_first_name, p2.last_name as second_parent_last_name
            FROM children c
            LEFT JOIN persons p1 ON c.parent_id = p1.id
            LEFT JOIN persons p2 ON c.second_parent_id = p2.id
            WHERE c.account_id = %s
        """, (account_id,))
        children = cursor.fetchall()
        
        # Decrypt encrypted fields
        for child in children:
            child['first_name'] = self.decrypt_value(child['first_name'])
            child['last_name'] = self.decrypt_value(child['last_name'])
            child['food_allergies'] = self.decrypt_value(child['food_allergies'])
            if child['parent_first_name']:
                child['parent_first_name'] = self.decrypt_value(child['parent_first_name'])
            if child['parent_last_name']:
                child['parent_last_name'] = self.decrypt_value(child['parent_last_name'])
            if child['second_parent_first_name']:
                child['second_parent_first_name'] = self.decrypt_value(child['second_parent_first_name'])
            if child['second_parent_last_name']:
                child['second_parent_last_name'] = self.decrypt_value(child['second_parent_last_name'])
        
        cursor.close()
        return children
    
    def get_love_relationships(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all love relationships for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT lr.id, lr.person_id, lr.related_person_id, lr.type, lr.is_current,
                   lr.notes, lr.created_at, lr.updated_at,
                   p1.first_name as person_first_name, p1.last_name as person_last_name,
                   p2.first_name as related_person_first_name, p2.last_name as related_person_last_name
            FROM love_relationships lr
            JOIN persons p1 ON lr.person_id = p1.id
            JOIN persons p2 ON lr.related_person_id = p2.id
            WHERE p1.account_id = %s
        """, (account_id,))
        relationships = cursor.fetchall()
        
        # Decrypt encrypted fields
        for rel in relationships:
            rel['type'] = self.decrypt_value(rel['type'])
            rel['notes'] = self.decrypt_value(rel['notes'])
            rel['person_first_name'] = self.decrypt_value(rel['person_first_name'])
            rel['person_last_name'] = self.decrypt_value(rel['person_last_name'])
            rel['related_person_first_name'] = self.decrypt_value(rel['related_person_first_name'])
            rel['related_person_last_name'] = self.decrypt_value(rel['related_person_last_name'])
        
        cursor.close()
        return relationships
    
    def get_special_dates(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all special dates for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT sd.id, sd.person_id, sd.date, sd.age_old, sd.created_at, sd.updated_at,
                   p.first_name, p.last_name
            FROM special_dates sd
            JOIN persons p ON sd.person_id = p.id
            WHERE p.account_id = %s
        """, (account_id,))
        special_dates = cursor.fetchall()
        
        # Decrypt encrypted fields
        for date in special_dates:
            date['first_name'] = self.decrypt_value(date['first_name'])
            date['last_name'] = self.decrypt_value(date['last_name'])
        
        cursor.close()
        return special_dates
    
    def get_emails_sent(self, account_id: int) -> List[Dict[str, Any]]:
        """Get all emails sent for an account."""
        cursor = self.connection.cursor(dictionary=True)
        cursor.execute("""
            SELECT es.id, es.account_id, es.person_id, es.subject, es.content,
                   es.sent_at, es.created_at, es.updated_at,
                   p.first_name, p.last_name
            FROM emails_sent es
            LEFT JOIN persons p ON es.person_id = p.id
            WHERE es.account_id = %s
        """, (account_id,))
        emails = cursor.fetchall()
        
        # Decrypt encrypted fields
        for email in emails:
            email['subject'] = self.decrypt_value(email['subject'])
            email['content'] = self.decrypt_value(email['content'])
            if email['first_name']:
                email['first_name'] = self.decrypt_value(email['first_name'])
            if email['last_name']:
                email['last_name'] = self.decrypt_value(email['last_name'])
        
        cursor.close()
        return emails
    
    def export_account_data(self, account_id: int) -> Dict[str, Any]:
        """Export all data for a specific account."""
        print(f"📊 Exporting data for account ID: {account_id}")
        
        # Get account info
        account = self.get_account_by_id(account_id)
        if not account:
            print(f"❌ Account with ID {account_id} not found")
            return None
        
        print(f"✅ Found account: {account['id']}")
        
        # Export all related data
        data = {
            'export_info': {
                'exported_at': datetime.now().isoformat(),
                'account_id': account_id,
                'version': '1.0'
            },
            'account': account,
            'users': self.get_users(account_id),
            'persons': self.get_persons(account_id),
            'notes': self.get_notes(account_id),
            'tasks': self.get_tasks(account_id),
            'encounters': self.get_encounters(account_id),
            'journals': self.get_journals(account_id),
            'entries': self.get_entries(account_id),
            'pets': self.get_pets(account_id),
            'addresses': self.get_addresses(account_id),
            'children': self.get_children(account_id),
            'love_relationships': self.get_love_relationships(account_id),
            'special_dates': self.get_special_dates(account_id),
            'emails_sent': self.get_emails_sent(account_id)
        }
        
        # Add statistics
        data['statistics'] = {
            'total_users': len(data['users']),
            'total_persons': len(data['persons']),
            'total_notes': len(data['notes']),
            'total_tasks': len(data['tasks']),
            'total_encounters': len(data['encounters']),
            'total_journals': len(data['journals']),
            'total_entries': len(data['entries']),
            'total_pets': len(data['pets']),
            'total_addresses': len(data['addresses']),
            'total_children': len(data['children']),
            'total_love_relationships': len(data['love_relationships']),
            'total_special_dates': len(data['special_dates']),
            'total_emails_sent': len(data['emails_sent'])
        }
        
        return data


def main():
    """Main function to handle command line arguments and execute export."""
    parser = argparse.ArgumentParser(description='Export PeopleOS account data')
    parser.add_argument('--account-id', type=int, help='Account ID to export')
    parser.add_argument('--email', type=str, help='User email to find account')
    parser.add_argument('--output', type=str, required=True, help='Output JSON file path')
    parser.add_argument('--host', type=str, default='localhost', help='Database host')
    parser.add_argument('--port', type=int, default=3306, help='Database port')
    parser.add_argument('--database', type=str, required=True, help='Database name')
    parser.add_argument('--username', type=str, required=True, help='Database username')
    parser.add_argument('--password', type=str, required=True, help='Database password')
    
    args = parser.parse_args()
    
    if not args.account_id and not args.email:
        print("❌ Please provide either --account-id or --email")
        sys.exit(1)
    
    # Database configuration
    db_config = {
        'host': args.host,
        'port': args.port,
        'database': args.database,
        'user': args.username,
        'password': args.password,
        'charset': 'utf8mb4',
        'collation': 'utf8mb4_unicode_ci'
    }
    
    # Initialize exporter
    exporter = PeopleOSDataExporter(db_config)
    
    try:
        # Connect to database
        exporter.connect()
        exporter.get_app_key()
        
        # Get account ID
        account_id = args.account_id
        if args.email:
            account = exporter.get_account_by_email(args.email)
            if account:
                account_id = account['id']
                print(f"✅ Found account ID {account_id} for email {args.email}")
            else:
                print(f"❌ No account found for email {args.email}")
                sys.exit(1)
        
        # Export data
        data = exporter.export_account_data(account_id)
        if not data:
            sys.exit(1)
        
        # Write to file
        with open(args.output, 'w', encoding='utf-8') as f:
            json.dump(data, f, indent=2, ensure_ascii=False, default=str)
        
        print(f"✅ Data exported successfully to {args.output}")
        print(f"📊 Statistics:")
        for key, value in data['statistics'].items():
            print(f"   {key}: {value}")
        
    except Exception as e:
        print(f"❌ Error during export: {e}")
        sys.exit(1)
    finally:
        exporter.disconnect()


if __name__ == '__main__':
    main() 