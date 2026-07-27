# Applicable legal jurisdictions

The country in which the webtrees server is located and the law that applies to
the website are related, but they are not identical. The controller, the target
audience, and the activities of the website can cause several legal
jurisdictions to apply at the same time.

`hh_legal_notice` therefore stores these concepts separately:

- **Server location** remains factual information about the hosting location.
- **Applicable legal jurisdictions** determine which regional and national
  variants the module uses in the generated legal notice and privacy policy.

## Selection modes

The default mode is **Infer from the server location**. It preserves the
behavior of earlier module versions while allowing more than one result:

| Configured server location | Automatically selected legal jurisdictions |
| --- | --- |
| Germany | European Union / European Economic Area (GDPR); Germany (national law) |
| Austria | European Union / European Economic Area (GDPR); Austria (national law) |
| Another EU/EEA country | European Union / European Economic Area (GDPR) |
| Switzerland | Switzerland (national law) |
| Another or unknown country | No module-specific jurisdiction |

In **Select manually** mode, the administrator can independently select any
combination of the supported jurisdictions:

- European Union / European Economic Area (GDPR)
- Germany (national law)
- Austria (national law)
- Switzerland (national law)

The settings page displays a warning whenever manual mode is selected. The
administrator is responsible for selecting every applicable jurisdiction. An
empty manual selection is permitted and produces the neutral variants without
module-specific regional references.

## Effects

The effective selection controls:

- GDPR-specific privacy-policy wording and legal bases;
- German national data-protection and media-law references;
- German, Austrian, and Swiss national legal-notice references;
- whether services outside the EEA are identified as possible third-country
  transfers.

The hosting country continues to be shown as the physical server location. It
does not override a manual legal-jurisdiction selection. Copyright wording no
longer claims that the hosting country alone determines the applicable
copyright law.

## Compatibility

Existing installations start in automatic mode because no override preference
exists. Their effective regional wording therefore remains based on the saved
server location until an administrator explicitly selects manual mode.

The implementation follows the configurable-jurisdiction concept introduced by
the [future webtrees Core privacy-policy work](https://github.com/fisharebest/webtrees/commit/4e6ccdb0a9ff794cb0e9c032b219944d0da2d2de),
but keeps EU/EEA law and the supported national jurisdictions as separate,
combinable choices.
