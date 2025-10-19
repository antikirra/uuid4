# UUID4 | Fast RFC 4122 UUIDv4 Generator

![Packagist Dependency Version](https://img.shields.io/packagist/dependency-v/antikirra/uuid4/php)
![Packagist Version](https://img.shields.io/packagist/v/antikirra/uuid4)

**Ultra-fast, lightweight PHP library for generating and validating RFC 4122 compliant UUIDv4 identifiers.** Perfect for distributed systems, database primary keys, and scenarios requiring cryptographically secure universally unique identifiers without external dependencies.

## Install

```console
composer require antikirra/uuid4:^3.0
```

## Why UUID4?

- ✨ **Blazing Fast Performance** - Optimized implementation with minimal overhead
- 🔧 **Universal Compatibility** - Works seamlessly from PHP 5.6 to PHP 8.4+
- 🔒 **Cryptographically Secure** - Uses secure random number generation (random_bytes)
- 📜 **RFC 4122 Compliant** - Strictly follows official UUID version 4 specification
- 📦 **Lightweight** - Pure PHP implementation with minimal dependencies
- ✅ **Built-in Validation** - Comprehensive UUID format and variant validation
- 🚀 **Production Ready** - Battle-tested with comprehensive test coverage
- 🧪 **Fully Tested** - 100% code coverage with PHPUnit/Pest test suite

## Features

- **RFC 4122 Compliant Generation**: Creates properly formatted UUIDv4 with correct version (4) and variant bits (8, 9, a, b)
- **Cryptographic Security**: Leverages PHP's `random_bytes()` for cryptographically secure randomness
- **Strict Validation**: Validates UUID format, version, variant, and character set
- **Case-Insensitive**: Accepts both uppercase and lowercase UUID strings
- **Type Safety**: Throws exceptions for invalid input types with clear error messages
- **Legacy Support**: Compatible with ancient PHP versions (5.6+) through modern PHP 8.4
- **Zero Configuration**: Works out of the box, no setup required
- **Memory Efficient**: Minimal memory footprint, perfect for high-load applications

## Perfect for

- **Database Primary Keys**: Alternative to auto-increment IDs in distributed databases
- **Distributed Systems**: Unique ID generation across multiple servers without coordination
- **API Development**: Request IDs, transaction tracking, resource identifiers
- **Microservices**: Service-independent unique identifiers
- **Event Sourcing**: Event IDs, aggregate identifiers
- **File Systems**: Unique file names, temporary file generation
- **Session Management**: Session tokens, correlation IDs
- **Legacy Systems**: Drop-in UUID solution for old PHP applications

## Requirements

- **PHP**: 5.6 or higher (tested up to PHP 8.4)
- **Extensions**: None (uses only core PHP functions)
- **Dependencies**:
  - `antikirra/random-bytes` for PHP < 7.0 (provides `random_bytes()` polyfill)
  - Zero dependencies for PHP 7.0+

## Basic usage

```php
<?php

use function Antikirra\uuid4;
use function Antikirra\uuid4_validate;

require __DIR__ . '/vendor/autoload.php';

// Generate a new UUID v4
echo uuid4(); // 19f16271-84eb-449c-d22b-0bbf7fcc1f63

// Validate UUID format
uuid4_validate('74331057-8c1a-40f0-1e6f-a3073c3f56fc'); // true
uuid4_validate('not-a-valid-uuid'); // false
uuid4_validate('550e8400-e29b-31d4-a716-446655440000'); // false (version 3, not 4)

// Type safety
try {
    uuid4_validate(123);
} catch (InvalidArgumentException $e) {
    echo $e->getMessage(); // UUID must be a string, got integer
}
```

## Testing

This library is thoroughly tested with comprehensive test coverage:

- **UUID Generation**: Validates format, version bits, variant bits, and randomness
- **UUID Validation**: Tests valid/invalid formats, version detection, variant validation
- **Edge Cases**: Handles uppercase/lowercase, malformed UUIDs, type errors
- **PHP Compatibility**: Tested across PHP 5.6 through PHP 8.4

## Performance

Blazing fast performance benchmarks on Apple M4 with PHP 8.4:

| Operation | Speed | Details |
|-----------|-------|---------|
| **UUID Generation** | 1,626,197 ops/sec | 100,000 iterations in 0.0615 seconds |
| **UUID Validation** | 8,338,825 ops/sec | 1,000,000 iterations in 0.1199 seconds |

*Run `php benchmark.php` to test performance on your own system.*

## Keywords

uuid4, uuid-generator, rfc4122, unique-identifier, php-uuid, cryptographically-secure, distributed-systems, php-5.6-compatible, zero-dependencies, lightweight-library, database-primary-keys, microservices
