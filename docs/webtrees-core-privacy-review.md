# Review of the rewritten webtrees Core privacy policy

This document records which statements and jurisdiction groupings introduced by
webtrees Core commit
[`4e6ccdb0`](https://github.com/fisharebest/webtrees/commit/4e6ccdb0a9ff794cb0e9c032b219944d0da2d2de)
are intentionally not adopted by `hh_legal_notice` at present.

The Core implementation is designed as a short, generic privacy page. This
module provides more detailed, configuration-dependent information. A Core
statement is therefore not copied when it would be less precise, cannot be
verified from the actual webtrees configuration, or would imply legal coverage
that the module does not provide.

## Current jurisdiction scope

`hh_legal_notice` currently supports separate, combinable selections for:

- European Union / European Economic Area data-protection law;
- German national law;
- Austrian national law; and
- Swiss national law.

An installation may also use the neutral output without selecting a
module-specific jurisdiction. This neutral output is not a claim that one
global or residual legal regime applies.

The following Core groupings are not adopted:

- **Germany / Austria**: the two countries share the GDPR context but have
  different national provider-identification and data-protection rules.
- **European Union / EEA / United Kingdom**: the United Kingdom is not part of
  the EU or EEA and applies the UK GDPR and the Data Protection Act 2018.
- **United States and groups of US states**: there is no single general privacy
  regime that can safely be represented by the same generic statements. State
  laws also have applicability thresholds and defined terms.
- **Australia / New Zealand**, **Latin America / Israel**, **Philippines /
  several African countries**, and **Middle East / Southeast Asia**: these
  groups combine distinct national laws and should not be treated as one legal
  jurisdiction.
- **Canada, Brazil, Japan, South Korea, India, China, Singapore, Thailand,
  South Africa, Russia, Saudi Arabia, and other individual Core choices**:
  support would require a separate review of the applicable national law,
  thresholds, terminology, data-subject rights, regulator information, and
  localisation or transfer requirements.

## Statements not adopted

### Generic legitimate-interest basis

The Core statement presents legitimate interest in historical and genealogical
research as the general lawful basis. This module instead distinguishes the
actual processing operation and, where EU/EEA law is selected, describes
legitimate interests, contractual or pre-contractual relationships, consent,
legal obligations, special-category data, and criminal-offence data separately.

### Limitations based on publicly accessible sources

The Core statement links limitations of erasure, objection, and restriction to
historical research **or** data obtained from publicly accessible sources.
Public availability alone is not treated by this module as a general exception
to data-subject rights. The module describes the research exception and its
conditions separately and states that deletion requests are reviewed
individually.

### Unqualified statement that data is not sold or shared

The words “sell” and “share” can have specific statutory meanings, particularly
under California law. The module cannot infer from webtrees configuration alone
whether an operator can truthfully make this statement or whether a statutory
opt-out mechanism is required. The statement is therefore not generated.

### Unqualified statement about children

The module cannot determine whether an installation collects data directly from
children and therefore does not make that Core assertion. The administrator can
configure an age threshold for additional protection in `hh_legal_notice`.
The active setting is described only when the value is greater than zero.
`hh_privacy_assistant` is responsible for reading that setting and applying the
corresponding `RESN CONFIDENTIAL` restrictions.

### Indefinite retention

The Core statement says that genealogical data is retained indefinitely. This
module uses the more cautious and accurate description “for the long term”,
explains the historical-preservation purpose, treats deletion requests
individually, and keeps genealogical data separate from configurable inactive
user-account retention.

### Generic international-transfer assurance

The Core text states generally that appropriate safeguards are used for
international transfers. This module reports actual detected or configured
third-party services and their countries. Where EU/EEA law is selected, it
describes possible third-country transfers and the safeguards permitted by
Articles 44 to 49 GDPR. It does not promise safeguards that cannot be verified.

### Universal cookie-consent conclusion

The Core text states that essential cookies do not require consent. This module
describes the cookies and services actually detected, distinguishes session and
persistent cookies, and adds jurisdiction-specific wording where supported. It
does not use one consent conclusion for every country.

### Free-form custom statement

The Core module permits an administrator to add an arbitrary custom statement.
Such text cannot be supplied consistently in every language offered by this
module and would bypass its gettext translation workflow. A free-form statement
is therefore not provided.

## Statements adopted in adapted form

The following ideas are useful independently of the rejected jurisdiction
matrix and are included using configuration-aware wording:

- typical sources of genealogical data and indirect collection;
- GEDCOM as a structured, machine-readable export format where an export is
  appropriate and legally permissible;
- a clearer distinction between long-term genealogical retention and the
  lifecycle of user accounts;
- a configuration-dependent statement about additional protection of minors;
  and
- notification of personal data breaches, with GDPR-specific thresholds when
  EU/EEA law is selected and neutral wording otherwise.
