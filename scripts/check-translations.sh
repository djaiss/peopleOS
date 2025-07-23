#!/bin/bash

# Check Translations Script
# This script checks that all translation keys in language files are properly translated

set -e

echo "🔍 Checking translations..."

# Check French translations
if [ -f "lang/fr.json" ]; then
    echo "📝 Checking French translations..."

    # Validate JSON structure
    if ! jq empty lang/fr.json 2>/dev/null; then
        echo "❌ Error: lang/fr.json is not valid JSON"
        exit 1
    fi

    # Find empty translation values
    empty_translations=$(jq -r 'to_entries[] | select(.value == "") | .key' lang/fr.json)

    if [ -n "$empty_translations" ]; then
        echo "❌ Found empty translation values in fr.json:"
        echo ""
        echo "$empty_translations" | while read -r key; do
            echo "  - \"$key\": \"\""
        done
        echo ""
        echo "Please translate these keys or remove them if they're not needed."
        exit 1
    else
        echo "✅ All French translations are complete!"
        echo "📊 Total translations checked: $(jq 'length' lang/fr.json)"
    fi
else
    echo "⚠️  Warning: lang/fr.json not found"
fi

echo "🎉 Translation check completed successfully!"
