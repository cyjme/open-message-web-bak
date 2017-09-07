import {z} from '../z.js';

test('z.version should be 0.1.0', () => {
    expect(z.version)
        .toEqual(
            expect.stringMatching(
                /\d{1,3}\.\d{1,3}\.\d{1,3}/u
            )
        );
});

test('z.generateUuid', () => {
    expect(z.generateUuid()).toEqual(expect.stringMatching(/(\d{13})-(\d{1,3})/u));
});

test('z.type', () => {
    expect(z.type('string')).toBe('string');
    expect(z.type([])).toBe('array');
    expect(z.type({})).toBe('object');
});
