@echo off
echo Starting npm run dev...
start cmd /k "npm run dev --host=0.0.0.0"

echo Starting php artisan serve...
start cmd /k "php artisan serve --host=0.0.0.0 --port=8000"

echo Both tasks have been started.
exit
