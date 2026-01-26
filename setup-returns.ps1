# Return System Setup Script
# Run this script to set up the return functionality

Write-Host "================================" -ForegroundColor Cyan
Write-Host "Return System Setup" -ForegroundColor Cyan
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""

# Step 1: Run migrations
Write-Host "Step 1: Running migrations..." -ForegroundColor Yellow
php artisan migrate

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Migrations completed successfully!" -ForegroundColor Green
} else {
    Write-Host "✗ Migration failed. Please check the error above." -ForegroundColor Red
    exit 1
}

Write-Host ""

# Step 2: Seed return reasons
Write-Host "Step 2: Seeding predefined return reasons..." -ForegroundColor Yellow
php artisan db:seed --class=ReturnReasonSeeder

if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Return reasons seeded successfully!" -ForegroundColor Green
} else {
    Write-Host "✗ Seeding failed. Please check the error above." -ForegroundColor Red
    exit 1
}

Write-Host ""
Write-Host "================================" -ForegroundColor Cyan
Write-Host "Setup Complete!" -ForegroundColor Green
Write-Host "================================" -ForegroundColor Cyan
Write-Host ""
Write-Host "Next steps:" -ForegroundColor Cyan
Write-Host "1. Visit your application and test the return functionality" -ForegroundColor White
Write-Host "2. As a customer, navigate to a delivered order and click 'Return Item'" -ForegroundColor White
Write-Host "3. As an admin, go to Admin Panel → Returns to manage requests" -ForegroundColor White
Write-Host ""
Write-Host "For detailed documentation, see RETURN_SYSTEM_GUIDE.md" -ForegroundColor Cyan
Write-Host ""
