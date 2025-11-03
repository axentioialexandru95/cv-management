# Laravel Cloud Deployment Guide

This guide covers deploying the CV Maker application to Laravel Cloud with PDF generation support.

## Prerequisites

The application requires the following for PDF generation:
- **Node.js** (v18 or higher)
- **Puppeteer** (automatically installed with spatie/laravel-pdf)
- **Chrome/Chromium** browser

## Verifying Browsershot Dependencies on Laravel Cloud

### Step 1: Check Node.js Availability

SSH into your Laravel Cloud environment and run:

```bash
which node
node --version
```

If Node.js is not installed, you'll need to add it to your build process (see Step 3).

### Step 2: Check Puppeteer/Chrome

```bash
# Check if Puppeteer's Chrome is installed
ls -la node_modules/puppeteer/.local-chromium/

# Or check for system Chrome
which google-chrome
which chromium-browser
```

### Step 3: Configure Build Scripts

Laravel Cloud supports build scripts. Create or update your `.laravel-cloud/deploy.yml` file:

```yaml
build:
  - name: Install Node.js dependencies
    run: |
      # Puppeteer will be installed automatically with npm install
      npm ci --production=false

  - name: Install Chromium dependencies
    run: |
      # Install required system libraries for Puppeteer
      apt-get update
      apt-get install -y \
        chromium \
        chromium-driver \
        fonts-liberation \
        libasound2 \
        libatk-bridge2.0-0 \
        libatk1.0-0 \
        libcairo2 \
        libcups2 \
        libdbus-1-3 \
        libgdk-pixbuf2.0-0 \
        libglib2.0-0 \
        libgtk-3-0 \
        libnspr4 \
        libnss3 \
        libpango-1.0-0 \
        libx11-6 \
        libx11-xcb1 \
        libxcb1 \
        libxcomposite1 \
        libxcursor1 \
        libxdamage1 \
        libxext6 \
        libxfixes3 \
        libxi6 \
        libxrandr2 \
        libxrender1 \
        libxss1 \
        libxtst6 \
        xdg-utils
```

**Note**: Check Laravel Cloud's documentation for the correct build script location and syntax, as it may differ.

## Environment Variables

Add these to your Laravel Cloud environment variables:

```env
# Optional: Specify Node.js path if not in default location
NODE_BINARY_PATH=/usr/bin/node
NPM_BINARY_PATH=/usr/bin/npm

# Optional: Specify Chrome path if using system Chrome
CHROME_BINARY_PATH=/usr/bin/chromium-browser

# Optional: Increase timeout for PDF generation
BROWSERSHOT_TIMEOUT=120
```

## Testing PDF Generation

After deployment, test PDF generation:

### Option 1: Use Tinker (via SSH)

```bash
php artisan tinker
```

```php
use App\Models\CV;
use Spatie\LaravelPdf\Facades\Pdf;

$cv = CV::first();
$cv->load(['workExperiences', 'educationEntries', 'languages', 'skills']);

// Test PDF generation
$pdf = Pdf::view('cv.templates.modern', ['cv' => $cv])
    ->format('a4')
    ->margins(15, 15, 15, 15);

// This will throw an error if Node.js or Chrome is missing
$pdf->inline();
```

### Option 2: Test via Browser

1. Create a test CV in the admin panel
2. Try to preview or download the PDF
3. Check Laravel Cloud logs for any errors:

```bash
php artisan pail
# or
tail -f storage/logs/laravel.log
```

## Common Issues

### Issue 1: "node: command not found"

**Solution**: Node.js is not installed or not in PATH.
- Add Node.js installation to your build script
- Or set `NODE_BINARY_PATH` environment variable

### Issue 2: "Error: Failed to launch the browser process"

**Solution**: Chrome/Chromium or its dependencies are missing.
- Install Chromium and its dependencies via build script
- Or set `CHROME_BINARY_PATH` to system Chrome

### Issue 3: "Error: EACCES: permission denied"

**Solution**: Puppeteer doesn't have write permissions.
- Ensure `/tmp` directory is writable
- Or set custom Puppeteer cache directory:

```env
PUPPETEER_CACHE_DIR=/var/www/html/storage/puppeteer
```

### Issue 4: Timeout errors

**Solution**: PDF generation is taking too long.
- Increase `BROWSERSHOT_TIMEOUT` in `.env`
- Optimize CV templates (remove heavy images, reduce complexity)

## Alternative: Use Laravel Cloud's Built-in Features

**Check with Laravel Cloud support** if they offer:
- Pre-installed Node.js and Chrome
- Managed Puppeteer service
- Alternative PDF generation services

## Debugging Commands

Run these on Laravel Cloud to diagnose issues:

```bash
# Check Node.js
which node && node --version

# Check npm
which npm && npm --version

# Check Chrome
which google-chrome chromium-browser chromium

# Check Puppeteer installation
ls -la node_modules/puppeteer/

# Test Chrome launch
node -e "const puppeteer = require('puppeteer'); puppeteer.launch().then(browser => { console.log('Success!'); browser.close(); });"

# Check file permissions
ls -la /tmp/
```

## Production Optimization

Once working, optimize for production:

1. **Cache Puppeteer**: Set `PUPPETEER_CACHE_DIR` to persist browser downloads
2. **Increase timeout**: Set `BROWSERSHOT_TIMEOUT=120` for complex CVs
3. **Queue PDF generation**: Consider queuing PDF generation for better UX
4. **Monitor logs**: Watch for PDF generation errors in production

## Need Help?

If you're still having issues:

1. Check Laravel Cloud documentation for Node.js/Puppeteer support
2. Contact Laravel Cloud support (they may have specific guides)
3. Consider alternative PDF libraries if Browsershot proves problematic:
   - `barryvdh/laravel-dompdf` (simpler, no browser required)
   - `spatie/browsershot` with external service (like Gotenberg)

## Current Implementation

The application automatically detects the environment:

- **Local (Herd)**: Uses symlinked Node.js from Herd
- **Production (Laravel Cloud)**: Searches common paths (`/usr/bin/node`, `/usr/local/bin/node`, `which node`)

See `app/Http/Controllers/CVController.php` and `PublicCVController.php` for implementation details.
