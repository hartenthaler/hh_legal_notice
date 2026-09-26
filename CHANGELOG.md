# Change Log

## Next release

## 2.2.6.10 - 2026-09-26

* Added compatibility with webtrees 2.2 and 2.3 (#158, #159), including container-based `UserService` resolution, the 2.3 translation stream API, and removal of the jQuery dependency from the settings page.
* Decoupled the module from the concrete Core `PrivacyPolicy` implementation by using `AbstractModule` and module-owned privacy-policy and footer behavior (#148).
* Removed the obsolete Google Charts privacy-service option and notice when running on webtrees 2.3; the setting remains available for webtrees 2.2 (#155).
* Added administrator-controlled selection of applicable legal jurisdictions, independent of the physical server location (#151).
* Adopted clearer Core-compatible wording for genealogical data sources, GEDCOM exports, retention, breach notifications, and protection of minors (#152).
* Made privacy-notice provider input tolerant of scalar values as well as the documented list format (#150).
* Clarified in the privacy policy how the current registration agreement notice depends on the Core `SHOW_REGISTER_CAUTION` setting; the module does not claim to store an acceptance record (#143).
* Updated Dutch translations; thanks to TheDutchJewel (#154, #157).

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
