# Privacy notices supplied by other modules

`hh_legal_notice` can include privacy information supplied by other enabled
webtrees modules. This document describes the current lightweight contract for
module authors.

The contract is read-only. A supplying module reports facts about its own
behavior; `hh_legal_notice` decides how these facts are presented in the
generated privacy policy.

## Why the contract is method-based

A supplying module may be installed and used without `hh_legal_notice`.
Therefore it must not implement an interface that is defined only by
`hh_legal_notice`, as that would create a hard load-time dependency.

For now, a compatible module exposes a public callable method with this
signature:

```php
public function privacyNotices(): array;
```

`hh_legal_notice` discovers enabled modules through webtrees `ModuleService`
and calls the method when `is_callable([$module, 'privacyNotices'])` is true.
A future neutral shared contract is discussed separately in GitHub issue #124.

## Return structure

The method returns an array with either or both of these optional keys:

```php
[
    'third_party_services' => [
        // Service definitions
    ],
    'security_measures' => [
        // Plain-text descriptions
    ],
]
```

Unknown top-level keys are currently ignored. Returning an empty array is
valid.

### `third_party_services`

Each entry describes one external service contacted or embedded by the
supplying module:

| Field | Required | Type | Meaning |
| --- | --- | --- | --- |
| `name` | yes | string | Human-readable service or provider name. |
| `url` | yes | string | Canonical service URL. It also identifies duplicate entries. |
| `country` | no | string | Country in which the service is provided, preferably a core-translatable English country name such as `Germany` or `United States`. |
| `privacy_url` | no | string | URL of the provider's privacy information. |
| `description` | no | string | Plain-text explanation of when and why the module uses the service. |
| `data` | no | list of strings | Plain-text categories of data transmitted or processed. |
| `group` | no | string | Presentation hint. Currently `map` and `transcription` receive specialized presentation; omit it for a general service. |

`name` and `url` must both contain non-whitespace text. Otherwise
`hh_legal_notice` ignores the complete service entry. Empty optional strings and
empty `data` entries are removed or treated as absent.

Services are deduplicated later by `url`, or by `name` if no URL is available.
Supplying a stable canonical HTTPS URL is therefore important.

The `country` value is used to determine whether a service may involve a
third-country transfer when EU data-protection law applies. It should describe
the relevant place of service provision, not the language of the provider's
website.

### `security_measures`

Each entry is a non-empty plain-text description of a technical or
organizational measure implemented by the supplying module. Examples include
encrypted credential storage or local caching that reduces external requests.

Do not report aspirations or generic security claims. Report only measures
that the module actually implements.

## Content rules

The supplying module knows its behavior better than `hh_legal_notice` and is
responsible for reporting it accurately.

- Report a third-party service only when the module can actually use it under
  the current site-wide configuration. If an optional provider is disabled,
  omit it.
- Describe server-side and browser-side transfers accurately. In particular,
  do not claim that a visitor IP address is transferred when only the web
  server contacts the provider.
- List concrete categories such as identifiers, search parameters, uploaded
  media, IP addresses, or technical request metadata.
- Do not include credentials, secrets, personal values, or live request data.
- Return plain text, not HTML. `hh_legal_notice` escapes supplied text for
  output.
- Prefer absolute HTTPS URLs for `url` and `privacy_url`.
- Keep notices concise enough for inclusion in a privacy policy.

The current method has no tree or user parameter. Its result is therefore
site-wide. A module should not report tree-specific or user-specific details
unless they are valid as a general description of the module's enabled
behavior.

## Translation

All user-facing descriptions and data categories should be translated by the
supplying module before they are returned. Use that module's normal
internationalization mechanism:

```php
I18N::translate('The module sends the selected record identifier to the external service.');
```

Provider names, trademarks, identifiers, and URLs normally remain untranslated.
For `country`, prefer a country name that webtrees can translate.

## Complete example

```php
/**
 * Privacy information consumed by hh_legal_notice.
 *
 * @return array{
 *     third_party_services:list<array{
 *         name:string,
 *         url:string,
 *         country:string,
 *         privacy_url:string,
 *         description:string,
 *         data:list<string>,
 *         group?:string
 *     }>,
 *     security_measures:list<string>
 * }
 */
public function privacyNotices(): array
{
    if (!$this->externalProviderEnabled()) {
        return [];
    }

    return [
        'third_party_services' => [
            [
                'name'        => 'Example Authority Service',
                'url'         => 'https://example.org/',
                'country'     => 'Germany',
                'privacy_url' => 'https://example.org/privacy',
                'description' => I18N::translate(
                    'The module retrieves a public description when it is not available in the local cache.'
                ),
                'data'        => [
                    I18N::translate('Public record identifier.'),
                    I18N::translate('The server IP address and technical request metadata.'),
                ],
            ],
        ],
        'security_measures' => [
            I18N::translate(
                'Responses from the external service are cached locally for 24 hours.'
            ),
        ],
    ];
}
```

## Defensive processing

`hh_legal_notice` treats supplying modules as optional:

- only enabled modules are inspected;
- only callable `privacyNotices()` methods are invoked;
- exceptions and other `Throwable` errors from a provider are caught;
- non-array return values are ignored;
- malformed service entries are ignored;
- missing top-level lists are treated as empty.

This prevents one incompatible provider from breaking the generated legal
notice. It does not replace testing by the supplying module. Module authors
should verify their notices with all supported languages and with the relevant
sections of `hh_legal_notice` enabled.

## Compatibility

The current array contract is intentionally small and additive. Supplying
modules should:

- use only documented keys for behavior they rely on;
- tolerate `hh_legal_notice` ignoring unknown optional keys;
- avoid depending on a particular HTML layout or section order;
- keep their module functional when `hh_legal_notice` is absent.

Changes that reinterpret existing fields should be avoided. New optional fields
may be introduced later without invalidating existing suppliers.
