# Guide Rewarding System

This Laravel application tracks tour guides, records their tourist visits and awards points. Guides can redeem points for items or cash. The system sends WhatsApp notifications via Twilio and provides dashboards that display guide activity and performance metrics.

## Installation

1. Install PHP dependencies
   ```bash
   composer install
   ```
2. Install JavaScript dependencies
   ```bash
   npm install
   ```
3. Copy the example environment file and update required variables
   ```bash
   cp .env.example .env
   ```
   Set values for:
   - `TWILIO_SID`
   - `TWILIO_AUTH_TOKEN`
   - `TWILIO_WHATSAPP_FROM`
4. Create the SQLite database and run migrations
   ```bash
   touch database/database.sqlite
   php artisan migrate
   ```

## Local Development

Start the development server, queue worker and Vite with:
```bash
composer dev
```
Alternatively run `php artisan serve` and `npm run dev`.

## Running Tests

Execute the test suite with:
```bash
composer test
```

## License

Released under the [MIT license](LICENSE).
# AGR-System
# AGR-System
