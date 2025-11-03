# Laravel Cloud Setup for PDF Generation

## Quick Setup Guide

Follow these steps to enable PDF generation on Laravel Cloud.

### Step 1: Deploy the Configuration

The `.laravel-cloud/deploy.yml` file is already included in this repository and will be automatically detected by Laravel Cloud.

When you push your code, Laravel Cloud will:
1. Detect the `.laravel-cloud/deploy.yml` file
2. Install Chromium and all required dependencies
3. Verify the installation
4. Set up environment variables for Puppeteer

Just commit and push:

```bash
git add .
git commit -m "Add Laravel Cloud PDF generation configuration"
git push
```

That's it! Laravel Cloud handles the rest automatically.

### Step 2: Add Environment Variables

In your Laravel Cloud project's environment variables, add:

```env
CHROME_BINARY_PATH=/usr/bin/chromium
PUPPETEER_EXECUTABLE_PATH=/usr/bin/chromium
PUPPETEER_SKIP_CHROMIUM_DOWNLOAD=true
BROWSERSHOT_TIMEOUT=120
```

**How to add (Laravel Cloud Dashboard):**
1. Go to your project → Environment
2. Add each variable with its value
3. Save and redeploy

### Step 3: Deploy Your Code

Commit and push all changes:

```bash
git add .
git commit -m "Add Browsershot configuration for PDF generation"
git push
```

Laravel Cloud will automatically deploy and run the build script.

### Step 4: Test PDF Generation

After deployment, test that PDFs work:

1. Log into your admin panel at `https://your-app.com/admin`
2. Create or edit a CV
3. Try to preview or download the PDF
4. Check that the PDF generates successfully

### Step 5: Verify Installation (Optional)

SSH into your Laravel Cloud instance and verify:

```bash
# Check Chromium is installed
which chromium

# Should output: /usr/bin/chromium

# Check Node.js
node --version

# Test Chromium launch
chromium --version
```

## Troubleshooting

### "chromium: error while loading shared libraries"

**Solution:** The build script didn't install all dependencies. Re-run the build or add missing libraries.

### "Chrome failed to start"

**Solution:** Add `--no-sandbox` argument. Update environment:

```env
BROWSERSHOT_ADDITIONAL_OPTIONS=--no-sandbox,--disable-gpu
```

### Build script not running

**Solution:** Laravel Cloud might not support `.laravel-cloud/build.sh`. Use the dashboard's build hooks instead (Option A above).

### Still getting errors?

**Contact Laravel Cloud Support:**
- Mention you need Chromium for Puppeteer/Browsershot
- Ask if they have a pre-configured environment for PDF generation
- They may have specific documentation or packages

## Alternative Solutions

If Browsershot continues to cause issues:

### Option 1: Use DomPDF (Simpler, No Browser Required)

```bash
composer require barryvdh/laravel-dompdf
```

Update controllers to use DomPDF instead of Spatie PDF.

### Option 2: Use External Service (Gotenberg)

Consider using a headless Chrome service like Gotenberg that runs separately.

## Notes

- The build script installs ~100MB of dependencies
- PDF generation may take 5-15 seconds per CV
- Consider queuing PDF generation for better UX
- Monitor Laravel Cloud logs during first PDF generation attempt

## Files Included

This setup includes:

- ✅ `app/Http/Controllers/CVController.php` - Auto-detects Node.js and Chrome paths
- ✅ `app/Http/Controllers/PublicCVController.php` - Auto-detects Node.js and Chrome paths
- ✅ `config/browsershot.php` - Configuration file for custom paths
- ✅ `.laravel-cloud/deploy.yml` - **Automatic build configuration**
- ✅ `.laravel-cloud/environment` - Environment variables template

## Success Indicators

After successful setup, you should see:

1. ✅ Build script runs without errors
2. ✅ Chromium installed at `/usr/bin/chromium`
3. ✅ PDFs generate successfully in admin panel
4. ✅ Public CV PDFs download correctly
5. ✅ No "Chrome failed to start" errors in logs

---

**Need help?** Check Laravel Cloud's documentation or contact their support team. They're very responsive!
