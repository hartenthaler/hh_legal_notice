# Change Log

## Next release

* Updated Dutch translations; thanks to TheDutchJewel.
* Fixed a runtime error when another module supplies a single data category, security measure, or third-party service instead of a list in `privacyNotices()`.
* Added an administrator-controlled multi-select for applicable legal jurisdictions, with the server location retained as the automatic default and a warning whenever that default is overridden.
* Decoupled regional legal wording, national legal-notice references, and EU/EEA third-country-transfer checks from the factual server location.

## 2.2.6.9 - 2026-07-15

* Consolidated duplicate third-party service reports while retaining every supplying module, its specific usage, data categories, and differing provider details.
* Added stable service identifiers to the privacy-notice contract, with URL-based compatibility matching and a shared Wikimedia Foundation entry for Wikidata, Wikipedia, and Wikimedia Commons.
* Reordered third-party service details into webtrees core services, map providers, external transcription providers, and additional services, followed by third-country transfers.
* Clarified that hh_legal_notice itself may use Gravatar to display an optional representative image.
* Moved the data-export and version-check sections directly before hosting and shortened the version-check explanation.
* Fixed detection of hh-family-trees-list so its configured per-tree research purposes are shown in the module settings.
* Improved the German wording for the webtrees administration menu in the version-check information.

## 2.2.6.8 - 2026-07-14

* Added an optional summary of per-tree research purposes supplied by hh-family-trees-list to the module settings.
* Updated Dutch translations; thanks to TheDutchJewel.

## 2.2.6.7 - 2026-07-10

* Added a privacy-policy section explaining that exported data is no longer protected by the technical protection mechanisms of webtrees.
* Documented GEDCOM exports, reports, and screenshots as ways data can leave webtrees.
* Updated the German translation for the new data-export wording.
