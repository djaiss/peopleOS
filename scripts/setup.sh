#!/bin/bash

# PeopleOS Export Script Setup
# This script sets up the Python environment for the export functionality

echo "🚀 Setting up PeopleOS Export Script..."

# Check if Python 3 is installed
if ! command -v python3 &> /dev/null; then
    echo "❌ Python 3 is not installed. Please install Python 3.8 or higher."
    exit 1
fi

echo "✅ Python 3 found: $(python3 --version)"

# Check if pip is installed
if ! command -v pip3 &> /dev/null; then
    echo "❌ pip3 is not installed. Please install pip3."
    exit 1
fi

echo "✅ pip3 found: $(pip3 --version)"

# Install Python dependencies
echo "📦 Installing Python dependencies..."
cd "$(dirname "$0")"
pip3 install -r requirements.txt

if [ $? -eq 0 ]; then
    echo "✅ Dependencies installed successfully"
else
    echo "❌ Failed to install dependencies"
    exit 1
fi

# Make the export script executable
chmod +x export_account_data.py

echo "✅ Setup completed successfully!"
echo ""
echo "You can now use the export functionality:"
echo "1. Through the web interface at /administration/export"
echo "2. Via command line: python3 export_account_data.py --help" 