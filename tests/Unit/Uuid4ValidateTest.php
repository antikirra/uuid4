<?php

use function Antikirra\uuid4;
use function Antikirra\uuid4_validate;

describe('uuid4_validate()', function () {
    it('validates a correct UUID v4', function () {
        $uuid = uuid4();

        expect(uuid4_validate($uuid))->toBeTrue();
    });

    it('accepts valid UUID v4 with lowercase letters', function () {
        $uuid = '550e8400-e29b-41d4-a716-446655440000';

        expect(uuid4_validate($uuid))->toBeTrue();
    });

    it('accepts valid UUID v4 with uppercase letters', function () {
        $uuid = '550E8400-E29B-41D4-A716-446655440000';

        expect(uuid4_validate($uuid))->toBeTrue();
    });

    it('accepts valid UUID v4 with mixed case', function () {
        $uuid = '550e8400-E29B-41d4-A716-446655440000';

        expect(uuid4_validate($uuid))->toBeTrue();
    });

    it('rejects UUID without hyphens', function () {
        $uuid = '550e8400e29b41d4a716446655440000';

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects UUID with incorrect version', function () {
        $uuid = '550e8400-e29b-31d4-a716-446655440000'; // version 3 instead of 4

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects UUID with incorrect variant', function () {
        $uuid = '550e8400-e29b-41d4-c716-446655440000'; // variant 'c' instead of 8/9/a/b

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects string with invalid characters', function () {
        $uuid = '550e8400-e29b-41d4-a716-44665544000g'; // 'g' is not valid hex

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects string that is too short', function () {
        $uuid = '550e8400-e29b-41d4-a716-4466554400';

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects string that is too long', function () {
        $uuid = '550e8400-e29b-41d4-a716-446655440000-extra';

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('rejects empty string', function () {
        expect(uuid4_validate(''))->toBeFalse();
    });

    it('rejects UUID with wrong hyphen positions', function () {
        $uuid = '550e84-00e29b-41d4a-716446-655440000';

        expect(uuid4_validate($uuid))->toBeFalse();
    });

    it('throws InvalidArgumentException for non-string input (integer)', function () {
        expect(fn() => uuid4_validate(123))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got integer');
    });

    it('throws InvalidArgumentException for non-string input (array)', function () {
        expect(fn() => uuid4_validate([]))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got array');
    });

    it('throws InvalidArgumentException for non-string input (null)', function () {
        expect(fn() => uuid4_validate(null))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got NULL');
    });

    it('throws InvalidArgumentException for non-string input (boolean)', function () {
        expect(fn() => uuid4_validate(true))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got boolean');
    });

    it('validates all variants (8, 9, a, b)', function () {
        $variants = ['8', '9', 'a', 'b'];

        foreach ($variants as $variant) {
            $uuid = "550e8400-e29b-41d4-{$variant}716-446655440000";
            expect(uuid4_validate($uuid))->toBeTrue();
        }
    });

    it('rejects invalid variants (0-7, c-f)', function () {
        $invalidVariants = ['0', '1', '2', '3', '4', '5', '6', '7', 'c', 'd', 'e', 'f'];

        foreach ($invalidVariants as $variant) {
            $uuid = "550e8400-e29b-41d4-{$variant}716-446655440000";
            expect(uuid4_validate($uuid))->toBeFalse();
        }
    });

    // Edge cases: whitespace and special characters
    it('rejects UUID with leading whitespace', function () {
        expect(uuid4_validate(' 550e8400-e29b-41d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with trailing whitespace', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a716-446655440000 '))->toBeFalse();
    });

    it('rejects UUID with internal whitespace', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a716 -446655440000'))->toBeFalse();
    });

    it('rejects UUID with newline character', function () {
        expect(uuid4_validate("550e8400-e29b-41d4-a716-446655440000\n"))->toBeFalse();
    });

    it('rejects UUID with tab character', function () {
        expect(uuid4_validate("550e8400-e29b-41d4-a716-446655440000\t"))->toBeFalse();
    });

    // Edge cases: all zeros and all Fs
    it('accepts UUID with all zeros (except version and variant)', function () {
        expect(uuid4_validate('00000000-0000-4000-8000-000000000000'))->toBeTrue();
    });

    it('accepts UUID with all Fs (except version and variant)', function () {
        expect(uuid4_validate('ffffffff-ffff-4fff-bfff-ffffffffffff'))->toBeTrue();
    });

    // Edge cases: boundary values for version field
    it('rejects UUID with version 0', function () {
        expect(uuid4_validate('550e8400-e29b-01d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with version 1', function () {
        expect(uuid4_validate('550e8400-e29b-11d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with version 2', function () {
        expect(uuid4_validate('550e8400-e29b-21d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with version 5', function () {
        expect(uuid4_validate('550e8400-e29b-51d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with version f', function () {
        expect(uuid4_validate('550e8400-e29b-f1d4-a716-446655440000'))->toBeFalse();
    });

    // Edge cases: hyphen variations
    it('rejects UUID with underscores instead of hyphens', function () {
        expect(uuid4_validate('550e8400_e29b_41d4_a716_446655440000'))->toBeFalse();
    });

    it('rejects UUID with no separators', function () {
        expect(uuid4_validate('550e8400e29b41d4a716446655440000'))->toBeFalse();
    });

    it('rejects UUID with spaces instead of hyphens', function () {
        expect(uuid4_validate('550e8400 e29b 41d4 a716 446655440000'))->toBeFalse();
    });

    it('rejects UUID with curly braces', function () {
        expect(uuid4_validate('{550e8400-e29b-41d4-a716-446655440000}'))->toBeFalse();
    });

    it('rejects UUID with URN prefix', function () {
        expect(uuid4_validate('urn:uuid:550e8400-e29b-41d4-a716-446655440000'))->toBeFalse();
    });

    // Edge cases: object inputs
    it('throws InvalidArgumentException for object input', function () {
        $obj = new \stdClass();
        expect(fn() => uuid4_validate($obj))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got object');
    });

    it('throws InvalidArgumentException for float input', function () {
        expect(fn() => uuid4_validate(3.14))
            ->toThrow(InvalidArgumentException::class, 'UUID must be a string, got double');
    });

    // Edge cases: Unicode and special characters
    it('rejects UUID with unicode characters', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a716-44665544000ф'))->toBeFalse();
    });

    it('rejects UUID with emoji', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a716-44665544000😀'))->toBeFalse();
    });

    // Edge cases: case sensitivity for variant
    it('accepts variant with uppercase letters', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-A716-446655440000'))->toBeTrue();
        expect(uuid4_validate('550e8400-e29b-41d4-B716-446655440000'))->toBeTrue();
    });

    // Edge cases: segment length violations
    it('rejects UUID with incorrect first segment length', function () {
        expect(uuid4_validate('550e840-e29b-41d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with incorrect second segment length', function () {
        expect(uuid4_validate('550e8400-e29-41d4-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with incorrect third segment length', function () {
        expect(uuid4_validate('550e8400-e29b-41d-a716-446655440000'))->toBeFalse();
    });

    it('rejects UUID with incorrect fourth segment length', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a71-446655440000'))->toBeFalse();
    });

    it('rejects UUID with incorrect fifth segment length', function () {
        expect(uuid4_validate('550e8400-e29b-41d4-a716-44665544000'))->toBeFalse();
    });

    // Edge cases: resource type (PHP < 8.0 compatibility)
    it('throws InvalidArgumentException for resource input', function () {
        $resource = fopen('php://memory', 'r');
        try {
            expect(fn() => uuid4_validate($resource))
                ->toThrow(InvalidArgumentException::class);
        } finally {
            fclose($resource);
        }
    });
});