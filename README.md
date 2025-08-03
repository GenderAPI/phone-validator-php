# 📞 Phone Number Validation & Formatter API (PHP SDK)

The `phone-validator-php` library uses the official [GenderAPI Phone Number Validation & Formatter API](https://www.genderapi.io/docs-phone-validation-formatter-api) to validate and format phone numbers from over 240 countries.

Whether your users enter phone numbers in various formats (e.g., `12128675309`, `+1 212 867 5309`, `001-212-867-5309`), this library will intelligently detect, validate, and convert the input into a standardized E.164 format (e.g., `+12128675309`).

---

## ✅ Features

- Converts phone numbers to **E.164** format
- Validates if number is real and structurally possible
- Detects number type: mobile, landline, VoIP, etc.
- Identifies region/city based on area code
- Includes country-level metadata (e.g. ISO code)
- Built with PHP, works with Composer autoloading

---

## 📦 Installation

```bash
composer require genderapi/phone-validator
```

Or manually:

```bash
git clone https://github.com/GenderAPI/phone-validator-php.git
cd phone-validator-php
composer install
```

---

## 🚀 Usage

```php
require_once __DIR__ . '/vendor/autoload.php';

use GenderApi\PhoneValidator;

$validator = new PhoneValidator('YOUR_API_KEY');

$response = $validator->validate('+1 212 867 5309', 'US');

print_r($response);
```

---

## 📝 Input Parameters

```php
validate(string $number, string|null $address = null): array
```

| Parameter | Type   | Required | Description |
|-----------|--------|----------|-------------|
| `number`  | string | ✅ Yes   | Phone number in any format |
| `address` | string | Optional | ISO country code (`US`), full country name (`Turkey`), or city name (`Berlin`) – helps resolve local numbers |

**Example:**

```php
$validator->validate('2128675309', 'US');
```

---

## 📤 API Response

```json
{
  "status": true,
  "remaining_credits": 15709,
  "expires": 0,
  "duration": "18ms",
  "regionCode": "US",
  "countryCode": 1,
  "country": "United States",
  "national": "(212) 867-5309",
  "international": "+1 212-867-5309",
  "e164": "+12128675309",
  "isValid": true,
  "isPossible": true,
  "numberType": "FIXED_LINE_OR_MOBILE",
  "nationalSignificantNumber": "2128675309",
  "rawInput": "+1 212 867 5309",
  "isGeographical": true,
  "areaCode": "212",
  "location": "New York City (Manhattan)"
}
```

---

## 📘 Response Field Reference

| Field                     | Type     | Description |
|--------------------------|----------|-------------|
| `status`                 | Boolean  | Was the request successful |
| `remaining_credits`      | Integer  | Remaining API credits |
| `regionCode`             | String   | ISO 3166-1 alpha-2 code (e.g. `US`) |
| `country`                | String   | Country name |
| `e164`                   | String   | Number formatted to E.164 |
| `isValid`                | Boolean  | Is number valid according to numbering rules |
| `isPossible`             | Boolean  | Is number structurally possible |
| `numberType`             | String   | Number type (`MOBILE`, `FIXED_LINE`, etc.) |
| `areaCode`               | String   | Area code from input |
| `location`               | String   | City/region matched from area code |

---

## 🔢 Number Type Values

| Value                 | Description                          |
|----------------------|--------------------------------------|
| `FIXED_LINE`         | Landline                             |
| `MOBILE`             | Mobile phone                         |
| `FIXED_LINE_OR_MOBILE` | Ambiguous, could be both           |
| `TOLL_FREE`          | e.g. 800 numbers                     |
| `PREMIUM_RATE`       | Expensive premium numbers            |
| `SHARED_COST`        | Cost shared between parties          |
| `VOIP`               | Internet-based phone                 |
| `PERSONAL_NUMBER`    | Forwarding number                    |
| `PAGER`              | Obsolete pager number                |
| `VOICEMAIL`          | Voicemail access                     |
| `UNKNOWN`            | Cannot be determined                 |

---

## ℹ️ More Information

- Supports 240+ countries and territories
- Detects mobile vs. landline automatically
- Great for sign-up forms, CRMs, messaging tools, and more
- More details: [GenderAPI Docs](https://www.genderapi.io/docs-phone-validation-formatter-api)

---

## 📄 License

MIT License © [GenderAPI](https://www.genderapi.io)
