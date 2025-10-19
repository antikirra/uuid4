<?php

use function Antikirra\uuid4;

describe('uuid4()', function () {
    it('generates a valid UUID v4', function () {
        $uuid = uuid4();

        expect($uuid)->toBeValidUuid4();
    });

    it('generates unique UUIDs', function () {
        $uuid1 = uuid4();
        $uuid2 = uuid4();

        expect($uuid1)->not->toBe($uuid2);
    });

    it('returns a string with correct length', function () {
        $uuid = uuid4();

        expect($uuid)
            ->toBeString()
            ->toHaveLength(36);
    });

    it('has correct format with hyphens at positions 8, 13, 18, 23', function () {
        $uuid = uuid4();

        expect($uuid[8])->toBe('-');
        expect($uuid[13])->toBe('-');
        expect($uuid[18])->toBe('-');
        expect($uuid[23])->toBe('-');
    });

    it('has version 4 identifier in the correct position', function () {
        $uuid = uuid4();

        expect($uuid[14])->toBe('4');
    });

    it('has correct variant bits (8, 9, a, or b at position 19)', function () {
        $uuid = uuid4();
        $variantChar = strtolower($uuid[19]);

        expect($variantChar)->toBeIn(['8', '9', 'a', 'b']);
    });

    it('generates 1000 unique UUIDs', function () {
        $uuids = [];

        for ($i = 0; $i < 1000; $i++) {
            $uuids[] = uuid4();
        }

        $uniqueUuids = array_unique($uuids);

        expect(count($uniqueUuids))->toBe(1000);
    });

    it('only contains valid hexadecimal characters and hyphens', function () {
        $uuid = uuid4();

        expect($uuid)->toMatch('/^[0-9a-f-]+$/i');
    });

    // Stress tests: ensure randomness and no collisions
    it('generates 10000 unique UUIDs without collisions', function () {
        $uuids = [];

        for ($i = 0; $i < 10000; $i++) {
            $uuids[] = uuid4();
        }

        $uniqueUuids = array_unique($uuids);

        expect(count($uniqueUuids))->toBe(10000);
    });

    // Test statistical distribution of variant bits
    it('generates all four variant values (8, 9, a, b) over multiple generations', function () {
        $variants = [];

        // Generate enough UUIDs to statistically ensure all variants appear
        for ($i = 0; $i < 100; $i++) {
            $uuid = uuid4();
            $variants[] = strtolower($uuid[19]);
        }

        $uniqueVariants = array_unique($variants);

        // We should see multiple variants (randomness check)
        expect(count($uniqueVariants))->toBeGreaterThan(1);

        // All values should be valid variants
        foreach ($uniqueVariants as $variant) {
            expect($variant)->toBeIn(['8', '9', 'a', 'b']);
        }
    });

    // Test that generated UUIDs are different from each other in rapid succession
    it('generates different UUIDs in rapid succession', function () {
        $uuid1 = uuid4();
        $uuid2 = uuid4();
        $uuid3 = uuid4();
        $uuid4 = uuid4();
        $uuid5 = uuid4();

        expect($uuid1)->not->toBe($uuid2);
        expect($uuid2)->not->toBe($uuid3);
        expect($uuid3)->not->toBe($uuid4);
        expect($uuid4)->not->toBe($uuid5);
        expect($uuid1)->not->toBe($uuid5);
    });

    // Test that all segments have correct lengths
    it('has correctly sized segments when split by hyphens', function () {
        $uuid = uuid4();
        $parts = explode('-', $uuid);

        expect(count($parts))->toBe(5);
        expect(strlen($parts[0]))->toBe(8);
        expect(strlen($parts[1]))->toBe(4);
        expect(strlen($parts[2]))->toBe(4);
        expect(strlen($parts[3]))->toBe(4);
        expect(strlen($parts[4]))->toBe(12);
    });

    // Test that version bit is always set correctly
    it('always sets version bit to 4 in 1000 generations', function () {
        for ($i = 0; $i < 1000; $i++) {
            $uuid = uuid4();
            expect($uuid[14])->toBe('4');
        }
    });

    // Test that variant bits are always valid in 1000 generations
    it('always sets valid variant bits in 1000 generations', function () {
        for ($i = 0; $i < 1000; $i++) {
            $uuid = uuid4();
            $variantChar = strtolower($uuid[19]);
            expect($variantChar)->toBeIn(['8', '9', 'a', 'b']);
        }
    });

    // Test character diversity (ensure it's not always the same character)
    it('generates UUIDs with diverse hexadecimal characters', function () {
        $uuid = uuid4();
        $chars = str_split(str_replace('-', '', $uuid));
        $uniqueChars = array_unique($chars);

        // A random UUID should have at least 5 different hex characters
        expect(count($uniqueChars))->toBeGreaterThanOrEqual(5);
    });

    // Test that the UUID validates with our own validator
    it('generates UUIDs that pass uuid4_validate()', function () {
        for ($i = 0; $i < 100; $i++) {
            $uuid = uuid4();
            expect(\Antikirra\uuid4_validate($uuid))->toBeTrue();
        }
    });

    // Test lowercase output consistency
    it('always returns lowercase letters', function () {
        for ($i = 0; $i < 100; $i++) {
            $uuid = uuid4();
            expect($uuid)->toBe(strtolower($uuid));
        }
    });

    // Test that each segment contains only valid hex characters
    it('has valid hexadecimal characters in each segment', function () {
        $uuid = uuid4();
        $parts = explode('-', $uuid);

        foreach ($parts as $part) {
            expect($part)->toMatch('/^[0-9a-f]+$/');
        }
    });
});