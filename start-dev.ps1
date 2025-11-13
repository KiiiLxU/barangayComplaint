#!/usr/bin/env pwsh
# Start Vite dev server in background then run Laravel's built-in server.

Write-Host "Starting Vite dev server (npm run dev)..."
$npm = Start-Process -FilePath npm -ArgumentList 'run','dev' -NoNewWindow -PassThru
Write-Host "Vite started (PID $($npm.Id)). Starting Laravel server..."

# Give Vite a moment to initialize (optional)
Start-Sleep -Seconds 2

php artisan serve

Write-Host "Laravel server stopped. You may stop Vite by killing PID $($npm.Id) if needed."
