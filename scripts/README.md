# PeopleOS Account Data Export

This feature allows users to export their account data, including all contacts, notes, tasks, journals, and more.

## Features

- ✅ Export complete account data
- ✅ Handle Laravel encrypted fields
- ✅ Support export by account ID or user email
- ✅ Generate JSON format export files
- ✅ Include data statistics
- ✅ Secure database connection

## Install Python Dependencies

Before running the export functionality, you need to install Python dependencies:

```bash
cd scripts
pip install -r requirements.txt
```

## Usage

### Via Web Interface

1. Log in to PeopleOS
2. Visit the administration page: `http://127.0.0.1:8000/administration`
3. Click "Export Data" in the sidebar
4. Click the "Export Data" button to start export
5. Click the download link after export is complete

### Via Command Line

```bash
# Export by account ID
python scripts/export_account_data.py \
  --account-id 123 \
  --output account_data.json \
  --host localhost \
  --port 3306 \
  --database peopleos \
  --username your_username \
  --password your_password

# Export by user email
python scripts/export_account_data.py \
  --email user@example.com \
  --output account_data.json \
  --host localhost \
  --port 3306 \
  --database peopleos \
  --username your_username \
  --password your_password
```

## Exported Data Types

1. **Account Information** (Account)
2. **User Information** (Users)
3. **Contact Information** (Persons)
4. **Notes** (Notes)
5. **Tasks** (Tasks)
6. **Encounters** (Encounters)
7. **Journals** (Journals & Entries)
8. **Pet Information** (Pets)
9. **Address Information** (Addresses)
10. **Children Information** (Children)
11. **Love Relationships** (Love Relationships)
12. **Special Dates** (Special Dates)
13. **Sent Emails** (Emails Sent)

## Output Format

The exported JSON file contains the following structure:

```json
{
  "export_info": {
    "exported_at": "2025-01-20T10:30:00",
    "account_id": 123,
    "version": "1.0"
  },
  "account": { ... },
  "users": [ ... ],
  "persons": [ ... ],
  "notes": [ ... ],
  "tasks": [ ... ],
  "encounters": [ ... ],
  "journals": [ ... ],
  "entries": [ ... ],
  "pets": [ ... ],
  "addresses": [ ... ],
  "children": [ ... ],
  "love_relationships": [ ... ],
  "special_dates": [ ... ],
  "emails_sent": [ ... ],
  "statistics": {
    "total_users": 2,
    "total_persons": 15,
    "total_notes": 45,
    ...
  }
}
```

## Security Considerations

1. Ensure database connections use SSL
2. Do not hardcode database passwords in code
3. Exported files contain sensitive information, please keep them secure
4. It's recommended to delete temporary files after export

## Troubleshooting

### Common Issues

1. **Python dependencies not installed**
   ```bash
   pip install -r requirements.txt
   ```

2. **Database connection failed**
   - Check database host, port, username and password
   - Ensure database service is running

3. **Permission errors**
   - Ensure database user has read permissions
   - Check if database user has access to all related tables

4. **Encrypted fields show as [ENCRYPTED]**
   - This is normal, indicating the field is encrypted in the database
   - If decryption is needed, the correct Laravel application key is required

## License

MIT License - Consistent with the PeopleOS project 