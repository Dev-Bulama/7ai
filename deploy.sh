#!/bin/bash
# 7AI Deployment Script
# Run this after every git pull on the host.
# It never overwrites .env if it already exists.

set -e

echo "==> Pulling latest code..."
git pull origin claude/trusting-gauss-aMUFh

echo "==> Installing/updating dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader --no-dev

echo "==> Setting up .env (only if missing)..."
if [ ! -f .env ]; then
  cp .env.example .env
  php artisan key:generate
  echo "!! .env created from .env.example — fill in your DB credentials then re-run migrations."
  exit 1
else
  echo "   .env already exists, skipping."
fi

echo "==> Running migrations..."
php artisan migrate --force

echo "==> Clearing and caching config..."
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:clear

echo "==> Linking storage..."
php artisan storage:link 2>/dev/null || true

echo "==> Done! Site is live."
