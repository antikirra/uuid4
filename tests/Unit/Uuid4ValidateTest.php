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
});