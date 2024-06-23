#!/bin/sh

# Function to wait for PostgreSQL
wait_for_postgres() {
    until pg_isready -h postgres -p 5432 -U postgres -d levart_blastemail; do
        echo "PostgreSQL is unavailable - sleeping"
        sleep 1
    done
    echo "PostgreSQL is up - executing command"
}

# Wait for PostgreSQL
wait_for_postgres

# Start the NSQ consumer script
php /var/www/html/nsq_consumer.php