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
});